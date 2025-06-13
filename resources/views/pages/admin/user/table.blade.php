<table class="table table-striped" id="tabel-user">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($users as $index => $user)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $user->nama }}</td>
                <td>{{ $user->email }}</td>
                <td class="align-middle">
                    <div class="btn-group">
                        <button data-toggle="modal" data-target="#modal-tambah" type="button"
                            class="btn btn-warning edit-button" data-id="{{ $user->id }}" data-toggle="tooltip"
                            title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button
                            onclick="confirmDelete('{{ route('admin.rujukan.destroy', $user->id) }}','.table-responsive', '{{ route('admin.user.table') }}', '#tabel-user')"
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
