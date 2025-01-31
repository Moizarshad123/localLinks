<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceImage;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DB;

class ServiceController extends Controller
{
    
    public function services() {
        $services = Service::with("images")->where('vendor_id', auth()->user()->id)->orderByDESC('id')->get();
        return $this->success($services);
    }
    
    public function serviceDetail(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'service_id' => 'required',
        ]);
        if ($validator->fails()){
            return $this->error('Validation Error', 200, [], $validator->errors());
        }
            
        $service = Service::with("images")->find($request->service_id);
        return $this->success($service);
    }
    
    public function updateService(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'service_id' => 'required'
            ]);
            if ($validator->fails()){
                return $this->error('Validation Error', 200, [], $validator->errors());
            }
            
            $service = Service::find($request->service_id);
            $service->name=$request->name;
            $service->price=$request->price;
            $service->location=$request->location;
            $service->lat=$request->lat;
            $service->lng=$request->lng;
            $service->duration=$request->duration;
            $service->detail=$request->detail;
            $service->save();
            
             if(count($request->images) > 0) {
                ServiceImage::where("service_id", $request->service_id)->delete();
                $dir  = "uploads/services/";
                foreach($request->images as $image) {
                    
                    $file     = $image;
                    $fileName = time().'-service.'.$file->getClientOriginalExtension();
                    $file->move($dir, $fileName);
                    $fileName = asset($dir.$fileName);
                    
                    
                    $serviceImg = new ServiceImage();
                    $serviceImg->image = $fileName;
                    $serviceImg->service_id = $service->id;
                    $serviceImg->save();
                }
            }
            
            $services = Service::with("images")->where('vendor_id', auth()->user()->id)->orderByDESC('id')->get();
            return $this->success($services,"Service Updated");
            
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
    
    
    public function addService(Request $request) {
        
        try {
            $validator = Validator::make($request->all(), [
                'price' => 'required',
                'name'    => 'required',
            ]);
            if ($validator->fails()){
                return $this->error('Validation Error', 200, [], $validator->errors());
            }
            DB::beginTransaction();
            $service = Service::create([
                "vendor_id" => auth()->user()->id,
                "name"=>$request->name,
                "price"=>$request->price,
                "location"=>$request->location,
                "lat"=>$request->lat,
                "lng"=>$request->lng,
                "duration"=>$request->duration,
                "detail"=>$request->detail
            ]);
            if(count($request->images) > 0) {
                
                $dir  = "uploads/services/";
                foreach($request->images as $image) {
                    
                    $file     = $image;
                    $fileName = time().'-service.'.$file->getClientOriginalExtension();
                    $file->move($dir, $fileName);
                    $fileName = asset($dir.$fileName);
                    
                    
                    $serviceImg = new ServiceImage();
                    $serviceImg->image = $fileName;
                    $serviceImg->service_id = $service->id;
                    $serviceImg->save();
                }
            }
            
            
            DB::commit();
            $services = Service::where('vendor_id', auth()->user()->id)->orderByDESC('id')->get();
            return $this->success($services,"Service Created");
            
        } catch (\Exception $e) {
            DB::rollback();
            return $this->error($e->getMessage());
        }
        
    }
}
