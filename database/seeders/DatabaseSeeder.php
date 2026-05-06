<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Engagement;
use App\Models\FsMapping;
use App\Models\IndustryType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
        Engagement::factory(20)->create();

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

        // Seed engagement staff assignments
        $this->seedEngagementStaff();

        // Seed fs_mappings from grouping-1.json
        $this->seedFsMappings();
    }

    /**
     * Seed industry types from business_activity.json
     */
    private function seedIndustryTypes(): void
    {
        $data = [
            ["code" => "01", "name" => "Crop and animal production, hunting and related service activities"],
            ["code" => "02", "name" => "Forestry and logging"],                                                    
            ["code" => "03", "name" => "Fishing and aquaculture"],
            ["code" => "05", "name" => "Mining of coal and lignite"],
            ["code" => "06", "name" => "Extraction of crude petroleum and natural gas"],
            ["code" => "07", "name" => "Mining of metal ores"],
            ["code" => "08", "name" => "Other mining and quarrying"],
            ["code" => "09", "name" => "Mining support service activities"],
            ["code" => "10", "name" => "Manufacture of food products"],
            ["code" => "11", "name" => "Manufacture of beverages"],
            ["code" => "12", "name" => "Manufacture of tobacco products"],
            ["code" => "13", "name" => "Manufacture of textiles"],
            ["code" => "14", "name" => "Manufacture of wearing apparel"],
            ["code" => "15", "name" => "Manufacture of leather and related products"],
            ["code" => "16", "name" => "Manufacture of wood and products of wood and cork"],
            ["code" => "17", "name" => "Manufacture of paper and paper products"],
            ["code" => "18", "name" => "Printing and reproduction of recorded media"],
            ["code" => "19", "name" => "Manufacture of coke and refined petroleum products"],
            ["code" => "20", "name" => "Manufacture of chemicals and chemical products"],
            ["code" => "21", "name" => "Manufacture of basic pharmaceutical products"],
            ["code" => "22", "name" => "Manufacture of rubber and plastics products"],
            ["code" => "23", "name" => "Manufacture of other non-metallic mineral products"],
            ["code" => "24", "name" => "Manufacture of basic metals"],
            ["code" => "25", "name" => "Manufacture of fabricated metal products"],
            ["code" => "26", "name" => "Manufacture of computer, electronic and optical products"],
            ["code" => "27", "name" => "Manufacture of electrical equipment"],
            ["code" => "28", "name" => "Manufacture of machinery and equipment"],
            ["code" => "29", "name" => "Manufacture of motor vehicles, trailers and semi-trailers"],
            ["code" => "30", "name" => "Manufacture of other transport equipment"],
            ["code" => "31", "name" => "Manufacture of furniture"],
            ["code" => "32", "name" => "Other manufacturing"],
            ["code" => "33", "name" => "Repair and installation of machinery and equipment"],
            ["code" => "35", "name" => "Electricity, gas, steam and air conditioning supply"],
            ["code" => "36", "name" => "Water collection"],
            ["code" => "37", "name" => "Sewerage"],
            ["code" => "38", "name" => "Waste collection, treatment and disposal"],
            ["code" => "41", "name" => "Construction of buildings"],
            ["code" => "42", "name" => "Civil engineering"],
            ["code" => "43", "name" => "Specialized construction activities"],
            ["code" => "45", "name" => "Wholesale and retail trade and repair of motor vehicles"],
            ["code" => "46", "name" => "Wholesale trade"],
            ["code" => "47", "name" => "Retail trade"],
            ["code" => "49", "name" => "Land transport and transport via pipelines"],
            ["code" => "50", "name" => "Water transport"],
            ["code" => "51", "name" => "Air transport"],
            ["code" => "52", "name" => "Warehousing and support activities for transportation"],
            ["code" => "53", "name" => "Postal and courier activities"],
            ["code" => "55", "name" => "Accommodation"],
            ["code" => "56", "name" => "Food and beverage service activities"],
            ["code" => "58", "name" => "Publishing activities"],
            ["code" => "59", "name" => "Motion picture, video and television production"],
            ["code" => "60", "name" => "Programming and broadcasting activities"],
            ["code" => "61", "name" => "Telecommunications"],
            ["code" => "62", "name" => "Computer programming, consultancy"],
            ["code" => "63", "name" => "Information service activities"],
            ["code" => "64", "name" => "Financial service activities"],
            ["code" => "65", "name" => "Insurance, reinsurance and pension funding"],
            ["code" => "66", "name" => "Activities auxiliary to financial service"],
            ["code" => "68", "name" => "Real estate activities"],
            ["code" => "69", "name" => "Legal and accounting activities"],
            ["code" => "70", "name" => "Activities of head offices"],
            ["code" => "71", "name" => "Architectural and engineering activities"],
            ["code" => "72", "name" => "Scientific research and development"],
            ["code" => "73", "name" => "Advertising and market research"],
            ["code" => "74", "name" => "Other professional, scientific and technical activities"],
            ["code" => "75", "name" => "Veterinary activities"],
            ["code" => "77", "name" => "Rental and leasing activities"],
            ["code" => "78", "name" => "Employment activities"],
            ["code" => "79", "name" => "Travel agency, tour operator"],
            ["code" => "80", "name" => "Security and investigation activities"],
            ["code" => "81", "name" => "Services to buildings and landscape activities"],
            ["code" => "82", "name" => "Office administrative support activities"],
            ["code" => "84", "name" => "Public administration and defence"],
            ["code" => "85", "name" => "Education"],
            ["code" => "86", "name" => "Human health activities"], 
            ["code" => "87", "name" => "Residential care activities"],
            ["code" => "88", "name" => "Social work activities"],
            ["code" => "90", "name" => "Creative, arts and entertainment activities"],
            ["code" => "91", "name" => "Libraries, archives, museums"],
            ["code" => "92", "name" => "Gambling and betting activities"],
            ["code" => "93", "name" => "Sports activities and recreation"],
            ["code" => "94", "name" => "Activities of membership organizations"],
            ["code" => "95", "name" => "Repair of computers and personal goods"],
            ["code" => "96", "name" => "Other personal service activities"],
            ["code" => "97", "name" => "Activities of households as employers"],
            ["code" => "98", "name" => "Undifferentiated goods-producing activities"],
            ["code" => "99", "name" => "Activities of extraterritorial organizations"],
        ];
        $industries = collect();

        foreach ($data as $item) {
            $industry = IndustryType::firstOrCreate(
                ['code' => $item['code']],
                ['name' => $item['name']]
            );

            $industries->push($industry);
        }

        $this->command->info("Industries seeded: " . $industries->count());
    }

    /**
     * Seed client-industry relationships with specific pattern
     */
    private function seedClientIndustryRelationships(): void
{
    $clients = Client::all();
    $industries = IndustryType::all();

    if ($clients->isEmpty() || $industries->isEmpty()) {
        $this->command->warning('No clients or industries found.');
        return;
    }

    $total = 0;

    foreach ($clients as $client) {

        // Pattern: 1 → 5 then repeat
        $industryCount = (($client->id - 1) % 5) + 1;

        // Safety (if industries < 5)
        $industryCount = min($industryCount, $industries->count());

        // Get random industries
        $selected = $industries->random($industryCount)->pluck('id')->toArray();

        // Attach without duplicate
        $client->industryTypes()->syncWithoutDetaching($selected);

        $total += count($selected);
    }

    $this->command->info("Created {$total} relationships.");
}

/**
 * Seed engagement staff assignments with role matching and minimum requirements
 */
private function seedEngagementStaff(): void
{
    $engagements = Engagement::all();
    
    foreach ($engagements as $engagement) {
        // Get the partner who created the engagement
        $partnerUser = User::find($engagement->created_by);
        
        // Ensure the creator is a partner
        if ($partnerUser->role !== 'partner') {
            // Find a partner user to reassign
            $partnerUser = User::where('role', 'partner')->first();
            if ($partnerUser) {
                $engagement->update(['created_by' => $partnerUser->id]);
            }
        }
        
        // Get users with specific roles for this engagement
        $partner = $partnerUser;
        $manager = User::where('role', 'manager')->inRandomOrder()->first();
        $senior = User::where('role', 'senior')->inRandomOrder()->first();
        $staff = User::where('role', 'staff')->inRandomOrder()->first();
        
        // Create staff assignments with role matching user role
        $staffAssignments = [
            ['user' => $partner, 'role' => 'partner'],
            ['user' => $manager, 'role' => 'manager'],
            ['user' => $senior, 'role' => 'senior'],
            ['user' => $staff, 'role' => 'staff'],
        ];
        
        foreach ($staffAssignments as $assignment) {
            if ($assignment['user']) {
                \App\Models\EngagementStaff::create([
                    'engagement_id' => $engagement->id,
                    'user_id' => $assignment['user']->id,
                    'role_on_engagement' => $assignment['role'],
                    'assigned_by' => $partner->id,
                    'assigned_at' => now(),
                ]);
            }
        }
        
        // Add some additional random staff members if available
        $assignedUserIds = array_map(function($assignment) {
            return $assignment['user']->id;
        }, array_filter($staffAssignments, function($assignment) {
            return !is_null($assignment['user']);
        }));
        
        $additionalUsers = User::whereIn('role', ['staff', 'senior'])
            ->whereNotIn('id', $assignedUserIds)
            ->inRandomOrder()
            ->limit(rand(0, 3))
            ->get();
        
        foreach ($additionalUsers as $user) {
            \App\Models\EngagementStaff::create([
                'engagement_id' => $engagement->id,
                'user_id' => $user->id,
                'role_on_engagement' => $user->role,
                'assigned_by' => $partner->id,
                'assigned_at' => now(),
            ]);
        }
    }
    
    $this->command->info("Created engagement staff assignments for " . $engagements->count() . " engagements");
}

    /**
     * Seed fs_mappings from grouping-1.json
     */
    private function seedFsMappings(): void
    {
        // Use the correct path for fs_mappings data
        $jsonPath = 'c:\\Users\\tuf\\Desktop\\audit-front-end\\data\\groupings\\grouping-1.json';
        
        if (!file_exists($jsonPath)) {
            $this->command->error('FS Mapping JSON file not found: ' . $jsonPath);
            return;
        }
        
        $jsonData = file_get_contents($jsonPath);
        $data = json_decode($jsonData, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->command->error('Failed to parse JSON: ' . json_last_error_msg());
            return;
        }
        
        if (empty($data)) {
            $this->command->warn('No data found in JSON file');
            return;
        }
        
        $mappings = collect();

        foreach ($data as $item) {
            $mapping = FsMapping::firstOrCreate(
                ['mapping_no' => $item['mappingNo']],
                [
                    'acc_code' => $item['accCode'],
                    'fs_group' => $item['fsGroup'] ?? '',
                    'fs_line' => $item['fsLine'],
                    'ls' => $item['ls'] ?? '',
                    'ls_name' => $item['lsName'] ?? '',
                    'mapping_no' => $item['mappingNo'],
                ]
            );

            $mappings->push($mapping);
        }

        $this->command->info("FS Mappings seeded: " . $mappings->count());
    }
}