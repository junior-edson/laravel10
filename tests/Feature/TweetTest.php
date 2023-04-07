<?php

use App\Http\Livewire\Tweet\Create;
use App\Models\Tweet;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Livewire\livewire;

it('should be able to create a tweet', function () {
    $user = User::factory()->create();
    actingAs($user);

    livewire(Create::class)
        ->set('body', 'My first tweet')
        ->call('tweet')
        ->assertEmitted('tweet::created');
    
    assertDatabaseCount('tweets', 1);

    expect(Tweet::first())->body->toBe('My first tweet')->created_by->toBe($user->id);
});

/* todo('should make sure that only authenticated users can tweet', function () {
    $this->post('/tweets', [
        'body' => 'My first tweet'
    ])->assertRedirect('/login');
});

todo('should have body required', function () {
    $this->post('/tweets', [
        'body' => ''
    ])->assertSessionHasErrors('body');
});

todo('the tweet should have a max of 255 characters', function () {
    $this->post('/tweets', [
        'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec auctor, nisl eget ultricies lacinia,
        nisl nisl aliquet nisl, nec aliquet nisl nisl nec nisl. Donec auctor, nisl eget ultricies lacinia,
        nisl nisl aliquet nisl,nec aliquet nisl nisl nec nisl.'
    ])->assertSessionHasErrors('body');
});

todo('it should show the tweet on the timeline', function () {
    $this->post('/tweets', [
        'body' => 'My first tweet'
    ]);

    $this->get('/tweets')
        ->assertSee('My first tweet');
}); */
