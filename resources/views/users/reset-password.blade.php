<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <h1>resetear contraseña</h1>
        </h2>
       
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {!! Form::open(['route' => 'users.reset-password']) !!}
                        {!! FORM::label('password','Contraseña') !!}
                        {!! FORM::password('password',null,['class'=>'form-control','required']) !!}
                        <br>
                        {!! FORM::label('password_confirmation','Repetir Contraseña') !!}
                        {!! FORM::password('password_confirmation',null,['class'=>'form-control','required']) !!}
                        <div class="form-group">
                            {!! FORM::submit('Enviar') !!}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>

