<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\CatName;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    private function createDummyCatName($userId = null) : CatName {
//        $cat = new CatName();
//        $cat->name = 'Meow';
//        $cat->age = 12;
//        $cat->save();
//
//        return $cat;

        return CatName::factory()->create([
            'user_id' => $userId ?? $this->user()->id,
        ]);
    }

    public function testNoCatWhenNothingInDatabase()
{
    $user = User::factory()->make();

    $this->actingAs($user);

    $response = $this->get('/cats');

    $response->assertSeeText("Where are my cats?");
}

    public function testSee1CatPostWhenThereIs1()
    {
        $user = $this->user();

        $this->actingAs($user);

        $cat = $this->createDummyCatName();
//        $cat->name = 'Meow';
//        $cat->age = 12;
//        $cat->user_id = 1;
//        $cat->save();

        $response = $this->get('/cats');

        $response->assertSeeText($cat->name);

        $this->assertDatabaseHas('cat_names', [
            'name' => $cat->name
        ]);
    }

    public function testStoreValid()
    {
        $params = [
          'name' => 'meow',
          'age' => 10,
        ];

        $this->actingAs($this->user()) //You can use {user()} because I have function in TestCase.php
            ->post('/cats', $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'New cat!');
    }

    public function testStoreFailed()
    {
        $params = [
            'name' => 'm',
            'age' => 1
        ];

        $this->actingAs($this->user()) //You can use {user()} because I have function in TestCase.php
            ->post('/cats', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $message = session('errors')->getMessages();

        $this->assertEquals($message['name'][0], 'The name must be at least 3 characters.');
    }

    public function testUpdateValid()
    {
        $user = $this->user();
        $cat = $this->createDummyCatName($user->id);

//        $user = User::factory()->make();

        $cat2 = [
            'name' => 'New cat',
            'age' => 22
        ];

        $this->actingAs($user)
            ->put("/cats/{$cat->id}", $cat2)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Cat was update!');

        $this->assertDatabaseMissing('cat_names', $cat->toArray());
//        $this->assertSoftDeleted('cat_names', $cat->toArray());
    }

    public function testDeleting()
    {
        $user = $this->user();
        $cat = $this->createDummyCatName($user->id);

//        $user = User::factory()->make();

        $this->actingAs($user)
            ->delete("/cats/{$cat->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Cat ' . $cat->name . ' was lost(');
    }

    public function testAddToDatabase()
    {
        $cat = [
            'id' => 1,
            'name' => "Super Cat",
            'age' => 123
        ];

        $this->actingAs($this->user()) //You can use {user()} because I have function in TestCase.php
            ->post('/cats', $cat)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'New cat!');
    }


    public function testSee1CatNameWithComments() {
        $user = $this->user();

//        $this->actingAs($user);

        $cat = $this->createDummyCatName();

        Comment::factory()->count(4)->create([
            'commentable_id' => $cat->id,
            'commentable_type' => 'App\Models\CatName',
            'user_id' => $user->id
        ]);

        $response = $this->get('/cats');
        $response->assertSeeText('4 comments');
    }


}

