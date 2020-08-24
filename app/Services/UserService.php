<?php

namespace App\Services;

use Request;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use App\Services\Interfaces\UserServiceInterface;


class UserService implements UserServiceInterface
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function listUser($request, $perPage = User::PERPAGE)
    {
        $searchParams = ['search' => $request->keywords ? $request->keywords : null];

        $query = $this->user->select('users.*');

        if (!empty($searchParams['search'])) {
            $s = $searchParams['search'];
            $query->where(function($q) use($s){
                $q->where('users.name', 'LIKE', '%'.$s.'%')
                ->orWhere('users.email', 'LIKE', '%'.$s.'%');
            });
        }

        $users = $query->orderBy('created_at', 'asc')->paginate($perPage);

        return UserResource::collection($users);
    }

    public function find($id)
    {
        $user = $this->user->findOrFail($id);

        return $user;
    }
}