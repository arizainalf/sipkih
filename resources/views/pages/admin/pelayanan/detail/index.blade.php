@extends('layouts.app')
@section('title', 'Form')
@push('styles')
    <link rel="stylesheet" href="{{ asset('') }}assets/modules/datatables/datatables.min.css">
    <link rel="stylesheet"
        href="{{ asset('') }}assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Detail Pelayanan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.pelayanan.index') }}">Pelayanan</a></div>
                <div class="breadcrumb-item">Detail Pelayanan</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-primary">Detail Data Pelayanan</h4>
                            <div class="ml-auto">
                                <button data-toggle="modal" data-target="#modal-tambah" type="button"
                                    data-id="{{ $pelayanan->id }}" class="btn btn-warning btn-icon edit-button">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-danger btn-icon"
                                    onclick="confirmDelete('{{ route('admin.pelayanan.destroy', $pelayanan->id) }}')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label font-weight-bold">Nama Ibu</label>
                                        <div class="col-sm-4">
                                            <p class="form-control-plaintext">{{ $pelayanan->kehamilan->ibu->nik ?? '-' }},
                                                {{ $pelayanan->kehamilan->ibu->nama ?? '-' }} Kehamilan anak ke
                                                {{ $pelayanan->kehamilan->anak_ke ?? '-' }}</p>
                                        </div>
                                        <div class="col-sm-6"></div>
                                    </div>
                                </div>
                                <!-- Kolom Kiri -->
                                <div class="col-md-6">

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label font-weight-bold">Trimester</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-plaintext">Trimester {{ $pelayanan->trismester }}</p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label font-weight-bold">Tanggal Periksa</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-plaintext">
                                                {{ \Carbon\Carbon::parse($pelayanan->tanggal_periksa)->format('d F Y') }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label font-weight-bold">Tinggi Badan</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-plaintext">{{ $pelayanan->tb }} cm</p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label font-weight-bold">Berat Badan</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-plaintext">{{ $pelayanan->bb }} kg</p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label font-weight-bold">Lingkar Lengan Atas</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-plaintext">{{ $pelayanan->lingkar_lengan_atas }} cm</p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label font-weight-bold">Detak Jantung Janin</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-plaintext">{{ $pelayanan->detak_jantung_janin }}</p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label font-weight-bold">Tinggi Rahim</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-plaintext">{{ $pelayanan->tinggi_rahim }} cm</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Kolom Kanan -->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label font-weight-bold">Konseling</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-plaintext">{{ $pelayanan->konseling }}</p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label font-weight-bold">Test HB</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-plaintext">{{ $pelayanan->test_hb }} g/dL</p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label font-weight-bold">Test Golongan Darah</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-plaintext">{{ $pelayanan->test_golongan_darah }}</p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label font-weight-bold">Test Protein Urin</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-plaintext">{{ $pelayanan->test_protein_urin }}</p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label font-weight-bold">Test Gula Darah</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-plaintext">{{ $pelayanan->test_gula_darah }} mg/dL</p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label font-weight-bold">PPIA</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-plaintext">{{ ucfirst($pelayanan->ppia) }}</p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label font-weight-bold">USG</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-plaintext">{{ $pelayanan->usg }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tata Laksana Kasus -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Tata Laksana Kasus</label>
                                        <div class="card">
                                            <div class="card-body">
                                                <p class="card-text">
                                                    {{ $pelayanan->tata_laksana_kasus ?? 'Tidak ada catatan' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <a href="{{ route('admin.pelayanan.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('pages.admin.pelayanan.detail.modal')
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

        })
    </script>
@endpush
