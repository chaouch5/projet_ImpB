<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220801123519 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Actualité (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(30) NOT NULL, text LONGTEXT NOT NULL, photo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Categorie (id INT AUTO_INCREMENT NOT NULL, nomC VARCHAR(254) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Contact (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(30) NOT NULL, email VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, machine VARCHAR(255) NOT NULL, date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Feedback (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(30) NOT NULL, email VARCHAR(255) NOT NULL, feedback LONGTEXT NOT NULL, date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Presentation (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(30) NOT NULL, text LONGTEXT NOT NULL, photo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Produit (id INT AUTO_INCREMENT NOT NULL, categorie INT DEFAULT NULL, nom VARCHAR(30) NOT NULL, prix INT NOT NULL, description LONGTEXT NOT NULL, photo VARCHAR(255) NOT NULL, INDEX IDX_E618D5BB497DD634 (categorie), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Promotion (id INT AUTO_INCREMENT NOT NULL, photo VARCHAR(254) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE User (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(30) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Produit ADD CONSTRAINT FK_E618D5BB497DD634 FOREIGN KEY (categorie) REFERENCES Categorie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Produit DROP FOREIGN KEY FK_E618D5BB497DD634');
        $this->addSql('DROP TABLE Actualité');
        $this->addSql('DROP TABLE Categorie');
        $this->addSql('DROP TABLE Contact');
        $this->addSql('DROP TABLE Feedback');
        $this->addSql('DROP TABLE Presentation');
        $this->addSql('DROP TABLE Produit');
        $this->addSql('DROP TABLE Promotion');
        $this->addSql('DROP TABLE User');
    }
}
