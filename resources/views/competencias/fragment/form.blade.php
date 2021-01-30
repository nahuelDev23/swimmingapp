<div class="form-group">
    {!! FORM::label('nombre_competencia','Nombre de la competencia') !!}
    {!! FORM::text('nombre_competencia',null,['class'=>'form-control','required']) !!}
    <br>
    {!! FORM::label('fecha_competencia','Fecha de la competencia') !!}
    {!! FORM::date('fecha_competencia',null,['class'=>'form-control','required']) !!}
    <br>
    {!! FORM::label('detalle','Detalle') !!}
    {!! FORM::textarea('detalle',null,['class'=>'form-control']) !!}
    <br>
    {!! FORM::label('carriles','N° Carriles') !!}
    {!! FORM::number('carriles',null,['class'=>'form-control']) !!}
</div>

<div class="form-group">
    {!! FORM::submit('Enviar') !!}
</div>