<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130412152918 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE texts (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, text_ca LONGTEXT NOT NULL, text_es LONGTEXT NOT NULL, text_en LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_1E3513BF5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("
            INSERT INTO texts (name, text_ca, text_en, text_es) VALUES
              ('quesignificayumcha_titol', 'què significa yumcha?' ,'what does yumcha mean?','¿qué significa yumcha?'),
              ('quesignificayumcha_text', 'quesignificayumcha text ca', 'quesignificayumcha text en', 'quesignificayumcha text es'),
              ('volstreballambnosaltres_titol', 'vols treball amb nosaltres?', 'work with us?', '¿quieres trabajo con nosotros?'),
              ('volstreballambnosaltres_text', 'vols treball amb nosaltres ca', 'vols treball amb nosaltres en', 'vols treball amb nosaltres es'),
              ('yumchashop_lateral', 'lateral yumcha shop', 'lateral yumcha shop', 'lateral yumcha shop'),
              ('yumchashop_text', 'yumchashop_text', 'yumchashop_text', 'yumchashop_text')
        ");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE texts");
    }
}
