<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // 1️⃣ Créer les rôles
        $roles = [
            'super-admin', 'ministere', 'regional-admin', 
            'centre-admin', 'secretaire', 'jury', 'lecteur', 'etudiant'
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // 2️⃣ Créer les permissions
        $permissions = [
            'manage exams',
            'view results',
            'manage users',
            'manage candidates'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 3️⃣ Assigner des permissions aux rôles
        Role::where('name', 'super-admin')->first()->givePermissionTo(Permission::all());
        Role::where('name', 'ministere')->first()->givePermissionTo(['manage exams', 'view results']);
        Role::where('name', 'regional-admin')->first()->givePermissionTo(['manage exams', 'view results']);
        Role::where('name', 'centre-admin')->first()->givePermissionTo(['manage candidates']);
        Role::where('name', 'secretaire')->first()->givePermissionTo(['manage candidates']);
        Role::where('name', 'jury')->first()->givePermissionTo(['view results']);
        Role::where('name', 'lecteur')->first()->givePermissionTo(['view results']);
        Role::where('name', 'etudiant')->first()->givePermissionTo(['view results']);

        // 4️⃣ Créer des utilisateurs pour chaque rôle
        $users = [
            ['name' => 'Super Admin', 'email' => 'superadmin@example.com', 'role' => 'super-admin'],
            ['name' => 'Ministère', 'email' => 'ministere@example.com', 'role' => 'ministere'],
            ['name' => 'Admin Régional', 'email' => 'regional@example.com', 'role' => 'regional-admin'],
            ['name' => 'Admin Centre', 'email' => 'centreadmin@example.com', 'role' => 'centre-admin'],
            ['name' => 'Secrétaire', 'email' => 'secretaire@example.com', 'role' => 'secretaire'],
            ['name' => 'Jury', 'email' => 'jury@example.com', 'role' => 'jury'],
            ['name' => 'Lecteur', 'email' => 'lecteur@example.com', 'role' => 'lecteur'],
            ['name' => 'Étudiant', 'email' => 'etudiant@example.com', 'role' => 'etudiant'],
        ];

        foreach ($users as $u) {
            $user = User::firstOrCreate(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'password' => Hash::make('password') // mot de passe par défaut
                ]
            );
            $user->assignRole($u['role']);
        }

        $this->command->info('Rôles, permissions et utilisateurs créés avec succès !');
    }
}
