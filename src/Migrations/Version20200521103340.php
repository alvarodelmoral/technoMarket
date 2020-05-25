<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200521103340 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cart ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BA388B7A76ED395 ON cart (user_id)');
        $this->addSql('ALTER TABLE cart_content ADD cart_id INT NOT NULL, ADD producto_id INT NOT NULL');
        $this->addSql('ALTER TABLE cart_content ADD CONSTRAINT FK_51FF8AE1AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('ALTER TABLE cart_content ADD CONSTRAINT FK_51FF8AE7645698E FOREIGN KEY (producto_id) REFERENCES producto (id)');
        $this->addSql('CREATE INDEX IDX_51FF8AE1AD5CDBF ON cart_content (cart_id)');
        $this->addSql('CREATE INDEX IDX_51FF8AE7645698E ON cart_content (producto_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B7A76ED395');
        $this->addSql('DROP INDEX UNIQ_BA388B7A76ED395 ON cart');
        $this->addSql('ALTER TABLE cart DROP user_id');
        $this->addSql('ALTER TABLE cart_content DROP FOREIGN KEY FK_51FF8AE1AD5CDBF');
        $this->addSql('ALTER TABLE cart_content DROP FOREIGN KEY FK_51FF8AE7645698E');
        $this->addSql('DROP INDEX IDX_51FF8AE1AD5CDBF ON cart_content');
        $this->addSql('DROP INDEX IDX_51FF8AE7645698E ON cart_content');
        $this->addSql('ALTER TABLE cart_content DROP cart_id, DROP producto_id');
    }
}
