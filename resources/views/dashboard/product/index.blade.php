@php use Illuminate\Support\Str; @endphp

<x-layouts.app :title="__('Product')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Product</flux:heading>
        <flux:subheading size="lg" class="mb-6">Manajemen Produk</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <div class="flex justify-between items-center mb-4">
        <form action="{{ route('product.index') }}" method="get">
            <flux:input
                icon="magnifying-glass"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search Product"
            />
        </form>
        <flux:button icon="plus">
            <flux:link href="{{ route('product.create') }}" variant="subtle">Add New Product</flux:link>
        </flux:button>
    </div>

    @if(session('successMessage'))
        <flux:badge color="lime" class="mb-3 w-full">
            {{ session('successMessage') }}
        </flux:badge>
    @endif

    @if(session('errorMessage'))
        <flux:badge color="red" class="mb-3 w-full">
            {{ session('errorMessage') }}
        </flux:badge>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-gray-900 dark:text-white leading-normal">
            <thead class="bg-gray-100 dark:bg-zinc-700 text-left text-xs font-semibold uppercase tracking-wider">
                <tr>
                    <th class="px-5 py-3 border-b">#</th>
                    <th class="px-5 py-3 border-b">Image</th>
                    <th class="px-5 py-3 border-b">Name</th>
                    <th class="px-5 py-3 border-b">Category</th>
                    <th class="px-5 py-3 border-b">SKU</th>
                    <th class="px-5 py-3 border-b">Price</th>
                    <th class="px-5 py-3 border-b">Stock</th>
                    <th class="px-5 py-3 border-b">Description</th>
                    <th class="px-5 py-3 border-b">Active</th>
                    <th class="px-5 py-3 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($product as $index => $item)
                    <tr class="bg-white dark:bg-zinc-800 border-b dark:border-zinc-700">
                        <td class="px-5 py-4">{{ $product->firstItem() + $index }}</td>
                        <td class="px-5 py-4">
                            @if($item->image_url)
                                <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="h-12 w-12 rounded object-cover border border-gray-300 dark:border-zinc-600" />
                            @else
                                <div class="h-12 w-12 flex items-center justify-center bg-gray-200 dark:bg-zinc-700 text-gray-500 dark:text-gray-300 rounded">
                                    N/A
                                </div>
                            @endif
                        </td>
                        <td class="px-5 py-4">{{ $item->name }}</td>
                        <td class="px-5 py-4">{{ $item->category->name ?? '-' }}</td>
                        <td class="px-5 py-4">{{ $item->sku }}</td>
                        <td class="px-5 py-4">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="px-5 py-4">{{ $item->stock }}</td>
                        <td class="px-5 py-4">
                            {{ Str::limit($item->description, 50) }}
                        </td>
                        <td class="px-5 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $item->is_active ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                {{ $item->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <flux:dropdown>
                                <flux:button icon:trailing="chevron-down">Actions</flux:button>
                                <flux:menu>
                                    <flux:menu.item icon="pencil" href="{{ route('product.edit', $item->id) }}">Edit</flux:menu.item>
                                    <flux:menu.item
                                        icon="trash"
                                        variant="danger"
                                        onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this product?')) document.getElementById('delete-form-{{ $item->id }}').submit();"
                                    >
                                        Delete
                                    </flux:menu.item>
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('product.destroy', $item->id) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </flux:menu>
                            </flux:dropdown>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            {{ $product->links() }}
        </div>
    </div>
</x-layouts.app>
