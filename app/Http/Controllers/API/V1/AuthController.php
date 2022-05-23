<?php

namespace App\Http\Controllers\API\V1;

use App\Constants\ErrorCodes;
use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Models\User as UserModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Enum;
use Validator;

/**
 * Authenticator Controller for Users Login And Register And Logout
 */
class AuthController extends Controller
{

    /**
     * Get UserModel.
     * @var UserModel
     */
    protected $user;

    public function __construct(UserModel $user)
    {
        $this->user = $user;
    }

    /**
     * Login Users In The System.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return ResponseBuilder::error($validator->errors()->first(), 422, ErrorCodes::VALIDATION);
        }

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $tokenResult = $user->createToken('appToken');
            $token = $tokenResult->token;
            $token->expires_at = Carbon::now()->addMonths(3);
            $token->save();

            return ResponseBuilder::success(['access_token' => 'Bearer ' . $tokenResult->accessToken,], ('You have successfully logged in'));
        }

        return ResponseBuilder::error('Data does not match');
    }


    /**
     * Register Users In The System.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'username' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'type' => ['required', new Enum(UserType::class)],
            'image' => 'nullable|mimes:jpg,jpeg,png,gif|max:5000',
            'password' => 'required|confirmed|min:8',
        ]);
        if ($validator->fails()) {
            return ResponseBuilder::error($validator->errors()->first(), 422, ErrorCodes::VALIDATION);
        }

        if ($request->hasFile('image')) {
            ###helper###
            $url = upload_image('users', $request->image);
        }

        $user = $this->user->create([
            'image' => $url,
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'type' => $request->input('type'),
            'password' => bcrypt($request->input('password'))
        ]);

        $tokenResult = $user->createToken('appToken');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addMonths(12);
        $token->save();

        return ResponseBuilder::success(['access_token' => $tokenResult->accessToken], 'You have been successfully registered');
    }

    /**
     * Logout User.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function logout(Request $request)
    {
        $token = auth()->user()->token()->revoke();
        return ResponseBuilder::success(null, 'You have been logged out successfully!', 200);
    }

}
