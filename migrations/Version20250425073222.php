<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250425073222 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE wishlist (id SERIAL NOT NULL, client_id INT DEFAULT NULL, hotel_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_9CE12A3119EB6921 ON wishlist (client_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_9CE12A313243BB18 ON wishlist (hotel_id)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN wishlist.created_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE wishlist ADD CONSTRAINT FK_9CE12A3119EB6921 FOREIGN KEY (client_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE wishlist ADD CONSTRAINT FK_9CE12A313243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE wishlist DROP CONSTRAINT FK_9CE12A3119EB6921
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE wishlist DROP CONSTRAINT FK_9CE12A313243BB18
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE wishlist
        SQL);
    }
}
