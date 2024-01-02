<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240102170709 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user CHANGE employement_status employement_status VARCHAR(555) NOT NULL, CHANGE guarantee guarantee VARCHAR(255) NOT NULL, CHANGE carte_professionnelle carte_professionnelle VARCHAR(17) DEFAULT NULL, CHANGE siret siret VARCHAR(14) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user CHANGE employement_status employement_status VARCHAR(555) DEFAULT NULL, CHANGE guarantee guarantee VARCHAR(555) DEFAULT NULL, CHANGE carte_professionnelle carte_professionnelle INT DEFAULT NULL, CHANGE siret siret INT DEFAULT NULL');
    }
}
