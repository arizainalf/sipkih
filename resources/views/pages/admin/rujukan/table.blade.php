<table class="table table-striped" id="tabel-rujukan">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th>Ibu</th>
            <th>Alasan</th>
            <th>Tanggal Rujukan</th>
            <th>Diagnosa Akhir</th>
            <th>Anjuran</th>
            <th>Aksi</th>
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
                <td class="align-middle">
                    <div class="btn-group">
                        <button data-toggle="modal" data-target="#modal-tambah" type="button"
                            class="btn btn-warning edit-button" data-id="{{ $rujukan->id }}" data-toggle="tooltip"
                            title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button
                            onclick="confirmDelete('{{ route('admin.rujukan.destroy', $rujukan->id) }}','.table-responsive', '{{ route('admin.rujukan.table') }}', '#tabel-rujukan')"
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
