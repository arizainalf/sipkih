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
            <th>Aksi</th>
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
                <td>
                    <div class="btn-group">
                        <a href="{{ route('admin.nifas.detail', $item->id) }}" class="btn btn-sm btn-info"
                            title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <button data-id="{{ $item->id }}" data-toggle="modal" data-target="#modal-tambah"
                            class="btn btn-sm btn-warning edit-button" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" title="Hapus"
                            onclick="confirmDelete('{{ route('admin.nifas.destroy', $item->id) }}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td></td>
                <td class="text-center">Tidak ada data ditemukan</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endforelse
    </tbody>
</table>
