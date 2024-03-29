<h1>Name:</h1>
<div class="form-group">
    <label for="title">{{ __('Title') }}</label>
    <input id="title" type="text" class="form-control" name="name" value="{{old('name', optional($cat ?? null)->name)}}">
</div>

<h1>Age:</h1>
<div class="form-group">
    <label for="content">{{ __('Content') }}</label>
    <input class="form-control" id="content" name="age" value="{{old('age', optional($cat ?? null)->age)}}">
</div>

<div class="form-group">
    <label for="content">{{ __('Thumbnail') }}</label>
    <input type="file" name="thumbnail" class="form-control-file"/>
</div>

@errors @enderrors
