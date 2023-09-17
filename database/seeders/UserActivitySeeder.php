<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserActivity::factory(1)->create();

        UserActivity::factory(1)->create([
            'user_id' => function(){
                return User::factory()->create()->id;
            },

            'activity_id' => function(){
                return Activity::factory()->create([
                    'scope' => 'local'
                ])->id;
            },
        ]);

    }
}
