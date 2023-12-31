<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231228184629 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        //$this->addSql('ALTER TABLE user ADD email VARCHAR(180) NOT NULL, ADD first_name VARCHAR(50) NOT NULL, ADD last_name VARCHAR(50) NOT NULL, ADD telephone INT NOT NULL, ADD address VARCHAR(1000) NOT NULL, ADD presentation VARCHAR(1000) NOT NULL, ADD net_income INT NOT NULL, ADD nom_agence VARCHAR(100) DEFAULT NULL, ADD numero_rue INT DEFAULT NULL, ADD code_postal INT DEFAULT NULL, ADD ville VARCHAR(60) DEFAULT NULL, ADD carte_professionnelle INT DEFAULT NULL, ADD siren INT DEFAULT NULL, ADD siret INT DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        //$this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('ALTER TABLE user DROP email, DROP first_name, DROP last_name, DROP telephone, DROP address, DROP presentation, DROP net_income, DROP nom_agence, DROP numero_rue, DROP code_postal, DROP ville, DROP carte_professionnelle, DROP siren, DROP siret, DROP updated_at');
    }
}
