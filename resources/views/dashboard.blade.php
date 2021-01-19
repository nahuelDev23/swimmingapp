<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                   <table>
                       <caption>Competencias</caption>
                       <tr>
                           <th>Competencia</th>
                           <th>Detalle</th>
                           <th>Created_At</th>
                           <th>Detalles</th>
                       </tr>
                       @foreach($competencias as $compe)
                        <tr>
                            <td>{{$compe->nombre_competencia}}</td>
                            <td>{{$compe->detalle}}</td>
                            <td>{{$compe->created_at}}</td>
                            <td><a href="{{route('competencias.show',$compe->id)}}">Ver</a></td>
                        </tr>
                       @endforeach
                   </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
