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
                        <h1>general</h1>
                        <table class="text-center">
                            <tr>
                                <th>Club</th>
                                <th>Puntaje total</th>
                            </tr>
                            @foreach($puntajes as $p)
                            <tr>
                                <td>
                                    {{$p[0]->nombre_club}}
                                </td>
                                <td> {{$p[0]->resultados_puntaje}}</td>
                            </tr>
                            @endforeach
                        </table>
                       
                           
                           
                        
                    </div>

                </div>
            </div>
        </div>
    </div>
        
    
</x-app-layout>
