<?php declare(strict_types=1);

/**
 * User Groups
 */

namespace TheFox\PersonsBundle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20180630212322 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // User Groups
        $this->addSql('INSERT INTO `persons2_fos_group` (`name`, `roles`) VALUES (\'SuperAdmin\', \'a:1:{i:0;s:16:"ROLE_SUPER_ADMIN";}\');');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM `persons2_fos_group` WHERE `name` = \'SuperAdmin\';');
    }
}
