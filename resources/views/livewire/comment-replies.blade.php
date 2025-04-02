@foreach ($comments as $comment)
    <li>
        <div class="tp-postbox-details-comment-box d-sm-flex align-items-start">
            <!-- Avatar -->
            <div class="tp-postbox-details-comment-thumb">
                <img loading="lazy" src="{{ $comment->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) . '&background=random&size=80' }}"
                    class="rounded-full border shadow" alt="{{ $comment->user->name }}">
            </div>
            <div class="tp-postbox-details-comment-content">
                <div class="tp-postbox-details-comment-top d-flex justify-content-between align-items-start">
                    <div class="tp-postbox-details-comment-avater">
                        <h4 class="tp-postbox-details-comment-avater-title">
                            {{ $comment->user->name ?? 'Usuario eliminado' }}</h4>
                        <span
                            class="tp-postbox-details-avater-meta">{{ $comment->created_at->format('d M, Y \a \l\a\s h:i A') }}</span>
                    </div>
                    @auth
                        <div class="tp-postbox-details-comment-reply">
                            <button wire:click="setReplyingTo({{ $comment->id }})">Responder</button>
                        </div>
                    @endauth
                </div>
                <p>{{ $comment->content }}</p>
                @auth
                    <button wire:click="likeComment({{ $comment->id }})" class="text-sm text-gray-500">
                        <i class="{{ $this->userLiked($comment->id) ? 'fas' : 'far' }} fa-thumbs-up"></i>
                        {{ $comment->likes_count }}
                    </button>
                @else
                    <button class="text-sm text-gray-500">
                        <i class="{{ $this->userLiked($comment->id) ? 'fas' : 'far' }} fa-thumbs-up"></i>
                        {{ $comment->likes_count }}
                    </button>
                @endauth
                @auth
                    <!-- Formulario de respuesta -->
                    @if ($replyingTo === $comment->id)
                        <div class="ml-4 mt-2">
                            <textarea wire:model="replyContent" class="w-full border rounded p-2" placeholder="Escribe una respuesta..."></textarea>
                            <button wire:click="postReply({{ $comment->id }})"
                                class="bg-green-500 text-white px-4 py-2 rounded mt-2">Responder</button>
                        </div>
                    @endif
                @endauth
            </div>
        </div>

        <!-- Respuestas anidadas -->
        <ul class="children">
            @include('livewire.comment-replies', ['comments' => $comment->replies])
        </ul>
    </li>
@endforeach
