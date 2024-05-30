@extends('layouts.app')

@section('content')
    @if (isset($error))
        <div class="alert alert-danger">
            <p>{{ $error }}</p>
        </div>
    @endif
    @if (isset($validate))
        <div class="container mb-4">
            <h1 class="mb-5">Validação Layout {{ $validate->layout }}
                <div
                    class="fs-6 {{ $validate->status == 'error' ? 'text-danger' : ($validate->status == 'warning' ? 'text-warning' : 'text-success') }}">
                    ({{ $validate->status == 'success' ? 'Arquivo validado com sucesso' : 'existem dados que necessitam ser verificados. Confira a tabela abaixo' }})
                </div>
            </h1>
        </div>
        <!-- BLOCO HEADER -->
        <div class="container mb-4">
            <div class="row border border-primary p-2">
                <h2>Bloco Header</h2>
                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th scope="col">CAMPO</th>
                            <th scope="col">CONTEÚDO</th>
                            <th scope="col">INICIO/FIM</th>
                            <th scope="col">TIPO</th>
                            <th scope="col">VALIDAÇÃO</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach ($validate->response->header as $headerMessage)
                            <tr>
                                <th scope="row">{{ $headerMessage->field_number }}</th>
                                <td>{{ $headerMessage->value }}</td>
                                <td>{{ $headerMessage->start_position }}...{{ $headerMessage->end_position }}</td>
                                <td>{{ $headerMessage->format }}</td>
                                <td class="{{ $headerMessage->validate ? 'text-success' : 'text-danger' }}">
                                    {{ $headerMessage->message }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- BLOCO DETAILS -->
        <div class="container mb-4">
            <div class="row border border-primary p-2">
                <h2>Bloco Detalhes</h2>
                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th scope="col">CAMPO</th>
                            <th scope="col">CONTEÚDO</th>
                            <th scope="col">INICIO/FIM</th>
                            <th scope="col">TIPO</th>
                            <th scope="col">VALIDAÇÃO</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach ($validate->response->details as $detailsMessage)
                            <tr>
                                <th scope="row">{{ $detailsMessage->field_number }}</th>
                                <td>{{ $detailsMessage->value }}</td>
                                <td>{{ $detailsMessage->start_position }}...{{ $detailsMessage->end_position }}</td>
                                <td>{{ $detailsMessage->format }}</td>
                                <td class="{{ $detailsMessage->validate ? 'text-success' : 'text-danger' }}">
                                    {{ $detailsMessage->message }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- BLOCO TRAILLER -->
        <div class="container">
            <div class="row border border-primary p-2">
                <h2>Bloco Trailler</h2>
                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th scope="col">CAMPO</th>
                            <th scope="col">CONTEÚDO</th>
                            <th scope="col">INICIO/FIM</th>
                            <th scope="col">TIPO</th>
                            <th scope="col">VALIDAÇÃO</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach ($validate->response->trailler as $traillerMessage)
                            <tr>
                                <th scope="row">{{ $traillerMessage->field_number }}</th>
                                <td>{{ $traillerMessage->value }}</td>
                                <td>{{ $traillerMessage->start_position }}...{{ $traillerMessage->end_position }}</td>
                                <td>{{ $traillerMessage->format }}</td>
                                <td class="{{ $traillerMessage->validate ? 'text-success' : 'text-danger' }}">
                                    {{ $traillerMessage->message }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
