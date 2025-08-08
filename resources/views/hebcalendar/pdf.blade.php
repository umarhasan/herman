<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gregorian Calendar {{ $gregorianYear }}</title>
    <style>
        @page { margin: 12px; }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            max-height: 60px;
            display: block;
            margin: 0 auto 10px;
        }



        .info {
            margin-top: 5px;
            font-size: 12px;
        }

        .calendar-title {
            font-size: 18px;
            font-weight: bold;
            margin: 20px 0 10px;
        }

        .year-calendar {
            display: table;
            width: 100%;
        }

        .row {
            display: table-row;
        }

        .cell {
            display: table-cell;
            width: 25%;
            padding: 10px;
            vertical-align: top;
        }

        .month-title {
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 6px;
        }

        .calendar-table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        .calendar-table th,
        .calendar-table td {
            width: 14.28%;
            height: 28px;
            font-size: 9px;
            padding: 1px 0;
        }

        .calendar-table th {
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
<!-- Header with logo and user info -->
<div class="header">
    <img src="{{ public_path('Backend/assets/images/logo.png') }}" alt="Logo" style="display: inline-block; margin-bottom: 10px; max-height: 60px;">
    <div class="info">
        <strong>{{ auth()->user()->name }}</strong><br>
        Date of Birth: {{ \Carbon\Carbon::parse(auth()->user()->date_of_birth)->format('F d, Y') }}<br>
        13-Year Jewish Calendar (Hebrew Years {{ $hebrewMonthRanges[1] ?? '' }} - {{ end($hebrewMonthRanges) }})
        <h1>Gregorian Calendar {{ $gregorianYear }}</h1>
    </div>
</div>

<div class="year-calendar">
    @foreach(array_chunk($gregorianTitles, 4, true) as $monthRow)
        <div class="row">
            @foreach($monthRow as $index => $monthName)
                @php
                    $year = \Carbon\Carbon::parse($eventsByMonth[$index][0]['date'] ?? now())->year ?? $gregorianYear;
                    $month = \Carbon\Carbon::parse($eventsByMonth[$index][0]['date'] ?? now())->month ?? 1;
                    $date = \Carbon\Carbon::create($year, $month, 1);
                    $daysInMonth = $date->daysInMonth;
                    $startDay = $date->dayOfWeek;
                @endphp
                <div class="cell">
                    <div class="month-title">
                        {{-- {{ $gregorianTitles[$index] ?? '' }} / {{ $hebrewTitles[$index] ?? '' }} {{ $hebrewMonthRanges[$index] ?? '' }} --}}
                        {{ $gregorianTitles[$index] ?? '' }}
                    </div>
                    <table class="calendar-table">
                        <thead>
                            <tr>
                                <th>Su</th><th>Mo</th><th>Tu</th><th>We</th><th>Th</th><th>Fr</th><th>Sa</th>
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
                                    @php
                                        $currentDate = \Carbon\Carbon::create($gregorianYear, $month, $day)->format('Y-m-d');
                                        $isStartDate = $highlightStart13thYear && $currentDate === $highlightStart13thYear;
                                        $isBirthday13 = $highlight13thBirthday && $currentDate === $highlight13thBirthday;

                                        $bgColor = '';
                                        $label = '';

                                        if ($isStartDate) {
                                            $bgColor = 'background-color: yellow;';
                                            $label = 'Hebrew Birthday';
                                        }

                                        if ($isBirthday13) {
                                            $bgColor = 'background-color: orange;';
                                            $label = 'Gregorian Birthday';
                                        }
                                    @endphp
                                    <td style="{{ $bgColor }} font-weight: bold; font-size: 9px; padding: 2px;">
                                        <div>{{ $day }}</div>
                                        @if($label)
                                            <div style="font-size: 6px; font-weight: normal;">{{ $label }}</div>
                                        @endif
                                    </td>
                                    @php $day++; @endphp
                                @endif

                                    @endfor
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    @endforeach
</div>

</body>
</html>
