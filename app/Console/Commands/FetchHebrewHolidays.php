<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Event;

class FetchHebrewHolidays extends Command
{
    protected $signature = 'app:fetch-hebrew-holidays';
    protected $description = 'Fetch Hebrew holidays from Hebcal and store as events';

    public function handle()
    {
        $response = Http::get('https://www.hebcal.com/hebcal/', [
            'v' => 1,
            'year' => now()->year,
            'month' => 'x',
            'nx' => 'on',
            'nh' => 'on',
            'vis' => 'on',
            's' => 'on',
            'maj' => 'on',
            'mf' => 'on',
            'ss' => 'on',
            'mod' => 'on',
            'lg' => 'en',
            'c' => 'on',
            'geo' => 'none',
            'json' => true
        ]);

        $data = $response->json();

        foreach ($data['items'] as $holiday) {
            Event::updateOrCreate(
                [
                    'title' => $holiday['title'],
                    'event_date' => substr($holiday['date'], 0, 10),
                ],
                [
                    'user_id' => 1, // or null if system event
                    'description' => $holiday['title'],
                ]
            );
        }

        $this->info('Hebrew holidays fetched and stored.');
    }
}

