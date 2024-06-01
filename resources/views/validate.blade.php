@extends('layouts.app')

@section('content')
    @if (isset($error))
        <div class="alert alert-danger">
            <p>{{ $error }}</p>
        </div>
    @endif
    @if (isset($validate))
        <div class="container my-4">
            <h1 class="mb-5 text-center bg-dark text-light p-4 fs-2 rounded">Validação para Layout CNAB <span class="text-primary text-decoration-underline">{{ $validate->layout }}</span></h1>
            <div><span class="fs-5"> Arquivo:  {{ $fileName }}</span></div>
                <div
                    class="fs-6 mt-1 {{ $validate->status == 'error' ? 'text-danger' : ($validate->status == 'warning' ? 'text-warning' : 'text-success') }}">
                    <i
                        class="{{ $validate->status == 'error' ? 'fa-solid fa-circle-exclamation' : 'fa-solid fa-circle-check' }}"></i>
                    {{ $validate->status == 'success' ? 'Arquivo validado com sucesso' : 'Existem dados que necessitam ser verificados. Confira a tabela abaixo' }}
                </div>
        </div>
        <!-- BLOCO HEADER -->
        <div class="table-responsive mb-4 p-4 rounded border border-secondary-subtle shadow-sm">
            <h2>Bloco Header</h2>
            <table class="table mt-4">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" width="30%">CAMPO</th>
                        <th scope="col" width="30%">CONTEÚDO</th>
                        <th scope="col" width="5%">INICIO/FIM</th>
                        <th scope="col" width="5%">TIPO</th>
                        <th scope="col" width="30%">VALIDAÇÃO</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($validate->response->header as $headerMessage)
                        <tr>
                            <td>{{ $headerMessage->field_number }}: {{ $headerMessage->field_name }}</td>
                            <td>{{ $headerMessage->value }}</td>
                            <td>{{ $headerMessage->start_position }}...{{ $headerMessage->end_position }}</td>
                            <td>{{ $headerMessage->format }}</td>
                            <td class="{{ $headerMessage->validate ? 'text-success' : 'text-danger' }}"><i
                                    class="{{ $validate->status == 'error' ? 'fa-solid fa-circle-exclamation' : 'fa-solid fa-circle-check' }}"></i>
                                {{ $headerMessage->message }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- BLOCO DETAILS -->
        <div class="table-responsive mb-4 p-4 rounded border border-secondary-subtle shadow-sm">
            <h2>Bloco Detalhes</h2>
            <table class="table mt-4">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" width="30%">CAMPO</th>
                        <th scope="col" width="30%">CONTEÚDO</th>
                        <th scope="col" width="5%">>INICIO/FIM</th>
                        <th scope="col" width="5%">>TIPO</th>
                        <th scope="col" width="30%">VALIDAÇÃO</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($validate->response->details as $detailsMessage)
                        <tr>
                            <td>{{ $detailsMessage->field_number }}: {{ $detailsMessage->field_name }}</td>
                            <td>{{ $detailsMessage->value }}</td>
                            <td>{{ $detailsMessage->start_position }}...{{ $detailsMessage->end_position }}</td>
                            <td>{{ $detailsMessage->format }}</td>
                            <td class="{{ $detailsMessage->validate ? 'text-success' : 'text-danger' }}"><i
                                    class="{{ $validate->status == 'error' ? 'fa-solid fa-circle-exclamation' : 'fa-solid fa-circle-check' }}"></i>
                                {{ $detailsMessage->message }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- BLOCO TRAILLER -->
        <div class="table-responsive mb-4 p-4 rounded border border-secondary-subtle shadow-sm">
            <h2>Bloco Trailler</h2>
            <table class="table mt-4">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" width="30%">CAMPO</th>
                        <th scope="col" width="30%">CONTEÚDO</th>
                        <th scope="col" width="5%">>INICIO/FIM</th>
                        <th scope="col" width="5%">>TIPO</th>
                        <th scope="col" width="30%">VALIDAÇÃO</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($validate->response->trailler as $traillerMessage)
                        <tr>
                            <td>{{ $traillerMessage->field_number }}: {{ $traillerMessage->field_name }}</td>
                            <td>{{ $traillerMessage->value }}</td>
                            <td>{{ $traillerMessage->start_position }}...{{ $traillerMessage->end_position }}</td>
                            <td>{{ $traillerMessage->format }}</td>
                            <td class="{{ $traillerMessage->validate ? 'text-success' : 'text-danger' }}"><i
                                    class="{{ $validate->status == 'error' ? 'fa-solid fa-circle-exclamation' : 'fa-solid fa-circle-check' }}"></i>
                                {{ $traillerMessage->message }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
