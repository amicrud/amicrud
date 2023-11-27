@extends($page_layout)
@section('title', amicrud_form_labels($crud_name))
@section('page-title') {{amicrud_form_labels($crud_name)}} @endsection
@section('breadcrumb')
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="h-100">
                <div class="row mb-3 justify-content-center">

                    @php
                        $issetSideBar = true;
                    //     isset($sidebar) && (isset($categories)||isset($customer_types)||isset($expenditure_types) || 
                    //     (
                    //         (isset($branches)||isset($warehouses)||isset($factories))&&user_has_role(['admin','admin_user'])
                    //     )
                    // );
                    @endphp
                    @if( $issetSideBar )
                    <div class="col-md-2">
                        <div class="card">
            
                            <div class="accordion accordion-flush">
                                @include('admin.includes.sidebar')
                            </div>
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                    @endif
                   

                   <div class=" @if($issetSideBar) col-md-10 @else col-lg-12 @endif">
                        <div class="card">
                               <div class="card-body">
                                <div >
                                    <div class="row g-4 mb-3">
                                        <div class="col-sm-auto">
                                            <div class="d-inline-flex">
                                                <!-- Vertical Variation -->
                                                @include('amicrud::amicrud.shared.export-button')
                                                @include('amicrud::amicrud.shared.paginate-number')
                                                
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

                                    <div class="row" id="other-data">
                                        
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
