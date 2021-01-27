<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <h1>Resultados</h1>
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-2 gap-4">
                    @foreach($resultado as $r_m)
                   
                    @if(count($r_m) != 0)
                        <table class="table__resultados text-center">
                            <caption class="table__resultados_caption">
                                Resultados {{$r_m[0]->serie->prueba->nombre_prueba}} 
                                
                                {{$r_m[0]->serie->prueba->sexo}}
                            </caption>
                            <tr>
                                <th>#</th>
                                <th>N° Prueba</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Categoria</th>
                                <th>Tiempo</th>
                                <th>Club</th>
                                <th>Sexo</th>
                                <th>Puntaje</th>
                            </tr>
                            @foreach ($r_m as $i => $r)
                            <tr class="table__resultados_tr">
                                <td>{{$i}}</td>
                                <td>{{$r->serie->prueba->nombre_prueba}}</td>
                                <td>{{$r->competidor->alumno->nombre}}</td>
                                <td>{{$r->competidor->alumno->apellido}}</td>
                                <td>{{$r->competidor->alumno->categoria->nombre_categoria}}</td>
                                <td>{{$r->tiempo}}</td>
                                <td>{{$r->competidor->alumno->club->nombre_club}}</td>
                                <td>{{$r->competidor->alumno->sexo}}</td>
                                <td>{{$r->puntaje}}</td>
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
