@extends('layouts.app')
@section('title', 'Kehamilan')
@push('styles')
    <link rel="stylesheet" href="{{ asset('') }}assets/modules/datatables/datatables.min.css">
    <link rel="stylesheet"
        href="{{ asset('') }}assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <style>
        .fc-event {
            height: 20px;
        }
    </style>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>@yield('title')</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">@yield('title')</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafik Kehamilan</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="kehamilanChart" height="158"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title font-weight-bolder">
                                <h4 class="text-primary">Data Pelayanan
                                </h4>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive-pelayanan">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title font-weight-bolder">
                                <h4 class="text-primary">Data Nifas
                                </h4>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive-nifas">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title font-weight-bolder">
                                <h4 class="text-primary">Minum Obat
                                </h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('pages.admin.kehamilan.detail.modal')
@endsection
@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('') }}assets/modules/datatables/datatables.min.js"></script>
    <script src="{{ asset('') }}assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('') }}assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="{{ asset('') }}assets/modules/jquery-ui/jquery-ui.min.js"></script>
    <script src="{{ asset('') }}assets/modules/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('') }}assets/js/page/modules-datatables.js"></script>

    <script>
        $(document).ready(function() {

            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                events: '{{ route('ibu.kehamilan.kalender.events', $kehamilan->id) }}',

                eventClick: function(info) {
                    $.ajax({
                        url: '{{ url('ibu/kehamilan/ttd') }}/' + info.event.id + '/toggle',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            var color = res.status ? '#28a745' : '#6c757d';
                            info.event.setProp('backgroundColor', color);
                            info.event.setProp('borderColor', color);
                            showToast('success', 'Berhasil memperbarui status.');
                        },
                        error: function(error) {
                            console.log('error', error);
                            showToast('error', 'Gagal memperbarui status.');
                        }
                    });
                },

                eventDidMount: function(info) {
                    info.el.style.cursor = 'pointer';
                },

                eventContent: function() {
                    // return kosong → tidak ada teks, hanya blok warna
                    return {
                        html: ''
                    };
                }


            });

            calendar.render();

            loadData('.table-responsive-nifas',
                "{{ route('ibu.nifas.table', $kehamilan->id) }}", "#tabel-nifas")
            loadData('.table-responsive-pelayanan',
                "{{ route('ibu.pelayanan.table', $kehamilan->id) }}", "#tabel-pelayanan")
        })

        console.log("{{ $labels }}")

        const ctx = document.getElementById('kehamilanChart').getContext('2d');
        const kehamilanChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                        label: 'Berat Badan (kg)',
                        data: {!! json_encode($bb) !!},
                        backgroundColor: 'rgba(63, 82, 227, 0.2)', // Biru soft
                        borderColor: 'rgba(63, 82, 227, 1)',
                        fill: true,
                        tension: 0.3
                    },
                    {
                        label: 'Tinggi Badan (cm)',
                        data: {!! json_encode($tb) !!},
                        backgroundColor: 'rgba(40, 199, 111, 0.2)', // Hijau soft
                        borderColor: 'rgba(40, 199, 111, 1)',
                        fill: true,
                        tension: 0.3
                    },
                    {
                        label: 'Lingkar Lengan Atas (cm)',
                        data: {!! json_encode($lingkar_lengan_atas) !!},
                        backgroundColor: 'rgba(255, 159, 64, 0.2)', // Orange soft
                        borderColor: 'rgba(255, 159, 64, 1)',
                        fill: true,
                        tension: 0.3
                    },
                    {
                        label: 'Tinggi Rahim (cm)',
                        data: {!! json_encode($tinggiRahim) !!},
                        backgroundColor: 'rgba(254, 86, 83, 0.2)', // Merah soft
                        borderColor: 'rgba(254, 86, 83, 1)',
                        fill: true,
                        tension: 0.3
                    },
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.formattedValue;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush
