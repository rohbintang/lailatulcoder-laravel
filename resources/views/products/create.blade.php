<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create</title>
</head>
<body>
   <form action="{{ route('products.store') }}" method="POST">
    @csrf

    <input type="text" name="name" placeholder="name">
    <input type="text" name="description" placeholder="description">
    <input type="number" name="price" placeholder="price">
    <input type="number" name="stock" placeholder="stock">

    <select name="category_id">
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
        @endforeach
    </select>

    <button type="submit">Simpan</button>
</form>
</body>
</html>