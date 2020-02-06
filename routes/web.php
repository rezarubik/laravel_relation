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
use App\Category;
use App\Role;
use Illuminate\Support\Str;

// Membuat User
Route::get('/create_users', function () {
    $user = User::create([
        'name' => 'Muhammad Reza Pahlevi Y',
        'email' => 'rezarubik17@gmail.com',
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
    $user = User::find(1);
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
    $user = User::find(1);
    $data = [
        'phone' => '08788221',
        'address' => 'Jl. Teluk Langsa 4 Blok C.8 No.4, Duren Sawit, Jakarta Timur'
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
        'title' => 'Title milik Member 1',
        'body' => 'Body milik Member 1'
    ];
    $user->posts()->create($data_post);
    return $user;
});
/**
 * Read data posts
 */
Route::get('/read_posts', function () {
    $user = User::findOrFail(1);
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
    // $post = Post::findOrFail(1);
    // // dd($post);
    // $post->categories()->create([
    //     'slug' => Str::slug('Belajar PHP', '-'),
    //     'category' => 'Belajar PHP'
    // ]);
    // return 'success';
    // Sekaligus membuat user, post, dan categories
    $user = User::create([
        'name' => 'Nadiah Tsamra Pratiwi',
        'email' => 'tspnadiah@gmail.com',
        'password' => bcrypt('password')
    ]);
    $user->posts()->create([
        'title' => 'Pyhsics is fun',
        'body' => 'Lets go to learn physics'
    ])->categories()->create([
        'slug' => Str::slug('Belajar Fisika', '-'),
        'category' => 'Belajar Fisika'
    ]);
    return 'Success';
});

/**
 * Read Data Categories
 */
Route::get('/read_category', function () {
    // Read data dari category. Mengakses data category berdasarkan data post.
    $post = Post::find(2);
    $categories = $post->categories;
    foreach ($categories as $category) {
        echo $category->slug . '</br>';
    }
    // Memanggil data category dengan id tertentu
    // $category = Category::find(1);
    // $posts = $category->posts;
    // foreach ($posts as $post) {
    //     echo $post->title . '</br>';
    // }
});
/**
 * Attaching Related Data Many To Many
 */
Route::get('/attach', function () {
    // Memberikan cateogry baru kepada post
    // $post = Post::find(2); // post dengan id = 2
    $post = Post::find(3); // post dengan id = 3
    // $post->categories()->attach(1); // memberikan data category 1 kepada post id 2
    $post->categories()->attach([1, 2, 3]); // memberikan data category 3 kepada post id 1, 2, 3
    return 'Attach Success';
});

/** 
 * Detaching Related Data Many To Many
 */
Route::get('/detach', function () {
    // Menghapus kategori pada post tertentu
    $post = Post::find(3);
    $post->categories()->detach([1, 2]);
    return 'Detach Success';
});
/**
 * Syncing Related Data untuk sinkronisasi data dengan Many To Many
 */
Route::get('/sync', function () {
    $post = Post::find(3);
    $post->categories()->sync([1, 3]);
    return 'Syncing Success';
});
/**
 * Hany Many Through Show Related Data
 */
Route::get('/role/posts', function () {
    $role = Role::find(2);
    return $role->posts;
});
/**
 * Polymorphic
 */
