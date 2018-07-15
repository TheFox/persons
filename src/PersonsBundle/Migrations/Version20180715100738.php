<?php declare(strict_types=1);

/**
 * Migrate Events.
 */

namespace TheFox\PersonsBundle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20180715100738 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE persons2_events (
id INT AUTO_INCREMENT NOT NULL,
old_id INT DEFAULT NULL,
person_id INT DEFAULT NULL,
happened_at DATETIME DEFAULT NULL,
type SMALLINT UNSIGNED DEFAULT 1000 NOT NULL,
place VARCHAR(255) DEFAULT NULL,
title VARCHAR(255) DEFAULT NULL,
comment LONGTEXT DEFAULT NULL,
created_at DATETIME DEFAULT NULL,
updated_at DATETIME DEFAULT NULL,
deleted_at DATETIME DEFAULT NULL,
INDEX IDX_6591305E39E6FA16 (old_id),
INDEX IDX_6591305E217BBB47 (person_id),
INDEX IDX_6591305E4AF38FD1 (deleted_at),
PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');

        $this->addSql('ALTER TABLE persons2_events ADD CONSTRAINT FK_6591305E217BBB47 FOREIGN KEY (person_id) REFERENCES persons2_persons (id)');

        if ($schema->hasTable('persons_person_events')) {
            $this->addSql('INSERT INTO `persons2_events` (old_id, happened_at, type, place, title, comment, created_at, updated_at, deleted_at, person_id)
SELECT id, happened_at, type, place, title, comment, created_at, updated_at, deleted_at, (
    SELECT p2.id FROM persons2_persons p2 WHERE p2.old_id = e1.person_id LIMIT 1
) AS p2_id
FROM `persons_person_events` AS e1;');
        }
    }

    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE persons2_events');
    }
}
