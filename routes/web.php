<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

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

// Route::get('/hello', function(){
//     //response(content, status, array hearders)
//     return response('<h1>Hello World</h1>')
//             ->header('Content-Type', 'text/plain')
//             ->header('foo', 'bar');
// });

// // Wildcard
// Route::get('/posts/{id}', function($id){
//     // dd($id);
//     // ddd($id);
//     return response('Post ' . $id);
// })->where('id', '[0-9]+'); // where id is a number


// // Request Query Param
// Route::get('/search', function(Request $request){
//     return $request->name . ' ' . $request->city;
// });

// All Listing
// Route::get('/', function () {
//     // View Basic and Passing Data
//     return view('listings', [
//         'listings' => Listing::all(), // Basic Model
//     ]);
// });

// Single Listing
// Route::get('/listing/{id}', function ($id) {

//     $listing = Listing::find($id);

//     if($listing){
//         // View Basic and Passing Data
//         return view('listing', [
//             'listing' => $listing,
//         ]);
//     }
//     else{
//         abort(404);
//     }
// });


//Route Model Binding
Route::get('/listing/{listing}', function (Listing $listing) {
    return view('listing', [
        'listing' => $listing,
    ]);
});

// Route with Controller: All Listing

// All Listing
Route::get('/', [ListingController::class, 'index']);

// Show Create Form
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

// Store Listing Data
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

// Show Edit Form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

// Update Listing
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

// Delete Listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

//Manage Listing
Route::get('/listings/manage',[ListingController::class, 'manage'])->middleware('auth');

// Route with Controller: Single Listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);

// Show Register/Create Form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

// Create New User
Route::post('/users', [UserController::class, 'store']);

// Log User Out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// Show Login Form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

// Login User
Route::post('/users/authenticate', [UserController::class, 'authenticate']);

