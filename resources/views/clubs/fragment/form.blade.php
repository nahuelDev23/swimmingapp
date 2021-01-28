<div class="form-group">
    {!! FORM::label('nombre_club','Nombre del club') !!}
    {!! FORM::text('nombre_club',null,['class'=>'form-control','step'=>'1','required']) !!}

</div>

<div class="form-group">
    {!! FORM::submit('Enviar') !!}
</div>