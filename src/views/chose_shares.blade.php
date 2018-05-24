@extends('adminamazing::teamplate')

@section('pageTitle', 'Добавление нового курса для акций')
@section('content')
    <script>
        var route = '{{ route('home') }}';
        var message = 'Вы точно хотите удалить данное сообщение?';
    </script>
	<div class="row">
	    <div class="col-sm-12">
	        <div class="card">
	            <div class="card-block">
	                <h4 class="card-title">Добавление нового курса для акций</h4>
	                @if(Session::has('error'))
                        <div class="alert alert-danger alert-rounded">{!!Session::get('error')!!}</div>
	                @endif	
	                @if(Session::has('success'))
                        <div class="alert alert-success alert-rounded">{!!Session::get('success')!!}</div>
	                @endif	        
	                <form class="form" method="GET" action="{{route('AdminSharesRateInfoStore')}}">
	                    <div class="form-group row {{ $errors->has('share_id') ? ' error' : '' }}">
						    <label for="example-month-input" class="col-2 col-form-label">Акция</label>
						    <div class="col-10">
						        <select class="custom-select col-12" id="inlineFormCustomSelect" name="share_id">
						            <option selected="" value="0">Выбрать...</option>
						            @foreach($shares as $row)
										<option {{($row->id==old('share_id'))?'selected':NULL}}  value="{{$row->id}}">{{$row->currency}} ({{$row->couple->title}}, {{$row->couple->currency}}), Курс: 1 {{$row->currency}} = {{(1*$row->rate->price_per_share)}} {{$row->couple->currency}}</option>
						            @endforeach
						        </select>
								@if ($errors->has('share_id'))
                                    <div class="help-block"><ul role="alert"><li>{{ $errors->first('share_id') }}</li></ul></div>
                                @endif							        
						    </div>
						</div>

	                    <div class="form-group m-b-0">
                            <div class="offset-sm-2 col-sm-9">
                                <button type="submit" class="btn btn-info waves-effect waves-light m-t-10">Далее</button>
                            </div>
                        </div>
                        {{ csrf_field() }}
	                </form>
	            </div>
	        </div>
	    </div>
	</div>    
@endsection