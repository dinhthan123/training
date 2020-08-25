<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Services\Interfaces\UserServiceInterface;
use Response;

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

    public function getGenders()
    {
        $genders = $this->userService->genders();

        return Response::json($genders);
    }

    public function getDepartments()
    {
        $departments = $this->userService->departments();

        return Response::json($departments);
    }

    public function show($id)
    {
        $findUser = $this->userService->find($id);

        return $findUser;
    }

    public function update(EditUserRequest $request, $id)
    {
        $response = $this->userService->update($request, $id);

        return Response::json($response);
    }

    public function store(AddUserRequest $request)
    {
        $response = $this->userService->insert($request);

        return Response::json($response);
    }

    public function destroy($id)
    {
        $response = '';

        if ($this->userService->delete($id)) {
            $response = 'success';
        }

        return Response::json($response);
    }

    public function uploadAvatar(Request $request)
    {
        $response = $this->userService->upload($request);

        return $response;
    }
}
