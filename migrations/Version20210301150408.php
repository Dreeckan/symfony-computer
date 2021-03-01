<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210301150408 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE component (id INT AUTO_INCREMENT NOT NULL, brand VARCHAR(128) NOT NULL, name VARCHAR(128) NOT NULL, price INT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, type VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE computer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(128) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, type VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE computer_has_device (computer_id INT NOT NULL, device_id INT NOT NULL, INDEX IDX_8D2F3019A426D518 (computer_id), INDEX IDX_8D2F301994A4C7D4 (device_id), PRIMARY KEY(computer_id, device_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE computer_has_component (computer_id INT NOT NULL, component_id INT NOT NULL, INDEX IDX_DC7B306BA426D518 (computer_id), INDEX IDX_DC7B306BE2ABAFFF (component_id), PRIMARY KEY(computer_id, component_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE device (id INT AUTO_INCREMENT NOT NULL, brand VARCHAR(128) NOT NULL, description LONGTEXT DEFAULT NULL, name VARCHAR(128) NOT NULL, price INT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, type VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE computer_has_device ADD CONSTRAINT FK_8D2F3019A426D518 FOREIGN KEY (computer_id) REFERENCES computer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE computer_has_device ADD CONSTRAINT FK_8D2F301994A4C7D4 FOREIGN KEY (device_id) REFERENCES device (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE computer_has_component ADD CONSTRAINT FK_DC7B306BA426D518 FOREIGN KEY (computer_id) REFERENCES computer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE computer_has_component ADD CONSTRAINT FK_DC7B306BE2ABAFFF FOREIGN KEY (component_id) REFERENCES component (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE computer_has_component DROP FOREIGN KEY FK_DC7B306BE2ABAFFF');
        $this->addSql('ALTER TABLE computer_has_device DROP FOREIGN KEY FK_8D2F3019A426D518');
        $this->addSql('ALTER TABLE computer_has_component DROP FOREIGN KEY FK_DC7B306BA426D518');
        $this->addSql('ALTER TABLE computer_has_device DROP FOREIGN KEY FK_8D2F301994A4C7D4');
        $this->addSql('DROP TABLE component');
        $this->addSql('DROP TABLE computer');
        $this->addSql('DROP TABLE computer_has_device');
        $this->addSql('DROP TABLE computer_has_component');
        $this->addSql('DROP TABLE device');
    }
}
