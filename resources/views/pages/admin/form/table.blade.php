<table class="table table-striped" id="tabel-form">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th>Nama</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($forms as $index => $form)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $form->nama }}</td>
                <td class="align-middle">
                    <div class="btn-group">

                        <button data-toggle="modal" data-target="#modal-tambah" type="button"
                            class="btn btn-warning edit-button" data-id="{{ $form->id }}" data-toggle="tooltip"
                            title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button
                            onclick="confirmDelete('{{ route('admin.form.destroy', $form->id) }}','.table-responsive', '{{ route('admin.form.index') }}', '#tabel-form')"
                            class="btn btn-danger delete-button" data-toggle="tooltip" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td class="text-center">-</td>
                <td class="text-center">Tidak ada data ditemukan</td>
                <td class="text-center">-</td>
            </tr>
        @endforelse
    </tbody>
</table>
