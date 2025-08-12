# Laravel RESTful API

RESTful API berbasis Laravel untuk manajemen nomor telepon WhatsApp.

## Instalasi

1. Clone repository: `git clone https://github.com/gilangcahyono/laravelrestfulapi.git`
2. Buka folder: `cd laravelrestfulapi`
3. Buat file `.env` di root folder lalu salin isi dari file `.env.example`
4. Generate key aplikasi: `php artisan key:generate`
5. Migrasi database sekaligus isi dengan data dummy: `php artisan migrate --seed`
6. Install dependencies: `composer install`
7. Jalankan server: `php artisan serve`

## Dokumentasi

Anda dapat mengakses dokumentasi API di [http://127.0.0.1:8000/docs/api](http://127.0.0.1:8000/docs/api)

## Teknologi

-   [Laravel](https://laravel.com/)
-   [Laravel Sanctum](https://laravel.com/docs/sanctum)

## Fitur Utama

-   CRUD nomor telepon WhatsApp
-   Autentikasi dengan Sanctum
-   Authorisasi dengan Laravel Policy
-   Upload file

## Catatan

API ini juga di implementasikan ke Frontend Next.js di [https://github.com/gilangcahyono/contactapp](https://github.com/gilangcahyono/contactapp)
