@extends('adminamazing::teamplate')

@section('pageTitle', 'Добавление нового курса для акций')
@section('content')
	<div class="row">
	    <div class="col-12">
	        <div class="card">
	            <div class="card-block">
					<h4 class="card-title">Курсы акций {{$share->couple->title}}, {{$share->couple->currency}}. Текущий курс {{$share->rate->price_per_share}} {{$share->currency}} ({{$share->rate->price_in_dollar}} USD)</h4>
					<div class="m-t-10 m-b-10" id="chart"></div>
                    <hr/>
                    @if(Session::has('error'))
                        <div class="alert alert-danger alert-rounded">{!!Session::get('error')!!}</div>
	                @endif	
	                @if(Session::has('success'))
                        <div class="alert alert-success alert-rounded">{!!Session::get('success')!!}</div>
	                @endif
                    <form class="form" method="POST" action="{{route('AdminSharesRateStore')}}">
	                    @for($i=0;$i<3;$i++)
	                    	@php
	                    		$add_hourse = 12;
	                    	@endphp
	                    	@if($i == 0)
	                    		@php
	                    			$add_hourse = 0;
	                    		@endphp
	                    	@endif
							<div class="row">
			                    <div class="form-group col-12 col-lg-5">
		                            <label for="available_at{{$i}}">Доступно с</label>
		                            <input type="text" class="form-control datepicker" name="available_at[]" class="form-control" placeholder="{{$available_at->addHours($add_hourse)->format('Y-m-d H:i:s')}}" id="available_at{{$i}}" value="{{$available_at->addHours($add_hourse)->format('Y-m-d H:i:s')}}">
		                        </div>
		                        <div class="col-12 col-lg-2">
		                            <label for="plus_minus{{$i}}">Плюс/Минус</label>
		                            <div class="form-group">
			                            <select class="custom-select form-control" id="plus_minus{{$i}}" name="plus_minus[]">
	                                        <option value="0" selected>Выбрать...</option>
	                                        <option value="plus">+</option>
	                                        <option value="minus">-</option>
	                                        
	                                    </select>
		                            </div>
		                        </div>
		                        <div class="col-12 col-lg-5">
		                            <label for="percent{{$i}}">Процент роста</label>
		                            <div class="input-group">
			                            <select class="custom-select form-control" id="percent{{$i}}" name="percent[]">
	                                        <option value="0" selected>Выбрать...</option>
	                                        @for($j=0.01;$j<=5;$j+=0.01)
	                                        	<option value="{{number($j)}}">{{number($j)}}%</option>
	                                        @endfor
	                                    </select>
			                            <span class="input-group-addon">%</span>
		                            </div>
		                        </div>
							</div>
							<hr/>
						@endfor

	                    <div class="form-group m-b-50">
                            <div class="offset-sm-2 col-sm-8 text-center">
                            	<input type="hidden" name="share_id" value="{{$share->id}}">
                                <button type="submit" class="btn btn-info waves-effect waves-light m-t-10">Добавить курсы</button>
                            </div>
                        </div>
                        {{ csrf_field() }}
	                </form>
                    <h6>Последнее 20 записей в базе</h6>
                    <div class="table-responsive">
	                    <table style="clear: both" class="table table-bordered table-striped" id="user">
	                        <tbody>
	                            @if($share->full_rate)
		                            @foreach($share->full_rate as $row)
			                            @php
			                            	$class = null;
			                            @endphp
			                            @if (!Carbon\Carbon::now()->lte(Carbon\Carbon::parse($row->available_at)))
				                            @php
				                            	$class = 'none';
				                            @endphp
			                            @endif
			                            <tr style="background: {{($row->id == $share->rate->id)?'#1c68ff54':NULL}}">
			                                <td>#{{$row->id}}</td>
			                                <td>{{$row->available_at->diffForHumans()}}</td>
			                                <td><a href="#" data-id="{{$row->id}}" class="inline-dob{{$class}}" data-type="combodate" data-value="{{$row->available_at}}" data-format="YYYY-MM-DD HH:mm:ss" data-viewformat="YYYY-MM-DD HH:mm:ss" data-template="YYYY-MMM-D HH:mm:ss" data-pk="{{$row->id}}" data-title="Select Date of birth">{{$row->available_at}}</a></td>
			                                <td>
			                                	<a href="#" data-id="{{$row->id}}" class="inline-rate{{$class}}" data-type="text" data-pk="{{$row->id}}" data-title="Enter rate">{{$row->price_per_share}}</a> {{$share->currency}} ({{$row->price_dollar}} USD)
			                                </td>
			                                {{--<td>
			                                	<a href="{{route('AdminSharesRatePercentageGrowth', $row->id)}}">Проценты роста </a>
			                                </td>--}}
			                                <td><a href="{{route('AdminSharesRateDelete', $row->id)}}" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Удалить"><i class="ti-close" aria-hidden="true"></i></a></td>
			                            </tr>
		                            @endforeach
	                            @endif
	                        </tbody>
	                    </table>
	            	</div>
	            	<nav aria-label="Page navigation example" class="m-t-40">
		                {{ $share->full_rate->links('vendor.pagination.bootstrap-4') }}
		            </nav>                
	            </div>
	        </div>
	    </div>
	</div>   



	<script>
        var route = '{{ route('home') }}';
        var message = 'Вы точно хотите удалить данное сообщение?';
    </script>
    <style type="text/css">
    	.cd-horizontal-timeline .events a{
    		padding-bottom: 5px!important;
    	}
		.pagination {
			justify-content: center;
		}
    </style>
    @push('scripts')
	    <link href="{{ asset('vendor/adminamazing/assets/plugins/x-editable/dist/bootstrap3-editable/css/bootstrap-editable.css') }}" rel="stylesheet">
	    <script src="{{ asset('vendor/adminamazing/assets/plugins/moment/moment.js') }}"></script>
	    <script src="{{ asset('vendor/adminamazing/assets/plugins/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.js') }}"></script>
	    <link href="{{ asset('vendor/sharesrateadmin/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
	    <script src="{{ asset('vendor/sharesrateadmin/js/bootstrap-datetimepicker.min.js') }}"></script>
		<script type="text/javascript">
			$(function() {
				$('.inline-rate').editable({
		            type: 'text',
		            pk: 1,
		            name: 'entered_rate',
		            title: 'Enter rate',
		            mode: 'inline',
					success: function(e, editable) {
				        var value = editable, id = $(this).data('id');
				        $.post('{{route('AdminSharesRateChangeRate')}}', {'type':'rate', 'id': id, 'value': value}, function(data){
				        	console.log(data);
				        });
				    }
		        });

		        $('.inline-dob').editable({
		            mode: 'inline',
		            combodate: {
						minYear: 2018,
						maxYear: 2019,
						minuteStep: 1,
					},
					success: function(e, editable) {
				        var value = editable.format('YYYY-MM-DD HH:mm:ss'), id = $(this).data('id');
				        $.post('{{route('AdminSharesRateChangeRate')}}', {'type':'date', 'id': id, 'value': value}, function(data){
				        	console.log(data);
				        });
				    }
		        });

		        $('.inline-ratenone, .inline-dobnone').on('click', function(e){
		        	e.preventDefault();
		        });
			});
		</script>
		<script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
		<script>
            document.addEventListener("DOMContentLoaded", ready);
            function ready(){
                 var chart = $('#chart').highcharts('chart', {
                    chart: {
                        type: 'column',
                        style:{fontSize:"11px",fontFamily:"inherit",overflow: "visible"},
                        borderColor:"#fff",
                        plotBorderColor:"#0275d8",
                        spacing:[0, 0, 0, 0],
                        height:200
                    },
                    credits:{
                        enabled:false
                    },
                    xAxis: {
                        tickWidth: 0,
                        gridLineWidth: 1,
                        gridLineColor:"#e7eef0",
                        lineColor:"#e7eef0",
                        labels: {
                            align: 'center',
                            style:{
                                color:'#637d95'
                            }
                        },
                        categories: [
                            @foreach($share->full_rate->reverse() as $key => $row) 
                                '{{$row->available_at->format('d M')}}',
                            @endforeach
                        ]
                    },
                    yAxis: [{
                        gridLineColor:"#e7eef0",
                        lineColor:"#e7eef0",
                        lineWidth: 1,
                        labels: {
                            align: 'right',
                            format: '{value} {{$share->currency}}',
                            style:{
                                color:'#637d95'
                            }
                        },
                        title:{
                            text:null
                        },
                        showFirstLabel: false,
                    },{
                        linkedTo: 0,
                        gridLineColor:"#e7eef0",
                        lineColor:"#e7eef0",
                        lineWidth: 1,
                        showFirstLabel: false,
                        title:{
                            text:null
                        },
                        labels: {
                            align: 'right',
                            enabled:false
                        },
                    }],
                     legend:{
                         enabled:false
                     },
                     title:{
                         text:null
                     },
                    tooltip: {
                        valueSuffix: '{{$share->currency}}'
                    },
                    plotOptions: {
                        column: {
                            borderRadius: 3
                        }
                    },
                    series: [{
                        color:'#1c68ff',
                        name: 'Share price',
                        data: [
							@foreach($share->full_rate->reverse() as $row)
                        		['{{$row->available_at}}', {{$row->price_per_share}}],
                        	@endforeach
                        ],
                        states:{
                            hover:{
                                color:'#002944',
                            }
                        }
                    }]
                });
            }
        </script>
    @endpush 
@endsection