<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240229061800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dossier_tech DROP FOREIGN KEY FK_A86F161CB7B5AFE');
        $this->addSql('DROP INDEX IDX_A86F161CB7B5AFE ON dossier_tech');
        $this->addSql('ALTER TABLE dossier_tech CHANGE saison_id_id nom_saison_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE dossier_tech ADD CONSTRAINT FK_A86F1616D94300D FOREIGN KEY (nom_saison_id) REFERENCES saisons (id)');
        $this->addSql('CREATE INDEX IDX_A86F1616D94300D ON dossier_tech (nom_saison_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dossier_tech DROP FOREIGN KEY FK_A86F1616D94300D');
        $this->addSql('DROP INDEX IDX_A86F1616D94300D ON dossier_tech');
        $this->addSql('ALTER TABLE dossier_tech CHANGE nom_saison_id saison_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE dossier_tech ADD CONSTRAINT FK_A86F161CB7B5AFE FOREIGN KEY (saison_id_id) REFERENCES saisons (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_A86F161CB7B5AFE ON dossier_tech (saison_id_id)');
    }
}
