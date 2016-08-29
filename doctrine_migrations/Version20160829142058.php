<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160829142058 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE berichten ADD body TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE berichten ADD advice TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE berichten ADD title_en VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE berichten ADD body_en TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE berichten ADD advice_en TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE berichten ADD title_fr VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE berichten ADD body_fr TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE berichten ADD advice_fr TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE berichten ADD title_de VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE berichten ADD body_de TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE berichten ADD advice_de TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE berichten ADD startdate DATE NOT NULL');
        $this->addSql('ALTER TABLE berichten ADD enddate DATE NOT NULL');
        $this->addSql('ALTER TABLE berichten ADD category VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE berichten ADD link VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE berichten ADD image_url VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE berichten ADD important BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE berichten ADD is_live BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE berichten ADD include_map BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE berichten ADD location_lat VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE berichten ADD location_lng VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE berichten ALTER title DROP NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_99E34D83BF396750 ON berichten (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_99E34D83BF396750');
        $this->addSql('ALTER TABLE berichten DROP body');
        $this->addSql('ALTER TABLE berichten DROP advice');
        $this->addSql('ALTER TABLE berichten DROP title_en');
        $this->addSql('ALTER TABLE berichten DROP body_en');
        $this->addSql('ALTER TABLE berichten DROP advice_en');
        $this->addSql('ALTER TABLE berichten DROP title_fr');
        $this->addSql('ALTER TABLE berichten DROP body_fr');
        $this->addSql('ALTER TABLE berichten DROP advice_fr');
        $this->addSql('ALTER TABLE berichten DROP title_de');
        $this->addSql('ALTER TABLE berichten DROP body_de');
        $this->addSql('ALTER TABLE berichten DROP advice_de');
        $this->addSql('ALTER TABLE berichten DROP startdate');
        $this->addSql('ALTER TABLE berichten DROP enddate');
        $this->addSql('ALTER TABLE berichten DROP category');
        $this->addSql('ALTER TABLE berichten DROP link');
        $this->addSql('ALTER TABLE berichten DROP image_url');
        $this->addSql('ALTER TABLE berichten DROP important');
        $this->addSql('ALTER TABLE berichten DROP is_live');
        $this->addSql('ALTER TABLE berichten DROP include_map');
        $this->addSql('ALTER TABLE berichten DROP location_lat');
        $this->addSql('ALTER TABLE berichten DROP location_lng');
        $this->addSql('ALTER TABLE berichten ALTER title SET NOT NULL');
    }
}
