<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <h1>Crear Pruebas para la competencia</h1>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-2 gap-4">
                        <!--erros es del  form validate -->
                        <div>
                            @foreach ($errors->all() as $message)
                                {{ $message }}<br>
                            @endforeach
                            @if (session()->has('message'))
                                {{ session('message') }}
                            @endif
                            <!--error es el mensaje personalizado q mando yo por back() -->
                            @if (session()->has('error'))
                                {{ session('error') }}
                            @endif
                            {!! Form::open(['route' => 'pruebas.store']) !!}
                            @include('pruebas.fragment.form')
                            {!! Form::close() !!}
                        </div>

                        <table class="text-center">
                            <caption class="table__resultados_caption mb-4">Pruebas Detalles</caption>
                            <tr>
                                <th>Nombre</th>
                                <th>Distancia</th>
                                <th>Estilo</th>
                                <th>Sexo</th>
                                <th>Categoria</th>
                                <th>Nivel</th>
                                <th>Acción</th>
                            </tr>
                            @foreach ($pruebas_de_la_competencia as $prueba)
                                <tr class="table__resultados_tr">
                                    <td>{{ $prueba->nombre_prueba }}</td>
                                    <td>{{ $prueba->distancia }}</td>
                                    <td>{{ $prueba->estilo }}</td>
                                    <td>{{ $prueba->sexo }}</td>
                                    <td>{{ $prueba->categoria->nombre_categoria }}</td>
                                    <td>{{ $prueba->nivel }}</td>
                                    <td><a href="{{route('pruebas.edit',$prueba->id)}}">Editar</a></td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>

</x-app-layout>
