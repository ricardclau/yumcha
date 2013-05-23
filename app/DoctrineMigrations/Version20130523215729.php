<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130523215729 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");

        $this->addSql("
            INSERT INTO texts (name, text_ca, text_en, text_es) VALUES
              ('bubble_especialitats', 'Especialitats' ,'Specialties', 'Especialidades'),
              ('que_es_bubble_tea', 'que_es_bubble_tea' ,'que_es_bubble_tea', 'que_es_bubble_tea'),
              ('que_es_bubble_tea_text', '<p>que_es_bubble_tea_text</p>' ,'<p>que_es_bubble_tea_text</p>', '<p>que_es_bubble_tea_text</p>'),
              ('bubble_tea_origens', 'bubble_tea_origens' ,'bubble_tea_origens', 'bubble_tea_origens'),
              ('bubble_tea_origens_text', '<p>bubble_tea_origens_text</p>' ,'<p>bubble_tea_origens_text</p>', '<p>bubble_tea_origens_text</p>'),
              ('perles_tapioca', 'perles_tapioca' ,'perles_tapioca', 'perles_tapioca'),
              ('perles_tapioca_text', '<p>perles_tapioca_text</p>' ,'<p>perles_tapioca_text</p>', '<p>perles_tapioca_text</p>')
        ");

    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
    }
}
