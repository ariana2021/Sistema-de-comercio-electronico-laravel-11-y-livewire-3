<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="tp-postbox-details-comment-wrapper">
            <h3 class="tp-postbox-details-comment-title">Comentarios ({{ $this->totalComments }})</h3>
            <div class="tp-postbox-details-comment-inner">
                <ul>
                    @foreach ($comments as $comment)
                        <li>
                            <div class="tp-postbox-details-comment-box d-sm-flex align-items-start">
                                <div class="tp-postbox-details-comment-thumb">
                                    <img loading="lazy" src="{{ $comment->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) . '&background=random&size=80' }}"
                                        class="rounded-full border shadow" alt="{{ $comment->user->name }}">

                                </div>
                                <div class="tp-postbox-details-comment-content">
                                    <div
                                        class="tp-postbox-details-comment-top d-flex justify-content-between align-items-start">
                                        <div class="tp-postbox-details-comment-avater">
                                            <h4 class="tp-postbox-details-comment-avater-title">
                                                {{ $comment->user->name ?? 'Usuario eliminado' }}</h4>
                                            <span
                                                class="tp-postbox-details-avater-meta">{{ $comment->created_at->format('d M, Y \a \l\a\s h:i A') }}</span>
                                        </div>
                                        @auth
                                            <div class="tp-postbox-details-comment-reply">
                                                <a href="#"
                                                    wire:click.prevent="setReplyingTo({{ $comment->id }})">Responder</a>
                                            </div>
                                        @endauth
                                    </div>
                                    <p>{{ $comment->content }}</p>
                                    @auth
                                        <button wire:click="likeComment({{ $comment->id }})" class="text-sm text-gray-500">
                                            <i
                                                class="{{ $this->userLiked($comment->id) ? 'fas' : 'far' }} fa-thumbs-up"></i>
                                            {{ $comment->likes_count }}
                                        </button>
                                    @else
                                        <button class="text-sm text-gray-500">
                                            <i
                                                class="{{ $this->userLiked($comment->id) ? 'fas' : 'far' }} fa-thumbs-up"></i>
                                            {{ $comment->likes_count }}
                                        </button>
                                    @endauth
                                    @auth
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
                            <ul class="children">
                                @include('livewire.comment-replies', ['comments' => $comment->replies])
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        @auth
            <div class="tp-postbox-details-form">
                <h3 class="tp-postbox-details-form-title">Deja un comentario</h3>
                <p>Tu dirección de correo electrónico no será publicada. Los campos obligatorios están marcados *</p>
                <div class="tp-postbox-details-form-wrapper">
                    <div class="tp-postbox-details-form-inner">
                        <div class="tp-postbox-details-input-box">
                            <div class="tp-contact-input">
                                <textarea wire:model="newComment" placeholder="Escribe tu mensaje aquí..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="tp-postbox-details-input-box">
                        <button wire:click="postComment" class="tp-postbox-details-input-btn">Publicar comentario</button>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-light text-center">
                <p class="mb-2 text-muted">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    Debes iniciar sesión para comentar.
                </p>
                <a href="{{ route('login') }}" class="btn btn-danger">
                    <i class="fas fa-sign-in-alt me-1"></i> Iniciar sesión
                </a>
            </div>

        @endauth

    </div>
</div>
