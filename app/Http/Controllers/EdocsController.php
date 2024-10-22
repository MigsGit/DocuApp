<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

use App\Models\Document;
use App\Services\PdfService;

use App\Http\Requests\EdocsRequest;
use App\Interfaces\EdocsInterface;
use App\Interfaces\ResourceInterface;
use Illuminate\Support\Facades\Storage;
// use Symfony\Component\HttpFoundation\File\UploadedFile;


class EdocsController extends Controller
{
    protected $resource_interface;
    protected $edocs_interface;

    protected $pdf_service;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ResourceInterface $resource_interface,EdocsInterface $edocs_interface,PdfService $pdf_service) {
        $this->resource_interface = $resource_interface;
        $this->edocs_interface = $edocs_interface;
        $this->pdf_service = $pdf_service;
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
        // return $save_document = $this->resource_interface->createOrUpdate( Document::class,$edocs_request->validated(),$edocs_request->document_id);
        // $edocs_request->validate([
        //     'document_file' => 'required|mimes:pdf|max:2048', // Example: only allow PDFs with max 2MB size
        // ]);
        $document_id = $edocs_request->document_id;
        if( isset( $document_id ) ){
            $this->resource_interface->update( Document::class,$document_id,$edocs_request->validated());
        }else{
            $save_document = $this->resource_interface->create( Document::class,$edocs_request->validated());
            $document_id = $save_document->data_id;
        }

        if($edocs_request->hasfile('document_file') ){
            return $this->edocs_interface->uploadFile($edocs_request->document_file,$document_id);
        }
    }
    public function readDocumentById(Request $request){
        // return $request->all();
        $read_document_by_id = $this->resource_interface->readById(Document::class,$request->document_id);
        // return $read_document_by_id[0]->id;
        // return $read_document_by_id[0]->filtered_document_name;
        // return Storage::response( 'public/edocs/'. $read_document_by_id[0]->id .'/'. $read_document_by_id[0]->filtered_document_name);

        try {
        } catch (\Throwable $th) {
            //throw $th;
        }

    }

}
