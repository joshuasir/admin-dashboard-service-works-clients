<div class="initcontainer container pt-md-5" id="services">
  <div class="row">
    <form action="{{url('./index/services')}}" method="get" class="pb-3">
      {{ csrf_field() }}
      <div class="form-groups">
        <h3 for="category"> Select Category to Search on</h3>
        <select class="form-control mb-3" name="service_categoryopt" value="{{$service_category}}" id="service_cat">
          <option value="%" >All</option>
          <option value="video">Videography</option>
          <option value="foto"> Photography</option>
        </select>
      </div>
      <div class="form-groups">
        
        <div class="input-group rounded pt-2">
          <input name="service_searchbar" value="{{$service_keyword}}" type="search" class="form-control rounded" placeholder="Search Keyword" id="service_searchbar" aria-label="Search"
          aria-describedby="search-addon" />
          
          <button type="submit" class="input-group-text border-0 btn-secondary" id="service_findword">
            Find 
          </button>
        </div>
      </div>
    </form>

      @include('messages')
      @if (isset($services) && count($services) > 0)
      {{$services->links()}}
      @foreach ( $services as $service)
      <div class="col-md-4"  >
        <div class="card mb-4 shadow-sm" >
            <img class="card-img-top" alt="Thumbnail [100%x225]" style="height: 225px; width: 190px; display: inline; margin-left: 5%; padding-top: .5em" src="/storage/app/public/services/{{$service->ServiceType}}/{{$service->ServiceSource}}" data-holder-rendered="true">
            <div class="card-body">
                <span class="card-text h3">{{$service->ServiceName}}</span>
                <br>
                <span class="card-text">From Rp. {{$service->ServicePrice}},-</span>
                <br>
                <span class="card-text">{{$service->ServiceType === 'foto' ? 'Photography':'Videography'}} </span>
                <br>
                <small class="text-muted"> {{$service->updated_at}}</small>
                @if(Auth::user()->is_admin == 1)
                <div key={{$service->id}} class="alert alert-danger alert-delete " role="alert" style="display: none">
                    You are about to delete a service. Are you sure ?
                    <br>
                    <div class="m-1" style="display:inline;">
                      <form style="display:inline;"method="post" action="{{action('App\Http\Controllers\ServicesController@destroy',[$service->id])}}" >
                        @method('delete')
                        @csrf
                        <button key={{$service->id}} type="submit" class="btn btn-primary confirm-del">Confirm</button>
                      </form>
                      <button style="display:inline;"key={{$service->id}}type="button" class="btn btn-secondary cancel">Cancel</button>
                    </div>
                  </div>
                    <br>
                    <div class="btn-group pt-2" style="display:inline;">
                    <button key={{$service->id}} type="button" class="btn btn-outline-danger delete">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"></path>
                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"></path>
                      </svg>
                      Delete
                    </button>
                    <button key={{$service->id}} type="button" class="btn btn-outline-primary editService">
                        Edit
                    </button>
                    <form method="post" style="display: inline;" action={{action('App\Http\Controllers\ServicesController@updateVisibility',[$service->id])}}>
                      @method('post')
                      @csrf
                      <button type="submit" class="btn btn-{{$service->Visible ? 'secondary':'outline-secondary'}} fav">
                      @if ($service->Visible)
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                      </svg>
                      @else
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16">
                        <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/>
                        <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/>
                        <path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"/>
                      </svg>
                      @endif
                        
                    </button>
                    </form>
                    </div>
                    
                    <div key={{$service->id}} class="editFormService" style="display: none">
                        <form id="editFormService" class="w-75" method="post" action="{{action('App\Http\Controllers\ServicesController@update',[$service->id])}}" enctype="multipart/form-data">
                            @method('post')
                            @csrf
                            <h3 class="pt-4">editting...</h3>
                            <input name="ServiceName" class="form-control mb-3" type="text" value="{{$service->ServiceName}}" placeholder="Service Name">
                            <input name="ServicePrice" class="form-control mb-3" type="numeric" value="{{$service->ServicePrice}}" placeholder="Service Price Rp. xxxxx,-">
                            <input name="ServiceSource" class="form-control mb-3" type="file">
                            <input class="btn bg-primary" style="color: white" type="submit" value="submit">
                            <button key={{$service->id}} type="button" class="btn btn-outline-secondary editServiceCancel">
                                Cancel
                            </button>
                          </form>
                    </div>
                    @endif
            </div>
        </div>
    </div>
          
          @endforeach
          {{$services->links()}}
      @else
      <p> No work posted yet at this moment.</p>
      @endif
    
    @if(Auth::user()->is_admin == 1)
      <div class="container">
      <form id="addFormService" class="w-75 pb-5" method="post" action="{{action('App\Http\Controllers\ServicesController@store')}}" enctype="multipart/form-data">
        @method('post')
        @csrf
        <h3 class="pt-4">Add a Service</h3>
        <input name="ServiceName" class="form-control mb-3" type="text" placeholder="Service Name">
        <input name="ServicePrice" class="form-control mb-3" type="numeric" placeholder="Service Price Rp. xxxxx,-">
        <input name="ServiceSource" class="form-control mb-3" type="file">
        <select name="ServiceType" class="form-control mb-3">
          <option value="video">Videography</option>
          <option value="foto"> Photography</option>
        </select>
        <input class="btn bg-primary" style="color: white" type="submit" value="submit">
      </form>
    </div>
    @endif
  </div>
</div>
