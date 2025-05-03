{{-- filepath: resources/views/components/input-field.blade.php --}}
  
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <div class="input-group">
        @if ($icon)
            <span class="input-group-text"><i class="{{ $icon }}"></i></span>
        @endif
        <input 
            type="{{ $type }}" 
            class="form-control" 
            id="{{ $id }}" 
            name="{{ $name }}" 
            placeholder="{{ $placeholder }}" 
            @if($type !== 'file') value="{{ old($name, $value) }}" @endif
            @if(isset($accept)) accept="{{ $accept }}" @endif
        >
    </div>
    @error($name)
        <span class="text-danger">{{ $message }}</span>
    @enderror
