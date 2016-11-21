<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161121101821 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE vialis_dynamic_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE vialis_dynamic (id INT NOT NULL, description VARCHAR(255) DEFAULT NULL, vialis_id VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, "full" BOOLEAN DEFAULT NULL, last_updated TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, open BOOLEAN DEFAULT NULL, status_description VARCHAR(255) DEFAULT NULL, capacity INT DEFAULT NULL, vacant INT DEFAULT NULL, last_pull TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D549110BF396750 ON vialis_dynamic (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D5491108C4B9B7D ON vialis_dynamic (vialis_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE vialis_dynamic_id_seq CASCADE');
        $this->addSql('DROP TABLE vialis_dynamic');
    }
}
