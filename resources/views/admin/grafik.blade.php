@extends('admin.layout.main')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Statistik Mahasiswa dan Dosen</h2>

    <div class="row">
        <div class="col-md-6">
            <h4>Jumlah Mahasiswa per Prodi</h4>
            <canvas id="mahasiswaChart" style="max-height: 400px;"></canvas>
        </div>
        <div class="col-md-6">
            <h4>Status Dosen</h4>
            <canvas id="dosenChart" style="max-height: 400px;"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data Mahasiswa
    const mahasiswaLabels = @json($jumlahMahasiswaPerProdi->map(function($item) {
        return $item->prodi_id; // Ganti ini jika Anda ingin menggunakan nama jurusan
    }));

    const mahasiswaData = @json($jumlahMahasiswaPerProdi->pluck('total'));

    const mahasiswaCtx = document.getElementById('mahasiswaChart').getContext('2d');
    const mahasiswaChart = new Chart(mahasiswaCtx, {
        type: 'bar',
        data: {
            labels: mahasiswaLabels,
            datasets: [{
                label: 'Jumlah Mahasiswa per Prodi',
                data: mahasiswaData,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Data Dosen
    const dosenLabels = @json($jumlahDosenPerStatus->pluck('status_dosen')->map(function($status) {
        return $status === '1' ? 'Aktif' : 'Tidak Aktif';
    }));

    const dosenData = @json($jumlahDosenPerStatus->pluck('total'));

    const dosenCtx = document.getElementById('dosenChart').getContext('2d');
    const dosenChart = new Chart(dosenCtx, {
        type: 'pie',
        data: {
            labels: dosenLabels,
            datasets: [{
                label: 'Status Dosen',
                data: dosenData,
                backgroundColor: ['rgba(54, 162, 235, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Statistik Status Dosen'
                }
            }
        }
    });
</script>
@endsection
