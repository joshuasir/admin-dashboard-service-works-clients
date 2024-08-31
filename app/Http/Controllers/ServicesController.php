<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Work;
use DB;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        $service_keyword = $request->input('service_searchbar','');
        $service_cat = $request->input('service_categoryopt','%');
        $services = Service::where([['ServiceName','like','%'.$service_keyword.'%'],['ServiceType','like',$service_cat]])->orderBy('updated_at','desc')->paginate(9);
        return view('/index/services')->with('service_category',$service_cat)->with('service_keyword',$service_keyword)->with('services',$services)->with('success','Successfully Updated!');
    }
    


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
 /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $service = Service::find($id);
        if($service){
            $service->ServiceName = $request->input('ServiceName',$service->ServiceName);
            
            $service->ServicePrice = $request->input('ServicePrice',$service->ServicePrice);
            if($request->file('ServiceSource')){
                $service->ServiceSource = $request->file('ServiceSource')->hashName();
                $request->file('ServiceSource')->store('services/'.$service->ServiceType);
            }
            $service->save();
            return redirect('/index/services')->with('success','Successfully Updated!');
        }
        return redirect('/index/services')->with('error','not found!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'ServiceSource'=>'image|required|file|max:1024',
            'ServiceName'=>'required|max:255',
            'ServicePrice'=>'required',
            'ServiceType'=>'required'
        ]);
        
        $service = new Service;
        $service->ServiceSource = $request->file('ServiceSource')->hashName();
        $request->file('ServiceSource')->store('services/'.$request->input('ServiceType'));
        $service->ServiceName = $request->input('ServiceName');
        $service->ServicePrice = $request->input('ServicePrice');
        $service->ServiceType = $request->input('ServiceType');
        $service->save();
        return redirect('/index/services')->with('success','Successfully Added!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service =  Service::findOrFail($id);
        if(Storage::exists('services/'.$service->ServiceType.'/'.$service->ServiceSource)){
            Storage::delete('services/'.$service->ServiceType.'/'.$service->ServiceSource);
        }

        $service->delete();
        return redirect('/index/services')->with('success','Successfully Deleted!');
    }

    public function updateVisibility($id)
    {

        $service = Service::find($id);
        $service->Visible = !$service->Visible;
        $service->save();
        return redirect('/index/services')->with('success','Successfully Saved!');
    }
}
