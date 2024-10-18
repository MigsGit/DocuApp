<?php

namespace App\Jobs;



//Interface
use App\Interface\ResourceInterface;

class ResourceJob implements ResourceInterface
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function create($model,array $data){
        return $model;
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
