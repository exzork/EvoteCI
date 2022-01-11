# Evote CI
## System Requirements
1. PHP Versi 7.4
2. MySQL
3. Composer
## Cara pemakaian
1. Install Seluruh library
``composer install``
2. Isi .env dan google-service
3. Buat Database
``php spark db:create [Nama database]``
4. Migrasi database
``php spark migrate``
5. Isi dummy database
``php spark db:seed admin``
``php spark db:seed configs``
6. Jalankan website
``php spark serve``
