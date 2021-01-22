<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <h1>{{$competencia->nombre_competencia}}</h1>
            <p>{{$competencia->detalle}}</p>
            <h2><a href="{{route('resultados.show',$competencia->id)}}">Ver resultados</a></h2>
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(Auth::user()->is_admin == 1)
                    <a href="">Crear pruebas</a>
                    <a href="{{route('series.create',$competencia->id)}}">Crear series</a>
                    <a class="bg-gray-400 text-gray-50" href="{{route('competencias.generarSeriesCancheos',$competencia->id)}}">Generar Series + cancheos</a>
                    <a href="">Agregar competidor</a>
                @else
                    <a href="">Agregar competidor</a>
                @endif
                    <div class="grid grid-cols-2 gap-4">
                      
                        <table  class="text-center">
                            <caption class="table__resultados_caption mb-4">Series</caption>
                            <tr>
                                <th>Nombre serie</th>
                                <th>Prueba</th>
                                <th>Detalles</th>
                            </tr>
                            @foreach($series as $serie)
                            <tr class="table__resultados_tr">
                                <td>{{$serie->nombre_serie}}</td>
                                <td>{{$serie->prueba->nombre_prueba}}</td>
                                <td><a href="{{route('series.show',$serie->id)}}">Ver</a></td>
                            </tr>
                            @endforeach
                        </table>

                        <table  class="text-center">
                            <caption class="table__resultados_caption mb-4">Pruebas</caption>
                            <tr>
                                <th>Nombre</th>
                                <th>Distancia</th>
                                <th>Estilo</th>
                                <th>Sexo</th>
                                <th>Categoria</th>
                                <th>Nivel</th>
                            </tr>
                            @foreach($pruebas as $prueba)
                            <tr class="table__resultados_tr">
                                <td>{{$prueba->nombre_prueba}}</td>
                                <td>{{$prueba->distancia}}</td>
                                <td>{{$prueba->estilo}}</td>
                                <td>{{$prueba->sexo}}</td>
                                <td>{{$prueba->categoria->nombre_categoria}}</td>
                                <td>{{$prueba->nivel}}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    
</x-app-layout>

