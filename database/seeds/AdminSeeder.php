<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\User;
use App\Specialization;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users =[
            [
            'id' => '1',
            'first_name' => 'Admin',
            'last_name' => 'OnCon',
            'contact_number' => '12345678910',
            'email' => 'oncon.capstone@gmail.com',
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'roll_number' => 'NULL',
            'proof_photo_path' => 'NULL',
            'location' => 'NULL',
            'specialization' => 'NULL',
            'availability' => 'NULL',
            'password' => Hash::make('adminadmin'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'is_verified' => '1',
            'role_id' => '3'
            ],
            [
            'id' => '2',
            'first_name' => 'Customer',
            'last_name' => 'OnCon',
            'contact_number' => '12345678910',
            'email' => 'customer.oncon@gmail.com',
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'roll_number' => 'NULL',
            'proof_photo_path' => 'NULL',
            'location' => 'NULL',
            'specialization' => 'NULL',
            'availability' => 'NULL',
            'password' => Hash::make('adminadmin'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'is_verified' => '1',
            'role_id' => '1'
            ],
            [
            'id' => '4',
            'first_name' => 'General Lawyer',
            'last_name' => 'OnCon',
            'contact_number' => '12345678910',
            'email' => 'lawyer.onco@gmail.com',
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'roll_number' => '123',
            'availability' => 'Online', 
            'specialization' => 'General',
            'proof_photo_path' => 'https://res.cloudinary.com/onconcapstone/image/upload/v1645047440/lawyer_proof/x6ybsw3en703nraxjely.png',
            'location' => 'Cebu',
            'password' => Hash::make('lawyerlaw'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'is_verified' => '1',
            'role_id' => '2'
            ],
            [
            'id' => '5',
            'first_name' => 'Business and Corporate Lawyer',
            'last_name' => 'OnCon',
            'contact_number' => '12345678910',
            'email' => 'lawyer.onc@gmail.com',
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'roll_number' => '123',
            'availability' => 'Online', 
            'specialization' => 'Business and Corporate Law',
            'proof_photo_path' => 'https://res.cloudinary.com/onconcapstone/image/upload/v1645047440/lawyer_proof/x6ybsw3en703nraxjely.png',
            'location' => 'Ilocos',
            'password' => Hash::make('lawyerlaw'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'is_verified' => '1',
            'role_id' => '2'
            ],
            [
            'id' => '6',
            'first_name' => 'Labor ',
            'last_name' => 'OnCon',
            'contact_number' => '12345678910',
            'email' => 'lawyer.on@gmail.com',
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'roll_number' => '123',
            'specialization' => 'Labor Law',
            'availability' => 'Offline', 
            'proof_photo_path' => 'https://res.cloudinary.com/onconcapstone/image/upload/v1645047440/lawyer_proof/x6ybsw3en703nraxjely.png',
            'location' => 'Paranaque',
            'password' => Hash::make('lawyerlaw'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'is_verified' => '1',
            'role_id' => '2'
            ],
            [
            'id' => '7',
            'first_name' => 'Family',
            'last_name' => 'OnCon',
            'contact_number' => '12345678910',
            'email' => 'lawyer.o@gmail.com',
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'roll_number' => '123',
            'availability' => 'Both', 
            'specialization' => 'Family Law (Marriage, Child, etc.)',
            'proof_photo_path' => 'https://res.cloudinary.com/onconcapstone/image/upload/v1645047440/lawyer_proof/x6ybsw3en703nraxjely.png',
            'location' => 'Pampanga',
            'password' => Hash::make('lawyerlaw'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'is_verified' => '1',
            'role_id' => '2'
            ],
            [
            'id' => '8',
            'first_name' => 'Tax Lawyer',
            'last_name' => 'OnCon',
            'contact_number' => '12345678910',
            'email' => 'lawyer.n@gmail.com',
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'roll_number' => '123',
            'availability' => 'Both', 
            'specialization' => 'Tax Law',
            'proof_photo_path' => 'https://res.cloudinary.com/onconcapstone/image/upload/v1645047440/lawyer_proof/x6ybsw3en703nraxjely.png',
            'location' => 'Pampanga',
            'password' => Hash::make('lawyerlaw'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'is_verified' => '1',
            'role_id' => '2'
            ]
        ];

        User::insert($users);

        /** Specializations */
        $items = [
            ['id' => 1, 'specialization' => 'General'],
            ['id' => 2, 'specialization' => 'Business and Corporate Law'],
            ['id' => 3, 'specialization' => 'Labor Law'],
            ['id' => 4, 'specialization' => 'Intellectual Property'],
            ['id' => 5, 'specialization' => 'Entertainment Law'],
            ['id' => 6, 'specialization' => 'Family Law (Marriage, Child, etc.)'],
            ['id' => 7, 'specialization' => 'Property Law'],
            ['id' => 8, 'specialization' => 'Tax Law'],
            ['id' => 9, 'specialization' => 'Data Privacy Law'],
        ];

        Specialization::insert($items);
    }
}
