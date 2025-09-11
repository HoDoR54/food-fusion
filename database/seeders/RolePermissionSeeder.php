<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = Role::where('name', 'Admin')->first();
        $moderator = Role::where('name', 'Moderator')->first();
        $user = Role::where('name', 'User')->first();

        if ($superAdmin) {
            $allPermissions = Permission::all();
            $superAdmin->permissions()->sync($allPermissions->pluck('id'));
        }

        if ($moderator) {
            $moderatorPermissions = Permission::whereIn('resource', [
                'recipes', 'blogs', 'ingredients', 'tags', 'comments',
            ])->get();
            $moderator->permissions()->sync($moderatorPermissions->pluck('id'));
        }

        if ($user) {
            $userPermissions = Permission::where(function ($query) {
                $query->where('resource', 'recipes')->whereIn('action', ['read', 'create'])
                    ->orWhere('resource', 'blogs')->whereIn('action', ['read', 'create'])
                    ->orWhere('resource', 'ingredients')->whereIn('action', ['read', 'create'])
                    ->orWhere('resource', 'tags')->whereIn('action', ['read', 'create'])
                    ->orWhere('resource', 'comments')->whereIn('action', ['create', 'read']);
            })->get();

            $user->permissions()->sync($userPermissions->pluck('id'));
        }

        $this->command->info('Role permissions assigned!');
    }
}
