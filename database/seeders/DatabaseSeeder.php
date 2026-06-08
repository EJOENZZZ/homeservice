<?php

namespace Database\Seeders;

use App\Models\Professional;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $pros = [
            [
                'first_name'  => 'Grace',
                'last_name'   => 'Dela Cruz',
                'email'       => 'superadmin@homefix.app',
                'password'    => Hash::make('Superadmin@12345'),
                'specialty'   => 'Plumbing',
                'badge'       => 'ELITE',
                'rating'      => 5.00,
                'jobs_count'  => 451,
                'hourly_rate' => 350,
                'location'    => 'Cebu City',
                'bio'         => 'Expert plumber with over 10 years of experience in residential and commercial plumbing.',
            ],
            [
                'first_name'  => 'Marco',
                'last_name'   => 'Reyes',
                'email'       => 'superadmin2@homefix.app',
                'password'    => Hash::make('Superadmin@12345'),
                'specialty'   => 'Electrical',
                'badge'       => 'TOP PRO',
                'rating'      => 4.98,
                'jobs_count'  => 312,
                'hourly_rate' => 400,
                'location'    => 'Mandaue City',
                'bio'         => 'Licensed electrician specializing in panel upgrades, wiring, and electrical repairs.',
            ],
            [
                'first_name'  => 'Ana',
                'last_name'   => 'Santos',
                'email'       => 'superadmin3@homefix.app',
                'password'    => Hash::make('Superadmin@12345'),
                'specialty'   => 'Carpentry',
                'badge'       => 'VERIFIED',
                'rating'      => 4.97,
                'jobs_count'  => 284,
                'hourly_rate' => 300,
                'location'    => 'Lapu-Lapu City',
                'bio'         => 'Skilled carpenter offering custom furniture, cabinetry, and woodwork solutions.',
            ],
            [
                'first_name'  => 'Luis',
                'last_name'   => 'Bautista',
                'email'       => 'superadmin4@homefix.app',
                'password'    => Hash::make('Superadmin@12345'),
                'specialty'   => 'Cleaning',
                'badge'       => 'TOP PRO',
                'rating'      => 4.95,
                'jobs_count'  => 198,
                'hourly_rate' => 250,
                'location'    => 'Talisay City',
                'bio'         => 'Professional cleaner offering deep cleaning, move-in/out, and regular home cleaning services.',
            ],
            [
                'first_name'  => 'Maria',
                'last_name'   => 'Fernandez',
                'email'       => 'superadmin5@homefix.app',
                'password'    => Hash::make('Superadmin@12345'),
                'specialty'   => 'Painting',
                'badge'       => 'ELITE',
                'rating'      => 4.99,
                'jobs_count'  => 376,
                'hourly_rate' => 320,
                'location'    => 'Cebu City',
                'bio'         => 'Expert painter with experience in interior and exterior painting, wallpaper installation, and finishing.',
            ],
        ];

        foreach ($pros as $data) {
            Professional::updateOrCreate(
                ['email' => $data['email']],
                array_merge($data, [
                    'is_active'           => true,
                    'is_verified'         => true,
                    'must_change_password' => false,
                ])
            );
        }

        $reviews = [
            ['Maria Garcia',   'Marco fixed our electrical panel quickly and professionally. Highly recommend!'],
            ['Jose Reyes',     'Grace did an amazing job with our bathroom pipes. Fast, clean, and affordable.'],
            ['Elena Torres',   'Ana built custom shelves for our living room. Absolutely beautiful craftsmanship!'],
            ['Carlos Mendoza', 'Luis and his team cleaned our whole house in 3 hours. Spotless result!'],
            ['Rosa Villanueva','Maria painted our entire house beautifully. Very clean and professional work!'],
        ];

        foreach ($reviews as [$name, $content]) {
            Testimonial::firstOrCreate(
                ['author_name' => $name],
                ['content' => $content, 'rating' => 5, 'is_approved' => true]
            );
        }
    }
}
