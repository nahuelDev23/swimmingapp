<div class="form-group">

    {!! FORM::label('prueba_id','Prueba') !!}
    {!! FORM::select('prueba_id',$pruebas_select,null,['class'=>'form-control']) !!}

    {!! FORM::label('competidor_id','Alumnos') !!}
    {!! FORM::select('competidor_id',$competidor_select,null,['class'=>'form-control']) !!}

    {!! FORM::hidden('competencia_id',$competencia_id,null,['class'=>'form-control']) !!}

</div>

<div class="form-group">
    {!! FORM::submit('Enviar') !!}
</div>