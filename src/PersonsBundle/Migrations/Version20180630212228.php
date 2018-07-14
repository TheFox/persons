<?php declare(strict_types=1);

namespace TheFox\PersonsBundle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180630212228 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE persons2_fos_user (
id INT AUTO_INCREMENT NOT NULL,
old_id INT DEFAULT NULL,
username VARCHAR(180) NOT NULL,
username_canonical VARCHAR(180) NOT NULL,
email VARCHAR(180) NOT NULL,
email_canonical VARCHAR(180) NOT NULL,
enabled TINYINT(1) NOT NULL,
salt VARCHAR(255) DEFAULT NULL,
password VARCHAR(255) NOT NULL,
last_login DATETIME DEFAULT NULL,
confirmation_token VARCHAR(180) DEFAULT NULL,
password_requested_at DATETIME DEFAULT NULL,
roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\',
created_at DATETIME NOT NULL,
updated_at DATETIME NOT NULL,
date_of_birth DATETIME DEFAULT NULL,
firstname VARCHAR(64) DEFAULT NULL,
lastname VARCHAR(64) DEFAULT NULL,
website VARCHAR(64) DEFAULT NULL,
biography VARCHAR(1000) DEFAULT NULL,
gender VARCHAR(1) DEFAULT NULL,
locale VARCHAR(8) DEFAULT NULL,
timezone VARCHAR(64) DEFAULT NULL,
phone VARCHAR(64) DEFAULT NULL,
facebook_uid VARCHAR(255) DEFAULT NULL,
facebook_name VARCHAR(255) DEFAULT NULL,
facebook_data LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\',
twitter_uid VARCHAR(255) DEFAULT NULL,
twitter_name VARCHAR(255) DEFAULT NULL,
twitter_data LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\',
gplus_uid VARCHAR(255) DEFAULT NULL,
gplus_name VARCHAR(255) DEFAULT NULL,
gplus_data LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\',
token VARCHAR(255) DEFAULT NULL,
two_step_code VARCHAR(255) DEFAULT NULL,
UNIQUE INDEX UNIQ_957A647992FC23A8 (username_canonical),
UNIQUE INDEX UNIQ_957A6479A0D96FBF (email_canonical),
UNIQUE INDEX UNIQ_957A6479C05FB297 (confirmation_token),
PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');

        $this->addSql('CREATE TABLE persons2_fos_group (
id INT AUTO_INCREMENT NOT NULL,
name VARCHAR(180) NOT NULL,
roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\',
UNIQUE INDEX UNIQ_4B019DDB5E237E06 (name),
PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');

        $this->addSql('CREATE TABLE persons2_fos_user_user_group (
user_id INT NOT NULL,
group_id INT NOT NULL,
INDEX IDX_B3C77447A76ED395 (user_id),
INDEX IDX_B3C77447FE54D947 (group_id),
PRIMARY KEY(user_id, group_id)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE persons2_fos_user_user_group ADD CONSTRAINT FK_B3C77447A76ED395 FOREIGN KEY (user_id) REFERENCES persons2_fos_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE persons2_fos_user_user_group ADD CONSTRAINT FK_B3C77447FE54D947 FOREIGN KEY (group_id) REFERENCES persons2_fos_group (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE persons2_fos_user_user_group DROP FOREIGN KEY FK_B3C77447A76ED395');
        $this->addSql('ALTER TABLE persons2_fos_user_user_group DROP FOREIGN KEY FK_B3C77447FE54D947');

        $this->addSql('DROP TABLE persons2_fos_user_user_group');
        $this->addSql('DROP TABLE persons2_fos_user');
        $this->addSql('DROP TABLE persons2_fos_group');
    }
}
