<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        // create permissions
        Permission::create(['name' =>"Review Report"]);
        Permission::create(['name' =>"Create Manager's Forum"]);
        Permission::create(['name' =>"Accept request"]);
        Permission::create(['name' =>"Edit All Users"]);
        Permission::create(['name' =>"De;ete User"]);
        Permission::create(['name' =>"Assign Role"]);
        Permission::create(['name' =>"Unassign Role"]);
        Permission::create(['name' =>"View All Permissions"]);
        Permission::create(['name' =>"View All Roles"]);
        Permission::create(['name' =>"create/delete manager"]);
        Permission::create(['name' =>"Admin chat group"]);
        Permission::create(['name' => "create supervisor"]);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'supervisor']);
        $role1->givePermissionTo("Review Report");
        $role1->givePermissionTo("Create Manager's Forum");
        $role1->givePermissionTo("Accept request");
        $role1->givePermissionTo("Edit All Users");
        $role1->givePermissionTo("De;ete User");
        $role1->givePermissionTo("Assign Role");
        $role1->givePermissionTo("Unassign Role");
        $role1->givePermissionTo("View All Permissions");
        $role1->givePermissionTo("View All Roles");
        $role1->givePermissionTo("create/delete manager");
        $role1->givePermissionTo("Admin chat group");
        
        $role2 = Role::create(['name' => 'Director']);
        $role1->givePermissionTo("Admin chat group");
        $role2->givePermissionTo('create supervisor');
        $role2->givePermissionTo("Review Report");
        $role2->givePermissionTo("Create Manager's Forum");
        $role2->givePermissionTo("Accept request");
        $role2->givePermissionTo("Edit All Users");
        $role2->givePermissionTo("De;ete User");
        $role2->givePermissionTo("Assign Role");
        $role2->givePermissionTo("Unassign Role");
        $role2->givePermissionTo("View All Permissions");
        $role2->givePermissionTo("View All Roles");
        $role2->givePermissionTo("create/delete manager");

        $user = Factory(App\User::class)->create([
            'name' => 'Director',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456789') ,
        ]);

        $user->assignRole($role2);
    }
}
