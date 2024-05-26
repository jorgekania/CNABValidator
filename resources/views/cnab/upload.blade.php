<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upload CNAB</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="my-4 text-center">
                <h1>Validador de arquivo CNAB</h1>
            </div>
            <form action="{{ route('cnab.validate') }}" method="POST" enctype="multipart/form-data"
                class="col-lg-12 w-50">
                @csrf
                <div class="mb-3">
                    <label for="file" class="form-label fw-bold">Arquivo CNAB:</label>
                    <input type="file" class="form-control" id="file" name="file" required>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Validar</button>
                </div>
            </form>
            <div class="col-lg-12 mt-4">
                {{-- @yield('content') --}}
                @if (isset($validate))
                    <div
                        class="alert {{ $validate->status == 'error' ? 'alert-danger' : ($validate->status == 'warning' ? 'alert-warning' : 'alert-success') }}">
                        <p><strong>Layout:</strong> CNAB{{ $validate->layout }}</p>
                        <p><strong>Status:</strong> {{ $validate->status }}</p>
                    </div>

                    <div class="response-section">
                        <h4>Retornos da Validação:</h4>

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
            </div>
            <div class="mt-4 text-center text-sm text-gray-500 col-lg-12">
                Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
