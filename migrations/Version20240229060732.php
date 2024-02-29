<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240229060732 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE saisons DROP FOREIGN KEY FK_1F1539CB55141174');
        $this->addSql('DROP TABLE saison_defini');
        $this->addSql('DROP INDEX IDX_1F1539CB55141174 ON saisons');
        $this->addSql('ALTER TABLE saisons ADD nom_saison VARCHAR(100) DEFAULT NULL, DROP sd_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE saison_defini (id INT AUTO_INCREMENT NOT NULL, nom_saisons VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE saisons ADD sd_id INT DEFAULT NULL, DROP nom_saison');
        $this->addSql('ALTER TABLE saisons ADD CONSTRAINT FK_1F1539CB55141174 FOREIGN KEY (sd_id) REFERENCES saison_defini (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_1F1539CB55141174 ON saisons (sd_id)');
    }
}
