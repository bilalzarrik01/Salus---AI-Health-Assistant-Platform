<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Seed the doctors table.
     */
    public function run(): void
    {
        $doctors = [
            [
                'name' => 'Dr. Amina El Idrissi',
                'specialty' => 'Generaliste',
                'city' => 'Casablanca',
                'years_of_experience' => 10,
                'consultation_price' => 250.00,
                'available_days' => ['Mon', 'Wed', 'Fri'],
            ],
            [
                'name' => 'Dr. Youssef Benali',
                'specialty' => 'Cardiologue',
                'city' => 'Rabat',
                'years_of_experience' => 15,
                'consultation_price' => 400.00,
                'available_days' => ['Tue', 'Thu'],
            ],
            [
                'name' => 'Dr. Salma Ait Lahcen',
                'specialty' => 'Dermatologue',
                'city' => 'Marrakech',
                'years_of_experience' => 8,
                'consultation_price' => 300.00,
                'available_days' => ['Mon', 'Thu'],
            ],
            [
                'name' => 'Dr. Karim Ould Ahmed',
                'specialty' => 'Pediatre',
                'city' => 'Fes',
                'years_of_experience' => 12,
                'consultation_price' => 280.00,
                'available_days' => ['Wed', 'Sat'],
            ],
            [
                'name' => 'Dr. Hanane Mernissi',
                'specialty' => 'Neurologue',
                'city' => 'Tanger',
                'years_of_experience' => 11,
                'consultation_price' => 450.00,
                'available_days' => ['Tue', 'Fri'],
            ],
            [
                'name' => 'Dr. Rachid Lamrani',
                'specialty' => 'Generaliste',
                'city' => 'Agadir',
                'years_of_experience' => 6,
                'consultation_price' => 200.00,
                'available_days' => ['Mon', 'Wed'],
            ],
            [
                'name' => 'Dr. Nadia El Khatib',
                'specialty' => 'Gynecologue',
                'city' => 'Casablanca',
                'years_of_experience' => 14,
                'consultation_price' => 350.00,
                'available_days' => ['Thu', 'Sat'],
            ],
            [
                'name' => 'Dr. Othmane Ziani',
                'specialty' => 'Orthopediste',
                'city' => 'Rabat',
                'years_of_experience' => 9,
                'consultation_price' => 320.00,
                'available_days' => ['Mon', 'Tue', 'Thu'],
            ],
            [
                'name' => 'Dr. Samira Akachar',
                'specialty' => 'Ophtalmologue',
                'city' => 'Meknes',
                'years_of_experience' => 7,
                'consultation_price' => 270.00,
                'available_days' => ['Wed', 'Fri'],
            ],
            [
                'name' => 'Dr. Mehdi Berrada',
                'specialty' => 'Endocrinologue',
                'city' => 'Oujda',
                'years_of_experience' => 13,
                'consultation_price' => 380.00,
                'available_days' => ['Tue', 'Sat'],
            ],
        ];

        foreach ($doctors as $doctor) {
            Doctor::create($doctor);
        }
    }
}
