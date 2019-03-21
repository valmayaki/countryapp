<?php

class CreateRolePermissionTableMigration
{
    public function up()
    {
        return "CREATE TABLE IF NOT EXISTS role_permission (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            role_id mediumint(9) NOT NULL,
            permission_id mediumint(9) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY  (id),
            FOREIGN KEY (role_id)
                REFERENCES roles(id)
                ON DELETE CASCADE,
            FOREIGN KEY (permission_id)
                REFERENCES permissions(id)
                ON DELETE CASCADE
          );";
    }

    public function down()
    {
        return "DROP TABLE role_permission";
    }
}