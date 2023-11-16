<!doctype html>
<html class="no-js" lang="en">
    <head> 
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Mizora Admin Panel</title>
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon" />

        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">
        
        <script src="{{ asset('js/app.js') }}"></script>

        <!-- themekit admin template asstes -->
        <link rel="stylesheet" href="{{ asset('all.css') }}">
        <link rel="stylesheet" href="{{ asset('dist/css/theme.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/icon-kit/dist/css/iconkit.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/ionicons/dist/css/ionicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </head>

    <body class="home-gradient-bg">
		<div class="container ">
			<div class="d-flex justify-content-between my-5">
				<div>
					<a href="https://themicly.com/products/radmin/">
		            	<img height="30" src="{{ asset('img/logo.png') }}">
		            </a>
				</div>
				<div>
					<!--<a class="btn btn-success btn-rounded mr-3" href="{{url('login')}}/">Login</a>-->
									</div>
			</div>
	    	<div class="banner-text m-4 d-relative">
	    		<img height="50" class="d-absolute left-0"  src="{{asset('/img/p1.png')}}">
	    		<img height="300" class="d-absolute"  src="{{asset('/img/s1-2.png')}}">
	    		<img height="50" class="d-absolute right-0"  src="{{asset('/img/s2-2.png')}}">
	    		Welcome to API Mizora 	    	</div>

	    	<div class="radmin-bannner text-center">
	    		<!--<img  src="{{asset('/img/radmin.jpg')}}">-->
	    	</div>
		    <div class="row justify-content-center">
		        <div class="my-5">
		        	<p class="text-center"></p>
		        	<div class="card-body template-demo text-center">
                        
                    </div>
		        	
		        </div>
		    </div>
		</div>
		<script src="{{ asset('all.js') }}"></script>
        
    </body>
</html>

