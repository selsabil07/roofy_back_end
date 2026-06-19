<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Roofy API: Seeds admin, demo agent, sample agents, clients, and their listings.
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            AgentSeeder::class,
        ]);

        User::factory(3)->create(['role' => User::ROLE_AGENT])->each(function ($agent) {
            Property::factory()->count(rand(2, 6))->create([
                'user_id' => $agent->id,
            ]);
        });

        User::factory(5)->create(['role' => User::ROLE_USER]);
    }
}
