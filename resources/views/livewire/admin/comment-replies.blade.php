<div class="row justify-content-center">
    <div class="card border-0">
        <div class="card-body">
            <div class="list-group">
                @foreach ($comments as $comment)
                    <div class="list-group-item py-3">
                        <div class="d-flex align-items-start">
                            <!-- Avatar -->
                            <img src="{{ $comment->user->avatar ? Storage::url($comment->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) . '&background=random&size=80' }}"
                                class="rounded-circle border shadow-sm me-3" width="50" height="50"
                                alt="{{ $comment->user->name }}">

                            <div class="w-100">
                                <!-- Nombre y fecha -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-1">{{ $comment->user->name ?? 'Usuario eliminado' }}</h5>
                                        <small class="text-muted">
                                            {{ $comment->created_at->format('d M, Y \a \l\a\s h:i A') }}
                                        </small>
                                    </div>
                                    <a href="#" class="text-primary small"
                                        wire:click="setReplyingTo({{ $comment->id }})">
                                        <i class="fas fa-reply"></i> Responder
                                    </a>
                                </div>

                                <!-- Comentario -->
                                <p class="mt-2 mb-2">{{ $comment->content }}</p>

                                <!-- Botones de Me gusta y Eliminar -->
                                <div>
                                    <button wire:click="likeComment({{ $comment->id }})"
                                        class="btn btn-sm btn-outline-primary">
                                        <i
                                            class="{{ $this->userLiked($comment->id) ? 'fas' : 'far' }} fa-thumbs-up"></i>
                                        {{ $comment->likes_count }}
                                    </button>
                                    <button wire:click="deleteComment({{ $comment->id }})"
                                        class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>

                                <!-- Responder al comentario -->
                                @if ($replyingTo === $comment->id)
                                    <div class="mt-3">
                                        <textarea wire:model="replyContent" class="form-control" rows="2" placeholder="Escribe una respuesta..."></textarea>
                                        <button wire:click="postReply({{ $comment->id }})"
                                            class="btn btn-success btn-sm mt-2">
                                            <i class="fas fa-paper-plane"></i> Responder
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Respuestas -->
                        @if ($comment->replies->count())
                            <div class="mt-3 ps-5 border-start">
                                @foreach ($comment->replies as $reply)
                                    <div class="border-bottom pb-2 mb-2">
                                        <div class="d-flex align-items-start">
                                            <!-- Avatar -->
                                            <img src="{{ $reply->user->avatar ? Storage::url($reply->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($reply->user->name) . '&background=random&size=80' }}"
                                                class="rounded-circle border shadow-sm me-3" width="40"
                                                height="40" alt="{{ $reply->user->name }}">

                                            <div class="w-100">
                                                <!-- Nombre y fecha -->
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <strong>{{ $reply->user->name ?? 'Usuario eliminado' }}</strong>
                                                        <small
                                                            class="text-muted">{{ $reply->created_at->format('d M, Y h:i A') }}</small>
                                                    </div>
                                                    <a href="#" class="text-primary small"
                                                        wire:click="setReplyingTo({{ $reply->id }})">
                                                        <i class="fas fa-reply"></i> Responder
                                                    </a>
                                                </div>

                                                <!-- Contenido de la respuesta -->
                                                <p class="mb-1">{{ $reply->content }}</p>

                                                <!-- Botones de Me gusta y Eliminar -->
                                                <div>
                                                    <button wire:click="likeComment({{ $reply->id }})"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i
                                                            class="{{ $this->userLiked($reply->id) ? 'fas' : 'far' }} fa-thumbs-up"></i>
                                                        {{ $reply->likes_count }}
                                                    </button>
                                                    <button wire:click="deleteComment({{ $reply->id }})"
                                                        class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>

                                                <!-- Responder a la respuesta -->
                                                @if ($replyingTo === $reply->id)
                                                    <div class="mt-3">
                                                        <textarea wire:model="replyContent" class="form-control" rows="2" placeholder="Escribe una respuesta..."></textarea>
                                                        <button wire:click="postReply({{ $reply->id }})"
                                                            class="btn btn-success btn-sm mt-2">
                                                            <i class="fas fa-paper-plane"></i> Responder
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
