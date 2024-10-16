@extends('layouts.template')

@section('content')
<form action="{{ route('account.update', $account['id']) }}" method="POST" class="card p-5">
    @csrf
    @method('PATCH')

    @if ($errors->any())
        <ul class="alert alert-danger p-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <div class="mb-3 row">
        <label for="name" class="col-sm-2 col-form-label">Nama :</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="name" name="name" value="{{ $account['name'] }}">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="email" class="col-sm-2 col-form-label">Email :</label>
        <div class="col-sm-10">
            <input type="email" class="form-control" id="email" name="email" value="{{ $account['email'] }}">
        </div>
    </div>
    
    <div class="mb-3 row">
        <label for="role" class="col-sm-2 col-form-label">Tipe Pengguna :</label>
        <div class="col-sm-10">
            <select class="form-select" id="role" name="role">
                <option selected disabled hidden>Pilih</option>
                <option value="admin" {{ $account['role'] == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="member" {{ $account['role'] == 'member' ? 'selected' : '' }}>Member</option>
            </select>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="password" class="col-sm-2 col-form-label">Ubah Password :</label>
        <div class="col-sm-10 d-flex">
            <input type="password" class="form-control" id="password" name="password" value="{{ $account['password'] }}">
            <button type="button" class="btn btn-secondary ms-2" onclick="showPassword()">Lihat</button>
        </div>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Ubah Data</button>
</form>

<script>
    function showPassword() {
        var passwordField = document.getElementById("password");
        var originalType = passwordField.type;
        
        passwordField.type = "text"; 

       
        setTimeout(function() {
            passwordField.type = originalType;
        }, 3000);
    }
</script>
@endsection
