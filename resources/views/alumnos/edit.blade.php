<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <h1>Editar Tiempo de prueba</h1>
        </h2>
       
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
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
                    {!! Form::model([
                        'nombre'=>$alumno->nombre,
                        'apellido'=>$alumno->apellido,
                        'categoria_id'=>$alumno->categoria_id,
                        'club_id'=>$alumno->club_id,
                        'sexo'=>$alumno->sexo,
                        'dni'=>$alumno->dni,
                        'fecha_nacimiento'=>$alumno->fecha_nacimiento,
                        ],['route'=>['alumnos.update',$alumno->id],'method'=>'PUT']) !!}
                        @include('alumnos.fragment.form')
                    {!! FORM::close() !!}
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>