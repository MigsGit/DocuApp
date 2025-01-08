<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApproverOrdinates extends Model
{
    protected $connection = 'mysql';
    protected $table = "approver_ordinates";

    /**
     * Get the user associated with the ApproverOrdinates
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'approver_id');
    }
}
