<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\EncounterController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\CreatorContentController;
use App\Http\Controllers\MonsterController;
use App\Http\Controllers\SpellController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\RoleMiddleware;

// Landing page
Route::get('/', fn() => view('welcome'))->name('home');

// Auth routes (guests only)
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Authenticated routes
Route::middleware('auth')->group(function () {

    // Dashboard & Profile — semua role
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile',          [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit',     [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile',          [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // D&D Reference — semua role (read-only)
    Route::get('/monsters',          [MonsterController::class, 'index'])->name('monsters.index');
    Route::get('/monsters/{index}',  [MonsterController::class, 'show'])->name('monsters.show');
    Route::get('/spells',            [SpellController::class, 'index'])->name('spells.index');
    Route::get('/spells/{index}',    [SpellController::class, 'show'])->name('spells.show');
    Route::get('/classes',           [ClassController::class, 'index'])->name('classes.index');
    Route::get('/classes/{index}',   [ClassController::class, 'show'])->name('classes.show');
    Route::get('/equipment',         [EquipmentController::class, 'index'])->name('equipment.index');
    Route::get('/equipment/{index}', [EquipmentController::class, 'show'])->name('equipment.show');

    // ─── ADMIN ───────────────────────────────────────────────────────────────
    Route::prefix('admin')->name('admin.')->middleware(RoleMiddleware::class.':admin')->group(function () {
        Route::get('/',                      [AdminController::class, 'index'])->name('index');
        Route::get('/users',                 [AdminController::class, 'users'])->name('users');
        Route::put('/users/{user}/role',     [AdminController::class, 'updateRole'])->name('users.role');
        Route::delete('/users/{user}',       [AdminController::class, 'destroyUser'])->name('users.destroy');
    });

    // ─── CAMPAIGNS ───────────────────────────────────────────────────────────
    // Static routes HARUS sebelum wildcard {campaign}

    // Khusus player & admin
    Route::get('campaigns/browse', [CampaignController::class, 'browse'])
        ->name('campaigns.browse')
        ->middleware(RoleMiddleware::class.':player,admin');

    // Khusus DM & admin
    Route::get('campaigns/create', [CampaignController::class, 'create'])
        ->name('campaigns.create')
        ->middleware(RoleMiddleware::class.':dm,admin');

    Route::post('campaigns', [CampaignController::class, 'store'])
        ->name('campaigns.store')
        ->middleware(RoleMiddleware::class.':dm,admin');

    Route::get('campaigns', [CampaignController::class, 'index'])
        ->name('campaigns.index')
        ->middleware(RoleMiddleware::class.':dm,admin');

    // Routes dengan {campaign} wildcard
    Route::get('campaigns/{campaign}/player-view', [CampaignController::class, 'playerView'])
        ->name('campaigns.player-view')
        ->middleware(RoleMiddleware::class.':player,admin');

    Route::post('campaigns/{campaign}/join', [CampaignController::class, 'join'])
        ->name('campaigns.join')
        ->middleware(RoleMiddleware::class.':player,admin');

    Route::delete('campaigns/{campaign}/leave', [CampaignController::class, 'leave'])
        ->name('campaigns.leave')
        ->middleware(RoleMiddleware::class.':player,admin');

    Route::delete('campaigns/{campaign}/kick/{userId}', [CampaignController::class, 'kick'])
        ->name('campaigns.kick')
        ->middleware(RoleMiddleware::class.':dm,admin');

    Route::get('campaigns/{campaign}/edit', [CampaignController::class, 'edit'])
        ->name('campaigns.edit')
        ->middleware(RoleMiddleware::class.':dm,admin');

    Route::put('campaigns/{campaign}', [CampaignController::class, 'update'])
        ->name('campaigns.update')
        ->middleware(RoleMiddleware::class.':dm,admin');

    Route::delete('campaigns/{campaign}', [CampaignController::class, 'destroy'])
        ->name('campaigns.destroy')
        ->middleware(RoleMiddleware::class.':dm,admin');

    Route::get('campaigns/{campaign}', [CampaignController::class, 'show'])
        ->name('campaigns.show')
        ->middleware(RoleMiddleware::class.':dm,admin');

    // ─── ENCOUNTERS — DM & admin ──────────────────────────────────────────────
    Route::resource('encounters', EncounterController::class)
        ->middleware(RoleMiddleware::class.':dm,admin');
    Route::get('/encounters/{encounter}/analyze', [EncounterController::class, 'analyze'])
        ->name('encounters.analyze')
        ->middleware(RoleMiddleware::class.':dm,admin');

    // ─── CHARACTERS — player & admin ─────────────────────────────────────────
    Route::resource('characters', CharacterController::class)
        ->middleware(RoleMiddleware::class.':player,admin');

    // ─── CREATOR CONTENT — creator & admin ───────────────────────────────────
    Route::resource('creator-content', CreatorContentController::class)
        ->middleware(RoleMiddleware::class.':creator,admin');

});