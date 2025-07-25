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
    @include('pages.admin.form.modal')
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

            let isEdit = false; // Inisialisasi dengan false

            $(document).on('click', '#tambah-button', function(e) {
                e.preventDefault();
                isEdit = false; // Pastikan mode tambah

                const $form = $('#form-tambah');
                $form[0].reset();
                $form.removeAttr('data-id'); // Hapus data-id jika ada

                // Reset semua field validasi jika menggunakan plugin validasi
                $form.find('.is-invalid').removeClass('is-invalid');
                $form.find('.invalid-feedback').remove();

                // Reset judul modal jika perlu
                $('#modal-tambah .modal-title').text('Tambah Form');
            });

            $(document).on('click', '.edit-button', function(e) {
                e.preventDefault();
                isEdit = true; // Set mode edit

                const id = $(this).data('id');
                const $form = $('#form-tambah');
                $form.attr('data-id', id);

                // Update judul modal
                $('#modal-tambah .modal-title').text('Edit Form');

                initEditModal({
                    formSelector: '#form-tambah',
                    url: `admin/form/${id}`,
                    fields: ['nama', 'status'],
                    callback: null,
                    onFetched: null,
                });
            });

            $(document).on('submit', '#form-tambah', function(e) {
                e.preventDefault();

                let url = '{{ route('admin.form.store') }}';
                const formData = new FormData(this);

                console.log(isEdit)

                if (isEdit == true) {
                    const id = $(this).data('id');
                    url = `/admin/form/${id}`
                    formData.append('_method', 'PUT');
                    isEdit = false;
                }

                const successCallback = function(response) {
                    handleSuccess(response, 'modal-tambah')
                    loadData('.table-responsive', "{{ route('admin.form.index') }}",
                        "#tabel-form")
                }

                const errorCallback = function(error) {
                    handleValidationErrors(error, '#form-tambah', [
                        'nama',
                        'status',
                    ])
                }

                ajaxCall(url, "POST", formData, successCallback, errorCallback);
            })

            loadData('.table-responsive', "{{ route('admin.form.index') }}", "#tabel-form")
        })
    </script>
@endpush
