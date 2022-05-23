<?php

namespace App\Http\Controllers\API\V1;

use App\Constants\ErrorCodes;
use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;
use Laravel\Passport\Bridge\UserRepository;
use Validator;

/**
 * User Controller for Crud User
 */
class UserController extends Controller
{

    /**
     * @var UserRepositoryInterface UserRepositoryInterface
     */
    protected $user;

    public function __construct(UserRepositoryInterface $user)
    {
        $this->user = $user;
    }

    /**
     * Get index method from Repository.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->user->index();
    }

    /**
     * Get show method from Repository
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return $this->user->show($id);
    }

    /**
     * Get store method from Repository
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if (Auth::user()->type != UserType::Normal->value) {

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

            return $this->user->store($request);

        }
        return ResponseBuilder::error('Something went wrong');
    }

    /**
     * Get update method from Repository
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function update(Request $request, $id)
    {
        if (Auth::user()->type != UserType::Normal->value && Auth::user()->id == $id) {

            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'username' => 'required|string',
                'email' => 'required|email|unique:users,email,' . $id,
                'type' => ['required', new Enum(UserType::class)],
                'image' => 'nullable|mimes:jpg,jpeg,png,gif|max:5000',
                'password' => 'required|confirmed|min:8',
            ]);

            if ($validator->fails()) {
                return ResponseBuilder::error($validator->errors()->first(), 422, ErrorCodes::VALIDATION);
            }

            return $this->user->update($request, $id);
        }

        return ResponseBuilder::error('Something went wrong');
    }

    /**
     * Get destroy method from Repository
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if (Auth::user()->type != UserType::Normal->value && Auth::user()->id == $id) {

            return $this->user->destroy($id);
        }

        return ResponseBuilder::error('Something went wrong');
    }


}
