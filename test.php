<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Javascript · Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond/respond.min.js"></script>
    <![endif]-->


  </head>

<body>
<ul id="myTab" class="nav nav-tabs">
	<li class="active"><a href="#home" data-toggle="tab">Home</a></li>
	<li><a href="#profile" data-toggle="tab">Profile</a></li>
</ul>

<div id="myTabContent" class="tab-content">
	<div class="tab-pane fade in active" id="home">
		<p>1</p>
	</div>
	<div class="tab-pane fade" id="profile">
		<p>2</p>
	</div>
</div>


<ul class="nav nav-tabs" id="myTab">
	<li class="active"><a href="#students" data-toggle="tab">Invited</a></li>
	<li><a href="#confirmed" data-toggle="tab">Confirmed</a></li>
</ul>

<div class="tab-content" id="myTabContent">
	<div class="tab-pane fade in active" id="students">
		<p>I'm in Section 1.</p>
	</div>
	<div class="tab-pane fade" id="confirmed">
		<p>I'm in Section 2.</p>
	</div>
</div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap-collapse.js"></script>



  </body>
</html>
