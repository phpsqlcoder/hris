@extends('layouts.report')
@section('content')

	<div class="row">
		<div class="col-md-12">
			<h3 class="text-center">{!! $report['title'] !!}</h3>
			<table class="table table-condensed" width="120%" cellpadding="10" cellspacing="10">
				{!! $report['header'] !!}
				{!! $report['footer'] !!}
				{!! $report['data'] !!}				
			</table>
		</div>
	</div>

@endsection

