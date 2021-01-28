<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <h1>agregar tiempos del competidor para una prueba especifica</h1>
        </h2>
       
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            @if (session()->has('message'))
                                {{ session('message') }}
                            @endif
                            @foreach ($errors->all() as $message)
                            {{ $message }}<br>
                        @endforeach
                            {!! Form::open(['route' => 'clubs.store']) !!}
                                @include('clubs.fragment.form')
                            {!! Form::close() !!}
                        </div>
                        <div>
                            <table class="text-center">
                                <caption class="table__resultados_caption mb-4">Clubs</caption>
                                <tr>
                                    <th>Nombre club</th>
                                    <th>Cantidad de alumnos</th>
                                    <th>Acciones</th>
                                </tr>
                                @foreach ($clubs as $club)
                                    @if ($club->count() !== 0)
                                        <tr class="table__resultados_tr">
                                            <td>{{ $club->nombre_club }}</td>
                                            <td>{{ $club->alumnos_count }}</td>
                                            <td><a href="{{ route('clubs.edit', $club->id) }}">Editar</a></td>
                                        </tr>
                                    @endif
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>