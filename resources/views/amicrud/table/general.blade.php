@extends($page_layout)
@section('title', form_labels($model_name))
@section('content')
    <div class="row">
        <div class="col">
            <div class="h-100">
                <div class="row mb-3 justify-content-center">
                  <div class="col-md-12">

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">
                                    View
                                    {{(isset($add_model)&&$add_model) ? ', Add' :'' }}
                                    {{(isset($edit_model)&&$edit_model) ? ', Edit' :'' }}
                                    {{(isset($delete_model)&&$delete_model) ? '& Delete ' :'' }}
                                     
                                    {{form_labels($model_name)}}</h4>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <div id="customerList">
                                    <!-- Add/Edit Buttons -->
                                    <div class="row g-4 mb-3">
                                        <div class="col-sm">
                                            <div class="d-inline-flex">
                                                @if(isset($add_model)&&$add_model)
                                                    <button type="button" class="btn btn-success add-btn d-ruby mr-2 pr-4" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal" data-name="{{Str::singular($model_name)}}" data-url="{{sign_url(route($form_edit_route,'null'))}}"> <span>Add</span> <i class="ri-add-line align-bottom me-1"></i></button>
                                                @endif
                                               
                                                <!-- Vertical Variation -->
                                                @if($export_model ?? false)
                                                 @include('amicrud::amicrud.shared.export-button')
                                                @endif

                                                @if($paginate_model ?? false)
                                                 @include('amicrud::amicrud.shared.paginate-number')
                                                @endif
                                            </div>
                                        </div>
                                        @if(!isset($search))
                                        <div class="col-sm">
                                            <div class="d-flex justify-content-sm-end">
                                                @include('amicrud::amicrud.shared.date-picker')
                                                <div class="search-box ms-2">
                                                    <input type="text" class="form-control search" placeholder="Search...">
                                                    <i class="ri-search-line search-icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <!-- Table -->
                                    <div id="table-data" data-list_target_route="{{sign_url(route($list_target_route))}}">
                                        
                                    </div>
                    </div>
                </div><!-- end card -->
            </div>
                  </div>
                </div>
            </div>
        </div>
    </div>

@include('amicrud::amicrud.table.modal')

@endsection
@section("js")
   
@include('amicrud::amicrud.table.js')
@endsection
