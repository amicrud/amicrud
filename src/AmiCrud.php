<?php

namespace AmiCrud\AmiCrud;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use AmiCrud\AmiCrud\Exports\ViewExport;
use Amicrud\Amicrud\Exports\CsvExport;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\View;
use Dompdf\Dompdf;

/**
 * Class AmiCrud
 *
 * This class provides a CRUD (Create, Read, Update, Delete) interface for a model within the Laravel framework.
 * It extends Laravel's base Controller class to leverage its functionality and includes additional methods
 * to handle CRUD operations efficiently. The class can be used to integrate with views, handle file uploads,
 * export data, and more.
 *
 * @package App\AmiCrud\Package
 */
class AmiCrud extends Controller
{

    /** 
    *** the select_items uses {key => value} array format , 
        the key is the {option value} and value will be displayed for view. 
        Therefore your array should be {(string) key } 
        and {(string) value}. It should be null if the form is not select

    *** form_field_name null will pick the formable key

    *** display_field null means it will not show in the table display , same for export_field.
**/

   /**
     * @var array $fillable An array that defines the fields which are mass assignable.

     */
   public $fillable;
   /** 
    * @var array $formable An array that defines the fields to be displayed and validated in forms.
     'name'=> [
        'type'=>'text',
        'col'=> '4',
        'validate_create' => 'required',
        'validate_update' => 'required',
        'validation_messages' => [
            'required'=> 'name is required',
            'string'=> 'name must be a string,
        ],
        'form_field_name' => null,
        'select_items' => [],
        'display_field' =>  true,
        'export_field' => true,

    ],
    **/
   public $formable;
   /**

     * @var string $form_view The view name that will be used to render forms.

     */
   public $form_view;
     /**
     * @var array Validation rules for creating new entries.
     */
    public $form_create_validation;

    /**
     * @var array Validation rules for updating existing entries.
     */
    public $form_update_validation;

    /**
     * @var array Custom validation messages for form fields.
     */
    public $form_validation_messages;

    /**
     * @var array Custom names for form fields, overriding default field names.
     */
    public $form_field_names;

    /**
     * @var array Key-value pairs for select options in forms. Used for fields with 'select' type.
     */
    public $form_select_items;

    /**
     * @var array Additional information for form fields, like help text or placeholders.
     */
    public $form_info;

    /**
     * @var array Indicates whether each field should be displayed in the table view.
     */
    public $display_field;

    /**
     * @var array Indicates whether each field should be included in export operations.
     */
    public $export_field;

    /**
     * @var array Custom hidden inputs for forms, typically used for passing additional data.
     */
    public $custom_form_hidden_input;

    /**
     * @var string Layout configuration for the page, e.g., sidebars, headers, etc.
     */
    public $page_layout;

    /**
     * @var string Name of the model associated with CRUD operations.
     */
    public $model_name;

    /**
     * @var \Illuminate\Database\Eloquent\Model Instance of the model for CRUD operations.
     */
    public $model;

    /**
     * @var \Illuminate\Database\Eloquent\Builder Custom query for the model. Allows for predefined conditions or joins.
     */
    public $custom_model_query;

    /**
     * @var string Unique identifier for forms, useful for targeting in JavaScript.
     */
    public $form_id;

    /**
     * @var string The target action URL for form submissions.
     */
    public $form_target;

    /**
     * @var string The target URL for listing data, typically used for redirection after actions.
     */
    public $list_target;

    public $show_actions;
    public $view_url;
    public $list_target_route;
    public $main_route;
    public $form_create_route;
    public $index_route;
    public $form_edit_route;
    public $form_delete_route;

    /**
     * @var array Configuration of action buttons and links in the view, such as 'edit', 'delete', etc.
     */
    public $controls;


    /**
     * @var string View name for the main index page. Used to render the primary list of items.
     */
    public $index_view;

    /**
     * @var string View name for export operations. Defines how exported data is formatted.
     */
    public $export_view;

    /**
     * @var string View name for the list. Used for rendering the list part of the CRUD.
     */
    public $list_view;

     /**
     * @var bool To enable or dissable add button.
     */
    public $add_model;

      /**
     * @var bool To enable or dissable export button.
     */
    public $export_model;

      /**
     * @var bool To enable or dissable per page number.
     */
    public $paginate_model;

     /**
     * @var bool To enable or dissable edit button.
     */
    public $edit_model;

     /**
     * @var bool To enable or dissable delete button.
     */
    public $delete_model;

      /**
     * @var mixed 
     */
    public $form_multi_select_value;

    /**
     * @var mixed  Date Range
     */
    public $search_date_from;

      /**
     * @var mixed  Date Range
     */
    public $search_date_to;

      /**
     * @var string  Date Range
     */
    public $search_date_width;

     /**
     * Constructor for the AmiCrud class.
     * Initializes controller instances and any required middleware.
     */
    public function __construct()
    {
        // Initialization code here
    }

    /**

     * Retrieve the model name for CRUD operations.

     * 

     * @return string The name of the model.

     */

   public function model_name(): string
   {
       return $this->model_name;
   }

   /**
     * Retrieve the model instance for CRUD operations.
     * 
     * @return mixed The model instance.
     */

   public function model(): mixed
   {
       return $this->custom_model_query() ? $this->custom_model_query() : $this->model;
   }

   public function custom_model_query(): mixed
   {
       return $this->custom_model_query;
   }
   
   public function fillable(): mixed
    {
        $fillable = [];
        $forms = array_merge($this->custom_form_hidden_input(),$this->formable());
        foreach ($forms as $key => $value) {
            if(!safe_array_access($value,['fillable'])){ continue; }
            $fillable[]=$key;
        }
        return $fillable;
    }

    public function verify_sign_url(Request $request)
    {
        // if (!verify_sign_url($request)) {
        //     if ($request->ajax()) {
        //         return response()->json(['status'=>'error', 'message' => 'Invalid signature'], 403);
        //     }
        //     abort(403, 'Invalid URL signature.');
        // }
    }

   

    public function formable(): mixed
    {
        $this->formable = $this->formable??[];
        // Iterate through each item in the formable array
        foreach ($this->formable as $fieldName => $fieldData) {
            // Set default values for missing properties
            $this->formable[$fieldName] = array_merge([
                'type' => 'text',
                'fillable' => true,
                'col'=> '4',
                'validate_create' => 'required',
                'validate_update' => 'required',
                'validation_messages' => [],
                'form_field_name' => null,
                'select_items' => [],
                'display_field' => true,
                'export_field' => true,
            ], $fieldData);
        }
        return $this->formable;
    }

    public function form_create_validation(): mixed
    {
        $form_create_validation = [];
        $forms = array_merge($this->custom_form_hidden_input(),$this->formable());
            foreach ($forms as $key => $value) {
                if ($val=$value['validate_create']) {
                    $form_create_validation[$key]=$val;
                }
            }
        return $form_create_validation;
    }

    public function form_update_validation(): mixed
    {
        $form_update_validation = [];
        $forms = array_merge($this->custom_form_hidden_input(),$this->formable());
        foreach ($forms as $key => $value) {
            if ($val=$value['validate_update']) {
                $form_update_validation[$key]=$val;
            }
        }
    return $form_update_validation;
    }

    public function form_validation_messages(): mixed
    {
        $form_validation_messages = [];

        foreach ($this->formable() as $key => $value) {
            if ($val=$value['validation_messages']) {
                 $fval=[];
                 foreach ($val as $k => $v) {
                   $fval[$key.'.'.$k]=$v;
                 }
                $form_validation_messages[]= $fval;
            }
        }
      return call_user_func_array('array_merge', $form_validation_messages);
    }

    public function form_field_names(): mixed
    {
        $form_field_names = [];
        foreach ($this->formable() as $key => $value) {
            if (isset($value['form_field_name']) && ($val=$value['form_field_name'])) {
                $form_field_names[$key]=$val;
            }else{
                $form_field_names[$key]=$key;
            }
        }
        return $form_field_names;
        
    }

    public function form_select_items(): mixed
    {
        $form_select_items = [];
        foreach ($this->formable() as $key => $value) {
            if (isset($value['select_items']) && ($val=$value['select_items'])) {
                $form_select_items[$key]=$val;
            }
        }
        return $form_select_items;

    }

    public function display_field(): mixed
    {
        $display_field = [];
        foreach ($this->formable() as $key => $value) {
            if (isset($value['display_field'])&&$value['display_field']) {
                if (is_bool($value['display_field'])) {
                    $display_field[$key]=$key;
                }else{
                    $display_field[$key]=$value['display_field'];
                }
                
            }
        }
        return $display_field;
    }

    public function export_field(): mixed
    {
        $display_field = [];
        foreach ($this->formable() as $key => $value) {
            if ($d=$value['export_field']) {
                if (is_bool($d)) {
                    $display_field[$key]=$key;
                }else{
                    $display_field[$key]=$value['export_field'];
                }
                
            }
        }
        return $display_field;
    }

    public function form_multi_select_value(): mixed
    {
        $form_multi_select_value = [];
        foreach ($this->formable() as $key => $value) {
            if ($value['type']!='checkbox') {continue;}
            $form_multi_select_value[]=$key;
        }
        return $form_multi_select_value;
    }

    public function show_actions(): mixed
    {
        return isset($this->show_actions) ? $this->show_actions : true;
    }

    public function view_url(): mixed
    {
        return $this->view_url;
    }

    public function custom_form_hidden_input(): mixed
    {
        $this->custom_form_hidden_input = $this->custom_form_hidden_input??[];
        // Iterate through each item in the formable array
        foreach ($this->custom_form_hidden_input as $fieldName => $fieldData) {
            // Set default values for missing properties
            $this->formable[$fieldName] = array_merge([
                'fillable' => true,
                'validate_create' => 'required',
                'validate_update' => 'required',
                'validation_messages' => [],
                'display_field' => true,
                'export_field' => true,
            ], $fieldData);
        }

        return $this->custom_form_hidden_input;
    }

    public function form_info(): mixed
    {
        return $this->form_info;
    }

    public function controls():mixed
    {
        return $this->controls ? $this->controls : [ 'save' => true,'cancel' => true,];
    }

    public function main_route():mixed
    {
        return $this->main_route;
    }

    public function index_route():mixed
    {
        return $this->index_route ? $this->index_route : $this->main_route.'.index';
    }

    public function form_create_route():mixed
    {
        return $this->form_create_route ? $this->form_create_route : $this->main_route.'.store';

    }

    public function form_edit_route():mixed
    {
        return $this->form_edit_route ? $this->form_edit_route : $this->main_route.'.edit';
    }

    public function form_delete_route():mixed
    {
        return $this->form_delete_route ? $this->form_delete_route : $this->main_route.'.destroy';
    }

    public function list_target_route():mixed
    {
        return $this->list_target_route ? $this->list_target_route : $this->main_route.'.create';
    }

    public function list_target():mixed
    {
        return $this->list_target ? $this->list_target : '#list-target';
    }

    public function form_target():mixed
    {
        return $this->form_target ? $this->form_target : '#form-target';
    }

    public function form_view():mixed
    {
        return $this->form_view ? $this->form_view : 'amicrud::amicrud.shared.form';
    }

    public function search_date_from():mixed
    {
        return $this->search_date_from ? $this->search_date_from : [
            'value' => null,
            'id' => 'fromDate',
            'class' => 'range_date',
        ];
    }

    public function search_date_to():mixed
    {
        return $this->search_date_to ? $this->search_date_to : [
            'value' => null,
            'id' => 'toDate',
            'class' => 'range_date',
        ];
    }

    public function search_date_width():mixed
    {
        return $this->search_date_width ? $this->search_date_width : '250px';
    }

    public function form_id():mixed
    {
        return $this->form_id ? $this->form_id : 'amicrud-form';
    }

    public function page_layout():mixed
    {
        return $this->page_layout ?? "amicrud::amicrud.layouts.app";
    }

    public function index_view():mixed
    {
       return $this->index_view ?? "amicrud::amicrud.table.general";
    }

    public function list_view():mixed
    {
       return $this->list_view ?? "amicrud::amicrud.table.list";
    }

    public function export_view():mixed
    {
       return $this->export_view ?? "amicrud::amicrud.table.export";
    }

    public function add_model():mixed
    {
       return $this->add_model ?? true;
    }

    public function export_model():mixed
    {
       return $this->export_model ?? true;
    }

    public function paginate_model():mixed
    {
       return $this->paginate_model ?? true;
    }

    public function edit_model():mixed
    {
       return $this->edit_model ?? true;
    }

    public function delete_model():mixed
    {
       return $this->delete_model ?? true;
    }


    public function index(Request $request) :mixed
    {
          if($request->has('export')){
            return $this->export($request);
          }
        $list_contents = $this->model;
        $content = [
              'list_contents' => $list_contents,
              'formable' =>  $this->formable(),
              'form_view' => $this->form_view(),
              'model_name'=> $this->model_name(),
              'show_actions'=> $this->show_actions(),
              'view_url' => $this->view_url(),
              'list_target_route' => $this->list_target_route(),
              'form_create_route' => $this->form_create_route(),
              'form_edit_route' => $this->form_edit_route(),
              'form_delete_route' => $this->form_delete_route(),
              'form_info' => $this->form_info(),
              'form_id' => $this->form_id(),
              'form_target' => $this->form_target(),
              'page_layout' => $this->page_layout(),
              'form_field_names' => $this->form_field_names(),
              'form_update' => false,
              'form_select_items' => $this->form_select_items(),
              'custom_form_hidden_input' => $this->custom_form_hidden_input(),
              'controls' => $this->controls(),
              'display_field' => $this->display_field(),
              'search_date_from' => $this->search_date_from(),
              'search_date_to' => $this->search_date_to(),
              'search_date_width' => $this->search_date_width(),
              'add_model' => $this->add_model(),
              'export_model' => $this->export_model(),
              'paginate_model' => $this->paginate_model(),
              'edit_model' => $this->edit_model(),
              'delete_model' => $this->delete_model(),
          ] ;
          
        return view($this->index_view())->with($content);
    }


        /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id) : mixed
    {
        if (!$this->edit_model()) {return null;}
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
           'form_update' => true,
           'form_select_items' => $this->form_select_items(),
           'custom_form_hidden_input' => $this->custom_form_hidden_input(),
           'controls' => $this->controls(),
         ];
        
         if ($request->ajax()) {
            $res = view($this->form_view(),$data)->render();
            return response()->json($res);
         }
          return view("amicrud::amicrud.table.form-page",$data);
       }else{
         if ($request->ajax()) {
            return response()->json(['status'=>'error', 'message' => ('Could not edit request.')]); 
         } 
        else{
            return response()->back()->with('error', ('Could not edit request.')); 
        }    
       }
    }



         /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request ) : mixed
    {
         // verify url signature
         if ($request->has('search')) {
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
        

        if($request->filled('search') && !empty($this->display_field())) {
            $search = $request->search;
            $displays = array_keys($this->display_field());
            $list_contents = $this->model()->where(function($q) use($displays,$search){
                 $q->where($displays[0], 'like', '%' . $search . '%');
                 if (count($displays)>1) {
                    for ($i = 1; $i < count($displays); $i++) {
                        $q->orWhere($displays[$i], 'like', '%' . $search . '%');
                    }
                 }
            })->get();
        }else{
            $list_contents = $this->model()->all();
        }

        $display_field = $request->has('export') ? $this->export_field() : $this->display_field();

        if($list_contents){
        $data = [
           'model_name'=> $this->model_name(),
           'formable' => $this->formable(),
           'form_view' => $this->form_view(),
           'list_contents' => $list_contents,
           'form_target' => $this->form_target(),
           'list_target' => $this->list_target(),
           'show_actions'=> $this->show_actions(),
           'view_url' => $this->view_url(),
           'display_field' => $display_field,
           'form_edit_route' => $this->form_edit_route(),
           'form_delete_route' => $this->form_delete_route(),
           'controls' => $this->controls(),
           'display_field' => $this->display_field(),
           'search_date_from' => $this->search_date_from(),
           'search_date_to' => $this->search_date_to(),
           'search_date_width' => $this->search_date_width(),
           'add_model' => $this->add_model(),
           'export_model' => $this->export_model(),
           'paginate_model' => $this->paginate_model(),
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
            'export_url' => sign_url(route($this->index_route(), $request->query())),
          ];
          return response()->json($res);
       }else{
         return response()->json(['status'=>'error', 'message' => ('Could not edit request.')]);      
       }
    }



       /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) : mixed
    {

        if ($request->filled('id')&&!$this->edit_model()) 
        {
            return null;
        }elseif (!$request->filled('id')&&!$this->add_model()) {
            return null;
        }
        
         // verify url signature
         $verificationResponse = $this->verify_sign_url($request);
        if ($verificationResponse !== null) {
            return $verificationResponse;
        }

        $validator = Validator::make($request->all(), [
            'id' => 'nullable|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $reload=true;
        if($request->has('id') && !empty($request->get('id'))){
            $formsValidate = $this->form_update_validation();
            $reload=false;
        }else{
            $formsValidate = $this->form_create_validation();
        }
        $request->validate($formsValidate, $this->form_validation_messages());
        // $validated = array_filter($request->only($this->fillable()));
        $validated = ($request->only($this->fillable()));
        $validated['id'] = $request->get('id')??null;

        foreach($request->all($this->fillable()) as $req => $value){
            if (!in_array($req,$this->form_multi_select_value())) {continue;}
                if (is_array($request->get($req))) {
                    $multi_select_value='';
                    foreach ($request->get($req) as $k => $v) {
                        $multi_select_value.=$v.', ';
                    }
                    $multi_select_value = rtrim($multi_select_value, ', ');
                    $validated[$req] = (string) $multi_select_value;
                }else{
                    $validated[$req] = null;
                }
        }
        foreach($request->all($this->fillable()) as $req => $value){
            if (empty($request->file($req)) || !$request->file($req) instanceof UploadedFile ) {continue;}
            $validated[$req] = gallery_file_upload($request->file($req),$this->model_name());
        }
        
        $model = $this->model()->where('id', $validated['id'])->first();
        $createed = false;
        if ($model) {
            foreach ($validated as $key => $value) {
                $model->{$key} = $value;
            }

            // on update 
            if ($createed = $model->save()) {
                $this->updated($model);
            }

        }else{
           $modelCreate = $this->model;
           foreach ($validated as $key => $value) {
            $modelCreate->{$key} = $value;
           }
           // on create 
            if ($createed = $modelCreate->save()) {
                $this->created($modelCreate);
            }
    
        }
         if($createed){
            if ($this->list_target()&&$this->list_target_route()) {
            return response()->json([ 
                'status'=>'success', 'message' =>  ('Data Saved Successfully'),
                'list_target_route' => sign_url(route($this->list_target_route())),
                'list_target' => $this->list_target()
            ]);
            }
        return response()->json(['status'=>'success', 'message' =>  ('Data Saved Successfully'),'reload'=>$reload]);
         }
        return response()->json(['status'=>'error', 'message' => ('Could not create.')]);  
    }
    


    /**
     * called when model added 
     */
    public function created($model) : void
    {
        

    }

     /**
     * called when model updated
     */
    public function updated($model): void
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id) : mixed
    {
        if (!$this->delete_model()) {return null;}
         // verify url signature
         $verificationResponse = $this->verify_sign_url($request);
        if ($verificationResponse !== null) {
            return $verificationResponse;
        }

        try {
        if($record=$this->model()->find($id)){
            $form_file = [];
            foreach ($this->formable() as $key => $value) {
                if ($value['type']=='file') {
                    $form_file[]=$key;
                }
            }
            if ($form_file) {
                 foreach ($form_file as $key => $file) {
                    if(file_exists($record->{$file})){unlink($record->{$file});}
                }
            }
           
             $record->delete();
               if ($this->list_target()&&$this->list_target_route()) {
                return response()->json([ 
                    'status'=>'success',
                    'message' =>  ('Data Deleted Successfully'),
                    'list_target_route' => sign_url(route($this->list_target_route())),
                    'list_target' => $this->list_target()
                ]);
                }
             return response()->json(['status'=>'success', 'message' =>  ('Data Deleted Successfully'),'reload'=>true]);
            }else{
            return response()->json(['status'=>'error', 'message' => ('Could not delete request.')]); 
            }

          } catch (\Exception $ex) {
            log_system_errors($ex);
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage(),
               ]);

        } 
    }


     /**
     * Export resource from create to pdf
     */
    public function export(Request $request) : mixed
    {
         // verify url signature
         $verificationResponse = $this->verify_sign_url($request);
         if ($verificationResponse !== null) {
             return $verificationResponse;
         }

        $validator = Validator::make($request->all(), [
            'signature' => 'required',
        ]);
        if ($validator->fails()) {
            return abort(400, 'Valid Signature Required');
        }

        $create = $this->create($request);
        $name = 'export';
        $view = $this->export_view();
        $data = $create['data'];

        if ($create&&$create['export-type']=='excel') {

            $exportData = View::make($view,$data);
            if (class_exists(Excel::class)) {
                return Excel::download(new ViewExport($exportData), $name . '.xlsx');
            } else {
                return ' Excel package not installed, install  Maatwebsite\Excel via composer.';
            }
    
           }elseif ($create && $create['export-type'] == 'csv') {

            // CSV export logic
            return Excel::download(new CsvExport($data), $name . '.csv');

            } else{
            $html = view($view, $data);
    
            if (class_exists(Dompdf::class)) {

                $dompdf = new Dompdf();
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();
                $dompdf->stream($name.'.pdf');

            } else {
                return ' PDF package not installed, install Dompdf via composer.';
            }

           }
    }
}
