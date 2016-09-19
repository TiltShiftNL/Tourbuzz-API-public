<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160919134550 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP INDEX uniq_c3ac1fda5126ac48');
        $this->addSql('ALTER TABLE telefoons RENAME COLUMN mail TO number');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C3AC1FDA96901F54 ON telefoons (number)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_C3AC1FDA96901F54');
        $this->addSql('ALTER TABLE telefoons RENAME COLUMN number TO mail');
        $this->addSql('CREATE UNIQUE INDEX uniq_c3ac1fda5126ac48 ON telefoons (mail)');
    }
}
