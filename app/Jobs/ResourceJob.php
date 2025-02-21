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

    public function read($model){
        try {
            return $data = $model::whereNull('deleted_at')->get();
        } catch (Exception $e) {
            return response()->json(['is_success' => 'false', 'exceptionError' => $e->getMessage()]);
        }
    }

    public function update($model,$data_id,array $data){
        date_default_timezone_set('Asia/Manila');
        DB::beginTransaction();
        try {
            $model::where('id',$data_id)->update($data);
            DB::commit();
            return response()->json(['is_success' => 'true','data_id'=>$data_id]);
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
    public function updateWithConditions($model,array $data,array $conditions){
        date_default_timezone_set('Asia/Manila');
        DB::beginTransaction();
        try {
            $query = $model::query();
            if($conditions != null){
                foreach ($conditions as $key => $value) {
                    $query->where($key, $value);
                    // $query->where('column1'=>'1');
                    // $query->where('column2'=>'2');
                }
            }
            $query->update($data);
            DB::commit();
            return response()->json(['is_success' => 'true']);
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
    public function readOnlyRelationsAndConditions($model,$data=null,$relations=null,$conditions=null){
        try {
            $query = $model::query();
            if($data != null){
                foreach ($data as $key => $value) {
                    $query->select($value);
                    // $query->select('column1','column2');
                }
            }
            if($relations != null){
                $query->with($relations);
                // $query->with('approver_ordinates','approver_ordinates.user');
            }
            if($conditions != null){
                foreach ($conditions as $key => $value) {
                    $query->where($key, $value);
                    // $query->where('column1'=>'1');
                    // $query->where('column2'=>'2');
                }
            }
            $query->whereNull('deleted_at');
            return $query->get();
        } catch (Exception $e) {
            return response()->json(['isSuccess' => 'false', 'exceptionError' => $e->getMessage()]);
        }
    }
}
