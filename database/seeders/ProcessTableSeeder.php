<?php

namespace Database\Seeders;

use App\Models\Process;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProcessTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $processesData = collect([
            [
                'name' => 'Order Of Material',
            ],
            [
                'name' => 'Drawing',
            ],
            [
                'name' => 'Programming JIG',
            ],
            [
                'name' => 'Laser & Turret JIG',
            ],
            [
                'name' => 'Preparing Rod',
            ],
            [
                'name' => 'Wire Shelf',
            ],
            [
                'name' => 'Welding Panel',
            ],
            [
                'name' => 'Zig Zag',
            ],
            [
                'name' => 'Post',
            ],
            [
                'name' => 'Bending(ALEX)- Side Ledges',
            ]
        ]);

        Schema::disableForeignKeyConstraints();
        DB::table('processes')->truncate();

        $processesData->each(function ($processData) {
            Process::firstOrCreate($processData);
        });
    }
}