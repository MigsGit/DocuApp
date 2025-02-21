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
    public function updateWithConditions($model,array $data,array $conditions);
    public function readByID($model,$id);
    public function readOnlyRelationsAndConditions($model,array $data,array $relations,array $conditions);

    // public function readAllWithConditions(array $conditions);
    // public function readAllRelationsAndConditions(array $relations,array $conditions);
    // public function delete($id);
    // public function inactive($id);

}
