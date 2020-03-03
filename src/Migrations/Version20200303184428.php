<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200303184428 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE election_boards (id INT AUTO_INCREMENT NOT NULL, election_cycles_id INT DEFAULT NULL, boards_name VARCHAR(255) NOT NULL, date_start VARCHAR(50) DEFAULT NULL, date_end VARCHAR(50) DEFAULT NULL, timezone VARCHAR(75) DEFAULT NULL, address_1 VARCHAR(75) DEFAULT NULL, address_2 VARCHAR(75) DEFAULT NULL, city VARCHAR(75) DEFAULT NULL, state VARCHAR(50) DEFAULT NULL, zipcode VARCHAR(25) DEFAULT NULL, phone VARCHAR(50) DEFAULT NULL, email VARCHAR(50) DEFAULT NULL, contact VARCHAR(75) DEFAULT NULL, important_note VARCHAR(300) DEFAULT NULL, locals_code VARCHAR(10) DEFAULT NULL, active TINYINT(1) NOT NULL, date_created VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE election_boards');
    }
}
