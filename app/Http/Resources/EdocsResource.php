<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EdocsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => encrypt($this->id), // Encrypt ID for security
            // 'id' => $this->id, // Encrypt ID for security
            'date_created' =>$this->date_created,
            'created_by' =>$this->created_by,
            'category_id' =>$this->category_id,
            'status' =>$this->status,
            'document_name' =>$this->document_name,
            'filtered_document_name' =>$this->filtered_document_name,
            'page_count' =>$this->page_count,
            'remarks' =>$this->remarks,
            'approval_order' =>$this->approval_order,
            'view_access_users' =>$this->view_access_users,
            'dcc_status' =>$this->dcc_status,
            'username' =>$this->username,
            'deleted_at' =>$this->deleted_at,
        ];

    }
}
