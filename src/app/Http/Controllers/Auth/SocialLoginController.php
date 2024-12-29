<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SocialLoginController extends Controller
{
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleGithubCallback()
    {
     
     try{

            $githubUser = Socialite::driver('github')->user();

             $user = User::updateOrCreate(
                [
                    'email' => $githubUser->getEmail(),
                ],
                [
                    'name' => $githubUser->getNickname(),
                    'github_id' => $githubUser->id,
                    'password' => Hash::make($githubUser->id),
                ],
            );

            Auth::login($user, true);
            return redirect()->route('posts.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect('/login')->with('error', 'GitHubログインに失敗しました');
        }
    }
}