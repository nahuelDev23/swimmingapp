<div class="form-group">
    {!! FORM::label('nombre_serie','Nombre serie') !!}
    {!! FORM::text('nombre_serie',null,['class'=>'form-control']) !!}
    <br>

    {!! FORM::label('prueba_id','Prueba') !!}
    {!! FORM::select('prueba_id',$pruebas,null,['class'=>'form-control']) !!}


    {!! FORM::hidden('competencia_id',$competencia_id,null,['class'=>'form-control']) !!}

</div>

<div class="form-group">
    {!! FORM::submit('Enviar') !!}
</div>