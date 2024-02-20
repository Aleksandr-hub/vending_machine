<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240219197675 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("INSERT INTO vending_machine.coin (id, denomination, quantity) VALUES (1, 0.01, 0);
INSERT INTO vending_machine.coin (id, denomination, quantity) VALUES (2, 0.05, 0);
INSERT INTO vending_machine.coin (id, denomination, quantity) VALUES (3, 0.1, 0);
INSERT INTO vending_machine.coin (id, denomination, quantity) VALUES (4, 0.25, 0);
INSERT INTO vending_machine.coin (id, denomination, quantity) VALUES (5, 0.50, 0);
INSERT INTO vending_machine.coin (id, denomination, quantity) VALUES (6, 1, 0);

");
     }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('Delete * From vending_machine.coin');
    }
}
