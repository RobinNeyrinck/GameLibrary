<?php

namespace App\Modules\Services;

use App\Modules\Services\Service;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserService extends Service
{
    protected array $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6',
    ];
    private array $credentialRules = [
        'email' => 'required|string|email',
        'password' => 'required|string',
    ];

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function registerUser($data)
    {
        $this->validate($data, $this->rules);
        if ($this->hasErrors()) {
            return [
                'errors' => $this->getErrors()
            ];
        }

        $data['password'] = Hash::make($data['password']);

        return $this->model->create($data);
    }

    function login($data): ?string
    {
        $validator = Validator::make($data->all(), $this->credentialRules);
        if ($validator->fails()) return null;

        $credentials = $data->only('email', 'password');
        $token = auth()->attempt($credentials);
        return $token;
    }
}
