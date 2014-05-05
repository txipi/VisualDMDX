CREATE DATABASE visualdmdx;
GRANT ALL ON visualdmdx.* TO 'visual'@'localhost' IDENTIFIED BY 'YOURPASSWORD';
USE visualdmdx;
CREATE TABLE `experiment` ( `id` INTEGER NOT NULL AUTO_INCREMENT, `slug` VARCHAR(255), `json` TEXT, `version` INTEGER NOT NULL DEFAULT 0, PRIMARY KEY (`id`) );

