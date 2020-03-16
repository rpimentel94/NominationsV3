<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200302213742 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE member CHANGE date_created date_created VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE member_information CHANGE date_created date_created VARCHAR(100) NOT NULL, CHANGE date_modified date_modified VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE member_local CHANGE date_created date_created VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE member CHANGE date_created date_created INT NOT NULL');
        $this->addSql('ALTER TABLE member_information CHANGE date_created date_created INT NOT NULL, CHANGE date_modified date_modified INT NOT NULL');
        $this->addSql('ALTER TABLE member_local CHANGE date_created date_created INT DEFAULT NULL');
    }
}
