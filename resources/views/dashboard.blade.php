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
                    <div class="grid grid-cols-1 gap-4">
                   <table class="text-center">
                       <caption  class="table__resultados_caption mb-4">Competencias</caption>
                        @if(Auth::user()->is_admin == 1)
                            <a href="">Crear competencia</a>
                        @endif
                       <tr>
                           <th>#</th>
                           <th>Competencia</th>
                           <th>Detalle</th>
                           <th>Fecha de la competencia</th>
                           <th>Detalles</th>
                       </tr>
                       @foreach($competencias as $i => $compe)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$compe->nombre_competencia}}</td>
                            <td>{{$compe->detalle}}</td>
                            <td>{{date('d-m-Y',strtotime($compe->fecha_competencia))}}</td>
                            <td><a href="{{route('competencias.show',$compe->id)}}">Ver</a></td>
                        </tr>
                       @endforeach
                   </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
