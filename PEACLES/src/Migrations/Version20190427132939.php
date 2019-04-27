<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190427132939 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE restaurant_specialty (restaurant_id INT NOT NULL, specialty_id INT NOT NULL, INDEX IDX_D0F3FCCBB1E7706E (restaurant_id), INDEX IDX_D0F3FCCB9A353316 (specialty_id), PRIMARY KEY(restaurant_id, specialty_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE restaurant_specialty ADD CONSTRAINT FK_D0F3FCCBB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE restaurant_specialty ADD CONSTRAINT FK_D0F3FCCB9A353316 FOREIGN KEY (specialty_id) REFERENCES specialty (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE pictures');
        $this->addSql('ALTER TABLE reservation ADD infos_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955544A4CCA FOREIGN KEY (infos_id) REFERENCES reservation_infos (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_42C84955544A4CCA ON reservation (infos_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE pictures (id INT AUTO_INCREMENT NOT NULL, img_url VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, caption LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, owner INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE restaurant_specialty');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955544A4CCA');
        $this->addSql('DROP INDEX UNIQ_42C84955544A4CCA ON reservation');
        $this->addSql('ALTER TABLE reservation DROP infos_id');
    }
}
