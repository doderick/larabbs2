@if (count($errors))
    <div class="alert alert-danger">
        <h4>有错误发生：</h4>
        <ul>
            @foreach ($errors->all() as $error)
                <li>
                    <span class="glyphicon glyphicon-remove"></span>
                     {{ $error }}
                </li>
            @endforeach
        </ul>
    </div>
@endif