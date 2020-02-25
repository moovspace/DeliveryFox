# Create user
GRANT ALL ON `phpapix`.* TO 'phpapix'@'localhost' IDENTIFIED BY 'toor' WITH GRANT OPTION;
GRANT ALL ON `phpapix`.* TO 'phpapix'@'127.0.0.1' IDENTIFIED BY 'toor' WITH GRANT OPTION;
FLUSH PRIVILEGES;

# Create database
# CREATE DATABASE moov CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
# GRANT ALL ON *.* TO 'phpapix'@'127.0.0.1' IDENTIFIED BY 'toor';
# GRANT ALL ON *.* TO 'phpapix'@'127.0.0.1' IDENTIFIED BY 'toor' WITH GRANT OPTION;
