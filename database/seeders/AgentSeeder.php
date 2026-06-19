<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Roofy API: Seeds a default agent account and sample listings for the agent dashboard.
 */
class AgentSeeder extends Seeder
{
    public function run(): void
    {
        $agent = User::updateOrCreate(
            ['email' => 'agent@agent.com'],
            [
                'name' => 'Demo Agent',
                'userName' => 'demo_agent',
                'password' => Hash::make('agent123'),
                'role' => User::ROLE_AGENT,
                'phone' => '1111111111',
                'address' => '123 Agent Street',
            ]
        );

        Property::factory()->count(5)->create([
            'user_id' => $agent->id,
        ]);
    }
}
