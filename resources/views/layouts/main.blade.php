<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Encontré Trabajo</title>
    <link rel="shortcut icon" href="assets/img/logop.png" />


	<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/css/slick.css') }}" rel="stylesheet" />
	<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" rel="stylesheet">
	<link href="{{ asset('assets/css/slick-theme.css') }}" rel="stylesheet" />
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/shared-navbar.css') }}" rel="stylesheet" />

    @stack('meta')

    <style>
        .elipse{
            background:#1675a9;
            position: fixed;
            z-index: 9999999;
            height: 100%;
            width: 100%;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }
            
        .elipse img {
            opacity: 0.3;
            width: 12rem;
            position: absolute;
            animation-name: colombia;
            animation-duration: 2s;
            /* or: Xms */
            animation-iteration-count: infinite;
            animation-direction: alternate;
            /* or: normal */
            animation-timing-function: ease-out;
            animation-fill-mode: forwards;
            /* or: backwards, both, none */
            animation-delay: 1s;
        }



        @-webkit-keyframes colombia {
            0% {
                opacity: 0.3;
            }

            100% {
                opacity: 0.8;
            }
        }

    </style>

    @stack("css")

</head>
    <div class="elipse">
        <img src="assets/img/encontre-trabajo-blanco.png" alt="" style="width: 280px;">
    </div>

    <body>   

        @yield('content')

        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/blazy/1.8.2/blazy.min.js"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/slick.min.js') }}"></script>
        <script src="{{ asset('assets/js/setting-slick.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
        <script src="{{ asset('/js/app.js') }}"></script>
        <script>
            
            $(document).ready(function () {
                setTimeout(function () {
                    $('.elipse').fadeOut(300);
                }, 3000)
            });
        </script>
        <script>
            new WOW().init();
        </script>

        @stack('scripts')

    </body>
</html>
