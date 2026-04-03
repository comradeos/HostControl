<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260403063938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE hosting_plans (
                id INT AUTO_INCREMENT NOT NULL,
                uuid VARCHAR(36) NOT NULL,
                name VARCHAR(255) NOT NULL,
                disk_space_mb INT NOT NULL,
                bandwidth_mb INT NOT NULL,
                price DOUBLE PRECISION NOT NULL,
                created_at DATETIME NOT NULL,
                UNIQUE INDEX UNIQ_EC0D8F2BD17F50A6 (uuid),
                PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8mb4
        ');

        $this->addSql('
            ALTER TABLE accounts
            CHANGE status status VARCHAR(255) NOT NULL
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE hosting_plans');

        $this->addSql('
            ALTER TABLE accounts
            CHANGE status status VARCHAR(20) NOT NULL
        ');

        $this->addSql('CREATE INDEX IDX_ACCOUNTS_STATUS ON accounts (status)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ACCOUNTS_EMAIL ON accounts (email)');
    }
}
