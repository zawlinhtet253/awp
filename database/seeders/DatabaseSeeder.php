<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\IndustryType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(20)->create();
        Client::factory(30)->create();

        // Create admin user only if it doesn't exist
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]);
        }

        // Seed industry types from business_activity.json
        $this->seedIndustryTypes();

        // Seed client-industry relationships
        $this->seedClientIndustryRelationships();
    }

    /**
     * Seed industry types from business_activity.json
     */
    private function seedIndustryTypes(): void
    {
        $jsonPath = 'C:/Users/tuf/Desktop/audit-front-end/business_activity.json';
        
        if (File::exists($jsonPath)) {
            $jsonContent = File::get($jsonPath);
            $industryTypes = json_decode($jsonContent, true);
            
            if (is_array($industryTypes) && !empty($industryTypes)) {
                $seededCount = 0;
                foreach ($industryTypes as $industry) {
                    // Only create if the industry type doesn't already exist
                    if (!IndustryType::where('code', $industry['code'])->exists()) {
                        IndustryType::create([
                            'code' => $industry['code'],
                            'name' => $industry['name'],
                        ]);
                        $seededCount++;
                    }
                }
                
                $this->command->info('Successfully seeded ' . $seededCount . ' new industry types.');
            } else {
                $this->command->error('Invalid JSON format or empty data in business_activity.json');
            }
        } else {
            $this->command->error('business_activity.json file not found at: ' . $jsonPath);
        }
    }

    /**
     * Seed client-industry relationships with specific pattern
     */
    private function seedClientIndustryRelationships(): void
    {
        $clients = Client::all();
        $industryTypes = IndustryType::all();
        
        if ($clients->isEmpty() || $industryTypes->isEmpty()) {
            $this->command->warning('No clients or industry types found for relationship seeding.');
            return;
        }

        $totalClients = $clients->count();
        $totalIndustries = $industryTypes->count();
        $relationshipsCreated = 0;

        foreach ($clients as $client) {
            // Calculate how many industry types this client should have
            // Pattern: client_id 1-5 has 1-5 industries, client_id 6-10 has 1-5 industries, etc.
            $industryCount = (($client->id - 1) % 5) + 1;
            
            // Ensure we don't request more industries than available
            $industryCount = min($industryCount, $totalIndustries);
            
            // Get random industry types for this client
            $randomIndustryTypes = $industryTypes->random($industryCount);
            
            // Attach the industry types to the client
            foreach ($randomIndustryTypes as $industryType) {
                $client->industryTypes()->attach($industryType->id);
                $relationshipsCreated++;
            }
        }
        
        $this->command->info('Successfully created ' . $relationshipsCreated . ' client-industry relationships.');
    }
}