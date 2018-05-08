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
	                <form class="form" method="POST" action="{{route('AdminSharesRateStore')}}">
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

	                    <div class="form-group m-t-40 row {{ $errors->has('price_per_share') ? ' error' : '' }}">
	                        <label for="example-text-input" class="col-2 col-form-label">Цена на одну акцию</label>
	                        <div class="col-10">
	                            <input class="form-control" type="text" name="price_per_share" value="{{old('price_per_share')}}" id="example-text-input">
								@if ($errors->has('price_per_share'))
                                    <div class="help-block"><ul role="alert"><li>{{ $errors->first('price_per_share') }}</li></ul></div>
                                @endif
	                        </div>
	                    </div>

	                    <div class="form-group m-t-40 row {{ $errors->has('available_at') ? ' error' : '' }}">
	                        <label for="example-text-input" class="col-2 col-form-label">Доступно с</label>
	                        <div class="col-10">
	                            <input class="form-control" type="text" name="available_at" value="{{old('available_at', $available_at)}}" id="example-text-input">
								@if ($errors->has('available_at'))
                                    <div class="help-block"><ul role="alert"><li>{{ $errors->first('available_at') }}</li></ul></div>
                                @endif
	                        </div>
	                    </div>


	                    <div class="form-group m-b-0">
                            <div class="offset-sm-2 col-sm-9">
                                <button type="submit" class="btn btn-info waves-effect waves-light m-t-10">Добавить курс</button>
                            </div>
                        </div>
                        {{ csrf_field() }}
	                </form>
	            </div>
	        </div>
	    </div>
	</div>    
@endsection