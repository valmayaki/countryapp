<?php

class CreatePermissionsTableMigration
{
    public function up()
    {
        return "CREATE TABLE IF NOT EXISTS permissions (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name VARCHAR(100) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY  (id)
          );";
    }

    public function down()
    {
        return "DROP TABLE roles";
    }
}