<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Support;
use App\Models\Review;
use App\Models\ReviewDetail;
use DB;

class MiscellaneousController extends Controller
{
    public function support(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required',
            ]);
            if ($validator->fails()){
                return $this->error('Validation Error', 200, [], $validator->errors());
            }
            DB::beginTransaction();
            Support::create([
                "user_id" => auth()->user()->id,
                "name"    => $request->name,
                "email"   => $request->email,
                "subject" => $request->subject,
                "message" => $request->message
            ]);
            DB::commit();
            return $this->success([], "form submitted");

        } catch (\Exception $e) {
            DB::rollback();
            return $this->error($e->getMessage());
        }
    }

   
}
