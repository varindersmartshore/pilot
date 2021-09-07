<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210906083621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94D3DAE168B');
        $this->addSql('DROP INDEX IDX_E11EE94D3DAE168B ON items');
        $this->addSql('ALTER TABLE items CHANGE list_id list_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94DA6D70A54 FOREIGN KEY (list_id_id) REFERENCES lists (id)');
        $this->addSql('CREATE INDEX IDX_E11EE94DA6D70A54 ON items (list_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94DA6D70A54');
        $this->addSql('DROP INDEX IDX_E11EE94DA6D70A54 ON items');
        $this->addSql('ALTER TABLE items CHANGE list_id_id list_id INT NOT NULL');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94D3DAE168B FOREIGN KEY (list_id) REFERENCES lists (id)');
        $this->addSql('CREATE INDEX IDX_E11EE94D3DAE168B ON items (list_id)');
    }
}
