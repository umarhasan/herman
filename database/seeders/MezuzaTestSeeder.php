<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MezuzaRecord; // ya jo bhi aapka model hai
use App\Models\User;
use Carbon\Carbon;

class MezuzaTestSeeder extends Seeder
{
    public function run()
    {
        $users = User::take(3)->get(); // pehla user ke liye data
        $today = Carbon::now();

        foreach ($users as $user) {
            // 5 random Mezuza records
            for ($i = 1; $i <= 5; $i++) {
                $inspectedOn = $today->copy()->subDays($i * 10);

                MezuzaRecord::create([
                    'user_id'      => $user->id,
                    'location'     => 'Door ' . $i,
                    'written_on'   => $today->copy()->subDays(50 + $i)->toDateString(),
                    'bought_from'  => 'Rabbi Cohen',
                    'paid'         => rand(50, 150),
                    'inspected_by' => 'Rabbi Levi',
                    'inspected_on' => $inspectedOn->toDateString(),
                    'next_due_date'=> $inspectedOn->copy()->addMonths(42)->toDateString(),
                    'reference_no' => 'M-' . $today->year . '-' . $user->id . '00' . $i,
                ]);
            }
        }
    }
}
