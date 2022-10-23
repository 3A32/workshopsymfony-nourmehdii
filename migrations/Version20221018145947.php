<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221018145947 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD id INT AUTO_INCREMENT NOT NULL, DROP ref, DROP titre, DROP name, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE event ADD category_id INT NOT NULL, ADD titre VARCHAR(100) NOT NULL, DROP title');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA712469DE2 ON event (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON category');
        $this->addSql('ALTER TABLE category ADD ref VARCHAR(100) NOT NULL, ADD titre VARCHAR(100) NOT NULL, ADD name VARCHAR(200) NOT NULL, DROP id');
        $this->addSql('ALTER TABLE category ADD PRIMARY KEY (ref)');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA712469DE2');
        $this->addSql('DROP INDEX IDX_3BAE0AA712469DE2 ON event');
        $this->addSql('ALTER TABLE event ADD title VARCHAR(200) NOT NULL, DROP category_id, DROP titre');
    }
}
