<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240525123748 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE addresses CHANGE street_secondary street_secondary VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE appointments CHANGE end_time end_time TIME DEFAULT NULL');
        $this->addSql('ALTER TABLE coding_languages CHANGE difficulty difficulty VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE daily_schedules CHANGE schedule_date schedule_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE my_notes CHANGE sub_category sub_category VARCHAR(255) DEFAULT NULL, CHANGE picture picture VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE projects ADD coding_language_id INT DEFAULT NULL, CHANGE end_date end_date DATE DEFAULT NULL, CHANGE resources resources VARCHAR(255) DEFAULT NULL, CHANGE picture picture VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A49552E5E2 FOREIGN KEY (coding_language_id) REFERENCES coding_languages (id)');
        $this->addSql('CREATE INDEX IDX_5C93B3A49552E5E2 ON projects (coding_language_id)');
        $this->addSql('ALTER TABLE suggested_tasks CHANGE picture picture VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE tasks CHANGE due_time due_time TIME DEFAULT NULL, CHANGE picture picture VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE dob dob DATE DEFAULT NULL, CHANGE phone phone VARCHAR(255) DEFAULT NULL, CHANGE picture picture VARCHAR(255) DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE addresses CHANGE street_secondary street_secondary VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE appointments CHANGE end_time end_time TIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE coding_languages CHANGE difficulty difficulty VARCHAR(50) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE daily_schedules CHANGE schedule_date schedule_date DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\' COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE my_notes CHANGE sub_category sub_category VARCHAR(255) DEFAULT \'NULL\', CHANGE picture picture VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A49552E5E2');
        $this->addSql('DROP INDEX IDX_5C93B3A49552E5E2 ON projects');
        $this->addSql('ALTER TABLE projects DROP coding_language_id, CHANGE end_date end_date DATE DEFAULT \'NULL\', CHANGE resources resources VARCHAR(255) DEFAULT \'NULL\', CHANGE picture picture VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE suggested_tasks CHANGE picture picture VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE tasks CHANGE due_time due_time TIME DEFAULT \'NULL\', CHANGE picture picture VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE dob dob DATE DEFAULT \'NULL\', CHANGE phone phone VARCHAR(255) DEFAULT \'NULL\', CHANGE picture picture VARCHAR(255) DEFAULT \'NULL\', CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
    }
}
