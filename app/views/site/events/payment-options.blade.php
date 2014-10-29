@extends('site.layouts._two_column')

@section('content')
    <h1> {{ trans('site.general.payment_options') }}</h1>
        {{ Form::open(['class' => 'form', 'method' => 'post', 'action' => ['PaymentsController@makePayment']]) }}
            {{ Form::hidden('payable_id',$event->id) }}
            {{ Form::hidden('payable_type','EventModel') }}

			<div class='form-actions'>
				<input class="btn btn btn-primary" name="commit" type="submit"
					value="Pay With Paypal" />
			</div>
		</form>
@stop
