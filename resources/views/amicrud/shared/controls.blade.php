
<div class="float-right">
@if(isset($preview))
    <button type="button" class="btn btn-primary  preview_btn" data-bs-toggle="modal" data-bs-target="#showModal"><i class="fa fa-eye"></i> Preview</button>
@endif

@if(isset($new))
    <button type="button" class="btn btn-primary  new_btn"><i class="fa fa-plus"></i> New</button>
@endif

@if(isset($cancel))
    <button type="button" class="btn btn-secondary  cancel_btn"><i class="fa fa-times"></i> Cancel</button>
@endif

@if(isset($list_cancel))
    <button type="button" class="btn btn-warning  cancel_btn" style="display:none"><i class="fa fa-times"></i> Cancel</button>
@endif 

@if(isset($edit))
    <button type="button" class="btn btn-info  edit_btn" ><i class="fa fa-edit"></i> Edit</button>
@endif

@if(isset($save))
<button type="submit" class="btn btn-success  save_btn"><i class="fa fa-save"></i> Save</button>
@endif

@if(isset($submit))
<button type="submit" class="btn btn-success  submit_btn"><i class="fa fa-save"></i> Submit</button>
@endif

</div>
