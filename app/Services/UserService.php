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

    public function update($request, $id)
    {
        $data = $request->all();
        unset($data['avatar']);

        try {
            $user = $this->user->findOrFail($id);

            return $user->update($data);
        } catch(Exception $e) {
            echo "Message: " . $e->getMessage();
        }
    }

    public function insert($request)
    {
        $data = $request->all();

        try {
            return $this->user->create($data);
        } catch(Exception $e) {
            echo "Message: " . $e->getMessage();
        }
    }

    public function delete($id)
    {
        try {
            $user = $this->user->findOrFail($id);

            return $user->delete();
        } catch(Exception $e) {
            echo "Message: " . $e->getMessage();
        }
    }

    public function genders()
    {
        return $this->user->genders();
    }

    public function departments()
    {
        return $this->user->departments();
    }

    public function upload($request)
    {
        $nameAvatar = '';
        if ($request->id) {
            $id = $request->id;
            // upload image
            if (!empty($request->image)) {
                $nameAvatar = uploadImage($request->image, $id);
                try {
                    $user = $this->find($id);
                    $user->update(['avatar' => $nameAvatar]);
                } catch(Exception $e) {
                    echo "Message: " . $e->getMessage();
                }
            }
        }

        return $nameAvatar;
    }
}