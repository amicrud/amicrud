  
    @if( isset($custom_form_hidden_input) && !empty($custom_form_hidden_input))
    @forelse ($custom_form_hidden_input as $item)
    <input type="hidden" data-ignore="true" name="{{$item['name']}}" value="{{$item['value']}}">
    @empty
    @endforelse
    @endif


    @if( isset($custom_form_display) && !empty($custom_form_display))
    @forelse ($custom_form_display as $item)
    <div class="form-group col-md-12">
    <label for="form-control-label">{{  amicrud_form_labels($item['name'])}}</label> <br>
    <input id="" value="@if($item['type']=='file') {{ asset($model->{$item['value']}) }} @else {{ $model->{$item['value']} }} @endif" disabled="true" class="bg-link" style="width: 90%;" readonly> 
    <a href="{{asset($model->{$item['value']})}}" target="_blank" class="btn btn-sm btn-info ml-3">view</a>
    </div>

    @empty  
    @endforelse
    @endif

    @forelse($formable as $field => $form)
    @if($form['type']=='text')
    <div class="form-group  col-md-{{$form['col']}}  ">
    <label for="form-control-label">{{  amicrud_form_labels($form_field_names[$field])}}</label>
    <input type="text" name="{{$field}}" id="{{$field}}" value="{!! $model->{$field} !!}" class='form-control'>
    <code class=" error-response {{$field}}"></code>
    </div>

    @elseif($form['type']=='text_readonly')
    <div class="form-group  col-md-{{$form['col']}}  ">
    <label for="form-control-label">{{  amicrud_form_labels($form_field_names[$field])}}</label>
    <input type="text" disabled="true" readonly value="{!! $model->{$field} !!}" class='form-control'>
    </div>
    @elseif($form['type']=='text_password')
    <div class="form-group  col-md-{{$form['col']}}  ">
    <label for="form-control-label">{{  amicrud_form_labels($form_field_names[$field])}}</label>
    <input type="password" name="{{$field}}" value="" class='form-control'>
    <code class="error-response {{$field}}"></code>
    </div>

    @elseif($form['type']=='color')
    <div class="form-group col-md-{{$form['col']}} ">
    <label for="form-control-label">{{  amicrud_form_labels($form_field_names[$field])}}</label>
    <input type="color" name="{{$field}}" id="{{$field}}" value="{!! $model->{$field} !!}" class='form-control'>
    <code class="error-response {{$field}}"></code>
    </div>

    @elseif($form['type']=='email')

    <div class="form-group col-md-{{$form['col']}} ">
    <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}</label>
    <input type="email" name="{{$field}}" id="{{$field}}" value="{!! $model->{$field} !!}" class='form-control'>
    <code class="error-response {{$field}}"></code>
    </div>

    @elseif($form['type']=='file')
    <div class="form-group col-md-{{$form['col']}}">
    <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}</label>
    <input type="file" accept="image/jpeg, image/png, image/*,.pdf,.mp4, .doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"  name="{{$field}}" id="{{$field}}" data-default-file="{{asset($model->{$field})}}"
    class="dropify" >
    <code class="error-response {{$field}}"></code>
    </div>


    @elseif($form['type']=='number')

    <div class="form-group col-md-{{$form['col']}} ">
    <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}</label>
    <input type="number" name="{{$field}}" id="{{$field}}" value="{!! $model->{$field} !!}" class='form-control'>
    <code class="error-response {{$field}}"></code>
    </div>

    @elseif($form['type']=='select')
    <div class="form-group col-md-{{$form['col']}} ">
    <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}</label>
    <select name="{{$field}}" id="{{$field}}" class="form-control">
    <option value="">select options...</option>
    @forelse($form_select_items[$field] as $k => $v)
    <option value="{{$k}}" @if($model->{$field}==$k) selected @endif>
        {{amicrud_form_labels($v)}}
    </option>
    @empty
    @endforelse
    </select>
    <code class="error-response {{$field}}"></code>
    </div>

    @elseif($form['type']=='date')
    <div class="form-group col-md-{{$form['col']}} ">
    <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}</label>
    <input type="date" name="{{$field}}" id="{{$field}}" value="{{(date('Y-m-d', strtotime($model->{$field})) ?? null)}}" class='form-control'>
    <code class="error-response {{$field}}"></code>
    </div>

    @elseif($form['type']=='textarea')

    <div class="form-group col-md-{{$form['col']}} ">
    <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}</label>
    <textarea name="{{$field}}" id="{{$field}}" cols="30" rows="3" class="form-control ">{{$model->{$field} ?? null}}</textarea>
    <code class="error-response {{$field}}"></code>
    </div>

    @elseif($form['type']=='textarea_summernote')

    <div class="form-group col-md-{{$form['col']}} ">
    <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}</label>
    <textarea name="{{$field}}" id="{{$field}}" cols="30" rows="3" class="form-control summernote">{{$model->{$field} ?? null}}</textarea>
    <code class="error-response {{$field}}"></code>
    </div>

    @elseif($form['type']=='checkbox')
    <div class="form-group col-md-{{$form['col']}} ">
    <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}</label>
    <br>
    <div class="row">
    @forelse($form_select_items[$field] as $k => $v)
        <label for="" class="col-md-3">
        <input type="checkbox" data-ignore="true" name="{{$field}}[]" value="{{$k}}" 
        @if(in_array($v,explode(', ',$model->{$field}))) @checked(true) @endif
        >
            {{amicrud_form_labels($v)}}
        </label>
    @empty
    @endforelse
    </div>
    <code class="error-response {{$field}}"></code>

    </div>


    @elseif($form['type']=='radio')

    <div class="form-group col-md-{{$form['col']}} ">
    <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}</label>
    <br>
    <div class="row">
    @forelse($form_select_items[$field] as $k => $v)
    <label for="" class="col-md-3">
            <input type="radio" data-ignore="true" 
            @if($model->{$field}==$form_select_items[$field][$v]) @checked(true) @endif 
            name="{{$field}}" value="{{$k}}">
            {{amicrud_form_labels($v)}}
    </label>
    @empty
    @endforelse
    </div>
    <code class="error-response {{$field}}"></code>
    </div>

    @endif


    @empty
    @endforelse