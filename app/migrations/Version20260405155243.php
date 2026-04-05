<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260405155243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE domains (id INT AUTO_INCREMENT NOT NULL, uuid VARCHAR(36) NOT NULL, name VARCHAR(255) NOT NULL, account_uuid VARCHAR(36) NOT NULL, status VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8C7BBF9DD17F50A6 (uuid), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('DROP INDEX IDX_ACCOUNTS_STATUS ON accounts');
        $this->addSql('DROP INDEX UNIQ_ACCOUNTS_EMAIL ON accounts');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE domains');
        $this->addSql('CREATE INDEX IDX_ACCOUNTS_STATUS ON accounts (status)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ACCOUNTS_EMAIL ON accounts (email)');
    }
}
