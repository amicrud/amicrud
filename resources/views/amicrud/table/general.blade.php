@extends($page_layout)
@section('title', amicrud_form_labels($crud_name))

@push('amicrud_css')

    @if(config('amicrud.load_fontawesome'))
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    @endif

    @if(config('amicrud.load_bootstrap'))
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    @endif

    @if(config('amicrud.load_dropify'))
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css">
    @endif

    @if(config('amicrud.load_summernote'))
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">
    @endif

    <style>
        .amicrud-avatar-xs{
            width: 40px;
        }
    </style>

@endpush

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
                                     
                                    {{amicrud_form_labels($crud_name)}}</h4>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <div id="customerList">
                                    <!-- Add/Edit Buttons -->
                                    <div class="row g-4 mb-3">
                                        <div class="col-sm">
                                            <div class="d-inline-flex">
                                                @if(isset($add_model)&&$add_model)
                                                    <button type="button" class="btn btn-success add-btn d-ruby mr-2 pr-4" id="create-btn" data-name="{{Str::singular($crud_name)}}" data-url="{{amicrud_sign_url(route($form_edit_route,'null'))}}"> <span>Add</span> <i class="ri-add-line align-bottom me-1"></i></button>
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
                                    <div id="table-data" data-list_target_route="{{amicrud_sign_url(route($list_target_route))}}">
                                        
                                    </div>
                    </div>
                </div><!-- end card -->
            </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('amicrud_js')

  @if(config('amicrud.load_jquery'))
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  @endif

  @if(config('amicrud.load_bootstrap'))
    <!-- Bootstrap Bundle (includes Popper) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
  @endif

  @if(config('amicrud.load_bootstrap_datepicker'))
    <!-- Bootstrap Datepicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        $('.date-picker').datepicker({ 
          clearBtn: true,
          autoclose: true
        });
    </script>
  @endif

  @if(config('amicrud.load_bootstrap_datepicker'))
    <!-- Sweet Alerts js -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  @endif

  @if(config('amicrud.load_dropify'))
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
    <script>
        $(document).ready(function(){
          // Initialize
          $('.dropify').dropify();
        });
    </script>
  @endif

  @if(config('amicrud.load_summernote'))
  <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function(){
            // Initialize
            $(".summernote").summernote({
                height: 150
            });
        });
    </script>
    @endif

@include('amicrud::amicrud.table.js')

@endpush
