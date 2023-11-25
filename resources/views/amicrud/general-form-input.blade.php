
@extends($page_layout)
@section('title') {{$type}} @endsection
@section('content')

    <div class="row">
        <div class="add-listing-headline">
            <h3>{{$type}}</h3>
        </div>
        
      <div class="card w-100">
        <div class="card-body">
            <h4 class="mt-0 header-title">Edit {{$type}}</h4>
            @include("amicrud::amicrud.shared.alert")
            <div id="form-id">
                @include("amicrud::amicrud.shared.form-input")      
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
    $('.edit_btn').prop('disabled', false);
    });
</script>
@endsection