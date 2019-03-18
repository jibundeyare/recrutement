<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190314180953 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_8D93D64983A00E68 ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D6493124B5B6 ON user');
        $this->addSql('ALTER TABLE user DROP firstname, DROP lastname');
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC1A76ED395');
        $this->addSql('DROP INDEX IDX_A45BDDC1A76ED395 ON application');
        $this->addSql('ALTER TABLE application ADD firstname VARCHAR(180) NOT NULL, ADD lastname VARCHAR(180) NOT NULL, ADD email VARCHAR(180) NOT NULL, DROP user_id');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A45BDDC183A00E68 ON application (firstname)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A45BDDC13124B5B6 ON application (lastname)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A45BDDC1E7927C74 ON application (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_A45BDDC183A00E68 ON application');
        $this->addSql('DROP INDEX UNIQ_A45BDDC13124B5B6 ON application');
        $this->addSql('DROP INDEX UNIQ_A45BDDC1E7927C74 ON application');
        $this->addSql('ALTER TABLE application ADD user_id INT DEFAULT NULL, DROP firstname, DROP lastname, DROP email');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_A45BDDC1A76ED395 ON application (user_id)');
        $this->addSql('ALTER TABLE user ADD firstname VARCHAR(180) NOT NULL COLLATE utf8mb4_unicode_ci, ADD lastname VARCHAR(180) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64983A00E68 ON user (firstname)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6493124B5B6 ON user (lastname)');
    }
}
