<table class="table table-striped" id="tabel-kehamilan">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th>NIK</th>
            <th>Nama Ibu</th>
            <th>Kehamilan Anak ke</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($kehamilans as $index => $kehamilan)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $kehamilan->ibu->nik }}</td>
                <td>{{ $kehamilan->ibu->nama }}</td>
                <td>{{ $kehamilan->anak_ke }}</td>
                <td class="align-middle">
                    <div class="btn-group">
                        <a href="{{ route('admin.kehamilan.detail', $kehamilan->id) }}" class="btn btn-info" data-toggle="tooltip" title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <button data-toggle="modal" data-target="#modal-tambah" type="button"
                            class="btn btn-warning edit-button" data-id="{{ $kehamilan->id }}" data-toggle="tooltip"
                            title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button
                            onclick="confirmDelete('{{ route('admin.kehamilan.destroy', $kehamilan->id) }}','.table-responsive', '{{ route('admin.kehamilan.index') }}', '#tabel-kehamilan')"
                            class="btn btn-danger delete-button" data-toggle="tooltip" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center">Tidak ada data ditemukan</td>
            </tr>
        @endforelse
    </tbody>
</table>
