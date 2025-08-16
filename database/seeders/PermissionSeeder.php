<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resources = [
            'users',
            'roles',
            'permissions',
            'recipes',
            'blogs',
            'ingredients',
            'tags',
            'comments',
        ];

        $actions = ['create', 'read', 'update', 'delete'];

        foreach ($resources as $resource) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'action' => $action,
                    'resource' => $resource,
                ]);
            }
        }

        $this->command->info('Permissions seeded successfully!');
    }
}
