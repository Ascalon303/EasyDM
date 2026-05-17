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

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile',           [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit',      [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile',           [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password',  [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Admin routes
    Route::prefix('admin')->name('admin.')->middleware('can:admin')->group(function () {
        Route::get('/',           [AdminController::class, 'index'])->name('index');
        Route::get('/users',      [AdminController::class, 'users'])->name('users');
        Route::put('/users/{user}/role',  [AdminController::class, 'updateRole'])->name('users.role');
        Route::delete('/users/{user}',    [AdminController::class, 'destroyUser'])->name('users.destroy');
    });

    // D&D Reference (read-only)
    Route::get('/monsters',          [MonsterController::class, 'index'])->name('monsters.index');
    Route::get('/monsters/{index}',  [MonsterController::class, 'show'])->name('monsters.show');

    Route::get('/spells',            [SpellController::class, 'index'])->name('spells.index');
    Route::get('/spells/{index}',    [SpellController::class, 'show'])->name('spells.show');

    Route::get('/classes',           [ClassController::class, 'index'])->name('classes.index');
    Route::get('/classes/{index}',   [ClassController::class, 'show'])->name('classes.show');

    Route::get('/equipment',         [EquipmentController::class, 'index'])->name('equipment.index');
    Route::get('/equipment/{index}', [EquipmentController::class, 'show'])->name('equipment.show');

    // Campaign CRUD
    Route::resource('campaigns', CampaignController::class);

    // Encounter CRUD + AI analyze
    Route::resource('encounters', EncounterController::class);
    Route::get('/encounters/{encounter}/analyze', [EncounterController::class, 'analyze'])->name('encounters.analyze');

    // Character CRUD
    Route::resource('characters', CharacterController::class);

    // Creator Content
    Route::resource('creator-content', CreatorContentController::class);
});
