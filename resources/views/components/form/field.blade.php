@props([ 'name', 'label', 'type' => 'text', 'value' => null ])
<div class="space-y-2">
  <label for="{{$name}}" class="label">{{$label}}</label>
  @if($type === 'textarea')
    <textarea name="{{$name}}" id="{{$name}}"
              class="textarea"{{ $attributes }}
        >{{old($name,$value ?? '')}}</textarea>
  @else

    <input type="{{$type}}" class="input" id="{{$name}}" name="{{$name}}"
           value="{{old($name, $value ?? '')}}" {{ $attributes }}>
  @endif

  <x-form.error name="{{ $name }}"/>

</div>
