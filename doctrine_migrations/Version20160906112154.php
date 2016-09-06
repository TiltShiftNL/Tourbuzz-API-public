<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160906112154 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE vergeten_tokens (id INT NOT NULL, user_id INT DEFAULT NULL, token VARCHAR(255) DEFAULT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BED8E03CBF396750 ON vergeten_tokens (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BED8E03C5F37A13B ON vergeten_tokens (token)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BED8E03CA76ED395 ON vergeten_tokens (user_id)');
        $this->addSql('ALTER TABLE vergeten_tokens ADD CONSTRAINT FK_BED8E03CA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users ADD vergeten_token_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E95D97FD8B FOREIGN KEY (vergeten_token_id) REFERENCES vergeten_tokens (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E95D97FD8B ON users (vergeten_token_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE users DROP CONSTRAINT FK_1483A5E95D97FD8B');
        $this->addSql('DROP TABLE vergeten_tokens');
        $this->addSql('DROP INDEX UNIQ_1483A5E95D97FD8B');
        $this->addSql('ALTER TABLE users DROP vergeten_token_id');
    }
}