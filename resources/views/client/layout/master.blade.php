<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/">

	<!-- title -->
	<title>Cake - @yield('title')</title>

	@include('client.layout.partials.css')

</head>
<body>
	
	<!--PreLoader-->
    <div class="loader">
        <div class="loader-inner">
            <div class="circle"></div>
        </div>
    </div>
    <!--PreLoader Ends-->
	
	@include('client.layout.partials.header')

	@yield('content')

	@include('client.layout.partials.footer')
	
	@include('client.layout.partials.js')
	@include('sweetalert::alert')
	@include('client.layout.partials.chatbot')
</body>
</html>