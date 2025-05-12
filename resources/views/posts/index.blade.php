@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-4 mt-6">
        <h1 class="text-2xl font-bold">Blog App</h1>
        <a href="{{ route('posts.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">+ Tambah Postingan</a>
    </div>

    <form method="GET" action="{{ route('posts.index') }}" class="mb-4 flex gap-2 items-center">
        <input type="text" name="search" placeholder="Cari judul..." value="{{ request('search') }}"
            class="border px-3 py-2 rounded" />

        <select name="sort" class="border px-6 py-2 rounded text-sm">
            <option value="latest" {{ request('sort') !== 'oldest' ? 'selected' : '' }}>Terbaru</option>
            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Terlama</option>
        </select>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Cari</button>

        @if(request()->filled('search') || request()->filled('sort'))
            <a href="{{ route('posts.index') }}" class="text-sm text-orange-500 hover:underline ml-2">Reset</a>
        @endif
    </form>




    @foreach ($posts as $post)
        <div class="bg-white p-4 rounded shadow mb-4">
            <h2 class="text-xl font-semibold">{{ $post->title }}</h2>
            <p class="text-gray-700">{{ Str::limit($post->content, 100) }}</p>
            <p class="text-sm text-gray-500">Ditulis oleh: {{ $post->user->name }}</p>

            @if (Auth::id() === $post->user_id)
                <div class="flex gap-2 mt-2">
                    <a href="{{ route('posts.edit', $post) }}" class="text-blue-600">Edit</a>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600">Hapus</button>
                    </form>
                </div>
            @endif
            <a href="{{ route('posts.show', $post) }}" class="text-blue-600 hover:underline">Lihat Detail</a>
        </div>
    @endforeach

    {{ $posts->links() }}
@endsection