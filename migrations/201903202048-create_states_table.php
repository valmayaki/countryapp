<?php

class CreateStatesTableMigration
{
    public function up()
    {
        return "CREATE TABLE IF NOT EXISTS states (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
            name VARCHAR(100) NOT NULL,
            country_id mediumint(9) NOT NULL,
            PRIMARY KEY (id),
            FOREIGN KEY (country_id)
                REFERENCES countries(id)
                ON UPDATE CASCADE ON DELETE RESTRICT
          );";
    }

    public function down()
    {
        return "DROP TABLE states";
    }
}