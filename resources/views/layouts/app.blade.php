<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="Nowa – Laravel Bootstrap 5 Admin & Dashboard Template">
		<meta name="Author" content="Spruko Technologies Private Limited">
		<meta name="Keywords" content="admin dashboard, admin dashboard laravel, admin panel template, blade template, blade template laravel, bootstrap template, dashboard laravel, laravel admin, laravel admin dashboard, laravel admin panel, laravel admin template, laravel bootstrap admin template, laravel bootstrap template, laravel template"/>

		<!-- Title -->
		<title> Nowa – Laravel Bootstrap 5 Admin & Dashboard Template </title>

        @include('layouts.components.styles')
		<link href="{{asset('css/style.css')}}" rel="stylesheet">
	</head>

	<body class="ltr main-body app sidebar-mini">

		<!-- Loader -->
		<div id="global-loader">
			<img src="{{asset('assets/img/loader.svg')}}" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->

		<!-- Page -->
		<div class="page">

			<div>

                @include('layouts.components.app-header')

                @include('layouts.components.app-sidebar')

			</div>

			<!-- main-content -->
			<div class="main-content app-content">

				<!-- container -->
				<div class="main-container container-fluid">

                    @yield('content')

				</div>
				<!-- Container closed -->
			</div>
			<!-- main-content closed -->

            @include('layouts.components.sidebar-right')

            @include('layouts.components.modal')

            @yield('modal')

            @include('layouts.components.footer')

			<!-- ////////////////////////// -->
			<div class="load_content form-group text-center">
				<img class="load_image" src="{{asset('images/load_image.jpg')}}">
			</div>

			<div class="confirm_content form-group text-center">
				<div class="confirm_alert panel panel-primary">
					<div class="panel-body">
						<h3>{{ __('app.are_you_sure') }}</h3>
						<button id="btn_no" class="btn btn-primary">{{ __('app.no') }}</button>
						<button id="btn_yes" class="btn btn-danger" data-href="">{{ __('app.yes') }}</button>
					</div>
				</div>
			</div>
			{{-- start show photo section --}}
			<div id="show_photo" class="text-center col-xs-12">
			
			</div>
			{{-- end update section --}}
		
			<div style="display: none" class="alert_message alert alert-success" role="alert">
				
			</div>
			<div class=" displayView">
				<div class="displayViewContent">
					
				</div>
				<button class="close btn btn-danger">X</button>     
			</div>
			<!-- ////////////////////////// -->

		</div>
		<!-- End Page -->

        @include('layouts.components.scripts')
		<script>
            $(document).ready(function(){
                $("body").on("click", "button[name='delete']",function(e){
                    e.preventDefault();
                    $('#btn_yes').data('href', $(this).data('href'));
                    $('.confirm_content').show();
                    
                });
                if('{{ session("message") }}')
                {
                    $(".alert_message").html('{{ session("message") }}');
                    $(".alert_message").fadeIn().delay(2000).fadeOut();
                }
                $('body').on('click', '#btn_no', function(e){
                    $('.confirm_content').hide();
                });
                $('body').on('click', '#btn_yes', function(e){
                    var url = $(this).data('href');
                    $('.confirm_content').hide();
                    $.ajax({
                        url:url,
                        method:"post",
                        data: {"_method":"delete", "_token": '{{ csrf_token() }}'},
                        beforeSend:function(){
                            $(".load_content").show();
                        },
                        success:function(responsetext){
                            $(".load_content").hide();
                            $(".alert_message").text('{{ __("app.success_operation") }}');
                            $(".alert_message").fadeIn().delay(2000).fadeOut();
                            $('.table-data').DataTable().ajax.reload(null, false);
                        },
                        error: function(data_error, exception){
                            $(".load_content").hide();
                            if(exception == "error"){
                                $(".alert_message").text(data_error.responseJSON.message);
                                $(".alert_message").fadeIn().delay(2000).fadeOut();
                            }
                        }
        
                    });
                });
                
                // start the is_active button
        
                $("body").on("click", "#is_active",function(e){
                    var url = $(this).data("href");
                    $.ajax({
                        url:url,
                        method:"post",
                        data:{"_token": "{{ csrf_token() }}"},
                        success:function(responsetext){
                            $('.table-data').DataTable().ajax.reload(null, false);
                        },
                        error: function(data_error, exception){
                            if(exception == "error"){
                                $(".alert_message").text(data_error.responseJSON.message);
                                $(".alert_message").fadeIn().delay(2000).fadeOut();
                            }
                        }
                    });
                });
        
                // end the is_active button
        
            });
        </script>
		<script src="{{asset('js/js.js')}}"></script>
        @yield('script')
    </body>
</html>
