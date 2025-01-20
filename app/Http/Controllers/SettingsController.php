<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SettingsController extends Controller
{

    public function getUserMaster(Request $request){
        // return 'true' ;
        try {
            $user = User::whereNull('deleted_at')->get();

            return DataTables::of($user)
            ->make(true);
            // return response()->json(['is_success' => 'true']);
        } catch (Exception $e) {
            return response()->json(['is_success' => 'false', 'exceptionError' => $e->getMessage()]);
        }
    }
}
