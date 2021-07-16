<input type="text" name="input_{{$row['_id']}}_{{ $item->getData('index')}}" class="{{ $item->getData('class') }} {{ $item->getData('is_serialzie') ? 'js_serialize_fields' : ''}}" 
data-name={{$item->getData('index')}} "/>

<!-- <select name="select_{{$row['_id']}}_{{ $item->getData('index')}}" class="{{ $item->getData('class') }} {{ $item->getData('is_serialzie') ? 'js_serialize_fields' : ''}}">
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="4">5</option>
</select> -->