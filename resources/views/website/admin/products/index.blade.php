@extends('admin.layouts.main')

@section('content')
<h2>Data Produk</h2>

<a href="{{ route('admin.products.create') }}">Tambah</a>
@csrf
<table border="1" cellpadding="8">
    <tr>
        <th>#</th>
        <th>Nama</th>
        <th>Harga</th>
        <th>Slug</th>
        <th>Aksi</th>
    </tr>

    @foreach ($products as $p)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $p->name }}</td>
        <td>{{ $p->price }}</td>
        <td>{{ $p->slug }}</td>
        <td>
            <a href="{{ route('admin.products.edit', $p->id) }}">Edit</a>

            <form action="{{ route('admin.products.destroy', $p->id) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
