<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200226211231 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE election_board_positions DROP FOREIGN KEY ElectionBP_Boards_FK01');
        $this->addSql('ALTER TABLE election_board_positions DROP FOREIGN KEY ElectionBP_Boards_FK02');
        $this->addSql('ALTER TABLE election_boards DROP FOREIGN KEY ElectionBoards_Cycle_FK01');
        $this->addSql('CREATE TABLE member_local (id INT AUTO_INCREMENT NOT NULL, users_id INT NOT NULL, election_cycles_id INT NOT NULL, description VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, active TINYINT(1) DEFAULT NULL, date_created INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE election_board_positions');
        $this->addSql('DROP TABLE election_boards');
        $this->addSql('DROP TABLE election_cycles');
        $this->addSql('ALTER TABLE member CHANGE election_cycle_id election_cycles_id INT NOT NULL');
        $this->addSql('ALTER TABLE staff CHANGE election_cycle_id election_cycles_id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE election_board_positions (id INT AUTO_INCREMENT NOT NULL, election_cycles_id INT DEFAULT NULL, election_boards_id INT DEFAULT NULL, position VARCHAR(150) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, position_2 VARCHAR(150) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, additional_note VARCHAR(150) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, signatures_required INT DEFAULT NULL, delegate TINYINT(1) DEFAULT NULL, date_created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, active TINYINT(1) DEFAULT \'1\' NOT NULL, deleted TINYINT(1) DEFAULT \'0\', INDEX ElectionBP_Boards_FK01 (election_boards_id), INDEX ElectionBP_Boards_FK02 (election_cycles_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE election_boards (id INT AUTO_INCREMENT NOT NULL, election_cycles_id INT NOT NULL, boards_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_start BIGINT DEFAULT NULL, date_end BIGINT DEFAULT NULL, time_zone VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, address VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, address_2 VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, city VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, state VARCHAR(40) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, zip VARCHAR(25) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, phone VARCHAR(25) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, email_address VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, contact VARCHAR(40) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, important_note VARCHAR(300) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, active TINYINT(1) DEFAULT \'1\' NOT NULL, deleted TINYINT(1) DEFAULT \'0\' NOT NULL, locals_code VARCHAR(5) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, date_created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX ElectionBoards_Cycle_FK01 (election_cycles_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE election_cycles (id INT AUTO_INCREMENT NOT NULL, date_start BIGINT DEFAULT NULL, date_end BIGINT DEFAULT NULL, date_created BIGINT NOT NULL, active TINYINT(1) DEFAULT \'1\' NOT NULL, deleted TINYINT(1) DEFAULT \'0\' NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE election_board_positions ADD CONSTRAINT ElectionBP_Boards_FK01 FOREIGN KEY (election_boards_id) REFERENCES election_boards (id)');
        $this->addSql('ALTER TABLE election_board_positions ADD CONSTRAINT ElectionBP_Boards_FK02 FOREIGN KEY (election_cycles_id) REFERENCES election_cycles (id)');
        $this->addSql('ALTER TABLE election_boards ADD CONSTRAINT ElectionBoards_Cycle_FK01 FOREIGN KEY (election_cycles_id) REFERENCES election_cycles (id)');
        $this->addSql('DROP TABLE member_local');
        $this->addSql('ALTER TABLE member CHANGE election_cycles_id election_cycle_id INT NOT NULL');
        $this->addSql('ALTER TABLE staff CHANGE election_cycles_id election_cycle_id INT NOT NULL');
    }
}
