<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190315001803 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_A45BDDC183A00E68 ON application');
        $this->addSql('DROP INDEX UNIQ_A45BDDC1E7927C74 ON application');
        $this->addSql('DROP INDEX UNIQ_A45BDDC13124B5B6 ON application');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE UNIQUE INDEX UNIQ_A45BDDC183A00E68 ON application (firstname)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A45BDDC1E7927C74 ON application (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A45BDDC13124B5B6 ON application (lastname)');
    }
}
