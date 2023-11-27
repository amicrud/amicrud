
@extends($page_layout)
@section('title') {{amicrud_form_labels($crud_name)}} @endsection
@section('content')

    <div class="row">
        <div class="add-listing-headline">
            <h3>{{amicrud_form_labels($crud_name)}}</h3>
        </div>
        
      <div class="card w-100">
        <div class="card-body">
            <h4 class="mt-0 header-title">List Of {{amicrud_form_labels($crud_name)}}</h4>
           <div class="row">
            <div class="col-md-3 p-0">
                <div class="card-footer bg-white p-0">
                    <input type="search" class="form-control" id="mini-search" placeholder="Search..." name="name">
                </div>
                <div class="card-body p-0" id="list-target">
                    {{-- @include("amicrud.shared.list")   --}}
                </div> <!-- end card body-->
            </div>

            <div class="col-md-9 p-0">
                @include("amicrud::amicrud.shared.alert")
                {{-- <h4 class="mt-0 header-title">Create {{amicrud_form_labels($crud_name)}}</h4> --}}
                <div class="row ml-1">
                    @if($form_info)
                    <p class=" alert-info p-2 rounded">
                        {!! $form_info??'' !!}
                    </p>
                    @endif
                </div>
                <div id="form-target">
                    @include($form_view)      
                </div>
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