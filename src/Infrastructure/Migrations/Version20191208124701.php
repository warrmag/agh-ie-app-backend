<?php

declare(strict_types=1);

namespace Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191208124701 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE card (id UUID NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN card.id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE task ADD card_id UUID DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN task.card_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB254ACC9A20 FOREIGN KEY (card_id) REFERENCES card (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_527EDB254ACC9A20 ON task (card_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE task DROP CONSTRAINT FK_527EDB254ACC9A20');
        $this->addSql('DROP TABLE card');
        $this->addSql('DROP INDEX IDX_527EDB254ACC9A20');
        $this->addSql('ALTER TABLE task DROP card_id');
    }
}
