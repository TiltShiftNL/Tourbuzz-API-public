<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161025120056 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE glimworm_device (id INT NOT NULL, device_type_id INT DEFAULT NULL, lat DOUBLE PRECISION DEFAULT NULL, lon DOUBLE PRECISION DEFAULT NULL, UUID VARCHAR(255) DEFAULT NULL, status INT DEFAULT NULL, timestamp INT DEFAULT NULL, battery INT DEFAULT NULL, front INT DEFAULT NULL, bottom INT DEFAULT NULL, lora_appid VARCHAR(255) DEFAULT NULL, lora_key VARCHAR(255) DEFAULT NULL, lora_devid INT DEFAULT NULL, displayname INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9861228DBF396750 ON glimworm_device (id)');
        $this->addSql('CREATE TABLE glimworm_data (id INT NOT NULL, device_id INT DEFAULT NULL, time TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, battery INT DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, devicetype VARCHAR(255) DEFAULT NULL, downsensor INT DEFAULT NULL, glimworm_id VARCHAR(255) DEFAULT NULL, msgtype VARCHAR(255) DEFAULT NULL, rssi INT DEFAULT NULL, status INT DEFAULT NULL, topsensor INT DEFAULT NULL, ts DOUBLE PRECISION DEFAULT NULL, vehicle INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3A4C2998BF396750 ON glimworm_data (id)');
        $this->addSql('CREATE INDEX IDX_3A4C299894A4C7D4 ON glimworm_data (device_id)');
        $this->addSql('ALTER TABLE glimworm_data ADD CONSTRAINT FK_3A4C299894A4C7D4 FOREIGN KEY (device_id) REFERENCES glimworm_device (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE glimworm_data DROP CONSTRAINT FK_3A4C299894A4C7D4');
        $this->addSql('DROP TABLE glimworm_device');
        $this->addSql('DROP TABLE glimworm_data');
    }
}