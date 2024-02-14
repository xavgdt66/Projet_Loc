<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240212153927 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE review CHANGE nom_agence nom_agence VARCHAR(555) NOT NULL');
        $this->addSql('ALTER TABLE user ADD reviews VARCHAR(555) NOT NULL, DROP numero_rue, DROP nom_rue, DROP image_size');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE review CHANGE nom_agence nom_agence VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD numero_rue INT DEFAULT NULL, ADD nom_rue VARCHAR(555) DEFAULT NULL, ADD image_size INT DEFAULT NULL, DROP reviews');
    }
}
