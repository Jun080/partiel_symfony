<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240706123924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bulletin (id INT AUTO_INCREMENT NOT NULL, proposition_id INT NOT NULL, vote_id INT NOT NULL, rang INT NOT NULL, INDEX IDX_2B7D8942DB96F9E (proposition_id), INDEX IDX_2B7D894272DCDAFC (vote_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE electeurs (id INT AUTO_INCREMENT NOT NULL, vote_id INT DEFAULT NULL, INDEX IDX_A6C2AB7072DCDAFC (vote_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proposition (id INT AUTO_INCREMENT NOT NULL, theme_id INT NOT NULL, nom VARCHAR(100) NOT NULL, INDEX IDX_C7CDC35359027487 (theme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resultat (id INT AUTO_INCREMENT NOT NULL, position INT NOT NULL, nombre_vote INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, resultat_id INT NOT NULL, theme VARCHAR(255) NOT NULL, nombre_places_gagnantes INT NOT NULL, UNIQUE INDEX UNIQ_9775E708D233E95C (resultat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bulletin ADD CONSTRAINT FK_2B7D8942DB96F9E FOREIGN KEY (proposition_id) REFERENCES proposition (id)');
        $this->addSql('ALTER TABLE bulletin ADD CONSTRAINT FK_2B7D894272DCDAFC FOREIGN KEY (vote_id) REFERENCES vote (id)');
        $this->addSql('ALTER TABLE electeurs ADD CONSTRAINT FK_A6C2AB7072DCDAFC FOREIGN KEY (vote_id) REFERENCES vote (id)');
        $this->addSql('ALTER TABLE proposition ADD CONSTRAINT FK_C7CDC35359027487 FOREIGN KEY (theme_id) REFERENCES theme (id)');
        $this->addSql('ALTER TABLE theme ADD CONSTRAINT FK_9775E708D233E95C FOREIGN KEY (resultat_id) REFERENCES resultat (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bulletin DROP FOREIGN KEY FK_2B7D8942DB96F9E');
        $this->addSql('ALTER TABLE bulletin DROP FOREIGN KEY FK_2B7D894272DCDAFC');
        $this->addSql('ALTER TABLE electeurs DROP FOREIGN KEY FK_A6C2AB7072DCDAFC');
        $this->addSql('ALTER TABLE proposition DROP FOREIGN KEY FK_C7CDC35359027487');
        $this->addSql('ALTER TABLE theme DROP FOREIGN KEY FK_9775E708D233E95C');
        $this->addSql('DROP TABLE bulletin');
        $this->addSql('DROP TABLE electeurs');
        $this->addSql('DROP TABLE proposition');
        $this->addSql('DROP TABLE resultat');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE vote');
    }
}
