<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240226125806 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dossier_tech ADD saison_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE dossier_tech ADD CONSTRAINT FK_A86F161CB7B5AFE FOREIGN KEY (saison_id_id) REFERENCES saisons (id)');
        $this->addSql('CREATE INDEX IDX_A86F161CB7B5AFE ON dossier_tech (saison_id_id)');
        $this->addSql('ALTER TABLE saisons ADD client_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE saisons ADD CONSTRAINT FK_1F1539CBDC2902E0 FOREIGN KEY (client_id_id) REFERENCES clients (id)');
        $this->addSql('CREATE INDEX IDX_1F1539CBDC2902E0 ON saisons (client_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dossier_tech DROP FOREIGN KEY FK_A86F161CB7B5AFE');
        $this->addSql('DROP INDEX IDX_A86F161CB7B5AFE ON dossier_tech');
        $this->addSql('ALTER TABLE dossier_tech DROP saison_id_id');
        $this->addSql('ALTER TABLE saisons DROP FOREIGN KEY FK_1F1539CBDC2902E0');
        $this->addSql('DROP INDEX IDX_1F1539CBDC2902E0 ON saisons');
        $this->addSql('ALTER TABLE saisons DROP client_id_id');
    }
}
