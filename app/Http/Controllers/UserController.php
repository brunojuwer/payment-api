<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Account;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $users = User::all();
        return UserResource::collection($users);
    }

    public function show(Request $request, string $id): UserResource
    {
        $user = User::findOrFail($id);
        AuthService::checkUserAuthorization($user, $request);
        return new UserResource($user);
    }

    public function store(StoreUpdateUserRequest $request, Account $account): UserResource
    {
        $data = $request->validated();
        $accountType = $data["account_type"];
        unset($data["account_type"]);

        $user = User::create($data);

        $account->createUserAccount($user->id, $accountType);

        return new UserResource($user);
    }

    public function update(Request $request, string $id): UserResource
    {
        $user = User::findOrfail($id);
        AuthService::checkUserAuthorization($user, $request);

        $data = $request->all();
        $user->update($data);

        return new UserResource($user);
    }

    public function destroy(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        AuthService::checkUserAuthorization($user, $request);
        $user->delete();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
