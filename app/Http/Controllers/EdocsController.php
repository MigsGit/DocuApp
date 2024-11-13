<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Document;

use App\Services\PdfService;
use Illuminate\Http\Request;

use Yajra\DataTables\DataTables;
use App\Interfaces\EdocsInterface;
use App\Http\Requests\EdocsRequest;
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

    /**
      * Create
     * @param $edocs_request
     */
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
            $arr_upload_file = $this->edocs_interface->uploadFile($edocs_request->document_file,$document_id);
            $this->resource_interface->update( Document::class,$document_id,$arr_upload_file);
        }
        return response()->json(['is_success' => 'true']);
    }

    public function get_module(Request $request){
        date_default_timezone_set('Asia/Manila');

        try {
            $document = Document::all();
            return DataTables::of($document)
            ->addColumn('get_action',function($row){
                // return $row->id;
                return $btn = '<button data-id = "'.$row->id.'"  class="btn btn-outline-info btn-sm" data-toggle="modal" id="btnEdocs" type="button" title="Edit"><i class="fas fa-edit"></i></button>';
                // return $btn = '<button data-id = "'.$row->id.'" id="editResProcedure" type="button" class="btn btn-info btn-sm" title="Edit"></i>Edit</button>';
            })
            ->rawColumns(['get_action'])
            ->make(true);
        } catch (Exception $e) {
            return response()->json(['is_success' => 'false', 'exceptionError' => e->getMessage()]);
        }
    }

    public function readDocumentById(Request $request){
        // return $request->all();
        try {
            $read_document_by_id = $this->resource_interface->readById(Document::class,$request->document_id);
            $page_count = $this->pdf_service->getPageCount(storage_path('app/' . 'public/edocs/'. $read_document_by_id[0]->id .'/'. $read_document_by_id[0]->filtered_document_name));

            return response()->json(['is_success' => 'true', 'read_document_by_id' => $read_document_by_id , 'page_count' => $page_count]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function readApproverNameById(Request $request){
        // return $request->all();
        try {
            $read_approver_by_id = $this->resource_interface->readById(User::class,$request->approver_id);
            return response()->json(['is_success' => 'true','read_approver_by_id' => $read_approver_by_id]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function readApproverName(Request $request){
        try {
            $read_approver_by_id = $this->resource_interface->read(User::class);
            return response()->json(['is_success' => 'true','read_approver_by_id' => $read_approver_by_id]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }


     /**
     * @param $request Handle PDF upload and convert a specific page to an image.
     */
    public function convertPdfToImageByPageNumber(Request $request)
    {
        try {
            $request->validate([
                // 'pdf' => 'required|mimes:pdf|max:2048',
                'select_page' => 'required|integer|min:1',
            ]);

            $documents = Document::where('id',$request->document_id)->get();
            $pageNumber = $request->input('select_page');
            $filePath = storage_path('app/public/edocs/'.$documents[0]->id.'/'.$documents[0]->filtered_document_name);
            $outputDir = storage_path('app/public/images');
            // Convert PDF page to image
            $imagePath = $this->pdf_service->convertPdfPageToImageTest($filePath, $pageNumber-1, $outputDir);
            return response()->json($imagePath);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function showPdf(Request $request){
        /**
         * TODO: get image employee number to DB
         * TODO: get file path, ordinates and page DB
         */
        $imagePath = storage_path('app/public/images/R152.png');
        // $filePath = storage_path('app/public/edocs/'.$documents[0]->id.'/'.$documents[0]->filtered_document_name);
        // $pdfPath = storage_path('app/public/edocs/1'.'/'.'0_updated_crud_ypics_as_of_september_2024.pdf');
        $pdfPath = storage_path('app/public/edocs/6'.'/'.'0_0_soa_2024_0001_pricon_january_2024.pdf');
        // $this->pdf_service->insertImageAtCoordinates($pdfPath, $imagePath, $request->x, $request->y, 1);
        // $insert_image_at_coordinates = $this->pdf_service->insertImageAtCoordinates($pdfPath, $imagePath, '0.4472630173564753', '0.563177771783113', 1);
        $this->pdf_service->insertImageAtCoordinates($pdfPath, $imagePath, '0.6995994659546061', '0.6158306285039835', 1);
    }

}
