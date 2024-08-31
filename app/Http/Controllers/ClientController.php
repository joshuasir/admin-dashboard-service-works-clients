<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Work;
use DB;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
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
            'clientImage'=>'required|image|file|max:1024',
            'size'=>'required'
        ]);
        
        $client = new Client;
        $client->Source = $request->file('clientImage')->hashName();
        $client->Size = $request->input('size');
        $request->file('clientImage')->store('clients');
        $client->save();
        return redirect('/index/clients')->with('success','Successfully Saved!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client =  Client::findOrFail($id);
        if(Storage::exists('clients/'.$client->Category.'/'.$client->Source)){
            Storage::delete('clients/'.$client->Category.'/'.$client->Source);
        }

        $client->delete();
        return redirect('/index/clients')->with('success','Successfully Saved!');
    }

    public function updateVisibility($id)
    {

        $client = Client::find($id);
        $client->Visible = !$client->Visible;
        $client->save();
        return redirect('/index/clients')->with('success','Successfully Saved!');
    }

}
