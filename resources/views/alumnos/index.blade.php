<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <h1>Alumnos pertenecientes al club {{Auth::user()->club != null ? Auth::user()->club->nombre_club : 'x'}}</h1>
        </h2>
       
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                   <a href="{{Route('alumnos.create')}}">Agregar Alumno</a>

                   <table class="text-center">
                    <caption class="table__resultados_caption mb-4">ALUMNOS club</caption>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Categoria</th>
                        <th>sexo</th>
                        <th>dni</th>
                        <th>fecha de nacimiento</th>
                    </tr>
                    {{-- {{dd($alumnos)}} --}}
                    @foreach ($alumnos as $alumno)
                        <tr class="table__resultados_tr">
                            <td>{{ $alumno->nombre }}</td>
                            <td>{{ $alumno->apellido }}</td>
                            <td>{{ $alumno->categoria->nombre_categoria }}</td>
                            <td>{{ $alumno->sexo }}</td>
                            <td>{{ $alumno->dni }}</td>
                            <td>{{ $alumno->fecha_nacimiento }}</td>
                           
                        </tr>
                    @endforeach
                </table>
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>