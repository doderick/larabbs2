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

// 主页相关路由
Route::get('/', 'TopicsController@index')->name('home');

// Auth 相关路由
//Auth::routes();

// 等价于
// register 相关路由
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Authentication 相关路由
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset 相关路由
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendRestLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
//

// Users 相关路由
Route::resource('users', 'UsersController', ['only' => ['show', 'edit', 'update']]);

// Topics 相关路由
Route::resource('topics', 'TopicsController', ['only' => ['index', 'create', 'store', 'edit', 'update', 'destroy']]);
Route::get('topics/{topic}/{slug?}', 'TopicsController@show')->name('topics.show');

// Categories 相关路由
Route::resource('categories', 'CategoriesController', ['only' => ['show']]);

// 图片上传相关路由
Route::post('upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');

// Replies 相关路由
Route::resource('replies', 'RepliesController', ['only' => ['store', 'destroy']]);

// Notifications 相关路由
Route::resource('notifications', 'NotificationsController', ['only' => ['index']]);

// 后台权限验证失败后的路由
Route::get('permission-denied', 'PagesController@permissionDenied')->name('permission-denied');

// 关注与取消关注相关路由
Route::post('users/followers/{user}', 'FollowersController@store')->name('followers.store');
Route::delete('users/followers/{user}', 'FollowersController@destroy')->name('followers.destroy');




Route::get('users/{user}/topics', 'UsersController@showTopics')->name('show.topics');
Route::get('users/{user}/replies', 'UsersController@showReplies')->name('show.replies');
Route::get('users/{user}/followers', 'UsersController@showFollowers')->name('show.followers');
Route::get('users/{user}/followings', 'UsersController@showFollowings')->name('show.followings');