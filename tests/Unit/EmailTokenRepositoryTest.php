<?php

namespace Tests\Unit;

use App\Auth\EmailToken;
use App\Auth\EmailTokenRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmailTokenRepositoryTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @var EmailTokenRepository
     */
    protected $repository;

    public function setUp()
    {
        parent::setUp();
        $this->repository = new EmailTokenRepository();
    }

    /** @test */
    public function it_returns_a_token()
    {
        $token = $this->repository->get('test@example.com');

        $this->assertNotEmpty($token);
    }

    /** @test */
    public function it_returns_same_token_twice()
    {
        $firstToken = $this->repository->get('test@example.com');
        $secondToken = $this->repository->get('test@example.com');

        $this->assertEquals($firstToken, $secondToken);
    }

    /** @test */
    public function it_stores_tokens_in_database()
    {
        $token = $this->repository->get('test@example.com');

        $this->assertDatabaseHas('email_verifications', [
            'email' => 'test@example.com',
            'token' => $token
        ]);
    }

    /** @test */
    public function it_returns_token_record()
    {
        $email = 'test@example.com';
        $token = $this->repository->get($email);
        $record = $this->repository->find('token', $token);

        $this->assertInstanceOf(EmailToken::class, $record);
        $this->assertEquals($email, $record->email);
        $this->assertEquals($token, $record->token);
    }
}
