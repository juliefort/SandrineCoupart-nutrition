<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240307082340 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recipes_allergens (recipes_id INT NOT NULL, allergens_id INT NOT NULL, INDEX IDX_EF93A5DAFDF2B1FA (recipes_id), INDEX IDX_EF93A5DA711662F1 (allergens_id), PRIMARY KEY(recipes_id, allergens_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipes_diet (recipes_id INT NOT NULL, diet_id INT NOT NULL, INDEX IDX_A6BC0469FDF2B1FA (recipes_id), INDEX IDX_A6BC0469E1E13ACE (diet_id), PRIMARY KEY(recipes_id, diet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recipes_allergens ADD CONSTRAINT FK_EF93A5DAFDF2B1FA FOREIGN KEY (recipes_id) REFERENCES recipes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipes_allergens ADD CONSTRAINT FK_EF93A5DA711662F1 FOREIGN KEY (allergens_id) REFERENCES allergens (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipes_diet ADD CONSTRAINT FK_A6BC0469FDF2B1FA FOREIGN KEY (recipes_id) REFERENCES recipes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipes_diet ADD CONSTRAINT FK_A6BC0469E1E13ACE FOREIGN KEY (diet_id) REFERENCES diet (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recipes_allergens DROP FOREIGN KEY FK_EF93A5DAFDF2B1FA');
        $this->addSql('ALTER TABLE recipes_allergens DROP FOREIGN KEY FK_EF93A5DA711662F1');
        $this->addSql('ALTER TABLE recipes_diet DROP FOREIGN KEY FK_A6BC0469FDF2B1FA');
        $this->addSql('ALTER TABLE recipes_diet DROP FOREIGN KEY FK_A6BC0469E1E13ACE');
        $this->addSql('DROP TABLE recipes_allergens');
        $this->addSql('DROP TABLE recipes_diet');
    }
}
