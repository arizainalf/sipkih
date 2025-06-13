@extends('layouts.auth')
@section('title', 'Register')

@push('styles')
@endpush

@section('content')

    <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
        <div class="login-brand">
            <img src="assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle">
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Registrasi Akun</h4>
            </div>
            <div class="card-body">
                <form id="form-daftar">
                    <div class="row">
                        <div class="form-group col-md-12 col-xl-6">
                            <label for="nik">NIK</label>
                            <input id="nik" type="text" class="form-control" name="nik" autofocus>
                            <div class="invalid-feedback" id="errornik">
                            </div>
                        </div>
                        <div class="form-group col-md-12 col-xl-6">
                            <label for="nama">Nama Lengkap</label>
                            <input id="nama" type="text" class="form-control" name="nama" autofocus>
                            <div class="invalid-feedback" id="errornama">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12 col-xl-6">
                            <label for="pembiayaan">Biaya</label>
                            <select name="pembiayaan" id="pembiayaan" class="form-control">
                                <option value="Mandiri">Mandiri</option>
                                <option value="kis">KIS</option>
                                <option value="kip">KIP</option>
                            </select>
                            <div class="invalid-feedback" id="errorbiaya">
                            </div>
                        </div>
                        <div class="form-group col-md-12 col-xl-6">
                            <label for="no_jkn">No. JKN</label>
                            <input type="text" name="no_jkn" id="no_jkn" class="form-control">
                            <div class="invalid-feedback" id="errorno_jkn">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12 col-xl-6">
                            <label for="golongan_darah">Golongan Darah</label>
                            <select name="golongan_darah" id="golongan_darah" class="form-control">
                                <option value="">Pilih Golongan Darah</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                            </select>
                            <div class="invalid-feedback" id="errorgolongandarah">
                            </div>
                        </div>
                        <div class="form-group col-md-12 col-xl-6">
                            <label for="tempat_lahir" class="d-block">Tempat, Tanggal Lahir</label>
                            <div class="input-group">
                                <input id="tempat_lahir" type="tempat_lahir" class="form-control"
                                    data-indicator="pwindicator" name="tempat_lahir">
                                <input id="tanggal_lahir" type="date" class="form-control" data-indicator="pwindicator"
                                    name="tanggal_lahir">

                            </div>
                        </div>
                        <div class="form-group col-md-12 col-xl-6">
                            <label for="pendidikan">Pendidikan Terakhir</label>
                            <select name="pendidikan" id="pendidikan" class="form-control">
                                <option value="">Pilih Pendidikan Terakhir</option>
                                <option value="sd">SD</option>
                                <option value="smp">SMP</option>
                                <option value="sma">SMA/SMK</option>
                                <option value="d3">D3</option>
                                <option value="s1">S1</option>
                                <option value="s2">S2</option>
                                <option value="s3">S3</option>
                            </select>
                            <div class="invalid-feedback" id="errorpendidikan">
                            </div>
                        </div>

                        <div class="form-group col-md-12 col-xl-6">
                            <label for="pekerjaan">Pekerjaan</label>
                            <input id="pekerjaan" type="text" class="form-control" name="pekerjaan" autofocus>
                            <div class="invalid-feedback" id="errorpekerjaan">
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-md-12 col-xl-6">
                            <label>Telepon</label>
                            <input type="text" name="telepon" class="form-control" id="telepon">
                        </div>
                        <div class="form-group col-md-12 col-xl-6">
                            <label>Nama Suami</label>
                            <input type="text" name="suami" class="form-control" id="suami">
                        </div>
                        <div class="form-group col-12">
                            <label>Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control" placeholder="Masukan alamat anda"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="agree" class="custom-control-input" id="agree">
                            <label class="custom-control-label" for="agree">Saya menyetujui syarat dan ketentuan yang
                                berlaku.</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <button id="submitBtn" type="submit" class="btn btn-primary btn-lg btn-block">
                            Register
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="simple-footer">
            Copyright &copy; Stisla 2018
        </div>
    </div>

@endsection
@push('scripts')
    <script src="{{ asset('') }}assets/modules/jquery-selectric/jquery.selectric.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#submitBtn').prop('disabled', true);

            $('#agree').change(function() {
                $('#submitBtn').prop('disabled', !$(this).is(':checked'));
            });

            $(document).on('submit', '#form-daftar', function(e) {
                e.preventDefault();

                const url = '{{ route('register.post') }}';
                const formData = new FormData(this);

                const successCallback = function(response) {
                    handleSuccess(response, null, '/login')
                }

                const errorCallback = function(error) {
                    handleValidationErrors(error, '#form-daftar', [
                        'nik',
                        'nama',
                        'pembiayaan',
                        'no_jkn',
                        'golongan_darah',
                        'tempat_lahir',
                        'tanggal_lahir',
                        'pendidikan',
                        'pekerjaan',
                        'telepon',
                        'suami',
                        'alamat',
                    ])
                }

                ajaxCall(url, "POST", formData, successCallback, errorCallback);
            })
        })
    </script>
@endpush
