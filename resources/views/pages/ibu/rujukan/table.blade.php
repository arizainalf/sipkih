<table class="table table-striped" id="tabel-rujukan">
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
