<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <h1>inscribir competidor a una prueba de la competencia</h1>
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
                            {!! Form::open(['route' => 'inscripciones.store']) !!}
                                @include('inscripciones.fragment.form')
                            {!! Form::close() !!}
                        </div>
                       
                        <table class="text-center">
                            <caption class="table__resultados_caption mb-4">Pruebas Detalles</caption>
                            <tr>
                                <th>Nombre</th>
                                <th>Distancia</th>
                                <th>Estilo</th>
                                <th>Sexo</th>
                                <th>Categoria</th>
                                <th>Nivel</th>
                            </tr>
                            @foreach ($pruebas_de_la_competencia as $prueba)
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

                        @foreach($rs as $index => $r)
                        @if($r->count() != 0)
                        <table class="table__resultados text-center">
                            {{-- estoy pudiendo agregar a un competidor en una prueba donde no tiene un tiempoo registrado --}}
                            <caption class="table__resultados_caption">Alumnos inscriptos a la prueba {{$r[0]->prueba->nombre_prueba}}</caption>
                            <tr>
                                <th>#</th>
                                <th>N° Prueba</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Categoria</th>
                                <th>Tiempo</th>
                                <th>Club</th>
                                <th>Sexo</th>
                            </tr>
                           @foreach($r as $i => $t)
                                <tr class="table__resultados_tr">
                                    <td>{{$i}}</td>
                                    <td>{{$t->prueba->nombre_prueba}}</td>
                                    <td>{{$t->competidor->alumno->nombre}}</td>
                                    <td>{{$t->competidor->alumno->apellido}}</td>
                                    <td>{{$t->competidor->prueba->categoria->nombre_categoria}}</td>
                                    <td>{{$t->competidor->competidor_tiempo}}</td>
                                    <td>{{$t->competidor->alumno->club->nombre_club}}</td>
                                    <td>{{$t->competidor->alumno->sexo}}</td>
                                </tr>
                           @endforeach
                        </table>
                        @endif
                        @endforeach
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>