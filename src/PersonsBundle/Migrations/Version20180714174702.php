<?php declare(strict_types=1);

/**
 * Remove old tables.
 */

namespace TheFox\PersonsBundle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20180714174702 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('SELECT 1;');

        $tables = [
            'persons_password_resets',
            'persons_sessions',
            'persons_migrations',
        ];
        foreach ($tables as $tableName) {
            if ($schema->hasTable($tableName)) {
                $schema->dropTable($tableName);
            }
        }
    }

    public function down(Schema $schema): void
    {
        $this->abortIf(true, 'You cannot go back.');
    }
}
