<?php

namespace App\Jobs;
use Illuminate\Support\Facades\DB;
use App\Models\Document;
//Interface
use App\Interfaces\ResourceInterface;

class ResourceJob implements ResourceInterface
{
    /**
     * Execute the job.
     *
     * @return mixed $model,array $data
     */
    public function create($model,array $data){
        date_default_timezone_set('Asia/Manila');
        DB::beginTransaction();
        try {
            $model::insert($data);
            DB::commit();
            return response()->json(['is_success' => 'true']);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['is_success' => 'false', 'exceptionError' => $e->getMessage()]);
        }
    }
    public function createOrUpdate( $model,array $data,$id){
        date_default_timezone_set('Asia/Manila');
        DB::beginTransaction();
        try {
            if( isset( $id ) ){
                $model::where('id',$id)->update($data);
            }else{
                $model::insert($data);
            }
            DB::commit();
            return response()->json(['is_success' => 'true']);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['is_success' => 'false', 'exceptionError' => $e->getMessage()]);
        }
    }

    public function readByID($model,$id){
        try {
            $data = $model::where('id',$id)->whereNull('deleted_at')->get();
            return response()->json(['is_success' => 'true','data'=> $data]);
        } catch (Exception $e) {
            return response()->json(['is_success' => 'false', 'exceptionError' => $e->getMessage()]);
        }
    }

    // public function read(Request $request){
    //     return 'true' ;
    //     try {
    //         return response()->json(['is_success' => 'true']);
    //     } catch (Exception $e) {
    //         return response()->json(['is_success' => 'false', 'exceptionError' => $e->getMessage()]);
    //     }
    // }

    // public function update(Request $request){
    //     return 'true' ;
    //     try {
    //         return response()->json(['is_success' => 'true']);
    //     } catch (Exception $e) {
    //         return response()->json(['is_success' => 'false', 'exceptionError' => $e->getMessage()]);
    //     }
    // }

    // public function inactive(Request $request){
    //     return 'true' ;
    //     try {
    //         return response()->json(['is_success' => 'true']);
    //     } catch (Exception $e) {
    //         return response()->json(['is_success' => 'false', 'exceptionError' => $e->getMessage()]);
    //     }
    // }
    // public function delete(Request $request){
    //     return 'true' ;
    //     try {
    //         return response()->json(['is_success' => 'true']);
    //     } catch (Exception $e) {
    //         return response()->json(['is_success' => 'false', 'exceptionError' => $e->getMessage()]);
    //     }
    // }
}
