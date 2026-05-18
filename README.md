# ⚔ EasyDM — D&D Campaign Management Platform

> AI-powered encounter balancing, D&D 5e compendium, campaign management, and a creator marketplace — all in one Laravel 12 platform.

---

## ✦ Tech Stack

| Layer    | Technology                       |
|----------|----------------------------------|
| Backend  | Laravel 12 (PHP 8.2+)            |
| Frontend | Blade + Alpine.js + Tailwind CSS |
| Database | MySQL 8+                         |
| API      | D&D 5e API (dnd5eapi.co)         |
| AI       | Google Gemini 2.5 Flash          |

---

## ✦ Quick Start

### 1. Clone & Install

```bash
git clone https://github.com/yourname/easydm.git
cd easydm
composer install
```

### 2. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:

```env
DB_DATABASE=easydm
DB_USERNAME=root
DB_PASSWORD=your_password

# Required for AI encounter analysis
GEMINI_API_KEY=your_gemini_api_key_here
```

> Dapatkan API key gratis di [Google AI Studio](https://aistudio.google.com). Buat project baru → Get API Key.

### 3. Database Setup

```bash
# Buat database terlebih dahulu
mysql -u root -p -e "CREATE DATABASE easydm;"

# Jalankan migrations
php artisan migrate

# Seed demo data (opsional tapi disarankan)
php artisan db:seed
```

### 4. Run Development Server

```bash
php artisan serve
```

Buka: **http://localhost:8000**

---

## ✦ Demo Accounts (setelah seeding)

| Email              | Password | Role    |
|--------------------|----------|---------|
| admin@easydm.com   | password | Admin   |
| dm@easydm.com      | password | DM      |
| player@easydm.com  | password | Player  |
| creator@easydm.com | password | Creator |

---

## ✦ Project Structure

```
easydm/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── AdminController.php
│   │   ├── CampaignController.php
│   │   ├── EncounterController.php
│   │   ├── CharacterController.php
│   │   ├── CreatorContentController.php
│   │   ├── MonsterController.php
│   │   ├── SpellController.php
│   │   ├── ClassController.php
│   │   ├── EquipmentController.php
│   │   └── ProfileController.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Campaign.php
│   │   ├── Encounter.php
│   │   ├── Character.php
│   │   ├── CreatorContent.php
│   │   ├── ContentReview.php
│   │   └── Favorite.php
│   └── Services/
│       ├── DndApiService.php            ← D&D 5e API wrapper (cache 1 jam)
│       ├── EncounterAnalysisService.php ← Kalkulasi CR/XP/DMG rules
│       └── AiService.php               ← Google Gemini integration
├── database/
│   ├── migrations/                     ← Semua schema tabel
│   └── seeders/DatabaseSeeder.php      ← Demo data
├── resources/views/
│   ├── layouts/app.blade.php           ← Main layout
│   ├── components/
│   │   ├── sidebar.blade.php
│   │   └── navbar.blade.php
│   ├── auth/         ← login, register
│   ├── dashboard/    ← dashboard per role
│   ├── campaigns/    ← CRUD lengkap
│   ├── encounters/   ← CRUD + AI analysis
│   ├── characters/   ← CRUD lengkap
│   ├── monsters/     ← read-only (D&D API)
│   ├── spells/       ← read-only (D&D API)
│   ├── classes/      ← read-only (D&D API)
│   ├── equipment/    ← read-only (D&D API)
│   ├── creator/      ← creator marketplace
│   ├── admin/        ← admin panel
│   └── profile/      ← profil pengguna
└── routes/web.php                      ← Semua routes
```

---

## ✦ Role System

| Role    | Kemampuan                                               |
|---------|---------------------------------------------------------|
| Admin   | Kelola semua user, role, dan analytics sistem           |
| DM      | Campaign CRUD, Encounter CRUD, AI encounter analyzer    |
| Player  | Character CRUD, join kampanye, track inventory/spell    |
| Creator | Publish homebrew content, kelola creator library        |

---

## ✦ AI Encounter Analyzer

Alur kerja AI analyzer:

1. **DM** memilih komposisi party + monster dari D&D 5e API
2. **EncounterAnalysisService** menghitung total CR, XP threshold (DMG 5e), action economy, dan TPK risk
3. **AiService** mengirim semua data ke **Google Gemini 2.5 Flash**
4. AI menghasilkan: penilaian kesulitan, ancaman utama, rekomendasi taktis DM, saran balancing, dan perilaku taktis monster

Tanpa API key Gemini, sistem otomatis menggunakan **fallback rule-based analysis**.

### Bug yang sudah diperbaiki

| Bug | Penyebab | Fix |
|-----|----------|-----|
| `party_data` / `monster_data` must be array (edit) | `update()` tidak decode JSON | Tambah `$request->merge([json_decode...])` di `update()` |
| AI selalu fallback | Quota Gemini 2.0 Flash habis | Ganti ke Gemini 2.5 Flash + API key baru |
| CR monster selalu 0 di tampilan | `analyze()` tidak save `monster_data` yang sudah di-enrich + `data-cr` tidak di-set di option tag + `updateMonsterName` tidak update `challenge_rating` | Tambah `'monster_data' => $monsters` di `$encounter->update()`, tambah `data-cr` di option tag, tambah `challenge_rating` di `updateMonsterName` |
| Monster Count hitung jenis bukan total creature | `count($monsters)` bukan `array_sum(quantity)` | Ganti ke `array_sum(array_column($monsters, 'quantity'))` |
| XP multiplier salah | `applyMultiplier` pakai `count($monsters)` | Ganti ke `array_sum(array_column($monsters, 'quantity'))` |
| Statistik hilang di halaman show | `show()` tidak kirim `$analysis` ke view | Hitung ulang `$analysis` di `show()` |

---

## ✦ Catatan Quota Gemini API

Gemini API free tier memiliki batas request harian. Jika quota habis (error 429):

- Tunggu reset otomatis keesokan hari (sekitar jam 07.00 WIB)
- Buat API key baru di [Google AI Studio](https://aistudio.google.com) dengan akun Google berbeda
- Aktifkan billing di [Google Cloud Console](https://console.cloud.google.com/billing) untuk pemakaian tanpa batas (±$0.15 per 1 juta token)

---

## ✦ D&D 5e API

Menggunakan [D&D 5e API](https://www.dnd5eapi.co) yang gratis:

- 300+ monster dengan full stat block
- 300+ spell dengan deskripsi lengkap
- 12 base class dengan profisiensi
- Katalog equipment lengkap

Semua hasil di-cache selama **1 jam** via Laravel cache system.

> **Catatan:** Endpoint `/api/monsters` hanya mengembalikan `index` dan `name`, tanpa `challenge_rating`. CR di-fetch secara individual per monster saat encounter di-analyze, lalu disimpan ke database.

---

## ✦ Roadmap

- [x] Phase 1: Auth + Layout + Dashboard
- [x] Phase 2: D&D API Integration (Monsters/Spells/Classes/Equipment)
- [x] Phase 3: Campaign & Encounter CRUD
- [x] Phase 4: Character System + Creator Marketplace
- [x] Phase 5: AI Encounter Analyzer (Google Gemini)
- [ ] Phase 6: UI Polish + Responsive + Favorites System
- [ ] Phase 7: Party invite system, campaign collaboration
- [ ] Phase 8: Initiative tracker, session notes

---

## ✦ License

MIT — Forge your own legend.