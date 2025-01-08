<?php

namespace App\Models;

use App\Models\ApproverOrdinates;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{

    /**
     * Get all of the ApproverOrdinates for the Document
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function approver_ordinates()
    {
        return $this->hasMany(ApproverOrdinates::class, 'fk_document', 'id');
    }

}
