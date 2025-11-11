<?php

use App\Livewire\Admin\Posts\Create;
use App\Livewire\Admin\Posts\Edit;
use App\Livewire\Admin\Posts\Index;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;

test('authenticated user can view posts index', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->get(route('admin.posts.index'));

    $response->assertSuccessful();
    $response->assertSee('Blog Posts');
});

test('posts index displays posts with categories', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $post = Post::factory()->published()->create(['user_id' => $user->id]);
    $post->categories()->attach($category);

    $this->actingAs($user);

    Livewire::test(Index::class)
        ->assertSee($post->title)
        ->assertSee($category->name);
});

test('authenticated user can create a post', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $this->actingAs($user);

    Livewire::test(Create::class)
        ->set('title', 'New Blog Post')
        ->set('slug', 'new-blog-post')
        ->set('excerpt', 'This is an excerpt')
        ->set('content', 'This is the full content of the blog post.')
        ->set('selectedCategories', [$category->id])
        ->set('published_at', now()->format('Y-m-d\TH:i'))
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('admin.posts.index'));

    expect(Post::where('title', 'New Blog Post')->exists())->toBeTrue();
    expect(Post::where('title', 'New Blog Post')->first()->categories)->toHaveCount(1);
});

test('authenticated user can edit a post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id, 'title' => 'Original Title']);
    $category = Category::factory()->create();

    $this->actingAs($user);

    Livewire::test(Edit::class, ['post' => $post])
        ->set('title', 'Updated Title')
        ->set('slug', 'updated-title')
        ->set('content', 'Updated content')
        ->set('selectedCategories', [$category->id])
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('admin.posts.index'));

    expect($post->fresh()->title)->toBe('Updated Title');
});

test('authenticated user can delete a post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user);

    Livewire::test(Index::class)
        ->call('deletePost', $post->id)
        ->assertHasNoErrors();

    expect(Post::find($post->id))->toBeNull();
});

test('post belongs to many categories', function () {
    $post = Post::factory()->create();
    $categories = Category::factory()->count(3)->create();

    $post->categories()->attach($categories);

    expect($post->categories)->toHaveCount(3);
});

test('category belongs to many posts', function () {
    $category = Category::factory()->create();
    $posts = Post::factory()->count(3)->create();

    $category->posts()->attach($posts);

    expect($category->posts)->toHaveCount(3);
});

test('post validation requires title and content', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test(Create::class)
        ->set('title', '')
        ->set('content', '')
        ->call('save')
        ->assertHasErrors(['title', 'content']);
});
