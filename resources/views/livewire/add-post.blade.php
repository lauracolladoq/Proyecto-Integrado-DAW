<div>
    <x-button wire:click="$set('openModalAddPost', true)" class="btn btn-primary">Add Post</x-button>
    <x-dialog-modal wire:model="openModalAddPost" class="justify-center">
        <x-slot name="title">
            <div class="flex justify-between items-center">
                <h2 class="font-extrabold flex-grow text-center">Add New Post</h2>
                <button wire:click="cancelAddPost" class="flex-shrink-0 ml-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                        color="#000000" fill="none">
                        <path d="M18 6L12 12M12 12L6 18M12 12L18 18M12 12L6 6" stroke="currentColor" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
        </x-slot>
        <x-slot name="content">
            <div class="row flex items-center justify-between">
                <div class="column flex flex-col">
                    <x-label for="image">Image:</x-label>
                    <x-input type="file" id="image" wire:model="image" />
                    <x-input-error for="image" />
                </div>
                <div class="column">
                    <x-label for="content">Content</x-label>
                    <textarea id="content" name="content" wire:model="content"></textarea>
                    <x-input-error for="content" />
                </div>
            </div>
            <div class="row flex flex-column">
                <x-label for="tags" class="font-extrabold">Tags</x-label>
                <div class="flex flex-wrap gap-2 justify-center">
                    @foreach ($myTags as $tag)
                        <div class="relative inline-block">
                            <!-- peer es una clase de Tailwind que se usa para habilitar estilo condicional basado en el estado de un "peer" que es un elemento de formulario como un input -->
                            <x-input id="{{ $tag->name }}" type="checkbox" value="{{ $tag->id }}"
                                wire:model="tags" class="hidden peer" />
                            <x-label for="{{ $tag->name }}"
                                class="px-1 py-0.5 bg-[{{ $tag->color }}] rounded-full cursor-pointer bg-opacity-40 hover:bg-opacity-100 hover:shadow-xl
                                peer-checked:bg-opacity-100 peer-checked:shadow-xl">
                                {{ $tag->name }}
                            </x-label>
                        </div>
                    @endforeach
                </div>
                <x-input-error for="tags" />
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-button wire:click="store" wire:loading.attr="disabled" class="btn btn-primary">
                Save
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>