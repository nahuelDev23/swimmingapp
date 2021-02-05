<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <h1>agregar tiempos del competidor para una prueba especifica</h1>
        </h2>
       
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            @if (session()->has('message'))
                                {{ session('message') }}
                            @endif
                            @foreach ($errors->all() as $message)
                            {{ $message }}<br>
                        @endforeach
                            {!! Form::open(['route' => 'competencias.store']) !!}
                                @include('competencias.fragment.form')
                            {!! Form::close() !!}
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>