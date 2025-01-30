<?php

namespace App\Interfaces;

interface EdocsInterface
{
    /**
     * Create a interface
     *
     * @param $model,array $data
     */
    public function uploadFile($temp_file,$id);
    // public function read();
    // public function update($id, array $data);
    // public function delete($id);
    // public function readByID($id);
    // public function readAllWithConditions(array $conditions);
    // public function readAllRelationsAndConditions(array $relations,array $conditions);
    // public function inactive($id);

}
