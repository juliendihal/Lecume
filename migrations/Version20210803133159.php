<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210803133159 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plats ADD subtype_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE plats ADD CONSTRAINT FK_854A620A8E2E245C FOREIGN KEY (subtype_id) REFERENCES sub_type (id)');
        $this->addSql('CREATE INDEX IDX_854A620A8E2E245C ON plats (subtype_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plats DROP FOREIGN KEY FK_854A620A8E2E245C');
        $this->addSql('DROP INDEX IDX_854A620A8E2E245C ON plats');
        $this->addSql('ALTER TABLE plats DROP subtype_id');
    }
}
