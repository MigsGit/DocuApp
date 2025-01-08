<?php

namespace App\Interfaces;

interface ResourceInterface
{
    /**
     * Create a interface
     *
     * @return void
     */
    public function create($model,array $data);
    public function createOrUpdate( $model,$data_id,array $data);
    public function read($model);
    public function update($model,$id,array $data);
    // public function delete($id);
    public function readByID($model,$id);
    // public function readAllWithConditions(array $conditions);
    // public function readAllRelationsAndConditions(array $relations,array $conditions);
    public function readOnlyRelationsAndConditions($model,array $data,array $relations,array $conditions);
    // public function inactive($id);

}
