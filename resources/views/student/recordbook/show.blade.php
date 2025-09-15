@extends('student.layouts.app')
@section('title','Record Book - '.$user->name)

@section('content')
<style>
  .record-book * {
    font-size: 11px;
    line-height: 1.4;
  }
  .record-book table {
    margin: 0;
    border-collapse: collapse !important;
    width: 100%;
  }
  /* Sirf outer box */
  .record-book > table,
  .record-book > div {
    border: 1px solid #000;
    margin-bottom: 6px;
    border-radius: 4px;
    overflow: hidden;
  }
  /* Table cells clean */
  .record-book td, .record-book th {
    padding: 4px 6px !important;
    border: none !important;
    vertical-align: top;
    /* white-space: nowrap; */
  }
  /* Row separation */
  .record-book tr:not(:last-child) td {
    /* border-bottom: 1px dashed #aaa !important; */
    border-bottom: 1px solid #4c4c4c3b;
  }
  /* Headings */
  .record-book .fw-bold {
    font-weight: bold;
    display: block;
    margin-bottom: 4px;
    padding: 2px 4px;
    background: #f7f7f7;
    border-bottom: 1px solid #ddd;
  }
  /* Inspection box */
  .inspect-box {
    text-align: center;
    font-weight: bold;
    background: #f1f1f1;
    border-top: 1px solid #aaa !important;
    padding: 6px !important;
  }
</style>
<div class="container record-book-container">
    <div class="d-flex justify-content-between align-items-center mb-3"> <h4>Record Book — {{ $user->name }}</h4> <div> <a class="btn btn-secondary" href="{{ route('student.recordbook.pdf',$user) }}">Download PDF</a> <button class="btn btn-outline-primary" onclick="window.print()">Print</button> </div> </div>
    <div class="record-book">
        <!-- Top Header -->
        <div>
            <div class="text-center fw-bold">The Day of the Week changes after 72 minutes after sunset</div>
            <table class="text-center">
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
            <!-- Tefillin & Batim-->
            <td style="width:50%; vertical-align:top;">
                <div class="fw-bold">Tefillin Record Keeper:&nbsp; Level #1 &nbsp; Level #2 &nbsp; Level #3</div>
                <table>
                    @foreach($tefillin as $t)
                    <tr>
                        <td>
                            Parshe #{{ $t->parshe_number }} written on {{ $t->written_on ? \Carbon\Carbon::parse($t->written_on)->format('d-m-Y') : '/ /' }},
                            Bought On {{ $t->bought_on ? \Carbon\Carbon::parse($t->bought_on)->format('d-m-Y') : '/ /' }} from {{ $t->bought_from ?? '____' }},
                            Paid ${{ $t->paid ?? '____' }}
                        </td>
                    </tr>
                    @endforeach
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
            <span class="fw-bold">Mezuza Record Keeper: add unlimited @ $1.00 per Mezuzah per month Email Reminder Next Due Date</span>
            <table>
                @foreach($mezuza as $m)
                    <tr>
                        <td>Mezuzah #{{ $loop->iteration }}{{ $m->house_number }}{{ $m->street_number }},{{ $m->street_name }},{{ $m->area_name }},
                            {{ $m->city }},
                            {{ $m->country }} written on {{ $m->written_on ? \Carbon\Carbon::parse($m->written_on)->format('d-m-Y') : '/ /' }}</td>
                        <td>Bought From Rabbi {{ $m->bought_from ?? '____' }}</td>
                        <td>Paid ${{ $m->paid ?? '____' }}</td>
                        <td>Inspected By {{ $m->inspected_by ?? '____' }}</td>
                        <td>On {{ $m->inspected_on ? \Carbon\Carbon::parse($m->inspected_on)->format('d-m-Y') : '/ /' }}</td>
                        <td>Next Due Date {{ $m->next_due_date ? \Carbon\Carbon::parse($m->next_due_date)->format('d-m-Y') : '/ /' }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection
