<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161228164513 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE invoice (id INT AUTO_INCREMENT NOT NULL, utility_id INT DEFAULT NULL, date DATETIME NOT NULL, value NUMERIC(7, 3) NOT NULL, INDEX IDX_906517447189C2DB (utility_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reading (id INT AUTO_INCREMENT NOT NULL, utility_id INT DEFAULT NULL, value INT NOT NULL, date DATETIME NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_C11AFC417189C2DB (utility_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utility (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_73D1B7675E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utility_rate (id INT AUTO_INCREMENT NOT NULL, utility_id INT DEFAULT NULL, startDate DATE DEFAULT NULL, endDate DATE DEFAULT NULL, value NUMERIC(7, 3) NOT NULL, INDEX IDX_A127E76E7189C2DB (utility_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_906517447189C2DB FOREIGN KEY (utility_id) REFERENCES utility (id)');
        $this->addSql('ALTER TABLE reading ADD CONSTRAINT FK_C11AFC417189C2DB FOREIGN KEY (utility_id) REFERENCES utility (id)');
        $this->addSql('ALTER TABLE utility_rate ADD CONSTRAINT FK_A127E76E7189C2DB FOREIGN KEY (utility_id) REFERENCES utility (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_906517447189C2DB');
        $this->addSql('ALTER TABLE reading DROP FOREIGN KEY FK_C11AFC417189C2DB');
        $this->addSql('ALTER TABLE utility_rate DROP FOREIGN KEY FK_A127E76E7189C2DB');
        $this->addSql('DROP TABLE invoice');
        $this->addSql('DROP TABLE reading');
        $this->addSql('DROP TABLE utility');
        $this->addSql('DROP TABLE utility_rate');
    }
}
