<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240527110950 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE events (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, category_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, start_datetime DATETIME NOT NULL, duration INT DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, INDEX IDX_5387574AA76ED395 (user_id), INDEX IDX_5387574A12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574A12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE addresses CHANGE street_secondary street_secondary VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE appointments CHANGE end_time end_time TIME DEFAULT NULL');
        $this->addSql('ALTER TABLE coding_languages CHANGE difficulty difficulty VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE daily_schedules CHANGE schedule_date schedule_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE my_notes CHANGE sub_category sub_category VARCHAR(255) DEFAULT NULL, CHANGE picture picture VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE projects CHANGE end_date end_date DATE DEFAULT NULL, CHANGE resources resources VARCHAR(255) DEFAULT NULL, CHANGE picture picture VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE suggested_tasks CHANGE picture picture VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE tasks CHANGE due_time due_time TIME DEFAULT NULL, CHANGE picture picture VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE dob dob DATE DEFAULT NULL, CHANGE phone phone VARCHAR(255) DEFAULT NULL, CHANGE picture picture VARCHAR(255) DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE events DROP FOREIGN KEY FK_5387574AA76ED395');
        $this->addSql('ALTER TABLE events DROP FOREIGN KEY FK_5387574A12469DE2');
        $this->addSql('DROP TABLE events');
        $this->addSql('ALTER TABLE addresses CHANGE street_secondary street_secondary VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE appointments CHANGE end_time end_time TIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE coding_languages CHANGE difficulty difficulty VARCHAR(50) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE daily_schedules CHANGE schedule_date schedule_date DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\' COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE my_notes CHANGE sub_category sub_category VARCHAR(255) DEFAULT \'NULL\', CHANGE picture picture VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE projects CHANGE end_date end_date DATE DEFAULT \'NULL\', CHANGE resources resources VARCHAR(255) DEFAULT \'NULL\', CHANGE picture picture VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE suggested_tasks CHANGE picture picture VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE tasks CHANGE due_time due_time TIME DEFAULT \'NULL\', CHANGE picture picture VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE dob dob DATE DEFAULT \'NULL\', CHANGE phone phone VARCHAR(255) DEFAULT \'NULL\', CHANGE picture picture VARCHAR(255) DEFAULT \'NULL\', CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
    }
}
