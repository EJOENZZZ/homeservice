<?php

namespace App\Http\Controllers;

use App\Models\Professional;

class ProfessionalController extends Controller
{
    private function staticPros(): array
    {
        return [
            ['id'=>1,'first_name'=>'Grace', 'last_name'=>'Dela Cruz','specialty'=>'Plumber',     'badge'=>'ELITE',   'rating'=>5.00,'jobs_count'=>451,'bio'=>'Expert in residential and commercial plumbing with 10+ years of experience. Specializes in pipe installation, leak repairs, bathroom renovations, and water heater setups.','hourly_rate'=>350,'location'=>'Cebu City','avatar_url'=>null,'is_active'=>true],
            ['id'=>2,'first_name'=>'Marco', 'last_name'=>'Reyes',    'specialty'=>'Electrician', 'badge'=>'TOP PRO', 'rating'=>4.98,'jobs_count'=>312,'bio'=>'Licensed electrician with expertise in residential wiring, panel upgrades, lighting installation, and smart home setups. Fully certified and insured.','hourly_rate'=>400,'location'=>'Mandaue City','avatar_url'=>null,'is_active'=>true],
            ['id'=>3,'first_name'=>'Ana',   'last_name'=>'Santos',   'specialty'=>'Carpenter',   'badge'=>'VERIFIED','rating'=>4.97,'jobs_count'=>284,'bio'=>'Custom furniture and woodwork specialist with an eye for detail. From built-in cabinets to full room renovations, Ana delivers quality craftsmanship.','hourly_rate'=>300,'location'=>'Lapu-Lapu City','avatar_url'=>null,'is_active'=>true],
            ['id'=>4,'first_name'=>'Luis',  'last_name'=>'Bautista', 'specialty'=>'Cleaner',     'badge'=>'TOP PRO', 'rating'=>4.95,'jobs_count'=>198,'bio'=>'Professional deep cleaning services for homes and offices. Uses eco-friendly products and modern equipment to deliver spotless results every time.','hourly_rate'=>250,'location'=>'Talisay City','avatar_url'=>null,'is_active'=>true],
        ];
    }

    public function show($id)
    {
        try {
            $pro = Professional::findOrFail($id);
        } catch (\Exception $e) {
            $data = collect($this->staticPros())->firstWhere('id', (int)$id);
            abort_if(!$data, 404);
            $pro = (object) $data;
        }
        return view('pages.pro-detail', compact('pro'));
    }
}