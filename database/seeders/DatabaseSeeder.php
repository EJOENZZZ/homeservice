<?php

namespace Database\Seeders;

use App\Models\Professional;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $pros = [
            ['Grace','Dela Cruz','Plumber',     'ELITE',   5.00, 451],
            ['Marco','Reyes',    'Electrician', 'TOP PRO', 4.98, 312],
            ['Ana',  'Santos',   'Carpenter',   'VERIFIED',4.97, 284],
            ['Luis', 'Bautista', 'Cleaner',     'TOP PRO', 4.95, 198],
        ];
        foreach ($pros as [$fn,$ln,$spec,$badge,$rating,$jobs]) {
            Professional::create([
                'first_name' => $fn, 'last_name'  => $ln,
                'specialty'  => $spec,'badge'      => $badge,
                'rating'     => $rating,'jobs_count'=> $jobs,
                'is_active'  => true,
            ]);
        }

        $reviews = [
            ['Maria Garcia',   'Marco fixed our electrical panel quickly and professionally. Highly recommend!'],
            ['Jose Reyes',     'Grace did an amazing job with our bathroom pipes. Fast, clean, and affordable.'],
            ['Elena Torres',   'Ana built custom shelves for our living room. Absolutely beautiful craftsmanship!'],
            ['Carlos Mendoza', 'Luis and his team cleaned our whole house in 3 hours. Spotless result!'],
        ];
        foreach ($reviews as [$name, $content]) {
            Testimonial::create([
                'author_name' => $name, 'content' => $content,
                'rating' => 5, 'is_approved' => true,
            ]);
        }
    }
}