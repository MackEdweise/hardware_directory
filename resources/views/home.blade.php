@extends('layouts.app')

@section('content')
<div class="hidden-sm hidden-xs top-img">
    <img class="top-img" src="{{ URL::asset('img/search-research-header.png') }}" >
</div>
<div class="hidden-md hidden-lg top-img">
    <img class="top-img" src="{{ URL::asset('img/search-research-header-mobile.png') }}" >
</div>
<div class="container space">
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(session('alert-' . $msg))
                <p class="alert alert-{{ $msg }}">{{ session('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
            @endif
        @endforeach
    </div>
</div>
<div class="space">
    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="list-group">
                <a id="view-option" class="list-group-item active clickable">
                    View Parts
                </a>
                <a id="add-option" class="list-group-item list-group-item-action {{ is_null(\Illuminate\Support\Facades\Auth::user()) ? 'disabled' : '' }} clickable" @if(!is_null(\Illuminate\Support\Facades\Auth::user())) data-toggle="modal" href="#deviceAddModal" @else href="#" data-toggle="popover" title="Add Components" data-content="Sign up to contribute" @endif>
                    Add Parts
                </a>
                <a id="datasheet-option" class="list-group-item list-group-item-action clickable">
                    Datasheet Search
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12" id="device-container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1">
                <div class="btn-group" role="group">
                    @if(!is_null($tags))
                        @foreach($tags as $tag)
                            <button id="{{ $tag->name }}-select" type="button" class="btn btn-secondary tag-select">{{ $tag->name }}</button>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="row" id="deviceWindow">
        @foreach($devices as $device)
            <div class="device col-lg-4 col-md-6 col-sm-12 col-xs-12 @foreach($device->Tags as $tag) {{ ' device-'.$tag->name.' ' }} @endforeach">
                <div class="deviceWindow-item space center">
                    <a class="deviceWindow-link" data-toggle="modal" href="{{ '#deviceWindowModal'.$device->id }}">
                        <div class="deviceWindow-hover">
                            <div class="deviceWindow-hover-content">
                                <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
                                    <p>{{ $device->name }}</p>
                                    <small>{{ $device->platform ? $device->platform.' compatible' : '' }} {{ $device->category }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="device-image-container">
                            <img class="img-fluid center device-image" src="{{ $device->image ? 'http://www.datablue.stream/HardwareDirectory/'.$device->image : 'img/device-filler.png' }}" alt="">
                        </div>
                    </a>
                    <div class="deviceWindow-caption">
                        <p>{{ $device->name }}</p>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>
    <div style="display: none;" class="col-lg-10 hidden-sm hidden-md hidden-xs datasheet-container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">Datasheet Search</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div id="table-container">
                        <table class="display data-table" cellspacing="0" width="80%">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Platform</th>
                                <th>Connectivity</th>
                                <th>Supply Voltage (Low)</th>
                                <th>Supply Voltage (High)</th>
                                <th>Speed</th>
                                <th>Manufacturers</th>
                                <th>Datasheet</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($devices as $device)
                                    <tr>
                                        <td>{{ $device->name }}</td>
                                        <td>{{ $device->category }}</td>
                                        <td>{{ $device->platform }}</td>
                                        <td>{{ $device->connectivity }}</td>
                                        <td>{{ $device->low_voltage }}</td>
                                        <td>{{ $device->high_voltage }}</td>
                                        <td>{{ $device->speed != -1 ? $device->speed : 'N/A' }}</td>
                                        <td>{{ $device->manufacturers }}</td>
                                        @if(!is_null($device->datasheet))
                                            <td><a href="{{ $device->datasheet }}">Get the Datasheet</a></td>
                                        @else
                                            <td>No Datasheet</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="display: none;" class="col-md-10 hidden-sm hidden-lg hidden-xs datasheet-container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">Datasheet Search</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div id="table-container">
                        <table class="display data-table" cellspacing="0" width="80%">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Platform</th>
                                <th>Connectivity</th>
                                <th>Supply Voltage (High)</th>
                                <th>Datasheet</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($devices as $device)
                                <tr>
                                    <td>{{ $device->name }}</td>
                                    <td>{{ $device->category }}</td>
                                    <td>{{ $device->platform }}</td>
                                    <td>{{ $device->connectivity }}</td>
                                    <td>{{ $device->high_voltage }}</td>
                                    @if(!is_null($device->datasheet))
                                        <td><a href="{{ $device->datasheet }}">Get the Datasheet</a></td>
                                    @else
                                        <td>No Datasheet</td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="display: none;" class="col-sm-12 col-xs-12 hidden-md hidden-lg datasheet-container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">Datasheet Search</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div id="table-container">
                        <table class="display data-table" cellspacing="0" width="80%">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Datasheet</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($devices as $device)
                                <tr>
                                    <td>{{ $device->name }}</td>
                                    @if(!is_null($device->datasheet))
                                        <td><a href="{{ $device->datasheet }}">Get the Datasheet</a></td>
                                    @else
                                        <td>No Datasheet</td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="deviceWindow-modal modal fade" id="deviceAddModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12 col-lg-10 col-lg-offset-1">
        <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mx-auto">
                    <div class="modal-body">
                        <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="{{ route('add_device') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-7 col-sm-12 col-xs-12 col-lg-8">
                                    <div class="col-md-4 col-lg-4 col-sm-6 col-xs-6">
                                        <input class="space-left-large" type="file" name="device-image" id="device-image" size="20" />
                                    </div>
                                    <div class="col-md-5 col-lg-4 col-sm-6 col-xs-6">
                                        <p>Device Image</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 col-sm-8 col-xs-8 col-sm-offset-2 col-md-offset-1 col-lg-offset-1 col-xs-offset-2 col-lg-5 text-center space">
                                    <ul class="fa-ul text-left">
                                        <li> <i class="fa-li fa fa-feed"></i><input id="device-connectivity" name="device-connectivity" type="text" class="form-control " value="{{ old('device-connectivity') ? old('device-connectivity') : '' }}" placeholder="Device connectivity"></li>
                                        <li> <i class="fa-li fa fa-battery-1"></i><input id="device-low" name="device-low" type="number" step="0.1" class="form-control " value="{{ old('device-low') ? old('device-low') : '' }}" placeholder="Device's low supply voltage"></li>
                                        <li> <i class="fa-li fa fa-battery-4"></i><input id="device-high" name="device-high" type="number" step="0.1" class="form-control " value="{{ old('device-high') ? old('device-high') : '' }}" placeholder="Device's high supply voltage"></li>
                                        <li> <i class="fa-li fa fa-hourglass-o"></i><input id="device-speed" name="device-speed" type="text" class="form-control " value="{{ old('device-speed') ? old('device-speed') : '' }}" placeholder="Device speed"></li>
                                        <li> <i class="fa-li fa fa-industry"></i><input id="device-manufacturers" name="device-manufacturers" type="text" class="form-control " value="{{ old('device-manufacturers') ? old('device-manufacturers') : '' }}" placeholder="Device manufacturers"></li>
                                        <li> <i class="fa-li fa fa-shopping-cart"></i><input id="device-available" name="device-available" type="number" step="1" class="form-control " value="{{ old('device-available') ? old('device-available') : '' }}" placeholder="Number available"></li>
                                    </ul>
                                </div>
                                <div class="col-md-5 col-sm-8 col-xs-8 col-sm-offset-2 col-md-offset-0 col-lg-offset-0 col-xs-offset-2 col-lg-5 text-center space">
                                    <input id="device-name" name="device-name" type="text" class="form-control " value="{{ old('device-name') ? old('device-name') : '' }}" placeholder="Device name">
                                    <input id="device-platform" name="device-platform" type="text" class="form-control " value="{{ old('device-platform') ? old('device-platform') : '' }}" placeholder="Device platform">
                                    <input id="device-category" name="device-category" type="text" class="form-control " value="{{ old('device-category') ? old('device-category') : '' }}" placeholder="Device category">
                                    <input id="device-datasheet" name="device-datasheet" type="text" class="form-control " value="{{ old('device-datasheet') ? old('device-datasheet') : '' }}" placeholder="Datasheet link">
                                    <textarea id="device-description" name="device-description" type="text" class="form-control" value="{{ old('device-description') ? old('device-description') : '' }}" placeholder="{{ is_null(old('device-description')) ? 'Device description'  : ''}}"></textarea>
                                    <div class="panel tag-panel">
                                        <div class="panel-body">
                                            <select data-role="tagsinput" value="" type="text" id="tags" name="tags[]" placeholder="Add tags" multiple></select>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success add-submit space">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@foreach($devices as $device)
    <div class="deviceWindow-modal modal fade" id="{{ 'deviceWindowModal'.$device->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12 col-lg-10 col-lg-offset-1">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal">
                    <div class="lr">
                        <div class="rl"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mx-auto">
                            <div class="modal-body">
                                <!-- Project Details Go Here -->
                                <div class="row">
                                    <div class="col-md-5 col-sm-12 col-xs-12 col-lg-5">
                                        <img class="img-fluid d-block mx-auto device-image" src="{{ $device->image ? 'http://www.datablue.stream/HardwareDirectory/'.$device->image : 'img/hddirlogo.png' }}" alt="">
                                    </div>
                                    <div class="col-md-7 col-sm-12 col-xs-12 col-lg-7 text-center hidden-lg hidden-md">
                                        <h2>{{ $device->name }}</h2>
                                        <p class="item-intro text-muted">{{ $device->platform ? $device->platform.' compatible' : '' }} {{ $device->category }}</p>
                                    </div>
                                    <div class="col-md-7 col-sm-12 col-xs-12 col-lg-7 text-left hidden-xs hidden-sm">
                                        <h2>{{ $device->name }}</h2>
                                        <p class="item-intro text-muted">{{ $device->platform ? $device->platform.' compatible' : '' }} {{ $device->category }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5 col-sm-12 col-xs-12 col-lg-5 hidden-sm hidden-lg">
                                        <ul class="fa-ul text-left space-left">
                                            <li> <i class="fa-li fa fa-feed"></i>Connectivity: {{ $device->connectivity }}</li>
                                            <li> <i class="fa-li fa fa-battery-1"></i>Supply Voltage (Low): {{ $device->low_voltage }}</li>
                                            <li> <i class="fa-li fa fa-battery-4"></i>Supply Voltage (High): {{ $device->high_voltage }}</li>
                                            <li> <i class="fa-li fa fa-hourglass-o"></i>Speed: {{ ($device->speed != null && $device->speed != '') ? $device->speed : 'N/A' }}</li>
                                            <li> <i class="fa-li fa fa-industry"></i>Manufacturers: {{ $device->manufacturers }}</li>
                                            <li> <i class="fa-li fa fa-shopping-cart"></i>Available: {{ $device->available }}</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-5 col-sm-12 col-xs-12 col-lg-5 hidden-xs hidden-md">
                                        <ul class="fa-ul text-left space-left-large">
                                            <li> <i class="fa-li fa fa-feed"></i>Connectivity: {{ $device->connectivity }}</li>
                                            <li> <i class="fa-li fa fa-battery-1"></i>Supply Voltage (Low): {{ $device->low_voltage }}</li>
                                            <li> <i class="fa-li fa fa-battery-4"></i>Supply Voltage (High): {{ $device->high_voltage }}</li>
                                            <li> <i class="fa-li fa fa-hourglass-o"></i>Speed: {{ ($device->speed != null && $device->speed != '') ? $device->speed : 'N/A' }}</li>
                                            <li> <i class="fa-li fa fa-industry"></i>Manufacturers: {{ $device->manufacturers }}</li>
                                            <li> <i class="fa-li fa fa-shopping-cart"></i>Available: {{ $device->available }}</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-7 col-sm-12 col-xs-12 col-lg-7 text-left hidden-sm hidden-xs">
                                        <p>{{ $device->description }}</p>
                                    </div>
                                    <div class="col-md-7 col-sm-12 col-xs-12 col-lg-7 text-left hidden-sm hidden-md hidden-lg">
                                        <p class="space-left">{{ $device->description }}</p>
                                    </div>
                                    <div class="col-md-7 col-sm-12 col-xs-12 col-lg-7 text-left hidden-md hidden-lg hidden-xs">
                                        <p class="space-left-large">{{ $device->description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection
@section('footer')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/data.css') }}"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"/>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>
    <script>
        $(document).ready(function() {

            $('.data-table').DataTable();
            $('#tags').tagsinput();

            $('#datasheet-option').on('click', function(){
                $('#view-option').removeClass('active');
                $('#add-option').removeClass('active');
                $(this).addClass('active');
                $('#device-container').hide();
                $('.datasheet-container').show();
            });
            $('#view-option').on('click', function(){
                $('#datasheet-option').removeClass('active');
                $('#add-option').removeClass('active');
                $(this).addClass('active');
                $('#device-container').show();
                $('.datasheet-container').hide();
            });
            $('#add-option').on('click', function(){
                $('#view-option').removeClass('active');
                $('#datasheet-option').removeClass('active');
                $(this).addClass('active');
            });

            if (window.location.toString().indexOf('link=parts') > -1){
                $('#view-option').click();
            }
            else if(window.location.toString().indexOf('link=datasheets') > -1){
                $('#datasheet-option').click();
            }
            else if(window.location.toString().indexOf('link=view') > -1){
                $('#view-option').click();
            }

            $('[data-toggle="popover"]').popover();

            @if(!is_null($tags))
                @foreach($tags as $tag)
                    $('#{{ $tag->name }}-select').on('click', function(){
                        $('.tag-select').removeClass('active');
                        $(this).addClass('active');
                        $('.device').hide();
                        $('.device-{{ $tag->name }}').show();
                    });
                @endforeach
            @endif
        });
    </script>
@endsection
