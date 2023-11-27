  
    @if( isset($custom_form_display) && !empty($custom_form_display))
    @forelse ($custom_form_display as $item)
    <div class="form-group col-md-12">
    <label for="form-control-label">{{  amicrud_form_labels($item['name'])}}</label> <br>
    <input value="@if($item['type']=='file') {{ asset($model->{$item['value']}) }} @else {{ $model->{$item['value']} }} @endif" disabled="true" readonly> 
    <a href="{{asset($model->{$item['value']})}}" target="_blank" class="btn btn-sm btn-info ml-3">view</a>
    </div>

    @empty  
    @endforelse
    @endif

    @forelse($formable as $field => $form)
    @if($form['type']=='text')
    <div class="form-group  col-md-{{$form['col']}}  ">
    <label for="form-control-label">{{  amicrud_form_labels($form_field_names[$field])}}</label>
    <input type="text" value="{!! $model->{$field} !!}" class='form-control'  disabled="true" readonly>
    </div>

    @elseif($form['type']=='text_readonly')
    <div class="form-group  col-md-{{$form['col']}}  ">
    <label for="form-control-label">{{  amicrud_form_labels($form_field_names[$field])}}</label>
    <input type="text" value="{!! $model->{$field} !!}" class='form-control'  disabled="true" readonly>
    </div>

    @elseif($form['type']=='color')
    <div class="form-group col-md-{{$form['col']}} ">
    <label for="form-control-label">{{  amicrud_form_labels($form_field_names[$field])}}</label>
    <input type="color" value="{!! $model->{$field} !!}" class='form-control'  disabled="true" readonly>
    </div>

    @elseif($form['type']=='email')

    <div class="form-group col-md-{{$form['col']}} ">
    <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}</label>
    <input type="email" value="{!! $model->{$field} !!}" class='form-control'  disabled="true" readonly>
    </div>

    @elseif($form['type']=='file')
    <div class="form-group col-md-{{$form['col']}}">
    <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}</label>
    <a href="{{asset($model->{$field})}}" target="_blank" class="btn btn-sm btn-info ml-3">view</a>

    </div>


    @elseif($form['type']=='number')

    <div class="form-group col-md-{{$form['col']}} ">
    <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}</label>
    <input type="number" value="{!! $model->{$field} !!}" class='form-control'  disabled="true" readonly>
    </div>

    @elseif($form['type']=='select')
    <div class="form-group col-md-{{$form['col']}} ">
    <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}</label>
    <select class="form-control" disabled="true" readonly>
    <option value="">select options...</option>
    @forelse($form_select_items[$field] as $k => $v)
    <option value="{{$k}}" @if($model->{$field}==$k) selected @endif>
        {{amicrud_form_labels($v)}}
    </option>
    @empty
    @endforelse
    </select>
    </div>

    @elseif($form['type']=='date')
    <div class="form-group col-md-{{$form['col']}} ">
    <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}</label>
    <input type="date" value="{{(date('Y-m-d', strtotime($model->{$field})) ?? null)}}" class='form-control'  disabled="true" readonly>
    </div>

    @elseif($form['type']=='textarea')

    <div class="form-group col-md-{{$form['col']}} ">
    <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}</label>
    <textarea cols="30" rows="3" class="form-control ">{{$model->{$field} ?? null}}</textarea>
    </div>

    @elseif($form['type']=='textarea_summernote')

    <div class="form-group col-md-{{$form['col']}} ">
    <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}</label>
    <textarea cols="30" rows="3" class="form-control summernote">{{$model->{$field} ?? null}}</textarea>
    </div>

    @elseif($form['type']=='checkbox')
    <div class="form-group col-md-{{$form['col']}} ">
    <label for="form-control-label">{{ amicrud_form_labels($form_field_names[$field]) }}</label>
    <br>
    <div class="row">
    @forelse($form_select_items[$field] as $k => $v)
        <label for="" class="col-md-3">
        <input type="checkbox" data-ignore="true" value="{{$k}}" 
        @if(in_array($v,explode(', ',$model->{$field}))) @checked(true) @endif
        disabled="true" readonly>
            {{amicrud_form_labels($v)}}
        </label>
    @empty
    @endforelse
    </div>

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
            value="{{$k}}" disabled="true" readonly>
            {{amicrud_form_labels($v)}}
    </label>
    @empty
    @endforelse
    </div>
    </div>

    @endif


    @empty
    @endforelse