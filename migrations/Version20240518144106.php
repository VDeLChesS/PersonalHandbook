<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240518144106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE daily_schedules (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, task_id INT DEFAULT NULL, appointments_id INT DEFAULT NULL, schedule_date DATE DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_B03FC594A76ED395 (user_id), INDEX IDX_B03FC5948DB60186 (task_id), INDEX IDX_B03FC59423F542AE (appointments_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE daily_schedules ADD CONSTRAINT FK_B03FC594A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE daily_schedules ADD CONSTRAINT FK_B03FC5948DB60186 FOREIGN KEY (task_id) REFERENCES tasks (id)');
        $this->addSql('ALTER TABLE daily_schedules ADD CONSTRAINT FK_B03FC59423F542AE FOREIGN KEY (appointments_id) REFERENCES appointments (id)');
        $this->addSql('ALTER TABLE appointments CHANGE end_time end_time TIME DEFAULT NULL');
        $this->addSql('ALTER TABLE suggested_tasks CHANGE picture picture VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE tasks CHANGE due_time due_time TIME DEFAULT NULL, CHANGE picture picture VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE dob dob DATE DEFAULT NULL, CHANGE phone phone VARCHAR(255) DEFAULT NULL, CHANGE picture picture VARCHAR(255) DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE daily_schedules DROP FOREIGN KEY FK_B03FC594A76ED395');
        $this->addSql('ALTER TABLE daily_schedules DROP FOREIGN KEY FK_B03FC5948DB60186');
        $this->addSql('ALTER TABLE daily_schedules DROP FOREIGN KEY FK_B03FC59423F542AE');
        $this->addSql('DROP TABLE daily_schedules');
        $this->addSql('ALTER TABLE appointments CHANGE end_time end_time TIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\' COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE suggested_tasks CHANGE picture picture VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE tasks CHANGE due_time due_time TIME DEFAULT \'NULL\', CHANGE picture picture VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE dob dob DATE DEFAULT \'NULL\', CHANGE phone phone VARCHAR(255) DEFAULT \'NULL\', CHANGE picture picture VARCHAR(255) DEFAULT \'NULL\', CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
    }
}
