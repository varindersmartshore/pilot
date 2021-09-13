<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210913091009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE items (id INT AUTO_INCREMENT NOT NULL, list_id_id INT NOT NULL, item_name VARCHAR(255) NOT NULL, color VARCHAR(255) DEFAULT NULL, order_by NUMERIC(10, 0) NOT NULL, INDEX IDX_E11EE94DA6D70A54 (list_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lists (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, list_name VARCHAR(255) NOT NULL, INDEX IDX_8269FA5A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, profile VARCHAR(255) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, verification_token VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, status INT DEFAULT 1 NOT NULL, profile VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94DA6D70A54 FOREIGN KEY (list_id_id) REFERENCES lists (id)');
        $this->addSql('ALTER TABLE lists ADD CONSTRAINT FK_8269FA5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94DA6D70A54');
        $this->addSql('ALTER TABLE lists DROP FOREIGN KEY FK_8269FA5A76ED395');
        $this->addSql('DROP TABLE items');
        $this->addSql('DROP TABLE lists');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE users');
    }
}
