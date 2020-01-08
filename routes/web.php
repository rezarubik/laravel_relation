<?php

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
    return view('welcome');
});

use App\User;
use App\Profile;
use App\Post;

// Membuat User
Route::get('/create_users', function () {
    $user = User::create([
        'name' => 'Nadiah Tsamara Pratiwi',
        'email' => 'nadiah@gmail.com',
        'password' => bcrypt('password')
    ]);
    return $user;
});
// Membuat Profile
Route::get('/create_profile', function () {
    // $profile = Profile::create([
    //     'user_id' => 1,
    //     'phone' => '089501011011',
    //     'address' => 'Jl. Teluk Langsa 4'
    // ]);
    $user = User::find(1);
    $data = [
        'phone' => '089501011011',
        'address' => 'Jl. Teluk Langsa 4'
    ];
    return $user->profile()->create($data);
});
// Membuat user profile
Route::get('/create_users_profile', function () {
    $user = User::find(5);
    $profile = new Profile([
        'phone' => '089501011011',
        'address' => 'Jl. Teluk Langsa 4 Blok C.8 No.4 Duren Sawit, Jakarta Timur'
    ]);
    $user->profile()->save($profile);
    return $user;
});
// Read Data User
Route::get('/read_user', function () {
    $user = User::find(1);
    $data = [
        'id' => $user->id,
        'name' => $user->name,
        'phone' => $user->profile->phone,
        'address' => $user->profile->address
    ];
    return $data;
});
// Read Data Profile
Route::get('/read_profile', function () {
    $profile = Profile::where('phone', '089501011011')->first();
    $data = [
        'user_id' => $profile->user->id,
        'name' => $profile->user->name,
        'email' => $profile->user->email,
        'phone' => $profile->phone,
        'address' => $profile->address
    ];
    return $data;
});
// Update data Profile
Route::get('/update_profile', function () {
    $user = User::find(2);
    $data = [
        'phone' => '08788221',
        'address' => 'Jl. Kalibata Tengah XVIII No. 29 Jakarta Selatan'
    ];
    $user->profile->update($data);
    return $user;
});
// Delete profile
Route::get('/delete_profile', function () {
    $user = User::find(1);
    $user->profile->delete();
    return $user;
});
/**
 * Membuat data posts, create posts
 */
Route::get('/create_post', function () {
    // $data_user = [
    //     'name' => 'rezarubik',
    //     'email' => 'reza.pahlevi.oa@gmail.com',
    //     'password' => bcrypt('password')
    // ];
    // $user = User::create($data_user);
    $user = User::findOrFail(2);
    $data_post = [
        'title' => 'Physics is Fun',
        'body' => 'Lets go to learn physics with fun learning!'
    ];
    $user->posts()->create($data_post);
    return $user;
});
/**
 * Read data posts
 */
Route::get('/read_posts', function () {
    $user = User::findOrFail(5);
    $posts = $user->posts()->get();
    foreach ($posts as $post) {
        $data[] = [
            'name' => $post->user->name,
            'email' => $post->user->email,
            'phone' => $user->profile->phone,
            'address' => $user->profile->address,
            'post_id' => $post->id,
            'title' => $post->title,
            'body' => $post->body
        ];
    }
    return $data;
});
/**
 * Update data post
 */
Route::get('/update_post', function () {
    $user = User::findOrFail(5);
    $data = [
        'title' => 'From Zero to a Pro Web Programming',
        'body' => 'Buku Pemrograman Website'
    ];
    $user->posts()->where('id', 1)->update($data);
    return $user;
});
/**
 * Delete data post
 */
Route::get('/delete_post', function () {
    $user = User::findOrFail(5);
    $user->posts()->where('id', 2)->delete();
    return $user;
});
/**
 * Create Data Categories
 */
Route::get('/create_categories', function () {
    $post = Post::findOrFail(1);
    $data = [
        'slug' => Str::slug('Belajar Laravel', '-'),
        'category' => 'Belajar Laravel'
    ];
    $post->categories()->create($data);
});
