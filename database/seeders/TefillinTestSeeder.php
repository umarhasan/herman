<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\TefillinRecord;
use Carbon\Carbon;

class TefillinTestSeeder extends Seeder
{
    public function run()
    {
        $users = User::take(3)->get(); // first 2 users for testing
        $today = Carbon::now();

        foreach ($users as $user) {

            // 1️⃣ Arm record
            TefillinRecord::create([
                'user_id' => $user->id,
                'type' => 'arm',
                'parshe_number' => 1,
                'written_on' => $today->subDays(10)->toDateString(),
                'bought_on' => $today->subDays(12)->toDateString(),
                'bought_from' => 'Rabbi Cohen',
                'paid' => 50.00,
                'inspected_by' => 'Rabbi Levi',
                'inspected_on' => $today->subDay()->toDateString(),
                'next_due_date' => $today->addMonths(42)->toDateString(),
                'reference_no' => 'A-'.$today->year.'-'.$user->id.'001'
            ]);

            // 2️⃣ Head records (4 records for Parshi 1–4)
            for ($i=1; $i<=4; $i++) {
                $inspectedOn = $today->subDays(5 + $i);
                TefillinRecord::create([
                    'user_id' => $user->id,
                    'type' => 'head',
                    'parshe_number' => $i,
                    'written_on' => $today->subDays(20 + $i)->toDateString(),
                    'bought_on' => $today->subDays(25 + $i)->toDateString(),
                    'bought_from' => 'Rabbi Cohen',
                    'paid' => 100.00,
                    'inspected_by' => 'Rabbi Levi',
                    'inspected_on' => $inspectedOn->toDateString(),
                    'next_due_date' => $inspectedOn->addMonths(42)->toDateString(),
                    'reference_no' => 'H-'.$today->year.'-'.$user->id.'00'.$i
                ]);
            }
        }


    }
}
