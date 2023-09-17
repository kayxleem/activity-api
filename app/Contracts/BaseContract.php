<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface BaseContract
 * @package App\Contracts
 */
interface BaseContract
{
    /**
     * Create a model instance
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * Update a model instance
     * @param Model $model
     * @param array $attributes
     * @return void
     */
    public function update(Model $model, array $attributes): void;

    /**
     * @param array $where
     * @param array $attributes
     */
    public function updateOrCreate(array $where, array $attributes);

    /**
     * Find one by ID
     * @param string $id
     * @return mixed
     */
    public function find(string $id);

    /**
     * Find based on a different column
     * @param array $data
     * @return mixed
     */
    public function findBy(array $data);

     /**
     * Find one based on a different column
     * @param array $data
     * @return mixed
     */
    public function findOneBy(array $data);

      /**
     * get all the items collection
     *
     * @return Collection of items.
     */
    public function get();

    /**
     * Delete one by Id
     * @param string $id
     * @return bool
     */
    public function delete(string $id);
}
