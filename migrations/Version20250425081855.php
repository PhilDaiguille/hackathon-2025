<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250425081855 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP INDEX uniq_e00cedde31d987b
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_E00CEDDE31D987B ON booking (id_offer_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_E00CEDDE31D987B
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX uniq_e00cedde31d987b ON booking (id_offer_id)
        SQL);
    }
}
