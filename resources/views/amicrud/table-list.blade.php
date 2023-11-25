
@extends($page_layout)
@section('title') {{$type}} @endsection
@section('content')

    <div class="row">
        <div class="add-listing-headline">
            <h3>{{$type}}</h3>
        </div>
        
      <div class="card w-100">
        <div class="card-body">
            <h4 class="mt-0 header-title">List Of {{$type}}</h4>
           <div class="row">
            <div class="col-md-12">
                <div class="card-footer bg-white p-0">
                    <input type="search" class="form-control" id="mini-search" placeholder="Search..." name="name">
                </div>
                <div class="card-body p-0">
                    @include("amicrud::amicrud.shared.table-list")  
                </div> <!-- end card body-->
            </div>
           </div>
        </div>
      </div>

    </div>


@endsection

@section('js')
@include('amicrud::amicrud.formsjs')
<script>
    $(function(){
    'use strict';

    });
</script>
@endsection