<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260402073257 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
        CREATE TABLE accounts (
            id INT AUTO_INCREMENT NOT NULL,
            uuid VARCHAR(36) NOT NULL,
            email VARCHAR(255) NOT NULL,
            full_name VARCHAR(255) NOT NULL,
            status VARCHAR(20) NOT NULL,
            created_at DATETIME(6) NOT NULL,
            UNIQUE INDEX UNIQ_CAC89EACD17F50A6 (uuid),
            UNIQUE INDEX UNIQ_ACCOUNTS_EMAIL (email),
            INDEX IDX_ACCOUNTS_STATUS (status),
            PRIMARY KEY (id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`
    ');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE accounts');
    }
}
