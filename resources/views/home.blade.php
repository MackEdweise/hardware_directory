@extends('layouts.app')

@section('content')
<div class="hidden-sm hidden-xs top-img">
    <img class="top-img" src="{{ URL::asset('img/search-research-header.png') }}" >
</div>
<div class="hidden-md hidden-lg top-img">
    <img class="top-img" src="{{ URL::asset('img/search-research-header-mobile.png') }}" >
</div>
<div class="container space">
    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="list-group">
                <a id="view-option" class="list-group-item active clickable">
                    View Parts
                </a>
                <a id="add-option" class="list-group-item list-group-item-action {{ is_null(\Illuminate\Support\Facades\Auth::user()) ? 'disabled' : 'data-toggle="modal" href="#deviceAddModal"' }} clickable">
                    Add Parts
                </a>
                <a id="datasheet-option" class="list-group-item list-group-item-action clickable">
                    Datasheet Search
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12" id="device-container">
        <div class="row" id="deviceWindow">
        @foreach($devices as $device)
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <div class="deviceWindow-item space center">
                    <a class="deviceWindow-link" data-toggle="modal" href="{{ '#deviceWindowModal'.$device->id }}">
                        <div class="deviceWindow-hover">
                            <div class="deviceWindow-hover-content">
                                <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
                                    <p>{{ $device->name }}</p>
                                    <small>{{ $device->platform }} compatible {{ $device->category }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="device-image-container">
                            <img class="img-fluid center device-image" src="{{ $device->image ? $device->image : 'img/device-filler.png' }}" alt="">
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
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mx-auto">
                        <div class="modal-body">
                            <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="{{ route('add_device') }}">
                                <div class="row">
                                    <div class="col-md-5 col-sm-12 col-xs-12 col-lg-5">
                                        <h2>Upload Image</h2>
                                        <input type="file" name="device-image" id="device-image" size="20" />
                                    </div>
                                    <div class="col-md-7 col-sm-12 col-xs-12 col-lg-7 text-center hidden-lg hidden-md">
                                        <input id="device-name" name="device-name" type="text" class="form-control " value="{{ old('device-name') ? old('device-name') : '' }}" placeholder="Device name">
                                        <input id="device-platform" platform="device-platform" type="text" class="form-control " value="{{ old('device-platform') ? old('device-platform') : '' }}" placeholder="Device platform">
                                        <input id="device-category" category="device-category" type="text" class="form-control " value="{{ old('device-category') ? old('device-category') : '' }}" placeholder="Device category">
                                    </div>
                                    <div class="col-md-7 col-sm-12 col-xs-12 col-lg-7 text-left hidden-xs hidden-sm">
                                        <input id="device-2-name" name="device-2-name" type="text" class="form-control " value="{{ old('device-2-name') ? old('device-2-name') : '' }}" placeholder="Device name">
                                        <input id="device-2-platform" platform="device-2-platform" type="text" class="form-control " value="{{ old('device-2-platform') ? old('device-2-platform') : '' }}" placeholder="Device platform">
                                        <input id="device-2-category" category="device-2-category" type="text" class="form-control " value="{{ old('device-2-category') ? old('device-2-category') : '' }}" placeholder="Device category">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5 col-sm-12 col-xs-12 col-lg-5 hidden-sm hidden-lg">
                                        <ul class="fa-ul text-left space-left">
                                            <li> <i class="fa-li fa fa-feed"></i><input id="device-connectivity" connectivity="device-connectivity" type="text" class="form-control " value="{{ old('device-connectivity') ? old('device-connectivity') : '' }}" placeholder="Device connectivity"></li>
                                            <li> <i class="fa-li fa fa-battery-1"></i><input id="device-low" low="device-low" type="number" class="form-control " value="{{ old('device-low') ? old('device-low') : '' }}" placeholder="Device's low supply voltage"></li>
                                            <li> <i class="fa-li fa fa-battery-4"></i><input id="device-high" high="device-high" type="number" class="form-control " value="{{ old('device-high') ? old('device-high') : '' }}" placeholder="Device's high supply voltage"></li>
                                            <li> <i class="fa-li fa fa-hourglass-o"></i><input id="device-speed" speed="device-speed" type="text" class="form-control " value="{{ old('device-speed') ? old('device-speed') : '' }}" placeholder="Device speed"></li>
                                            <li> <i class="fa-li fa fa-industry"></i><input id="device-manufacturers" manufacturers="device-manufacturers" type="text" class="form-control " value="{{ old('device-manufacturers') ? old('device-manufacturers') : '' }}" placeholder="Device manufacturers"></li>
                                            <li> <i class="fa-li fa fa-shopping-cart"></i><input id="device-available" available="device-available" type="number" class="form-control " value="{{ old('device-available') ? old('device-available') : '' }}" placeholder="Number available"></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-5 col-sm-12 col-xs-12 col-lg-5 hidden-xs hidden-md">
                                        <ul class="fa-ul text-left space-left-large">
                                            <li> <i class="fa-li fa fa-feed"></i><input id="device-2-connectivity" connectivity="device-2-connectivity" type="text" class="form-control " value="{{ old('device-2-connectivity') ? old('device-2-connectivity') : '' }}" placeholder="Device connectivity"></li>
                                            <li> <i class="fa-li fa fa-battery-1"></i><input type="number" id="device-2-low" low="device-2-low" class="form-control " value="{{ old('device-2-low') ? old('device-2-low') : '' }}" placeholder="Device's low supply voltage"></li>
                                            <li> <i class="fa-li fa fa-battery-4"></i><input id="device-2-high" high="device-2-high" type="number" class="form-control " value="{{ old('device-2-high') ? old('device-2-high') : '' }}" placeholder="Device's high supply voltage"></li>
                                            <li> <i class="fa-li fa fa-hourglass-o"></i><input id="device-2-speed" speed="device-2-speed" type="text" class="form-control " value="{{ old('device-2-speed') ? old('device-2-speed') : '' }}" placeholder="Device speed"></li>
                                            <li> <i class="fa-li fa fa-industry"></i><input id="device-2-manufacturers" manufacturers="device-2-manufacturers" type="text" class="form-control " value="{{ old('device-2-manufacturers') ? old('device-2-manufacturers') : '' }}" placeholder="Device manufacturers"></li>
                                            <li> <i class="fa-li fa fa-shopping-cart"></i><input id="device-2-available" available="device-2-available" type="number" class="form-control " value="{{ old('device-2-available') ? old('device-2-available') : '' }}" placeholder="Number available"></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-7 col-sm-12 col-xs-12 col-lg-7 text-left hidden-sm hidden-xs">
                                        <textarea id="device-description" name="device-description" type="text" class="form-control" value="{{ old('device-description') ? old('device-description') : '' }}" placeholder="{{ is_null(old('device-description')) ? 'Device description'  : ''}}"></textarea>
                                    </div>
                                    <div class="col-md-7 col-sm-12 col-xs-12 col-lg-7 text-left hidden-sm hidden-md hidden-lg">
                                        <textarea id="device-2-description" name="device-2-description" type="text" class="form-control" value="{{ old('device-2-description') ? old('device-2-description') : '' }}" placeholder="{{ is_null(old('device-2-description')) ? 'Device description'  : ''}}"></textarea>
                                    </div>
                                    <div class="col-md-7 col-sm-12 col-xs-12 col-lg-7 text-left hidden-md hidden-lg hidden-xs">
                                        <textarea id="device-3-description" name="device-3-description" type="text" class="form-control" value="{{ old('device-3-description') ? old('device-3-description') : '' }}" placeholder="{{ is_null(old('device-3-description')) ? 'Device description'  : ''}}"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <button type="submit" style="height: 30px; width:80px;" class="btn btn-success">Save</button>
                                </div>
                            </form>
                        </div>
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
                                        <img class="img-fluid d-block mx-auto device-image" src="{{ $device->image ? $device->image : 'img/hddirlogo.png' }}" alt="">
                                    </div>
                                    <div class="col-md-7 col-sm-12 col-xs-12 col-lg-7 text-center hidden-lg hidden-md">
                                        <h2>{{ $device->name }}</h2>
                                        <p class="item-intro text-muted">{{ $device->platform }} compatible {{ $device->category }}</p>
                                    </div>
                                    <div class="col-md-7 col-sm-12 col-xs-12 col-lg-7 text-left hidden-xs hidden-sm">
                                        <h2>{{ $device->name }}</h2>
                                        <p class="item-intro text-muted">{{ $device->platform }} compatible {{ $device->category }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5 col-sm-12 col-xs-12 col-lg-5 hidden-sm hidden-lg">
                                        <ul class="fa-ul text-left space-left">
                                            <li> <i class="fa-li fa fa-feed"></i>Connectivity: {{ $device->connectivity }}</li>
                                            <li> <i class="fa-li fa fa-battery-1"></i>Supply Voltage (Low): {{ $device->low_voltage }}</li>
                                            <li> <i class="fa-li fa fa-battery-4"></i>Supply Voltage (High): {{ $device->high_voltage }}</li>
                                            <li> <i class="fa-li fa fa-hourglass-o"></i>Speed: {{ $device->speed != -1 ? $device->speed : 'N/A' }}</li>
                                            <li> <i class="fa-li fa fa-industry"></i>Manufacturers: {{ $device->manufacturers }}</li>
                                            <li> <i class="fa-li fa fa-shopping-cart"></i>Available: {{ $device->available }}</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-5 col-sm-12 col-xs-12 col-lg-5 hidden-xs hidden-md">
                                        <ul class="fa-ul text-left space-left-large">
                                            <li> <i class="fa-li fa fa-feed"></i>Connectivity: {{ $device->connectivity }}</li>
                                            <li> <i class="fa-li fa fa-battery-1"></i>Supply Voltage (Low): {{ $device->low_voltage }}</li>
                                            <li> <i class="fa-li fa fa-battery-4"></i>Supply Voltage (High): {{ $device->high_voltage }}</li>
                                            <li> <i class="fa-li fa fa-hourglass-o"></i>Speed: {{ $device->speed != -1 ? $device->speed : 'N/A' }}</li>
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
    <script>
        $('document').ready(function() {
            $('.data-table').DataTable();
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
        });
    </script>
@endsection
