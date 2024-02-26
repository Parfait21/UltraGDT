<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240226053104 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE photos');
        $this->addSql('ALTER TABLE clients DROP saison');
        $this->addSql('ALTER TABLE dossier_tech ADD file VARCHAR(100) NOT NULL, CHANGE date_ok_pord date_creat DATE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE photos (id INT AUTO_INCREMENT NOT NULL, file VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE clients ADD saison VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE dossier_tech DROP file, CHANGE date_creat date_ok_pord DATE NOT NULL');
    }
}
