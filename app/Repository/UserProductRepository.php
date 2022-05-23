<?php

namespace App\Repository;


use App\Http\Controllers\API\V1\ResponseBuilder;
use App\Http\Interfaces\ProductRepositoryInterface;
use App\Http\Interfaces\UserRepositoryInterface;
use App\Http\Resources\UserResource;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Class User Product Repository.
 */
class UserProductRepository implements UserRepositoryInterface
{

    /**
     * Get UserModel.
     *
     * @var  UserModel
     *
     */
    protected $user;

    public function __construct(UserModel $user)
    {
        $this->user = $user;
    }

    /**
     * Get All Users.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = $this->user->latest()->get();

        return ResponseBuilder::success(UserResource::collection($user));
    }

    /**
     * Show User Information.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = $this->user->findOrFail($id);

        return ResponseBuilder::success(UserResource($user));
    }

    /**
     * add user in the system.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($request)
    {
        $user = $this->user->create([
            'image' => $request->hasFile('image') ? upload_image('users', $request->file('image')) : null,
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'type' => $request->input('type'),
            'password' => bcrypt($request->input('password'))
        ]);

        return ResponseBuilder::success(null, 'Added successfully');
    }

    /**
     * Update User Information.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($request, $id)
    {
        $user = $this->user->findOrFail($id);

        $user->update([
            'image' => $request->hasFile('image') ? upload_image('users', $request->file('image')) : $user->image,
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'type' => $request->input('type'),
            'password' => bcrypt($request->input('password')),
        ]);

        return ResponseBuilder::success(null, 'Updated successfully');
    }

    /**
     * Delete User.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $user = $this->user->findOrFail($id);

        if ($user->image) {
            $image = Str::after($user->image, 'storage/users/');

            #delete from folder
            Storage::disk('public')->delete('users/' . $image);
        }

        if ($user->delete()) {
            return ResponseBuilder::success(null, 'Deleted successfully');
        }
    }

}
