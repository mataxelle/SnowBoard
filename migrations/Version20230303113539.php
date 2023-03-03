<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230303113539 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE figure (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, created_by_id INT NOT NULL, updated_by_id INT DEFAULT NULL, name VARCHAR(150) NOT NULL, slug VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_2F57B37A12469DE2 (category_id), INDEX IDX_2F57B37AB03A8386 (created_by_id), INDEX IDX_2F57B37A896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, figure_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_C53D045F5C011B5 (figure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE figure ADD CONSTRAINT FK_2F57B37A12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE figure ADD CONSTRAINT FK_2F57B37AB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE figure ADD CONSTRAINT FK_2F57B37A896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F5C011B5 FOREIGN KEY (figure_id) REFERENCES figure (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE figure DROP FOREIGN KEY FK_2F57B37A12469DE2');
        $this->addSql('ALTER TABLE figure DROP FOREIGN KEY FK_2F57B37AB03A8386');
        $this->addSql('ALTER TABLE figure DROP FOREIGN KEY FK_2F57B37A896DBBDE');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F5C011B5');
        $this->addSql('DROP TABLE figure');
        $this->addSql('DROP TABLE image');
    }
}
