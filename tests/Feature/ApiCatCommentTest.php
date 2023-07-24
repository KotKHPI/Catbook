<?php

namespace Tests\Feature;

use App\Models\CatName;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiCatCommentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testCatDoesNotHaveComments() {
        $this->catName();

        $response = $this->json('GET', 'api/v1/cats/1/comment');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta'])
            ->assertJsonCount(0, 'data');
    }

    public function testCatHas10Comments() {
        $this->catName()->each(function (CatName $cat) {
            $cat->comments()->saveMany(
                Comment::factory()->count(10)->create([
                    'user_id' => $this->user()->id,
                    'commentable_type' => 'App\Models\User',
                    'commentable_id' => $this->user()->id
                ])
            );
        });

        $response = $this->json('GET', 'api/v1/cats/2/comment?per_page=10');

        $response->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'content',
                            'created_at',
                            'updated_at',
                            'user' => [
                                'id',
                                'name'
                            ]
                        ]
                    ],
                    'links',
                    'meta'
                ]
            )
            ->assertJsonCount(10, 'data');
    }

    public function testAddingCommentsWhenNotAuthenticated() {
        $this->catName();

        $response = $this->json('POST', 'api/v1/cats/3/comment');

        $response->assertStatus(401);
    }

    public function testAddingCommentsWhenAuthenticated () {
        $this->catName();

        $response = $this->actingAs($this->user(), 'api')->json('POST', 'api/v1/cats/4/comment', ['content' => 'Hello_form_test']);

        $response->assertStatus(201);
    }

    public function testAddingCommentWithInvalidData() {
        $this->catName();

        $response = $this->actingAs($this->user(), 'api')->json('POST', 'api/v1/cats/5/comment', ['content' => 'Mw']);

        $response->assertStatus(422);

    }


}
