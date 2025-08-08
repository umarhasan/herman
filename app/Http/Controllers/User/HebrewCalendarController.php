<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class HebrewCalendarController extends Controller
{
    public function index()
    {
        $date = Carbon::now()->format('Y-m-d');
        $calendar = $this->getCalendarData($date); // Full year from Jan
        return view('user.hebcalendar.index', $calendar);
    }

    public function downloadPdf()
    {
        $user = Auth::user();
        $dob = $user->date_of_birth;

        // Convert Gregorian DOB to Hebrew
        $response = Http::get("https://www.hebcal.com/converter", [
            'cfg' => 'json',
            'gy' => Carbon::parse($dob)->year,
            'gm' => Carbon::parse($dob)->month,
            'gd' => Carbon::parse($dob)->day,
            'g2h' => 1,
        ]);

        if (!$response->ok()) {
            return back()->with('error', 'Hebrew date conversion failed.');
        }

        $hebrewDob = $response->json(); // contains hy, hm, hd
        $dobHebrewYear = $hebrewDob['hy'];
        $dobHebrewMonth = $hebrewDob['hm'];
        $dobHebrewDay = $hebrewDob['hd'];

        $thirteenHebrewYear = $dobHebrewYear + 13;

        // ✅ Convert 1 Tishrei of 13th Hebrew year → Gregorian (start of 13th Hebrew year)
        $start13thYearResponse = Http::get("https://www.hebcal.com/converter", [
            'cfg' => 'json',
            'hy' => $thirteenHebrewYear,
            'hm' => 'Tishrei',
            'hd' => 1,
            'h2g' => 1,
        ]);

        if (!$start13thYearResponse->ok()) {
            return back()->with('error', 'Failed to convert Hebrew to Gregorian.');
        }

        $gregorianStartDate = Carbon::create(
            $start13thYearResponse->json()['gy'],
            $start13thYearResponse->json()['gm'],
            $start13thYearResponse->json()['gd']
        )->format('Y-m-d');

        // ✅ Convert 13th Hebrew birthday (same hdate, but year +13) → Gregorian
        $birthday13Response = Http::get("https://www.hebcal.com/converter", [
            'cfg' => 'json',
            'hy' => $thirteenHebrewYear,
            'hm' => $dobHebrewMonth,
            'hd' => $dobHebrewDay,
            'h2g' => 1,
        ]);

        if (!$birthday13Response->ok()) {
            return back()->with('error', 'Failed to convert 13th Hebrew birthday.');
        }

        $birthday13Gregorian = Carbon::create(
            $birthday13Response->json()['gy'],
            $birthday13Response->json()['gm'],
            $birthday13Response->json()['gd']
        )->format('Y-m-d');

        // Get calendar data starting from 13th year
        $dobMonth = Carbon::parse($dob)->month;
        $calendar = $this->getCalendarData($gregorianStartDate, $dobMonth);

        // ✅ Pass both highlight dates
        $calendar['highlightStart13thYear'] = $gregorianStartDate;
        $calendar['highlight13thBirthday'] = $birthday13Gregorian;

        // return view('admin.hebcalendar.pdf', $calendar);
        $pdf = Pdf::loadView('hebcalendar.pdf', $calendar);
        return $pdf->download("Jewish-Calendar-Year-$thirteenHebrewYear.pdf");
    }

    private function getCalendarData($startDateYmd, $startMonth = 1)
    {
        $eventsByMonth = [];
        $hebrewTitles = [];
        $hebrewMonthRanges = [];
        $gregorianTitles = [];
        $hebrewByDate = [];

        $gregorianYear = Carbon::parse($startDateYmd)->year;

        for ($i = 0; $i < 12; $i++) {
            $month = ($startMonth + $i - 1) % 12 + 1;
            $yearOffset = intdiv($startMonth + $i - 1, 12);
            $currentYear = $gregorianYear + $yearOffset;

            $start = Carbon::create($currentYear, $month, 1)->startOfMonth()->toDateString();
            $end = Carbon::create($currentYear, $month, 1)->endOfMonth()->toDateString();

            // Fetch events from Hebcal API
            $response = Http::get("https://www.hebcal.com/hebcal", [
                'v' => '1',
                'cfg' => 'json',
                'maj' => 'on',
                'min' => 'on',
                'mod' => 'on',
                'nx'  => 'on',
                'ss'  => 'on',
                'mf'  => 'on',
                'c' => 'on',
                'geo' => 'none',
                'start' => $start,
                'end' => $end,
            ]);

            $data = $response->json();
            $events = [];
            $hebrewMonthNames = [];
            $hebrewYear = '';

            if (isset($data['items'])) {
                foreach ($data['items'] as $item) {
                    $events[] = [
                        'title' => $item['title'],
                        'date' => $item['date'],
                        'hebrew' => $item['hdate'] ?? '',
                        'source' => 'hebcal',
                    ];

                    if (isset($item['hdate']) && isset($item['date'])) {
                        $hebrewByDate[$item['date']] = [
                            'hebrew' => $item['hdate'],
                        ];
                    }

                    if (isset($item['hdate'])) {
                        $parts = explode(' ', $item['hdate']);
                        if (count($parts) === 3) {
                            $hm = $parts[1];
                            $hy = $parts[2];

                            if (!in_array($hm, $hebrewMonthNames)) {
                                $hebrewMonthNames[] = $hm;
                            }

                            $hebrewYear = $hy;
                        }
                    }
                }
            }

            // Custom DB events
            $customEvents = Event::whereBetween('event_date', [$start, $end])->get();
            foreach ($customEvents as $event) {
                $events[] = [
                    'title' => $event->title,
                    'date' => $event->event_date,
                    'hebrew' => '',
                    'source' => 'custom',
                ];
            }

            $key = $i + 1; // for month-block index
            $gregorianTitles[$key] = Carbon::create($currentYear, $month, 1)->format('F Y');
            $hebrewTitles[$key] = implode(" – ", $hebrewMonthNames);
            $hebrewMonthRanges[$key] = $hebrewYear;
            $eventsByMonth[$key] = $events;
        }

        return compact(
            'eventsByMonth',
            'gregorianTitles',
            'hebrewTitles',
            'hebrewMonthRanges',
            'hebrewByDate',
            'gregorianYear'
        );
    }

    public function converter()
    {
        return view('user.hebcalendar.convertor');
    }

    public function gregorianToHebrew(Request $request)
    {
        $request->validate([
            'day' => 'required|integer|min:1|max:31',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer',
            'afterSunset' => 'nullable|boolean'
        ]);

        $url = "https://www.hebcal.com/converter?cfg=json&gy={$request->year}&gm={$request->month}&gd={$request->day}&g2h=1";
        if ($request->afterSunset) {
            $url .= "&after=1";
        }

        $response = Http::get($url);
        if ($response->failed()) {
            return response()->json(['error' => 'Hebcal API not responding'], 500);
        }

        $conversion = $response->json();
        $date = Carbon::create($request->year, $request->month, $request->day)->toDateString();
        $events = $this->getEventsForDate($date);

        return response()->json([
            'hebrew' => $conversion['hebrew'] ?? '',
            'gy' => $conversion['gy'] ?? $request->year,
            'gm' => $conversion['gm'] ?? $request->month,
            'gd' => $conversion['gd'] ?? $request->day,
            'wd' => $conversion['wd'] ?? null,
            'events' => $events
        ]);
    }

    public function hebrewToGregorian(Request $request)
    {
        $request->validate([
            'day' => 'required|integer|min:1|max:30',
            'month' => 'required|string',
            'year' => 'required|integer',
        ]);

        $url = "https://www.hebcal.com/converter?cfg=json&hy={$request->year}&hm={$request->month}&hd={$request->day}&h2g=1";
        $response = Http::get($url);

        if ($response->failed()) {
            return response()->json(['error' => 'Hebcal API not responding'], 500);
        }

        $conversion = $response->json();
        $date = Carbon::create($conversion['gy'], $conversion['gm'], $conversion['gd'])->toDateString();
        $events = $this->getEventsForDate($date);

        return response()->json([
            'gregorian' => "{$conversion['gy']}-{$conversion['gm']}-{$conversion['gd']}",
            'gy' => $conversion['gy'],
            'gm' => $conversion['gm'],
            'gd' => $conversion['gd'],
            'hebrew' => $conversion['hebrew'] ?? '',
            'wd' => $conversion['wd'] ?? null,
            'events' => $events
        ]);
    }

    public function calendarListView(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        $days = [];
        $start = Carbon::create($year, $month, 1);
        $end = $start->copy()->endOfMonth();

        while ($start->lte($end)) {
            $dateStr = $start->toDateString();

            $conv = Http::get("https://www.hebcal.com/converter", [
                'cfg' => 'json',
                'gy' => $start->year,
                'gm' => $start->month,
                'gd' => $start->day,
                'g2h' => 1
            ])->json();

            $events = $this->getEventsForDate($dateStr);

            $days[] = [
                'gregorian' => $dateStr,
                'hebrew' => $conv['hebrew'] ?? '',
                'events' => $events
            ];

            $start->addDay();
        }

        return response()->json([
            'month' => $month,
            'year' => $year,
            'days' => $days
        ]);
    }

    private function getEventsForDate($date)
    {
        $events = [];

        $hebcalResponse = Http::get("https://www.hebcal.com/hebcal", [
            'v' => '1',
            'cfg' => 'json',
            'maj' => 'on',
            'min' => 'on',
            'mod' => 'on',
            'nx'  => 'on',
            'ss'  => 'on',
            'mf'  => 'on',
            'c' => 'on',
            'geo' => 'none',
            'start' => $date,
            'end' => $date,
        ]);

        if ($hebcalResponse->ok()) {
            foreach ($hebcalResponse->json()['items'] ?? [] as $item) {
                $events[] = [
                    'title' => $item['title'],
                    'hdate' => $item['hdate'] ?? '',
                    'source' => 'hebcal'
                ];
            }
        }

        $customEvents = Event::whereDate('event_date', $date)->get();
        foreach ($customEvents as $event) {
            $events[] = [
                'title' => $event->title,
                'hdate' => '',
                'source' => 'custom'
            ];
        }

        return $events;
    }
}
