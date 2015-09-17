<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\UserRepository;
use App\Models\User;
use App\Repositories\Exceptions\RepositoryException;
use Illuminate\Support\MessageBag;
use Validator;

/**
 * Class UserRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function findById($id) {
        $user = $this->model->find($id);

        if (! $user) {
            $messageBag = new MessageBag(array("User does not exists (id = {$id})"));
            throw new RepositoryException($messageBag);
        }

        return $user;
    }

    public function create(array $input) {
        $validator = Validator::make($input, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'role' => 'required|max:255',
        ]);

        if ($validator->fails())
        {
            throw new RepositoryException($validator->messages());
        }

        $input['password'] = bcrypt($input['password']);

        $user = parent::create(array_except($input, ['role']));

        $user->roles()->attach($input['role']);

        return $user;
    }
}