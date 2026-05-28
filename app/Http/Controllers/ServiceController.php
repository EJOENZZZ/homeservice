<?php

namespace App\Http\Controllers;

use App\Models\Professional;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    private function staticPros(): array
    {
        return [
            ['id'=>1,'first_name'=>'Grace', 'last_name'=>'Dela Cruz','specialty'=>'Plumber',     'badge'=>'ELITE',   'rating'=>5.00,'jobs_count'=>451,'bio'=>'Expert in residential and commercial plumbing with 10+ years experience.','hourly_rate'=>350,'location'=>'Cebu City'],
            ['id'=>2,'first_name'=>'Marco', 'last_name'=>'Reyes',    'specialty'=>'Electrician', 'badge'=>'TOP PRO', 'rating'=>4.98,'jobs_count'=>312,'bio'=>'Licensed electrician specializing in wiring, panels, and smart home setups.','hourly_rate'=>400,'location'=>'Mandaue City'],
            ['id'=>3,'first_name'=>'Ana',   'last_name'=>'Santos',   'specialty'=>'Carpenter',   'badge'=>'VERIFIED','rating'=>4.97,'jobs_count'=>284,'bio'=>'Custom furniture and woodwork specialist with an eye for detail.','hourly_rate'=>300,'location'=>'Lapu-Lapu City'],
            ['id'=>4,'first_name'=>'Luis',  'last_name'=>'Bautista', 'specialty'=>'Cleaner',     'badge'=>'TOP PRO', 'rating'=>4.95,'jobs_count'=>198,'bio'=>'Professional deep cleaning services for homes and offices.','hourly_rate'=>250,'location'=>'Talisay City'],
        ];
    }

    public function index(Request $request)
    {
        try {
            $query = Professional::where('is_active', true);
            if ($request->filled('service')) {
                $query->where('specialty', 'like', '%'.$request->service.'%');
            }
            if ($request->filled('location')) {
                $query->where('location', 'like', '%'.$request->location.'%');
            }
            $professionals = $query->orderByDesc('rating')->get();
            if ($professionals->isEmpty()) throw new \Exception('empty');
        } catch (\Exception $e) {
            $static = collect($this->staticPros())->map(fn($p) => (object)$p);
            $service  = $request->service;
            $location = $request->location;
            $professionals = $static->when($service,  fn($c) => $c->filter(fn($p) => stripos($p->specialty, $service)  !== false))
                                    ->when($location, fn($c) => $c->filter(fn($p) => stripos($p->location,  $location) !== false))
                                    ->values();
        }

        return view('pages.services', compact('professionals'));
    }
}