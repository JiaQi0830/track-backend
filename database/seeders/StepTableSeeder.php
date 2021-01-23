<?php

namespace Database\Seeders;

use App\Models\Step;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class StepTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stepData = collect([
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
        DB::table('steps')->truncate();

        $stepData->each(function ($transactionTypeData) {
            Step::firstOrCreate($transactionTypeData);
        });
    }
}
