<?php

namespace App\Interfaces;

interface MailerInterface
{
    /**
     * Create a interface
     *
     * @param $model,array $data
     */
    public function uploadFile($temp_file,$id);
    
}
