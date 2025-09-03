<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Record Book - {{ $user->name }}</title>
  <style>
    body { font-family: DejaVu Sans, Arial, sans-serif; font-size:12px; color:#000; }
    .record-book * { font-size: 8px; line-height: 1.4; }
    .record-book table { margin:0; border-collapse:collapse; width:100%; }
    /* outer box */
    .record-book > table,
    .record-book > div {
      border:1px solid #000;
      margin-bottom:6px;
      border-radius:4px;
      overflow:hidden;
    }
    /* cells clean */
    .record-book td, .record-book th {
      padding:4px 6px;
      border:none;
      vertical-align:top;
    }
    /* row separation */
    .record-book tr:not(:last-child) td {
      /* border-bottom:1px dashed #aaa; */
      border-bottom: 1px solid #4c4c4c3b;
    }
    /* headings */
    .fw-bold {
      font-weight:bold;
      display:block;
      margin-bottom:4px;
      padding:2px 4px;
      background:#f7f7f7;
      border-bottom:1px solid #ddd;
    }
    .title { font-weight:bold; text-align:center; margin-bottom:10px; font-size:14px; }
  </style>
</head>
<body>
  <div class="title">Record Book — {{ $user->name }}</div>
  <div class="record-book">

    <!-- Top Header -->
    <div>
      <div class="fw-bold" style="text-align:center;">
        The Day of the Week changes after 72 minutes after sunset
      </div>
        <table style="text-align:center;">
            <tr>
                <td>שבת<br>Day #7<br>Saturday</td>
                <td>פרייטאג<br>Day #6<br>Friday</td>
                <td>דאנערשטאג<br>Day #5<br>Thursday</td>
                <td>מיטוואך<br>Day #4<br>Wednesday</td>
                <td>דינסטאג<br>Day #3<br>Tuesday</td>
                <td>מאנטאג<br>Day #2<br>Monday</td>
                <td>זונטאג<br>Day #1<br>Sunday</td>
            </tr>
        </table>
    </div>

    <!-- Tefillin + Batim Side by Side -->
    <table>
      <tr>
        <!-- Tefillin -->
        <td style="width:50%; vertical-align:top;">
          <div class="fw-bold">Tefillin Record Keeper:&nbsp; Level #1 &nbsp; Level #2 &nbsp; Level #3</div>
          <table>
            @for($i=1;$i<=4;$i++)
              @php $t = $tefillin->firstWhere('parshe_number',$i); @endphp
              <tr>
                <td>
                  Parshe #{{ $i }}
                  @if($t && $t->written_on) written on {{ \Carbon\Carbon::parse($t->written_on)->format('Y-m-d') }} @endif,
                  @if($t && $t->bought_on) Bought On {{ \Carbon\Carbon::parse($t->bought_on)->format('Y-m-d') }} @endif
                  from {{ $t->bought_from ?? '____' }},
                  Paid {{ $t?->paid ? '$'.number_format($t->paid,2) : '____' }}
                </td>
              </tr>
            @endfor
          </table>
        </td>
        <!-- Batim -->
        <td style="width:50%; vertical-align:top;">
          <div class="fw-bold">Batim Record Keeper:</div>
          <table>
            @foreach($batim as $b)
                    <tr>
                        <td>
                            {{ ucfirst($b->type) }} Batim bought from {{ $b->bought_from ?? '____' }}
                            ${{ $b->paid ?? '____' }} on {{ $b->inspected_on ? \Carbon\Carbon::parse($b->inspected_on)->format('d-m-Y') : '/ /' }}
                            Inspected By {{ $b->inspected_by ?? '____' }}
                            &nbsp; Next Due Date {{ $b->next_due_date ? \Carbon\Carbon::parse($b->next_due_date)->format('d-m-Y') : '/ /' }}
                        </td>
                    </tr>
                    @endforeach
          </table>
        </td>
      </tr>
    </table>

    <!-- Mezuza -->
    <div>
      <span class="fw-bold">
        Mezuza Record Keeper: add unlimited @ $1.00 per Mezuzah per month Email Reminder Next Due Date
      </span>
      <table>
        @forelse($mezuza as $m)
          <tr>
            <td>Mezuzah #{{ $loop->iteration }} {{ $m->location }}</td>
            <td>
              @if($m && $m->written_on) written on {{ \Carbon\Carbon::parse($m->written_on)->format('Y-m-d') }} @else written on / / @endif
            </td>
            <td>Bought From Rabbi {{ $m->bought_from ?? '____' }}</td>
            <td>Paid {{ $m?->paid ? '$'.number_format($m->paid,2) : '____' }}</td>
            <td>Inspected By {{ $m->inspected_by ?? '____' }}</td>
            <td>
              On @if($m && $m->inspected_on) {{ \Carbon\Carbon::parse($m->inspected_on)->format('Y-m-d') }} @else / / @endif
            </td>
            <td>
              Next Due Date @if($m && $m->next_due_date) {{ \Carbon\Carbon::parse($m->next_due_date)->format('Y-m-d') }} @else / / @endif
            </td>
          </tr>
        @empty
          <tr><td colspan="7" style="text-align:center;">No records</td></tr>
        @endforelse
      </table>
    </div>
  </div>
</body>
</html>
