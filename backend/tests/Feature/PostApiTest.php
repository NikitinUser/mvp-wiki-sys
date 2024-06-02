<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Throwable;

class PostApiTest extends TestCase
{
    private Auth $auth;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->auth = $this->app->make(Auth::class);
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        unset(
            $this->auth
        );
    }

    /**
     * @return void
     */
    public function testGetAllPostsWithAuth(): void
    {
        $email = fake()->unique()->safeEmail();
        $pass = 'password';

        \App\Models\User::factory()->create([
            'email' => $email,
            'password' => $pass
        ]);

        $authResponse = $this->postJson('/api/auth/login', [
            'email' => $email,
            'password' => $pass
        ]);
        $token = $authResponse->getData()?->access_token;

        $response = $this->get('/api/post', [
            'Authorization' => sprintf('Bearer %s', $token),
        ]);

        $data = $response->getData();

        $response->assertStatus(200);
        $this->assertTrue(is_array($data));
    }

    /**
     * @return void
     */
    public function testGetAllPostsWithInvalidAuth(): void
    {
        $response = $this->get('/api/post', [
            'Authorization' => sprintf('Bearer %s', 'token'),
        ]);

        $response->assertStatus(401);
    }

    /**
     * @return void
     */
    public function testGetAllPostsWithoutAuth(): void
    {
        $response = $this->get('/api/post');

        $response->assertStatus(401);
    }

    /**
     * @return void
     */
    public function testCreatePostWithValidData(): void
    {
        $email = fake()->unique()->safeEmail();
        $pass = 'password';

        \App\Models\User::factory()->create([
            'email' => $email,
            'password' => $pass
        ]);

        $authResponse = $this->postJson('/api/auth/login', [
            'email' => $email,
            'password' => $pass
        ]);
        $token = $authResponse->getData()?->access_token;

        $params = [
            'title' => fake()->sentence(14),
            'content' => fake()->paragraphs(1, true)
        ];

        $response = $this->postJson(
            '/api/post',
            $params,
            [
                'Authorization' => sprintf('Bearer %s', $token),
            ]
        );

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->hasAll(['postId', 'actionId'])
        );
    }

    /**
     * @return void
     */
    public function testCreatePostWithInvalidData(): void
    {
        $email = fake()->unique()->safeEmail();
        $pass = 'password';

        \App\Models\User::factory()->create([
            'email' => $email,
            'password' => $pass
        ]);

        $authResponse = $this->postJson('/api/auth/login', [
            'email' => $email,
            'password' => $pass
        ]);
        $token = $authResponse->getData()?->access_token;

        $params = [
            [
                'title' => fake()->sentence(14)
            ],
            [
                'content' => fake()->paragraphs(1, true)
            ]
        ];

        foreach ($params as $data) {
            $response = $this->postJson(
                '/api/post',
                $data,
                [
                    'Authorization' => sprintf('Bearer %s', $token),
                ]
            );

            $response->assertStatus(422);
        }
    }

    /**
     * @return void
     */
    public function testUpdatePostWithValidData(): void
    {
        $email = fake()->unique()->safeEmail();
        $pass = 'password';

        \App\Models\User::factory()->create([
            'email' => $email,
            'password' => $pass
        ]);

        $authResponse = $this->postJson('/api/auth/login', [
            'email' => $email,
            'password' => $pass
        ]);
        $token = $authResponse->getData()?->access_token;

        $post = \App\Models\Post::factory()->create([
            'title' => fake()->sentence(14),
            'content' => fake()->paragraphs(1, true)
        ]);

        $params = [
            'id' => $post->id,
            'title' => fake()->sentence(14),
            'content' => fake()->paragraphs(1, true)
        ];

        $response = $this->putJson(
            '/api/post',
            $params,
            [
                'Authorization' => sprintf('Bearer %s', $token),
            ]
        );

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testUpdatePostWithInvalidData(): void
    {
        $email = fake()->unique()->safeEmail();
        $pass = 'password';

        \App\Models\User::factory()->create([
            'email' => $email,
            'password' => $pass
        ]);

        $authResponse = $this->postJson('/api/auth/login', [
            'email' => $email,
            'password' => $pass
        ]);
        $token = $authResponse->getData()?->access_token;

        $post = \App\Models\Post::factory()->create([
            'title' => fake()->sentence(14),
            'content' => fake()->paragraphs(1, true)
        ]);

        $params = [
            [
                'title' => fake()->sentence(14),
                'content' => fake()->paragraphs(1, true)
            ],
            [
                'id' => $post->id,
                'content' => fake()->paragraphs(1, true)
            ],
            [
                'id' => $post->id,
                'title' => fake()->sentence(14)
            ]
        ];

        foreach ($params as $data) {
            $response = $this->putJson(
                '/api/post',
                $data,
                [
                    'Authorization' => sprintf('Bearer %s', $token),
                ]
            );

            $response->assertStatus(422);
        }
    }

    /**
     * @return void
     */
    public function testGetPostWithAuth(): void
    {
        $email = fake()->unique()->safeEmail();
        $pass = 'password';

        \App\Models\User::factory()->create([
            'email' => $email,
            'password' => $pass
        ]);

        $authResponse = $this->postJson('/api/auth/login', [
            'email' => $email,
            'password' => $pass
        ]);
        $token = $authResponse->getData()?->access_token;

        $post = \App\Models\Post::first();

        $response = $this->get('/api/post/' . $post->id, [
            'Authorization' => sprintf('Bearer %s', $token),
        ]);

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->hasAll(['id', 'post_number', 'created_by', 'title', 'content', 'version', 'is_active', 'created_at', 'updated_at'])
        );
    }

    /**
     * @return void
     */
    public function testGetPostWithInvalidAuth(): void
    {
        $response = $this->get('/api/post/1', [
            'Authorization' => sprintf('Bearer %s', 'token'),
        ]);

        $response->assertStatus(401);
    }

    /**
     * @return void
     */
    public function testGetPostWithoutAuth(): void
    {
        $response = $this->get('/api/post/1');

        $response->assertStatus(401);
    }
}
