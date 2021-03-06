<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Traits\WithAuthRedirects;
use Livewire\Component;
use App\Models\Comment;
use App\Notifications\CommentCreated;
use Illuminate\Http\Response;

class CreateComment extends Component
{
    use WithAuthRedirects;

    public $idea;
    public $comment = '';

    protected $rules = [
        'comment' => 'required|string|min:10',
    ];

    public function addComment()
    {
        if (auth()->guest()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $this->validate();

        $newComment = Comment::create([
            'idea_id' => $this->idea->id,
            'user_id' => auth()->id(),
            'body' => $this->comment,
        ]);

        $this->idea->user->notify(new CommentCreated($newComment));

        $this->emit('commentCreated', 'Comment was successfuly created.');

        $this->comment = '';
    }

    public function render()
    {
        return view('livewire.create-comment');
    }
}
