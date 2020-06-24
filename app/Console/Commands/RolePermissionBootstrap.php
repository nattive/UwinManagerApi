<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionBootstrap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel_api:bootstrap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create roles and permissions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $roles = ["Director", "Supervisor", "Manager"];

        $permissions = [
            "View All Managers",
            "Review Report",
            "Create Manager's Forum",
            "Accept request",
            "Edit All Users",
            "De;ete User",
            "Assign Role",
            "Unassign Role",
            "View All Roles",
            "View All Permissions",
            "View All Roles"
        ];


        $this->line('------------- Setting Up Roles:');

        foreach ($roles as $role) {
            $role = Role::updateOrCreate(['name' => $role, 'guard_name' => 'api']);
            $this->info("Created " . $role->name . " Role");
        }

        $this->line('------------- Setting Up Permissions:');

        $superAdminRole = Role::where('name', "Director")->first();

        foreach ($permissions as $perm_name) {
            $permission = Permission::updateOrCreate([
                'name' => $perm_name,
                'guard_name' => 'api'
            ]);

            $superAdminRole->givePermissionTo($permission);

            $this->info("Created " . $permission->name . " Permission");
        }

        $this->info("All permissions are granted to Super Admin");
        $this->line('------------- Application Bootstrapping is Complete: \n');
    }
}
