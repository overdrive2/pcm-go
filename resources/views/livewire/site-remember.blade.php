<div>
    @if($site != auth()->user()->stksite)
        <x-button type="button" class="bg-gray-100" wire:click='remember'>จำค่า</x-button>
    @endif
</div>
