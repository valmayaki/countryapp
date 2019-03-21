<?php

class CreateCountriesTableMigration
{
    public function up()
    {
        return "CREATE TABLE IF NOT EXISTS countries (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
            name VARCHAR(100) NOT NULL,
            PRIMARY KEY (id)
          );";
    }

    public function down()
    {
        return "DROP TABLE countries";
    }
}