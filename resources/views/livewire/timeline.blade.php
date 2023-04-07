<div class="mt-10 text-white text-lg">
    @foreach($tweets as $tweet)
        <div class="p-4">
            <p class="text-gray-700">{{ $tweet->body }}</p>
        </div>
    @endforeach
</div>
