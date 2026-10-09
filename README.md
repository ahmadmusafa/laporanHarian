# Laporan Harian

Aplikasi web untuk mengelola laporan aktivitas harian menggunakan CodeIgniter 4 dan MySQL.

## Teknologi

- PHP 8.5
- CodeIgniter 4
- MySQL
- Bootstrap 5
- Docker

## Persyaratan

- Docker Desktop
- Git

## Cara Menjalankan Project

1. Clone repository:

   ```bash
   git clone URL_REPOSITORY
   ```

2. Masuk ke folder project:

   ```bash
   cd laporanHarian
   ```

3. Jalankan aplikasi:

   ```bash
   docker compose up -d --build
   ```

4. Buka aplikasi melalui browser:
   http://localhost:8082

## Struktur Folder

- `app/` — kode aplikasi CodeIgniter 4
- `public/` — file publik dan entry point aplikasi
- `writable/` — file sementara, cache, dan log
- `compose.yaml` — konfigurasi Docker Compose
- `Dockerfile.dev` — konfigurasi image PHP dan Apache
