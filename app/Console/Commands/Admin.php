<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class Admin extends Command
{
    protected $signature = 'doucsoft:admin';
    protected $description = 'Créer un utilisateur admin (ID 1) et lui attribuer le rôle admin si nécessaire';

    public function handle()
    {
        // Vérifie si l'utilisateur existe
        $user = User::find(1);

        if (!$user) {
            $this->info('Utilisateur #1 introuvable. Création...');

            $user = User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'), // Change le mot de passe ensuite
            ]);

            $this->info("Utilisateur créé avec succès : {$user->email}");
        }

        // Vérifie si le rôle 'admin' existe, sinon le crée
        if (!Role::where('name', 'admin')->exists()) {
            Role::create(['name' => 'admin']);
            $this->info("Rôle 'admin' créé.");
        }

        // Attribue le rôle à l'utilisateur s’il ne l’a pas déjà
        if (!$user->hasRole('admin')) {
            $user->assignRole('admin');
            $this->info("Rôle 'admin' assigné à l'utilisateur.");
        } else {
            $this->info("L'utilisateur a déjà le rôle 'admin'.");
        }
    }
}
