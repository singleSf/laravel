<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

Route::get(
    '/', function () {
    return view('welcome');
}
);

Route::get(
    '/news/{page?}', [
    \App\Http\Controllers\NewListController::class,
    'index',
]
)->name('news');

Route::get(
    '/storage/public/new-list/{id}.{extension}', function (int $_id) {
    /** @var \App\Models\File $file */
    $file = \App\Models\File::find($_id);

    if (!$file) {
        abort(404);
    }
    $stream = Storage::disk('local')->get($file->getUri());

    return response($stream)->header('Content-Disposition', 'attachment; filename="image.'.$file->extension.'"');
}
);

Route::get(
    '/dashboard', function () {
    return view('dashboard');
}
)->middleware(
    [
        'auth',
        'verified',
    ]
)->name('dashboard');

Route::middleware('auth')->group(
    function () {
        Route::get(
            '/profile', [
            ProfileController::class,
            'edit',
        ]
        )->name('profile.edit');
        Route::patch(
            '/profile', [
            ProfileController::class,
            'update',
        ]
        )->name('profile.update');
        Route::delete(
            '/profile', [
            ProfileController::class,
            'destroy',
        ]
        )->name('profile.destroy');
    }
);

require __DIR__.'/auth.php';
