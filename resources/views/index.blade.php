@extends('header')

@section('script')
<script>
$(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#add').on('click',function(){
        if($('#addForm').css('display')==='none'){
            
            $(this).text('Cancel');
            $('#addForm').css('display','initial');
            $(this).attr('class',"ml-auto btn btn-info text-white bg-danger");
            
        }else{
            $(this).text('Add');
            $('#addForm').css('display','none');
            $(this).attr('class',"ml-auto btn btn-info text-white bg-success");
            $('.tag').val('');
            $('.link').val('');
            $('#cat option[value="'.concat('%').concat('"]')).attr('selected',true);
            $('#type option[value="'.concat('video').concat('"]')).attr('selected',true);
            $('.id').val('');
        }
        
    })
    $('li.workitem').on('click',function(){
        if($('#addForm').css('display')==='none'){
            $('#add').click()[0];

        }
        $("html,body").animate({ scrollTop: $('#add').offset().top }, 500);
        let id = $(this).attr('key');
        let loc = 'li[key='.concat(id).concat('] ');
        let img = $(loc.concat('img')).attr('src');
        let tag = $(loc.concat('span > .tag')).text();
        let link = $(loc.concat('span > .tag')).attr('href');
        let category = $(loc.concat('span > .category')).text().split(' ')[2];
        let type  =$(loc.concat('span > .type')).text().split(' ')[2];
        
        // alert($('li[key=24] span p.tag').text());
        $('.tag').val(tag);
        $('.link').val(link);
        $('#cat option[value="'.concat(category).concat('"]')).attr('selected',true);
        $('#type option[value="'.concat(type).concat('"]')).attr('selected',true);
        $('.id').val(id);
    })
    $('#searchbar').keypress(function (e) {
        if (e.which == 13) {
            $('#findword').click();
            return false;    //<---- Add this line
        }
        });
      $('#service_searchbar').keypress(function (e) {
      if (e.which == 13) {
          $('#service_findword').click();
          return false;    //<---- Add this line
      }
      });

    let cat = $('#select-cat').attr('value');
    $('#select-cat option[value="'.concat(cat).concat('"]')).attr('selected',true);
    
    let service_cat = $('#service_cat').attr('value');
    $('#service_cat option[value="'.concat(service_cat).concat('"]')).attr('selected',true);

    $('button.openEdit').on('click',function(){
      
      if($('#clientEdit').css('display')==='none'){
            
            $(this).text('Cancel');
            $('#clientEdit').show();
            $(this).attr('class',"btn btn-sm btn-outline-danger openEdit mb-4");
        }else{
            $(this).text('Add');
            $('#clientEdit').css('display','none');
            $(this).attr('class',"btn btn-sm btn-outline-secondary openEdit mb-4");

        }

    })
    $('div > button.fav').on('click',function(){
        let cat = $(this).attr('key');
        
        $.ajax({
            type: "put",
            url: '/public/works/'.concat(cat),
            success: function (response) {
              
            }
        });
        if($(this).attr('class')==='btn btn-outline-secondary fav'){
            $(this).attr('class',"btn btn-warning fav");
        }else{
            $(this).attr('class',"btn btn-outline-secondary fav");
        }
      })
      $('button.editService').on('click',function(){
        let key = $(this).attr('key');
        $('div.editFormService[key='.concat(key).concat(']')).show();
      })
      $('button.editServiceCancel').on('click',function(){
        let key = $(this).attr('key');
        $('div.editFormService[key='.concat(key).concat(']')).hide();
      })
      
    $('#select-menu').on('change',function(e){
        let menu = $('#select-menu option:selected').attr('value');
        $('div.initcontainer').css('display','none');
        $('#'.concat(menu)).css('display','initial');
    });
    $('button.delete').on('click',function(){
      let key = $(this).attr('key');
      let _this = '.alert-delete[key="'.concat(key).concat('"]');
      $(_this).show();
      
      $(_this.concat(' .cancel')).on('click',function(){
        $(_this).hide();
    })
    
    })
    
})
</script>
@endsection

@section('content')
<body class="antialiased">
  <nav class="navbar navbar-expand-lg navbar-light bg-light mt-3">
  <div class="album bg-light container">
    <div class="navbar-nav ">
      <a class="nav-item nav-link" href="/public/index/works" >Works</a>
      <a class="nav-item nav-link" href="/public/index/clients">Clients</a>
      <a class="nav-item nav-link" href="/public/index/services">Services</a>
    </div>
  </div>
  </nav>

    @if ($tab==='' || $tab==='works')
      @include('works')
    @elseif ($tab==='clients')
      @include('clients')
    @else
      @include('services')
    @endif

</body>
@endsection

