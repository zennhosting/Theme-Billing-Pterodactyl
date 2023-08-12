<?php

namespace Pterodactyl\Http\Controllers\Auth;

use Laravel\Socialite\Facades\Socialite;
use Pterodactyl\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Bill;
class SocialLoginController extends AbstractLoginController
{

    public function Driver($driver)
    {
        if(!Bill::allowed('socialite')) {
            return $this->denied();
          }

        if($driver == "github" OR $driver == "google" OR $driver == "discord" OR $driver == "whmcs") {
        return Socialite::driver($driver)->redirect();
        }
        else {
            return "Selected driver is not supported";
        }

    }

    public function DriverCallback($driver)
    {
        $service = Socialite::driver($driver)->user();

        if (User::where('email', '=', $service->getEmail())->exists()) {
            $getUser = User::where('email', $service->getEmail())->first();
            Auth::loginUsingId($getUser->id);
        } else {
            if(config('billing.socialite.create_account')) {
                $this->CreateNewAccount($service, $driver);
            }
        }

        return redirect('/account');
    }

    private function CreateNewAccount($service, $driver) 
    {
        $email = $service->getEmail();
        if(!$service->getNickname()) { $username =  $service->getName(); } else { $username =  $service->getNickname(); }
        
        $username = str_replace(' ', '', $username);
        $username = preg_replace("/[^a-zA-Z0-9]+/", "", $username);

        $user = new User();
        $user->name = $username;
        $user->email = $email;
        $user->name_first = $username;
        $user->name_last = $username;
        $user->language = 'en';
        $user->password = mb_substr(Hash::make($username . time() . $email . substr(md5(mt_rand()), 0, 7)), 0, 10);
        $user->save();
        Auth::loginUsingId($user->id);

        // $res = Artisan::call("p:user:make --email={$email} --username={$username} --name-first={$username} --name-last={$driver} --admin=0 --no-password");
        // $getUser = User::where('email', $service->getEmail())->first();
        // Auth::loginUsingId($getUser->id);
        

    }

    private function denied()
    {
      return redirect()->back()->withError('You have discovered a Premium Feature, to access upgrade your plan. Upgrade here: https://wemx.net/pricing');
    }


}