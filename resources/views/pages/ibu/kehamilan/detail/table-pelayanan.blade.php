<table class="table table-striped" id="tabel-pelayanan">
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
            <th>Aksi</th>
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
                <td class="align-middle">
                    <div class="btn-group">
                        <a href="{{ route('admin.pelayanan.detail', $pelayanan->id) }}" class="btn btn-info"
                            data-toggle="tooltip" title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <button data-toggle="modal" data-target="#modal-tambah-pelayanan" type="button"
                            class="btn btn-warning edit-button-pelayanan" data-id="{{ $pelayanan->id }}" data-toggle="tooltip"
                            title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button
                            onclick="confirmDelete('{{ route('admin.pelayanan.destroy', $pelayanan->id) }}','.table-responsive-pelayanan', '{{ route('admin.pelayanan.index') }}', '#tabel-pelayanan')"
                            class="btn btn-danger delete-button-pelayanan" data-toggle="tooltip" title="Hapus">
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
