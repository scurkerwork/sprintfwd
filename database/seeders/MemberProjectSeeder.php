<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use App\Models\Member;

class MemberProjectSeeder extends Seeder
{
    public function run()
    {
        Member::all()->each(function ($member) {
            $projects = Project::inRandomOrder()->limit(rand(1, 5))->get();
            $member->projects()->attach($projects);
        });
    }
}
