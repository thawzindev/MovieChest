<div class="form-group {{ $errors->has($name) ? 'has-danger' : '' }}">
  <label for="{{ $name }}">{{ $title }}</label>

  <select class="form-control" id="{{ $name }}" name="{{ $name }}">
    @foreach($objects as $object)
      <option 
        value="{{ $object['value'] }}"
        {{ old($name, $selected) == $object['value'] ? 'selected': '' }}
      >
        {{ $object[$objectName] }}
      </option>
    @endforeach
  </select>

  @if($errors->has($name))
      <label class="error mt-2 text-danger">{{ $errors->first($name) }}</label>
  @endif
</div>