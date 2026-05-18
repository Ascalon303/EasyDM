# ⚔ EasyDM — D&D Campaign Management Platform

> AI-powered encounter balancing, D&D 5e compendium, campaign management, and a creator marketplace — all in one Laravel 12 platform.

---

## ✦ Tech Stack

| Layer      | Technology                       |
|------------|----------------------------------|
| Backend    | Laravel 12 (PHP 8.2+)            |
| Frontend   | Blade + Alpine.js + Tailwind CSS |
| Database   | MySQL 8+                         |
| API        | D&D 5e API (dnd5eapi.co)         |
| AI         | OpenAI GPT-4o-mini               |

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
GEMINI_API_KEY=sk-xxxxxxxxxxxxxx
```

### 3. Database Setup

```bash
# Create the database first
mysql -u root -p -e "CREATE DATABASE easydm;"

# Run migrations
php artisan migrate

# Seed demo data (optional but recommended)
php artisan db:seed
```

### 4. Run Development Server

```bash
php artisan serve
```

Visit: **http://localhost:8000**

---

## ✦ Demo Accounts (after seeding)

| Email                  | Password   | Role    |
|------------------------|------------|---------|
| admin@easydm.com       | password   | Admin   |
| dm@easydm.com          | password   | DM      |
| player@easydm.com      | password   | Player  |
| creator@easydm.com     | password   | Creator |

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
│       ├── DndApiService.php           ← D&D 5e API wrapper
│       ├── EncounterAnalysisService.php ← CR/XP calculations
│       └── AiService.php              ← OpenAI integration
├── database/
│   ├── migrations/                    ← All table schemas
│   └── seeders/DatabaseSeeder.php     ← Demo data
├── resources/views/
│   ├── layouts/app.blade.php          ← Main layout
│   ├── components/
│   │   ├── sidebar.blade.php
│   │   └── navbar.blade.php
│   ├── auth/         ← login, register
│   ├── dashboard/    ← role-based dashboards
│   ├── campaigns/    ← full CRUD
│   ├── encounters/   ← CRUD + AI analysis
│   ├── characters/   ← full CRUD
│   ├── monsters/     ← read-only (API)
│   ├── spells/       ← read-only (API)
│   ├── classes/      ← read-only (API)
│   ├── equipment/    ← read-only (API)
│   ├── creator/      ← creator marketplace
│   ├── admin/        ← admin panel
│   └── profile/      ← user profile
└── routes/web.php                     ← All routes
```

---

## ✦ Role System

| Role    | Capabilities                                            |
|---------|---------------------------------------------------------|
| Admin   | Manage all users, roles, system analytics               |
| DM      | Campaign CRUD, Encounter CRUD, AI encounter analyzer    |
| Player  | Character CRUD, join campaigns, track inventory/spells  |
| Creator | Publish homebrew content, manage creator library        |

---

## ✦ AI Encounter Analyzer

The AI flow works as follows:

1. **DM** selects party composition + monsters from D&D 5e API
2. **EncounterAnalysisService** calculates CR totals, XP thresholds, action economy
3. **AiService** sends data to OpenAI GPT-4o-mini
4. AI returns: difficulty rating, TPK risk, tactical recommendations, balancing advice

Without an OpenAI key, the system falls back to a rule-based text analysis.

---

## ✦ D&D 5e API

Uses the free [D&D 5e API](https://www.dnd5eapi.co):
- 300+ monsters with full stat blocks
- 300+ spells with complete descriptions
- All 12 base classes with proficiencies
- Full equipment catalog

Results are cached for 1 hour via Laravel's cache system.

---

## ✦ Roadmap

- [ ] Phase 1: Auth + Layout + Dashboard ✅
- [ ] Phase 2: D&D API Integration (Monsters/Spells/Classes/Equipment) ✅
- [ ] Phase 3: Campaign & Encounter CRUD ✅
- [ ] Phase 4: Character System + Creator Marketplace ✅
- [ ] Phase 5: AI Encounter Analyzer ✅
- [ ] Phase 6: UI Polish + Responsive + Favorites System
- [ ] Phase 7: Party invite system, campaign collaboration
- [ ] Phase 8: Initiative tracker, session notes

---

## ✦ License

MIT — Forge your own legend.
