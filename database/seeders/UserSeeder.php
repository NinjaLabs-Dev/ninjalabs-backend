<?php

namespace Database\Seeders;

use App\Models\Domain;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $user = new User;
        $user->name = "Ninja";
        $user->password = Hash::make('password');
        $user->save();

        $domain = new Domain;
        $domain->user_id = $user->id;
        $domain->domain = "ninjalabs.dev";
        $domain->sub = "cdn";
        $domain->default = true;
        $domain->save();
    }
}
