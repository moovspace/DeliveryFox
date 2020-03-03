# Create user
GRANT ALL ON `app`.* TO 'app'@'localhost' IDENTIFIED BY 'toor' WITH GRANT OPTION;
GRANT ALL ON `app`.* TO 'app'@'127.0.0.1' IDENTIFIED BY 'toor' WITH GRANT OPTION;
FLUSH PRIVILEGES;

# Create database samples
# CREATE DATABASE moov CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
# GRANT ALL ON *.* TO 'app'@'localhost' IDENTIFIED BY 'toor';
# GRANT ALL ON *.* TO 'app'@'127.0.0.1' IDENTIFIED BY 'toor' WITH GRANT OPTION;
