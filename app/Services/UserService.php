<?php

namespace App\Services;

use App\Models\User;
use APp\Models\UserAkses;

class UserService extends Service
{
    public function search($params = [])
    {
        $user = User::orderBy('id');

        $user = $this->searchFilter($params, $user, []);
        return $this->searchResponse($params, $user);
    }

    public function find($value, $column = 'id')
    {
        return User::where($column, $value)->first();
    }

    public function store($params)
    {
        return User::create($params);
    }

    public function update($id, $params)
    {
        $user = User::find($id);
        if (!empty($user)) $user->update($params);
        return $user;
    }

    public function delete($id)
    {
        $user = User::find($id);
        if (!empty($user)) {
            try {
                $user->delete();
                return true;
            } catch (\Exception $e) {
                return ['error' => 'Delete user failed! This user currently being used'];
            }
        }
        return $user;
    }

    public function clean_password($params)
    {
        $password = $params['password'] ?? '';
        if ($password === '') unset($params['password']);
        else $params['password'] = bcrypt($password);
        return $params;
    }

    public function list_akses()
    {
        return array_combine(User::LIST_AKSES, User::LIST_AKSES);
    }

    public function base_routes()
    {
        return User::BASE_ROUTES;
    }
}
