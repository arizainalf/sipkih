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
                            <h4 class="text-primary">@yield('title')</h4>
                        </div>
                        <div class="card-body">
                            <form id="form-profile">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label for="nik">NIK</label>
                                            <input type="text" class="form-control" name="nik"
                                                value="{{ auth()->user()->nik }}">
                                            <div class="invalid-feedback" id="errornik"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label for="nama">Nama</label>
                                            <input type="text" class="form-control" name="nama"
                                                value="{{ auth()->user()->nama }}">
                                            <div class="invalid-feedback" id="errornama"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label for="pembiayaan">Pembiayaan</label>
                                            <select name="pembiayaan" class="form-control">
                                                <option value="Mandiri"
                                                    {{ auth()->user()->pembiayaan == 'Mandiri' ? 'selected' : '' }}>Mandiri
                                                </option>
                                                <option value="KIS"
                                                    {{ auth()->user()->pembiayaan == 'KIS' ? 'selected' : '' }}>KIS</option>
                                                <option value="KIP"
                                                    {{ auth()->user()->pembiayaan == 'KIP' ? 'selected' : '' }}>KIP</option>
                                            </select>
                                            <div class="invalid-feedback" id="errorpembiayaan"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label for="suami">Nama Suami</label>
                                            <input type="text" class="form-control" name="suami"
                                                value="{{ auth()->user()->suami }}">
                                            <div class="invalid-feedback" id="errorsuami"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label for="no_jkn">No. JKN</label>
                                            <input type="text" class="form-control" name="no_jkn"
                                                value="{{ auth()->user()->no_jkn }}">
                                            <div class="invalid-feedback" id="errorno_jkn"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label for="golongan_darah">Golongan Darah</label>
                                            <input type="text" class="form-control" name="golongan_darah"
                                                value="{{ auth()->user()->golongan_darah }}">
                                            <div class="invalid-feedback" id="errorgolongan_darah"></div>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label for="tempat_lahir">Tempat, Tanggal Lahir</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="tempat_lahir"
                                                    value="{{ auth()->user()->tempat_lahir }}">
                                                <input type="date" class="form-control" name="tanggal_lahir"
                                                    value="{{ auth()->user()->tanggal_lahir }}">
                                            </div>
                                            <div class="invalid-feedback" id="errortempat_lahir"></div>
                                            <div class="invalid-feedback" id="errortanggal_lahir"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label for="pendidikan">Pendidikan</label>
                                            <select name="pendidikan" class="form-control">
                                                @foreach (['sd', 'smp', 'sma', 'd3', 's1', 's2', 's3'] as $edu)
                                                    <option value="{{ $edu }}"
                                                        {{ auth()->user()->pendidikan == $edu ? 'selected' : '' }}>
                                                        {{ strtoupper($edu) }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback" id="errorpendidikan"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label for="pekerjaan">Pekerjaan</label>
                                            <input type="text" class="form-control" name="pekerjaan"
                                                value="{{ auth()->user()->pekerjaan }}">
                                            <div class="invalid-feedback" id="errorpekerjaan"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label for="telepon">Telepon</label>
                                            <input type="text" class="form-control" name="telepon"
                                                value="{{ auth()->user()->telepon }}">
                                            <div class="invalid-feedback" id="errortelepon"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group mb-1">
                                            <label for="alamat">Alamat</label>
                                            <textarea class="form-control" name="alamat" rows="2">{{ auth()->user()->alamat }}</textarea>
                                            <div class="invalid-feedback" id="erroralamat"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </form>

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

            $('#form-profile').submit(function(e) {
                e.preventDefault();

                const url = "{{ route('ibu.profile.update') }}";
                const formData = new FormData(this);

                formData.append('_method', 'PUT');

                const successCallback = function(response) {
                    handleSuccess(response, null, '/ibu/profile')
                }

                const errorCallback = function(error) {
                    handleValidationErrors(error, '#form-profile', [
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
