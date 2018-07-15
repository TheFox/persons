<?php declare(strict_types=1);

/**
 * Migrate User.
 */

namespace TheFox\PersonsBundle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20180714175034 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('SELECT 1;');

        if ($schema->hasTable('persons_users')) {
            $this->addSql('INSERT INTO `persons2_fos_user` (old_id, username, username_canonical, email, email_canonical, enabled, password, gender, roles, created_at, updated_at)
SELECT id, email, email, email, email, 1, password, "u", "a:0:{}", created_at, updated_at FROM `persons_users`;');
        }
    }

    public function down(Schema $schema): void
    {
        $this->abortIf(true, 'You cannot go back.');
    }
}
