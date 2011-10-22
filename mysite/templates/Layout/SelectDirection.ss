 
<% if Invalid=true %>
<h4>Invalid Route: <strong>$Route</strong></h4>
<% end_if %>
<div style="text-align:center">
<h4>Route: $Route</h4>
<h3>Stop Location: $StopName</h3>
<p>Schedules</p>
<% control Schedules %>
<h5>$Time | <span>$Day</span> | <span id="startDest">$Destination1</span> to <span id="endDest">$Destination2</span></h5>
<% end_control %>

<div class="clearfix">

<p>Send me a reminder via</p>
<button class="btn info">SMS</button>
<button class="btn success">Voice Call</button>
<br/>
<input class="large" id="phoneNumber" name="phoneNumber" size="20" type="text" placeholder="Enter a valid 10 digit Number">
<br />
<div class="clearfix"></div>

<img src="http://www.sparqcode.com/qrgen?qt=url&data=$ThisURL&cap=Just Missed It!&col=144B88" height="200" />
</div>
</div>
