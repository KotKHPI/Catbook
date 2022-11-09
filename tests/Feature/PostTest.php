<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\CatName;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testNoCatWhenNothingInDatabase()
    {
        $response = $this->get('/cats');

        $response->assertSeeText('Where are my cats?');
    }

    public function testSee1CatPostWhenThereIs1()
    {
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

        $this->post('/cats', $params)
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

        $this->post('/cats', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $message = session('errors')->getMessages();

        $this->assertEquals($message['name'][0], 'The name must be at least 3 characters.');
    }

    public function testUpdateValid()
    {
        $cat = new CatName();
        $cat->name = 'Meow';
        $cat->age = 12;
        $cat->save();

        $cat2 = [
            'name' => 'New cat',
            'age' => 22
        ];

        $this->put("/cats/{$cat->id}", $cat2)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Cat was update!');

        $this->assertDatabaseMissing('cat_names', $cat->toArray());
    }

    public function testDeleting()
    {
        $cat = new CatName();
        $cat->name = 'Meow';
        $cat->age = 12;
        $cat->save();

        $this->delete("/cats/{$cat->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Cat ' . $cat->name . ' was lost(');
    }

    public function testAddToDatabase()
    {
        $cat = [
            'name' => 'Mewo',
            'age' => 13
        ];

        $this->post('/cats', $cat)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'New cat!');
    }

    public function testUpdateAgain()
    {
        $cat = new CatName();
        $cat->name = 'Meow';
        $cat->age = 123;
        $cat->save();

        $cat2 = [
            'name' => "Super Cat",
            'age' => 123
        ];

        $this->put("/cats/{$cat->id}", $cat2)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Cat was update!');
        $this->assertDatabaseMissing('cat_names', $cat);
    }

}

