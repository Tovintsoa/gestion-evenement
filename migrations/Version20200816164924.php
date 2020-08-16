<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200816164924 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, nom_evenement VARCHAR(255) NOT NULL, description_evenement VARCHAR(255) NOT NULL, budget_evenement DOUBLE PRECISION NOT NULL, date_debut_evenement DATETIME NOT NULL, date_fin_evenement DATETIME DEFAULT NULL, lieu_evenement JSON NOT NULL, type_evenement JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lieu_evenement (id INT AUTO_INCREMENT NOT NULL, nom_lieu_evenement VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photos_evenement (id INT AUTO_INCREMENT NOT NULL, evenements_id INT NOT NULL, image_evenement VARCHAR(255) NOT NULL, INDEX IDX_86583A1B63C02CD4 (evenements_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_evenement (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom_utilisateur VARCHAR(255) DEFAULT NULL, prenom_utilisateur VARCHAR(255) NOT NULL, login_utilisateur VARCHAR(255) NOT NULL, mail_utilisateur VARCHAR(255) NOT NULL, telephone_utilisateur VARCHAR(255) DEFAULT NULL, motdepasse_utilisateur VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE photos_evenement ADD CONSTRAINT FK_86583A1B63C02CD4 FOREIGN KEY (evenements_id) REFERENCES evenement (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photos_evenement DROP FOREIGN KEY FK_86583A1B63C02CD4');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE lieu_evenement');
        $this->addSql('DROP TABLE photos_evenement');
        $this->addSql('DROP TABLE type_evenement');
        $this->addSql('DROP TABLE utilisateur');
    }
}
