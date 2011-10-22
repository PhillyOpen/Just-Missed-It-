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
		
		<script type="text/javascript"
src="https://static.twilio.com/libs/twiliojs/1.0/twilio.min.js"></script>
		
		<!--[if IE 6]>
			<style type="text/css">
			 @import url(themes/blackcandy/css/ie6.css);
			</style> 
		<![endif]-->
	</head>
	<body>

        <div class="container">
        $Layout
        </div>
    </body>
</html>
