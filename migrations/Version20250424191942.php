<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250424191942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajoute le champ stars à la table hotel';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE hotel ADD stars INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE hotel DROP stars');
    }
}
