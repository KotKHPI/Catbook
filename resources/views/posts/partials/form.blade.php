<h1>Name:</h1>
<div class="form-group">
    <label for="title">Title</label>
    <input id="title" type="text" class="form-control" name="name" value="{{old('name', optional($cat ?? null)->name)}}">
</div>

<h1>Age:</h1>
<div class="form-group">
    <label for="content">Content</label>
    <input class="form-control" id="content" name="age" value="{{old('age', optional($cat ?? null)->age)}}">
</div>


@if($errors->any())
    <div class="mb-3">
        <ul class="list-group">
            @foreach($errors->all() as $error)
                <li class="list-group-item list-group-item-danger">{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif
