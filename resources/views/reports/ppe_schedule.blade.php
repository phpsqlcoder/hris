@extends('layouts.report')
@section('content')

	<div class="row">
		<div class="col-md-12">
			
			<h3 class="text-center">APE Schedule for {{$monthName}}</h3>
			
			<table class="table">
				<thead>
					<tr>
						<th>Seq</th>
						<th>Name</th>
						<th>Teamleader</th>
						<th>Birthdate</th>
						<th>Age</th>						
					</tr>
				</thead>
				<tbody>
			@php
				$x=0;
			@endphp
			@forelse($employees as $e)
			@php
				$x++;
			@endphp	
				<tr>
					<td>{{$x}}</td>
					<td>{{$e->fullName}}</td>
					<td>{{$e->teamleader}}</td>
					<td>{{$e->birthDate}}</td>
					<td>{{$e->age}}</td>
				</tr>	
			@empty
				<tr><td colspan="5">No Employee found!</td></tr>
			@endforelse	
					<tr><td colspan="5"><br><hr style="border-top: dotted 1px;"><br></td></tr>
				</tbody>
			</table>
			
		</div>
	</div>
@endsection


