@if ($errors->any())
    <div id="serverErrorsMessage" style="display: none">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(\Illuminate\Support\Facades\Session::has('error'))
    <div id="serverErrorsMessage" style="display: none">
        <ul>
            <li>{{ \Illuminate\Support\Facades\Session::get('error') }}</li>
        </ul>
    </div>
@endif
@if(\Illuminate\Support\Facades\Session::has('success'))
    <div id="serverSuccessMessage" style="display: none">
        <ul>
            <li>{{ \Illuminate\Support\Facades\Session::get('success') }}</li>
        </ul>
    </div>
@endif
@if(\Illuminate\Support\Facades\Session::has('warning'))
    <div id="serverWarningMessage" style="display: none">
        <ul>
            <li>{{ \Illuminate\Support\Facades\Session::get('warning') }}</li>
        </ul>
    </div>
@endif
