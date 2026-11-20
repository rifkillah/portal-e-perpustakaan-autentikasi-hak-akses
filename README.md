# Sistem Autentikasi dan Hak Akses Portal E-Perpustakaan Kampus

Aplikasi Laravel yang menerapkan autentikasi dan otorisasi berbasis role pada portal e-perpustakaan kampus. Role **pustakawan** dan **anggota** memiliki hak akses berbeda.

## Fitur

- Registrasi dengan role `pustakawan` atau `anggota`.
- Login, logout, dan proteksi halaman dengan middleware `auth`.
- Middleware `role` untuk membatasi akses.
- Dashboard terpisah sesuai role.
- Halaman kelola buku khusus pustakawan.
- Halaman pinjam buku khusus anggota.
- Halaman 403 kustom untuk akses yang ditolak.
- Feature test autentikasi dan hak akses (`tests/Feature/PerpusAuthTest.php`).

## Teknologi

- PHP 8.3+
- Laravel
- Blade Template
- SQLite (default)

## Instalasi

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
php artisan serve
```

Buka http://localhost:8000/perpus/login.

## Akun Demo (hasil seeder)

| Role | Email | Password |
|---|---|---|
| Pustakawan | `pustakawan@kampus.ac.id` | `password` |
| Anggota | `anggota@kampus.ac.id` | `password` |

## Route

| Method | URI | Middleware | Keterangan |
|---|---|---|---|
| GET/POST | `/perpus/register` | — | Registrasi pustakawan/anggota |
| GET/POST | `/perpus/login` | — | Login |
| GET | `/perpus/dashboard` | `auth` | Dashboard sesuai role |
| POST | `/perpus/logout` | `auth` | Logout |
| GET | `/perpus/kelola-buku` | `auth`, `role:pustakawan` | Kelola buku |
| GET | `/perpus/pinjam-buku` | `auth`, `role:anggota` | Pinjam buku |

## Pengujian

```bash
php artisan test
```

## Struktur Penting

- `app/Http/Controllers/PerpusAuthController.php` — autentikasi dan halaman per role.
- `app/Http/Middleware/CekRole.php` — pengecekan role.
- `database/seeders/DatabaseSeeder.php` — akun demo.
