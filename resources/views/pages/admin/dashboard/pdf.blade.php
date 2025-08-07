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
            font-size: 10px;
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
        <h2>Laporan Periode {{ $tanggal_mulai }} sampai {{ $tanggal_akhir }}</h2>
    </div>

    <div class="section-title">Ibu</div>
    <table>
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Pembiayaan</th>
                <th>No JKN</th>
                <th>Golongan Darah</th>
                <th>Tempat, Tanggal Lahir</th>
                <th>Pendidikan</th>
                <th>Pekerjaan</th>
                <th>Alamat</th>
                <th>Telepon</th>
                <th>Suami</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($ibus as $index => $ibu)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $ibu->nik }}</td>
                    <td>{{ $ibu->nama }}</td>
                    <td>{{ $ibu->pembiayaan }}</td>
                    <td>{{ $ibu->no_jkn }}</td>
                    <td>{{ strtoupper($ibu->golongan_darah) }}</td>
                    <td>{{ $ibu->tempat_lahir }},
                        {{ date('d-m-Y', strtotime($ibu->tanggal_lahir)) }}</td>
                    <td>
                        @php
                            $pendidikan = [
                                'sd' => 'SD',
                                'smp' => 'SMP',
                                'sma' => 'SMA/SMK',
                                'd3' => 'D3',
                                's1' => 'S1',
                                's2' => 'S2',
                                's3' => 'S3',
                            ];
                        @endphp
                        {{ $pendidikan[$ibu->pendidikan] ?? $ibu->pendidikan }}
                    </td>
                    <td>{{ $ibu->pekerjaan }}</td>
                    <td class="text-wrap">{{ $ibu->alamat }}</td>
                    <td>{{ $ibu->telepon }}</td>
                    <td>{{ $ibu->suami }}</td>
                    <td>{{ $ibu->status_kehidupan == '1' ? 'Hidup' : 'Meninggal' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="14" class="text-center">Tidak ada data ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">Kehamilan</div>
    <table>
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th>NIK</th>
                <th>Nama Ibu</th>
                <th>Kehamilan Anak ke</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kehamilans as $index => $kehamilan)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $kehamilan->ibu->nik }}</td>
                    <td>{{ $kehamilan->ibu->nama }}</td>
                    <td>{{ $kehamilan->anak_ke }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

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
                <th>Tablet Tambah Darah</th>
                <th>Imunisasi dan Tetanus</th>
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
                    <td>{{ $pelayanan->tablet_tambah_darah }}</td>
                    <td>{{ $pelayanan->imunisasi_tetanus }}</td>
                    <td>{{ $pelayanan->ppia }}</td>
                    <td>{{ $pelayanan->tata_laksana_kasus }}</td>
                    <td>{{ $pelayanan->usg }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="21" class="text-center">Tidak ada data ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">NIFAS</div>

    <table class="table table-striped table-bordered" id="tabel-nifas">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Ibu</th>
                <th>Periksa ASI</th>
                <th>Periksa Perdarahan</th>
                <th>Periksa Jalan Lahir</th>
                <th>Vitamin A</th>
                <th>KB Pasca Kelahiran</th>
                <th>Konseling</th>
                <th>Tata Laksana</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($nifas as $key => $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if ($item->kehamilan && $item->kehamilan->ibu && $item->kehamilan->ibu->nik)
                            {{ $item->kehamilan->ibu->nik }}, {{ $item->kehamilan->ibu->nama }}, Kehamilan ke
                            {{ $item->kehamilan->anak_ke }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if ($item->periksa_asi)
                            <span class="badge badge-success"><i class="fas fa-check"></i> Ya</span>
                        @else
                            <span class="badge badge-danger"><i class="fas fa-times"></i> Tidak</span>
                        @endif
                    </td>
                    <td>
                        @if ($item->periksa_perdarahan)
                            <span class="badge badge-success"><i class="fas fa-check"></i> Ya</span>
                        @else
                            <span class="badge badge-danger"><i class="fas fa-times"></i> Tidak</span>
                        @endif
                    </td>
                    <td>
                        @if ($item->periksa_jalan_lahir)
                            <span class="badge badge-success"><i class="fas fa-check"></i> Ya</span>
                        @else
                            <span class="badge badge-danger"><i class="fas fa-times"></i> Tidak</span>
                        @endif
                    </td>
                    <td>{{ $item->vitamin_a ?? '-' }}</td>
                    <td>
                        @if ($item->kb_pasca_kelahiran)
                            @if ($item->kb_pasca_kelahiran == 'suntik')
                                <span class="badge badge-info">Suntik</span>
                            @else
                                <span class="badge badge-primary">Pil</span>
                            @endif
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if ($item->konseling)
                            <span class="badge badge-success"><i class="fas fa-check"></i> Ya</span>
                        @else
                            <span class="badge badge-danger"><i class="fas fa-times"></i> Tidak</span>
                        @endif
                    </td>
                    <td>
                        @if ($item->tata_laksana_kasus)
                            <span class="badge badge-success"><i class="fas fa-check"></i> Ya</span>
                        @else
                            <span class="badge badge-danger"><i class="fas fa-times"></i> Tidak</span>
                        @endif
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">Rujukan</div>

    <table id="tabel-rujukan">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th>Ibu</th>
                <th>Alasan</th>
                <th>Tanggal Rujukan</th>
                <th>Diagnosa Akhir</th>
                <th>Anjuran</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rujukans as $index => $rujukan)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $rujukan->ibu->nama }}</td>
                    <td>{{ $rujukan->alasan }}</td>
                    <td>{{ $rujukan->tanggal_rujukan }}</td>
                    <td>{{ $rujukan->diagnosa_akhir }}</td>
                    <td>{{ $rujukan->anjuran }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">User</div>

    <table id="tabel-user">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $index => $user)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
