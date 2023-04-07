<?php

use App\Http\Livewire\Timeline;
use App\Http\Livewire\Tweet\Create;
use App\Models\Tweet;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Livewire\livewire;

it('should be able to create a tweet', function ($tweet) {
    $user = User::factory()->create();
    actingAs($user);

    livewire(Create::class)
        ->set('body', $tweet)
        ->call('tweet')
        ->assertEmitted('tweet::created');
    
    assertDatabaseCount('tweets', 1);

    expect(Tweet::first())->body->toBe($tweet)->created_by->toBe($user->id);
})->with(['my first tweet', 'my second tweet', 'my third tweet']);

it('should make sure that only authenticated users can tweet', function () {
    livewire(Create::class)
        ->set('body', 'My first tweet')
        ->call('tweet')
        ->assertForbidden();
    
    actingAs(User::factory()->create());

    livewire(Create::class)
        ->set('body', 'My first tweet')
        ->call('tweet')
        ->assertEmitted('tweet::created');
});

test('body is required', function () {
    $this->actingAs(User::factory()->create());

    livewire(Create::class)
        ->set('body', '')
        ->call('tweet')
        ->assertHasErrors(['body' => 'required']);
});

test('body has no more than 255 characters', function () {
    $this->actingAs(User::factory()->create());

    livewire(Create::class)
        ->set('body', str_repeat('a', 256))
        ->call('tweet')
        ->assertHasErrors(['body' => 'max']);
});

it('should show the tweet on the timelien', function () {
    $user = User::factory()->create();
    actingAs($user);

    livewire(Create::class)
        ->set('body', 'My first tweet')
        ->call('tweet')
        ->assertEmitted('tweet::created');
    
    livewire(Timeline::class)
        ->assertSee('My first tweet');
});

it('should set body as null after creating a tweet', function () {
    $user = User::factory()->create();
    actingAs($user);

    livewire(Create::class)
        ->set('body', 'My first tweet')
        ->call('tweet')
        ->assertEmitted('tweet::created')
        ->assertSet('body', null);
});
