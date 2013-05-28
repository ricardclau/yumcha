<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130528223614 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE bubble_ingredients (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, title_ca VARCHAR(255) NOT NULL, title_es VARCHAR(255) NOT NULL, title_en VARCHAR(255) NOT NULL, INDEX IDX_9ABB006012469DE2 (category_id), UNIQUE INDEX UNIQ_9ABB00605E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE bubble_ingredients_categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, title_ca VARCHAR(255) NOT NULL, title_es VARCHAR(255) NOT NULL, title_en VARCHAR(255) NOT NULL, step INT NOT NULL, UNIQUE INDEX UNIQ_7D1DD6515E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE bubble_ingredients ADD CONSTRAINT FK_9ABB006012469DE2 FOREIGN KEY (category_id) REFERENCES bubble_ingredients_categories (id)");
        $this->addSql("
            INSERT INTO bubble_ingredients_categories (name, title_ca, title_es, title_en, step) VALUES
              ('SenseLlet', 'Sense Llet', 'Sin Leche', 'Without Milk', 2),
              ('AmbLlet', 'Amb Llet', 'Con Leche', 'With Milk', 2),
              ('Tapioca', 'Tapioca', 'Tapioca', 'Tapioca', 3),
              ('Gelatines', 'Gelatines', 'Gelatinas', 'Jelly', 3),
              ('Poppings', 'Poppings', 'Poppings', 'Poppings', 3),
              ('Altres', 'Altres', 'Otros', 'Others', 3)
        ");

        $this->addSql("
        INSERT INTO bubble_ingredients (id, category_id, name, title_ca, title_es, title_en) VALUES
            (1,1,'Mango','Mango','Mango','Mango'),
            (2,1,'Maduixa','Maduixa','Fresa','Strawberry'),
            (3,2,'Taro','Taro','Taro','Taro'),
            (4,2,'Ametlla','Ametlla','Almendra','Hazelnut'),
            (6,4,'Maduixa_gel','Maduixa','Fresa','Strawberry'),
            (7,4,'Poma verda','Poma verda','Manzana verde','Green Apple'),
            (8,5,'Litxi','Litxi','Lichi','Lichy'),
        ");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE bubble_ingredients DROP FOREIGN KEY FK_9ABB006012469DE2");
        $this->addSql("DROP TABLE bubble_ingredients");
        $this->addSql("DROP TABLE bubble_ingredients_categories");
    }
}
