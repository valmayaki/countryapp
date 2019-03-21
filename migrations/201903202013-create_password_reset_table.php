<?php

class CreatePasswordResetTableMigration
{
    public function up()
    {
        return "CREATE TABLE IF NOT EXISTS password_reset (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
            email VARCHAR(100) NOT NULL,
            token VARCHAR(100) NOT NULL,
            PRIMARY KEY  (id),
            UNIQUE KEY unique_email (email)
          );";
    }

    public function down()
    {
        return "DROP TABLE password_reset";
    }
}