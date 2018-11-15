<?php

namespace Tests\Feature;

use App\Auth\EmailTokenRepository;
use App\Models\User;
use App\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sends_email_verification_notifications()
    {
        /**
         * @var User $user
         */
        $user = factory(User::class)->create();

        Notification::fake();

        $user->sendEmailVerificationNotification();

        Notification::assertSentTo($user, VerifyEmail::class);
    }

    /** @test */
    public function it_verifies_user()
    {
        /**
         * @var User $user
         */
        $user = factory(User::class)->create();

        $repository = new EmailTokenRepository();
        $token = $repository->get($user->email);

        $this->put('/api/auth/verify/' . $token)->assertSuccessful();

        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }
}
