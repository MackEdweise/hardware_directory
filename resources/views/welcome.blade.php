<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>hardware.dir</title>

    <!-- CSS -->
    <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet">

    <!-- Plugin CSS -->
    <link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css') }}">

    <!-- favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('img/hddirlogo.png') }}">

</head>

<body id="page-top">
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span><i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top">hardware<h3 style="display: inline;" class="text-danger">.</h3 style="display: inline;">dir</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="{{ route('login') }}">Login</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="{{ route('register') }}">Register</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
    <div class="row">
        <img src="{{ URL::asset('img/blackchips.jpg') }}" class="top-img">
        <div class="header-label"><h1>hardware</h1><h1 style="color: #A94442 !important;">.</h1><h1>dir</h1></div>
    </div>
    <div class="row">
        <div class="container space">
            <div class="row text-center space">
                <div class="col-md-4 col-sm-12 space">
                    <img class="img-responsive icon" src="{{ URL::asset('img/integrated-circuit.png') }}" alt="">
                    <br>
                    <a href="{{ route('home').'?link=parts' }}">
                        Search for parts
                    </a>
                </div>
                <div class="col-md-4 col-sm-12 space">
                    <img class="img-responsive icon" src="{{ URL::asset('img/folder.png') }}" alt="">
                    <br>
                    <a href="{{ route('home').'?link=datasheets' }}">
                        Access datasheets
                    </a>
                </div>
                <div class="col-md-4 col-sm-12 space">
                    <img class="img-responsive icon" src="{{ URL::asset('img/play-button.png') }}" alt="">
                    <br>
                    <a href="{{ route('home').'?link=view' }}">
                        Learn to use components
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row space">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <p class="inside">
                When you are creating anything new, research is at the core of this creative process.
                With prototyping electronics that means picking out the parts you want to use in your prototype based on
                their interfacing compatibility, clock speed, form factor, and other parameters. hardware.dir
                makes it easy to find and understand the parts that you need.
            </p>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="inside">
                <img class="img-responsive" src="{{ URL::asset('img/prototyping.jpg') }}" alt="">
            </div>
        </div>
    </div>
</body>
<footer>
    <div class="container text-center text-secondary">
        <div class="text-white inside-small">Icons made by <a href="https://www.flaticon.com/authors/smashicons" title="Smashicons">Smashicons</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
    </div>

    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function(){
            var width = $(window).width();
            var topOffset = width/2.5;
            if(width < 700){
                var leftOffset = width - width/1.75;
            }
            else{
                var leftOffset = width - width/3;
            }
            $('.header-label').offset({top: topOffset, left: leftOffset});
            $(window).resize(function(){
                var width = $(window).width();
                var topOffset = width/2.5;
                if(width < 700){
                    var leftOffset = width - width/1.75;
                }
                else{
                    var leftOffset = width - width/3;
                }
                $('.header-label').offset({top: topOffset, left: leftOffset});
            });
        });
    </script>
</footer>