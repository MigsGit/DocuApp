<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

//Interface
use App\Interface\ResourceInterface;

class ResourceJob implements ShouldQueue,ResourceInterface
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function create(array $data){
        return 'true';
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
