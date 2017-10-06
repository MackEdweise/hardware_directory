<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Leadme</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Plugin CSS -->
    <link rel="stylesheet" href="css/font-awesome.min.css">

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
                <a class="navbar-brand page-scroll" href="#page-top">hardware<p class="text-danger">.</p>dir</a>
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
        <img src="img/blackchips.png" class="img-responsive top-img">
    </div>
    <div class="row">
        <div class="container explanation">
            <div class="col-md-12">
                <p class="text-muted">
                    Find everything you need to build your prototype.
                </p>
            </div>
            <div class="row text-center">
                <div class="col-md-34 col-sm-12 inside">
                    <img class="img-responsive icon" src="img/integrated-circuit.png" alt="">
                    <br>
                    <p class="text-muted">
                        Search for parts.
                    </p>
                </div>
                <div class="col-md-3 col-sm-12 inside">
                    <img class="img-responsive icon" src="img/folder.png" alt="">
                    <br>
                    <p class="text-muted">
                        Access datasheets.
                    </p>
                </div>
                <div class="col-md-3 col-sm-12 inside">
                    <img class="img-responsive icon" src="img/play-button.png" alt="">
                    <br>
                    <p class="text-muted">
                        Learn to use components.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="row">
            <p>
                When you are creating anything new, research is at the core of this creative process.
                With prototyping electronics that means picking out the parts you want to use in your prototype based on
                their interfacing compatibility, clock speed, form factor, and other parameters. hardware<p class="text-danger">.</p>dir
                make it wasy to find and understanding the parts that you need.
            </p>
        </div>
        <div class="col-md-6 col-sm-12 inside">
            <img class="img-responsive" src="img/prototyping.png" alt="">
        </div>
    </div>
    <footer>
        <div class="container">
            <div>Icons made by <a href="https://www.flaticon.com/authors/smashicons" title="Smashicons">Smashicons</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
        </div>
    </footer>
</body>