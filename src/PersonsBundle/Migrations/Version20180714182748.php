<?php declare(strict_types=1);

/**
 * Migrate Persons.
 */

namespace TheFox\PersonsBundle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20180714182748 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE persons2_persons (
id INT AUTO_INCREMENT NOT NULL,
old_id INT DEFAULT NULL,
user_id INT DEFAULT NULL,
name VARCHAR(255) DEFAULT NULL,
last_name VARCHAR(255) NOT NULL,
last_name_born VARCHAR(255) DEFAULT NULL,
middle_name VARCHAR(255) DEFAULT NULL,
first_name VARCHAR(255) NOT NULL,
nick_name VARCHAR(255) DEFAULT NULL,
gender VARCHAR(255) DEFAULT NULL,
birthday DATETIME DEFAULT NULL,
deceased_at DATETIME DEFAULT NULL,
first_met_at DATETIME DEFAULT NULL,
facebook_id VARCHAR(255) DEFAULT NULL,
facebook_url LONGTEXT DEFAULT NULL,
blood_type VARCHAR(2) DEFAULT NULL,
blood_type_rhd VARCHAR(1) DEFAULT NULL,
default_event_type SMALLINT DEFAULT 1000,
comment LONGTEXT DEFAULT NULL,
created_at DATETIME DEFAULT NULL,
updated_at DATETIME DEFAULT NULL,
deleted_at DATETIME DEFAULT NULL,
INDEX IDX_B8B005C939E6FA16 (old_id),
INDEX IDX_B8B005C9A76ED395 (user_id),
INDEX IDX_B8B005C94AF38FD1 (deleted_at),
PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');

        $this->addSql('ALTER TABLE persons2_persons ADD CONSTRAINT FK_B8B005C9A76ED395 FOREIGN KEY (user_id) REFERENCES persons2_fos_user (id)');

        if ($schema->hasTable('persons_persons')) {
            $this->addSql('INSERT INTO `persons2_persons` (old_id, name, last_name, last_name_born, middle_name, first_name, nick_name, gender, birthday, deceased_at, first_met_at, facebook_id, facebook_url, blood_type, blood_type_rhd, default_event_type, comment, created_at, updated_at, deleted_at, user_id)
SELECT id, name, last_name, last_name_born, middle_name, first_name, nick_name, gender, birthday, deceased_at, first_met_at, facebook_id, facebook_url, blood_type, blood_type_rhd, default_event_type, comment, created_at, updated_at, deleted_at, (SELECT u2.id FROM persons2_fos_user u2 WHERE u2.old_id = p1.user_id) AS u2_id
FROM `persons_persons` AS p1;');
        }
    }

    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE persons2_persons');
    }
}
