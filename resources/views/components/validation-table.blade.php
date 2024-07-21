<div class="table-responsive mb-4 p-4 rounded border border-secondary-subtle shadow-sm">
    <h2>{{ $title }}</h2>
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
            @foreach ($response as $item)
                <tr>
                    <td>{{ $item->field_number }}: {{ $item->field_name }}</td>
                    <td>{!! $item->value != ''
                        ? $item->value
                        : '<span class="badge bg-warning text-dark">campo preenchido com branco</span>' !!}</td>
                    <td>{{ $item->start_position }}...{{ $item->end_position }}</td>
                    <td>{{ $item->format }}</td>
                    <td class="{{ $item->validate ? 'text-success' : 'text-danger' }}">
                        <i
                            class="{{ $item->validate ? 'fa-solid fa-circle-check' : 'fa-solid fa-circle-exclamation' }}"></i>
                        {{ $item->message }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
