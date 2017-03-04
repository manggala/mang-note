{!! Form::open(['url' => route('note.store')]) !!}
	<div class="row">
		<div class="input-field">
			{!! Form::text('title', null, ['class'=> 'validate', 'required' => 'required']) !!}
			{!! Form::label('title', 'Note Title', ['placeholder' => 'Note Title']) !!}
		</div>
	</div>
	<div class="row">
		<div class="input-field">
			{!! Form::textarea('content', null, ['class'=> 'validate materialize-textarea', 'required' => 'required']) !!}
			{!! Form::label('content', 'Write down your notes', ['placeholder' => 'Label Title']) !!}
		</div>
	</div>
	<div class="row">
		{!! Form::label('title', 'Label', ['placeholder' => 'Label']) !!}
		<div class="input-field">
			{!! Form::select('label_id', $data['dropdownLabel'] , null, ['class'=> 'validate browser-default', 'required' => 'required']) !!}
		</div>
	</div>
	<div class="row">
		{!! Form::label('title', 'Deadline Date', ['placeholder' => 'Label']) !!}
		<div class="input-field">
			{!! Form::date('deadlineDate', \Carbon\Carbon::now(), ['class'=> 'validate datepicker', 'required' => 'required']) !!}
		</div>
	</div>
	<div class="row">
		{!! Form::label('title', 'Deadline time', ['placeholder' => 'Label']) !!}
		<div class="input-field">
			{!! Form::time('deadlineTime', '23:59', ['class'=> 'validate datepicker', 'required' => 'required']) !!}
		</div>
	</div>
	<div class="row">
		{!! Form::submit('Create', ['class' => 'btn col m4 offset-m4 s12 ']) !!}
	</div>
{!! Form::close() !!}