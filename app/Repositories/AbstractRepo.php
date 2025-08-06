<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class AbstractRepo
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(array $columns = ['*']): Collection
    {
        return $this->model->select($columns)->get();
    }

    public function find(string $id, array $columns = ['*']): ?Model
    {
        return $this->model->select($columns)->find($id);
    }

    public function findOrFail(string $id, array $columns = ['*']): Model
    {
        return $this->model->select($columns)->findOrFail($id);
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update(string $id, array $data): bool
    {
        return $this->model->where('id', $id)->update($data);
    }

    public function delete(string $id): bool
    {
        return $this->model->destroy($id) > 0;
    }

    public function paginate(int $page = 1, array $columns = ['*'], int $size = 10): LengthAwarePaginator
    {
        return $this->model->paginate($size, $columns, 'page', $page);
    }

    public function where(array $conditions, array $columns = ['*']): Collection
    {
        $query = $this->model->select($columns);
        
        foreach ($conditions as $field => $value) {
            if (is_array($value)) {
                $query->whereIn($field, $value);
            } else {
                $query->where($field, $value);
            }
        }
        
        return $query->get();
    }

    public function whereFirst(array $conditions, array $columns = ['*']): ?Model
    {
        $query = $this->model->select($columns);
        
        foreach ($conditions as $field => $value) {
            if (is_array($value)) {
                $query->whereIn($field, $value);
            } else {
                $query->where($field, $value);
            }
        }
        
        return $query->first();
    }

    public function count(): int
    {
        return $this->model->count();
    }

    public function orderBy(string $column, string $direction = 'asc', array $columns = ['*']): Collection
    {
        return $this->model->select($columns)->orderBy($column, $direction)->get();
    }

    public function latest(string $column = 'created_at', int $limit = null, array $columns = ['*']): Collection
    {
        $query = $this->model->select($columns)->latest($column);
        
        if ($limit) {
            $query->limit($limit);
        }
        
        return $query->get();
    }
}