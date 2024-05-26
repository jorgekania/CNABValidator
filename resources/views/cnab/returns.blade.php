@extends('cnab.upload')

@dd($validate)
@section('content')

    @if (isset($validate))
        <div class="alert alert-info">
            <p><strong>Layout:</strong> {{ $validate->layout }}</p>
            <p><strong>Status:</strong> {{ $validate->status }}</p>
        </div>

        <div class="response-section">
            <h4>Mensagens de Retorno:</h4>

            @if (isset($validate->response->header))
                <div class="response-block">
                    <h5>Header:</h5>
                    @if (is_array($validate->response->header))
                        <ul>
                            @foreach ($validate->response->header as $headerMessage)
                                <li>{{ $headerMessage }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p>{{ $validate->response->header }}</p>
                    @endif
                </div>
            @endif

            @if (isset($validate->response->details))
                <div class="response-block">
                    <h5>Details:</h5>
                    @if (is_array($validate->response->details))
                        <ul>
                            @foreach ($validate->response->details as $detailsMessage)
                                <li>{{ $detailsMessage }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p>{{ $validate->response->details }}</p>
                    @endif
                </div>
            @endif

            @if (isset($validate->response->trailer))
                <div class="response-block">
                    <h5>Trailer:</h5>
                    @if (is_array($validate->response->trailer))
                        <ul>
                            @foreach ($validate->response->trailer as $trailerMessage)
                                <li>{{ $trailerMessage }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p>{{ $validate->response->trailer }}</p>
                    @endif
                </div>
            @endif
        </div>
    @elseif(isset($error))
        <div class="alert alert-danger">
            <p>{{ $error }}</p>
        </div>
    @endif

@endsection
