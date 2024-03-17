<?php

namespace App\Modules\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

abstract class Service
{
    protected Model $model;
    protected array $rules;
    protected array $errors;
    protected ?Model $result;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->errors = [];
    }

    protected function validate($data, $id = false): void
    {
        $this->validateId($id);

        if ($this->hasErrors()) return;

        $this->validateData($data);
    }

    public function hasErrors(): bool
    {
        return count($this->errors) > 0;
    }

    protected function validateId($id): void
    {
        if (!$id) return;

        $result = $this->model->find($id);
        if (!$result) {
            $this->result = null;
            $this->errors = ['record' => 'not found'];
        }
    }

    private function validateData($data): void
    {
        $validator = Validator::make($data, $this->rules);

        if ($validator->fails()) {
            $this->result = null;
            $this->errors = $validator->errors()->toArray();
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    protected function getResult(): ?Model
    {
        return $this->result;
    }
}
