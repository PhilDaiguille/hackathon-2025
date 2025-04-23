<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250423102326 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE TABLE blocked_booking (id SERIAL NOT NULL, id_user_id INT NOT NULL, id_hotel_id INT NOT NULL, blocked_until TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_59DE852879F37AE5 ON blocked_booking (id_user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_59DE85286298578D ON blocked_booking (id_hotel_id)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN blocked_booking.created_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE booking (id SERIAL NOT NULL, id_user_id INT NOT NULL, id_offer_id INT NOT NULL, final_price DOUBLE PRECISION NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_E00CEDDE79F37AE5 ON booking (id_user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_E00CEDDE31D987B ON booking (id_offer_id)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN booking.created_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN booking.updated_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE hotel (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, street_name VARCHAR(255) DEFAULT NULL, street_number VARCHAR(50) DEFAULT NULL, postal_code VARCHAR(25) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, country VARCHAR(255) NOT NULL, rating DOUBLE PRECISION NOT NULL, admin_email VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN hotel.created_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN hotel.updated_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE negociation (id SERIAL NOT NULL, id_booking_id INT NOT NULL, new_price DOUBLE PRECISION NOT NULL, response_deadline TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_B5E137D8A6BA9CB7 ON negociation (id_booking_id)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN negociation.created_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN negociation.updated_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE offer (id SERIAL NOT NULL, id_hotel_id INT NOT NULL, id_room_id INT NOT NULL, acceptance_threshold INT DEFAULT NULL, refusal_threshold INT DEFAULT NULL, available_from TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_until TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_29D6873E6298578D ON offer (id_hotel_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_29D6873E8A8AD9E3 ON offer (id_room_id)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN offer.created_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN offer.updated_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE room (id SERIAL NOT NULL, id_hotel_id INT NOT NULL, type VARCHAR(255) NOT NULL, base_price DOUBLE PRECISION NOT NULL, description TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_729F519B6298578D ON room (id_hotel_id)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN room.created_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN room.updated_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE "user" (id SERIAL NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, is_active BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN "user".created_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN "user".updated_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE blocked_booking ADD CONSTRAINT FK_59DE852879F37AE5 FOREIGN KEY (id_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE blocked_booking ADD CONSTRAINT FK_59DE85286298578D FOREIGN KEY (id_hotel_id) REFERENCES hotel (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE79F37AE5 FOREIGN KEY (id_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE31D987B FOREIGN KEY (id_offer_id) REFERENCES offer (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE negociation ADD CONSTRAINT FK_B5E137D8A6BA9CB7 FOREIGN KEY (id_booking_id) REFERENCES booking (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE offer ADD CONSTRAINT FK_29D6873E6298578D FOREIGN KEY (id_hotel_id) REFERENCES hotel (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE offer ADD CONSTRAINT FK_29D6873E8A8AD9E3 FOREIGN KEY (id_room_id) REFERENCES room (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE room ADD CONSTRAINT FK_729F519B6298578D FOREIGN KEY (id_hotel_id) REFERENCES hotel (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE blocked_booking DROP CONSTRAINT FK_59DE852879F37AE5
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE blocked_booking DROP CONSTRAINT FK_59DE85286298578D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE booking DROP CONSTRAINT FK_E00CEDDE79F37AE5
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE booking DROP CONSTRAINT FK_E00CEDDE31D987B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE negociation DROP CONSTRAINT FK_B5E137D8A6BA9CB7
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE offer DROP CONSTRAINT FK_29D6873E6298578D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE offer DROP CONSTRAINT FK_29D6873E8A8AD9E3
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE room DROP CONSTRAINT FK_729F519B6298578D
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE blocked_booking
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE booking
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE hotel
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE negociation
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE offer
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE room
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE "user"
        SQL);
    }
}
