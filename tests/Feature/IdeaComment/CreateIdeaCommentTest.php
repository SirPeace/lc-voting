<?php

use App\Http\Livewire\CreateIdeaComment;
use App\Models\Idea;
use App\Models\User;
use Livewire\Livewire;
use App\Models\IdeaComment;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);


// ! Does not work
// test("create-idea-comment_livewire_component_renders", function ()
// {
//     $idea = Idea::factory()->create();

//     $response = $this->get(route('idea.show', $idea));

//     $response->assertSeeLivewire('create-idea-comment');
// });


test("add_comment_form_renders_when_user_is_logged_in", function ()
{
    $user = User::factory()->create();
    $idea = Idea::factory()->create();

    $response = $this->actingAs($user)->get(route('idea.show', $idea));

    $response->assertSee('Share your thoughts');
});


test("add_comment_form_does_not_render_when_user_is_logged_out", function () {
    $idea = Idea::factory()->create();

    $response = $this->get(route('idea.show', $idea));

    $response->assertSee('Please login or create an account to post a comment');
});


test("add_comment_form_validation_works", function ()
{
    $user = User::factory()->create();
    $idea = Idea::factory()->create();

    Livewire::actingAs($user)
        ->test(CreateIdeaComment::class, [
            'idea' => $idea,
        ])
        ->set('comment', '')
        ->call('addComment')
        ->assertHasErrors(['comment'])
        ->set('comment', 'ab')
        ->call('addComment')
        ->assertHasErrors(['comment']);
});


test("add_comment_form_works", function ()
{
    $user = User::factory()->create();
    $idea = Idea::factory()->create();

    Livewire::actingAs($user)
        ->test(CreateIdeaComment::class, [
            'idea' => $idea,
        ])
        ->set('comment', 'This is my first comment')
        ->call('addComment')
        ->assertEmitted('ideaCommentCreated');

    $this->assertEquals(1, IdeaComment::count());
    $this->assertEquals('This is my first comment', $idea->comments->first()->body);
});