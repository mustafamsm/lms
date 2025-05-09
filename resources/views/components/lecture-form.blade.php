<div class="container">
    <x-input id="lecture_title" name="lecture_title" label="Lecture Title" placeholder="Enter lecture title"
        value="{{ old('lecture_title') }}" icon="bx bx-pencil" type="text" />
    <label for="exampleFormControlTextarea1">Lecture Description</label>
    <textarea class="form-control mt-2" id="exampleFormControlTextarea1" rows="3" name="content"
        placeholder="Enter lecture content">{{ old('content') }}</textarea>
    <x-input id="url" name="url" label="Lecture Video URL" placeholder="Enter lecture video URL"
        value="{{ old('url') }}" icon="bx bx-pencil" type="text" />
    <button class="btn btn-primary mt-3 save-lecture">Save Lecture</button>
    <button class="btn btn-secondary mt-3 cancel-lecture">Cancel</button>
</div>