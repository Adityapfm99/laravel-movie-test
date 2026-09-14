<?php

namespace Tests\Feature;

use Tests\TestCase;

class MovieAppTest extends TestCase
{
    public function test_login_requires_valid_credentials(): void
    {
        $response = $this->post('/login', [
            'username' => 'wrong',
            'password' => 'wrong',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('error', 'Invalid username or password.');
    }

    public function test_valid_login_redirects_to_movies(): void
    {
        $response = $this->post('/login', [
            'username' => 'aldmic',
            'password' => '123abc123',
        ]);

        $response->assertRedirect('/movies');
        $this->assertTrue(session()->has('user'));
    }

    public function test_detail_page_displays_full_movie_metadata(): void
    {
        $response = $this->withSession(['user' => ['username' => 'aldmic']])
            ->get('/movies/tt3896198');

        $response->assertOk();
        $response->assertSee('Guardians of the Galaxy: Vol. 2');
        $response->assertSee('Released');
        $response->assertSee('Writer');
        $response->assertSee('IMDb Votes');
    }
}
