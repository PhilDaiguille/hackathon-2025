<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250423191728 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // 1. Ajouter la colonne roles mais nullable
        $this->addSql('ALTER TABLE "user" ADD roles JSON DEFAULT NULL');

        // 2. Mettre une valeur par défaut pour les utilisateurs existants
        $this->addSql("UPDATE \"user\" SET roles = '[ROLE_USER]' WHERE roles IS NULL");

        // 3. Rendre la colonne NOT NULL
        $this->addSql('ALTER TABLE "user" ALTER COLUMN roles SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE "user" DROP roles
        SQL);
    }
}
