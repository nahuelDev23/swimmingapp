<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <h1>{{$serie->nombre_serie}}</h1>
        </h2>
       
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-2 gap-4">
                    <div>
                        <table>
                            <caption>Descripcion {{$serie->prueba->nombre_prueba}}</caption>
                            <tr>
                                <th>Distancia</th>
                                <th>Estilo</th>
                                <th>Sexo</th>
                                <th>Categoria</th>
                                <th>Nivel</th>
                            </tr>
                           <tr>
                               <td>{{$serie->prueba->distancia}}</td>
                               <td>{{$serie->prueba->estilo}}</td>
                               <td>{{$serie->prueba->sexo}}</td>
                               <td>{{$serie->prueba->categoria->nombre_categoria}}</td>
                               <td>{{$serie->prueba->nivel}}</td>
                           </tr>
                        </table>
                
                        <table>
                            <caption>Cancheo</caption>
                            <tr>
                                <th>Carril</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Categoria</th>
                                <th>Tiempo</th>
                                <th>Club</th>
                                <th>Sexo</th>
                                <th>Acciones</th>
                            </tr>
                            @foreach ($cancheo as $c)
                            <tr>
                                <td>{{$c->carril}}</td>
                                <td>{{$c->competidor->alumno->nombre}}</td>
                                <td>{{$c->competidor->alumno->apellido}}</td>
                                <td>{{$c->competidor->alumno->categoria->nombre_categoria}}</td>
                                <td>{{$c->tiempo}}</td>
                                <td>{{$c->competidor->alumno->club->nombre_club}}</td>
                                <td>{{$c->competidor->alumno->sexo}}</td>
                                <td><a href="{{route('cancheos.edit',$c->id)}}">Editar Cancheo</a></td>
                            </tr>
                            @endforeach
                          
                        </table>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>