<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <h1>Competencia</h1>
            <h2><a href="{{route('resultados.show',$series[0]->competencia_id)}}">Ver resultados</a></h2>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table>
                        <caption>Series</caption>
                        <tr>
                            <th>Nombre serie</th>
                            <th>Prueba</th>
                            <th>Detalles</th>
                        </tr>
                        @foreach($series as $serie)
                        <tr>
                            <td>{{$serie->nombre_serie}}</td>
                            <td>{{$serie->prueba->nombre_prueba}}</td>
                            <td><a href="{{route('series.show',$serie->id)}}">Ver</a></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
        
    
</x-app-layout>

