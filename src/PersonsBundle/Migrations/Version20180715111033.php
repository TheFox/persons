<?php declare(strict_types=1);

/**
 * Clean up.
 */

namespace TheFox\PersonsBundle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20180715111033 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX IDX_680271C139E6FA16 ON persons2_fos_user');
        $this->addSql('ALTER TABLE persons2_fos_user DROP old_id');
        $this->addSql('DROP INDEX IDX_6591305E39E6FA16 ON persons2_events');
        $this->addSql('ALTER TABLE persons2_events DROP old_id');
        $this->addSql('DROP INDEX IDX_B8B005C939E6FA16 ON persons2_persons');
        $this->addSql('ALTER TABLE persons2_persons DROP old_id');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE persons2_events ADD old_id INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_6591305E39E6FA16 ON persons2_events (old_id)');
        $this->addSql('ALTER TABLE persons2_fos_user ADD old_id INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_680271C139E6FA16 ON persons2_fos_user (old_id)');
        $this->addSql('ALTER TABLE persons2_persons ADD old_id INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_B8B005C939E6FA16 ON persons2_persons (old_id)');
    }
}
