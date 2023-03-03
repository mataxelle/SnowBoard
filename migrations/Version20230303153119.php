<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230303153119 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category CHANGE descrition description LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE image CHANGE figure_id figure_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE video CHANGE figure_id figure_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category CHANGE description descrition LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE image CHANGE figure_id figure_id INT NOT NULL');
        $this->addSql('ALTER TABLE video CHANGE figure_id figure_id INT NOT NULL');
    }
}
