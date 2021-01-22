@foreach  ($errors->all() as $message)
{{$message}}<br>
@endforeach 
<div class="form-group">
    {!! FORM::label('Nombre','Nombre Entrenador') !!}
    {!! FORM::text('name',null,['class'=>'form-control','required']) !!}
    <br>
    {!! FORM::label('email','E-mail') !!}
    {!! FORM::text('email',null,['class'=>'form-control','required']) !!}
    <br>
    <br>
    {!! FORM::label('club_id','Club al que pertenece') !!}
    {!! FORM::select('club_id',$clubs,null,['class'=>'form-control','required']) !!}
    <br>
    {{-- No muesto los cambos password si estoy editando el usuario --}}
    @if(!request()->routeIs('users.edit'))
        {!! FORM::label('password','Contraseña') !!}
        {!! FORM::password('password',null,['class'=>'form-control','required']) !!}
        <br>
        {!! FORM::label('password_confirmation','Repetir Contraseña') !!}
        {!! FORM::password('password_confirmation',null,['class'=>'form-control','required']) !!}
    @endif
</div>

<div class="form-group">
    {!! FORM::submit('Enviar') !!}
</div>