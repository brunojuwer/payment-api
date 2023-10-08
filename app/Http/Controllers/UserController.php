<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Account;
use App\Models\User;
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

    public function show(string $id): UserResource
    {

        $user = User::findOrFail($id);
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
        $data = $request->all();
        $user->update($data);

        return new UserResource($user);
    }

    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
