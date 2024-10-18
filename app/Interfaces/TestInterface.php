<?php

namespace App\Interfaces;

interface TestInterface
{
    /**
     * Create a interface
     *
     * @param $model
     * @param array $data
     */
    public function create($model,array $data);
    // public function read();
    // public function update($id, array $data);
    // public function delete($id);
    // public function readByID($id);
    // public function readAllWithConditions(array $conditions);
    // public function readAllRelationsAndConditions(array $relations,array $conditions);
    // public function inactive($id);

}
