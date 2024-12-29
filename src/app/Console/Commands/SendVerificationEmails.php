<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendVerificationEmails extends Command
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-verification-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '認証が済んでいないユーザーにメールを送信します。';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $unverifiedUsers = User::whereNull('email_verified_at')->get();

        foreach ($unverifiedUsers as $user) {
            Mail::to($user->email)->send(new VerificationEmail($user));
            $this->info('Verification email sent to', $user->email);
        }

        return 0;
    }
}
