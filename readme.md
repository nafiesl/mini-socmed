![Laravel](https://laravel.com/assets/img/components/logo-laravel.svg)

<h1 align="center">Media Sosial Mini</h1>

>**Development in progress**

## Tentang

Contoh aplikasi laravel dengan notifikasi realtime menggunakan pusher. Sebagian besar aplikasi ini mengacu pada tutorial berikut : [Social network in laravel 5.3 and vuejs 2.0](https://www.youtube.com/playlist?list=PLZAiN3wmUtzV1eI7mAxERQaE2LkyA5Nh6)

## Fitur

1. Akun User
    - Login dan Logout User (bawaan laravel)
    - Registrasi (bawaan laravel)
2. Menu **Browse Users**
    - Melihat daftar User yang terdaftar
    - Klik **View Profile**
3. Pertemanan
    - **Add Friend** mengirim permintaan teman kepada user lain
    - **Accept Friend** menerima permintaan teman dari user lain
    - **Remove Friend** menghapus pertemanan dengan user lain
3. Fitur Realtime
    - Menggunakan layanan **pusher**
    - Notifikasi kepada user ketika dikirimi permintaan sebagai teman
    - Notifikasi kepada user ketika permintaan pertemanan diterima
    - Jumlah Unread Notif bertambah otomatis
4. Menggunakan Komponen Vuejs
    - Tombol Teman
    - Notifikasi dari pusher
    - Jumlah Unread Notif

## Cara Install

### Install Aplikasi
1. Para terminal, clone repo dengan git `git clone git@github.com:nafiesl/mini-socmed.git`
2. `cd mini-socmed`
3. `cp .env.example .env`
4. `composer install`
5. Pada terminal `php artisan key:generate`
6. Buat database pada mysql untuk aplikasi ini
7. Setting database ada file `.env`
8. `php artisan migrate`
9. [Atur akun dan aplikasi pada layanan pusher](#buat-akun-pada-pushercom)
10. (optional) Buat beberapa akun dengan tinker dan factory
11. `php artisan serve`
12. Selesai, silakan registrasi dan coba aplikasinya

### Buat Akun pada Pusher.com
1. Buat akun pada `pusher.com`
2. `Create new app` dan masuk `dashboard` aplikasi
3. Pada bagian **Keys**, masukkan `app_id`, `key`, dan `secret` ke file `.env` pada aplikasi laravel.
4. Pada file `.env` set `BROADCAST_DRIVER=pusher`

Jika ada problem dengan instalasi atau aplikasi, silakan buat `New issue` pada repo ini.

## Testing
Ingin mencoba testingnya? Silakan ketik perintah pada terminal: `vendor/bin/phpunit`

## License

The Laravel framework is open-sourced software licensed under the [MIT license](LICENSE).