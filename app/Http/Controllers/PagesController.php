<?php

namespace App\Http\Controllers;

use App\Models\msworks;
use App\Models\Client;
use App\Models\Service;
use App\Models\work_category;
use Illuminate\Http\Request;
use App\Work;

class PagesController extends Controller
{
    // public function index($cat = '%',$keyword='')
    // {
    //    $works = msworks::orderBy('LastUpdated','desc')->paginate(5);

    //    return view('index',['works'=>$works,'category'=>$cat,'keyword'=> $keyword]);
    // }

    public function index(Request $request,$tab='works')
    {

        $keyword = $request->input('searchbar','');
        $cat = $request->input('categoryopt','%');

        $service_keyword = $request->input('service_searchbar','');
        $service_cat = $request->input('service_categoryopt','%');

        if($cat === 'highlight'){
            $works = msworks::where([['Tag','like','%'.$keyword.'%'],['Highlight','=',1]])->orderBy('LastUpdated','desc')->paginate(5);
        }else{
            $works = msworks::where([['Tag','like','%'.$keyword.'%'],['Category','like',$cat]])->orderBy('LastUpdated','desc')->paginate(5);
        }
        $clients = Client::all();
        $services = Service::where([['ServiceName','like','%'.$service_keyword.'%'],['ServiceType','like',$service_cat]])->orderBy('updated_at','desc')->paginate(9);
        return view('index',['works'=>$works,'category'=>$cat,'keyword'=> $keyword,'service_category'=>$service_cat,'service_keyword'=> $service_keyword,'clients'=>$clients,'services'=>$services,'tab'=>$tab]);
    }
    
    public function login(){
        return view('login');
    }

    public function signup(){
        return view('signup');
    }
}
