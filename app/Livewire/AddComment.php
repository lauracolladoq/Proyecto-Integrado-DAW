<?php
namespace App\Livewire;

use App\Models\Comment;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AddComment extends Component
{
    #[Validate(['required', 'string', 'max:255'])]
    public string $content = '';

    public int $postId;

    public function store()
    {
        $this->validate();

        $comment = Comment::create([
            'content' => $this->content,
            'user_id' => auth()->id(),
            'post_id' => $this->postId,
        ]);

        // Se dispara el evento para actualizar los comentarios en las vistas
        $this->dispatch('eventAddComment')->to(Explore::class);
        $this->dispatch('eventAddComment')->to(Home::class);
        $this->dispatch('eventAddComment')->to(TrendingTag::class);
        $this->dispatch('eventAddComment')->to(PostDetail::class);

        // Se dispara el evento para mostrar el mensaje informativo
        $this->dispatch("message", "Comment created!");

        $this->cancelAddComment();
    }

    public function cancelAddComment()
    {
        $this->reset(['content']);

        //Limpiar errores
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.add-comment');
    }
}