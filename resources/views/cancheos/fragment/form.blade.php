<div class="form-group">
    {!! FORM::label('tiempo','Tiempo') !!}
    {!! FORM::time('tiempo',null,['class'=>'form-control','step'=>'1','required']) !!}

</div>

<div class="form-group">
    {!! FORM::submit('Enviar') !!}
</div>