
<div class="float-right">
@if(isset($preview))
    <button type="button" class="btn btn-primary  preview_btn" data-bs-toggle="modal" data-bs-target="#showModal"><i class="fa fa-eye"></i>  @if(is_bool($preview)) Preview @else {{$preview}} @endif </button>
@endif

@if(isset($new))
    <button type="button" class="btn btn-primary  new_btn"><i class="fa fa-plus"></i>  @if(is_bool($new)) New @else {{$new}} @endif </button>
@endif

@if(isset($cancel))
    <button type="button" class="btn btn-danger  cancel_btn"><i class="fa fa-times"></i> @if(is_bool($cancel)) Cancel @else {{$cancel}}  @endif </button>
@endif

@if(isset($list_cancel))
    <button type="button" class="btn btn-warning  cancel_btn" style="display:none"><i class="fa fa-times"></i> @if(is_bool($list_cancel)) Cancel @else {{$list_cancel}} @endif </button>
@endif 

@if(isset($edit))
    <button type="button" class="btn btn-info  edit_btn" ><i class="fa fa-edit"></i> @if(is_bool($edit)) Edit @else {{$edit}} @endif </button>
@endif

@if(isset($save))
<button type="submit" class="btn btn-success  save_btn"><i class="fa fa-save"></i> @if(is_bool($save)) Save @else {{$save}} @endif </button>
@endif

@if(isset($submit))
<button type="submit" class="btn btn-success  submit_btn"><i class="fa fa-save"></i> @if(is_bool($submit)) Submit @else {{$submit}} @endif </button>
@endif

</div>
