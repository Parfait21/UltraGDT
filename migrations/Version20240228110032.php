<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240228110032 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE saisons_clients (saisons_id INT NOT NULL, clients_id INT NOT NULL, INDEX IDX_DF1CE79298E2D5DF (saisons_id), INDEX IDX_DF1CE792AB014612 (clients_id), PRIMARY KEY(saisons_id, clients_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE saisons_clients ADD CONSTRAINT FK_DF1CE79298E2D5DF FOREIGN KEY (saisons_id) REFERENCES saisons (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE saisons_clients ADD CONSTRAINT FK_DF1CE792AB014612 FOREIGN KEY (clients_id) REFERENCES clients (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE saisons_clients DROP FOREIGN KEY FK_DF1CE79298E2D5DF');
        $this->addSql('ALTER TABLE saisons_clients DROP FOREIGN KEY FK_DF1CE792AB014612');
        $this->addSql('DROP TABLE saisons_clients');
    }
}
