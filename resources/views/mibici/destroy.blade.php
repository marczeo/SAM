@extends('layouts.app')

@section('scriptsTop')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCk3aVE_atNGMx06dHKbmU6RMCgAOMMWEQ&signed_in=true"></script>
    <script src="/js/mibici-destroy.js"></script>
    <style>body {background-color: #FFE6E6;}</style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{trans('mibici.label')}}</div>

                <div class="panel-body">
                    <form class="form-horizontal" name = main role="form" method="POST" action="{{ action('MibiciController@deleteNode','name') }}" onsubmit="return confirm('{{trans('mibici.msg_confirm_delete')}}');">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        
                            <label for="name" class="col-md-1">{{trans('mibici.name')}}</label>
                            
                            <div class="col-md-11">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus placeholder="{{trans('mibici.name')}}"  readonly>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label for="markerFromAddress" class="col-md-1 text-left">{{trans('mibici.from')}}</label>
                            <div class="col-xs-9">
                                <input id="markerFromAddress" type="text" class="form-control" name="from" value="{{ old('name') }}" placeholder="{{trans('mibici.from')}}" readonly >
                            </div>                                    
                            <input type="hidden" id="markerFromLang" name="markerFromLang" value="">
                            <input type="hidden" id="markerFromLat" name="markerFromLat" value="">
                            <input type="hidden" id="id" name= "id" value="">

                            <div class="col-md-2 text-center">
                                <button type="submit" class="btn  btn-danger">
                                    {{trans('navbar.destroy')}}             
                                    <span class="glyphicon glyphicon-minus" aria-hidden="true">
                                    </span>
                                </button>
                            </div>                                      
                        </div>
                        <!--<script async defer
                            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCk3aVE_atNGMx06dHKbmU6RMCgAOMMWEQ&signed_in=true&callback=initMap">
                        </script>-->
                        <div class="form-gr">
                            <div id="map" style="height: 500px;"></div>                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
