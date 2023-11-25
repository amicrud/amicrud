@extends($page_layout)
@section('title', form_labels($model_name))
@section('page-title') {{form_labels($model_name)}} @endsection
@section('breadcrumb')
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="h-100">
                <div class="row mb-3 justify-content-center">
                  <div class="col-md-12">

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">{{isset($model_action)?$model_action:'Create/Update'}} {{form_labels($model_name)}}</h4>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <div id="customerList">
                                    <!-- Form Page -->
                                    @include('amicrud::amicrud.shared.form')
                    </div>
                </div><!-- end card -->
            </div>
                  </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section("js")
   
@include('amicrud::amicrud.table.js')
@endsection
