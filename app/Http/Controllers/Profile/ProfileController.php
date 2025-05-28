<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    /**
     * Retrieve the account information for a user.
     *
     * @param Request $request The HTTP request object.
     *
     * @return UserResource The user resource representing the account information.
     */
    public function show(
        Request $request
    ): UserResource {

        return UserResource::make(
            $request->user()
        )
            ->additional([
                'message' => null,
                'status' => Response::HTTP_OK
            ]);
    }
 }

