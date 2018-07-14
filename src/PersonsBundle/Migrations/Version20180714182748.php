<?php declare(strict_types=1);

namespace TheFox\PersonsBundle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20180714182748 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE persons2_persons (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) NOT NULL, last_name_born VARCHAR(255) DEFAULT NULL, middle_name VARCHAR(255) DEFAULT NULL, first_name VARCHAR(255) NOT NULL, nick_name VARCHAR(255) DEFAULT NULL, gender VARCHAR(255) DEFAULT NULL, birthday DATETIME DEFAULT NULL, deceased_at DATETIME DEFAULT NULL, first_met_at DATETIME DEFAULT NULL, facebook_id VARCHAR(255) DEFAULT NULL, facebook_url LONGTEXT DEFAULT NULL, blood_type VARCHAR(2) DEFAULT NULL, blood_type_rhd VARCHAR(1) DEFAULT NULL, default_event_type SMALLINT DEFAULT 1000, comment LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_B8B005C94AF38FD1 (deleted_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE persons2_persons');
    }
}
