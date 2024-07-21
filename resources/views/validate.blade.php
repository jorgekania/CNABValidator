@extends('layouts.app')

@section('content')
    @if (isset($error))
        <div class="alert alert-danger">
            <p>{{ $error }}</p>
        </div>
    @endif
    @if (isset($validate))
        <div class="container my-4">
            <h1 class="mb-5 text-center bg-dark text-light p-4 fs-2 rounded">Validação para Layout CNAB <span
                    class="text-primary text-decoration-underline">{{ $validate->layout }}</span></h1>
            <div class="d-flex justify-content-between">

                <div>
                    <span class="fs-5"> <b>Arquivo:</b> {{ $fileName }}</span>
                </div>
                <div
                    class="fs-6 mt-1 {{ $validate->status == 'error' ? 'text-danger' : ($validate->status == 'warning' ? 'text-warning' : 'text-success') }}">
                    <i
                        class="{{ $validate->status == 'error' ? 'fa-solid fa-circle-exclamation' : 'fa-solid fa-circle-check' }}"></i>
                    {{ $validate->status == 'success' ? 'Arquivo validado com sucesso' : 'Existem dados que necessitam ser verificados. Confira a tabela abaixo' }}
                </div>
            </div>
        </div>
        <!-- BLOCO HEADER -->
        @component('components.validation-table', ['title' => 'Bloco Header', 'response' => $validate->response->header])
        @endcomponent

        <!-- BLOCO DETAILS -->
        @component('components.validation-table', [
            'title' => 'Bloco Detalhes',
            'response' => $validate->response->details,
        ])
        @endcomponent

        <!-- BLOCO TRAILLER -->
        @component('components.validation-table', [
            'title' => 'Bloco Trailler',
            'response' => $validate->response->trailler,
        ])
        @endcomponent
    @endif
@endsection
