<?php

namespace App\Http\Livewire;

use App\Models\Idea;
use Livewire\Component;
use App\Models\IdeaComment;
use Illuminate\Http\Response;

class CreateIdeaComment extends Component
{
    public Idea $idea;
    public string $comment = '';

    protected $rules = [
        'comment' => 'required|string|min:10',
    ];

    public function addComment()
    {
        if (auth()->guest()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $this->validate();

        IdeaComment::create([
            'idea_id' => $this->idea->id,
            'user_id' => auth()->id(),
            'body' => $this->comment,
        ]);

        $this->emit('ideaCommentCreated', 'Comment was successfuly created.');
    }

    public function render()
    {
        return view('livewire.create-idea-comment');
    }
}