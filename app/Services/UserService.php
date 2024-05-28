<?php

namespace App\Services;

use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function update(UserUpdateRequest $request)
    {
        return DB::transaction(function () use ($request) {
            return $request->user()->update($request->all());
        });
    }

    public function show(Request $request)
    {
        return $request->user();
    }
}
