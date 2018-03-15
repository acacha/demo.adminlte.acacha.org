<?php

namespace Tests\Feature;

use Newsletter;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class NewsletterTest.
 *
 * @package Tests\Feature
 */
class NewsletterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_users_can_subscribe_to_newsletter()
    {
        Newsletter::shouldReceive('subscribePending')
            ->once()
            ->with('prova@gmail.com')
            ->andReturn('value'); // Return some value to avoid 422 errors

        $response = $this->post('/newsletter', [ 'email' => 'prova@gmail.com' ]);

        $response->assertStatus(302);
        $response->assertRedirect('/');
        $response->assertSessionHas('msg');
    }

    /** @test */
    public function guest_users_cannot_subscribe_two_times_to_newsletter()
    {
        Newsletter::shouldReceive('subscribePending')
            ->once()
            ->with('prova@gmail.com')
            ->andReturn(null);

        $response = $this->post('/newsletter', [ 'email' => 'prova@gmail.com' ]);

        $response->assertStatus(302);
        $response->assertRedirect('/');
        $response->assertSessionHas('error');
    }



    /** @test */
    public function email_is_required()
    {
        $response = $this->post('/newsletter', [ 'email' => null ]);
        $response->assertStatus(302);

        $response = $this->post('/newsletter', [ 'email' => 'invalidemail' ]);
        $response->assertStatus(302);
    }
}
