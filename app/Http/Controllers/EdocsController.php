<?php

namespace App\Http\Controllers;

use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Http\Requests\EdocsRequest;
use App\Interfaces\ResourceInterface;
use App\Interfaces\EdocsInterface;
// use Symfony\Component\HttpFoundation\File\UploadedFile;


class EdocsController extends Controller
{
    protected $resource_interface;
    protected $edocs_interface;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ResourceInterface $resource_interface,EdocsInterface $edocs_interface) {
        $this->resource_interface = $resource_interface;
        $this->edocs_interface = $edocs_interface;
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
        return $save_document = $this->resource_interface->createOrUpdate( Document::class,$edocs_request->validated(),$edocs_request->document_id);
        // $edocs_request->validate([
        //     'document_file' => 'required|mimes:pdf|max:2048', // Example: only allow PDFs with max 2MB size
        // ]);
        if($edocs_request->hasfile('document_file') ){
            return $this->edocs_interface->uploadFile($edocs_request->document_file,$save_document->data_id);
        }
        // $this->edocs_interface->uploadFile();
    }
    public function readDocumentById(Request $request){
        // return $request->all();
        return $read_document_by_id = $this->resource_interface->readById(Document::class,$request->document_id);
        return Storage::response( 'public/edocs/'. $document_id .'/'. $file_id);

    }

}
