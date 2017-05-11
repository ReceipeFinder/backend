<?php
namespace App\Http\Controllers;

use App\FacebookService;
use Socialite;

class LoginController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @param FacebookService $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback(FacebookService $service)
    {
        $socialiteUser = Socialite::driver('facebook')->user();

        $user = $service->firstOrCreate($socialiteUser->getId(), $socialiteUser->getEmail(), $socialiteUser->getName());

        auth()->login($user);

        return redirect()->to('/');
    }
}