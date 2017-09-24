@extends('roboplanner.layouts.template')
@section('title', $header)
@section('styles')
	<link rel="stylesheet" href="{{ asset('css/jquery.idealforms.css')  }}">
	<style>
		.highlight_error{
			border: solid 1px #990000 !important;
		}
	</style>
@endsection
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="navbar navbar-default bootstrap-admin-navbar-thin">
				<ol class="breadcrumb bootstrap-admin-breadcrumb">
					<li><a href="{{ route('dashboard') }}">Dashboard</a></li>
					<li><a href="{{ route('taxes') }}">Taxes</a></li>
					<li class="active">{{ $header }}</li>
				</ol>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default bootstrap-admin-no-table-panel">
				<div class="panel panel-default bootstrap-admin-no-table-panel">
					<div class="panel-heading">
						<div class="text-muted bootstrap-admin-box-title">{{ $header }}</div>
					</div>
					<div class="bootstrap-admin-no-table-panel-content bootstrap-admin-panel-content collapse in">
						@if(Session::has('message'))
							<div class="alert alert-success alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								{{ Session::get('message') }}
							</div>
						@elseif(count($errors) > 0 )
							<div class="alert alert-box alert-danger alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								@if(!$errors->has('single_filters_from_error') && $errors->has('married_filling_jointly_from_error') && $errors->has('married_filling_separately_from') && $errors->has('head_of_household_from_error'))
								<div>The highlighted fields are required!</div>
								@endif
								{{--@foreach ($errors->all() as $error)--}}
								@if($errors->has('single_filters_from_error'))
								<div>{{ $errors->first('single_filters_from_error') }}</div>
								@endif
								@if($errors->has('married_filling_jointly_from_error'))
								<div>{{ $errors->first('married_filling_jointly_from_error') }}</div>
								@endif
								@if($errors->has('married_filling_separately_from'))
								<div>{{ $errors->first('married_filling_separately_from') }}</div>
								@endif
								@if($errors->has('head_of_household_from_error'))
								<div>{{ $errors->first('head_of_household_from_error') }}</div>
								@endif
								{{--@endforeach--}}
							</div>
							{{--@foreach ($errors->all() as $error)--}}
								{{--<div class="alert alert-box alert-dismissible" role="alert">--}}
									{{--<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>--}}
									{{--<li style="list-style:none">{{ $error }}</li>--}}
								{{--</div>--}}
							{{--@endforeach--}}
						@endif
						<form action="{{ $action }}" method="post">
							<div class="row form-group">
								<div class="col-md-6">
									<div class="row">
										<div class="col-sm-6">
											<label for="tax_rate">Tax Rate:</label>
											<input type="text" name="tax_rate" id="tax_rate" placeholder="%" value="{{ $tax_rate }}" class="form-control percentage {{ ($errors->has('tax_rate')) ? 'highlight_error' : '' }}" >
										</div>
										<div class="col-sm-6">
											<label for="due_date">Due Date</label>
											<input type="text" name="due_date" id="due_date" class="form-control datepicker {{ ($errors->has('due_date')) ? 'highlight_error' : '' }}" value="{{ $due_date }}">
										</div>
									</div>

								</div>
								<div class="col-md-6">
									<label>Single Filers</label>
									<div class="row">
										<div class="col-sm-4"><input type="text" name="single_filters_from" id="single_filters_from" placeholder="From $" value="{{ $single_filters_from }}" class="form-control currency"></div>
										<div class="col-sm-4"><input type="text" name="single_filters_to" id="single_filters_to" placeholder="To $" value="{{ $single_filters_to }}" class="to_more form-control {{ $single_filters_to == 'or more' ? '' : 'currency' }} {{ ($errors->has('single_filters_to')) ? 'highlight_error' : '' }}" {{ $single_filters_to == 'or more' ? 'disabled="disabled"' : '' }}></div>
										<div class="col-sm-4"><label for="single_filters_or_more"><input type="checkbox" name="single_filters_or_more" id="single_filters_or_more" class="or_more" {{ $single_filters_to == 'or more' ? 'checked' : '' }}> or more</label></div>
									</div>

								</div>
							</div>
							<div class="row form-group">
								<div class="col-md-6">
									<label for="married_filling_jointly">Married Filing Jointly or qualifying widow/widower</label>
									<div class="row">
										<div class="col-sm-4"><input type="text" name="married_filling_jointly_from" id="married_filling_jointly_from" placeholder="From $" value="{{ $married_filling_jointly_from }}" class="form-control currency "></div>
										<div class="col-sm-4"><input type="text" name="married_filling_jointly_to" id="married_filling_jointly_to" placeholder="To $" value="{{ $married_filling_jointly_to }}" class="to_more form-control {{ $married_filling_jointly_to == 'or more' ? '' : 'currency' }} {{ ($errors->has('married_filling_jointly_to')) ? 'highlight_error' : '' }}" {{ $married_filling_jointly_to == 'or more' ? 'disabled="disabled"' : '' }}></div>
										<div class="col-sm-4"><label for="married_filling_jointly_or_more"><input type="checkbox" name="married_filling_jointly_or_more" id="married_filling_jointly_or_more" class="or_more" {{ $married_filling_jointly_to == 'or more' ? 'checked' : '' }}> or more</label></div>
									</div>

								</div>
								<div class="col-md-6">
									<label for="married_filling_separately">Married Filing Separately</label>
									<div class="row">
										<div class="col-sm-4"><input type="text" name="married_filling_separately_from" id="married_filling_separately_from" placeholder="From $" class="form-control currency " value="{{ $married_filling_separately_from }}"></div>
										<div class="col-sm-4"><input type="text" name="married_filling_separately_to" id="married_filling_separately_to" placeholder="To $" class="to_more form-control {{ $married_filling_separately_to == 'or more' ? '' : 'currency' }} {{ ($errors->has('married_filling_separately_to')) ? 'highlight_error' : '' }}" value="{{ $married_filling_separately_to }}" {{ $married_filling_separately_to == 'or more' ? 'disabled="disabled"' : '' }}></div>
										<div class="col-sm-4"><label for="married_filling_separately_to_or_more"><input type="checkbox" name="married_filling_separately_to_or_more" id="married_filling_separately_to_or_more" class="or_more" {{ $married_filling_separately_to == 'or more' ? 'checked' : '' }}> or more</label></div>
									</div>

								</div>
							</div>
							<div class="row form-group">
								<div class="col-md-6">
									<label for="head_of_household">Head of Household</label>
									<div class="row">
										<div class="col-sm-4"><input type="text" name="head_of_household_from" id="head_of_household_to" placeholder="From $" value="{{ $head_of_household_from }}" class="form-control currency"></div>
										<div class="col-sm-4"><input type="text" name="head_of_household_to" id="head_of_household_to" placeholder="To $" value="{{ $head_of_household_to }}" class="to_more form-control {{ $head_of_household_to == 'or more' ? '' : 'currency'}} {{ ($errors->has('head_of_household_to')) ? 'highlight_error' : '' }}" {{ $head_of_household_to == 'or more' ? 'disabled="disabled"' : ''}}></div>
										<div class="col-sm-4"><label for="head_of_household_to_or_more"><input type="checkbox" name="head_of_household_to_or_more" id="head_of_household_to_or_more" value="yes" class="or_more" {{ $head_of_household_to == 'or more' ? 'checked' : ''}}> or more</label></div>
									</div>

								</div>
								<div class="col-md-6">

								</div>
							</div>
							{!! csrf_field() !!}
							<button type="submit" class="btn btn-lg btn-primary" >{{ $header }}</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('scripts')
	<script src="{{ asset('js/extensions/jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.js') }}"></script>
	<script src="{{ asset('js/jquery.mask.js') }}"></script>
	<script src="{{ asset('js/extensions/jquery.price_format.2.0.js') }}"></script>
	<script>
		$(document).ready(function() {

			var inputMask = function(){
				$( ".datepicker" ).datepicker({
					dateFormat:'mm/dd/yy',
					changeYear: true,
					changeMonth: true,
					showMonthAfterYear: true, //this is what you are looking for,
					yearRange: '-100:+100',
					minDate:'0d'
//					maxDate:0
				});
				$('.currency').priceFormat({prefix: '$ '});
//				$('.currency').mask("###,##0,000.00", {
//					reverse: true,
//					onKeyPress: function(cep, event, currentField, options){
//						console.log('An key was pressed!:', cep, ' event: ', event,
//								'currentField: ', currentField, ' options: ', options);
//					},
//					onChange: function(cep){
//						console.log('cep changed! ', cep);
//					},
//					onInvalid: function(val, e, f, invalid, options){
//						var error = invalid[0];
//						console.log ("Digit: ", error.v, " is invalid for the position: ", error.p, ". We expect something like: ", error.e);
//					}
//				});
				$('.percentage').mask('%000');
			}

			inputMask();

			$('.or_more').change(function(){
				var val  = $(this).prop('checked');
				console.log(val);
				if(val == true){
					$(this).parent().parent().parent().find('.to_more').val('or more').prop('disabled', true).removeClass('currency');
					$('.currency').priceFormat({prefix: '$ '});
				}else{
					$(this).parent().parent().parent().find('.to_more').val('').prop('disabled', false).addClass('currency');
					$('.currency').priceFormat({prefix: '$ '});
				}
			});

		});


	</script>
@stop