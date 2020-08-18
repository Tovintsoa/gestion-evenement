<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200818141644 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evenement_lieu_evenement (id INT AUTO_INCREMENT NOT NULL, id_evenement_id INT NOT NULL, id_lieu_evenement_id INT NOT NULL, INDEX IDX_CCA488252C115A61 (id_evenement_id), INDEX IDX_CCA488257F9508D4 (id_lieu_evenement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evenement_lieu_evenement ADD CONSTRAINT FK_CCA488252C115A61 FOREIGN KEY (id_evenement_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE evenement_lieu_evenement ADD CONSTRAINT FK_CCA488257F9508D4 FOREIGN KEY (id_lieu_evenement_id) REFERENCES lieu_evenement (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE evenement_lieu_evenement');
    }
}
