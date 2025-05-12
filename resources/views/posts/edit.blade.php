@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Edit Postingan</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('posts.update', $post) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block font-semibold">Judul</label>
                <input type="text" name="title" id="title" class="w-full border px-3 py-2 rounded"
                    value="{{ $post->title }}" required>
            </div>

            <div class="mb-4">
                <label for="content" class="block font-semibold">Konten</label>
                <textarea name="content" id="content" rows="5" class="w-full border px-3 py-2 rounded"
                    required>{{ $post->content }}</textarea>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Perbarui</button>
        </form>
    </div>
@endsection