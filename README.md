# 🏥 SIMRS TI Manajemen – RSI Banjarmasin

Aplikasi **Manajemen & Pelaporan Tim IT** untuk Rumah Sakit Islam Banjarmasin.  
Dibangun dengan **Laravel 11**, **Tailwind CSS**, dan **Laravel Breeze** (Blade stack).  
Aplikasi ini membantu tim IT mencatat, memantau, dan menyelesaikan tiket keluhan, mengelola inventaris perangkat, serta menyediakan portal pelapor publik tanpa login.

---

## ✨ Fitur Utama

### 1. Portal Pelapor Publik
- Form laporan tanpa login (nama, unit, kategori, prioritas, keluhan)
- Kode unik otomatis untuk memantau status tiket
- Riwayat status (open → in progress → resolved → closed)

### 2. Manajemen Tiket (Admin)
- CRUD tiket lengkap
- Filter berdasarkan status & prioritas
- Assign teknisi
- Update status cepat (tombol ubah status)
- Riwayat perubahan status tercatat

### 3. Manajemen Inventaris
- Pencatatan perangkat IT (kode QR, lokasi, kondisi)
- Relasi vendor & garansi
- Riwayat perbaikan perangkat

### 4. Role & Permission (Middleware)
- Multi-role: `super_admin`, `kepala_it`, `teknisi`, `pelapor`
- Pembatasan akses berdasarkan role

### 5. Dashboard Statistik
- Total tiket open/progress, resolved, closed
- Daftar tiket terbaru

### 6. Autentikasi (Laravel Breeze)
- Login, register, forgot password
- Tailwind CSS UI

---

## 🔧 Teknologi

- **Backend**: Laravel 11, PHP 8.2+
- **Frontend**: Blade, Tailwind CSS, Alpine.js (via Breeze)
- **Database**: PostgreSQL (dapat diubah ke MySQL)
- **Autentikasi**: Laravel Breeze (Blade)
- **Package**: Laravel Vite

---

## 🚀 Instalasi & Menjalankan Proyek

### Prasyarat
- PHP 8.2+
- Composer
- Node.js & NPM
- PostgreSQL (atau MySQL)

### Langkah-langkah
# 1. Clone repository
git clone https://github.com/USERNAME/simrs-ti-manajemen.git
cd simrs-ti-manajemen

# 2. Install dependensi PHP
composer install

# 3. Copy file environment
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Konfigurasi database di .env (DB_CONNECTION, DB_DATABASE, DB_USERNAME, DB_PASSWORD)
#    Pastikan database sudah dibuat

# 6. Jalankan migrasi dan seeder
php artisan migrate --seed

# 7. Install dependensi Node.js dan compile assets
npm install
npm run build

# 8. Jalankan server
php artisan serve

Akun Demo (Seeder)
Role	Email	Password
Super Admin	superadmin@rs-bjm.test	password123
Kepala IT	kepalait@rs-bjm.test	password123
Teknisi 1	teknisi1@rs-bjm.test	password123
Teknisi 2	teknisi2@rs-bjm.test	password123
Staff Pelapor	staff@rs-bjm.test	password123
⚠️ Staff Pelapor tidak memiliki akses ke panel admin.
Hanya super_admin, kepala_it, dan teknisi yang dapat mengakses /admin/*.

Role & Permission
Role	Akses
super_admin	Semua akses (dashboard, CRUD tiket, CRUD inventaris)
kepala_it	Semua akses
teknisi	Akses dashboard, tiket (view, update status), inventaris (view)
pelapor	Hanya portal publik (tanpa login)
Middleware role digunakan untuk membatasi akses admin.
