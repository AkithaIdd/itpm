<?php

namespace App\Providers;

use App\Role;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $user = \Auth::user();

        
        // Auth gates for: User management
        Gate::define('user_management_access', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Roles
        Gate::define('role_access', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('role_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('role_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('role_view', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('role_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Users
        Gate::define('user_access', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('user_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('user_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('user_view', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('user_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Courses
        Gate::define('course_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('course_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('course_edit', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('course_view', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('course_delete', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Coursematerials
        Gate::define('coursematerial_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('coursematerial_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('coursematerial_edit', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('coursematerial_view', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('coursematerial_delete', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Assignments
        Gate::define('assignment_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('assignment_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('assignment_edit', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('assignment_view', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('assignment_delete', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Library
        Gate::define('library_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('library_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('library_edit', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('library_view', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('library_delete', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Notices
        Gate::define('notice_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('notice_create', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('notice_edit', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('notice_view', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('notice_delete', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });

    }
}
