<div class="form-group">

    {!! FORM::label('prueba_id','Prueba') !!}
    {!! FORM::select('prueba_id',$pruebas_select,null,['class'=>'form-control','required']) !!}

    {!! FORM::label('alumno_id','Alumnos') !!}
    {!! FORM::select('alumno_id',$alumnos_select,null,['class'=>'form-control']) !!}

    {!! FORM::label('competidor_tiempo','Tiempo') !!}
    {!! FORM::time('competidor_tiempo',null,['class'=>'form-control','step'=>'1','required']) !!}

    {!! FORM::hidden('competencia_id',$competencia_id,null,['class'=>'form-control']) !!}


</div>

<div class="form-group">
    {!! FORM::submit('Enviar') !!}
</div>