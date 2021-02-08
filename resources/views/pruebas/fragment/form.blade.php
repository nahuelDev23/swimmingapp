<div class="form-group">
    {!! FORM::label('nombre_prueba','Nombre Prueba') !!}
    {!! FORM::text('nombre_prueba',null,['class'=>'form-control']) !!}
    <br>

    {!! FORM::label('distancia','Distancia') !!}
    {!! FORM::text('distancia',null,['class'=>'form-control']) !!}
    <br>

    {!! FORM::label('estilo','Estilo') !!}
    {!! FORM::select('estilo',['PECHO'=>'PECHO','LIBRE'=>'LIBRE','COMBINADO'=>'COMBINADO','ESPALDA'=>'ESPALDA'],null,['class'=>'form-control']) !!}
    <br>
    {!! FORM::label('sexo','Sexo') !!}
    {!! FORM::select('sexo',['MIXTO'=>'MIXTO','MUJERES'=>'MUJERES','VARONES'=>'VARONES'],null,['class'=>'form-control']) !!}
    <br>
    {!! FORM::label('nivel','Nivel') !!}
    {!! FORM::select('nivel',['ESCUELA'=>'ESCUELA','PROMO'=>'PROMO'],null,['class'=>'form-control']) !!}
    <br>
    {!! FORM::label('categoria_id','Categoria') !!}
    {!! FORM::select('categoria_id',$categorias_select,null,['class'=>'form-control']) !!}
    <br>

    {!! FORM::hidden('competencia_id',$competencia_id,null,['class'=>'form-control']) !!}

</div>

<div class="form-group">
    {!! FORM::submit('Enviar') !!}
</div>