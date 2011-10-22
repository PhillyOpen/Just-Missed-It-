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
		<% require javascript(mysite/javascript/jquery.countdown.js) %>
		<% require javascript(mysite/javascript/home.js) %>
		
		<script type="text/javascript"
src="https://static.twilio.com/libs/twiliojs/1.0/twilio.min.js"></script>
		
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
      <div class="" style="text-align:center">
        <h1>Just Missed It!<br /><small>Southeastern Pennsylvania Transit Application</small></h1>
        <h2 style="color:#F15D30">+1-215-874-6340</h2>
        <p style="color:#144B88">Text your nearest intersection, followed by the bus/trolly number, and we will send you the latest schedule information.
        <br />e.g. <strong>"3rd and Poplar bus 27"</strong></p>
       <!-- <p><a 
href="https://www.facebook.com/dialog/oauth?client_id=185247381547676&scope=email,offline_access,sms,publish_stream,user_about_me,user_birthday&redirect_uri=http://fatapp.emelle.me/signup"><img 
src="themes/jmi/img/fb-button.png" /></a></p> -->
      </div>
      
    <div class="row">
    <div id="menuBox" class="span8">
    <a href="#" id="trainButton"><img src="/themes/jmi/img/train.png" width="50"/></a>
    <a href="#" id="busButton"><img src="/themes/jmi/img/bus.png" width="50"/></a>
    </div>
    </div>
	<div class="row show-grid">
        	<div id="busBox" class="span8">
        		<h3>Bus or Trolly</h3>
        		
        		<h6>What stop are you at?</h6>
        		
        		<div class="input-append">
		    		<input class="xlarge" id="userLocation" name="userLocation" size="30" type="text" placeholder="Enter the address or intersection">
		    		<label class="add-on" id="forAddress"><input type="checkbox" name="" id="" value="" disabled=""></label>
		    		<div class="clearfix"></div>
	    		</div>
	    		
        		<h6>What bus do you want to take?</h6>
        		<div class="input-append">
        		<input class="small" id="transitNumber" name="transitNumber" size="20" type="text" placeholder="bus/trolly #">
        		<label class="add-on" id="forRoute"><input type="checkbox" name="" id="" value="" disabled=""></label>
		    		<div class="clearfix"></div>
        		</div>
        		
        		<h6>Which direction do you want to travel?</h6>
        		<div class="clearfix">
		        <div class="input-append">
		          <select name="userDestination" id="userDestination">
		            <option>Enter your location and route #</option>
		          </select>
		        </div>
		      </div>
        		
        		
        		
        		<!--
        		<h3>Regional Rail</h3>
        		
        		<h6>Where are you at?</h6>
        		<h6>What train do you want to take?</h6>
        		<h6>Where do you want to go?</h6>
        		<h6>When do you want to leave?</h6>
        		-->
        	</div>
        	
        	<div id="trainBox" class="span8">
        		<h3>Regional Rail</h3>
        		
        		<h6>What station are you at?</h6>
        		
        		<div class="input-append">
		    		<input class="xlarge" id="userLocation" name="userLocation" size="40" type="text" placeholder="Enter your current Station">
		    		<label class="add-on" id="forAddress"><input type="checkbox" name="" id="" value="" disabled=""></label>
		    		<div class="clearfix"></div>
	    		</div>
	    		
        		<h6>Where do you want to go?</h6>
        		<div class="input-append">
        		<input class="xlarge" id="userDestination" name="userDestination" size="40" type="text" placeholder="Enter a Destination Station">
        		<label class="add-on" id="forRoute"><input type="checkbox" name="" id="" value="" disabled=""></label>
		    		<div class="clearfix"></div>
        		</div>
        		
        		
        		
        		
        		
        		<!--
        		<h3>Regional Rail</h3>
        		
        		<h6>Where are you at?</h6>
        		<h6>What train do you want to take?</h6>
        		<h6>Where do you want to go?</h6>
        		<h6>When do you want to leave?</h6>
        		-->
        	</div>
        	<div class="span8">
        		<h3>Result <small id="smsString">sms handler:</small></h3>
        		<h6>Fill out the form to begin</h6>
        		<div id="firstResults">
        		<p>Enter your location to begin.</p>
        		</div>
        		<div id="secondResults">
        		</div>
        	</div>
        
        </div>
        <hr>
      <!-- Example row of columns 
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

        </div>
      </div>
      
      -->
      
      <% include subscribeModal %>
      <footer>
        <p>&copy; <a href="http://phillyopen.org">Phat.Apps</a> 2011 | <a href="http://live.appsforsepta.org/">Septa Hack-a-thon</a> | <a href="http://septa.org">SEPTA.org</a></p>
      </footer>
		$Form
    </div> <!-- /container -->

  </body>
</html>
