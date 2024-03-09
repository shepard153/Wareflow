<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $arrayOfPermissionNames = [
            'manage users',
            'manage permissions',
            'manage products',
            'view products',
            'manage product categories',
            'view product categories',
            'manage warehouses',
            'view warehouses',
            'manage contacts',
            'view contacts',
            'manage shipments',
            'view shipments',
        ];

        $permissions = collect($arrayOfPermissionNames)->map(function (string $permission): array {
            return ['name' => $permission, 'guard_name' => 'web'];
        });

        Permission::insert($permissions->toArray());

        Role::create(['name' => 'warehouse_worker'])
            ->givePermissionTo([
                'view products',
                'view warehouses',
                'view contacts',
                'manage shipments',
                'view shipments',
            ]);

        Role::create(['name' => 'office_worker'])
            ->givePermissionTo([
                'manage products',
                'view products',
                'manage product categories',
                'view product categories',
                'manage warehouses',
                'view warehouses',
                'manage contacts',
                'view contacts',
                'manage shipments',
                'view shipments',
            ]);

        Role::create(['name' => 'admin'])->givePermissionTo([
            'manage users',
            'manage permissions',
            'view warehouses',
            'view contacts',
            'view shipments',
            'view products',
            'view product categories',
        ]);
    }
}
