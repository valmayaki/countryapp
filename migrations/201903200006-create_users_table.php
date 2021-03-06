<?php

class CreateUserTableMigration
{
    public function up()
    {
        return "CREATE TABLE IF NOT EXISTS users (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
            firstname VARCHAR(100) NOT NULL,
            lastname VARCHAR(100) NOT NULL,
            email VARCHAR(50) NOT NULL,
            password VARCHAR(50) NOT NULL,
            enable BOOLEAN NOT NULL DEFAULT 1,
            PRIMARY KEY  (id),
            UNIQUE KEY unique_email (email)
          );";
    }

    public function down()
    {
        return "DROP TABLE users";
    }
}