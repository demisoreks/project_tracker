<div class="form-group row">
    {!! Form::label('order_no', 'Order No. *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::number('order_no', $value = null, ['class' => 'form-control', 'placeholder' => 'Order Number', 'required' => true]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('description', 'Description *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::text('description', $value = null, ['class' => 'form-control', 'placeholder' => 'Description', 'required' => true, 'maxlength' => 100]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('start_date', 'Start Date *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::date('start_date', $value = null, ['class' => 'form-control', 'placeholder' => 'Start Date', 'required' => true]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('end_date', 'End Date *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::date('end_date', $value = null, ['class' => 'form-control', 'placeholder' => 'End Date', 'required' => true]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('weight', 'Weight *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::number('weight', $value = null, ['class' => 'form-control', 'placeholder' => 'Weight', 'required' => true]) !!}
    </div>
</div>
<div class="form-group row">
    <div class="col-md-10 offset-md-2">
        {!! Form::submit($submit_text, ['class' => 'btn btn-primary']) !!}
    </div>
</div>