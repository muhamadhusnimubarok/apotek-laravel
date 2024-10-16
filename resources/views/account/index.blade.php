@extends('layouts.template')

@section('content')
    <div class="container mt-5">
        <div class="position-absolute top-0 end-0 m-3">
            <a href="{{ route('account.create') }}" class="btn btn-secondary">Tambah Akun</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @forelse ($users as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['email'] }}</td>
                        <td>{{ $item['role'] }}</td> 
                        <td class="d-flex justify-content-center">
                            <a href="{{ route('account.edit', $item['id']) }}" class="btn btn-primary me-3">Edit</a>
                            <form action="{{ route('account.destroy', $item['id']) }}" method="POST" onsubmit="return confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data akun</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script>
        function confirmDelete(event) {
          
            event.preventDefault();
           
            const confirmed = confirm("Apakah Anda yakin ingin menghapus akun ini?");
            if (confirmed) {
              
                event.target.submit();
            }
        }
    </script>
@endsection
