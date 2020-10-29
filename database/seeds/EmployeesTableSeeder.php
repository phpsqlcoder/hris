<?php

use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $limit = 100;

        for ($i = 0; $i < $limit; $i++) {
            DB::table('employees')->insert([ //,
            	'hiredDate' => $faker->dateTime(),
                'created_at' => $faker->dateTime(),
                'updated_at' => $faker->dateTime(),
                'lName' => $faker->lastName,
                'image' => $faker->word,
                'fName' => $faker->firstName,
                'mName' => $faker->lastName,
                'fullName' => $faker->name,
                'extName' => $faker->name,
                'sss' => $faker->word,
                'hdmf' => $faker->word,
                'philhealth' => $faker->word,
                'tin' => $faker->word,
                'status' => $faker->word,
                'birthDate' => $faker->dateTime(),
                'birthPlace' => $faker->address,
                'gender' => $faker->randomElement(array('Male','Female')),
                'address' => $faker->address,
                'civilStatus' => $faker->randomElement(array('Single','Married','Divorse')),
                'religion' => $faker->randomElement(array('Protestant','Catholic','Iglesia')),
                'bloodType' => $faker->randomElement(array('AB','O','B+')),
                'empid' => $faker->unique()->randomDigit,
                'emergencyContactPerson' => $faker->name,
                'emergencyContactNo' => $faker->phoneNumber,
                'contactNo' => $faker->phoneNumber,
            ]);
        }
    }
}
