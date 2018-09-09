<?php declare(strict_types=1);

/**
 * Remove old tables.
 */

namespace TheFox\PersonsBundle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20180715104348 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('SELECT 1;');

        $tables = [
            'persons_person_events',
            'persons_persons',
            'persons_users',
        ];
        foreach ($tables as $tableName) {
            if ($schema->hasTable($tableName)) {
                $this->addSql(sprintf('DROP TABLE %s;',$tableName));
            }
        }
    }

    public function down(Schema $schema): void
    {
        $this->abortIf(true, 'You cannot go back.');
    }
}
