    
     <div class="card">
        <div class="card-body">
         
          @if($form_update&&!empty($model))

              <form action="{{amicrud_sign_url(route($form_create_route))}}" method="POST" class="amicrud {{isset($class)?$class:''}} w-100"
              enctype="multipart/form-data" id="{{$form_id}}">
              @csrf
              <div class="row">

                 <input type="hidden" data-ignore="true" name="id" value="{{$model->id}}">

                 @if( isset($custom_form_hidden_input) && !empty($custom_form_hidden_input))
                 @forelse ($custom_form_hidden_input as $key => $item)
                 <input type="hidden" data-ignore="true" class="ignore" name="{{$key}}" value="{{$item['value']}}">
                 @empty
                 @endforelse
                 @endif


                 @if( isset($custom_form_display) && !empty($custom_form_display))
                 @forelse ($custom_form_display as $item)
                 <div class="form-group col-md-12">
                  <label for="form-control-label">{{  amicrud_form_labels($item['name'])}}
                     @if (in_array($form['validate_update'],["required"])||is_array($form['validate_update']))
                     <span class="text-danger">*</span>
                     @endif 
                  </label> <br>
                  <input id="" value="@if($item['type']=='file') {{ asset($model->{$item['value']}) }} @else {{ $model->{$item['value']} }} @endif" disabled="true" class="bg-link" style="width: 90%;" readonly> 
                  <a href="{{asset($model->{$item['value']})}}" target="_blank" class="btn btn-sm btn-info ml-3">view</a>
                 </div>
                   
                 @empty  
                 @endforelse
                 @endif

                 @forelse($formable as $field => $form)
                  @if($form['type']=='text')
                  <div class="form-group  col-md-{{$form['col']}}  ">
                  <label for="form-control-label">{{  amicrud_form_labels($form_field_names[$field])}} 
                     @if (in_array($form['validate_update'],["required"])||is_array($form['validate_update']))
                     <span class="text-danger">*</span>
                     @endif 
                  </label>
                  <input type="text" name="{{$field}}" id="{{$field}}" value="{!! $model->{$field} !!}" class='form-control'>
                  <code class=" error-response {{$field}}"></code>
                  </div>

                  @elseif($form['type']=='text_readonly')
                  <div class="form-group  col-md-{{$form['col']}}  ">
                  <label for="form-control-label">{{  amicrud_form_labels($form_field_names[$field])}}
                     @if (in_array($form['validate_update'],["required"])||is_array($form['validate_update']))
                     <span class="text-danger">*</span>
                     @endif 
                  </label>
                  <input type="text" disabled="true" readonly value="{!! $model->{$field} !!}" class='form-control'>
                  </div>
                  @elseif($form['type']=='text_password')
                  <div class="form-group  col-md-{{$form['col']}}  ">
                  <label for="form-control-label">{{  amicrud_form_labels($form_field_names[$field])}}
                     @if (in_array($form['validate_update'],["required"])||is_array($form['validate_update']))
                     <span class="text-danger">*</span>
                     @endif 
                  </label>
                  <input type="password" name="{{$field}}" value="" class='form-control'>
                  <code class="error-response {{$field}}"></code>
                  </div>

                  @elseif($form['type']=='color')
                  <div class="form-group col-md-{{$form['col']}} ">
                  <label for="form-control-label">{{  amicrud_form_labels($form_field_names[$field])}}
                     @if (in_array($form['validate_update'],["required"])||is_array($form['validate_update']))
                     <span class="text-danger">*</span>
                     @endif 
                  </label>
                  <input type="color" name="{{$field}}" id="{{$field}}" value="{!! $model->{$field} !!}" class='form-control'>
                  <code class="error-response {{$field}}"></code>
                  </div>

                  @elseif($form['type']=='email')

                  <div class="form-group col-md-{{$form['col']}} ">
                  <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}
                     @if (in_array($form['validate_update'],["required"])||is_array($form['validate_update']))
                     <span class="text-danger">*</span>
                     @endif 
                  </label>
                  <input type="email" name="{{$field}}" id="{{$field}}" value="{!! $model->{$field} !!}" class='form-control'>
                  <code class="error-response {{$field}}"></code>
                  </div>

                  @elseif($form['type']=='file')
                  <div class="form-group col-md-{{$form['col']}}">
                     <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}
                        @if (in_array($form['validate_update'],["required"])||is_array($form['validate_update']))
                        <span class="text-danger">*</span>
                        @endif 
                     </label>
                     <input type="file" accept="image/jpeg, image/png,.mp4, image/*,.pdf, .doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"  name="{{$field}}" id="{{$field}}" data-default-file="{{asset($model->{$field})}}"
                     class="dropify" >
                     <code class="error-response {{$field}}"></code>
                 </div>
                  

                  @elseif($form['type']=='number')

                 <div class="form-group col-md-{{$form['col']}} ">
                  <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}
                     @if (in_array($form['validate_update'],["required"])||is_array($form['validate_update']))
                     <span class="text-danger">*</span>
                     @endif 
                  </label>
                  <input type="number" name="{{$field}}" id="{{$field}}" value="{!! $model->{$field} !!}" class='form-control'>
                  <code class="error-response {{$field}}"></code>
                  </div>

                  @elseif($form['type']=='select')
                  <div class="form-group col-md-{{$form['col']}} ">
                  <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}
                     @if (in_array($form['validate_update'],["required"])||is_array($form['validate_update']))
                     <span class="text-danger">*</span>
                     @endif 
                  </label>
                  <select name="{{$field}}" id="{{$field}}" class="form-control">
                     <option value="">select options...</option>
               
                      
                  @if ($form_select_items)
                    @forelse($form_select_items[$field] as $k => $v)
                    <option value="{{$k}}" @if($model->{$field}==$k) selected @endif>
                        {{amicrud_form_labels($v)}}
                    </option>
                    @empty
                    @endforelse
                  @endif
                  </select>
                  <code class="error-response {{$field}}"></code>
                  </div>

                  @elseif($form['type']=='date')
                   <div class="form-group col-md-{{$form['col']}} ">
                  <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}
                     @if (in_array($form['validate_update'],["required"])||is_array($form['validate_update']))
                     <span class="text-danger">*</span>
                     @endif 
                  </label>
                  <input type="date" name="{{$field}}" id="{{$field}}" value="{{(date('Y-m-d', strtotime($model->{$field})) ?? null)}}" class='form-control'>
                  <code class="error-response {{$field}}"></code>
                  </div>

                  @elseif($form['type']=='textarea')

                  <div class="form-group col-md-{{$form['col']}} ">
                  <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}
                     @if (in_array($form['validate_update'],["required"])||is_array($form['validate_update']))
                     <span class="text-danger">*</span>
                     @endif 
                  </label>
                  <textarea name="{{$field}}" id="{{$field}}" cols="30" rows="3" class="form-control ">{{$model->{$field} ?? null}}</textarea>
                  <code class="error-response {{$field}}"></code>
                  </div>

                   @elseif($form['type']=='textarea_summernote')

                  <div class="form-group col-md-{{$form['col']}} ">
                  <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}
                     @if (in_array($form['validate_update'],["required"])||is_array($form['validate_update']))
                     <span class="text-danger">*</span>
                     @endif 
                  </label>
                  <textarea name="{{$field}}" id="{{$field}}" cols="30" rows="3" class="form-control summernote">{{$model->{$field} ?? null}}</textarea>
                  <code class="error-response {{$field}}"></code>
                  </div>

                  @elseif($form['type']=='textarea_readonly')

                  <div class="form-group col-md-{{$form['col']}} ">
                  <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}
                     @if (in_array($form['validate_update'],["required"])||is_array($form['validate_update']))
                     <span class="text-danger">*</span>
                     @endif 
                  </label>
                  <textarea name="{{$field}}" id="{{$field}}" cols="30" rows="3" class="form-control " readonly dissable >{{$model->{$field} ?? null}}</textarea>
                  <code class="error-response {{$field}}"></code>
                  </div>
                  
                  @elseif($form['type']=='checkbox')
                  <div class="form-group mt-4 col-md-{{$form['col']}} ">
                  <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}
                     @if (in_array($form['validate_update'],["required"])||is_array($form['validate_update']))
                     <span class="text-danger">*</span>
                     @endif 
                  </label>
                   <br>
                   <div class="row">
                  @if ($form_select_items)
                   @forelse($form_select_items[$field] as $k => $v)
                      <label for="" class="col-md-3">
                        {{-- $model->{$field} must return an array of which $v may be included --}}
                        @php
                        if (is_array($model->{$field})) {
                          $mod = $model->{$field};
                        }else{
                          $mod = explode(", ", $model->{$field});
                        }
                        @endphp
                      <input type="checkbox" data-ignore="true" value="{{$k}}" name="{{$field}}[]"
                      @if(in_array($k,$mod)) @checked(true) @endif >
                          {{amicrud_form_labels($v)}}
                      </label>
                   @empty
                   @endforelse
                   @endif
                  </div>
                  <code class="error-response {{$field}}"></code>
  
                  </div>



                  @elseif($form['type']=='radio')

                  <div class="form-group mt-4 col-md-{{$form['col']}} ">
                  <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}
                     @if (in_array($form['validate_update'],["required"])||is_array($form['validate_update']))
                     <span class="text-danger">*</span>
                     @endif 
                  </label>
                   <br>
                   <div class="row">
                     @if ($form_select_items)
                    @forelse($form_select_items[$field] as $k => $v)
                    <label for="" class="col-md-3">
                          <input type="radio" data-ignore="true" 
                          @if($model->{$field}==$form_select_items[$field][$v]) @checked(true) @endif 
                          name="{{$field}}" value="{{$k}}">
                          {{amicrud_form_labels($v)}}
                    </label>
                    @empty
                    @endforelse
                    @endif
                   </div>
                   <code class="error-response {{$field}}"></code>
                  </div>

                  @elseif($form['type']=='inputs')
                  <div class="form-group mt-4 col-md-{{$form['col']}} ">
                  <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}
                     @if (in_array($form['validate_update'],["required"])||is_array($form['validate_update']))
                     <span class="text-danger">*</span>
                     @endif 
                  </label>
                   <br>
                   <div class="row">
                     @if ($form_select_items)
                   @forelse($form_select_items[$field] as $k => $v)
                     <div class="form-group col-md-3 ">
                      <label for="" class="form-control-label"> {{amicrud_form_labels($v)}} </label>
                      <input type="text" class="form-control" data-ignore="true" name="{{$field}}[]" value="{{ $model?->{$field}?->{$v} }}">
                     </div>
                   @empty
                   @endforelse
                   @endif
                  </div>
                  <code class="error-response {{$field}}"></code>
  
                  </div>

                  @endif
                  

                @empty
                @endforelse


              
              </div>
              <div class="process-response mb-3"></div>
              @include("amicrud::amicrud.shared.controls",$controls)
                  
              </form>






   @else






                <form action="{{amicrud_sign_url(route($form_create_route))}}" method="POST" class="amicrud {{isset($class)?$class : ''}}" enctype="multipart/form-data" id="{{$form_id}}">
                    @csrf

               @if( isset($custom_form_hidden_input) && !empty($custom_form_hidden_input))
               @forelse ($custom_form_hidden_input as $key => $item)
               <input type="hidden" data-ignore="true" class="ignore" name="{{$key}}" value="{{$item['value']}}">
               @empty
               @endforelse
               @endif

              <div class="row">
                 @forelse($formable as $field => $form)

                 @if($form['type']=='text')
                 <div class="form-group col-md-{{$form['col']}} ">
                 <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field])}}
                 @if (in_array($form['validate_create'],["required"])||is_array($form['validate_create']))
                 <span class="text-danger">*</span>
                 @endif 
               </label>
                 <input type="text" name="{{$field}}" id="{{$field}}" value="" class='form-control'>
                 <code class="error-response {{$field}}"></code>
                 </div>

                 @elseif($form['type']=='text_password')
                 <div class="form-group  col-md-{{$form['col']}}  ">
                 <label for="form-control-label">{{  amicrud_form_labels($form_field_names[$field])}}
                  @if (in_array($form['validate_create'],["required"])||is_array($form['validate_create']))
                  <span class="text-danger">*</span>
                  @endif 
               </label>
                 <input type="password" name="{{$field}}" value="" class='form-control'>
                 <code class="error-response {{$field}}"></code>
                 </div>

                 @elseif($form['type']=='color')

                 <div class="form-group col-md-{{$form['col']}} ">
                 <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}
                  @if (in_array($form['validate_create'],["required"])||is_array($form['validate_create']))
                  <span class="text-danger">*</span>
                  @endif 
               </label>
                 <input type="color" name="{{$field}}" id="{{$field}}" value="" class='form-control'>
                 <code class="error-response {{$field}}"></code>
                 </div>

                 @elseif($form['type']=='email')

                 <div class="form-group col-md-{{$form['col']}} ">
                 <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}
                  @if (in_array($form['validate_create'],["required"])||is_array($form['validate_create']))
                  <span class="text-danger">*</span>
                  @endif 
               </label>
                 <input type="email" name="{{$field}}" id="{{$field}}" value="" class='form-control'>
                 <code class="error-response {{$field}}"></code>
                 </div>

                 @elseif($form['type']=='file')
                 <div class="form-group col-md-{{$form['col']}} ">
                    <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}
                     @if (in_array($form['validate_create'],["required"])||is_array($form['validate_create']))
                     <span class="text-danger">*</span>
                     @endif 
                  </label>
                    <input type="file" accept="image/jpeg, image/png,.mp4, image/*,.pdf, .doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"  name="{{$field}}" id="{{$field}}" class="dropify" >
                    <code class="error-response {{$field}}"></code>
                </div>
                 

                 @elseif($form['type']=='number')

                <div class="form-group col-md-{{$form['col']}} ">
                 <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}
                  @if (in_array($form['validate_create'],["required"])||is_array($form['validate_create']))
                  <span class="text-danger">*</span>
                  @endif 
               </label>
                 <input type="number" name="{{$field}}" id="{{$field}}" value="" class='form-control'>
                 <code class="error-response {{$field}}"></code>
                 </div>

                 @elseif($form['type']=='select')
                 <div class="form-group col-md-{{$form['col']}} ">
                 <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}
                  @if (in_array($form['validate_create'],["required"])||is_array($form['validate_create']))
                  <span class="text-danger">*</span>
                  @endif 
               </label>
                 <select name="{{$field}}" id="{{$field}}" class="form-control">
                  <option value="" selected>select options...</option>
                  @if ($form_select_items)
                @forelse($form_select_items[$field] as $k => $v)
                <option value="{{$k}}">{{amicrud_form_labels($v)}}</option>
                @empty
                @endforelse
                @endif
                 </select>
                 <code class="error-response {{$field}}"></code>
                 </div>

                @elseif($form['type']=='date')
                <div class="form-group col-md-{{$form['col']}} ">
                <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}
                  @if (in_array($form['validate_create'],["required"])||is_array($form['validate_create']))
                  <span class="text-danger">*</span>
                  @endif 
               </label>
                <input type="date" name="{{$field}}" id="{{$field}}" value="{{date('Y-m-d')}}" class='form-control'>
                <code class="error-response {{$field}}"></code>
                </div>

                @elseif($form['type']=='textarea')

                <div class="form-group col-md-{{$form['col']}} ">
                <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}
                  @if (in_array($form['validate_create'],["required"])||is_array($form['validate_create']))
                  <span class="text-danger">*</span>
                  @endif 
               </label>
                <textarea name="{{$field}}" id="{{$field}}" cols="30" rows="3" class="form-control"></textarea>
                <code class="error-response {{$field}}"></code>
                </div>

                @elseif($form['type']=='textarea_summernote')

                <div class="form-group col-md-{{$form['col']}} ">
                <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}
                  @if (in_array($form['validate_create'],["required"])||is_array($form['validate_create']))
                  <span class="text-danger">*</span>
                  @endif 
               </label>
                <textarea name="{{$field}}" id="{{$field}}" cols="30" rows="3" class="form-control summernote"></textarea>
                <code class="error-response {{$field}}"></code>
                </div>

                @elseif($form['type']=='textarea_readonly')
                <div class="form-group col-md-{{$form['col']}} ">
                <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}
                  @if (in_array($form['validate_create'],["required"])||is_array($form['validate_create']))
                  <span class="text-danger">*</span>
                  @endif 
               </label>
                <textarea name="{{$field}}" id="{{$field}}" cols="30" rows="3" class="form-control " readonly dissable></textarea>
                <code class="error-response {{$field}}"></code>
                </div>

                @elseif($form['type']=='checkbox')

                <div class="form-group mt-4  col-md-{{$form['col']}} ">
                <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}
                  @if (in_array($form['validate_create'],["required"])||is_array($form['validate_create']))
                  <span class="text-danger">*</span>
                  @endif 
               </label>
                 <br>
                 <div class="row">
                  @if ($form_select_items)
                 @forelse($form_select_items[$field] as $k => $v)
                    <label for="" class="col-md-3">
                    <input type="checkbox" data-ignore="true" 
                     name="{{$field}}[]" value="{{$k}}">
                        {{amicrud_form_labels($v)}}
                    </label>
                 @empty
                 @endforelse
                 @endif
                 </div>
                 <code class="error-response {{$field}}"></code>
                </div>


                @elseif($form['type']=='radio')

                <div class="form-group mt-4  col-md-{{$form['col']}} ">
                <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}
                  @if (in_array($form['validate_create'],["required"])||is_array($form['validate_create']))
                  <span class="text-danger">*</span>
                  @endif 
               </label>
                 <br>
                 <div class="row">
                  @if ($form_select_items)
                  @forelse($form_select_items[$field] as $k => $v)
                  <label for="" class="col-md-3">
                        <input type="radio" data-ignore="true"
                        name="{{$field}}" value="{{$k}}">
                        {{amicrud_form_labels($v)}}
                  </label>
                  @empty
                  @endforelse
                  @endif
                 </div>
                 <code class="error-response {{$field}}"></code>
                </div>


                @elseif($form['type']=='inputs')
                <div class="form-group mt-4 col-md-{{$form['col']}} ">
                <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}
                   @if (in_array($form['validate_create'],["required"])||is_array($form['validate_create']))
                   <span class="text-danger">*</span>
                   @endif 
                </label>
                 <br>
                 <div class="row">
                  @if ($form_select_items)
                 @forelse($form_select_items[$field] as $k => $v)
                   <div class="form-group col-md-3 ">
                    <label for="" class="form-control-label"> {{amicrud_form_labels($v)}} </label>
                    <input type="text" class="form-control" data-ignore="true" name="{{$field}}[]">
                   </div>
                 @empty
                 @endforelse
                 @endif
                </div>
                <code class="error-response {{$field}}"></code>

                </div>


                @endif
                 
                @empty
                @endforelse
                   </div>
                   <div class="process-response mb-3"></div>
                   @include("amicrud::amicrud.shared.controls",$controls)
                </form>

      @endif
     
    </div>
</div>


