<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $users = User::all();

        // Cada usuario crea al menos una compañía.
        foreach ($users as $user) {
            Company::create([
                'user_id' => $user->id,
                'name' => $user->name . "'s Company",
                'state' => 'CA', // Puedes variar el estado o asignarlo de forma aleatoria.
                'registered_agent_type' => 'user', // Inicialmente, el usuario se asigna a sí mismo.
                'registered_agent_id' => $user->id,
            ]);
        }
    }
}
