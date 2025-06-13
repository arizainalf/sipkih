@extends('layouts.auth')
@section('title', 'Login')
@push('styles')
@endpush
@section('content')
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
        <div class="login-brand">
            <img src="{{ asset('') }}assets/img/stisla-fill.svg" alt="logo" width="100"
                class="shadow-light rounded-circle">
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4 id="login-title">Login</h4>
                <h4 id="login-title">{{ auth()->check() }}</h4>
            </div>

            <div class="card-body">
                <!-- Toggle Buttons -->
                <div class="row mb-3">
                    <div class="col-6">
                        <button type="button" class="btn btn-outline-primary btn-block" id="btn-user">
                            <i class="fas fa-user"></i> Ibu
                        </button>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-outline-danger btn-block" id="btn-admin">
                            <i class="fas fa-user-shield"></i> Admin
                        </button>
                    </div>
                </div>

                <!-- User Login Form -->
                <form method="POST" class="needs-validation" novalidate="" id="user-form">
                    @csrf
                    <input type="hidden" name="role" value="ibu">
                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input id="nik" type="nik" class="form-control" name="nik" tabindex="1" required
                            autofocus>
                        <div class="invalid-feedback">
                            Masukan nik anda.
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="d-block">
                            <label for="user-password" class="control-label">Password</label>
                            <div class="float-right">
                                <label for="user-password" class="control-label">Format Tahun-Bulan-Tanggal</label>
                            </div>
                        </div>
                        <div class="input-group">
                            <input id="user-password" type="password" class="form-control" name="password" tabindex="2"
                                required>
                                <div class="input-group-append">
                                    <button class="btn bg-white border" type="button"
                                        onclick="togglePasswordVisibility('#user-password', '#toggle-password'); event.preventDefault();">
                                        <i id="toggle-password" class="fas fa-eye"></i>
                                    </button>
                                </div>
                            <div class="invalid-feedback">
                                Masukan tanggal lahir anda contoh 2000-02-02
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="remember" class="custom-control-input" tabindex="3"
                                id="user-remember-me">
                            <label class="custom-control-label" for="user-remember-me">Remember Me</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                            Login
                        </button>
                    </div>
                </form>

                <!-- Admin Login Form -->
                <form method="POST" class="needs-validation" novalidate="" id="admin-form" style="display: none;">
                    @csrf
                    <input type="hidden" name="role" value="admin">
                    <div class="form-group">
                        <label for="admin-email">Email</label>
                        <input id="admin-email" type="email" class="form-control" name="email" tabindex="1" required>
                        <div class="invalid-feedback">
                            Masukan email anda admin.
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="d-block">
                            <label for="admin-password" class="control-label">Password</label>
                        </div>
                        <input id="admin-password" type="password" class="form-control" name="password" tabindex="2"
                            required>
                        <div class="invalid-feedback">
                            Masukan passwordnya juga min.
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="remember" class="custom-control-input" tabindex="3"
                                id="admin-remember-me">
                            <label class="custom-control-label" for="admin-remember-me">Remember Me</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-danger btn-lg btn-block" tabindex="4">
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-5 text-muted text-center">
            Ibu belum punya akun? <a href="{{ route('register') }}">Buat Sekarang</a>
        </div>
        <div class="simple-footer">
            Copyright &copy;
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            const savedRole = localStorage.getItem('loginRole');

            // Set default based on saved preference or default to 'user'
            const defaultRole = savedRole || 'user';
            toggleLoginForm(defaultRole);

            // Event handlers for toggle buttons
            $('#btn-user').click(function() {
                toggleLoginForm('user');
                localStorage.setItem('loginRole', 'user'); // Save preference
            });

            $('#btn-admin').click(function() {
                toggleLoginForm('admin');
                localStorage.setItem('loginRole', 'admin'); // Save preference
            });

            function toggleLoginForm(type) {
                if (type === 'user') {
                    // Show user form, hide admin form with animation
                    $('#admin-form').fadeOut(300, function() {
                        $('#user-form').fadeIn(300);
                    });

                    // Update button styles
                    $('#btn-user').removeClass('btn-outline-primary').addClass('btn-primary');
                    $('#btn-admin').removeClass('btn-danger').addClass('btn-outline-danger');

                    // Update title with animation
                    $('#login-title').fadeOut(150, function() {
                        $(this).text('Login').fadeIn(150);
                    });

                } else if (type === 'admin') {
                    // Show admin form, hide user form with animation
                    $('#user-form').fadeOut(300, function() {
                        $('#admin-form').fadeIn(300);
                    });

                    // Update button styles
                    $('#btn-admin').removeClass('btn-outline-danger').addClass('btn-danger');
                    $('#btn-user').removeClass('btn-primary').addClass('btn-outline-primary');

                    // Update title with animation
                    $('#login-title').fadeOut(150, function() {
                        $(this).text('Login').fadeIn(150);
                    });
                }
            }

            // Form validation enhancement
            $('.needs-validation').on('submit', function(e) {
                if (this.checkValidity() === false) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                $(this).addClass('was-validated');
            });

            // Clear validation when switching forms
            function clearValidation() {
                $('.needs-validation').removeClass('was-validated');
                $('.form-control').removeClass('is-invalid is-valid');
                $('.invalid-feedback').hide();
            }

            // Clear validation when switching between forms
            $('#btn-user, #btn-admin').click(function() {
                clearValidation();
            });

            // Real-time validation
            $('.form-control').on('blur', function() {
                if ($(this).val().trim() !== '') {
                    $(this).removeClass('is-invalid').addClass('is-valid');
                } else {
                    $(this).removeClass('is-valid').addClass('is-invalid');
                }
            });

            $(document).on('submit', '#admin-form', function(e) {
                e.preventDefault();

                const url = "{{ route('login.post') }}";
                const formData = new FormData(this);

                const successCallback = function(response) {
                    handleSuccess(response, null, '/admin')
                }

                const errorCallback = function(error) {
                    handleValidationErrors(error, '#admin-form', )
                }

                ajaxCall(url, "POST", formData, successCallback, errorCallback);
            })

            $(document).on('submit', '#user-form', function(e) {
                e.preventDefault();

                const url = "{{ route('login.post') }}";
                const formData = new FormData(this);

                const successCallback = function(response) {
                    handleSuccess(response, null, '/ibu')
                }

                const errorCallback = function(error) {
                    handleValidationErrors(error, '#user-form', )
                }

                ajaxCall(url, "POST", formData, successCallback, errorCallback);
            })
        });
    </script>
@endpush
