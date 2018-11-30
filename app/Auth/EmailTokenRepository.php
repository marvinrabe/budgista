<?php

namespace App\Auth;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EmailTokenRepository
{

    /**
     * Time in seconds it takes to expire tokens.
     * @var int
     */
    protected $expires = 60 * 60;

    /**
     * Returns a token.
     * @param  $string $email
     * @return string
     */
    public function get($email)
    {
        $record = $this->find('email', $email);
        return is_null($record) ? $this->create($email) : $record->token;
    }

    /**
     * Checks if valid token exists and returns token.
     * @param  string $column
     * @param  string $value
     * @return EmailToken|null
     */
    public function find($column, $value)
    {
        $record = $this->getTable()
            ->where($column, $value)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$record) {
            return null;
        }

        $token = new EmailToken($record);

        if ($this->isExpired($token->created_at)) {
            return null;
        }

        return $token;
    }

    /**
     * Create a new token record.
     * @param  string $email
     * @return string
     */
    public function create($email)
    {
        $this->deleteExisting($email);

        $token = $this->createNewToken();

        $this->getTable()->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        return $token;
    }

    /**
     * Delete all existing reset tokens from the database.
     * @param  string $email
     * @return int
     */
    public function deleteExisting($email)
    {
        return $this->getTable()->where('email', $email)->delete();
    }

    /**
     * Delete expired tokens.
     * @return void
     */
    public function deleteExpired()
    {
        $expiredAt = Carbon::now()->subSeconds($this->expires);

        $this->getTable()->where('created_at', '<', $expiredAt)->delete();
    }

    /**
     * Determine if the token has expired.
     * @param  string $createdAt
     * @return bool
     */
    protected function isExpired($createdAt)
    {
        return Carbon::parse($createdAt)->addSeconds($this->expires)->isPast();
    }

    /**
     * Create a new token.
     * @return string
     */
    protected function createNewToken()
    {
        return hash_hmac('sha256', Str::random(40), config('app.key'));
    }

    /**
     * Returns email verification token table.
     * @return \Illuminate\Database\Query\Builder
     */
    protected function getTable()
    {
        return DB::table('email_verifications');
    }

}
