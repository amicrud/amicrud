    
     <div class="card">
        <div class="card-body">
         <form action="{{route($form_create_route)}}" method="POST" class="amicrud {{isset($class)?$class:''}} w-100"
              enctype="multipart/form-data" id="{{$form_id_update}}">
              @csrf
              <div class="row">

                 @if( isset($custom_form_input) && !empty($custom_form_input))
                 <input type="hidden" data-ignore="true" name="{{$custom_form_input['name']}}" value="{{$custom_form_input['value']}}">
                 @endif

                 @if( isset($custom_form_display) && !empty($custom_form_display))
                 @forelse ($custom_form_display as $item)
                 <div class="form-group col-md-12">
                  <label for="form-control-label">{{  form_labels($item['name'])}}</label> <br>
                  <input id="" value="@if($item['type']=='file') {{ asset($value->{$item['value']}) }} @else {{ $value->{$item['value']} }} @endif" disabled="true" class="bg-link" style="width: 90%;" readonly> <a href="{{asset($value->{$item['value']})}}" target="_blank" class="btn btn-sm btn-info ml-3">view</a>
                 </div>
                   
                 @empty  
                 @endforelse
                 @endif

                 @forelse($forms as $field => $form)
                  @if($form=='text')
                  <div class="form-group  @if(in_array($field,$form_text_format)) col-md-6 @else col-md-4  @endif  ">
                  <label for="form-control-label">{{  form_labels($form_display[$field])}}</label>
                  <input type="text" name="{{$field}}" id="{{$field}}" value="{!! $value->{$field} !!}" class='form-control'>
                  </div>

                  @elseif($form=='text_readonly')
                  <div class="form-group  @if(in_array($field,$form_text_format)) col-md-6 @else col-md-4  @endif  ">
                  <label for="form-control-label">{{  form_labels($form_display[$field])}}</label>
                  <input type="text" disabled="true" value="{!! $value->{$field} !!}" class='form-control'>
                  </div>

                  @elseif($form=='text_password')
                  <div class="form-group  @if(in_array($field,$form_text_format)) col-md-6 @else col-md-4  @endif  ">
                  <label for="form-control-label">{{  form_labels($form_display[$field])}}</label>
                  <input type="password" name="{{$field}}" value="" class='form-control'>
                  </div>

                  @elseif($form=='color')
                  <div class="form-group col-md-4 ">
                  <label for="form-control-label">{{  form_labels($form_display[$field])}}</label>
                  <input type="color" name="{{$field}}" id="{{$field}}" value="{!! $value->{$field} !!}" class='form-control'>
                  </div>

                  @elseif($form=='email')

                  <div class="form-group col-md-4 ">
                  <label for="form-control-label">{{ form_labels($form_display[$field]) }}</label>
                  <input type="email" name="{{$field}}" id="{{$field}}" value="{!! $value->{$field} !!}" class='form-control'>
                  </div>

                  @elseif($form=='file')
                  <div class="form-group col-md-4">
                     <label for="form-control-label">{{ form_labels($form_display[$field]) }}</label>
                     <input type="file" accept="image/jpeg, image/png,.mp4, image/*,.pdf, .doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"  name="{{$field}}" id="{{$field}}" data-default-file="{{asset($value->{$field})}}"
                     
                     class="dropify" >
                 </div>
                  

                  @elseif($form=='number')

                 <div class="form-group col-md-4 ">
                  <label for="form-control-label">{{ form_labels($form_display[$field]) }}</label>
                  <input type="number" name="{{$field}}" id="{{$field}}" value="{!! $value->{$field} !!}" class='form-control'>
                  </div>

                  @elseif($form=='select')
                  <div class="form-group col-md-4 ">
                  <label for="form-control-label">{{ form_labels($form_display[$field]) }}</label>
                  <select name="{{$field}}" id="{{$field}}" class="form-control">
                     <option value="">select options...</option>
                    @forelse($form_selects[$field] as $k => $v)
                    <option value="{{$k}}" @if($value->{$field}==$k) selected @endif>
                        {{form_labels($v)}}
                    </option>
                    @empty
                    @endforelse
                  </select>
                  </div>

                  @elseif($form=='date')
                   <div class="form-group col-md-4 ">
                  <label for="form-control-label">{{ form_labels($form_display[$field]) }}</label>
                  <input type="date" name="{{$field}}" id="{{$field}}" value="{{(date('Y-m-d', strtotime($value->{$field})) ?? null)}}" class='form-control'>
                  </div>

                  @elseif($form=='textarea')

                  <div class="form-group col-md-12 ">
                  <label for="form-control-label">{{ form_labels($form_display[$field]) }}</label>
                  <textarea name="{{$field}}" id="{{$field}}" cols="30" rows="3" class="form-control ">{{$value->{$field} ?? null}}</textarea>
                  </div>
                  

                  @elseif($form=='textarea_summernote')
                  <div class="form-group col-md-12 ">
                  <label for="form-control-label">{{ form_labels($form_display[$field]) }}</label>
                  <textarea name="{{$field}}" id="{{$field}}" cols="30" rows="3" class="form-control summernote">{{$value->{$field} ?? null}}</textarea>
                  </div>
                  

                  @elseif($form=='checkbox')
                  <div class="form-group col-md-6 ">
                  <label for="form-control-label">{{ form_labels($form_display[$field]) }}</label>
                   <br>
                   @forelse($form_selects[$field] as $k => $v)
                      <label for="">
                      <input type="checkbox" data-ignore="true" value="{{$k}}" name="{{$field}}[]" value="{{$k}}" @if(in_array($k, $value->{$field})) checked="" @endif >
                          {{form_labels($v)}}
                      </label> &emsp13; &emsp13;
                   @empty
                   @endforelse
  
                  </div>

                  @endif
                  

                @empty
                @endforelse

              </div>
              <div class="process-response mb-3"></div>
              @include("amicrud::amicrud.shared.controls",$controls)
                  
              </form>


     
    </div>
</div>


