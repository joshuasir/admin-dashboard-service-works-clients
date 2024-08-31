<?php

namespace App\Http\Controllers;

use App\Models\msworks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Work;
use DB;

class WorksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $works = msworks::orderBy('LastUpdated','desc')->paginate(5);
       return view('index')->with('works',$works)->with('tab','works');
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'Tag'=>'required|max:255',
            'Link'=>'required',
            'Type'=>'required',
            'CategoryAdd'=>'required',
            'Source'=>'image|file|max:1024'
        ]);
        
        $data = [
            'WorkID'=> $request->input('WorkID')
        ];

        $work = msworks::firstOrNew($data);
        if($work->Category !== $request->input('CategoryAdd') or $work->Link !== $request->input('Link')){
            $work = new msworks;
        }
        $work->Tag = $request->input('Tag');
        
        $work->Link = $request->input('Link');
        $work->Type = $request->input('Type');
        $work->Category = $request->input('CategoryAdd');
        if($request->file('Source')){
            $work->Source = $request->file('Source')->hashName();
            $request->file('Source')->store('works/'.$work->Category);
        }
        $work->LastUpdated = \Carbon\Carbon::now()->toDateTimeString();
        $work->save();
        return redirect('/index/works')->with('success','Successfully Saved!')->with('category',$work->Category);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $works = msworks::find($id);
        return $works;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update($id)
    {

        $work = msworks::find($id);
        $work->Highlight = !$work->Highlight;
        $work->save();
        return;
    }
    public function updateVisibility($id)
    {

        $work = msworks::find($id);
        $work->Visible = !$work->Visible;
        $work->LastUpdated = \Carbon\Carbon::now()->toDateTimeString();
        $work->save();
        return redirect('/index/works')->with('success','Successfully Saved!')->with('category',$work->Category);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $work =  msworks::findOrFail($id);
        if(Storage::exists('works/'.$work->Category.'/'.$work->Source)){
            Storage::delete('works/'.$work->Category.'/'.$work->Source);
        }

        $work->delete();
        return redirect('/index/works')->with('success','Successfully Saved!');
    }

}
