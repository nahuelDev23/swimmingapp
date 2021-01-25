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
                            {!! Form::open(['route' => 'competidores.store']) !!}
                                @include('competidores.fragment.form')
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

                       
                        @foreach($rs as $r)
                        @if($r->count() != 0)
                        <table class="table__resultados text-center">
                           
                            <caption class="table__resultados_caption">Tiempos registrados por {{$r[0]->prueba->nombre_prueba}}</caption>
                            
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
                                    <td>{{$t->alumno->nombre}}</td>
                                    <td>{{$t->alumno->apellido}}</td>
                                    <td>{{$t->prueba->categoria->nombre_categoria}}</td>
                                    <td>{{$t->competidor_tiempo}}</td>
                                    <td>{{$t->alumno->club->nombre_club}}</td>
                                    <td>{{$t->alumno->sexo}}</td>
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