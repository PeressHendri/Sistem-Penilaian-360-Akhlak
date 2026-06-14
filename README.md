<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="340" alt="Laravel Logo"/>
</p>

<h1 align="center">🌿 Sistem Penilaian 360° AKHLAK</h1>

<p align="center">
  <strong>Aplikasi Penilaian Kinerja Karyawan Berbasis Nilai-Nilai AKHLAK</strong><br/>
  Dibangun dengan Laravel · Tailwind CSS · Alpine.js
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?logo=laravel&logoColor=white" alt="Laravel"/>
  <img src="https://img.shields.io/badge/PHP-8.2%2B-777BB4?logo=php&logoColor=white" alt="PHP"/>
  <img src="https://img.shields.io/badge/TailwindCSS-3.x-38B2AC?logo=tailwind-css&logoColor=white" alt="Tailwind"/>
  <img src="https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?logo=alpine.js&logoColor=white" alt="Alpine.js"/>
  <img src="https://img.shields.io/badge/License-MIT-green" alt="License"/>
</p>

---

## 📖 Tentang Aplikasi

**Sistem Penilaian 360° AKHLAK** adalah platform manajemen kinerja berbasis web yang dirancang untuk mendukung proses evaluasi karyawan secara menyeluruh menggunakan pendekatan **360 derajat** — melibatkan atasan, rekan sejawat, dan bawahan dalam satu siklus penilaian terintegrasi.

Aplikasi ini mengimplementasikan **6 Nilai Inti AKHLAK** sebagai kerangka kompetensi:

| Nilai | Deskripsi |
|-------|-----------|
| 🤝 **A**manah | Memegang teguh kepercayaan yang diberikan |
| 🧠 **K**ompeten | Terus belajar dan mengembangkan kapabilitas |
| 🌱 **H**armonis | Saling peduli dan menghargai perbedaan |
| 💡 **L**oyal | Berdedikasi dan mengutamakan kepentingan bersama |
| 🚀 **A**daptif | Terus berinovasi dan antusias menghadapi perubahan |
| 🤲 **K**olaboratif | Membangun kerja sama yang sinergis |

---

## ✨ Fitur Utama

### 👥 Multi-Role Access
- **Administrator** – Manajemen akun pengguna, hak akses, dan log aktivitas sistem
- **Human Capital (HC)** – Kelola karyawan, program penilaian, indikator AKHLAK, bobot, dan hasil
- **Penilai (Reviewer)** – Isi formulir penilaian dan lihat daftar penilaian yang ditugaskan
- **Management** – Dashboard analitik, ranking kinerja, dan talent mapping

### 📋 Modul Utama
- **Kelola Karyawan** – CRUD karyawan lengkap dengan upload foto profil
- **Formulir Penilaian** – Stepper multi-langkah dengan penilaian per indikator AKHLAK
- **Indikator & Bobot** – Konfigurasi bobot penilaian per dimensi kompetensi
- **Daftar Penilai** – Penetapan penilai otomatis dengan notifikasi pengingat
- **Dashboard Analisis** – Tren kinerja, distribusi skor, dan perbandingan unit kerja
- **Skor Detail** – Visualisasi skor per kompetensi dengan slider interaktif
- **Submit Penilaian** – Konfirmasi akhir dengan ringkasan hasil dan checklist kelengkapan
- **Hasil Penilaian** – Overview skor keseluruhan, growth trend, dan competency breakdown
- **Kelola Akun** – Manajemen pengguna dengan filter role dan pencarian real-time
- **Notifikasi Real-time** – Dropdown notifikasi terintegrasi dengan activity log

---

## 🛠️ Teknologi

| Layer | Teknologi |
|-------|-----------|
| Backend | Laravel 11, PHP 8.2+ |
| Frontend | Blade Templates, Tailwind CSS (CDN), Alpine.js |
| Database | MySQL / MariaDB |
| Auth & Roles | Laravel Sanctum + Spatie Permission |
| Storage | Laravel Storage (local disk) |
| Typography | Inter, Plus Jakarta Sans (Google Fonts) |

---

## 🚀 Cara Instalasi

### Prasyarat
- PHP >= 8.2
- Composer
- MySQL / MariaDB
- Node.js & NPM (opsional untuk build assets)

### Langkah Instalasi

```bash
# 1. Clone repositori
git clone https://github.com/PeressHendri/Sistem-Penilaian-360-Akhlak.git
cd Sistem-Penilaian-360-Akhlak

# 2. Install dependensi PHP
composer install

# 3. Salin file environment
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Konfigurasi database di file .env
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=sistem_penilaian
# DB_USERNAME=root
# DB_PASSWORD=

# 6. Jalankan migrasi dan seeder
php artisan migrate --seed

# 7. Buat symlink storage
php artisan storage:link

# 8. Jalankan server lokal
php artisan serve
```

Akses aplikasi di: **http://localhost:8000**

---

## 🔐 Akun Default

Setelah menjalankan seeder, gunakan akun berikut untuk login:

| Role | Email | Password |
|------|-------|----------|
| Administrator | admin@example.com | password |
| Human Capital | hc@example.com | password |
| Penilai | penilai@example.com | password |
| Management | management@example.com | password |

---

## 📁 Struktur Direktori Utama

```
├── app/
│   ├── Http/Controllers/     # Controller per modul
│   ├── Models/               # Eloquent Models
│   └── Helpers/              # ActivityLogger helper
├── database/
│   ├── migrations/           # Skema database
│   └── seeders/              # Data awal
├── resources/
│   └── views/
│       ├── admin/            # Halaman Administrator
│       ├── components/       # Sidebar, Header komponen
│       ├── employees/        # Kelola Karyawan
│       ├── indicators/       # Indikator & Bobot
│       ├── results/          # Hasil Penilaian
│       ├── reviewer/         # Formulir & Daftar Penilaian
│       ├── scores/           # Skor Detail
│       ├── submit/           # Submit Penilaian
│       └── users/            # Kelola Akun
└── routes/
    └── web.php               # Definisi rute aplikasi
```

---

## 📸 Tampilan Aplikasi

> Sistem ini menampilkan UI modern dengan desain premium menggunakan skema warna hijau teal (#006240), tipografi Plus Jakarta Sans, dan animasi micro-interaction Alpine.js.

---

## 🤝 Kontribusi

Kontribusi sangat disambut! Silakan buat **pull request** atau buka **issue** untuk melaporkan bug atau mengusulkan fitur baru.

1. Fork repositori ini
2. Buat branch fitur: `git checkout -b feature/NamaFitur`
3. Commit perubahan: `git commit -m 'Add: NamaFitur'`
4. Push ke branch: `git push origin feature/NamaFitur`
5. Buat Pull Request

---

## 📄 Lisensi

Aplikasi ini dilisensikan di bawah [MIT License](https://opensource.org/licenses/MIT).

---

<p align="center">
  Dibuat dengan ❤️ menggunakan <a href="https://laravel.com">Laravel</a> & <a href="https://tailwindcss.com">Tailwind CSS</a>
</p>
