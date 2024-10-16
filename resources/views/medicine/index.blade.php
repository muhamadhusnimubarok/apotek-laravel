@extends('layouts.layout')

@section('content')
    <div class="container">
        {{-- Session::get mengambil pesan pada return redirect bagian with pada controller --}}
        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if (Session::get('failed'))
            <div class="alert alert-danger">{{ Session::get('failed') }}</div>
        @endif
<form action="" method="GET" class="d-flex justift-content-end mb-2">
    {{-- FORM PENCARIAN
    1. INPUT NAME
    2, BUTTON  SUBMIT
    3.METHOT= "GET"
    4. ACTION KOSONG AGAR MENGARAH KE ROUTE YANG SAMA --}}
    
    <input type="text" name="search_medicine" placeholder="Cari Nama Obat..." class="form-control">
    <button type="submit" class="btn btn-primary ms-2">Cari </button>
</form>
        <table class="table table-bordered table-stripped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Obat</th>
                    <th>Tipe</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if (count($medicines) < 1)
                    <tr>
                        <td colspan="6" class="text-center">Data Obat Kosong</td>
                    </tr>
                @else
                    @foreach ($medicines as $index => $item)
                        <tr>
                            <td>{{ ($medicines->currentPage()-1) * ($medicines->perPage()) + ($index+1) }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['type'] }}</td>
                            <td>Rp. {{  number_format($item['price'], 0, ',', '.') }}</td>
                            <td style="cursor: pointer" class="{{ $item['stock'] <=  3 ? 'bg-danger text-white' : '' }}" onclick="showModalStock('{{$item->id}}', '{{$item->name}}', '{{ $item->stock }}')"> {{ $item['stock'] }}</td>
                            <td class="d-flex">
                                {{-- , $item['id'] pada route akan mengisi path dinamis {id} --}}
                                <a href="{{ route('medicines.edit', $item['id']) }}" class="btn btn-primary me-2">Edit</a>
                                <button class="btn btn-danger" onclick="showModalDelete('{{$item->id}}', '{{$item->name}}')">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="d-flex justify-content-end my-3">
        {{$medicines->links()}}
    </div>
        <!-- Modal -->
<div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        {{-- MENGGANTI METHOD=POST MENJADI DELETE AGAR SESUAI DENGAN ROUTE WEEB.PHP ::DELETE() --}}
      <form class="modal-content" method="POST" action="">
        @csrf
        @method('DELETE')
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Obat</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Apakah Anda Yakin Menghapus Data Obat <b id="name-medicine"></b>  ?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger">Hapus</button>
        </div>
      </form>
    </div>
  </div>
 {{-- modal edit --}}
        <div class="modal fade" id="modalEditStock" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content" method="POST" action="">
                    @csrf
                    {{-- mengganti method="POST" menjadi dalete agar sesuai dengan route web.php ::delete() --}}
                    @method('PATCH')
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Stok Obat</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5 id="title_form_edit"></h5>
                        <div class="form-group">
                            <label class="form-label" for="stock">Stok Sebelumnya : </label>
                            <input type="number" name="stock" id="stock" class="form-control">
                            {{-- menampung error yang terjadi pada proses form modal --}}
                            @if (Session::get('failed'))
                                <small class="text-danger">{{ Session::get('failed') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        {{-- ketika btn hapus di klik, memenggil js showModalDelete dengan mengirim data id untuk spesifik hapusnya, dan name untuk memunculkan nama obat di modalnya --}}
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    function showModalDelete(id,name) {
        $("#name-medicine").text(name);
        $("#modalDelete").modal('show');
        let url="{{route('medicines.delete', ':id')}}";

        url = url.replace(':id', id);

        $("form").attr('action',url);
    }
    function showModalStock(id, name, stock) {
        $("#title_form_edit").text(name);
        $("#stock").val(stock);
        $("#modalEditStock").modal('show');
        let url="{{route('medicines.update.stock', ':id')}}";

        url = url.replace(':id', id);

        $("form").attr('action',url);
    }
    @if (Session::get('failed'))
        let id= "{{ Session::get('id')}}";
        let name= "{{ Session::get('name')}}";
        let stock = "{{ Session::get('stock')}}";
        showModalDelete(id,name, stock);
        @endif
</script>
    
@endpush