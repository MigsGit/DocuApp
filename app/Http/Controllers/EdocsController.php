<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Requests\EdocsRequest;
use App\Interfaces\ResourceInterface;

class EdocsController extends Controller
{
    protected $resource_interface;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ResourceInterface $resource_interface) {
        $this->resource_interface = $resource_interface;
    }

    public function get_module(Request $request){
        date_default_timezone_set('Asia/Manila');

        try {
            $document = Document::all();
            return DataTables::of($document)
            ->addColumn('get_action',function($row){
                // return $row->id;
                return $btn = '<button data-id = "'.$row->id.'"  class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#modalSave" id="btnEdocs" type="button" title="Edit"><i class="fas fa-edit"></i></button>';
                // return $btn = '<button data-id = "'.$row->id.'" id="editResProcedure" type="button" class="btn btn-info btn-sm" title="Edit"></i>Edit</button>';
            })
            ->rawColumns(['get_action'])
            ->make(true);
        } catch (Exception $e) {
            return response()->json(['is_success' => 'false', 'exceptionError' => e->getMessage()]);
        }
    }
    public function saveDocument(EdocsRequest $edocs_request){
        // return $edocs_request->validated();
        return $this->resource_interface->create( Document::class,$edocs_request->validated());
        date_default_timezone_set('Asia/Manila');
        DB::beginTransaction();
        try {
            DB::commit();
            return response()->json(['is_success' => 'true']);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['is_success' => 'false', 'exceptionError' => $e->getMessage()]);
        }
    }
}
