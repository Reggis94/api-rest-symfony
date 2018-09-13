<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180910020510 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, master_id INT DEFAULT NULL, creditcard_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slogan VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, website_url VARCHAR(255) DEFAULT NULL, picture_url VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_4FBF094F13B3DB11 (master_id), INDEX IDX_4FBF094F82C99CC2 (creditcard_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE creditcard (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, credit_card_type VARCHAR(255) NOT NULL, credit_card_number VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE master (id INT AUTO_INCREMENT NOT NULL, company_id INT DEFAULT NULL, firstname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, api_key VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_2D09A3D6979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094F13B3DB11 FOREIGN KEY (master_id) REFERENCES master (id)');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094F82C99CC2 FOREIGN KEY (creditcard_id) REFERENCES creditcard (id)');
        $this->addSql('ALTER TABLE master ADD CONSTRAINT FK_2D09A3D6979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE master DROP FOREIGN KEY FK_2D09A3D6979B1AD6');
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094F82C99CC2');
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094F13B3DB11');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE creditcard');
        $this->addSql('DROP TABLE master');
    }
}
