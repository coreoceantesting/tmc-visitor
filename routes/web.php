<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/check-pass-id', [App\Http\Controllers\HomeController::class, 'checkPassId']);

Route::get('/register-visitor', [App\Http\Controllers\HomeController::class, 'register_visitor'])->name('register.visitor');
Route::post('/store-visitor', [App\Http\Controllers\HomeController::class, 'store_visitor'])->name('visitor.store');
Route::get('/exit-list-visitor', [App\Http\Controllers\HomeController::class, 'exit_list_visitor'])->name('exitlist.visitor');
Route::get('/entry-list-visitor', [App\Http\Controllers\HomeController::class, 'entry_list_visitor'])->name('entrylist.visitor');
Route::post('/visitor-exit/{id}', [App\Http\Controllers\HomeController::class, 'update_visitor_exit_time'])->name('update.exit');
Route::get('/exited-list-visitor', [App\Http\Controllers\HomeController::class, 'exited_list_visitor'])->name('exitedlist.visitor');

// Masters Route

// Visiting Department
Route::get('/department-list', [App\Http\Controllers\MastersController::class, 'index'])->name('list.department');
Route::get('/add-department', [App\Http\Controllers\MastersController::class, 'add_department'])->name('add.department');
Route::post('/store-department', [App\Http\Controllers\MastersController::class, 'store_department'])->name('store.department');
Route::get('/edit-department/{id}', [App\Http\Controllers\MastersController::class, 'edit_department'])->name('edit.department');
Route::put('/update-department/{id}', [App\Http\Controllers\MastersController::class, 'update_department'])->name('update.department');
Route::delete('/delete-department/{id}', [App\Http\Controllers\MastersController::class, 'delete_department'])->name('delete.department');

// purpose of visiting 
Route::get('/visiting-purpose-list', [App\Http\Controllers\MastersController::class, 'visiting_purpose_list'])->name('list.visiting_purpose');
Route::get('/add-visiting-purpose', [App\Http\Controllers\MastersController::class, 'add_visiting_purpose'])->name('add.visiting_purpose');
Route::post('/store-visiting-purpose', [App\Http\Controllers\MastersController::class, 'store_visiting_purpose'])->name('store.visiting_purpose');
Route::get('/edit-visiting-pupose/{id}', [App\Http\Controllers\MastersController::class, 'edit_visiting_purpose'])->name('edit.visiting_purpose');
Route::put('/update-visiting-purpose/{id}', [App\Http\Controllers\MastersController::class, 'update_visiting_purpose'])->name('update.visiting_purpose');
Route::delete('/delete-visiting-purpose/{id}', [App\Http\Controllers\MastersController::class, 'delete_visiting_purpose'])->name('delete.visiting_purpose');

// user registration
Route::get('/users-list', [App\Http\Controllers\MastersController::class, 'users_list'])->name('list.users');
Route::get('/add-users', [App\Http\Controllers\MastersController::class, 'add_users'])->name('add.users');
Route::post('/store-users', [App\Http\Controllers\MastersController::class, 'store_users'])->name('store.users');
Route::get('/edit-users/{id}', [App\Http\Controllers\MastersController::class, 'edit_users'])->name('edit.users');
Route::put('/update-users/{id}', [App\Http\Controllers\MastersController::class, 'update_users'])->name('update.users');
Route::delete('/delete-users/{id}', [App\Http\Controllers\MastersController::class, 'delete_users'])->name('delete.users');

// pass made for 
Route::get('/pass-for-list', [App\Http\Controllers\MastersController::class, 'pass_for_list'])->name('list.pass_for');
Route::get('/add-pass-for', [App\Http\Controllers\MastersController::class, 'add_pass_for'])->name('add.pass_for');
Route::post('/store-pass-for', [App\Http\Controllers\MastersController::class, 'store_pass_for'])->name('store.pass_for');
Route::get('/edit-pass-for/{id}', [App\Http\Controllers\MastersController::class, 'edit_pass_for'])->name('edit.pass_for');
Route::put('/update-pass-for/{id}', [App\Http\Controllers\MastersController::class, 'update_pass_for'])->name('update.pass_for');
Route::delete('/delete-pass-for/{id}', [App\Http\Controllers\MastersController::class, 'delete_pass_for'])->name('delete.pass_for');

// pass validity master 
Route::get('/pass-validity-list', [App\Http\Controllers\MastersController::class, 'pass_validity_list'])->name('list.pass_validity');
Route::get('/add-pass-validity', [App\Http\Controllers\MastersController::class, 'add_pass_validity'])->name('add.pass_validity');
Route::post('/store-pass-validity', [App\Http\Controllers\MastersController::class, 'store_pass_validity'])->name('store.pass_validity');
Route::get('/edit-pass-validity/{id}', [App\Http\Controllers\MastersController::class, 'edit_pass_validity'])->name('edit.pass_validity');
Route::put('/update-pass-validity/{id}', [App\Http\Controllers\MastersController::class, 'update_pass_validity'])->name('update.pass_validity');
Route::delete('/delete-pass-validity/{id}', [App\Http\Controllers\MastersController::class, 'delete_pass_validity'])->name('delete.pass_validity');

// Special Pass routes

Route::get('/special-pass-visitor', [App\Http\Controllers\HomeController::class, 'special_pass'])->name('specialpass');
Route::get('/add-special-pass-visitor', [App\Http\Controllers\HomeController::class, 'add_specialpass'])->name('add.specialpass');
Route::post('/store-special-visitor-pass', [App\Http\Controllers\HomeController::class, 'store_special_pass'])->name('store.special_pass');
Route::get('/pending-special-pass', [App\Http\Controllers\HomeController::class, 'pending_special_pass'])->name('pending.special_pass');
Route::post('/special-pass-approved/{id}', [App\Http\Controllers\HomeController::class, 'special_pass_approval'])->name('approved.special_pass');

Route::get('/special-pass-view/{id}', [App\Http\Controllers\HomeController::class, 'special_pass_view'])->name('view.special_pass');
Route::post('/special-pass-reject/{id}', [App\Http\Controllers\HomeController::class, 'special_pass_reject'])->name('reject.special_pass');

// Change password routes
// Display the password change form
Route::get('/change-password',[App\Http\Controllers\ChangePasswordController::class, 'showChangePasswordForm'])->name('password.change');

// Handle the form submission
Route::post('/change-password', [App\Http\Controllers\ChangePasswordController::class, 'changePassword'])->name('password.update');

// term and condition & Privacy policy
Route::get('/term-condition', [App\Http\Controllers\HomeController::class, 'term_condition'])->name('term.condition');
Route::get('/privacy-policy', [App\Http\Controllers\HomeController::class, 'privacy_policy'])->name('privacy.policy');
