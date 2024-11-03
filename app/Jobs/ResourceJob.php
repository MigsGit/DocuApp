<?php

namespace App\Jobs;
use Illuminate\Support\Facades\DB;
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
            $data_id = $model::insertGetId($data);
            DB::commit();
            return response()->json(['is_success' => 'true','data_id'=>$data_id]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['is_success' => 'false', 'exceptionError' => $e->getMessage()]);
        }
    }
    public function createOrUpdate( $model,$data_id,array $data){
        date_default_timezone_set('Asia/Manila');
        DB::beginTransaction();
        try {
            if( isset( $id ) ){
                $model::where('id',$id)->update($data);
                $data_id = $id;
            }else{
                $insert_by_id = $model::insertGetId($data);
                $data_id = $insert_by_id;
            }
            DB::commit();
            return response()->json(['is_success' => 'true','data_id'=>$data_id]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['is_success' => 'false', 'exceptionError' => $e->getMessage()]);
        }
    }

    public function readByID($model,$id){
        try {
            return $data = $model::where('id',$id)->whereNull('deleted_at')->get();
            // return response()->json(['is_success' => 'true','data'=> $data]);
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

    public function update($model,$data_id,array $data){

        date_default_timezone_set('Asia/Manila');
        DB::beginTransaction();
        try {
            $model::where('id',$data_id)->update($data);
            return response()->json(['is_success' => 'true']);
            DB::commit();
            return response()->json(['is_success' => 'true','data_id'=>$data_id]);
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

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
