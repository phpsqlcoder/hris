@extends('layouts.report')
@section('content')

	<div class="row">
		<div class="col-md-12">
			
			<h3 class="text-center">Masterlist as of {{date('F d Y')}}</h3>
			
			<table class="table">
				<thead>
					<tr>
						<th>Seq</th>
						<th>Name</th>
						<th>Teamleader</th>
						<th>Birthdate</th>
						<th>Age</th>
						<th>Hired</th>
						<th>Gender</th>
						<th>ContactNo</th>
						<th>CivilStatus</th>
						<th>Religion</th>
						<th>BloodType</th>
						<th>BiometricId</th>
						<th>SSS</th>
						<th>HDMF</th>						
						<th>Philhealth</th>
						<th>Tin</th>
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
					<td>{{$e->hiredDate}}</td>
					<td>{{$e->gender}}</td>
					<td>{{$e->contactNo}}</td>
					<td>{{$e->civilStatus}}</td>
					<td>{{$e->religion}}</td>
					<td>{{$e->bloodType}}</td>
					<td>{{$e->biometricId}}</td>
					<td>{{$e->sss}}</td>
					<td>{{$e->hdmf}}</td>
					<td>{{$e->philhealth}}</td>
					<td>{{$e->tin}}</td>
				</tr>	
			@empty
				<tr><td colspan="16">No Employee found!</td></tr>
			@endforelse	
					<tr><td colspan="16"><br><hr style="border-top: dotted 1px;"><br></td></tr>
				</tbody>
			</table>
			
		</div>
	</div>
@endsection


