<?php

namespace App\Http\Controllers\Web;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
// use App\Http\Requests\Api\CheckPhoneRequest;
use App\Http\Requests\LoginRequest;
// use App\Http\Requests\Api\UpdateProfileLogoRequest;
use App\Http\Resources\AuthUserResource;
use App\Services\AuthService;
use Exception;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }

    public function login(LoginRequest $request)
    {
        try {
            $remember = isset($request->remember) ? $request->remember:0;
            $user = $this->authService->loginWithEmail(email: $request->email, password: $request->password, remember: $remember);
            if(!$user->is_active)
                return redirect()->back()->with("message", __('app.something_went_wrong'));
            return redirect()->route('home');
        } catch (Exception|NotFoundException $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    }

    // public function profile(): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    // {
    //     try {
    //         $user = Auth::user();

    //         return apiResponse(data: new AuthUserResource($user), message: __('lang.success_operation'));
    //     } catch (\Exception $exception) {
    //         return apiResponse(message: $exception->getMessage(), code: 422);
    //     }
    // }
    // public function updateProfileLogo(UpdateProfileLogoRequest $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    // {
    //     try {
    //         $user = $this->authService->updateProfileLogo(data: $request->Validated());
    //         return apiResponse(data: new AuthUserResource($user), message: __('lang.success_operation'));
    //     } catch (\Exception $exception) {
    //         return apiResponse(message: $exception->getMessage(), code: 422);
    //     }
    // }

    public function logout()
    {

        try {
            $status = $this->authService->logout();
            if($status)
                return redirect()->route('login');
        } catch (Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    }

}
