<?php declare(strict_types=1);

namespace TheFox\PersonsBundle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180915165750 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE INDEX IDX_B8B005C9C7470A42 ON persons2_persons (gender)');
        $this->addSql('CREATE INDEX IDX_B8B005C9482EAEC5 ON persons2_persons (deceased_at)');
        $this->addSql('CREATE INDEX IDX_B8B005C91CBD5E87 ON persons2_persons (first_met_at)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX IDX_B8B005C9C7470A42 ON persons2_persons');
        $this->addSql('DROP INDEX IDX_B8B005C9482EAEC5 ON persons2_persons');
        $this->addSql('DROP INDEX IDX_B8B005C91CBD5E87 ON persons2_persons');
    }
}
