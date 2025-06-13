<table class="table table-striped" id="tabel-nifas">
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
            <th>Aksi</th>
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
                        <span class="badge badge-success"><i class="fas fa-check"></i></span>
                    @else
                        <span class="badge badge-danger"><i class="fas fa-times"></i></span>
                    @endif
                </td>
                <td class="text-center">
                    @if ($nifa->periksa_perdarahan)
                        <span class="badge badge-success"><i class="fas fa-check"></i></span>
                    @else
                        <span class="badge badge-danger"><i class="fas fa-times"></i></span>
                    @endif
                </td>
                <td class="text-center">
                    @if ($nifa->periksa_jalan_lahir)
                        <span class="badge badge-success"><i class="fas fa-check"></i></span>
                    @else
                        <span class="badge badge-danger"><i class="fas fa-times"></i></span>
                    @endif
                </td>
                <td>{{ $nifa->vitamin_a ?? '-' }}</td>
                <td>{{ ucfirst($nifa->kb_pasca_kelahiran) ?? '-' }}</td>
                <td class="text-center">
                    @if ($nifa->konseling)
                        <span class="badge badge-success"><i class="fas fa-check"></i></span>
                    @else
                        <span class="badge badge-danger"><i class="fas fa-times"></i></span>
                    @endif
                </td>
                <td class="text-center">
                    @if ($nifa->tata_laksana_kasus)
                        <span class="badge badge-success"><i class="fas fa-check"></i></span>
                    @else
                        <span class="badge badge-danger"><i class="fas fa-times"></i></span>
                    @endif
                </td>
                <td>{{ $nifa->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <div class="btn-group">
                        <a href="{{ route('admin.nifas.detail', $nifa->id) }}" class="btn btn-sm btn-info"
                            title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <button data-id="{{ $nifa->id }}" data-toggle="modal" data-target="#modal-tambah-nifas"
                            class="btn btn-sm btn-warning edit-button-nifas" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" title="Hapus"
                            onclick="confirmDelete('{{ route('admin.nifas.destroy', $nifa->id) }}','.table-responsive-nifas', '{{ route('admin.nifas.index') }}', '#tabel-nifas')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td>-</td>
                <td class="text-center">Tidak ada data ditemukan</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
            </tr>
        @endforelse
    </tbody>
</table>
