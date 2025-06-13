@extends('layouts.app')
@section('title', 'Pengaturan')
@push('styles')
    <link rel="stylesheet" href="{{ asset('') }}assets/modules/datatables/datatables.min.css">
    <link rel="stylesheet"
        href="{{ asset('') }}assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <style>
        #cropper-image {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header">
                                <div class="card-title font-weight-bolder">
                                    <h4 class="text-primary">@yield('title')
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center d-flex">
                                <div class="col-md-6">
                                    <form id="form-pengaturan">

                                        <div class="form-group mb-1">
                                            <img src="{{ asset('storage/' . getPengaturan()->logo) ?? asset('') }}" alt="" width="100">
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="logo">Logo Aplikasi</label>
                                            <input type="file" class="form-control" name="logo" required>
                                            <div class="invalid-feedback" id="errorlogo"></div>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="nama_aplikasi">Nama Aplikasi</label>
                                            <input type="text" class="form-control" name="nama_aplikasi" required
                                                value="{{ getPengaturan()->nama_aplikasi }}">
                                            <div class="invalid-feedback" id="errornama_aplikasi"></div>
                                        </div>

                                        <div class="form-group mb-1">
                                            <label for="deskripsi_aplikasi">Deskripsi</label>
                                            <input type="text" class="form-control" name="deskripsi_aplikasi" required
                                                value="{{ getPengaturan()->deskripsi }}">
                                            <div class="invalid-feedback" id="errordeskripsi_aplikasi"></div>
                                        </div>

                                        <div class="form-group mt-3">
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="cropperModal" tabindex="-1" role="dialog" aria-labelledby="cropperModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crop Logo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="cropper-image" src="" alt="Image">
                </div>
                <div class="modal-footer">
                    <button type="button" id="cropImageBtn" class="btn btn-primary">Crop & Upload</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('') }}assets/modules/datatables/datatables.min.js"></script>
    <script src="{{ asset('') }}assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('') }}assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="{{ asset('') }}assets/modules/jquery-ui/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>


    <!-- Page Specific JS File -->
    <script src="{{ asset('') }}assets/js/page/modules-datatables.js"></script>

    <script>
        $(document).ready(function() {

            let cropper;
            const image = document.getElementById('cropper-image');

            $('input[name="logo"]').on('change', function(e) {
                const file = e.target.files[0];
                if (file && /^image\/\w+/.test(file.type)) {
                    const reader = new FileReader();
                    reader.onload = function() {
                        image.onload = function() {
                            $('#cropperModal').modal('show');
                        };
                        image.src = reader.result;
                    }
                    reader.readAsDataURL(file);
                } else {
                    alert('File harus berupa gambar.');
                }
            });

            $('#cropperModal').on('shown.bs.modal', function() {
                cropper = new Cropper(image, {
                    aspectRatio: 1,
                    viewMode: 1,
                    autoCropArea: 1, // FULL WIDTH (biar tidak offset)
                    responsive: true,
                    background: false
                });
            }).on('hidden.bs.modal', function() {
                cropper.destroy();
                cropper = null;
            });


            $('#cropImageBtn').on('click', function() {
                cropper.getCroppedCanvas().toBlob(function(blob) {
                    const fileInput = $('input[name="logo"]');
                    const file = new File([blob], "cropped_logo.png", {
                        type: 'image/png'
                    });
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    fileInput[0].files = dataTransfer.files;

                    $('#cropperModal').modal('hide');
                });
            });

            $('#form-pengaturan').submit(function(e) {
                e.preventDefault();

                const url = "{{ route('admin.pengaturan.update') }}";
                const formData = new FormData(this);
                formData.append('_method', 'PUT');

                const successCallback = function(response) {
                    handleSuccess(response, null, '/admin/pengaturan')
                }

                const errorCallback = function(error) {
                    handleValidationErrors(error, '#form-pengaturan', [
                        'nama_aplikasi',
                        'deskripsi_aplikasi',
                        'logo',
                    ])
                }

                ajaxCall(url, "POST", formData, successCallback, errorCallback);
            })

        })
    </script>
@endpush
