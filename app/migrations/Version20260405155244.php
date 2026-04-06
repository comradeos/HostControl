<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260405155244 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add unique constraints for domains.name and hosting_plans.name';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE UNIQUE INDEX uniq_domain_name ON domains (name)');
        $this->addSql('CREATE UNIQUE INDEX uniq_hosting_plan_name ON hosting_plans (name)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX uniq_domain_name ON domains');
        $this->addSql('DROP INDEX uniq_hosting_plan_name ON hosting_plans');
    }
}
