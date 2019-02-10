<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190209134424 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE users ADD books_id INT DEFAULT NULL, CHANGE code code INT NOT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E97DD8AC20 FOREIGN KEY (books_id) REFERENCES books (id)');
        $this->addSql('CREATE INDEX IDX_1483A5E97DD8AC20 ON users (books_id)');
        $this->addSql('ALTER TABLE books DROP FOREIGN KEY FK_4A1B2A9267B3B43D');
        $this->addSql('DROP INDEX IDX_4A1B2A9267B3B43D ON books');
        $this->addSql('ALTER TABLE books DROP users_id, DROP user_historical');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE books ADD users_id INT DEFAULT NULL, ADD user_historical VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE books ADD CONSTRAINT FK_4A1B2A9267B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_4A1B2A9267B3B43D ON books (users_id)');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E97DD8AC20');
        $this->addSql('DROP INDEX IDX_1483A5E97DD8AC20 ON users');
        $this->addSql('ALTER TABLE users DROP books_id, CHANGE code code VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
