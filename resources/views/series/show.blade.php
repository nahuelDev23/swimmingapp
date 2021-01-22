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
                                <td>{{$c->competidor->nombre}}</td>
                                <td>{{$c->competidor->apellido}}</td>
                                <td>{{$c->competidor->categoria->nombre_categoria}}</td>
                                <td>{{$c->tiempo}}</td>
                                <td>{{$c->competidor->club->nombre_club}}</td>
                                <td>{{$c->competidor->sexo}}</td>
                                <td>Editar Cancheo</td>
                            </tr>
                            @endforeach
                          
                        </table>
                    </div>
                   <div>
                    {{-- <table>
                        <caption>Competidores aptos para la prueba</caption>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Categoria</th>.
                            <th>Club</th>
                            <th>Sexo</th>
                            <th>Tiempo</th>
                        </tr>
                        @foreach ($competidoresAptos as $ca)
                        <tr>
                            <td>{{$ca->competidor->nombre}}</td>
                            <td>{{$ca->competidor->apellido}}</td>
                            <td>{{$ca->competidor->categoria->nombre_categoria}}</td>
                            <td>{{$ca->competidor->club->nombre_club}}</td>
                            <td>{{$ca->competidor->sexo}}</td>
                            <td>{{$ca->competidor->tiempo_competidor}}</td>
                        </tr>
                        @endforeach
                      
                    </table> --}}
                    
                   </div>
                   <div>  
                    {{-- @foreach ($cancheo_creacion as  $index =>$cc)
                        <table>
                            <caption>Serie {{$index+1}}</caption>
                            <tr>
                                <th>Carril</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Categoria</th>
                                <th>Tiempo</th>
                                <th>Club</th>
                                <th>Sexo</th>
                            </tr>
                            @foreach ($cc as $index => $c)
                            <tr>
                                <td>{{$carriles[$index]}}</td>
                                <td> {{$c->nombre}}</td>
                                <td> {{$c->apellido}}</td>
                                <td> {{$c->competidor->categoria->nombre_categoria}}</td>
                                <td></td>
                                <td> {{$c->competidor->club->nombre_club}}</td>
                                <td> {{$c->sexo}}</td>
                            </tr> 
                            @endforeach
                        </table>
                    @endforeach --}}
                    <tr></tr>
                   </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>