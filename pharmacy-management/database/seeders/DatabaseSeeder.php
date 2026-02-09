<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Medicine;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@pharmacy.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '0888888888',
            'address' => 'София, ул. Витоша 1',
            'egn' => '1234567890',
        ]);

        User::create([
            'name' => 'Pharmacist User',
            'email' => 'pharmacist@pharmacy.com',
            'password' => Hash::make('password'),
            'role' => 'pharmacist',
            'phone' => '0899999999',
            'address' => 'София, ул. Рилски 15',
            'egn' => '0987654321',
        ]);

        $medicines = [
            [
                'name' => 'Аспирин',
                'manufacturer' => 'Bayer',
                'barcode' => '400000000001',
                'price' => 5.50,
                'quantity_in_stock' => 100,
                'min_quantity' => 20,
                'description' => 'Аналгетик и антипиретик',
                'prescription_required' => false,
                'expiry_date' => '2025-12-31',
                'category' => 'Аналгетици',
                'active_substance' => 'Ацетилсалицилова киселина',
                'dosage' => 500,
                'dosage_unit' => 'mg',
            ],
            [
                'name' => 'Парацетамол',
                'manufacturer' => 'Sopharma',
                'barcode' => '400000000002',
                'price' => 3.20,
                'quantity_in_stock' => 150,
                'min_quantity' => 30,
                'description' => 'Аналгетик и антипиретик',
                'prescription_required' => false,
                'expiry_date' => '2025-06-30',
                'category' => 'Аналгетици',
                'active_substance' => 'Парацетамол',
                'dosage' => 500,
                'dosage_unit' => 'mg',
            ],
            [
                'name' => 'Амоксицилин',
                'manufacturer' => 'Actavis',
                'barcode' => '400000000003',
                'price' => 12.80,
                'quantity_in_stock' => 50,
                'min_quantity' => 10,
                'description' => 'Антибиотик',
                'prescription_required' => true,
                'expiry_date' => '2024-12-31',
                'category' => 'Антибиотици',
                'active_substance' => 'Амоксицилин',
                'dosage' => 500,
                'dosage_unit' => 'mg',
            ],
        ];

        foreach ($medicines as $medicine) {
            Medicine::create($medicine);
        }
    }
}
