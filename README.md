# Installation

1. ```git clone https://github.com/l6gistaja/brpblog.git```
1. ```cd brpblog```
1. ```composer install```
1. create database
1. configure database in .env variable DATABASE_URL
1. ```php bin/console doctrine:migrations:migrate```
1. login to database and ```INSERT INTO user (email, roles, password) VALUES('root@brpblog.com','{"roles":"ROLE_ADMIN"}','$argon2id$v=19$m=65536,t=4,p=1$8mC8G7gZ1JcJ4R1h9K2hHg$RomdGQCMXwj4ktXDNGeZ7LSgMHCcuREF2Pl+Bikwkrk');``` . this created admin user 'root@brpblog.com' with password 'kala'.