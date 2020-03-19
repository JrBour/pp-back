<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200319214251 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE expenses_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE users_events_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE medias_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE album_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE events_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE expenses (id INT NOT NULL, event_id INT DEFAULT NULL, user_id INT DEFAULT NULL, amount DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2496F35B71F7E88B ON expenses (event_id)');
        $this->addSql('CREATE INDEX IDX_2496F35BA76ED395 ON expenses (user_id)');
        $this->addSql('CREATE TABLE users_events (id INT NOT NULL, user_id INT DEFAULT NULL, event_id INT DEFAULT NULL, status VARCHAR(30) NOT NULL, is_read BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5C60D9DAA76ED395 ON users_events (user_id)');
        $this->addSql('CREATE INDEX IDX_5C60D9DA71F7E88B ON users_events (event_id)');
        $this->addSql('CREATE TABLE medias (id INT NOT NULL, album_id INT DEFAULT NULL, path VARCHAR(125) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_12D2AF811137ABCF ON medias (album_id)');
        $this->addSql('CREATE TABLE album (id INT NOT NULL, event_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_39986E4371F7E88B ON album (event_id)');
        $this->addSql('CREATE TABLE events (id INT NOT NULL, author_id INT DEFAULT NULL, name VARCHAR(90) NOT NULL, description VARCHAR(255) NOT NULL, image VARCHAR(125) DEFAULT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(125) NOT NULL, zipcode INT NOT NULL, start_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, share_fees BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5387574AF675F31B ON events (author_id)');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, given_name VARCHAR(125) NOT NULL, last_name VARCHAR(125) NOT NULL, email VARCHAR(254) NOT NULL, image VARCHAR(125) DEFAULT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE expenses ADD CONSTRAINT FK_2496F35B71F7E88B FOREIGN KEY (event_id) REFERENCES events (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expenses ADD CONSTRAINT FK_2496F35BA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users_events ADD CONSTRAINT FK_5C60D9DAA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users_events ADD CONSTRAINT FK_5C60D9DA71F7E88B FOREIGN KEY (event_id) REFERENCES events (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE medias ADD CONSTRAINT FK_12D2AF811137ABCF FOREIGN KEY (album_id) REFERENCES album (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE album ADD CONSTRAINT FK_39986E4371F7E88B FOREIGN KEY (event_id) REFERENCES events (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574AF675F31B FOREIGN KEY (author_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE medias DROP CONSTRAINT FK_12D2AF811137ABCF');
        $this->addSql('ALTER TABLE expenses DROP CONSTRAINT FK_2496F35B71F7E88B');
        $this->addSql('ALTER TABLE users_events DROP CONSTRAINT FK_5C60D9DA71F7E88B');
        $this->addSql('ALTER TABLE album DROP CONSTRAINT FK_39986E4371F7E88B');
        $this->addSql('ALTER TABLE expenses DROP CONSTRAINT FK_2496F35BA76ED395');
        $this->addSql('ALTER TABLE users_events DROP CONSTRAINT FK_5C60D9DAA76ED395');
        $this->addSql('ALTER TABLE events DROP CONSTRAINT FK_5387574AF675F31B');
        $this->addSql('DROP SEQUENCE expenses_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE users_events_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE medias_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE album_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE events_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('DROP TABLE expenses');
        $this->addSql('DROP TABLE users_events');
        $this->addSql('DROP TABLE medias');
        $this->addSql('DROP TABLE album');
        $this->addSql('DROP TABLE events');
        $this->addSql('DROP TABLE users');
    }
}
