<div class="initcontainer container pt-md-2" id="works">
    <form action="{{url('./index')}}" method="get" id="form1">
      {{ csrf_field() }}
      <div class="form-groups">
        <h3 for="category"> Select Category to Search on</h3>
        <select class="form-control mb-3" name="categoryopt" id="select-cat" value="{{$category}}">
          <option value="%">All</option>
          <option value="event">Travel & Event </option>
          <option value="movies"> Film & Web Series</option>
          <option value="fotografi"> Product Commercial</option>
          <option value="prop">Company Profile</option>
          <option value="music">Music Video</option>
          <option value="live">Live Stream</option>
          <option value="highlight">Highlights</option>
        </select>
      </div>
      <div class="form-groups">
        
        <div class="input-group rounded pt-2">
          <input name="searchbar" value="{{$keyword}}" type="search" class="form-control rounded" placeholder="Search Keyword" id="searchbar" aria-label="Search"
          aria-describedby="search-addon" />
          
          <button type="submit" class="input-group-text border-0 btn-secondary" id="findword">
            Find 
          </button>
          @if(Auth::user()->is_admin == 1)
          <button id="add" class="ml-auto btn btn-info text-white bg-success" type="button"> Add </button>
          @endif
        </div>
      </div>
        
        
    </form>
    @if(Auth::user()->is_admin == 1)
    <form id="addForm" style="display: none" class="w-75" method="post" action="{{action('App\Http\Controllers\WorksController@store')}}" enctype="multipart/form-data">
        @method('post')
        @csrf
        <h3 class="pt-4">Upload/Edit a Work</h3>
        <input name="WorkID"type="text" value='-1' style="display:none;" class="id">
        <input name="Tag" class="tag form-control mb-3" type="text" placeholder="title">
        <input name="Link" class="link form-control mb-3" type="text" placeholder="link">
        <input name="Source" id="formFile" class="source form-control mb-3" type="file">
        <select name="CategoryAdd" class="form-control mb-3" id="cat">
            <option class="text-muted" value="%">-- pick category --</option>
            <option value="event">Travel & Event</option>
            <option value="movies"> Film & Web Series</option>
            <option value="fotografi"> Product Commercial</option>
            <option value="prop">Company Profile</option>
            <option value="music">Music Video</option>
            <option value="live">Live Stream</option>
        </select>
        <select name="Type" class="form-control mb-3" name="type" id="type">
            <option value="video">Video</option>
            <option value="image">Image</option>
        </select>
        <input class="btn bg-primary" style="color: white" type="submit" value="submit">
      </form>
      @endif
      @include('messages')
    <ol class="list-group m-4 lists" >
      @if (isset($works) && count($works) > 0)
      {{$works->links()}}
      @foreach ( $works as $work)
            
          <li key={{$work->WorkID}} type="button" class="workitem list-group-item list-group-item-action" >
              
            <img width="200px" height="200px" class="img-thumbnail image mr-5" src="/storage/app/public/works/{{$work->Category}}/{{$work->Source}}" alt="">
            <br>
            <span class="column">
                  <a href={{$work->Link}} target='_blank' class="tag btn-link ">{{$work->Tag}} </a>
                  <br>
                  <span class="w-50 category">Category : {{$work->Category}} </span>
                  <br>
                  <span class="w-50 type">Type : {{$work->Type}}</span>
                  <br>
                  <span class="text-muted w-75 last">{{$work->LastUpdated}}</span>
                </span>
          </li>
          @if(Auth::user()->is_admin == 1)
          <div key={{$work->WorkID}} class="alert alert-danger alert-delete " role="alert" style="display: none">
            You are about to delete a work. Are you sure ?
            <div class="m-1" style="display: inline;">
              <button key={{$work->WorkID}}type="button" class="btn btn-secondary cancel">Cancel</button>
              <form style="display: inline;" method="post" action={{route('works.destroy',[$work->WorkID])}} >
                @method('delete')
                @csrf
                <button key={{$work->WorkID}} type="submit" class="btn btn-primary confirm-del">Confirm</button>
              </form>
            </div>
          </div>
          <div key={{$work->WorkID}} style="display: inline;" class="flex-row justify-content-between w-100 work-btn container-fluid p-2">
            <button key={{$work->WorkID}} type="button" class="btn btn-{{$work->Highlight ? 'warning':'outline-secondary'}} fav">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 17">
                <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
              </svg> 
            
            </button>
            <form method="post" style="display: inline;" action={{action('App\Http\Controllers\WorksController@updateVisibility',[$work->WorkID])}}>
              @method('post')
              @csrf
              <button type="submit" class="btn btn-{{$work->Visible ? 'secondary':'outline-secondary'}} fav">
              @if ($work->Visible)
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
            <button key={{$work->WorkID}} type="button" class="btn btn-outline-danger delete">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"></path>
                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"></path>
              </svg>
              Delete
            </button>
          </div> 
          @endif
          @endforeach
          {{$works->links()}}
      @else
      <p> No work posted yet at this moment.</p>
      @endif
      </ol>
</div>
