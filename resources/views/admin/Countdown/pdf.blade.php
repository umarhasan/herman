<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Jewish Calendar PDF – Full Year (1 Page)</title>
<style>
    @page {
        size: A4 landscape;  /* ✅ Landscape for wide layout */
        margin: 5mm;
    }

    body {
        font-family: "DejaVu Sans", sans-serif;
        font-size: 8px;
        margin: 0;
        padding: 0;
        color: #222;
    }

    h1 {
        text-align: center;
        font-size: 18px;
        font-weight: bold;
        margin: 5px 0 10px 0;
    }

    /* ✅ GRID LAYOUT – 3 months per row, 4 rows */
    .calendar-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .month-block {
        width: 32%;        /* ✅ 3 months per row */
        margin-bottom: 8px;
        border: 1px solid #ccc;
        padding: 3px;
        box-sizing: border-box;
    }

    .month-title {
        text-align: center;
        font-size: 11px;
        font-weight: bold;
        margin-bottom: 3px;
    }

    .calendar-table {
        width: 100%;
        border-collapse: collapse;
    }

    .calendar-table th,
    .calendar-table td {
        border: 1px solid #aaa;
        width: 14.28%;
        height: 28px;  /* ✅ Thoda chhota taki fit ho jaye */
        vertical-align: top;
        text-align: left;
        padding: 1px;
    }

    .calendar-table th {
        background: #f1f1f1;
        font-weight: bold;
        font-size: 7px;
        text-align: center;
    }

    .day-number {
        font-weight: bold;
        font-size: 7px;
        display: block;
    }

    .event {
        font-size: 6px;
        padding: 1px 2px;
        margin-bottom: 1px;
        border-radius: 2px;
        color: white;
        line-height: 1.1;
    }

    .event.api { background-color: #42a5f5; }
    .event.custom { background-color: #7e57c2; }
</style>
</head>
<body>

<h1>Jewish Calendar {{ $gregorianYear }} – Full Year View</h1>

<div class="calendar-grid">
@foreach(array_keys($eventsByMonth) as $month)
    @php
        $date = \Carbon\Carbon::create(null, $month, 1);
        $daysInMonth = $date->daysInMonth;
        $startDay = $date->dayOfWeek;
    @endphp

    <div class="month-block">
        <div class="month-title">
            {{ $gregorianTitles[$month] ?? '' }}<br>
            <span style="color:#b71c1c; font-size: 9px;">
                {{ $hebrewTitles[$month] ?? '' }} {{ $hebrewMonthRanges[$month] ?? '' }}
            </span>
        </div>

        <table class="calendar-table">
            <thead>
                <tr>
                    <th>Su</th>
                    <th>Mo</th>
                    <th>Tu</th>
                    <th>We</th>
                    <th>Th</th>
                    <th>Fr</th>
                    <th>Sa</th>
                </tr>
            </thead>
            <tbody>
                @php $day = 1; @endphp
                @for($row = 0; $row < 6; $row++)
                    <tr>
                        @for($col = 0; $col < 7; $col++)
                            @if($row === 0 && $col < $startDay)
                                <td></td>
                            @elseif($day > $daysInMonth)
                                <td></td>
                            @else
                                <td>
                                    <span class="day-number">{{ $day }}</span>

                                    @foreach($eventsByMonth[$month] as $event)
                                        @if(\Carbon\Carbon::parse($event['date'])->day == $day)
                                            <div class="event {{ $event['type'] ?? 'api' }}">
                                                {{ $event['title'] }}
                                            </div>
                                        @endif
                                    @endforeach

                                    @php $day++; @endphp
                                </td>
                            @endif
                        @endfor
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
@endforeach
</div>

</body>
</html>
