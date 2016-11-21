<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161121124453 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE parkeerplaats_dynamic_xref_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE parkeerplaats_dynamic_xref (id INT NOT NULL, vialis_dynamic_id INT DEFAULT NULL, parkeerplaats VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D7471CB6BF396750 ON parkeerplaats_dynamic_xref (id)');
        $this->addSql('CREATE INDEX IDX_D7471CB67E3B48EB ON parkeerplaats_dynamic_xref (vialis_dynamic_id)');
        $this->addSql('ALTER TABLE parkeerplaats_dynamic_xref ADD CONSTRAINT FK_D7471CB67E3B48EB FOREIGN KEY (vialis_dynamic_id) REFERENCES vialis_dynamic (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE parkeerplaats_dynamic_xref_id_seq CASCADE');
        $this->addSql('DROP TABLE parkeerplaats_dynamic_xref');
    }
}