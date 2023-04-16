<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230415222337 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, city VARCHAR(50) NOT NULL, country VARCHAR(50) NOT NULL, postal_code VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE announce (id INT AUTO_INCREMENT NOT NULL, user_announce_id INT NOT NULL, title VARCHAR(150) NOT NULL, description LONGTEXT NOT NULL, price INT NOT NULL, created_at DATETIME NOT NULL, is_active TINYINT(1) NOT NULL, brand VARCHAR(255) NOT NULL, model VARCHAR(255) DEFAULT NULL, INDEX IDX_E6D6DD75C6466A4B (user_announce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, user_comment_id INT NOT NULL, post_id INT NOT NULL, comment LONGTEXT NOT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_9474526C5F0EBBFF (user_comment_id), INDEX IDX_9474526C4B89032C (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE multimedia (id INT AUTO_INCREMENT NOT NULL, tchat_id INT DEFAULT NULL, post_id INT DEFAULT NULL, comment_id INT DEFAULT NULL, announce_id INT DEFAULT NULL, mp4_post VARCHAR(255) DEFAULT NULL, mp4_message VARCHAR(255) DEFAULT NULL, image_comment VARCHAR(255) DEFAULT NULL, image_post VARCHAR(255) DEFAULT NULL, image_profile VARCHAR(255) DEFAULT NULL, image_message VARCHAR(255) DEFAULT NULL, image_announce VARCHAR(255) DEFAULT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_61312863CACEEE58 (tchat_id), INDEX IDX_613128634B89032C (post_id), INDEX IDX_61312863F8697D13 (comment_id), INDEX IDX_613128636F5DA3DE (announce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE passionate (id INT AUTO_INCREMENT NOT NULL, user_passionate_id INT DEFAULT NULL, passionate VARCHAR(100) NOT NULL, INDEX IDX_717A92C0EAC78EEB (user_passionate_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, user_post_id INT NOT NULL, vehicle_id INT NOT NULL, title VARCHAR(150) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, is_active TINYINT(1) DEFAULT 1 NOT NULL, INDEX IDX_5A8A6C8D13841D26 (user_post_id), INDEX IDX_5A8A6C8D545317D1 (vehicle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tchat (id INT AUTO_INCREMENT NOT NULL, message_send LONGTEXT DEFAULT NULL, message_receive LONGTEXT DEFAULT NULL, send_to DATETIME NOT NULL, receive_to DATETIME NOT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, address_id INT NOT NULL, user_info_id INT NOT NULL, profile_picture_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, is_verified TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, is_agree TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649F5B7AF75 (address_id), UNIQUE INDEX UNIQ_8D93D649586DFF2 (user_info_id), UNIQUE INDEX UNIQ_8D93D649292E8AE2 (profile_picture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_info (id INT AUTO_INCREMENT NOT NULL, lastname VARCHAR(30) NOT NULL, firstname VARCHAR(30) NOT NULL, pseudo VARCHAR(10) NOT NULL, phone VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle (id INT AUTO_INCREMENT NOT NULL, vehicle VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE announce ADD CONSTRAINT FK_E6D6DD75C6466A4B FOREIGN KEY (user_announce_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C5F0EBBFF FOREIGN KEY (user_comment_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C4B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE multimedia ADD CONSTRAINT FK_61312863CACEEE58 FOREIGN KEY (tchat_id) REFERENCES tchat (id)');
        $this->addSql('ALTER TABLE multimedia ADD CONSTRAINT FK_613128634B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE multimedia ADD CONSTRAINT FK_61312863F8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE multimedia ADD CONSTRAINT FK_613128636F5DA3DE FOREIGN KEY (announce_id) REFERENCES announce (id)');
        $this->addSql('ALTER TABLE passionate ADD CONSTRAINT FK_717A92C0EAC78EEB FOREIGN KEY (user_passionate_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D13841D26 FOREIGN KEY (user_post_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649586DFF2 FOREIGN KEY (user_info_id) REFERENCES user_info (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649292E8AE2 FOREIGN KEY (profile_picture_id) REFERENCES multimedia (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE announce DROP FOREIGN KEY FK_E6D6DD75C6466A4B');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C5F0EBBFF');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C4B89032C');
        $this->addSql('ALTER TABLE multimedia DROP FOREIGN KEY FK_61312863CACEEE58');
        $this->addSql('ALTER TABLE multimedia DROP FOREIGN KEY FK_613128634B89032C');
        $this->addSql('ALTER TABLE multimedia DROP FOREIGN KEY FK_61312863F8697D13');
        $this->addSql('ALTER TABLE multimedia DROP FOREIGN KEY FK_613128636F5DA3DE');
        $this->addSql('ALTER TABLE passionate DROP FOREIGN KEY FK_717A92C0EAC78EEB');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D13841D26');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D545317D1');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649F5B7AF75');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649586DFF2');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649292E8AE2');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE announce');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE multimedia');
        $this->addSql('DROP TABLE passionate');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE tchat');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_info');
        $this->addSql('DROP TABLE vehicle');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
