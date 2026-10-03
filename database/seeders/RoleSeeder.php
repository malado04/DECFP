<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = ['super-admin','ministere','regional-admin','centre-admin','jury','secretaire','lecteur','etudiant'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
    }
}


// @role('centre-admin')
//     <div class="alert alert-info">
//         Vous êtes connecté en tant que centre-admin.
//     </div>
// @endrole

// @hasanyrole('super-admin|ministere')
//     <a href="{{ route('admin.reports') }}" class="btn btn-primary">Rapports</a>
// @endhasanyrole
