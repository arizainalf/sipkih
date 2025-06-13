@extends('layouts.app')
@section('title', 'Pelayanan')
@push('styles')
    <link rel="stylesheet" href="{{ asset('') }}assets/modules/datatables/datatables.min.css">
    <link rel="stylesheet"
        href="{{ asset('') }}assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header">
                                <div class="card-title font-weight-bolder">
                                    <h4 class="text-primary">Data @yield('title')
                                    </h4>
                                </div>
                                <div class="ml-auto">
                                    <button type="button" class="btn btn-primary" id="tambah-button" data-toggle="modal"
                                        data-target="#modal-tambah"><i class="fas fa-plus mr-2"></i>Tambah</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('pages.admin.pelayanan.modal')
@endsection
@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('') }}assets/modules/datatables/datatables.min.js"></script>
    <script src="{{ asset('') }}assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('') }}assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="{{ asset('') }}assets/modules/jquery-ui/jquery-ui.min.js"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('') }}assets/js/page/modules-datatables.js"></script>

    <script>
        $(document).ready(function() {

            let isEdit;

            $(document).on('click', '#tambah-button', function(e) {
                e.preventDefault();

                const $form = $('#form-tambah');
                $form[0].reset();
                $form.attr('data-id', '');

                loadSelectOptions('#kehamilan_id', '{{ route('admin.kehamilan.index') }}')

            })

            $(document).on('click', '.edit-button', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                isEdit = true;

                const $form = $('#form-tambah');
                $form[0].reset();
                $form.attr('data-id', id);

                loadSelectOptions('#kehamilan_id', '{{ route('admin.kehamilan.index') }}')

                initEditModal({
                    formSelector: '#form-tambah',
                    url: `admin/pelayanan/${id}`,
                    fields: [
                        'kehamilan_id',
                        'trismester',
                        'tanggal_periksa',
                        'tb',
                        'bb',
                        'lingkar_lengan_atas',
                        'detak_jantung_janin',
                        'tinggi_rahim',
                        'konseling',
                        'test_hb',
                        'test_golongan_darah',
                        'test_protein_urin',
                        'test_gula_darah',
                        'ppia',
                        'tata_laksana_kasus',
                        'usg',
                    ],
                    callback: null,
                    onFetched: null,
                })
            })

            $(document).on('submit', '#form-tambah', function(e) {
                e.preventDefault();

                let url = '{{ route('admin.pelayanan.store') }}';
                const formData = new FormData(this);

                console.log(isEdit)

                if (isEdit == true) {
                    const id = $(this).data('id');
                    url = `/admin/pelayanan/${id}`
                    formData.append('_method', 'PUT');
                    isEdit = false;
                }

                const successCallback = function(response) {
                    handleSuccess(response, 'modal-tambah')
                    loadData('.table-responsive', "{{ route('admin.pelayanan.index') }}",
                        "#tabel-pelayanan")
                }

                const errorCallback = function(error) {
                    handleValidationErrors(error, '#form-tambah', [
                        'kehamilan_id',
                        'trismester',
                        'tanggal_periksa',
                        'tb',
                        'bb',
                        'lingkar_lengan_atas',
                        'detak_jantung_janin',
                        'tinggi_rahim',
                        'konseling',
                        'test_hb',
                        'test_golongan_darah',
                        'test_protein_urin',
                        'test_gula_darah',
                        'ppia',
                        'tata_laksana_kasus',
                        'usg',
                    ])
                }

                ajaxCall(url, "POST", formData, successCallback, errorCallback);
            })

            loadData('.table-responsive', "{{ route('admin.pelayanan.index') }}", "#tabel-pelayanan")
        })
    </script>
@endpush
