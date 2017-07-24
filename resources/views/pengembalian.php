<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../resources/assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../resources/assets/img/logo_asabri.png" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Aplikasi Kantor Cabang PT. Asabri (Persero)</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="../resources/assets/css/bootstrap.min.css" rel="stylesheet" />

    <!--  Material Dashboard CSS    -->
    <link href="../resources/assets/css/material-dashboard.css" rel="stylesheet"/>

    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="../resources/assets/css/demo.css" rel="stylesheet" />

    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
</head>

<body>

	<div class="wrapper">
	    <div class="sidebar" data-color="purple" data-image="../resources/assets/img/sidebar-1.jpg">
			<!--
	        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"
		    Tip 2: you can also add an image using data-image tag

			-->

			<div class="logo">
				<a href="http://www.creative-tim.com" class="simple-text">
					Creative Tim
				</a>
			</div>


	    	<div class="sidebar-wrapper">
				<ul class="nav">
	               <li>
	                    <a href="<?php echo $app->make('url')->to('/dashboard')?>">
	                        <i class="material-icons">dashboard</i>
	                        <p>Dashboard</p>
	                    </a>
	                </li>
	                <li class="active">
	                    <a href="<?php echo $app->make('url')->to('/table');?>">
	                        <i class="material-icons">content_paste</i>
	                        <p>Dropping</p>
	                    </a>
	                </li>
	            </ul>
	    	</div>
		</div>

	    <div class="main-panel">
			<nav class="navbar navbar-transparent navbar-absolute">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#">Table List</a>
					</div>
					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav navbar-right">
							<li>
								<a href="#pablo" class="dropdown-toggle" data-toggle="dropdown">
									<i class="material-icons">dashboard</i>
									<p class="hidden-lg hidden-md">Dashboard</p>
								</a>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="material-icons">notifications</i>
									<span class="notification">5</span>
									<p class="hidden-lg hidden-md">Notifications</p>
								</a>
								<ul class="dropdown-menu">
									<li><a href="#">Mike John responded to your email</a></li>
									<li><a href="#">You have 5 new tasks</a></li>
									<li><a href="#">You're now friend with Andrew</a></li>
									<li><a href="#">Another Notification</a></li>
									<li><a href="#">Another One</a></li>
								</ul>
							</li>
							<li>
								<a href="#pablo" class="dropdown-toggle" data-toggle="dropdown">
	 							   <i class="material-icons">person</i>
	 							   <p class="hidden-lg hidden-md">Profile</p>
	 						   </a>
							</li>
						</ul>

						<form class="navbar-form navbar-right" role="search">
							<div class="form-group  is-empty">
	                        	<input type="text" class="form-control" placeholder="Search">
	                        	<span class="material-input"></span>
							</div>
							<button type="submit" class="btn btn-white btn-round btn-just-icon">
								<i class="material-icons">search</i><div class="ripple-container"></div>
							</button>
	                    </form>
					</div>
				</div>
			</nav>

	        <div class="content">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="col-md-12">
	                        <div class="card">
	                            <div class="card-header" data-background-color="purple">
	                                <h4 class="title">Pengembalian Dropping</h4>
	                            </div>
	                            <div class="card-content table-responsive">
		                            <div class="col-md-6">
			                            	<div class="form-group" style="overflow: hidden;" >
				                                <div class="col-md-3">
				                                    <label for="">Tanggal</label>
				                                </div>
				                                <div class="col-md-9">
				                                    <input type="text" class="form-control" placeholder="17/07/2017" disabled>
				                                </div>
				                            </div>
				                            <div class="form-group" style="overflow: hidden;" >
				                                <div class="col-md-3">
				                                    <label for="">Jumlah</label>
				                                </div>
				                                <div class="col-md-9">
				                                    <input type="text" placeholder="Masukkan nominal kelebihan dropping" class="form-control">
				                                </div>
				                            </div>
				                            <div class="form-group" style="overflow: hidden;" >
				                                <div class="col-md-3">
				                                    <label for="">Nama Bank</label>
				                                </div>
				                                <div class="col-md-9">
				                                    <select class="form-control">
			                                        	<option value="">BCA</option>
			                                    	</select>
				                                </div>
				                            </div>
				                            <div class="form-group" style="overflow: hidden;" >
				                                <div class="col-md-3">
				                                    <label for="">No. Rekening</label>
				                                </div>
				                                <div class="col-md-9">
				                                    <input type="text" placeholder="Masukkan no.rekening" class="form-control">
				                                </div>
				                            </div>
				                        <a href="<?php echo $app->make('url')->to('/table');?>" class="btn btn-primary pull-right" style = "background-color:#F1C40F">Kirim<div class="ripple-container"></div></a>
			                        </div>
		                     	</div>
	                        </div>
	                    </div>

	                    
	                    </div>
	                </div>
	            </div>
	        </div>

	        <footer class="footer">
	            <div class="container-fluid">
	                <nav class="pull-left">
	                    <ul>
	                        <li>
	                            <a href="#">
	                                Home
	                            </a>
	                        </li>
	                        <li>
	                            <a href="#">
	                                Company
	                            </a>
	                        </li>
	                        <li>
	                            <a href="#">
	                                Portfolio
	                            </a>
	                        </li>
	                        <li>
	                            <a href="#">
	                               Blog
	                            </a>
	                        </li>
	                    </ul>
	                </nav>
	                <p class="copyright pull-right">
	                    &copy; <script>document.write(new Date().getFullYear())</script> <a href="http://www.creative-tim.com">Creative Tim</a>, made with love for a better web
	                </p>
	            </div>
	        </footer>
	    </div>
	</div>

</body>

	<!--   Core JS Files   -->
	<script src="../resources/assets/js/jquery-3.1.0.min.js" type="text/javascript"></script>
	<script src="../resources/assets/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="../resources/assets/js/material.min.js" type="text/javascript"></script>

	<!--  Charts Plugin -->
	<script src="../resources/assets/js/chartist.min.js"></script>

	<!--  Notifications Plugin    -->
	<script src="../resources/assets/js/bootstrap-notify.js"></script>

	<!--  Google Maps Plugin    -->
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

	<!-- Material Dashboard javascript methods -->
	<script src="../resources/assets/js/material-dashboard.js"></script>

	<!-- Material Dashboard DEMO methods, don't include it in your project! -->
	<script src="../resources/assets/js/demo.js"></script>

</html>
