<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200306175143 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE petitions (id INT AUTO_INCREMENT NOT NULL, users_id INT NOT NULL, election_cycles_id INT NOT NULL, election_boards_id INT NOT NULL, election_board_positions_id INT NOT NULL, consent_to_serve TINYINT(1) NOT NULL, agreement_signature TINYINT(1) NOT NULL, lmrda_notice TINYINT(1) NOT NULL, photo_release TINYINT(1) NOT NULL, withdrawn TINYINT(1) NOT NULL, preliminary_eligibility_check TINYINT(1) NOT NULL, final_eligibility TINYINT(1) NOT NULL, online_signature_status TINYINT(1) NOT NULL, notes VARCHAR(500) DEFAULT NULL, national TINYINT(1) DEFAULT NULL, active TINYINT(1) NOT NULL, date_created VARCHAR(50) NOT NULL, date_modified VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE petitions');
    }
}
