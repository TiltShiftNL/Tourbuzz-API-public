<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161017130610 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE users DROP CONSTRAINT fk_1483a5e941dee7b9');
        $this->addSql('DROP INDEX uniq_1483a5e941dee7b9');
        $this->addSql('ALTER TABLE users DROP token_id');
        $this->addSql('DROP INDEX uniq_aa5a118ea76ed395');
        $this->addSql('CREATE INDEX IDX_AA5A118EA76ED395 ON tokens (user_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX IDX_AA5A118EA76ED395');
        $this->addSql('CREATE UNIQUE INDEX uniq_aa5a118ea76ed395 ON tokens (user_id)');
        $this->addSql('ALTER TABLE users ADD token_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT fk_1483a5e941dee7b9 FOREIGN KEY (token_id) REFERENCES tokens (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_1483a5e941dee7b9 ON users (token_id)');
    }
}