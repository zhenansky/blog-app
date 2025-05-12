@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">
        {{-- Post --}}
        <div class="bg-white p-6 rounded shadow mb-6">
            <h1 class="text-3xl font-bold mb-2">{{ $post->title }}</h1>
            <p class="text-gray-700 mb-4">{{ $post->content }}</p>
            <p class="text-sm text-gray-500">Ditulis oleh: {{ $post->user->name }}</p>
        </div>

        {{-- Form komentar utama --}}
        @auth
            <form action="{{ route('comments.store') }}" method="POST" class="mb-6">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <textarea name="content" rows="3" class="w-full border rounded px-3 py-2" placeholder="Tulis komentar..."
                    required></textarea>
                <button type="submit" class="mt-2 bg-blue-600 text-white px-4 py-2 rounded">Kirim Komentar</button>
            </form>
        @else
            <p class="text-sm text-gray-600 mb-6">Login untuk memberi komentar.</p>
        @endauth

        {{-- Komentar dan balasan --}}
        <div>
            <h2 class="text-xl font-semibold mb-4">Komentar</h2>

            @forelse($post->comments as $comment)
                <div class="mb-4 border-l-4 border-blue-500 pl-4">
                    <p class="font-semibold text-sm">{{ $comment->user->name }}</p>
                    <p class="mb-2">{{ $comment->content }}</p>

                    {{-- Form balasan komentar --}}
                    @auth
                        <form action="{{ route('comments.store') }}" method="POST" class="mt-2 ms-4">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                            <textarea name="content" rows="2" class="w-full border rounded px-3 py-1 text-sm"
                                placeholder="Balas komentar..." required></textarea>
                            <button type="submit"
                                class="mt-1 text-sm bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded">Balas</button>
                        </form>
                    @endauth

                    {{-- Balasan satu tingkat --}}
                    @foreach($comment->replies as $reply)
                        <div class="mt-2 ms-6 border-l-2 border-gray-300 pl-3">
                            <p class="font-semibold text-xs">{{ $reply->user->name }}</p>
                            <p class="text-sm">{{ $reply->content }}</p>
                        </div>
                    @endforeach
                </div>
            @empty
                <p class="text-gray-600">Belum ada komentar.</p>
            @endforelse
        </div>
    </div>
@endsection