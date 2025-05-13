<x-layouts.app :title="__('Products')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Update Product</flux:heading>
        <flux:subheading size="lg" class="mb-6">Manage data Products</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    @if(session()->has('successMessage'))
        <flux:badge color="lime" class="mb-3 w-full">
            {{ session()->get('successMessage') }}
        </flux:badge>
    @elseif(session()->has('errorMessage'))
        <flux:badge color="red" class="mb-3 w-full">
            {{ session()->get('errorMessage') }}
        </flux:badge>
    @endif

    <form action="{{ route('product.update', $product->id) }}" method="post">
        @method('patch')
        @csrf

        <flux:input label="Name" name="name" value="{{ $product->name }}" class="mb-3" />
        <flux:input label="Slug" name="slug" value="{{ $product->slug }}" class="mb-3" disabled />
        <flux:textarea label="Description" name="description" class="mb-3">{{ $product->description }}</flux:textarea>
        <flux:input label="SKU" name="sku" value="{{ $product->sku }}" class="mb-3" />
        <flux:input type="number" label="Price" name="price" value="{{ $product->price }}" class="mb-3" />
        <flux:input type="number" label="Stock" name="stock" value="{{ $product->stock }}" class="mb-3" />

        <flux:select label="Category" name="product_category_id" class="mb-3">
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $category->id == $product->product_category_id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </flux:select>

        <flux:input label="Image URL" name="image_url" value="{{ $product->image_url }}" class="mb-3" />
        <flux:select label="Status" name="is_active" class="mb-3">
            <option value="1" {{ $product->is_active ? 'selected' : '' }}>Active</option>
            <option value="0" {{ !$product->is_active ? 'selected' : '' }}>Inactive</option>
        </flux:select>

        <flux:separator />

        <div class="mt-4">
            <flux:button type="submit" variant="primary">Update</flux:button>
            <flux:link href="{{ route('product.index') }}" variant="ghost" class="ml-3">Kembali</flux:link>
        </div>
    </form>
</x-layouts.app>
