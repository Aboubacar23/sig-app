<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240610174522 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE depense_camion (id INT AUTO_INCREMENT NOT NULL, camion_id INT DEFAULT NULL, banque VARCHAR(255) NOT NULL, montant DOUBLE PRECISION DEFAULT NULL, date_depense DATE NOT NULL, mode_paiement VARCHAR(255) DEFAULT NULL, numero_cheque VARCHAR(255) DEFAULT NULL, ordre_de VARCHAR(255) DEFAULT NULL, observation LONGTEXT DEFAULT NULL, INDEX IDX_F55E902B3A706D3 (camion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recette_camion (id INT AUTO_INCREMENT NOT NULL, camion_id INT DEFAULT NULL, montant_transport DOUBLE PRECISION NOT NULL, mode_paiement VARCHAR(255) DEFAULT NULL, date_recette DATE NOT NULL, depart VARCHAR(255) NOT NULL, banque VARCHAR(255) DEFAULT NULL, numero_cheque VARCHAR(255) DEFAULT NULL, destination VARCHAR(255) DEFAULT NULL, type_tc VARCHAR(255) NOT NULL, observation LONGTEXT DEFAULT NULL, INDEX IDX_4445A4153A706D3 (camion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE depense_camion ADD CONSTRAINT FK_F55E902B3A706D3 FOREIGN KEY (camion_id) REFERENCES camion (id)');
        $this->addSql('ALTER TABLE recette_camion ADD CONSTRAINT FK_4445A4153A706D3 FOREIGN KEY (camion_id) REFERENCES camion (id)');
        $this->addSql('ALTER TABLE camion ADD numero_camion VARCHAR(255) NOT NULL, ADD chauffeur VARCHAR(255) NOT NULL, ADD model VARCHAR(255) NOT NULL, ADD marque VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE depense_camion DROP FOREIGN KEY FK_F55E902B3A706D3');
        $this->addSql('ALTER TABLE recette_camion DROP FOREIGN KEY FK_4445A4153A706D3');
        $this->addSql('DROP TABLE depense_camion');
        $this->addSql('DROP TABLE recette_camion');
        $this->addSql('ALTER TABLE camion DROP numero_camion, DROP chauffeur, DROP model, DROP marque');
    }
}
