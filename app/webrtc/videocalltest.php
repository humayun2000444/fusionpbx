<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Janus WebRTC Server (0.x): Video Call Demo</title>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/8.1.1/adapter.min.js" ></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js" ></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
<script type="text/javascript" src="janus.js" ></script>
<script type="text/javascript" src="videocalltest.js"></script>
<script>
	$(function() {
		$(".navbar-static-top").load("navbar.html", function() {
			$(".navbar-static-top li.dropdown").addClass("active");
			$(".navbar-static-top a[href='videocalltest.html']").parent().addClass("active");
		});
		$(".footer").load("footer.html");
	});
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.4.0/cerulean/bootstrap.min.css" type="text/css"/>
<link rel="stylesheet" href="css/demo.css" type="text/css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css"/>
</head>
<body>

<a href="https://github.com/meetecho/janus-gateway"><img style="position: absolute; top: 0; left: 0; border: 0; z-index: 1001;" src="https://s3.amazonaws.com/github/ribbons/forkme_left_darkblue_121621.png" alt="Fork me on GitHub"></a>

<nav class="navbar navbar-inverse navbar-static-top">
</nav>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1>Plugin Demo: Video Call
					<button class="btn btn-default" autocomplete="off" id="start">Start</button>
				</h1>
			</div>
			<div class="container" id="details">
				<div class="row">
					<div class="col-md-12">
						
					</div>
				</div>
			</div>
			<div class="container hide" id="videocall">
				<div class="row">
					<div class="col-md-12">
						<div class="col-md-6 container hide" id="login">
							<div class="input-group margin-bottom-sm">
								<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
								<input class="form-control" type="text" placeholder="Choose a username" autocomplete="off" id="username" onkeypress="return checkEnter(this, event);" />
							</div>
							<button class="btn btn-success margin-bottom-sm" autocomplete="off" id="register">Register</button> <span class="hide label label-info" id="youok"></span>
						</div>
						<div class="col-md-6 container hide" id="phone">
							<div class="input-group margin-bottom-sm">
								<span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
								<input class="form-control" type="text" placeholder="Who should we call?" autocomplete="off" id="peer" onkeypress="return checkEnter(this, event);" />
							</div>
							<button class="btn btn-success margin-bottom-sm" autocomplete="off" id="call">Call</button>
						</div>
					</div>
				<div/>
				<div id="videos" class="hide">
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">Local Stream
									<div class="btn-group btn-group-xs pull-right hide">
										<button class="btn btn-danger" autocomplete="off" id="toggleaudio">Disable audio</button>
										<button class="btn btn-danger" autocomplete="off" id="togglevideo">Disable video</button>
										<div class="btn-group btn-group-xs">
											<button autocomplete="off" id="bitrateset" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
												Bandwidth<span class="caret"></span>
											</button>
											<ul id="bitrate" class="dropdown-menu" role="menu">
												<li><a href="#" id="0">No limit</a></li>
												<li><a href="#" id="128">Cap to 128kbit</a></li>
												<li><a href="#" id="256">Cap to 256kbit</a></li>
												<li><a href="#" id="512">Cap to 512kbit</a></li>
												<li><a href="#" id="1024">Cap to 1mbit</a></li>
												<li><a href="#" id="1500">Cap to 1.5mbit</a></li>
												<li><a href="#" id="2000">Cap to 2mbit</a></li>
											</ul>
										</div>
									</div>
								</h3>
							</div>
							<div class="panel-body" id="videoleft"></div>
						</div>
						<div class="input-group margin-bottom-sm">
							<span class="input-group-addon"><i class="fa fa-cloud-upload fa-fw"></i></span>
							<input class="form-control" type="text" placeholder="Write a DataChannel message to your peer" autocomplete="off" id="datasend" onkeypress="return checkEnter(this, event);" disabled />
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">Remote Stream <span class="label label-info hide" id="callee"></span> <span class="label label-primary hide" id="curres"></span> <span class="label label-info hide" id="curbitrate"></span></h3>
							</div>
							<div class="panel-body" id="videoright"></div>
						</div>
						<div class="input-group margin-bottom-sm">
							<span class="input-group-addon"><i class="fa fa-cloud-download fa-fw"></i></span>
							<input class="form-control" type="text" id="datarecv" disabled />
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<hr>
	<div class="footer">
	</div>
</div>

</body>
</html>
