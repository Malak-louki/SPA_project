<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230612161818 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '8 - Entities ajout propriété generalInformation dans classe Announcement';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE announcement ADD general_information LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE user DROP roles');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE announcement DROP general_information');
        $this->addSql('ALTER TABLE `user` ADD roles JSON NOT NULL');
    }
}
