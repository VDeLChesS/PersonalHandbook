<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240522130536 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointments CHANGE end_time end_time TIME DEFAULT NULL');
        $this->addSql('ALTER TABLE daily_schedules CHANGE schedule_date schedule_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE my_notes ADD category_id INT DEFAULT NULL, ADD sub_category VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE my_notes ADD CONSTRAINT FK_6DDD144812469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_6DDD144812469DE2 ON my_notes (category_id)');
        $this->addSql('ALTER TABLE suggested_tasks CHANGE picture picture VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE tasks CHANGE due_time due_time TIME DEFAULT NULL, CHANGE picture picture VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE dob dob DATE DEFAULT NULL, CHANGE phone phone VARCHAR(255) DEFAULT NULL, CHANGE picture picture VARCHAR(255) DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointments CHANGE end_time end_time TIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE daily_schedules CHANGE schedule_date schedule_date DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\' COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE my_notes DROP FOREIGN KEY FK_6DDD144812469DE2');
        $this->addSql('DROP INDEX IDX_6DDD144812469DE2 ON my_notes');
        $this->addSql('ALTER TABLE my_notes DROP category_id, DROP sub_category');
        $this->addSql('ALTER TABLE suggested_tasks CHANGE picture picture VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE tasks CHANGE due_time due_time TIME DEFAULT \'NULL\', CHANGE picture picture VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE dob dob DATE DEFAULT \'NULL\', CHANGE phone phone VARCHAR(255) DEFAULT \'NULL\', CHANGE picture picture VARCHAR(255) DEFAULT \'NULL\', CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
    }
}