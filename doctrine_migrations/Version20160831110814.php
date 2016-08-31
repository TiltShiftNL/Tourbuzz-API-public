<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160831110814 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP INDEX uniq_aa5a118ef85e0677');
        $this->addSql('ALTER TABLE tokens RENAME COLUMN username TO token');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AA5A118E5F37A13B ON tokens (token)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_AA5A118E5F37A13B');
        $this->addSql('ALTER TABLE tokens RENAME COLUMN token TO username');
        $this->addSql('CREATE UNIQUE INDEX uniq_aa5a118ef85e0677 ON tokens (username)');
    }
}