<!-- resources/views/stories/show.blade.php -->
<x-layout.app-layout :type="$type">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="mb-6">
            <h2 class="text-xl font-bold">{{ $story->title }}</h2>
            @if($story->url)
                <a href="{{ $story->url }}" target="_blank" class="text-sm text-gray-500 hover:underline">
                    {{ $story->url }}
                </a>
            @endif
            <div class="text-xs text-gray-500 mt-2">
                {{ $story->score }} points by {{ $story->by }} | 
                {{ $story->time->diffForHumans() }}
            </div>
            @if($story->text)
                <div class="mt-4 prose max-w-none">
                    {!! $story->text !!}
                </div>
            @endif
        </div>

        <div class="comments">
            <h3 class="font-medium mb-4">{{ $story->comments->count() }} Comments</h3>
            @foreach($story->comments as $comment)
                <div class="comment pl-4 border-l-2 border-gray-200 mb-4">
                    <div class="text-xs text-gray-500 mb-1">
                        {{ $comment->by }} {{ $comment->time->diffForHumans() }}
                    </div>
                    <div class="prose max-w-none text-sm">
                        {!! $comment->text !!}
                    </div>

                    @if($comment->replies->count() > 0)
                        <div class="mt-3 pl-4 space-y-3">
                            @foreach($comment->replies as $reply)
                                <div class="comment pl-4 border-l-2 border-gray-200">
                                    <div class="text-xs text-gray-500 mb-1">
                                        {{ $reply->by }} {{ $reply->time->diffForHumans() }}
                                    </div>
                                    <div class="prose max-w-none text-sm">
                                        {!! $reply->text !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</x-layout.app-layout>