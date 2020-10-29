
	<div class="row">
		<div class="col-md-12">
			<h3 class="text-center"></h3>
			@forelse($payrolls->chunk(4) as $pp)
				@foreach($pp as $p)
					<table style="font-size:11px;font-family:Arial;" cellpadding="0" cellspacing="0" width="100%">
							<tr><td colspan="4" style="text-align:center"> 
								
						        <small>HUMAN RESOURCE INFORMATION SYSTEM</small>
						        <small>PAYSLIP</small>
							</td></tr>
							<tr><td colspan="4" style="text-align:center">Cutoff: {!! $cutoff->start !!} to {!! $cutoff->end !!}<br><br></td></tr>
							<tr>
								<td>Name</td>
								<td>:&nbsp;{!! $p->fullName !!}</td>
								<td style="margin-left:20px;">ID</td>
								<td>:&nbsp;{!! $p->employee_id !!}</td>
							</tr>
							
							<tr>
								<td>Rate</td>
								<td>:&nbsp;{!! number_format($p->rate,2) !!}</td>
								<td>HDMF</td>
								<td>:&nbsp;{!! $p->hdmf !!}</td>
							</tr>
							<tr>
								
								<td>Leave</td>
								<td>:&nbsp;{!! $p->leave !!} days</td>
								<td>Philhealth</td>
								<td>:&nbsp;{!! $p->philhealth !!}</td>
								
							</tr>
							<tr>
								<td>Duty</td>
								<td>:&nbsp;{!! $p->present !!} days</td>
								<td>SSS</td>
								<td>:&nbsp;{!! $p->sss !!}</td>
								
							</tr>
							<tr><td colspan="4"><hr></td></tr>
							<tr style="font-weight:bold;">
								<td>Earnings</td>
								<td style="text-align:right;">Amount</td>
								<td style="padding-left:20px;">Deductions</td>
								<td style="text-align:right;">Amount</td>
							</tr>
							<tr>
								<td>Duty</td>
								<td style="text-align:right;">{!! number_format($p->present_amount,2) !!}</td>
								<td style="padding-left:20px;">HDMF Loan</td>
								<td style="text-align:right;">{!! $p->hdmf_loan_amount !!}</td>
							</tr>
							<tr>
								<td>Leave</td>
								<td style="text-align:right;">{!! $p->leave_amount !!}</td>
								<td style="padding-left:20px;">SSS Loan</td>
								<td style="text-align:right;">{!! $p->sss_loan_amount !!}</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td style="text-align:right;">&nbsp;</td>
								<td style="padding-left:20px;">SSS</td>
								<td style="text-align:right;">{!! $p->sss_amount !!}</td>
							</tr>
							<tr>
								<td>Adjustment</td>
								<td style="text-align:right;">{!! $p->adjustment !!}</td>
								<td style="padding-left:20px;">Philhealth</td>
								<td style="text-align:right;">{!! $p->philhealth_amount !!}</td>
							</tr>
							<tr>
								<td>Cola</td>
								<td style="text-align:right;">{!!  number_format(($p->cola * $p->present),2) !!}</td>
								<td style="padding-left:20px;">HDMF</td>
								<td style="text-align:right;">{!! $p->hdmf_amount !!}</td>
							</tr>
							<tr style="font-weight:bold;">
								<td>Total</td>
								<td style="text-align:right;">{!! number_format(($p->present_amount + $p->leave_amount + $p->adjustment),2) !!}</td>
								<td style="padding-left:20px;">Total</td>
								<td style="text-align:right;">{!! number_format(($p->sss_amount + $p->philhealth_amount + $p->hdmf_amount + $p->hdmf_loan_amount + $p->sss_loan_amount),2) !!}</td>
							</tr>
							<tr><td colspan="4"><hr></td></tr>
							<tr style="font-weight:bold;font-size:12px;">
								<td>Net Pay:</td>
								<td style="text-align:right;">{!! number_format($p->amount,2) !!}</td>
								<td style="padding-left:20px;">Signature:</td>
								<td style="text-align:right;">_______________</td>
							</tr>
							
							<tr><td colspan="4"><br><hr style="border-top: dotted 1px;"><br></td></tr>
					</table>
				@endforeach
				<div style="page-break-before: always;"> </div>
			@empty

			@endforelse
		</div>
	</div>


