<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\friendController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ReviewsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication Routes
Route::prefix('auth')->group(function () {
    // Login Routes
    Route::get('/login', function () {
        if(Auth::check()) {
            return redirect()->route('profile');
        }
        return view('login');
    })->name('login.auth');

    Route::get('/login/admin', function () {
        if(Auth::check()) {
            return redirect()->route('profile');
        }
        return view('adminLogin');
    });

    Route::post('/login/checking', [UserController::class, 'login'])->name('login');

    // Registration Route
    Route::post('/register/checking', [UserController::class, 'register'])->name('register');

    // Logout Route
    Route::post('/logout', [UserController::class, 'logOut'])->name('logout');
});

// Profile Management (Authenticated User Routes)
Route::middleware(['auth.user'])->prefix('profile')->group(function () {
    Route::get('/', [UserController::class, 'getUserInfo'])->name('profile');
    Route::patch('/update/picture', [UserController::class, 'updateProfilePicture'])->name('profile.update.picture');
    Route::patch('/update/background', [UserController::class, 'updateBackground'])->name('profile.update.background');
    Route::put('/update', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::patch('/update/password', [UserController::class, 'updatePassword'])->name('password.update');
    Route::delete('/delete', [UserController::class, 'deleteAccount'])->name('profile.delete');
});

// Admin Routes
Route::middleware(['auth.admin'])->prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin');
    })->name('admin.dashboard');
});

// Friends Route
Route::prefix('friend')->group(function () {
    Route::get('/', [FriendController::class, 'index'])->name('friends');
    Route::post('/search', [FriendController::class, 'searchFriend'])->name('search.friend');
    Route::post('/addFriend/{id}', [FriendController::class, 'addFriend'])->name('addFriend.friend');
    Route::patch('/request/accept/{id}', [FriendController::class, "acceptRequest"])->name('accept.request.friend');
    Route::delete('/request/reject/{id}', [FriendController::class, "rejectRequest"])->name('reject.request.friend');
});

// Friend Route
Route::prefix('media')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('post.media');
    Route::post('/create/post', [PostController::class, 'createPost'])->name('post.create.media');
    Route::delete('/delete/post/{id}', [PostController::class, 'delete'])->name('post.delete.media');
    Route::put('/update/post/{id}', [PostController::class, 'update'])->name('post.update');
    Route::post('/create/comment/post/{id}', [CommentController::class, 'create'])->name('post.create.comment');
    Route::patch('/edit/comment/post/{id}', [CommentController::class, 'edit'])->name('edit.comment.media');
    Route::delete('/delete/comment/post/{id}', [CommentController::class, 'delete'])->name('delete.comment.media');
});

Route::prefix('biblio')->group(function () {
    Route::get('/',  [RecipeController::class, 'index'])->name('library.recipe');
    Route::post('/make/recipe/', [RecipeController::class, 'create'])->name('make.recipe');
    Route::post('/create/recipe/', [RecipeController::class, 'create'])->name('create.recipe');
    Route::post('/search/categorie', [RecipeController::class, 'searchCategorie'])->name('search.categorie');
    Route::get('/biblio/recipe/{id}', [RecipeController::class, 'SelectRecipe'])->name('get.recipe');
    Route::put('/edit/recipe/{id}', [RecipeController::class, 'editRecipe'])->name('edit.recipe');
    Route::put('/edit/recipe/', [RecipeController::class, 'searchCategorie'])->name('searchCategorie');
    Route::delete('/delete/recipe/{id}', [RecipeController::class, 'deleteRecipe'])->name('delete.recipe');
    Route::post('/recipe/add/favorite/{id}', [FavoriteController::class, 'addFavorite'])->name('add.favorite.recipe');
    Route::delete('/recipe/delete/favorite/{id}', [FavoriteController::class, 'removeFavorite'])->name('remove.favorite.recipe');
    Route::post('/search/recipe', [RecipeController::class, 'searchRecipe'])->name('search.recipe');
    Route::delete('/remove/favorite/{id}', [FavoriteController::class, 'removeFavorite'])->name('remove.favorite.recipe');
    Route::post('/create/reviews/{id}', [ReviewsController::class, 'create'])->name('create.reviews.recipe');
    Route::put('/edit/review/{id}', [ReviewsController::class, 'edit'])->name('edit.review.recipe');
    Route::delete('/remove/review/{id}', [ReviewsController::class, 'remove'])->name('remove.review.recipe');
});

// Application Routes
Route::prefix('app')->group(function () {

    // Route::get('/recipes', function () {
    //     return view('recipe');
    // })->name('app.recipes');

});
