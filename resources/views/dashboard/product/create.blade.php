<x-layouts.app :title="__('Produk')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Tambah Produk Baru</flux:heading>
        <flux:subheading size="lg" class="mb-6">Kelola data produk</flux:subheading>
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

    <form action="{{ route('product.store') }}" method="post">
        @csrf

        <flux:input label="Nama Produk" name="name" class="mb-3" />
        <flux:input label="Slug" name="slug" class="mb-3" />
        <flux:textarea label="Deskripsi" name="description" class="mb-3" />
        <flux:input label="SKU" name="sku" class="mb-3" />
        <flux:input label="Harga" name="price" type="number" step="0.01" class="mb-3" />
        <flux:input label="Stok" name="stock" type="number" class="mb-3" />

        <flux:select label="Kategori Produk" name="product_category_id" class="mb-3">
            <option value="">-- Pilih Kategori --</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </flux:select>

        <flux:input label="URL Gambar" name="image_url" type="url" class="mb-3" />

        <flux:select label="Status Aktif" name="is_active" class="mb-3">
            <option value="1">Aktif</option>
            <option value="0">Tidak Aktif</option>
        </flux:select>

        <flux:separator />

        <div class="mt-4">
            <flux:button type="submit" variant="primary">Simpan</flux:button>
            <flux:link href="{{ route('product.index') }}" variant="ghost" class="ml-3">Kembali</flux:link>
        </div>
    </form>
</x-layouts.app>
