<table id="dataTable" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Mahasiswa</th>
            <th>NIM</th>
            <th>Prodi</th>
            <th>Gender</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody class="text-center">
        @foreach ($mahasiswa as $index => $mhs)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $mhs->nama }}</td>
                <td>{{ $mhs->nim }}</td>
                <td>{{ optional($mhs->prodi)->prodi ?? 'N/A' }}</td>
                <td>{{ $mhs->gender == '1' ? 'Laki-laki' : 'Perempuan' }}</td>
                <td>{{ $mhs->status_mahasiswa == '1' ? 'Aktif' : 'Tidak Aktif' }}</td>
                <td>
                    <a href="{{ route('mahasiswa.edit', $mhs->id_mahasiswa) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('mahasiswa.destroy', $mhs->id_mahasiswa) }}" method="POST" class="delete-form" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-delete">Hapus</button>
                    </form>
                    <a href="{{ route('mahasiswa.show', $mhs->id_mahasiswa) }}" class="btn btn-info">Detail</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
