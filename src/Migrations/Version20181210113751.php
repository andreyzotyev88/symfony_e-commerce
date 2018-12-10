<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181210113751 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE basket DROP INDEX UNIQ_2246507BA76ED395, ADD INDEX IDX_2246507BA76ED395 (user_id)');
        $this->addSql('ALTER TABLE basket DROP INDEX UNIQ_2246507B4584665A, ADD INDEX IDX_2246507B4584665A (product_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles TEXT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE basket DROP INDEX IDX_2246507BA76ED395, ADD UNIQUE INDEX UNIQ_2246507BA76ED395 (user_id)');
        $this->addSql('ALTER TABLE basket DROP INDEX IDX_2246507B4584665A, ADD UNIQUE INDEX UNIQ_2246507B4584665A (product_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles TEXT NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
