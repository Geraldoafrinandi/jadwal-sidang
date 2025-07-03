@extends('admin.layout.main')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="container-fluid">
        {{-- <h1 class="mb-4">Dashboard Admin</h1> --}}

        <!-- Kalender Jadwal Sidang -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h2 class="m-0 font-weight-bold text-primary">Jadwal Sidang Mahasiswa</h2>
            </div>
            <div class="card-body">
                <div class="calendar">
                    <!-- Header Kalender (Hari) -->
                    <div class="calendar-header">
                        @foreach (['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $day)
                            <div class="calendar-day-header">{{ $day }}</div>
                        @endforeach
                    </div>

                    <!-- Body Kalender (Tanggal dan Event) -->
                    <div class="calendar-body">
                        @php
                            $startOfMonth = now()->startOfMonth();
                            $daysInMonth = $startOfMonth->daysInMonth;
                            $firstDayOfWeek = $startOfMonth->dayOfWeek; // 0 (Minggu) sampai 6 (Sabtu)
                        @endphp

                        <!-- Kosongkan hari sebelum tanggal 1 -->
                        @for ($i = 0; $i < $firstDayOfWeek; $i++)
                            <div class="calendar-day empty"></div>
                        @endfor

                        <!-- Tampilkan hari dalam bulan -->
                        @for ($i = 1; $i <= $daysInMonth; $i++)
                            @php
                                $tanggal = $startOfMonth->copy()->addDays($i - 1)->format('Y-m-d');
                                $jadwalHariIni = $events->filter(function ($event) use ($tanggal) {
                                    return \Carbon\Carbon::parse($event['start'])->isSameDay($tanggal);
                                });
                            @endphp
                            <div class="calendar-day">
                                <div class="day-number">{{ $i }}</div>
                                @foreach ($jadwalHariIni as $jadwal)
                                    <div class="event" style="background-color: {{ $jadwal['color'] }};">
                                        <strong>{{ $jadwal['title'] }}</strong><br>
                                        {{ \Carbon\Carbon::parse($jadwal['start'])->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal['end'])->format('H:i') }}
                                    </div>
                                @endforeach
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Container Kalender */
        .calendar {
            display: grid;
            gap: 8px;
            font-family: Arial, sans-serif;
        }

        /* Header Hari */
        .calendar-header {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            text-align: center;
            font-weight: bold;
            margin-bottom: 8px;
            color: #495057;
        }

        .calendar-day-header {
            padding: 8px;
            background-color: #f1f3f5;
            border: 1px solid #dee2e6;
            border-radius: 4px;
        }

        /* Body Kalender */
        .calendar-body {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 8px;
        }

        /* Kotak Hari */
        .calendar-day {
            border: 1px solid #dee2e6;
            padding: 10px;
            min-height: 120px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .calendar-day:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        /* Kotak Kosong */
        .calendar-day.empty {
            background-color: #f8f9fa;
            border: none;
        }

        /* Nomor Hari */
        .day-number {
            font-weight: bold;
            margin-bottom: 8px;
            color: #495057;
        }

        /* Event */
        .event {
            background-color: #e9ecef;
            padding: 6px;
            margin-bottom: 6px;
            border-radius: 4px;
            font-size: 0.85em;
            color: #ffffff;
            word-break: break-word;
        }

        .event strong {
            display: block;
            margin-bottom: 2px;
        }
    </style>
@endsection
