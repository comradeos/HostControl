<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260408184254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'CREATE TABLE websites (
                id INT AUTO_INCREMENT NOT NULL,
                uuid VARCHAR(36) NOT NULL,
                domain_uuid VARCHAR(36) NOT NULL,
                root_path VARCHAR(255) NOT NULL,
                php_version VARCHAR(10) NOT NULL,
                disk_limit_mb INT NOT NULL,
                cpu_limit INT NOT NULL,
                created_at DATETIME NOT NULL,
                UNIQUE INDEX UNIQ_2527D78DD17F50A6 (uuid),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE websites');
    }
}
