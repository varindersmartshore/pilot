<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210903073815 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lists ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE lists ADD CONSTRAINT FK_8269FA5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8269FA5A76ED395 ON lists (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lists DROP FOREIGN KEY FK_8269FA5A76ED395');
        $this->addSql('DROP INDEX IDX_8269FA5A76ED395 ON lists');
        $this->addSql('ALTER TABLE lists DROP user_id');
    }
}
