@extends('layouts.app')
@section('title', 'Detail Nifas')
@push('styles')
    <link rel="stylesheet" href="{{ asset('') }}assets/modules/datatables/datatables.min.css">
    <link rel="stylesheet"
        href="{{ asset('') }}assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Detail Masa Nifas</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.nifas.index') }}">Data Nifas</a></div>
                <div class="breadcrumb-item">Detail Masa Nifas</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-primary">Detail Data Masa Nifas</h4>
                            <div class="ml-auto">
                                <button data-id="{{ $nifas->id }}" class="btn btn-warning btn-icon edit-button" data-toggle="modal" data-target="#modal-tambah">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-danger btn-icon"
                                    onclick="confirmDelete('{{ route('admin.nifas.destroy', $nifas->id) }}')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Kolom Kiri -->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label font-weight-bold">Nama Ibu</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-plaintext">
                                                {{ $nifas->kehamilan->ibu->nik ?? '-' }}, {{ $nifas->kehamilan->ibu->nama ?? '-' }} Kehamilan Ke {{ $nifas->kehamilan->anak_ke ?? '-' }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label font-weight-bold">Tanggal Pemeriksaan</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-plaintext">
                                                {{ \Carbon\Carbon::parse($nifas->created_at)->format('d F Y') }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label font-weight-bold">Pemeriksaan ASI</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-plaintext">
                                                @if ($nifas->periksa_asi)
                                                    <span class="badge badge-success">Sudah diperiksa</span>
                                                @else
                                                    <span class="badge badge-secondary">Belum diperiksa</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label font-weight-bold">Pemeriksaan
                                            Perdarahan</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-plaintext">
                                                @if ($nifas->periksa_perdarahan)
                                                    <span class="badge badge-success">Sudah diperiksa</span>
                                                @else
                                                    <span class="badge badge-secondary">Belum diperiksa</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label font-weight-bold">Pemeriksaan Jalan
                                            Lahir</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-plaintext">
                                                @if ($nifas->periksa_jalan_lahir)
                                                    <span class="badge badge-success">Sudah diperiksa</span>
                                                @else
                                                    <span class="badge badge-secondary">Belum diperiksa</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Kolom Kanan -->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label font-weight-bold">Vitamin A</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-plaintext">
                                                {{ $nifas->vitamin_a ?? 'Tidak ada data' }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label font-weight-bold">KB Pasca Kelahiran</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-plaintext">
                                                @if ($nifas->kb_pasca_kelahiran)
                                                    {{ ucfirst($nifas->kb_pasca_kelahiran) }}
                                                @else
                                                    Tidak ada data
                                                @endif
                                            </p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label font-weight-bold">Konseling</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-plaintext">
                                                @if ($nifas->konseling)
                                                    <span class="badge badge-success">Sudah dilakukan</span>
                                                @else
                                                    <span class="badge badge-secondary">Belum dilakukan</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label font-weight-bold">Tata Laksana Kasus</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-plaintext">
                                                @if ($nifas->tata_laksana_kasus)
                                                    <span class="badge badge-success">Sudah dilakukan</span>
                                                @else
                                                    <span class="badge badge-secondary">Belum dilakukan</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label font-weight-bold">Terakhir Diupdate</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-plaintext">
                                                {{ \Carbon\Carbon::parse($nifas->updated_at)->format('d F Y H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Catatan Tambahan -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Catatan Tambahan</label>
                                        <div class="card">
                                            <div class="card-body">
                                                <p class="card-text">
                                                    @if ($nifas->catatan)
                                                        {{ $nifas->catatan }}
                                                    @else
                                                        Tidak ada catatan tambahan
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <a href="{{ route('admin.nifas.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('pages.admin.nifas.detail.modal')
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
                    url: `admin/nifas/${id}`,
                    fields: [
                        'kehamilan_id',
                        'periksa_asi',
                        'periksa_perdarahan',
                        'periksa_jalan_lahir',
                        'vitamin_a',
                        'kb_pasca_kelahiran',
                        'konseling',
                        'tata_laksana_kasus',
                    ],
                    callback: null,
                    onFetched: null,
                })
            })

            $(document).on('submit', '#form-tambah', function(e) {
                e.preventDefault();

                let url = '{{ route('admin.nifas.store') }}';
                const formData = new FormData(this);

                console.log(isEdit)

                if (isEdit == true) {
                    const id = $(this).data('id');
                    url = `/admin/nifas/${id}`
                    formData.append('_method', 'PUT');
                    isEdit = false;
                }

                const successCallback = function(response) {
                    handleSuccess(response, 'modal-tambah',
                        '{{ route('admin.nifas.detail', $nifas->id) }}')
                }

                const errorCallback = function(error) {
                    handleValidationErrors(error, '#form-tambah', [
                        'kehamilan_id',
                        'periksa_asi',
                        'periksa_perdarahan',
                        'periksa_jalan_lahir',
                        'vitamin_a',
                        'kb_pasca_kelahiran',
                        'konseling',
                        'tata_laksana_kasus',
                    ])
                }

                ajaxCall(url, "POST", formData, successCallback, errorCallback);
            })
        })
    </script>
@endpush
