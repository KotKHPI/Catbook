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

    private function createDummyCatName() : CatName {
        $cat = new CatName();
        $cat->name = 'Meow';
        $cat->age = 12;
        $cat->save();

        return $cat;
    }

//    public function testNoCatWhenNothingInDatabase()
//    {
//        $user = User::factory()->make();
//
//        $this->actingAs($user);
//
//        $response = $this->get('/cats');
//
//        $response->assertSeeText("Where are my cats?");
//    } TO DO

    public function testSee1CatPostWhenThereIs1()
    {
        $user = User::factory()->make();

        $this->actingAs($user);

        $cat = new CatName();
        $cat->name = 'Meow';
        $cat->age = 12;
        $cat->save();

        $response = $this->get('/cats');

        $response->assertSeeText('Meow');

        $this->assertDatabaseHas('cat_names', [
            'name' => 'Meow'
        ]);
    }

    public function testStoreValid()
    {
        $params = [
          'name' => 'meow',
          'age' => 10
        ];

        $user = User::factory()->make();

        $this->actingAs($user);


        $this->actingAs($user)
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

        $user = User::factory()->make();


        $this->actingAs($user)
            ->post('/cats', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $message = session('errors')->getMessages();

        $this->assertEquals($message['name'][0], 'The name must be at least 3 characters.');
    }

    public function testUpdateValid()
    {
        $cat = $this->createDummyCatName();

        $user = User::factory()->make();

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
        $cat = $this->createDummyCatName();

        $user = User::factory()->make();

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

        $user = User::factory()->make();

        $this->actingAs($user)
            ->post('/cats', $cat)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'New cat!');
    }

//    public function testUpdateAgain()
//    {
//        $cat = [
//            'name' => "Cat",
//            'age' => 1
//        ];
//
//        $user = User::factory()->make();
//
//        $cat2 = [
//            'name' => "Super Cat",
//            'age' => 123
//        ];
//
//        $this->actingAs($user)
//            ->put("/cats/{$cat->id}", $cat2)
//            ->assertStatus(302)
//            ->assertSessionHas('status');
//
//        $this->assertEquals(session('status'), 'Cat was update!');
//        $this->assertDatabaseMissing('cat_names', $cat);
//    }

    public function testSee1CatNameWithComments() {
        $cat = $this->createDummyCatName();

        $user = User::factory()->make();

        $this->actingAs($user);

        Comment::factory()->count(4)->create([
            'cat_name_id' => $cat->id
        ]);

        $response = $this->get('/cats');
        $response->assertSeeText('4 comments');
    }


}

