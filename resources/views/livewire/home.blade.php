<div class="main-middle">
    <!-- ------------------------------------------- Inicio Feed ------------------------------------------- -->
    <!-- Si los usuarios a los que sigues han subido posts, se muestran -->
    @if (auth()->user()->following()->count())
        @if ($posts->count())
            <div class="feeds">
                @foreach ($posts as $post)
                    <div class="feed">
                        <div class="feed-top">
                            <a href="{{ route('user-profile', $post->user->id) }}" class="user">
                                <div class="profile-picture">
                                    <img src="{{ Storage::url($post->user->avatar) }}"
                                        alt="{{ $post->user->username }}'s profile picture" />
                                </div>
                                <div class="info">
                                    <h4 class="font-extrabold text-[16px]"><span>@</span>{{ $post->user->username }}
                                    </h4>
                                    <div class="time text-gray">
                                        <small>{{ $post->created_at->format('d/m/Y h:i:s') }}</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="feed-img">
                            <img src="{{ Storage::url($post->image) }}"
                                alt="Post image by {{ $post->user->username }}" />
                        </div>
                        <div class="action-button">
                            <button wire:click="like({{ $post->id }})">
                                <i @class([
                                    'fa-regular fa-heart',
                                    'fa-solid fa-heart liked' => in_array(
                                        $post->id,
                                        $myLikes->pluck('id')->toArray()),
                                ])></i>
                            </button>
                            <button id="toggleComments-{{ $post->id }}">
                                <i class="fa-regular fa-comment-dots"></i>
                            </button>
                            <span><i class="fa-solid fa-link"></i></span>
                        </div>
                        <!-- Si no tiene likes, aparece vacío -->
                        @if ($post->usersLikes->count() == 0)
                            <!-- Si solo tiene un like, aparece que es likeado por esa persona y solo aparece su foto -->
                        @elseif ($post->usersLikes->count() == 1)
                            <div class="liked-by">
                                <span><img
                                        src="{{ Storage::url($post->usersLikes()->inRandomOrder()->value('avatar')) }}"
                                        alt="User avatar" /></span>
                                <p>Liked By <b>{{ $post->usersLikes()->inRandomOrder()->value('name') }}</b></p>
                            </div>
                        @else
                            <!-- Si tiene más de un like, aparece que es likeado por dos personas aleatorias y cuantas personas más le han dado like -->
                            <div class="liked-by">
                                <span><img
                                        src="{{ Storage::url($post->usersLikes()->inRandomOrder()->value('avatar')) }}"
                                        alt="User avatar" /></span>
                                <span><img
                                        src="{{ Storage::url($post->usersLikes()->inRandomOrder()->value('avatar')) }}"
                                        alt="User avatar" /></span>
                                <p>Liked By <b>{{ $post->usersLikes()->inRandomOrder()->value('name') }}</b> and
                                    <b>{{ $post->usersLikes->count() - 1 }}</b> others
                                </p>
                            </div>
                        @endif
                        <div class="caption">
                            <!-- Si no tiene contenido, aparece vacío -->
                            @if ($post->content)
                                <p>
                                    <span class="pr-1 font-bold">{{ $post->user->name }}</span>{{ $post->content }}
                                </p>
                            @endif
                            @if ($post->tags->count())
                                <div class="tags pt-2 flex flex-wrap gap-2">
                                    @foreach ($post->tags as $tag)
                                        <a href="{{ route('trending-tag', $tag->id) }}"
                                            class="px-1 py-0.5 bg-[{{ $tag->color }}] text-black rounded-full mr-1">{{ $tag->name }}</a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div id="comments-{{ $post->id }}" class="comments" style="display: none;">
                            <!-- Si tiene comentarios, se muestran -->
                            @if (count($post->comments))
                                @foreach ($post->comments as $comment)
                                    <!-- Si el comentario es del usuario logeado, se añade el botón de delete -->
                                    @if ($comment->user_id == auth()->user()->id)
                                        <div class="comment-user">
                                            <div class="profile-picture">
                                                <img src="{{ Storage::url($comment->user->avatar) }}"
                                                    alt="{{ $comment->user->username }}'s profile picture" />
                                            </div>
                                            <div class="comment-body">
                                                <p class="font-extrabold">{{ $comment->user->username }}</p>
                                                <p>
                                                    {{ $comment->content }}
                                                </p>
                                            </div>
                                            <button wire:click="delete({{ $comment->id }})">
                                                <i class="fas fa-trash text-red-500"></i>
                                            </button>
                                        </div>
                                    @else
                                        <div class="comment">
                                            <a href="{{ route('user-profile', $comment->user->id) }}"
                                                class="profile-picture">
                                                <img src="{{ Storage::url($comment->user->avatar) }}"
                                                    alt="{{ $comment->user->username }}'s profile picture" />
                                            </a>
                                            <div class="comment-body">
                                                <a href="{{ route('user-profile', $comment->user->id) }}"
                                                    class="font-extrabold">{{ $comment->user->username }}</a>
                                                <p>{{ $comment->content }}</p>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                <!-- Si no tiene comentarios, aparece un mensaje -->
                            @else
                                <p>No comments yet</p>
                            @endif
                        </div>
                        <div class="pt-2">
                            @livewire('add-comment', ['postId' => $post->id], key('add-comment-' . $post->id))
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- ------------------------------------------- Fin Feed  ------------------------------------------- -->
            <!-- Si no hay posts, aparece un mensaje -->
        @else
            <div class="no-posts text-center">
                <h2 class="text-2xl font-extrabold">No posts yet</h2>
                <p class="text-gray">When someone posts something, you'll see it here.</p>
            </div>
        @endif
        <!-- Si no sigues a nadie, aparece un mensaje -->
    @else
        <div class="no-posts text-center">
            <h2 class="text-2xl font-extrabold">Start following someone!</h2>
            <p class="text-gray">Once you start following other users, you'll see their posts here.</p>
        </div>
    @endif
</div>
