<?php

class CreateIncreaseSizeOfPasswordInUsersTableMigration
{
    public function up()
    {
        return "ALTER TABLE users MODIFY `password` VARCHAR(255) NOT NULL;";
    }

    public function down()
    {
        return "ALTER TABLE users ALTER COLUMN `password` VARCHAR(50) NOT NULL;";
    }
}