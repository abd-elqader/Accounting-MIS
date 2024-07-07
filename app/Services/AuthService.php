<?php

namespace App\Services;

use App\Enum\ImageTypeEnum;
use App\Models\ResetCodePassword;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\NotFoundException;
use App\Enum\UserTypeEnum;
use App\Events\PushEvent;
use App\Models\FcmMessage;
use Carbon\Carbon;

use function Laravel\Prompts\password;

class AuthService extends BaseService
{

    public function loginWithEmail(string $email, string $password, bool $remember = false) :User|Model
    {
        $credential = ['email'=>$email,'password'=>$password/*, 'type'=>[UserTypeEnum::MANAGER, UserTypeEnum::EMPLOYEE]*/];
        if (!auth()->attempt(credentials: $credential, remember: $remember))
            return throw new NotFoundException(__('lang.login_failed'));
        $user = User::where('email', $email)->first();
        // $user->device_token = $deviceToken;
        // $user->save();

        return $user;
    }


    // public function checkPhone(string $phone) :bool
    // {
    //     $user = User::where('phone', $phone)->whereIn('type', [UserTypeEnum::CLIENT, UserTypeEnum::SUPERVISOR])->first();

    //     if ($user)
    //         return true;

    //     return false;
    // }


    public function logout(): bool
    {
        $user =  auth::user();
        // Auth::user()->tokens()->delete();
        Auth::logout();
        return true;
    }

    public function getAuthUser()
    {
        return auth('sanctum')->user();
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }

    // public function updateProfileLogo(array $data)
    // {
    //     $user = Auth::user();
    //     if (isset($data['logo']))
    //     {
    //         $user->clearMediaCollection('users');
    //         $user->addMediaFromRequest('logo')->toMediaCollection('users');
    //     }
    //     return $user;

    // }
}
