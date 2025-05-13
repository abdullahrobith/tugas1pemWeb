<x-layouts.app :title="__('categories')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Product</flux:heading>
        <flux:subheading size="lg" class="mb-6">Manajemen Produk</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <div class="flex justify-between items-center mb-4">
        <form action="{{ route('categories.index') }}" method="get">
            @csrf
            <flux:input
                icon="magnifying-glass"
                name="q"
                value="{{ $q }}"
                placeholder="Search Product Categories"
            />
        </form>
        <flux:button icon="plus">
            <flux:link href="{{ route('categories.create') }}" variant="subtle">Add New Category</flux:link>
        </flux:button>
    </div>

    @if(session()->has('successMessage'))
        <flux:badge color="lime" class="mb-3 w-full">
            {{ session()->get('successMessage') }}
        </flux:badge>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-gray-900 dark:text-white leading-normal">
            <thead class="bg-gray-100 dark:bg-zinc-700 text-left text-xs font-semibold uppercase tracking-wider">
                <tr>
                    <th class="px-5 py-3 border-b">ID</th>
                    <th class="px-5 py-3 border-b">Image</th>
                    <th class="px-5 py-3 border-b">Name</th>
                    <th class="px-5 py-3 border-b">Slug</th>
                    <th class="px-5 py-3 border-b">Description</th>
                    <th class="px-5 py-3 border-b">Created At</th>
                    <th class="px-5 py-3 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $key => $category)
                    <tr class="bg-white dark:bg-zinc-800 border-b dark:border-zinc-700">
                        <td class="px-5 py-5">{{ $key + 1 }}</td>
                        <td class="px-5 py-5">
                            @if($category->image)
                                <img src="{{ $category->image }}" 
                                    alt="{{ $category->name }}"
                                    class="h-12 w-12 rounded object-cover border border-gray-300 dark:border-zinc-600" />
                            @else
                                <div class="h-12 w-12 flex items-center justify-center bg-gray-200 dark:bg-zinc-700 text-gray-500 dark:text-gray-300 rounded">
                                    N/A
                                </div>
                            @endif
                        </td>
                        <td class="px-5 py-5">{{ $category->name }}</td>
                        <td class="px-5 py-5">{{ $category->slug }}</td>
                        <td class="px-5 py-5">{{ $category->description }}</td>
                        <td class="px-5 py-5">{{ $category->created_at }}</td>
                        <td class="px-5 py-5">
                            <flux:dropdown>
                                <flux:button icon:trailing="chevron-down">Actions</flux:button>
                                <flux:menu>
                                    <flux:menu.item icon="pencil" href="{{ route('categories.edit', $category->id) }}">Edit</flux:menu.item>
                                    <flux:menu.item
                                        icon="trash"
                                        variant="danger"
                                        onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this category?')) document.getElementById('delete-form-{{ $category->id }}').submit();"
                                    >
                                        Delete
                                    </flux:menu.item>
                                    <form id="delete-form-{{ $category->id }}" action="{{ route('categories.destroy', $category->id) }}" method="POST" class="hidden">
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
            {{ $categories->links() }}
        </div>
    </div>
</x-layouts.app>
