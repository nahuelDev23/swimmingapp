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
                    <table>
                        <caption>Cancheo</caption>
                        <tr>
                            <th>N° Prueba</th>
                            <th>Carril</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Categoria</th>
                            <th>Tiempo</th>
                            <th>Club</th>
                            <th>Sexo</th>
                        </tr>
                        @foreach ($resultadoPreInfantilesPrueba1 as $rpip1)
                        <tr>
                            <td>{{$rpip1->serie->prueba->nombre_prueba}}</td>
                            <td>{{$rpip1->carril}}</td>
                            <td>{{$rpip1->competidor->nombre}}</td>
                            <td>{{$rpip1->competidor->apellido}}</td>
                            <td>{{$rpip1->competidor->categoria->nombre_categoria}}</td>
                            <td>{{$rpip1->tiempo}}</td>
                            <td>{{$rpip1->competidor->club->nombre_club}}</td>
                            <td>{{$rpip1->competidor->sexo}}</td>
                        </tr>
                        @endforeach
                      
                    </table>
                </div>
            </div>
        </div>
    </div>
        
    
</x-app-layout>
