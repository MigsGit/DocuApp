<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Document;
use App\Services\PdfService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\ApproverOrdinates;
use App\Interfaces\EdocsInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EdocsRequest;
use App\Interfaces\CommonInterface;
use App\Http\Resources\EdocsResource;
use App\Interfaces\ResourceInterface;
use Illuminate\Support\Facades\Cache;
use App\Interfaces\PdfCustomInterface;
use Illuminate\Support\Facades\Storage;


class EdocsController extends Controller
{
    protected $resource_interface;
    protected $edocs_interface;
    protected $pdf_service;
    protected $common_interface;
    protected $pdf_custom_interface;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        ResourceInterface $resource_interface,EdocsInterface $edocs_interface,
        PdfCustomInterface $pdf_custom_interface,CommonInterface $common_interface,
        PdfService $pdf_service
    ) {
        $this->resource_interface = $resource_interface;
        $this->edocs_interface = $edocs_interface;
        $this->pdf_service = $pdf_service;
        $this->pdf_custom_interface = $pdf_custom_interface;
        $this->common_interface = $common_interface;
    }

    public function saveDocument(EdocsRequest $edocs_request){

        date_default_timezone_set('Asia/Manila');
        DB::beginTransaction();
        try {
            $edocs_request->all();
            $document_id = decrypt($edocs_request->document_id);
            if( isset( $document_id ) ){
                $fk_document = $this->resource_interface->update( Document::class,$document_id,$edocs_request->validated());
            }else{
                //TODO : DELETE THE APPROVER Coordinates
                $save_document = $this->resource_interface->create( Document::class,$edocs_request->validated());
                $document_id = $save_document->data_id;
            }
            $conditions = [
                'fk_document' => $document_id
            ];
            $getApproverOrdinates = $this->resource_interface->readOnlyRelationsAndConditions(ApproverOrdinates::class,[],[],$conditions);

            if( count( $getApproverOrdinates ) != 0   ){
                ApproverOrdinates::where('fk_document',$document_id)->delete();
            }

            foreach ($edocs_request->approver_name as $key => $value) {
                $request_validated = [
                    'fk_document'  => $document_id,
                    'approver_id' => $edocs_request->approver_name[$key],
                    'page_no' => $edocs_request->selected_page[$key],
                    'ordinates' => $edocs_request->ordinates[$key],
                ];
                $this->resource_interface->create( ApproverOrdinates::class,$request_validated);
            }
            if($edocs_request->hasfile('document_file') ){
                $arr_upload_file = $this->edocs_interface->uploadFile($edocs_request->document_file,$document_id);
                $this->resource_interface->update( Document::class,$document_id,$arr_upload_file);
            }
            DB::commit();
            return response()->json(['is_success' => 'true']);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['is_success' => 'false', 'exceptionError' => $e->getMessage()]);
        }
    }

    public function loadEdocs(Request $request){
        date_default_timezone_set('Asia/Manila');
        try {
            // $edocs_resource= EdocsResource::collection( Document::all());// Secure API response
            // Cache::tags(['edocs_resource'])->flush();
            $edocs_resource = Cache::remember('edocs_resource', now()->addMinutes(10), function () {
                return EdocsResource::collection( Document::all());
            });
            return DataTables::of($edocs_resource)
            ->addColumn('get_action',function($row){
                $result = '';
                $result .= '<button data-id = "'.$row['id'].'"  class="btn btn-outline-info btn-sm" data-toggle="modal" id="btnEdocs" type="button" title="Edit"><i class="fas fa-edit"></i></button>';
                $result .= '<button data-id = "'.$row['id'].'"  class="btn btn-outline-success btn-sm" data-toggle="modal" id="btnEdocsView" type="button" title="Approval"><i class="fas fa-eye"></i></button>';
                return $result;
                // return $btn = '<button data-id = "'.$row->id.'" id="editResProcedure" type="button" class="btn btn-info btn-sm" title="Edit"></i>Edit</button>';
            })
            ->rawColumns(['get_action'])
            ->make(true);
        } catch (Exception $e) {
            return response()->json(['is_success' => 'false', 'exceptionError' => e->getMessage()]);
        }
    }
    public function loadApproverByDocId(Request $request){
        date_default_timezone_set('Asia/Manila');
        try {
            $document_id = ( isset($request->document_id) ) ? decrypt($request->document_id) : 0;
            $data = '';
            $relations = [
                'user'
            ];
            $conditions = [

                'fk_document' => $document_id
                // 'fk_document' => 6
            ];
            $read_document_by_id = $this->resource_interface->readOnlyRelationsAndConditions(ApproverOrdinates::class,$data,$relations,$conditions);
            return DataTables::of($read_document_by_id)
            // ->addIndexColumn() // This automatically adds a "DT_RowIndex"
            // ->addColumn('get_num',function($row){
            //      return $row->DT_RowIndex; // Return the row number
            // })
            ->addColumn('get_num', function ($row) use (&$count) {//& Increments and keeps track across all rows
                $result = '';
                return $result .= ++$count;
            })
            ->addColumn('get_status',function($row){
                $result = '';
                switch ($row->status) {
                    case 'PE':
                        # code...
                        $bg_color = 'bg-warning text-white';
                        $status = 'PENDING';
                        break;
                    case 'AP':
                        # code...
                        $bg_color = 'bg-success text-white';
                        $status = 'APPROVED';
                        break;
                    case 'DIS':
                        # code...
                        $bg_color = 'bg-danger text-white';
                        $status = 'DISAPPROVED';
                        break;
                    case 'CAN':
                        # code...
                        $bg_color = 'bg-danger text-white';
                        $status = 'CANCELLED';
                        break;
                    default:
                        # code...
                        break;
                }
                $result .='<span class="badge '.$bg_color.'"> '.$status.' </span>';
                return $result;
            })
            ->addColumn('get_approver_name', function ($row) {
                $result = '';
                return $result .= $row['user']->name;
            })
            ->rawColumns(['get_num','get_status','get_approver_name'])
            ->make(true);
        } catch (Exception $e) {
            return response()->json(['is_success' => 'false', 'exceptionError' => e->getMessage()]);
        }
    }
    public function getDocumentInfoForEmail(Request $request){
        date_default_timezone_set('Asia/Manila');

        try {
            return $document = Document::all();

        } catch (Exception $e) {
            return response()->json(['is_success' => 'false', 'exceptionError' => e->getMessage()]);
        }
    }


    public function readDocumentById(Request $request){
        try {
            $read_document_by_id = $this->resource_interface->readById(Document::class,$request->document_id);
            $document_id = decrypt($request->document_id);
            $data = [
                '*'
            ];
            $relations = [
                'approver_ordinates',
                'approver_ordinates.user'

            ];
            $conditions = [
                'id' => $document_id
            ];
            $read_document_by_id = $this->resource_interface->readOnlyRelationsAndConditions(Document::class,$data,$relations,$conditions);


            $page_count = $this->pdf_service->getPageCount(storage_path('app/' . 'public/edocs/'. $document_id .'/'. $read_document_by_id[0]->filtered_document_name));

            return response()->json(['is_success' => 'true', 'read_document_by_id' => $read_document_by_id , 'page_count' => $page_count]);
        } catch (\Exception $th) {
            throw $th;
        }
    }

    public function readApproverNameById(Request $request){
        return $request->all();
        try {
            $read_approver_by_id = $this->resource_interface->readById(User::class,$request->approver_id);
            return response()->json(['is_success' => 'true','read_approver_by_id' => $read_approver_by_id]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function readApproverName(Request $request){
        try {
            $read_approver_by_id = $this->resource_interface->read(User::class);
            return response()->json(['is_success' => 'true','read_approver_by_id' => $read_approver_by_id]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

     /**
     * @param $request Handle PDF upload and convert a specific page to an image.
     */
    public function convertPdfToImageByPageNumber(Request $request)
    {
        try {
            $documentId = decrypt($request->document_id);
            $request->validate([
                // 'pdf' => 'required|mimes:pdf|max:2048',
                'select_page' => 'required|integer|min:1',
            ]);

            $documents = Document::where('id',$documentId)->get();
            $pageNumber = $request->input('select_page');
            $filePath = storage_path('app/public/edocs/'.$documents[0]->id.'/'.$documents[0]->filtered_document_name);
            $outputDir = storage_path('app/public/images');
            // Convert PDF page to image
            $imagePath = $this->pdf_service->convertPdfPageToImage($filePath, $pageNumber-1, $outputDir);
            return response()->json($imagePath);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function showPdfWithSignatures(Request $request){
        return $this->pdf_custom_interface->insertMultipleImageAtCoordinates($request->documentId);
        /**
         * TODO: get image employee number to DB
         * TODO: get file path, ordinates and page DB
         */
        $imagePath = storage_path('app/public/images/R152.png');
        // $filePath = storage_path('app/public/edocs/'.$documents[0]->id.'/'.$documents[0]->filtered_document_name);
        // $pdfPath = storage_path('app/public/edocs/1'.'/'.'0_updated_crud_ypics_as_of_september_2024.pdf');
        $pdfPath = storage_path('app/public/edocs/1'.'/'.'0_updated_crud_ypics_as_of_september_2024.pdf');
        // $pdfPath = storage_path('app/public/edocs/6'.'/'.'0_0_soa_2024_0001_pricon_january_2024.pdf');
        // $this->pdf_service->insertImageAtCoordinates($pdfPath, $imagePath, $request->x, $request->y, 1);
        // $insert_image_at_coordinates = $this->pdf_service->insertImageAtCoordinates($pdfPath, $imagePath, '0.4472630173564753', '0.563177771783113', 1);
        $this->pdf_service->insertImageAtCoordinates($pdfPath, $imagePath, '0.711121157323689 ', '0.6189567684193703', 1);
    }

    public function updateEdocsApprovalStatus(Request $request){
        $data = [
            'status' => $request->status,
            'approver_remarks' => $request->remarks,
        ];
        $conditions = [
            'fk_document' => decrypt($request->document_id),
            'approver_id' => 1,
        ];
        $this->resource_interface->updateWithConditions(ApproverOrdinates::class,$data,$conditions);
        try {
            return response()->json(['is_success' => 'true']);
        } catch (Exception $e) {
            return response()->json(['is_success' => 'false', 'exceptionError' => $e->getMessage()]);
        }
    }
}
