<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApproverOrdinatesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'fk_document',
            'date_created',
            'created_by',
            'status',
            'date_approved',
            'approver_remarks',
            'approver_username',
            'page_no',
            'ordinate',
            'order_no',
            'username',
        ];
    }
}
