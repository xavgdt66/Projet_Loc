<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231215152725 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD last_name VARCHAR(255) NOT NULL, ADD telephone VARCHAR(255) NOT NULL, ADD address VARCHAR(255) NOT NULL, ADD presentation VARCHAR(255) NOT NULL, ADD employement_status VARCHAR(255) NOT NULL, ADD net_income VARCHAR(255) NOT NULL, ADD guarantee VARCHAR(255) NOT NULL, ADD nom_agence VARCHAR(255) NOT NULL, ADD numero_rue VARCHAR(255) NOT NULL, ADD nom_rue VARCHAR(255) NOT NULL, ADD code_postal VARCHAR(255) NOT NULL, ADD ville VARCHAR(255) NOT NULL, ADD carte_professionnelle VARCHAR(255) NOT NULL, ADD siren VARCHAR(255) NOT NULL, ADD siret VARCHAR(255) NOT NULL, ADD kbis VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP last_name, DROP telephone, DROP address, DROP presentation, DROP employement_status, DROP net_income, DROP guarantee, DROP nom_agence, DROP numero_rue, DROP nom_rue, DROP code_postal, DROP ville, DROP carte_professionnelle, DROP siren, DROP siret, DROP kbis');
    }
}
