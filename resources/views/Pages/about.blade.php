@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="container">
                    <div class="content">
                        <div class="title">About Page Here!<br>
                            @if (empty($people))
                                There are no people!
                            @endif
                            @foreach ($people as $person)
                                <li> {{ $person }}</li>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection