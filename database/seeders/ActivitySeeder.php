<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\UserActivity;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Activity::factory(3)->create();
        // Activity::cursor()
        //     ->each(function ($activity) {
        //         UserActivity::factory()
        //             ->count(5)
        //             ->create(['account_id' => $activity->id]);
        //     });
    }
}
