<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Interfaces\UserServiceInterface;

class UserController extends Controller
{
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    //
    public function index(Request $request)
    {
        $users = $this->userService->listUser($request);
       
        return $users;
    }
}
