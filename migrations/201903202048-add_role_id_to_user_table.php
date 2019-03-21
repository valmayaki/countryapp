<?php

class CreateAddRoleIdToUsersTableMigration
{
    public function up()
    {
        return "ALTER TABLE users
            ADD COLUMN role_id mediumint(9) AFTER email,
            ADD FOREIGN KEY user_role_id(role_id)
                REFERENCES roles(id)
                ON UPDATE CASCADE ON DELETE RESTRICT
        ;";
    }

    public function down()
    {
        return "ALTER TABLE users
            DROP FOREIGN KEY user_role_id,
            DROP COLUMN role_id
        ;";
    }
}