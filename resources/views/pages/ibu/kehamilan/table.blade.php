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
                        <a href="{{ route('ibu.kehamilan.detail', $kehamilan->id) }}" class="btn btn-info" data-toggle="tooltip" title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
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
