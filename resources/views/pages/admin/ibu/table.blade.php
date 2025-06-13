<table class="table table-striped" id="tabel-ibu">
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
            <th>Aksi</th>
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
                <td class="align-middle">
                    <div class="btn-group">
                        <a href="{{ route('admin.periksa.index', $ibu->id) }}" class="btn btn-success" data-toggle="tooltip"
                            title="Detail">
                            <i class="fas fa-calendar"></i>
                        </a>
                        <a href="{{ route('admin.ibu.detail', $ibu->id) }}" class="btn btn-info" data-toggle="tooltip"
                            title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <button data-toggle="modal" data-target="#modal-tambah" type="button"
                            class="btn btn-warning edit-button" data-id="{{ $ibu->id }}" data-toggle="tooltip"
                            title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button
                            onclick="confirmDelete('{{ route('admin.ibu.destroy', $ibu->id) }}','.table-responsive', '{{ route('admin.ibu.index') }}', '#tabel-ibu')"
                            class="btn btn-danger delete-button" data-toggle="tooltip" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="13" class="text-center">Tidak ada data ditemukan</td>
            </tr>
        @endforelse
    </tbody>
</table>
