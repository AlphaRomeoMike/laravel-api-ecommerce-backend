<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function Symfony\Component\Translation\t;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test user_can_register_themselves
     *
     * @return void
     */
    public function user_can_register_themselves()
    {
        $this->withExceptionHandling();

        $resposne = $this->post('/v1/register', [
            'name'      => 'Some User',
            'email'     => 'someuser@gmail.com',
            'password'  => 'AlphaVictorCharlie',
            'admin'     => false
        ]);

        $resposne->assertOk();

        $this->assertCount(1, User::all());
    }
}
