<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <h1>{{ $competencia->nombre_competencia }}</h1>
            <p>{{ $competencia->detalle }}</p>
            @if($competencia->estado == 0)
                <h2><a href="{{ route('resultados.show', $competencia->id) }}">Ver resultados</a></h2>
            @endif
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (Auth::user()->is_admin == 1) 
                        @if($competencia->estado == 1)
                        <a href="{{route('pruebas.create',$competencia->id)}}">Crear pruebas</a>
                        <br>
                        <a class="bg-gray-400 text-gray-50"
                            href="{{ route('competencias.generarSeriesCancheos', $competencia->id) }}">Generar Series +
                            cancheos</a>
                            <br>
                        {{-- El admin puede agregar un competidor de cualquier club    --}}
                        <a href="{{route('inscripciones.create',$competencia->id)}}">Inscribir competidor a prueba (admin)</a>
                        <br>
                        {{-- El admin puede agregar un el tiempo de un competidor de cualquier club    --}}
                        <a href="{{route('competidores.create',$competencia->id)}}">Agregar tiempos de pruebas para este evento (admin)</a>
                        <br>
                        @endif
                        @if($competencia->estado != 0)
                            {!! Form::open(['route' => ['resultados.store', $competencia->id],'method'=>'post']) !!}
                                <button onclick="return confirm('Seguro?')"  type="submit">Cerrar evento y generar resultados</button>
                            {!! Form::close() !!}
                        @else
                            <h2>Evento finalizado</h2>
                        @endif

                    @else
                        @if($competencia->estado != 0)
                            {{-- Agrego a pruebas_inscripciones --}}
                            {{-- El entrenador puede agregar un competidor a una pruba que sea de su club --}}
                            <a href="{{route('inscripciones.create',$competencia->id)}}">Inscribir competidor a prueba</a>
                            <br>
                            {{-- Agrego a competidors los tiempos de cada prueba por alumno--}}
                            <a href="{{route('competidores.create',$competencia->id)}}">Agregar tiempos de pruebas para este evento</a>
                        @else
                            <h2>Evento finalizado</h2>
                        @endif
                    @endif
                    <div class="grid grid-cols-2 gap-4">

                        <table class="text-center">
                            <caption class="table__resultados_caption mb-4">Series</caption>
                            <tr>
                                <th>Nombre serie</th>
                                <th>Prueba</th>
                                <th>Detalles</th>
                            </tr>
                            @foreach ($series as $serie)
                                @if ($serie->cancheos->count() !== 0)
                                    <tr class="table__resultados_tr">
                                        <td>{{ $serie->nombre_serie }}</td>
                                        <td>{{ $serie->nombre_prueba }}</td>
                                        <td><a href="{{ route('series.show', $serie->id) }}">Ver</a></td>
                                    </tr>
                                @endif
                            @endforeach
                        </table>

                        <table class="text-center">
                            <caption class="table__resultados_caption mb-4">Pruebas</caption>
                            <tr>
                                <th>Nombre</th>
                                <th>Distancia</th>
                                <th>Estilo</th>
                                <th>Sexo</th>
                                <th>Categoria</th>
                                <th>Nivel</th>
                            </tr>
                            @foreach ($pruebas as $prueba)
                                <tr class="table__resultados_tr">
                                    <td>{{ $prueba->nombre_prueba }}</td>
                                    <td>{{ $prueba->distancia }}</td>
                                    <td>{{ $prueba->estilo }}</td>
                                    <td>{{ $prueba->sexo }}</td>
                                    <td>{{ $prueba->categoria->nombre_categoria }}</td>
                                    <td>{{ $prueba->nivel }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
