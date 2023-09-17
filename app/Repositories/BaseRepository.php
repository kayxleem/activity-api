<?php

namespace App\Repositories;

use App\Contracts\BaseContract;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseRepository
 *
 * @package \App\Repositories
 */
class BaseRepository implements BaseContract
{
    protected $model;

    public function __construct(Model $model) {
        $this->model = $model;
    }

    /**
     * @param array $attributes
     * @return model
    */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * @param Model $model
     * @param array $attributes
     * @return void
    */
    public function update(Model $model, array $attributes): void
    {
       $model->update($attributes);
    }

    /**
     * @param array $where
     * @param array $attributes
     * @return mixed
     */
    public function updateOrCreate(array $where, array $attributes)
    {
        return $this->model->updateOrCreate($where, $attributes);
    }

    /**
     * @param array $where
     * @param array $attributes
     * @return mixed
     */
    public function firstOrCreate(array $where, array $attributes)
    {
        return $this->model->firstOrCreate($where, $attributes);
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function find(string $id)
    {
        return $this->model->find($id);
    }

     /**
     * @param array $data
     * @return mixed
     */
    public function findBy(array $data)
    {
        return $this->model->where($data)->get();
    }

     /**
     * @param array $data
     * @return mixed
     */
    public function findOneBy(array $data)
    {
        return $this->model->where($data)->first();
    }

     /**
     * get all the items in collection
     *
     * @return Collection of items.
     */
    public function get()
    {
        return $this->model->get();
    }

    /**
     * @param string $id
     * @return bool
     */
    public function delete(string $id): bool|null
    {
        return $this->model->delete($id);
    }

}
