<!DOCTYPE html>
<html lang="$ContentLocale">
	<head>
		<meta charset="utf-8">
		<% base_tag %>
		<title><% if MetaTitle %>$MetaTitle<% else %>$Title<% end_if %> &raquo; $SiteConfig.Title</title>
		$MetaTags(false)
		<link rel="shortcut icon" href="/favicon.ico" />
		<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
		<!--[if lt IE 9]>
		  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<!-- Le styles -->
		<% require themedCSS(bootstrap-1.2.0) %> 
		<% require themedCSS(typography) %> 
		<% require themedCSS(overlay) %> 
		
		<% require javascript(http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js) %>
		<% require javascript(mysite/javascript/jquery.tools.min.js) %>
		<% require javascript(mysite/javascript/home.js) %>
		
		<!--[if IE 6]>
			<style type="text/css">
			 @import url(themes/blackcandy/css/ie6.css);
			</style> 
		<![endif]-->
	</head>
<body>
	<body>

    <div class="topbar">
      <div class="fill">
        <div class="container">
          <h3><a href="#">Just Missed It!</a></h3>
          <ul class="nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a id="about" href="#about" class="modalLink" rel="#aboutModal">About</a></li>
		<% if CurrentUser %>
            <li><a id="login" href="#login" class="modalLink" rel="#loginModal">Login</a></li>
		<% else %>
           <!-- <li><a href="http://blog.phillyopen.org" 
target="_blank">Phat Stats</a></li>
            <li><a href="#">My Account</a></li>
            <li><a href="#">Logout</a></li> -->
        <% end_if %>
          </ul>
        </div>
      </div>
    </div>

    <div class="container">

      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
        <h1>Just Missed It!<small>Find out if you just missed the last train bus or trolly, and when the next one will arrive.</small></h1>
        
       <!-- <p><a 
href="https://www.facebook.com/dialog/oauth?client_id=185247381547676&scope=email,offline_access,sms,publish_stream,user_about_me,user_birthday&redirect_uri=http://fatapp.emelle.me/signup"><img 
src="themes/jmi/img/fb-button.png" /></a></p> -->
      </div>

      <!-- Example row of columns -->
      <div class="row">
        <div class="span6">
          <h3>We'll tell you when the next bus/train/trolly is on its way.</h3>
          <p>If you are at a bus or train stop, and you simply want to know when the next one is coming, <strong>Just Missed It!</strong> will call you and let you know when its on its way!</p>
          <p>Lorem Ipsum
        </p>
          <p><a class="btn" href="#" target="_blank">Learn More </a></p>
        </div>
        <div class="span5">
          <h3>Know where you are, where you want to go, but not sure the best way to get there? We got your back.</h3>
           <p>Planning a trip with <strong>Just Missed It!</strong> makes catching the bus or train easy and fun! All you need to do is text us your location and destination, and we will call or text you and let you know what route to take. </p>
          <p><a class="btn" href="#" target="_blank">Learn More</a></p>
       </div>
        <div class="span5">
          <h3>Track how long you spend on trips, and help us improve our routing system!</h3>
          <p>When you go on trips you can simply "check-in" when you get on the bus or train, and "check-out" when you get off. We' won't share this information with anyone, but it will help make our machines smarter and more accurate!</p>
<!--          <p><a class="btn" href="#" target="_blank">Join Our 
Meet-Up Group! &raquo;</a></p> -->
        </div>
      </div>
      
      
      <footer>
        <p>&copy; Phat Apps 2011</p>
      </footer>
		$Form
    </div> <!-- /container -->

  </body>
</html>
</body>
</html>
