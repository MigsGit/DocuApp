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
    public function createOrUpdate( $model,array $data,$id);
    // public function read();
    // public function update($id, array $data);
    // public function delete($id);
    public function readByID($model,$id);
    // public function readAllWithConditions(array $conditions);
    // public function readAllRelationsAndConditions(array $relations,array $conditions);
    // public function inactive($id);

}
