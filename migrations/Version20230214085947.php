<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230214085947 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresses (id INT AUTO_INCREMENT NOT NULL, numero INT DEFAULT NULL, voierue VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, codepostal INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE adresses_clients (adresses_id INT NOT NULL, clients_id INT NOT NULL, INDEX IDX_705B2ED485E14726 (adresses_id), INDEX IDX_705B2ED4AB014612 (clients_id), PRIMARY KEY(adresses_id, clients_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adresses_clients ADD CONSTRAINT FK_705B2ED485E14726 FOREIGN KEY (adresses_id) REFERENCES adresses (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE adresses_clients ADD CONSTRAINT FK_705B2ED4AB014612 FOREIGN KEY (clients_id) REFERENCES clients (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresses_clients DROP FOREIGN KEY FK_705B2ED485E14726');
        $this->addSql('ALTER TABLE adresses_clients DROP FOREIGN KEY FK_705B2ED4AB014612');
        $this->addSql('DROP TABLE adresses');
        $this->addSql('DROP TABLE adresses_clients');
    }
}
