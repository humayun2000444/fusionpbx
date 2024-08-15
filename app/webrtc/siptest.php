<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>WebRTC</title>
    <script
      type="text/javascript"
      src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/8.1.1/adapter.min.js"
    ></script>
    <script
      type="text/javascript"
      src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"
    ></script>
    <script
      type="text/javascript"
      src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"
    ></script>
    <script
      type="text/javascript"
      src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/js/bootstrap.min.js"
    ></script>
    <script
      type="text/javascript"
      src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"
    ></script>
    <script
      type="text/javascript"
      src="https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.js"
    ></script>
    <script
      type="text/javascript"
      src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.6.0/js/md5.min.js"
    ></script>
    <script
      type="text/javascript"
      src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"
    ></script>
    <script type="text/javascript" src="janus.js"></script>
    <script type="text/javascript" src="siptest.js"></script>
    <script>
      $(function () {
        $('.navbar-static-top').load('navbar.html', function () {
          $('.navbar-static-top li.dropdown').addClass('active');
          $(".navbar-static-top a[href='siptest.html']")
            .parent()
            .addClass('active');
        });
        $('.footer').load('footer.html');
      });
    <?php
	require_once dirname(__DIR__, 2) . "/resources/require.php";
    require_once "resources/check_auth.php";
	require_once "resources/paging.php";
	
	require_once "resources/footer.php";


  
    ?>
    
    </script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.4.0/cerulean/bootstrap.min.css"
      type="text/css"
    />
    <link rel="stylesheet" href="css/demo.css" type="text/css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
      type="text/css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css"
    />
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="page-header">
            <h1>
              IP PBX Web RTC
            </h1>
          </div>

          <div class="container hide" id="sipcall">
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-6 container hide" id="login">
                  <!-- Rizwan Changes -->
                  <!-- <div class="input-group margin-bottom-sm">
								<span class="input-group-addon"><i class="fa fa-cloud-upload fa-fw"></i></span>
								<input class="form-control" type="text" placeholder="SIP Registrar (e.g., sip:host:port)" autocomplete="off" id="server" onkeypress="return checkEnter(this, event);" />
							</div> -->
                  <div class="input-group margin-bottom-sm">
                    <span class="input-group-addon"
                      ><i class="fa fa-user fa-fw"></i
                    ></span>
                    <input
                      class="form-control"
                      type="text"
                      placeholder="SIP Identity (e.g., sip:goofy@example.com)"
                      autocomplete="off"
                      id="username"
                      onkeypress="return checkEnter(this, event);"
                    />
                  </div>
                  <div class="input-group margin-bottom-sm">
                    <span class="input-group-addon"
                      ><i class="fa fa-user-plus fa-fw"></i
                    ></span>
                    <input
                      class="form-control"
                      type="text"
                      placeholder="Username (e.g., goofy, overrides the one in the SIP identity if provided)"
                      autocomplete="off"
                      id="authuser"
                      onkeypress="return checkEnter(this, event);"
                    />
                  </div>
                  <div class="input-group margin-bottom-sm">
                    <span class="input-group-addon"
                      ><i class="fa fa-key fa-fw"></i
                    ></span>
                    <input
                      class="form-control"
                      type="password"
                      placeholder="Secret (e.g., mysupersecretpassword)"
                      autocomplete="off"
                      id="password"
                      onkeypress="return checkEnter(this, event);"
                    />
                  </div>
                  <!-- Rizwan Changes -->
                  <!-- <div class="input-group margin-bottom-sm">
								<span class="input-group-addon"><i class="fa fa-quote-right fa-fw"></i></span>
								<input class="form-control" type="text" placeholder="Display name (e.g., Alice Smith)" autocomplete="off" id="displayname" onkeypress="return checkEnter(this, event);" />
							</div> -->
                  <div class="btn-group btn-group-sm" style="width: 100%">
                    <button
                      class="btn btn-primary"
                      autocomplete="off"
                      id="register"
                      style="width: 30%"
                    >
                      Register
                    </button>
                    <div class="btn-group btn-group-sm" style="width: 70%">
                      <!-- <button autocomplete="off" id="registerset" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="width: 100%">
										Register using plain secret
									</button> -->
                      <!-- <ul id="registerlist" class="dropdown-menu" role="menu"> -->
                      <!-- Rizwan Changes-->
                      <!-- <li><a href='#' id='secret'>Register using plain secret</a></li> -->
                      <!-- <li><a href='#' id='ha1secret'>Register using HA1 secret</a></li>
										<li><a href='#' id='guest'>Register as a guest (no secret)</a></li> -->
                      <!-- </ul> -->
                    </div>
                  </div>
                </div>
                <div class="col-md-6 container hide" id="phone">
                  <div class="input-group margin-bottom-sm">
                    <span class="input-group-addon"
                      ><i class="fa fa-phone fa-fw"></i
                    ></span>
                    <!-- Rizwan Changes -->
                    <!-- <input class="form-control" type="text" placeholder="SIP URI to call (e.g., sip:1000@example.com)" autocomplete="off" id="peer" onkeypress="return checkEnter(this, event);" /> -->
                    <input
                      class="form-control"
                      type="text"
                      placeholder="SIP URI to call (example: 5555)"
                      autocomplete="off"
                      id="peer"
                      onkeypress="return checkEnter(this, event);"
                    />
                  </div>
                  <button
                    class="btn btn-success margin-bottom-sm"
                    autocomplete="off"
                    id="call"
                  >
                    Call
                  </button>
                  <input autocomplete="off" id="dovideo" type="checkbox" />Use
                  Video
                </div>
              </div>
            </div>
            <div id="videos" class="hide">
              <div class="col-md-6">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title">You</h3>
                  </div>
                  <div class="panel-body" id="videoleft"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title">Remote UA</h3>
                  </div>
                  <div class="panel-body" id="videoright"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <hr />
      <!-- Rizwan Changes -->
      <!-- <div class="footer">
	</div> -->
    </div>
  </body>
</html>
