<div>
    <div>
        <textarea wire:model="body" class="w-full" rows="3" placeholder="What's up doc?"></textarea>
        <button wire:click="tweet" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Tweet</button>
        @error('body') <span class="text-red-500 font-bold">{{ $message }}</span> @enderror
    </div>
</div>
