@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> {{ $error }}
            @endforeach
        </ul>
    </div>
@endif