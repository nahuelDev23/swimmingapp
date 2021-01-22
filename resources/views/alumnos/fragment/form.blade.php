@foreach  ($errors->all() as $message)
{{$message}}<br>
@endforeach 
<div class="form-group">
    {!! FORM::label('nombre','Nombre') !!}
    {!! FORM::text('nombre',null,['class'=>'form-control']) !!}
    <br>
    {!! FORM::label('apellido','Apellido') !!}
    {!! FORM::text('apellido',null,['class'=>'form-control']) !!}
    <br>
    {!! FORM::label('categoria_id','Categoria') !!}
    {!! FORM::select('categoria_id',$categorias,['class'=>'form-control']) !!}
    <br>
    {!! FORM::label('sexo','Sexo') !!}
    {!! FORM::select('sexo',['M'=>'Hombre','F'=>'Femenino'],['class'=>'form-control']) !!}
    <br>
    {!! FORM::label('dni','DNI') !!}
    {!! FORM::text('dni',null,['class'=>'form-control']) !!}
    <br>
    <br>
    {!! FORM::label('fecha_nacimiento','Fecha nacimiento') !!}
    {!! FORM::date('fecha_nacimiento',null,['class'=>'form-control']) !!}
    <br>
</div>

<div class="form-group">
    {!! FORM::submit('Enviar') !!}
</div>