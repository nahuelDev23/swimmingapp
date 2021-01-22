<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <h1>Usuarios</h1>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{Route('users.create')}}">Agregar Entrenador</a> 
                    <table class="text-center">
                        <caption class="table__resultados_caption mb-4">Entrenadores de cada club</caption>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Club</th>
                            <th>Es admin</th>
                            <th>Acciones</th>
                        </tr>
                        @foreach ($users as $user)
                            <tr class="table__resultados_tr">
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->club != null ? $user->club->nombre_club : 'Admin' }}</td>
                                <td>{{ $user->is_admin == 1 ? 'Si' : 'No' }}</td>
                                <td>
                                    <a href="{{route('users.edit',$user->id)}}">Editar</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
