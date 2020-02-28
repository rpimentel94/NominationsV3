<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200227225849 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE member_information (id INT AUTO_INCREMENT NOT NULL, users_id INT NOT NULL, ballot_display_name VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, address_1 VARCHAR(255) DEFAULT NULL, address_2 VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, state VARCHAR(100) DEFAULT NULL, country VARCHAR(100) DEFAULT NULL, zip_code VARCHAR(50) DEFAULT NULL, media_contact TINYINT(1) DEFAULT NULL, media_phone VARCHAR(50) DEFAULT NULL, media_email VARCHAR(100) DEFAULT NULL, election_cycles_id INT NOT NULL, active TINYINT(1) NOT NULL, date_created INT NOT NULL, date_modified INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE member_information');
    }
}
