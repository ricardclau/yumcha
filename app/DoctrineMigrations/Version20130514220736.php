<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130514220736 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE icecream_categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, title_ca VARCHAR(255) NOT NULL, title_es VARCHAR(255) NOT NULL, title_en VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_44BBAF35E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE icecream_flavours (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, title_ca VARCHAR(255) NOT NULL, title_es VARCHAR(255) NOT NULL, title_en VARCHAR(255) NOT NULL, INDEX IDX_3213E0E812469DE2 (category_id), UNIQUE INDEX UNIQ_3213E0E85E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE special_icecreams (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, title_ca VARCHAR(255) NOT NULL, title_es VARCHAR(255) NOT NULL, title_en VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_AE0801D65E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE icecream_flavours ADD CONSTRAINT FK_3213E0E812469DE2 FOREIGN KEY (category_id) REFERENCES icecream_categories (id)");
        $this->addSql("
            INSERT INTO icecream_categories (name, title_ca, title_en, title_es) VALUES
              ('crema', 'crema' ,'crema', 'crema'),
              ('sorbet', 'sorbet' ,'sorbete', 'sorbet'),
              ('toppings', 'toppings' ,'toppings', 'toppings')
        ");
        $this->addSql("
            INSERT INTO icecream_flavours (category_id, name, title_ca, title_en, title_es) VALUES
              (1, 'avellanes', 'avellanes', 'hazelnut' 'avellanas'),
              (1, 'cafè', 'cafè' ,'coffee', 'café'),
              (1, 'llet merengada', 'llet merengada' ,'meringued milk', 'leche merengada'),
              (1, 'xocolata', 'xocolata' ,'chocolate', 'chocolate'),
              (1, 'sèsam negre', 'sèsam negre' ,'black sesam', 'sésamo negro'),
              (1, 'crema catalana', 'crema catalana' ,'catalan cream', 'crema catalana'),
              (1, 'plàtan', 'plàtan' ,'banana', 'plátano'),
              (1, 'taro', 'taro (o ube)' ,'taro (or ube)', 'taro (o ube)'),
              (2, 'te matcha', 'te matcha' ,'matcha tea', 'té matcha'),
              (1, 'maduixa', 'maduixa' ,'strawberry', 'fresa'),
              (1, 'stracciatella', 'stracciatella' ,'stracciatella', 'stracciatella'),
              (1, 'festuc', 'festuc' ,'pistachio', 'pistacho'),
              (1, 'coco', 'coco' ,'coconut', 'coco'),
              (1, 'vainilla', 'vainilla' ,'vanilla', 'vainilla'),

              (2, 'mango', 'mango' ,'mango', 'mango'),
              (2, 'mandarina', 'mandarina' ,'mandarine', 'mandarina'),
              (2, 'llimona', 'llimona' ,'lemon', 'limón'),
              (2, 'gingebre', 'gingebre' ,'ginger', 'jengibre'),
              (2, 'te matcha', 'te matcha' ,'matcha tea', 'té matcha'),
              (2, 'maracujà', 'maracujà' ,'maracuja', 'maracuyà'),

              (3, 'bombolles xoco', 'bombolles xoco' ,'choc bubbles', 'burbujas choco'),
              (3, 'fruits secs', 'fruits secs' ,'nuts', 'frutos secos'),
              (3, 'nutella', 'nutella' ,'nutella', 'nutella'),
              (3, 'poppings', 'poppings' ,'poppings', 'poppings'),
              (3, 'gelatines', 'gelatines' ,'gelatines', 'gelatinas')
        ");

        $this->addSql("
            INSERT INTO texts (name, text_ca, text_en, text_es) VALUES
              ('gelats_especialitats', 'Les especialitats' ,'The specialties', 'Las especialidades'),
              ('per_diabetics', 'Per diabètics', 'For diabetics', 'Para diabéticos'),
              ('restauracio', 'Restauració', 'Restoration', 'Restauración'),
              ('per_diabetics_text', 'Per diabètics text', 'For diabetics text', 'Para diabéticos texto'),
              ('restauracio_text', 'Restauració', 'Restoration text', 'Restauración texto')
        ");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE icecream_flavours DROP FOREIGN KEY FK_3213E0E812469DE2");
        $this->addSql("DROP TABLE icecream_categories");
        $this->addSql("DROP TABLE icecream_flavours");
        $this->addSql("DROP TABLE special_icecreams");
    }
}
