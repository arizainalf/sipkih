@extends('layouts.app')
@section('title', 'Kehamilan ' . $kehamilan->ibu->nama)
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
            <h1>@yield('title') - Anak Ke {{ $kehamilan->anak_ke }} Ibu {{ $kehamilan->ibu->nama }} -
                {{ $kehamilan->ibu->nik }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">@yield('title')</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Grafik Kehamilan</h4>
                            <a href="{{ route('kehamilan.exportPdf', $kehamilan->id) }}" class="btn btn-danger">
                                <i class="fas fa-file-pdf"></i> Export PDF
                            </a>
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
                                <h4 class="text-primary">Menyambut Persalinan</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div>
                                <form id="form-kehamilan">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label for="anak_ke">Anak Ke</label>
                                                    <input type="hidden" value="{{ $kehamilan->ibu_id }}" name="ibu_id">
                                                    <input type="number" name="anak_ke" value="{{ $kehamilan->anak_ke }}"
                                                        id="anak_ke" class="form-control" min="1" required>
                                                    <div class="invalid-feedback" id="error-anak_ke"></div>
                                                </div>

                                                <div class="form-group mb-2">
                                                    <label for="bulan_perkiraan_lahir">Bulan Perkiraan Lahir</label>
                                                    <div class="d-flex align-items-center">
                                                        <select name="bulan" id="bulan" class="form-control mr-2"
                                                            style="flex: 1;">
                                                            <option value="">Pilih Bulan</option>
                                                            <option value="Januari"
                                                                {{ $kehamilan->bulan == 'Januari' ? 'selected' : '' }}>
                                                                Januari</option>
                                                            <option value="Februari"
                                                                {{ $kehamilan->bulan == 'Februari' ? 'selected' : '' }}>
                                                                Februari</option>
                                                            <option value="Maret"
                                                                {{ $kehamilan->bulan == 'Maret' ? 'selected' : '' }}>Maret
                                                            </option>
                                                            <option value="April"
                                                                {{ $kehamilan->bulan == 'April' ? 'selected' : '' }}>April
                                                            </option>
                                                            <option value="Mei"
                                                                {{ $kehamilan->bulan == 'Mei' ? 'selected' : '' }}>Mei
                                                            </option>
                                                            <option value="Juni"
                                                                {{ $kehamilan->bulan == 'Juni' ? 'selected' : '' }}>Juni
                                                            </option>
                                                            <option value="Juli"
                                                                {{ $kehamilan->bulan == 'Juli' ? 'selected' : '' }}>Juli
                                                            </option>
                                                            <option value="Agustus"
                                                                {{ $kehamilan->bulan == 'Agustus' ? 'selected' : '' }}>
                                                                Agustus</option>
                                                            <option value="September"
                                                                {{ $kehamilan->bulan == 'September' ? 'selected' : '' }}>
                                                                September</option>
                                                            <option value="Oktober"
                                                                {{ $kehamilan->bulan == 'Oktober' ? 'selected' : '' }}>
                                                                Oktober</option>
                                                            <option value="November"
                                                                {{ $kehamilan->bulan == 'November' ? 'selected' : '' }}>
                                                                November</option>
                                                            <option value="Desember"
                                                                {{ $kehamilan->bulan == 'Desember' ? 'selected' : '' }}>
                                                                Desember</option>
                                                        </select>
                                                        <select name="tahun" id="tahun" class="form-control"
                                                            style="flex: 1;">
                                                            <option value="">Pilih Tahun</option>
                                                            @for ($i = date('Y'); $i <= date('Y') + 2; $i++)
                                                                <option value="{{ $i }}"
                                                                    {{ $kehamilan->tahun == $i ? 'selected' : '' }}>
                                                                    {{ $i }}
                                                                </option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                    <div class="invalid-feedback" id="error-bulan_perkiraan_lahir"></div>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label for="kendaraan">Kendaraan Persalinan</label>
                                                    <select name="kendaraan" id="kendaraan" class="form-control" required>
                                                        <option value="pribadi"
                                                            {{ $kehamilan->kendaraan == 'pribadi' ? 'selected' : '' }}>
                                                            Pribadi</option>
                                                        <option value="ambulance"
                                                            {{ $kehamilan->kendaraan == 'ambulance' ? 'selected' : '' }}>
                                                            Ambulance</option>
                                                    </select>
                                                    <div class="invalid-feedback" id="error-kendaraan"></div>
                                                </div>

                                                <div class="form-group mb-2">
                                                    <label for="kontrasepsi">Kontrasepsi</label>
                                                    <input type="text" value="{{ $kehamilan->kontrasepsi }}"
                                                        name="kontrasepsi" id="kontrasepsi" class="form-control">
                                                    <div class="invalid-feedback" id="error-kontrasepsi"></div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label for="sumbangan_darah">Sumbangan Darah</label>
                                                    <input type="text" value="{{ $kehamilan->sumbangan_darah }}"
                                                        name="sumbangan_darah" id="sumbangan_darah" class="form-control">
                                                    <div class="invalid-feedback" id="error-sumbangan_darah"></div>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label for="dana_persalinan">Dana Persalinan</label>
                                                    <select name="dana_persalinan" id="dana_persalinan"
                                                        class="form-control" required>
                                                        <option value="sendiri"
                                                            {{ $kehamilan->dana_persalinan == 'sendiri' ? 'selected' : '' }}>
                                                            Biaya Sendiri</option>
                                                        <option value="jkn"
                                                            {{ $kehamilan->dana_persalinan == 'jkn' ? 'selected' : '' }}>
                                                            JKN</option>
                                                        <option value="jampersal"
                                                            {{ $kehamilan->dana_persalinan == 'jampersal' ? 'selected' : '' }}>
                                                            Jampersal</option>
                                                    </select>
                                                    <div class="invalid-feedback" id="error-dana_persalinan"></div>
                                                </div>

                                                <div class="form-group mb-2">
                                                    <label for="bidan">Bidan Penolong</label>
                                                    <input type="text" value="{{ $kehamilan->bidan }}" name="bidan"
                                                        id="bidan" class="form-control">
                                                    <div class="invalid-feedback" id="error-bidan"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($kehamilan->persalinan)
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title font-weight-bolder">
                                    <h4 class="text-primary">Persalinan</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div>
                                    <form id="form-persalinan">
                                        @csrf
                                        <div class="modal-body">

                                            <input type="hidden" name="kehamilan_id" value="{{ $kehamilan->id }}">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label for="tanggal_persalinan">Tanggal Persalinan</label>
                                                        <input type="date" name="tanggal_persalinan"
                                                            id="tanggal_persalinan" class="form-control" required
                                                            value="{{ $kehamilan->persalinan->tanggal_persalinan }}">
                                                        <div class="invalid-feedback" id="error-tanggal_persalinan"></div>
                                                    </div>

                                                    <div class="form-group mb-2">
                                                        <label for="waktu_persalinan">Waktu Persalinan</label>
                                                        <input type="time" name="waktu_persalinan"
                                                            id="waktu_persalinan" class="form-control"
                                                            value="{{ \Carbon\Carbon::parse($kehamilan->persalinan->waktu_persalinan)->format('H:i') }}">
                                                        <div class="invalid-feedback" id="error-waktu_persalinan"></div>
                                                    </div>

                                                    <div class="form-group mb-2">
                                                        <label for="umur_kehamilan_minggu">Umur Kehamilan (minggu)</label>
                                                        <input type="number" name="umur_kehamilan_minggu"
                                                            id="umur_kehamilan_minggu" class="form-control" required
                                                            value="{{ $kehamilan->persalinan->umur_kehamilan_minggu }}">
                                                        <div class="invalid-feedback" id="error-umur_kehamilan_minggu">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label for="penolong_persalinan">Penolong Persalinan</label>
                                                        <select name="penolong_persalinan" id="penolong_persalinan"
                                                            class="form-control" required>
                                                            <option value="">Pilih Penolong</option>
                                                            <option value="SpOG"
                                                                {{ $kehamilan->persalinan->penolong_persalinan == 'SpOG' ? 'selected' : '' }}>
                                                                SpOG</option>
                                                            <option value="Dokter Umum"
                                                                {{ $kehamilan->persalinan->penolong_persalinan == 'Dokter Umum' ? 'selected' : '' }}>
                                                                Dokter Umum</option>
                                                            <option value="Bidan"
                                                                {{ $kehamilan->persalinan->penolong_persalinan == 'Bidan' ? 'selected' : '' }}>
                                                                Bidan</option>
                                                            <option value="Lainnya"
                                                                {{ $kehamilan->persalinan->penolong_persalinan == 'Lainnya' ? 'selected' : '' }}>
                                                                Lainnya</option>
                                                        </select>
                                                        <div class="invalid-feedback" id="error-penolong_persalinan">
                                                        </div>
                                                    </div>

                                                    <div class="form-group mb-2">
                                                        <label for="cara_persalinan">Cara Persalinan</label>
                                                        <select name="cara_persalinan" id="cara_persalinan"
                                                            class="form-control" required>
                                                            <option value="">Pilih Cara</option>
                                                            <option value="Normal"
                                                                {{ $kehamilan->persalinan->cara_persalinan == 'Normal' ? 'selected' : '' }}>
                                                                Normal</option>
                                                            <option value="Forceps"
                                                                {{ $kehamilan->persalinan->cara_persalinan == 'Forceps' ? 'selected' : '' }}>
                                                                Forceps</option>
                                                            <option value="Vakum"
                                                                {{ $kehamilan->persalinan->cara_persalinan == 'Vakum' ? 'selected' : '' }}>
                                                                Vakum</option>
                                                            <option value="Sectio Caesarea"
                                                                {{ $kehamilan->persalinan->cara_persalinan == 'Sectio Caesarea' ? 'selected' : '' }}>
                                                                Sectio Caesarea</option>
                                                            <option value="Lainnya"
                                                                {{ $kehamilan->persalinan->cara_persalinan == 'Lainnya' ? 'selected' : '' }}>
                                                                Lainnya</option>
                                                        </select>
                                                        <div class="invalid-feedback" id="error-cara_persalinan"></div>
                                                    </div>

                                                    <div class="form-group mb-2">
                                                        <label for="keadaan_ibu">Keadaan Ibu</label>
                                                        <select name="keadaan_ibu" id="keadaan_ibu" class="form-control"
                                                            required>
                                                            <option value="">Pilih Keadaan</option>
                                                            <option value="Sehat"
                                                                {{ $kehamilan->persalinan->keadaan_ibu == 'Sehat' ? 'selected' : '' }}>
                                                                Sehat</option>
                                                            <option value="Sakit"
                                                                {{ $kehamilan->persalinan->keadaan_ibu == 'Sakit' ? 'selected' : '' }}>
                                                                Sakit</option>
                                                            <option value="Meninggal"
                                                                {{ $kehamilan->persalinan->keadaan_ibu == 'Meninggal' ? 'selected' : '' }}>
                                                                Meninggal</option>
                                                        </select>
                                                        <div class="invalid-feedback" id="error-keadaan_ibu"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group mb-2">
                                                <label for="detail_keadaan_ibu">Detail Keadaan Ibu</label>
                                                <textarea name="detail_keadaan_ibu" id="detail_keadaan_ibu" class="form-control" rows="2">{{ $kehamilan->persalinan->detail_keadaan_ibu }}</textarea>
                                                <div class="invalid-feedback" id="error-detail_keadaan_ibu"></div>
                                            </div>

                                            <div class="form-group mb-2">
                                                <label for="kb_pasca_persalinan">KB Pasca Persalinan</label>
                                                <input type="text" name="kb_pasca_persalinan" id="kb_pasca_persalinan"
                                                    class="form-control"
                                                    value="{{ $kehamilan->persalinan->kb_pasca_persalinan }}">
                                                <div class="invalid-feedback" id="error-kb_pasca_persalinan"></div>
                                            </div>

                                            <div class="form-group mb-2">
                                                <label for="keterangan_tambahan">Keterangan Tambahan</label>
                                                <textarea name="keterangan_tambahan" id="keterangan_tambahan" class="form-control" rows="2">{{ $kehamilan->persalinan->keterangan_tambahan }}</textarea>
                                                <div class="invalid-feedback" id="error-keterangan_tambahan"></div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Simpan Data</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($kehamilan->persalinan->bayi)
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title font-weight-bolder">
                                        <h4 class="text-primary">Bayi Baru Lahir</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div>
                                        <form id="form-bayi">
                                            @csrf
                                            <input type="hidden" name="persalinan_id" id="persalinan_id"
                                                value="{{ $kehamilan->persalinan->id }}">

                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-2">
                                                            <label for="anak_ke">Anak Ke</label>
                                                            <input type="number" value="{{ $kehamilan->anak_ke }}"
                                                                id="anak_ke" class="form-control" min="1"
                                                                required>
                                                            <div class="invalid-feedback" id="erroranak_ke"></div>
                                                        </div>

                                                        <div class="form-group mb-2">
                                                            <label for="berat_lahir_gram">Berat Lahir (gram)</label>
                                                            <input type="number" name="berat_lahir_gram"
                                                                id="berat_lahir_gram" class="form-control" required
                                                                value="{{ $kehamilan->persalinan->bayi->berat_lahir_gram }}">
                                                            <div class="invalid-feedback" id="errorberat_lahir_gram">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-2">
                                                            <label for="panjang_badan_cm">Panjang Badan (cm)</label>
                                                            <input type="number" step="0.1" name="panjang_badan_cm"
                                                                id="panjang_badan_cm" class="form-control" required
                                                                value="{{ $kehamilan->persalinan->bayi->panjang_badan_cm }}">
                                                            <div class="invalid-feedback" id="errorpanjang_badan_cm">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group mb-2">
                                                            <label for="lingkar_kepala_cm">Lingkar Kepala (cm)</label>
                                                            <input type="number" step="0.1" name="lingkar_kepala_cm"
                                                                id="lingkar_kepala_cm" class="form-control" required
                                                                value="{{ $kehamilan->persalinan->bayi->lingkar_kepala_cm }}">
                                                            <div class="invalid-feedback" id="errorlingkar_kepala_cm">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-2">
                                                            <label for="jenis_kelamin">Jenis Kelamin</label>
                                                            <select name="jenis_kelamin" id="jenis_kelamin"
                                                                class="form-control" required>
                                                                <option value="">Pilih Jenis Kelamin</option>
                                                                <option value="Laki-laki"
                                                                    {{ $kehamilan->persalinan->bayi->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>
                                                                    Laki-laki</option>
                                                                <option value="Perempuan"
                                                                    {{ $kehamilan->persalinan->bayi->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>
                                                                    Perempuan</option>
                                                                <option value="Tidak bisa ditentukan"
                                                                    {{ $kehamilan->persalinan->bayi->jenis_kelamin == 'Tidak bisa ditentukan' ? 'selected' : '' }}>
                                                                    Tidak bisa ditentukan</option>
                                                            </select>
                                                            <div class="invalid-feedback" id="errorjenis_kelamin"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card mb-3">
                                                    <div class="card-header">Kondisi Bayi Saat Lahir</div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="segera_menangis" id="segera_menangis"
                                                                        {{ $kehamilan->persalinan->bayi->segera_menangis ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="segera_menangis">Segera menangis</label>
                                                                </div>
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="menangis_beberapa_saat"
                                                                        id="menangis_beberapa_saat"
                                                                        {{ $kehamilan->persalinan->bayi->menangis_beberapa_saat ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="menangis_beberapa_saat">Menangis beberapa
                                                                        saat</label>
                                                                </div>
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="tidak_menangis" id="tidak_menangis"
                                                                        {{ $kehamilan->persalinan->bayi->tidak_menangis ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="tidak_menangis">Tidak menangis</label>
                                                                </div>
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="seluruh_tubuh_kemerahan"
                                                                        id="seluruh_tubuh_kemerahan"
                                                                        {{ $kehamilan->persalinan->bayi->seluruh_tubuh_kemerahan ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="seluruh_tubuh_kemerahan">Seluruh tubuh
                                                                        kemerahan</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="anggota_gerak_kebiruan"
                                                                        id="anggota_gerak_kebiruan"
                                                                        {{ $kehamilan->persalinan->bayi->anggota_gerak_kebiruan ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="anggota_gerak_kebiruan">Anggota gerak
                                                                        kebiruan</label>
                                                                </div>
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="seluruh_tubuh_biru" id="seluruh_tubuh_biru"
                                                                        {{ $kehamilan->persalinan->bayi->seluruh_tubuh_biru ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="seluruh_tubuh_biru">Seluruh tubuh biru</label>
                                                                </div>
                                                                <div class="form-group mb-2">
                                                                    <label for="kelainan_bawaan">Kelainan bawaan</label>
                                                                    <input type="text" name="kelainan_bawaan"
                                                                        id="kelainan_bawaan" class="form-control"
                                                                        value="{{ $kehamilan->persalinan->bayi->kelainan_bawaan }}">
                                                                </div>
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="meninggal" id="meninggal"
                                                                        {{ $kehamilan->persalinan->bayi->meninggal ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="meninggal">Meninggal</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card mb-3">
                                                    <div class="card-header">Asuhan Bayi Baru Lahir</div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="imd" id="imd"
                                                                        {{ $kehamilan->persalinan->bayi->imd ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="imd">Inisiasi Menyusu Dini (IMD)</label>
                                                                </div>
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="vitamin_k1" id="vitamin_k1"
                                                                        {{ $kehamilan->persalinan->bayi->vitamin_k1 ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="vitamin_k1">Suntikan Vitamin K1</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="salep_mata" id="salep_mata"
                                                                        {{ $kehamilan->persalinan->bayi->salep_mata ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="salep_mata">Salep
                                                                        mata antibiotika profilaksis</label>
                                                                </div>
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="imunisasi_hb0" id="imunisasi_hb0"
                                                                        {{ $kehamilan->persalinan->bayi->imunisasi_hb0 ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="imunisasi_hb0">Imunisasi HB0</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-2">
                                                    <label for="keterangan_tambahan">Keterangan Tambahan</label>
                                                    <textarea name="keterangan_tambahan" id="keterangan_tambahan" class="form-control" rows="2">{{ $kehamilan->persalinan->bayi->keterangan_tambahan }}</textarea>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Simpan Data</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($kehamilan->persalinan->kunjunganNifas)
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title font-weight-bolder">
                                        <h4 class="text-primary">Kunjungan Nifas</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div>
                                        <form id="form-kunjungan-nifas">
                                            @csrf
                                            <input type="hidden" name="persalinan_id" id="persalinan_id_kunjungan"
                                                value="{{ $kehamilan->persalinan->id }}">

                                            <div class="modal-body">
                                                <!-- KF1 Section (6-48 jam) -->
                                                <div class="card mb-3">
                                                    <div class="card-header">KF1 - 6-48 Jam</div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-2">
                                                                    <label for="tanggal_kunjungan_kf_1">Tanggal
                                                                        Kunjungan</label>
                                                                    <input type="date" name="tanggal_kunjungan_kf_1"
                                                                        id="tanggal_kunjungan_kf_1" class="form-control"
                                                                        value="{{ $kehamilan->persalinan->kunjunganNifas->tanggal_kunjungan_kf_1 ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-2">
                                                                    <label for="faskes_kf_1">Fasilitas Kesehatan</label>
                                                                    <input type="text" name="faskes_kf_1"
                                                                        id="faskes_kf_1" class="form-control"
                                                                        value="{{ $kehamilan->persalinan->kunjunganNifas->faskes_kf_1 ?? '' }}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-2">
                                                            <label for="masalah_kf_1">Masalah yang Ditemukan</label>
                                                            <textarea name="masalah_kf_1" id="masalah_kf_1" class="form-control" rows="2">{{ $kehamilan->persalinan->kunjunganNifas->masalah_kf_1 ?? '' }}</textarea>
                                                        </div>

                                                        <div class="form-group mb-2">
                                                            <label for="tindakan_kf_1">Tindakan</label>
                                                            <textarea name="tindakan_kf_1" id="tindakan_kf_1" class="form-control" rows="2">{{ $kehamilan->persalinan->kunjunganNifas->tindakan_kf_1 ?? '' }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- KF2 Section (3-7 hari) -->
                                                <div class="card mb-3">
                                                    <div class="card-header">KF2 - 3-7 Hari</div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-2">
                                                                    <label for="tanggal_kunjungan_kf_2">Tanggal
                                                                        Kunjungan</label>
                                                                    <input type="date" name="tanggal_kunjungan_kf_2"
                                                                        id="tanggal_kunjungan_kf_2" class="form-control"
                                                                        value="{{ $kehamilan->persalinan->kunjunganNifas->tanggal_kunjungan_kf_2 ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-2">
                                                                    <label for="faskes_kf_2">Fasilitas Kesehatan</label>
                                                                    <input type="text" name="faskes_kf_2"
                                                                        id="faskes_kf_2" class="form-control"
                                                                        value="{{ $kehamilan->persalinan->kunjunganNifas->faskes_kf_2 ?? '' }}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-2">
                                                            <label for="masalah_kf_2">Masalah yang Ditemukan</label>
                                                            <textarea name="masalah_kf_2" id="masalah_kf_2" class="form-control" rows="2">{{ $kehamilan->persalinan->kunjunganNifas->masalah_kf_2 ?? '' }}</textarea>
                                                        </div>

                                                        <div class="form-group mb-2">
                                                            <label for="tindakan_kf_2">Tindakan</label>
                                                            <textarea name="tindakan_kf_2" id="tindakan_kf_2" class="form-control" rows="2">{{ $kehamilan->persalinan->kunjunganNifas->tindakan_kf_2 ?? '' }}</textarea>
                                                        </div>


                                                    </div>
                                                </div>

                                                <!-- KF3 Section (8-28 hari) -->
                                                <div class="card mb-3">
                                                    <div class="card-header">KF3 - 8-28 Hari</div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-2">
                                                                    <label for="tanggal_kunjungan_kf_3">Tanggal
                                                                        Kunjungan</label>
                                                                    <input type="date" name="tanggal_kunjungan_kf_3"
                                                                        id="tanggal_kunjungan_kf_3" class="form-control"
                                                                        value="{{ $kehamilan->persalinan->kunjunganNifas->tanggal_kunjungan_kf_3 ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-2">
                                                                    <label for="faskes_kf_3">Fasilitas Kesehatan</label>
                                                                    <input type="text" name="faskes_kf_3"
                                                                        id="faskes_kf_3" class="form-control"
                                                                        value="{{ $kehamilan->persalinan->kunjunganNifas->faskes_kf_3 ?? '' }}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-2">
                                                            <label for="masalah_kf_3">Masalah yang Ditemukan</label>
                                                            <textarea name="masalah_kf_3" id="masalah_kf_3" class="form-control" rows="2">{{ $kehamilan->persalinan->kunjunganNifas->masalah_kf_3 ?? '' }}</textarea>
                                                        </div>

                                                        <div class="form-group mb-2">
                                                            <label for="tindakan_kf_3">Tindakan</label>
                                                            <textarea name="tindakan_kf_3" id="tindakan_kf_3" class="form-control" rows="2">{{ $kehamilan->persalinan->kunjunganNifas->tindakan_kf_3 ?? '' }}</textarea>
                                                        </div>


                                                    </div>
                                                </div>

                                                <!-- KF4 Section (28 hari ke atas) -->
                                                <div class="card mb-3">
                                                    <div class="card-header">KF4 - 28 Hari Ke Atas</div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-2">
                                                                    <label for="tanggal_kunjungan_kf_4">Tanggal
                                                                        Kunjungan</label>
                                                                    <input type="date" name="tanggal_kunjungan_kf_4"
                                                                        id="tanggal_kunjungan_kf_4" class="form-control"
                                                                        value="{{ $kehamilan->persalinan->kunjunganNifas->tanggal_kunjungan_kf_4 ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-2">
                                                                    <label for="faskes_kf_4">Fasilitas Kesehatan</label>
                                                                    <input type="text" name="faskes_kf_4"
                                                                        id="faskes_kf_4" class="form-control"
                                                                        value="{{ $kehamilan->persalinan->kunjunganNifas->faskes_kf_4 ?? '' }}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-2">
                                                            <label for="masalah_kf_4">Masalah yang Ditemukan</label>
                                                            <textarea name="masalah_kf_4" id="masalah_kf_4" class="form-control" rows="2">{{ $kehamilan->persalinan->kunjunganNifas->masalah_kf_4 ?? '' }}</textarea>
                                                        </div>

                                                        <div class="form-group mb-2">
                                                            <label for="tindakan_kf_4">Tindakan</label>
                                                            <textarea name="tindakan_kf_4" id="tindakan_kf_4" class="form-control" rows="2">{{ $kehamilan->persalinan->kunjunganNifas->tindakan_kf_4 ?? '' }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Simpan Data</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($kehamilan->persalinan->kesimpulanNifas)
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title font-weight-bolder">
                                        <h4 class="text-primary">Kesimpulan Nifas</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div>
                                        <form id="form-kesimpulan-nifas">
                                            @csrf
                                            <input type="hidden" name="persalinan_id" id="persalinan_id_kesimpulan"
                                                value="{{ $kehamilan->persalinan->id }}">

                                            <div class="modal-body">
                                                <div class="card mb-3">
                                                    <div class="card-header">Keadaan Ibu</div>
                                                    <div class="card-body">
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="radio"
                                                                name="keadaan_ibu" id="keadaan_ibu_sehat" value="Sehat"
                                                                required
                                                                {{ $kehamilan->persalinan->kesimpulanNifas->keadaan_ibu == 'Sehat' ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="keadaan_ibu_sehat">Sehat</label>
                                                        </div>
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="radio"
                                                                name="keadaan_ibu" id="keadaan_ibu_sakit" value="Sakit"
                                                                {{ $kehamilan->persalinan->kesimpulanNifas->keadaan_ibu == 'Sakit' ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="keadaan_ibu_sakit">Sakit</label>
                                                        </div>
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="radio"
                                                                name="keadaan_ibu" id="keadaan_ibu_meninggal"
                                                                value="Meninggal"
                                                                {{ $kehamilan->persalinan->kesimpulanNifas->keadaan_ibu == 'Meninggal' ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="keadaan_ibu_meninggal">Meninggal</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card mb-3">
                                                    <div class="card-header">Komplikasi Nifas</div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="perdarahan" id="perdarahan"
                                                                        {{ $kehamilan->persalinan->kesimpulanNifas->perdarahan ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="perdarahan">Perdarahan</label>
                                                                </div>
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="infeksi" id="infeksi"
                                                                        {{ $kehamilan->persalinan->kesimpulanNifas->infeksi ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="infeksi">Infeksi</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="hipertensi" id="hipertensi"
                                                                        {{ $kehamilan->persalinan->kesimpulanNifas->hipertensi ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="hipertensi">Hipertensi</label>
                                                                </div>
                                                                <div class="form-group mb-2">
                                                                    <label for="komplikasi_lain">Lain-lain</label>
                                                                    <input type="text" name="komplikasi_lain"
                                                                        id="komplikasi_lain" class="form-control"
                                                                        value="{{ $kehamilan->persalinan->kesimpulanNifas->komplikasi_lain }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card mb-3">
                                                    <div class="card-header">Keadaan Bayi</div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="keadaan_bayi" id="keadaan_bayi_sehat"
                                                                        value="Sehat" required
                                                                        {{ $kehamilan->persalinan->kesimpulanNifas->keadaan_bayi == 'Sehat' ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="keadaan_bayi_sehat">Sehat</label>
                                                                </div>
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="keadaan_bayi" id="keadaan_bayi_sakit"
                                                                        value="Sakit"
                                                                        {{ $kehamilan->persalinan->kesimpulanNifas->keadaan_bayi == 'Sakit' ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="keadaan_bayi_sakit">Sakit</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-2">
                                                                    <label for="kelainan_bawaan">Kelainan Bawaan</label>
                                                                    <input type="text" name="kelainan_bawaan"
                                                                        id="kelainan_bawaan_kesimpulan"
                                                                        class="form-control"
                                                                        value="{{ $kehamilan->persalinan->kesimpulanNifas->kelainan_bawaan }}">
                                                                </div>
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="keadaan_bayi" id="keadaan_bayi_meninggal"
                                                                        value="Meninggal"
                                                                        {{ $kehamilan->persalinan->kesimpulanNifas->keadaan_bayi == 'Meninggal' ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="keadaan_bayi_meninggal">Meninggal</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-2">
                                                    <label for="catatan">Catatan</label>
                                                    <textarea name="catatan" id="catatan" class="form-control" rows="2">{{ $kehamilan->persalinan->kesimpulanNifas->catatan }}</textarea>
                                                </div>

                                                <div class="form-group mb-2">
                                                    <label for="kesimpulan">Kesimpulan</label>
                                                    <textarea name="kesimpulan" id="kesimpulan" class="form-control" rows="3" required>{{ $kehamilan->persalinan->kesimpulanNifas->kesimpulan }}</textarea>
                                                    <div class="invalid-feedback" id="errorkesimpulan"></div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Simpan Kesimpulan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title font-weight-bolder">
                                <h4 class="text-primary">Data Pelayanan
                                </h4>
                            </div>
                            <div class="ml-auto">
                                <button id="tambah-button-pelayanan" class="btn btn-primary" data-toggle="modal"
                                    data-target="#modal-tambah-pelayanan"><i class="fas fa-plus mr-2"></i>Tambah</button>
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
                            <div class="ml-auto">
                                <button id="tambah-button-nifas" class="btn btn-primary" data-toggle="modal"
                                    data-target="#modal-tambah-nifas"><i class="fas fa-plus mr-2"></i>Tambah</button>
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
    <script src="{{ asset('') }}assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js">
    </script>
    <script src="{{ asset('') }}assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="{{ asset('') }}assets/modules/jquery-ui/jquery-ui.min.js"></script>
    <script src="{{ asset('') }}assets/modules/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('') }}assets/js/page/modules-datatables.js"></script>

    <script>
        $(document).ready(function() {

            let isEdit;

            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                events: '{{ route('kehamilan.kalender.events', $kehamilan->id) }}',

                eventClick: function(info) {
                    $.ajax({
                        url: '{{ url('admin/kehamilan/ttd') }}/' + info.event.id + '/toggle',
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

            $(document).on('click', '#tambah-button-pelayanan', function(e) {
                e.preventDefault();

                const $form = $('#form-tambah-pelayanan');
                $form[0].reset();
                $form.attr('data-id', '');
            })

            $(document).on('click', '.edit-button-pelayanan', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                isEdit = true;

                const $form = $('#form-tambah-pelayanan');
                $form[0].reset();
                $form.attr('data-id', id);

                initEditModal({
                    formSelector: '#form-tambah-pelayanan',
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
                        'tablet_tambah_darah',
                        'imunisasi_tetanus',
                        'ppia',
                        'tata_laksana_kasus',
                        'usg',
                    ],
                    callback: function(response) {
                        console.log(response, 'callback edit')
                    },
                    onFetched: null,
                })
            })

            $(document).on('submit', '#form-tambah-pelayanan', function(e) {
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
                    loadData('.table-responsive-pelayanan',
                        "{{ route('admin.kehamilan.detail.pelayanan', $kehamilan->id) }}",
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
                        'table_tambah_darah',
                        'imunisasi_tetanus',
                        'ppia',
                        'tata_laksana_kasus',
                        'usg',
                    ])
                }

                ajaxCall(url, "POST", formData, successCallback, errorCallback);
            })

            $(document).on('click', '#tambah-button-nifas', function(e) {
                e.preventDefault();

                const $form = $('#form-tambah-nifas');
                $form[0].reset();
                $form.attr('data-id', '');
            })

            $(document).on('click', '.edit-button-nifas', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                isEdit = true;

                const $form = $('#form-tambah-nifas');
                $form[0].reset();
                $form.attr('data-id', id);

                initEditModal({
                    formSelector: '#form-tambah-nifas',
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

            $(document).on('submit', '#form-kehamilan', function(e) {
                e.preventDefault();

                const url = '{{ route('admin.kehamilan.update.menyambut', $kehamilan->id) }}';

                const method = 'POST'

                const data = new FormData(this);

                data.append('_method', 'PUT');

                const successCallback = function(res) {
                    handleSuccess(res)
                }

                const errorCallback = function(err) {
                    handleValidationErrors(
                        'ibu_id',
                        'anak_ke',
                        'bulan',
                        'tahun',
                        'kendaraan',
                        'kontrasepsi',
                        'sumbangan_darah',
                        'dana_persalinan',
                        'bidan',
                    )
                }

                ajaxCall(url, method, data, successCallback, errorCallback)
            })

            // Form Persalinan
            $(document).on('submit', '#form-persalinan', function(e) {
                e.preventDefault();

                const url =
                    '{{ route('admin.kehamilan.update.persalinan', $kehamilan->persalinan->id ?? '') }}';
                const method = 'POST';
                const data = new FormData(this);

                data.append('_method', 'PUT');

                const successCallback = function(res) {
                    handleSuccess(res);
                }

                const errorCallback = function(err) {
                    handleValidationErrors(
                        'kehamilan_id',
                        'tanggal_persalinan',
                        'waktu_persalinan',
                        'umur_kehamilan_minggu',
                        'penolong_persalinan',
                        'cara_persalinan',
                        'keadaan_ibu',
                        'detail_keadaan_ibu',
                        'kb_pasca_persalinan',
                        'keterangan_tambahan'
                    );
                }

                ajaxCall(url, method, data, successCallback, errorCallback);
            });

            // Form Bayi
            $(document).on('submit', '#form-bayi', function(e) {
                e.preventDefault();

                const url =
                    '{{ route('admin.kehamilan.update.bayi', $kehamilan->persalinan->bayi->id ?? '') }}';
                const method = 'POST';
                const data = new FormData(this);

                data.append('_method', 'PUT');

                const successCallback = function(res) {
                    handleSuccess(res);
                }

                const errorCallback = function(err) {
                    handleValidationErrors(err, '#form-bayi', [
                        'persalinan_id',
                        'anak_ke',
                        'berat_lahir_gram',
                        'panjang_badan_cm',
                        'lingkar_kepala_cm',
                        'jenis_kelamin',
                        'segera_menangis',
                        'menangis_beberapa_saat',
                        'tidak_menangis',
                        'seluruh_tubuh_kemerahan',
                        'anggota_gerak_kebiruan',
                        'seluruh_tubuh_biru',
                        'kelainan_bawaan',
                        'meninggal',
                        'imd',
                        'vitamin_k1',
                        'salep_mata',
                        'imunisasi_hb0',
                        'keterangan_tambahan'
                    ]);
                }

                ajaxCall(url, method, data, successCallback, errorCallback);
            });

            // Form Kunjungan Nifas
            $(document).on('submit', '#form-kunjungan-nifas', function(e) {
                e.preventDefault();

                const url =
                    '{{ route('admin.kehamilan.update.kunjungan', $kehamilan->persalinan->kunjunganNifas->id ?? '') }}';
                const method = 'POST';
                const data = new FormData(this);

                data.append('_method', 'PUT');

                const successCallback = function(res) {
                    handleSuccess(res);
                }

                const errorCallback = function(err) {
                    handleValidationErrors(
                        'persalinan_id',
                        'jenis_kunjungan',
                        'tanggal_kunjungan',
                        'faskes',
                        'masalah',
                        'tindakan',
                        'asi',
                        'belum_asi',
                        'trauma',
                        'message',
                        'belum_bab',
                        'ayruba',
                        'mudra',
                        'tetanus',
                        'keterangan_tambahan'
                    );
                }

                ajaxCall(url, method, data, successCallback, errorCallback);
            });

            // Form Kesimpulan Nifas
            $(document).on('submit', '#form-kesimpulan-nifas', function(e) {
                e.preventDefault();

                const url =
                    '{{ route('admin.kehamilan.update.kesimpulan', $kehamilan->persalinan->kesimpulanNifas->id ?? '') }}';
                const method = 'POST';
                const data = new FormData(this);

                data.append('_method', 'PUT');

                const successCallback = function(res) {
                    handleSuccess(res);
                }

                const errorCallback = function(err) {
                    handleValidationErrors(
                        'persalinan_id',
                        'keadaan_ibu',
                        'perdarahan',
                        'infeksi',
                        'hipertensi',
                        'komplikasi_lain',
                        'keadaan_bayi',
                        'kelainan_bawaan',
                        'catatan',
                        'kesimpulan'
                    );
                }

                ajaxCall(url, method, data, successCallback, errorCallback);
            });

            $(document).on('submit', '#form-tambah-nifas', function(e) {
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
                    handleSuccess(response, 'modal-tambah-nifas')
                    loadData('.table-responsive-pelayanan',
                        "{{ route('admin.kehamilan.detail.pelayanan', $kehamilan->id) }}",
                        "#tabel-pelayanan")
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

            loadData('.table-responsive-nifas',
                "{{ route('admin.kehamilan.detail.nifas', $kehamilan->id) }}", "#tabel-nifas")
            loadData('.table-responsive-pelayanan',
                "{{ route('admin.kehamilan.detail.pelayanan', $kehamilan->id) }}", "#tabel-pelayanan")
            dataLoad('.table-responsive-ttd', "{{ route('admin.kehamilan.detail.ttd', $kehamilan->id) }}")
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
