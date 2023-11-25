<?php

namespace AmiCrud\AmiCrud;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AmiCrudTable extends AmiCrud{

          /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     /** 
         *** the select_items uses {key => value} array format , 
               the key is the {option value} and value will be displayed for view. 
               Therefore your array should be {(string) key } 
               and {(string) value}. It should be null if the form is not select

         *** form_field_name null will pick the formable key

         *** display_field null means it will not show in the table display
         */
        
    public function edit(Request $request, $id) : mixed
    {

         // verify url signature
         $verificationResponse = $this->verify_sign_url($request);
         if ($verificationResponse !== null) {
             return $verificationResponse;
         }

        $model= $this->model()->find($id);
        if($model){
          
        $data = [
           'model' => $model,
           'model_action' => 'Update',
           'model_name' => $this->model_name(),
           'form_create_route' => $this->form_create_route(),
           'form_id' => $this->form_id(),
           'form_field_names' => $this->form_field_names(),
           'form_view' => $this->form_view(),
           'formable' => $this->formable(),
           'page_layout' => $this->page_layout(),
           'form_update' => true,
           'form_select_items' => $this->form_select_items(),
           'custom_form_hidden_input' => $this->custom_form_hidden_input(),
           'controls' => $this->controls(),
         ];
          
          if ($request->ajax()) {
            $res = view($this->form_view(),$data)->render();
             return response()->json($res);
          }
          return view("amicrud.table.form-page",$data);

        } else{

        // add form
        $data = [
            'form_create_route' => $this->form_create_route(),
            'form_id' => $this->form_id(),
            'model_action' => 'Create',
            'model_name' => $this->model_name(),
            'form_field_names' => $this->form_field_names(),
            'form_view' => $this->form_view(),
            'formable' => $this->formable(),
            'page_layout' => $this->page_layout(),
            'form_update' => false,
            'form_select_items' => $this->form_select_items(),
            'custom_form_hidden_input' => $this->custom_form_hidden_input(),
            'controls' => $this->controls(),
          ];
            if ($request->ajax()) {
                $res = view($this->form_view(),$data)->render();
                return response()->json($res);  
            } 
          return view("amicrud.table.form-page",$data);
       }
    }


    public function create(Request $request ) : mixed
    {
      if ($request->has('search')) {
          // verify url signature
          $verificationResponse = $this->verify_sign_url($request);
          if ($verificationResponse !== null) {
              return $verificationResponse;
          }
        }

        $validator = Validator::make($request->all(), [
          'search' => 'nullable|string|max:255',
          'export' => 'nullable|string|max:255',
          'export-type' => 'nullable|string|max:255',
      ]);
  
      if ($validator->fails()) {
          return response()->json(['errors' => $validator->errors()], 400);
      }
        
        $list_contents = $this->model();

        $perPage = $request->filled('paginated_number')?$request->paginated_number:default_pagination_number();
        
        $startDate = date('Y-m-d',strtotime($request->from_date));
        $endDate = date('Y-m-d',strtotime($request->to_date));

        if($request->filled('from_date')&&$request->filled('to_date')&&($startDate!=$endDate)) {
          $list_contents = $list_contents->whereBetween('created_at', [$startDate, $endDate]);

        }elseif ($request->filled('from_date')) {
          $list_contents = $list_contents->whereDate('created_at', '=', $startDate);

        }elseif ($request->filled('to_date')) {
          $list_contents = $list_contents->whereDate('created_at', '=', $endDate);
        }
  

        if($request->filled('search') && !empty($this->display_field())) {

            $search = $request->search;
            $displays = array_keys($this->display_field());
            $list_contents = $list_contents->where(function($q) use($displays,$search){
                 $q->where($displays[0], 'like', '%' . $search . '%');
                 if (count($displays)>1) {
                    for ($i = 1; $i < count($displays); $i++) {
                        $q->orWhere($displays[$i], 'like', '%' . $search . '%');
                    }
                 }
            })->orderBy('id','desc');

            if($request->has('export')){
              $list_contents = $list_contents->get();
              }else{
              $list_contents = $list_contents->paginate($perPage);
              }

        }
        elseif($request->filled('page')) {
            // for pagination
            $currentPage = $request->input('page', 1); // Get the current page from the request, default to 1 if not provided
            $list_contents = $list_contents->orderBy('id','desc');

            if($request->has('export')){
              $list_contents = $list_contents->get();
              }else{
                $list_contents = $list_contents->paginate($perPage, ['*'], 'page', $currentPage);
                $list_contents->appends(['page' => $currentPage]);
              }

         }
        else{
            $list_contents = $list_contents->orderBy('id','desc');

            if($request->has('export')){
            $list_contents = $list_contents->get();
            }else{
            $list_contents = $list_contents->paginate($perPage);
            }
        }
        if($list_contents){
        $display_field = $request->has('export') ? $this->export_field() : $this->display_field();
        $data = [
           'model_name'=> $this->model_name(),
           'formable' => $this->formable(),
           'list_contents' => $list_contents,
           'form_target' => $this->form_target(),
           'list_target' => $this->list_target(),
           'show_actions'=> $this->show_actions(),
           'form_view' => $this->form_view(),
           'view_url' => $this->view_url(),
           'display_field' => $display_field,
           'form_edit_route' => $this->form_edit_route(),
           'form_delete_route' => $this->form_delete_route(),
           'edit_model' => $this->edit_model(),
           'delete_model' => $this->delete_model(),
         ];

         if($request->has('export')){
          $data['export'] = true;
            return [
                'data' => $data,
                'export-type' => $request->get('export-type'),
            ];
          }
          $res = view($this->list_view(),$data)->render();
          
          $request->merge(['export' => true,]);
          $res = [
            'data' => $res,
            'other_data' => null,
            'export_url' => sign_url(route($this->index_route(), $request->query())),
          ];
          return response()->json($res);
       }else{
         return response()->json(['message' => error_message('Could not edit request.')]);      
       }
    }


}
