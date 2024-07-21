<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Validador de Arquivo CNAB</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body class="p-5">
    <div class="container mt-4">
        <div class="my-4 text-center pb-4">
            <h1><a href="{{ route('cnab.uploadForm') }}" class="text-decoration-none"><i class="fa-solid fa-house"></i>
                    Validador de arquivo CNAB</a></h1>
        </div>
        <div class="row justify-content-center bg-light shadow border rounded pt-4">
            <form action="{{ route('cnab.validate') }}" method="POST" enctype="multipart/form-data"
                class="col-lg-12 w-50">
                @csrf
                <label for="file" class="form-label col-form-label fw-bold">Arquivo CNAB:</label>
                <div class="d-flex">
                    <div class="col-sm-10">
                        <input type="file" class="form-control border-primary" id="file" name="file"
                            required>
                    </div>
                    <div class="col-sm-2 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Validar</button>
                    </div>
                </div>
            </form>
            <div class="col-lg-12 mt-4">
                @yield('content')
            </div>
            <div class="my-4 text-center text-sm text-gray-500 col-lg-12">
                Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
