<div class="position-relative">
    <input type="text" wire:model.live="search" placeholder="Buscar productos...">

    @if (!empty($results))
        <ul class="position-absolute bg-white border rounded shadow-lg w-100 mt-1 custom-dropdown z-index-110 max-h-60 overflow-auto">
            @foreach ($results as $product)
                <li class="p-2 custom-hover cursor-pointer rounded">
                    <a href="#" class="d-block text-decoration-none text-dark">
                        {{ $product->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
