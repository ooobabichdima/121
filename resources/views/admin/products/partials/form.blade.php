<div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(240px,1fr)); gap:10px;">
    <label>Название<input class="btn small" name="name" value="{{ old('name', $product->name ?? '') }}" required></label>
    <label>Slug<input class="btn small" name="slug" value="{{ old('slug', $product->slug ?? '') }}" required></label>
    <label>SKU<input class="btn small" name="sku" value="{{ old('sku', $product->sku ?? '') }}" required></label>
    <label>Цена<input class="btn small" type="number" name="price" value="{{ old('price', $product->price ?? 0) }}" required></label>
    <label>Старая цена<input class="btn small" type="number" name="old_price" value="{{ old('old_price', $product->old_price ?? '') }}"></label>
    <label>Сток<input class="btn small" type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" required></label>
    <label>Категория
        <select name="category_id" class="btn small" required>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" @selected(old('category_id', $product->category_id ?? '')==$cat->id)>{{ $cat->name }}</option>
            @endforeach
        </select>
    </label>
    <label>Бренд
        <select name="brand_id" class="btn small">
            <option value="">—</option>
            @foreach($brands as $brand)
                <option value="{{ $brand->id }}" @selected(old('brand_id', $product->brand_id ?? '')==$brand->id)>{{ $brand->name }}</option>
            @endforeach
        </select>
    </label>
</div>
<label>Описание<textarea class="btn small" name="description" rows="3">{{ old('description', $product->description ?? '') }}</textarea></label>
