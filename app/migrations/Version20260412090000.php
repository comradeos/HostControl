<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260412090000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Bind domains.account_uuid to accounts.uuid with foreign key';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE domains MODIFY account_uuid VARCHAR(36) COLLATE utf8mb4_unicode_ci NOT NULL');
        $this->addSql('ALTER TABLE domains ADD CONSTRAINT FK_DOMAINS_ACCOUNT_UUID FOREIGN KEY (account_uuid) REFERENCES accounts (uuid)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE domains DROP FOREIGN KEY FK_DOMAINS_ACCOUNT_UUID');
    }
}
