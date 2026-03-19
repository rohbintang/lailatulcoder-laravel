<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Daftar Product</h1>

    <a href="{{ route('products.create') }}">Tambah Produk</a>

@foreach($products as $p)
    <div>
        <h3>{{ $p->name }}</h3>
        <p>{{ $p->description }}</p>
        <p>Rp {{ $p->price }}</p>

        <a href="{{ route('products.edit', $p->id) }}">Edit</a>

        <form action="{{ route('products.destroy', $p->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Hapus</button>
        </form>
    </div>
@endforeach
</body>
</html>