<!-- resources/views/stories/index.blade.php -->
<x-layout.app-layout :type="$type">
    <div class="bg-white rounded-lg shadow p-6">
        @foreach ($stories as $story)
            <div class="py-4 border-b border-gray-200 last:border-b-0">
                <div class="flex items-start">
                    <span class="text-gray-500 mr-2">{{ $loop->iteration }}.</span>
                    <div>
                        <div class="flex items-center">
                            <a href="{{ $story->url ?? route('stories.show', $story->id) }}" 
                               target="_blank" 
                               class="text-lg font-medium hover:underline">
                                {{ $story->title }}
                            </a>
                            @if($story->url)
                                <span class="text-xs text-gray-500 ml-2">
                                    ({{ parse_url($story->url, PHP_URL_HOST) }})
                                </span>
                            @endif
                        </div>
                        <div class="text-xs text-gray-500 mt-1">
                            {{ $story->score }} points by {{ $story->by }} | 
                            {{ $story->time->diffForHumans() }} | 
                            <a href="{{ route('stories.show', $story->id) }}" class="hover:underline">
                                {{ $story->comments_count }} comments
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="mt-4">
            {{ $stories->links() }}
        </div>
    </div>
</x-layout.app-layout>