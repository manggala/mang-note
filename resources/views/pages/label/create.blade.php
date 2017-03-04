<h5>Create New Label</h5>
{!! Form::open(['url' => route('label.store')]) !!}
	<div class="row">
		<div class="input-field">
			{!! Form::text('title', null, ['class'=> 'validate', 'required' => 'required']) !!}
			{!! Form::label('title', 'Label Title', ['placeholder' => 'Label Title']) !!}
		</div>
	</div>
	<div class="row">
		{!! Form::submit('Create', ['class' => 'btn col m4 offset-m4 s12 ']) !!}
	</div>
{!! Form::close() !!}