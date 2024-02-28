<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240228105525 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE saisons DROP FOREIGN KEY FK_1F1539CBDC2902E0');
        $this->addSql('DROP INDEX IDX_1F1539CBDC2902E0 ON saisons');
        $this->addSql('ALTER TABLE saisons DROP client_id_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE saisons ADD client_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE saisons ADD CONSTRAINT FK_1F1539CBDC2902E0 FOREIGN KEY (client_id_id) REFERENCES clients (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_1F1539CBDC2902E0 ON saisons (client_id_id)');
    }
}
