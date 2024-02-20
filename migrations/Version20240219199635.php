<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240219199635 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("INSERT INTO vending_machine.product (id, title, price, quantity) VALUES (1, 'Coca-cola', 1.5, 0);
INSERT INTO vending_machine.product (id, title, price, quantity) VALUES (2, 'Snickers', 1.2, 0);
INSERT INTO vending_machine.product (id, title, price, quantity) VALUES (3, 'Lay\'s', 2, 0);
");
     }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('Delete * From vending_machine.product');
    }
}
