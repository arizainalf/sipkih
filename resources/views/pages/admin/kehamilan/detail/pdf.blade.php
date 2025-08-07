<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .chart-container {
            text-align: center;
            margin: 30px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .section-title {
            background-color: #e9ecef;
            padding: 10px;
            margin-top: 30px;
            font-weight: bold;
        }

        .card {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .card-header {
            background-color: #f8f9fa;
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
        }

        .card-body {
            padding: 15px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .text-primary {
            color: #007bff;
        }

        /* Dalam file CSS/view Anda */
        @media print {
            @page {
                size: landscape;
                margin: 1cm;
            }

            body {
                width: 100%;
                font-size: 12pt;
            }

            table {
                width: 100%;
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Laporan Kehamilan</h2>
        <h3>{{ $kehamilan->ibu->nama }} (NIK: {{ $kehamilan->ibu->nik }})</h3>
    </div>

    <div class="chart-container">
        <h4>Grafik Perkembangan Kehamilan</h4>
        <img src="{{ $chartPath }}" style="width: 100%; max-width: 800px;">
    </div>
    <div class="section-title">Pelayanan</div>
    <table>
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th>Ibu</th>
                <th>Kehamilan</th>
                <th>Trimester</th>
                <th>Tanggal Periksa</th>
                <th>Tinggi Badan (cm)</th>
                <th>Berat Badan (kg)</th>
                <th>Lingkar Lengan Atas (cm)</th>
                <th>Detak Jantung Janin</th>
                <th>Tinggi Rahim</th>
                <th>Konseling</th>
                <th>Test HB</th>
                <th>Test Gol. Darah</th>
                <th>Test Protein Urin</th>
                <th>Test Gula Darah</th>
                <th>PPIA</th>
                <th>Tata Laksana Kasus</th>
                <th>Usg</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pelayanans as $index => $pelayanan)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $pelayanan->kehamilan->ibu->nik }}, {{ $pelayanan->kehamilan->ibu->nama }}</td>
                    <td>{{ $pelayanan->kehamilan->anak_ke }}</td>
                    <td>{{ $pelayanan->trismester }}</td>
                    <td>{{ \Carbon\Carbon::parse($pelayanan->tanggal_periksa)->format('d/m/Y') }}</td>
                    <td>{{ $pelayanan->tb }}</td>
                    <td>{{ $pelayanan->bb }}</td>
                    <td>{{ $pelayanan->lingkar_lengan_atas }}</td>
                    <td>{{ $pelayanan->detak_jantung_janin }}</td>
                    <td>{{ $pelayanan->tinggi_rahim }}</td>
                    <td>{{ $pelayanan->konseling }}</td>
                    <td>{{ $pelayanan->test_hb }}</td>
                    <td>{{ $pelayanan->test_golongan_darah }}</td>
                    <td>{{ $pelayanan->test_protein_urin }}</td>
                    <td>{{ $pelayanan->test_gula_darah }}</td>
                    <td>{{ $pelayanan->ppia }}</td>
                    <td>{{ $pelayanan->tata_laksana_kasus }}</td>
                    <td>{{ $pelayanan->usg }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="18" class="text-center">Tidak ada data ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Menyambut Persalinan Section -->
    <div class="section-title">Menyambut Persalinan</div>
    <table>
        <tbody>
            <tr>
                <th width="30%">Anak Ke</th>
                <td>{{ $kehamilan->anak_ke }}</td>
            </tr>
            <tr>
                <th>Bulan Perkiraan Lahir</th>
                <td>{{ $kehamilan->bulan }} {{ $kehamilan->tahun }}</td>
            </tr>
            <tr>
                <th>Kendaraan Persalinan</th>
                <td>{{ ucfirst($kehamilan->kendaraan) }}</td>
            </tr>
            <tr>
                <th>Kontrasepsi</th>
                <td>{{ $kehamilan->kontrasepsi }}</td>
            </tr>
            <tr>
                <th>Sumbangan Darah</th>
                <td>{{ $kehamilan->sumbangan_darah }}</td>
            </tr>
            <tr>
                <th>Dana Persalinan</th>
                <td>
                    @if ($kehamilan->dana_persalinan == 'sendiri')
                        Biaya Sendiri
                    @elseif($kehamilan->dana_persalinan == 'jkn')
                        JKN
                    @elseif($kehamilan->dana_persalinan == 'jampersal')
                        Jampersal
                    @endif
                </td>
            </tr>
            <tr>
                <th>Bidan Penolong</th>
                <td>{{ $kehamilan->bidan }}</td>
            </tr>
        </tbody>
    </table>

    @if ($kehamilan->persalinan)
        <!-- Persalinan Section -->
        <div class="section-title">Persalinan</div>
        <table>
            <tbody>
                <tr>
                    <th width="30%">Tanggal Persalinan</th>
                    <td>{{ $kehamilan->persalinan->tanggal_persalinan }}</td>
                </tr>
                <tr>
                    <th>Waktu Persalinan</th>
                    <td>{{ $kehamilan->persalinan->waktu_persalinan }}</td>
                </tr>
                <tr>
                    <th>Umur Kehamilan (minggu)</th>
                    <td>{{ $kehamilan->persalinan->umur_kehamilan_minggu }}</td>
                </tr>
                <tr>
                    <th>Penolong Persalinan</th>
                    <td>{{ $kehamilan->persalinan->penolong_persalinan }}</td>
                </tr>
                <tr>
                    <th>Cara Persalinan</th>
                    <td>{{ $kehamilan->persalinan->cara_persalinan }}</td>
                </tr>
                <tr>
                    <th>Keadaan Ibu</th>
                    <td>{{ $kehamilan->persalinan->keadaan_ibu }}</td>
                </tr>
                <tr>
                    <th>Detail Keadaan Ibu</th>
                    <td>{{ $kehamilan->persalinan->detail_keadaan_ibu }}</td>
                </tr>
                <tr>
                    <th>KB Pasca Persalinan</th>
                    <td>{{ $kehamilan->persalinan->kb_pasca_persalinan }}</td>
                </tr>
                <tr>
                    <th>Keterangan Tambahan</th>
                    <td>{{ $kehamilan->persalinan->keterangan_tambahan }}</td>
                </tr>
            </tbody>
        </table>

        @if ($kehamilan->persalinan->bayi)
            <!-- Bayi Baru Lahir Section -->
            <div class="section-title">Bayi Baru Lahir</div>
            <table>
                <tbody>
                    <tr>
                        <th width="30%">Anak Ke</th>
                        <td>{{ $kehamilan->anak_ke }}</td>
                    </tr>
                    <tr>
                        <th>Berat Lahir (gram)</th>
                        <td>{{ $kehamilan->persalinan->bayi->berat_lahir_gram }}</td>
                    </tr>
                    <tr>
                        <th>Panjang Badan (cm)</th>
                        <td>{{ $kehamilan->persalinan->bayi->panjang_badan_cm }}</td>
                    </tr>
                    <tr>
                        <th>Lingkar Kepala (cm)</th>
                        <td>{{ $kehamilan->persalinan->bayi->lingkar_kepala_cm }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td>{{ $kehamilan->persalinan->bayi->jenis_kelamin }}</td>
                    </tr>
                    <tr>
                        <th>Kondisi Bayi Saat Lahir</th>
                        <td>
                            @if ($kehamilan->persalinan->bayi->segera_menangis)
                                Segera menangis<br>
                            @endif
                            @if ($kehamilan->persalinan->bayi->menangis_beberapa_saat)
                                Menangis beberapa saat<br>
                            @endif
                            @if ($kehamilan->persalinan->bayi->tidak_menangis)
                                Tidak menangis<br>
                            @endif
                            @if ($kehamilan->persalinan->bayi->seluruh_tubuh_kemerahan)
                                Seluruh tubuh kemerahan<br>
                            @endif
                            @if ($kehamilan->persalinan->bayi->anggota_gerak_kebiruan)
                                Anggota gerak kebiruan<br>
                            @endif
                            @if ($kehamilan->persalinan->bayi->seluruh_tubuh_biru)
                                Seluruh tubuh biru<br>
                            @endif
                            @if ($kehamilan->persalinan->bayi->kelainan_bawaan)
                                Kelainan bawaan: {{ $kehamilan->persalinan->bayi->kelainan_bawaan }}<br>
                            @endif
                            @if ($kehamilan->persalinan->bayi->meninggal)
                                Meninggal
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Asuhan Bayi Baru Lahir</th>
                        <td>
                            @if ($kehamilan->persalinan->bayi->imd)
                                Inisiasi Menyusu Dini (IMD)<br>
                            @endif
                            @if ($kehamilan->persalinan->bayi->vitamin_k1)
                                Suntikan Vitamin K1<br>
                            @endif
                            @if ($kehamilan->persalinan->bayi->salep_mata)
                                Salep mata antibiotika profilaksis<br>
                            @endif
                            @if ($kehamilan->persalinan->bayi->imunisasi_hb0)
                                Imunisasi HB0
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Keterangan Tambahan</th>
                        <td>{{ $kehamilan->persalinan->bayi->keterangan_tambahan }}</td>
                    </tr>
                </tbody>
            </table>
        @endif

        @if ($kehamilan->persalinan->kunjunganNifas)
            <!-- Kunjungan Nifas Section -->
            <div class="section-title">Kunjungan Nifas</div>

            <!-- KF1 - 6-48 Jam -->
            <h4>KF1 - 6-48 Jam</h4>
            <table>
                <tbody>
                    <tr>
                        <th width="30%">Tanggal Kunjungan</th>
                        <td>{{ $kehamilan->persalinan->kunjunganNifas->tanggal_kunjungan_kf_1 }}</td>
                    </tr>
                    <tr>
                        <th>Fasilitas Kesehatan</th>
                        <td>{{ $kehamilan->persalinan->kunjunganNifas->faskes_kf_1 }}</td>
                    </tr>
                    <tr>
                        <th>Masalah yang Ditemukan</th>
                        <td>{{ $kehamilan->persalinan->kunjunganNifas->masalah_kf_1 }}</td>
                    </tr>
                    <tr>
                        <th>Tindakan</th>
                        <td>{{ $kehamilan->persalinan->kunjunganNifas->tindakan_kf_1 }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- KF2 - 3-7 Hari -->
            <h4>KF2 - 3-7 Hari</h4>
            <table>
                <tbody>
                    <tr>
                        <th width="30%">Tanggal Kunjungan</th>
                        <td>{{ $kehamilan->persalinan->kunjunganNifas->tanggal_kunjungan_kf_2 }}</td>
                    </tr>
                    <tr>
                        <th>Fasilitas Kesehatan</th>
                        <td>{{ $kehamilan->persalinan->kunjunganNifas->faskes_kf_2 }}</td>
                    </tr>
                    <tr>
                        <th>Masalah yang Ditemukan</th>
                        <td>{{ $kehamilan->persalinan->kunjunganNifas->masalah_kf_2 }}</td>
                    </tr>
                    <tr>
                        <th>Tindakan</th>
                        <td>{{ $kehamilan->persalinan->kunjunganNifas->tindakan_kf_2 }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- KF3 - 8-28 Hari -->
            <h4>KF3 - 8-28 Hari</h4>
            <table>
                <tbody>
                    <tr>
                        <th width="30%">Tanggal Kunjungan</th>
                        <td>{{ $kehamilan->persalinan->kunjunganNifas->tanggal_kunjungan_kf_3 }}</td>
                    </tr>
                    <tr>
                        <th>Fasilitas Kesehatan</th>
                        <td>{{ $kehamilan->persalinan->kunjunganNifas->faskes_kf_3 }}</td>
                    </tr>
                    <tr>
                        <th>Masalah yang Ditemukan</th>
                        <td>{{ $kehamilan->persalinan->kunjunganNifas->masalah_kf_3 }}</td>
                    </tr>
                    <tr>
                        <th>Tindakan</th>
                        <td>{{ $kehamilan->persalinan->kunjunganNifas->tindakan_kf_3 }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- KF4 - 28 Hari Ke Atas -->
            <h4>KF4 - 28 Hari Ke Atas</h4>
            <table>
                <tbody>
                    <tr>
                        <th width="30%">Tanggal Kunjungan</th>
                        <td>{{ $kehamilan->persalinan->kunjunganNifas->tanggal_kunjungan_kf_4 }}</td>
                    </tr>
                    <tr>
                        <th>Fasilitas Kesehatan</th>
                        <td>{{ $kehamilan->persalinan->kunjunganNifas->faskes_kf_4 }}</td>
                    </tr>
                    <tr>
                        <th>Masalah yang Ditemukan</th>
                        <td>{{ $kehamilan->persalinan->kunjunganNifas->masalah_kf_4 }}</td>
                    </tr>
                    <tr>
                        <th>Tindakan</th>
                        <td>{{ $kehamilan->persalinan->kunjunganNifas->tindakan_kf_4 }}</td>
                    </tr>
                </tbody>
            </table>
        @endif

        @if ($kehamilan->persalinan->kesimpulanNifas)
            <!-- Kesimpulan Nifas Section -->
            <div class="section-title">Kesimpulan Nifas</div>
            <table>
                <tbody>
                    <tr>
                        <th width="30%">Keadaan Ibu</th>
                        <td>{{ $kehamilan->persalinan->kesimpulanNifas->keadaan_ibu }}</td>
                    </tr>
                    <tr>
                        <th>Komplikasi Nifas</th>
                        <td>
                            @if ($kehamilan->persalinan->kesimpulanNifas->perdarahan)
                                Perdarahan<br>
                            @endif
                            @if ($kehamilan->persalinan->kesimpulanNifas->infeksi)
                                Infeksi<br>
                            @endif
                            @if ($kehamilan->persalinan->kesimpulanNifas->hipertensi)
                                Hipertensi<br>
                            @endif
                            @if ($kehamilan->persalinan->kesimpulanNifas->komplikasi_lain)
                                {{ $kehamilan->persalinan->kesimpulanNifas->komplikasi_lain }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Keadaan Bayi</th>
                        <td>{{ $kehamilan->persalinan->kesimpulanNifas->keadaan_bayi }}</td>
                    </tr>
                    <tr>
                        <th>Kelainan Bawaan</th>
                        <td>{{ $kehamilan->persalinan->kesimpulanNifas->kelainan_bawaan }}</td>
                    </tr>
                    <tr>
                        <th>Catatan</th>
                        <td>{{ $kehamilan->persalinan->kesimpulanNifas->catatan }}</td>
                    </tr>
                    <tr>
                        <th>Kesimpulan</th>
                        <td>{{ $kehamilan->persalinan->kesimpulanNifas->kesimpulan }}</td>
                    </tr>
                </tbody>
            </table>
        @endif
    @endif

    <div class="section-title">Nifas</div>
    <table>
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th>NIK Ibu</th>
                <th>Nama Ibu</th>
                <th>Periksa ASI</th>
                <th>Periksa Perdarahan</th>
                <th>Periksa Jalan Lahir</th>
                <th>Vitamin A</th>
                <th>KB Pasca Kelahiran</th>
                <th>Konseling</th>
                <th>Tata Laksana Kasus</th>
                <th>Tanggal Pemeriksaan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($nifas as $index => $nifa)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $nifa->kehamilan->ibu->nik ?? '-' }}</td>
                    <td>{{ $nifa->kehamilan->ibu->nama ?? '-' }}</td>
                    <td class="text-center">
                        @if ($nifa->periksa_asi)
                            Y
                        @else
                            T
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($nifa->periksa_perdarahan)
                            Y
                        @else
                            T
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($nifa->periksa_jalan_lahir)
                            Y
                        @else
                            T
                        @endif
                    </td>
                    <td>{{ $nifa->vitamin_a ?? '-' }}</td>
                    <td>{{ ucfirst($nifa->kb_pasca_kelahiran) ?? '-' }}</td>
                    <td class="text-center">
                        @if ($nifa->konseling)
                            Y
                        @else
                            T
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($nifa->tata_laksana_kasus)
                            Y
                        @else
                            T
                        @endif
                    </td>
                    <td>{{ $nifa->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" class="text-center">Tidak ada data ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
