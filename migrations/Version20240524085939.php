<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240524085939 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE projects (id INT AUTO_INCREMENT NOT NULL, status_id INT DEFAULT NULL, tasks_id INT DEFAULT NULL, user_id INT NOT NULL, project_name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, start_date DATE NOT NULL, end_date DATE DEFAULT NULL, priority VARCHAR(50) NOT NULL, documentation LONGTEXT DEFAULT NULL, resources VARCHAR(255) DEFAULT NULL, completion_progress INT DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, INDEX IDX_5C93B3A46BF700BD (status_id), INDEX IDX_5C93B3A4E3272D31 (tasks_id), INDEX IDX_5C93B3A4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A46BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A4E3272D31 FOREIGN KEY (tasks_id) REFERENCES tasks (id)');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE addresses CHANGE street_secondary street_secondary VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE appointments CHANGE end_time end_time TIME DEFAULT NULL');
        $this->addSql('ALTER TABLE daily_schedules CHANGE schedule_date schedule_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE my_notes CHANGE sub_category sub_category VARCHAR(255) DEFAULT NULL, CHANGE picture picture VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE suggested_tasks CHANGE picture picture VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE tasks CHANGE due_time due_time TIME DEFAULT NULL, CHANGE picture picture VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE dob dob DATE DEFAULT NULL, CHANGE phone phone VARCHAR(255) DEFAULT NULL, CHANGE picture picture VARCHAR(255) DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A46BF700BD');
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A4E3272D31');
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A4A76ED395');
        $this->addSql('DROP TABLE projects');
        $this->addSql('ALTER TABLE addresses CHANGE street_secondary street_secondary VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE appointments CHANGE end_time end_time TIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE daily_schedules CHANGE schedule_date schedule_date DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\' COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE my_notes CHANGE sub_category sub_category VARCHAR(255) DEFAULT \'NULL\', CHANGE picture picture VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE suggested_tasks CHANGE picture picture VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE tasks CHANGE due_time due_time TIME DEFAULT \'NULL\', CHANGE picture picture VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE dob dob DATE DEFAULT \'NULL\', CHANGE phone phone VARCHAR(255) DEFAULT \'NULL\', CHANGE picture picture VARCHAR(255) DEFAULT \'NULL\', CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
    }
}
