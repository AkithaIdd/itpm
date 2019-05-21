<?php
Route::get('/', 'HomeController@index');
Route::get('courses/{id}', ['uses' => 'CoursesController@show', 'as' => 'courses.show']);
Route::get('/profile', 'PagesController@profile');
Route::get('/library', 'PagesController@library');


// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
$this->post('login', 'Auth\LoginController@login')->name('auth.login');
$this->post('logout', 'Auth\LoginController@logout')->name('auth.logout');

// Registration Routes...
$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('auth.register');
$this->post('register', 'Auth\RegisterController@register')->name('auth.register');

// Change Password Routes...
$this->get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
$this->patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.reset');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('home', 'DashboardController@index');
    Route::resource('roles', 'Admin\RolesController');
    Route::post('roles_mass_destroy', ['uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);
    Route::resource('users', 'Admin\UsersController');
    Route::post('users_mass_destroy', ['uses' => 'Admin\UsersController@massDestroy', 'as' => 'users.mass_destroy']);
    Route::resource('courses', 'Admin\CoursesController');
    Route::post('courses_mass_destroy', ['uses' => 'Admin\CoursesController@massDestroy', 'as' => 'courses.mass_destroy']);
    Route::post('courses_restore/{id}', ['uses' => 'Admin\CoursesController@restore', 'as' => 'courses.restore']);
    Route::delete('courses_perma_del/{id}', ['uses' => 'Admin\CoursesController@perma_del', 'as' => 'courses.perma_del']);
    Route::resource('coursematerials', 'Admin\CoursematerialsController');
    Route::post('coursematerials_mass_destroy', ['uses' => 'Admin\CoursematerialsController@massDestroy', 'as' => 'coursematerials.mass_destroy']);
    Route::post('coursematerials_restore/{id}', ['uses' => 'Admin\CoursematerialsController@restore', 'as' => 'coursematerials.restore']);
    Route::delete('coursematerials_perma_del/{id}', ['uses' => 'Admin\CoursematerialsController@perma_del', 'as' => 'coursematerials.perma_del']);
    Route::resource('assignments', 'Admin\AssignmentsController');
    Route::post('assignments_mass_destroy', ['uses' => 'Admin\AssignmentsController@massDestroy', 'as' => 'assignments.mass_destroy']);
    Route::post('assignments_restore/{id}', ['uses' => 'Admin\AssignmentsController@restore', 'as' => 'assignments.restore']);
    Route::delete('assignments_perma_del/{id}', ['uses' => 'Admin\AssignmentsController@perma_del', 'as' => 'assignments.perma_del']);
    Route::resource('libraries', 'Admin\LibrariesController');
    Route::post('libraries_mass_destroy', ['uses' => 'Admin\LibrariesController@massDestroy', 'as' => 'libraries.mass_destroy']);
    Route::post('libraries_restore/{id}', ['uses' => 'Admin\LibrariesController@restore', 'as' => 'libraries.restore']);
    Route::delete('libraries_perma_del/{id}', ['uses' => 'Admin\LibrariesController@perma_del', 'as' => 'libraries.perma_del']);
    Route::resource('notices', 'Admin\NoticesController');
    Route::post('notices_mass_destroy', ['uses' => 'Admin\NoticesController@massDestroy', 'as' => 'notices.mass_destroy']);
    Route::post('notices_restore/{id}', ['uses' => 'Admin\NoticesController@restore', 'as' => 'notices.restore']);
    Route::delete('notices_perma_del/{id}', ['uses' => 'Admin\NoticesController@perma_del', 'as' => 'notices.perma_del']);
    Route::post('/spatie/media/upload', 'Admin\SpatieMediaController@create')->name('media.upload');
    Route::post('/spatie/media/remove', 'Admin\SpatieMediaController@destroy')->name('media.remove');



 
});
