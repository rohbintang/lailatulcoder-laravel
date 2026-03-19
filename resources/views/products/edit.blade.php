<form action="{{ route('products.update', $product->id) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="name" value="{{ $product->name }}"><br>

    <textarea name="description">{{ $product->description }}</textarea><br>

    <input type="number" name="price" value="{{ $product->price }}"><br>
    <input type="number" name="stock" value="{{ $product->stock }}"><br>

    <select name="category_id">
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}"
                {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
        @endforeach
    </select><br>

    <button type="submit">Update</button>
</form>