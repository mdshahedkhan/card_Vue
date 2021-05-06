<?php

namespace Database\Seeders;

use App\Models\Task;
use Faker\Factory;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        foreach (range(1, 10) as $item) {
            Task::create([
                'name'   => $faker->unique()->name,
                'status' => $this->GetStatus()
            ]);
        }
    }

    protected function GetStatus()
    {
        $status = ['active' => "active", 'inactive' => 'inactive'];
        return array_rand($status);
    }
}
