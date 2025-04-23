<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250423123243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE TABLE experiences (id SERIAL NOT NULL, id_room_id INT NOT NULL, id_predefined_extra_id INT DEFAULT NULL, is_predefined BOOLEAN DEFAULT NULL, custom_name VARCHAR(255) DEFAULT NULL, custom_description TEXT DEFAULT NULL, custom_image VARCHAR(2048) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_82020E708A8AD9E3 ON experiences (id_room_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_82020E7015DB71F4 ON experiences (id_predefined_extra_id)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN experiences.created_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE extras (id SERIAL NOT NULL, id_room_id INT NOT NULL, id_predefined_extras_id INT DEFAULT NULL, is_predefined BOOLEAN DEFAULT NULL, custom_name VARCHAR(255) DEFAULT NULL, custom_description TEXT DEFAULT NULL, custom_image VARCHAR(2048) DEFAULT NULL, price DOUBLE PRECISION NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_269B65D18A8AD9E3 ON extras (id_room_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_269B65D15DB45051 ON extras (id_predefined_extras_id)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN extras.created_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE hotel_images (id SERIAL NOT NULL, id_hotel_id INT DEFAULT NULL, url VARCHAR(2048) NOT NULL, type VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_7CF56C0D6298578D ON hotel_images (id_hotel_id)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN hotel_images.created_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE predefined_extras (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, image VARCHAR(2048) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN predefined_extras.created_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE experiences ADD CONSTRAINT FK_82020E708A8AD9E3 FOREIGN KEY (id_room_id) REFERENCES room (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE experiences ADD CONSTRAINT FK_82020E7015DB71F4 FOREIGN KEY (id_predefined_extra_id) REFERENCES predefined_extras (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE extras ADD CONSTRAINT FK_269B65D18A8AD9E3 FOREIGN KEY (id_room_id) REFERENCES room (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE extras ADD CONSTRAINT FK_269B65D15DB45051 FOREIGN KEY (id_predefined_extras_id) REFERENCES predefined_extras (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE hotel_images ADD CONSTRAINT FK_7CF56C0D6298578D FOREIGN KEY (id_hotel_id) REFERENCES hotel (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE experiences DROP CONSTRAINT FK_82020E708A8AD9E3
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE experiences DROP CONSTRAINT FK_82020E7015DB71F4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE extras DROP CONSTRAINT FK_269B65D18A8AD9E3
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE extras DROP CONSTRAINT FK_269B65D15DB45051
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE hotel_images DROP CONSTRAINT FK_7CF56C0D6298578D
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE experiences
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE extras
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE hotel_images
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE predefined_extras
        SQL);
    }
}
