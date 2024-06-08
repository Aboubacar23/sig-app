<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240608115337 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE approvisionnement (id INT AUTO_INCREMENT NOT NULL, quantite INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE banque (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE camion (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, code_client VARCHAR(255) DEFAULT NULL, etat TINYINT(1) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, telephone INT DEFAULT NULL, contact VARCHAR(255) DEFAULT NULL, pays VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_client (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, code_commande VARCHAR(255) DEFAULT NULL, numero_reference VARCHAR(255) DEFAULT NULL, date_commande DATE DEFAULT NULL, type_commande VARCHAR(255) DEFAULT NULL, etat TINYINT(1) DEFAULT NULL, note LONGTEXT DEFAULT NULL, paiement_date DATE DEFAULT NULL, reception_date DATE DEFAULT NULL, flag TINYINT(1) DEFAULT NULL, INDEX IDX_C510FF8019EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_fournisseur (id INT AUTO_INCREMENT NOT NULL, fournisseur_id INT DEFAULT NULL, numero_commande VARCHAR(255) DEFAULT NULL, date_commande DATE DEFAULT NULL, paiement_date DATE DEFAULT NULL, paiement_mode VARCHAR(255) DEFAULT NULL, expedition_mode VARCHAR(255) DEFAULT NULL, etat TINYINT(1) DEFAULT NULL, note LONGTEXT DEFAULT NULL, INDEX IDX_7F6F4F53670C757F (fournisseur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entrepot (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) DEFAULT NULL, pays VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, telephone INT DEFAULT NULL, description LONGTEXT DEFAULT NULL, etat TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture_client (id INT AUTO_INCREMENT NOT NULL, commande_id INT DEFAULT NULL, numero_facture VARCHAR(255) DEFAULT NULL, date_facturation DATE DEFAULT NULL, paiement TINYINT(1) DEFAULT NULL, condition_paiement VARCHAR(255) DEFAULT NULL, mode_paiement VARCHAR(255) DEFAULT NULL, avance DOUBLE PRECISION DEFAULT NULL, remise DOUBLE PRECISION DEFAULT NULL, somme DOUBLE PRECISION DEFAULT NULL, INDEX IDX_92D316F282EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture_fournisseur (id INT AUTO_INCREMENT NOT NULL, commande_id INT DEFAULT NULL, numero_facture VARCHAR(255) DEFAULT NULL, reference_paiement VARCHAR(255) DEFAULT NULL, date_limite_paiement DATE DEFAULT NULL, etat_paiement TINYINT(1) DEFAULT NULL, condition_paiement VARCHAR(255) DEFAULT NULL, date_facturation DATE DEFAULT NULL, note LONGTEXT DEFAULT NULL, INDEX IDX_311911C482EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fournisseur (id INT AUTO_INCREMENT NOT NULL, code_fournisseur VARCHAR(255) DEFAULT NULL, societe VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, telephone INT DEFAULT NULL, pays VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, fax INT DEFAULT NULL, etat TINYINT(1) DEFAULT NULL, note LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lcommande_client (id INT AUTO_INCREMENT NOT NULL, produit_id INT DEFAULT NULL, num_commande_id INT DEFAULT NULL, quantite INT DEFAULT NULL, tva DOUBLE PRECISION DEFAULT NULL, lig VARCHAR(255) DEFAULT NULL, remise DOUBLE PRECISION DEFAULT NULL, INDEX IDX_601BE97DF347EFB (produit_id), INDEX IDX_601BE97DF80F63BC (num_commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lcommande_fournisseur (id INT AUTO_INCREMENT NOT NULL, produit_id INT DEFAULT NULL, num_commande_id INT DEFAULT NULL, quantite INT DEFAULT NULL, tva DOUBLE PRECISION DEFAULT NULL, lig VARCHAR(255) DEFAULT NULL, remise DOUBLE PRECISION DEFAULT NULL, INDEX IDX_659C74B1F347EFB (produit_id), INDEX IDX_659C74B1F80F63BC (num_commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livraison (id INT AUTO_INCREMENT NOT NULL, facture_id INT DEFAULT NULL, num_livraison VARCHAR(255) DEFAULT NULL, date_livraison DATE DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, INDEX IDX_A60C9F1F7F2DEE08 (facture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personnel (id INT AUTO_INCREMENT NOT NULL, code_personnel VARCHAR(255) DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, tel INT DEFAULT NULL, pays VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, fournisseur_id INT DEFAULT NULL, entrepot_id INT DEFAULT NULL, code_produit VARCHAR(255) DEFAULT NULL, libelle VARCHAR(255) DEFAULT NULL, prix_achat DOUBLE PRECISION DEFAULT NULL, prix_vente DOUBLE PRECISION DEFAULT NULL, key_produit VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, stock_initial DOUBLE PRECISION DEFAULT NULL, quantite DOUBLE PRECISION DEFAULT NULL, poids DOUBLE PRECISION DEFAULT NULL, volume VARCHAR(255) DEFAULT NULL, couleur VARCHAR(255) DEFAULT NULL, etat VARCHAR(255) DEFAULT NULL, reference VARCHAR(255) DEFAULT NULL, desciption LONGTEXT DEFAULT NULL, taux DOUBLE PRECISION DEFAULT NULL, INDEX IDX_29A5EC27670C757F (fournisseur_id), INDEX IDX_29A5EC2772831E97 (entrepot_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) DEFAULT NULL, periodique TINYINT(1) DEFAULT NULL, prix DOUBLE PRECISION DEFAULT NULL, taxe DOUBLE PRECISION DEFAULT NULL, reference VARCHAR(255) DEFAULT NULL, desciption LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, tel INT DEFAULT NULL, pays VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE versement (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, banque_id INT DEFAULT NULL, facture_id INT DEFAULT NULL, montant DOUBLE PRECISION DEFAULT NULL, date_versement DATE DEFAULT NULL, avance TINYINT(1) DEFAULT NULL, type_reglement VARCHAR(255) DEFAULT NULL, delegue VARCHAR(255) DEFAULT NULL, emetteur_cheque VARCHAR(255) DEFAULT NULL, INDEX IDX_716E936719EB6921 (client_id), INDEX IDX_716E936737E080D9 (banque_id), INDEX IDX_716E93677F2DEE08 (facture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande_client ADD CONSTRAINT FK_C510FF8019EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE commande_fournisseur ADD CONSTRAINT FK_7F6F4F53670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id)');
        $this->addSql('ALTER TABLE facture_client ADD CONSTRAINT FK_92D316F282EA2E54 FOREIGN KEY (commande_id) REFERENCES commande_client (id)');
        $this->addSql('ALTER TABLE facture_fournisseur ADD CONSTRAINT FK_311911C482EA2E54 FOREIGN KEY (commande_id) REFERENCES commande_fournisseur (id)');
        $this->addSql('ALTER TABLE lcommande_client ADD CONSTRAINT FK_601BE97DF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE lcommande_client ADD CONSTRAINT FK_601BE97DF80F63BC FOREIGN KEY (num_commande_id) REFERENCES commande_client (id)');
        $this->addSql('ALTER TABLE lcommande_fournisseur ADD CONSTRAINT FK_659C74B1F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE lcommande_fournisseur ADD CONSTRAINT FK_659C74B1F80F63BC FOREIGN KEY (num_commande_id) REFERENCES commande_fournisseur (id)');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1F7F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture_client (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC2772831E97 FOREIGN KEY (entrepot_id) REFERENCES entrepot (id)');
        $this->addSql('ALTER TABLE versement ADD CONSTRAINT FK_716E936719EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE versement ADD CONSTRAINT FK_716E936737E080D9 FOREIGN KEY (banque_id) REFERENCES banque (id)');
        $this->addSql('ALTER TABLE versement ADD CONSTRAINT FK_716E93677F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture_client (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande_client DROP FOREIGN KEY FK_C510FF8019EB6921');
        $this->addSql('ALTER TABLE commande_fournisseur DROP FOREIGN KEY FK_7F6F4F53670C757F');
        $this->addSql('ALTER TABLE facture_client DROP FOREIGN KEY FK_92D316F282EA2E54');
        $this->addSql('ALTER TABLE facture_fournisseur DROP FOREIGN KEY FK_311911C482EA2E54');
        $this->addSql('ALTER TABLE lcommande_client DROP FOREIGN KEY FK_601BE97DF347EFB');
        $this->addSql('ALTER TABLE lcommande_client DROP FOREIGN KEY FK_601BE97DF80F63BC');
        $this->addSql('ALTER TABLE lcommande_fournisseur DROP FOREIGN KEY FK_659C74B1F347EFB');
        $this->addSql('ALTER TABLE lcommande_fournisseur DROP FOREIGN KEY FK_659C74B1F80F63BC');
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1F7F2DEE08');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27670C757F');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC2772831E97');
        $this->addSql('ALTER TABLE versement DROP FOREIGN KEY FK_716E936719EB6921');
        $this->addSql('ALTER TABLE versement DROP FOREIGN KEY FK_716E936737E080D9');
        $this->addSql('ALTER TABLE versement DROP FOREIGN KEY FK_716E93677F2DEE08');
        $this->addSql('DROP TABLE approvisionnement');
        $this->addSql('DROP TABLE banque');
        $this->addSql('DROP TABLE camion');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE commande_client');
        $this->addSql('DROP TABLE commande_fournisseur');
        $this->addSql('DROP TABLE entrepot');
        $this->addSql('DROP TABLE facture_client');
        $this->addSql('DROP TABLE facture_fournisseur');
        $this->addSql('DROP TABLE fournisseur');
        $this->addSql('DROP TABLE lcommande_client');
        $this->addSql('DROP TABLE lcommande_fournisseur');
        $this->addSql('DROP TABLE livraison');
        $this->addSql('DROP TABLE personnel');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE versement');
    }
}
