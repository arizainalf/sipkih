@extends('layouts.app')
@section('title', 'Profile')
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
                                    <h4 class="text-primary">@yield('title')
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <form id="form-profile">
                                        <div class="form-group mb-1">
                                            <label for="nama">Nama</label>
                                            <input type="text" class="form-control" name="nama" required
                                                value="{{ auth()->user()->nama }}">
                                            <div class="invalid-feedback" id="errornama"></div>
                                        </div>

                                        <div class="form-group mb-1">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" name="email" required
                                                value="{{ auth()->user()->email }}">
                                            <div class="invalid-feedback" id="erroremail"></div>
                                        </div>

                                        <div class="form-group mt-3">
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-6">
                                    <form id="form-password">
                                        <div class="form-group mb-1">
                                            <label for="password">Password Saat Ini</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" name="password" id="password">
                                                <div class="input-group-append">
                                                    <button class="btn bg-white border" type="button"
                                                        onclick="togglePasswordVisibility('#password', '#toggle-password'); event.preventDefault();">
                                                        <i id="toggle-password" class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback" id="errorpassword"></div>
                                        </div>

                                        <div class="form-group mb-1">
                                            <label for="password_baru">Password Baru</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" name="password_baru"
                                                    id="password_baru">
                                                <div class="input-group-append">
                                                    <button class="btn bg-white border" type="button"
                                                        onclick="togglePasswordVisibility('#password_baru', '#toggle-password_baru'); event.preventDefault();">
                                                        <i id="toggle-password_baru" class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback" id="errorpassword_baru"></div>
                                        </div>

                                        <div class="form-group mb-1">
                                            <label for="konfirmasi_password_baru">Konfirmasi Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" name="konfirmasi_password_baru"
                                                    id="konfirmasi_password_baru">
                                                <div class="input-group-append">
                                                    <button class="btn bg-white border" type="button"
                                                        onclick="togglePasswordVisibility('#konfirmasi_password_baru', '#toggle-konfirmasi_password_baru'); event.preventDefault();">
                                                        <i id="toggle-konfirmasi_password_baru" class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback" id="errorkonfirmasi_password_baru"></div>
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
            $('#konfirmasi_password_baru').on('change', function() {
                if ($(this).val() != $('#password_baru').val()) {
                    $(this).addClass('is-invalid');
                    $(this).removeClass('is-valid');
                    $('#errorkonfirmasi_password_baru').html(
                        'Konfirmasi password harus sama dengan password baru'
                    );
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).addClass('is-valid');
                    $('#errorkonfirmasi_password_baru').html('');
                }
            })

            $('#form-profile').submit(function(e) {
                e.preventDefault();

                const url = "{{ route('admin.profile.update') }}";
                const formData = new FormData(this);

                const successCallback = function(response) {
                    handleSuccess(response, null, '/admin/profile')
                }

                const errorCallback = function(error) {
                    handleValidationErrors(error, '#form-profile', [
                        'name',
                        'email',
                    ])
                }

                ajaxCall(url, "POST", formData, successCallback, errorCallback);
            })

            $('#form-password').submit(function(e) {
                e.preventDefault();

                const url = "{{ route('admin.profile.password.update') }}";
                const formData = new FormData(this);

                const successCallback = function(response) {
                    handleSuccess(response, null, '/admin/profile')
                }

                const errorCallback = function(error) {
                    handleValidationErrors(error, '#form-password', [
                        'password',
                        'password_baru',
                        'konfirmasi_password_baru',
                    ])
                }

                ajaxCall(url, "POST", formData, successCallback, errorCallback);
            })
        })
    </script>
@endpush
