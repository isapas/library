<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190205151325 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE users ADD books_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E97DD8AC20 FOREIGN KEY (books_id) REFERENCES books (id)');
        $this->addSql('CREATE INDEX IDX_1483A5E97DD8AC20 ON users (books_id)');
        $this->addSql('ALTER TABLE books CHANGE borrow_date borrow_date DATE DEFAULT NULL, CHANGE return_date return_date DATE DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE books CHANGE borrow_date borrow_date DATETIME DEFAULT NULL, CHANGE return_date return_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E97DD8AC20');
        $this->addSql('DROP INDEX IDX_1483A5E97DD8AC20 ON users');
        $this->addSql('ALTER TABLE users DROP books_id');
    }
}
