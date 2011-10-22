<?php
class Page extends SiteTree {

	public static $db = array(
	);

	public static $has_one = array(
	);

}
class Page_Controller extends ContentController {

	/**
	 * An array of actions that can be accessed via a request. Each array element should be an action name, and the
	 * permissions or conditions required to allow the user to access it.
	 *
	 * <code>
	 * array (
	 *     'action', // anyone can access this action
	 *     'action' => true, // same as above
	 *     'action' => 'ADMIN', // you must have ADMIN permissions to access this action
	 *     'action' => '->checkAction' // you can only access this action if $this->checkAction() returns true
	 * );
	 * </code>
	 *
	 * @var array
	 */
	public static $allowed_actions = array (
	);
	
	public function geocodeAddress($arguments) {
		$params = $arguments->requestVars();
		if(!@$params['q']){
			//To-do: Return User Error
			user_error('Missing query Parameter');
		}
		$q = $params['q'];
		$a = new RestfulService('http://maps.googleapis.com/maps/api/geocode/json?address='.$params['q'].'+Philadelphia,+PA&sensor=true');
		$addy = $a->request();
		if($addy->getStatusCode() == 200){
			//Status Good. Parse geocode
			
			$results = json_decode($addy->getBody());
			return $results;
		}
	}
	
	public function nearbyStops(&$arguments) { 
		//Search Stops near given location.
		$geoinfo = $this->geocodeAddress($arguments);
		$latlng = "LATLNG(".$geoinfo->results[0]->geometry->location->lat.",".$geoinfo->results[0]->geometry->location->lng.")";
		$sql = 'https://www.google.com/fusiontables/api/query?sql=SELECT+*+FROM+1913429+ORDER+BY+ST_Distance(geolocation,+'.$latlng.')+LIMIT+5';
		$r = new RestfulService($sql,$expiry = 360);
		$resp = $r->request();
		
		$stops = explode("\n",$resp->getBody());
		Session::set('stops', $stops);
		
		//Perform Query on Fusion Table for nearby stops
		if($stops[1]==''){
					//Blank result. try a different address.
					echo "No Results";
					exit;
		}
		
		$stopids = json_encode($stops);
		$schedules = array();
		$aRoute = array();
		$nearbyStops = new DataObjectSet();
		
		//Make sense of the stopids
		foreach($stops as $num=>$results){
			if($num > 0){
				if(!empty($results)){
					$r = str_getcsv($results);
					$aStop = array(
								"stop_id" => $r[0],
								"stop_name" => $r[1]
							);
					//$a = new ArrayData($aStop);
					$nearbyStops->push($aStop);
				}
			}	
		}
		//header("content-type: text/json");
		echo json_encode($nearbyStops->toArray());
		exit;
	}
	
	public function checkStop($arguments){
		$params = $arguments->requestVars();
		if(!@$params['q']){
			//To-do: Return User Error
			user_error('Missing query Parameter');
		}
		$q = $params['q'];
		//Search Stops near given location.
		$geoinfo = $this->geocodeAddress($arguments);
		$latlng = "LATLNG(".$geoinfo->results[0]->geometry->location->lat.",".$geoinfo->results[0]->geometry->location->lng.")";
		$sql = 'https://www.google.com/fusiontables/api/query?sql=SELECT+*+FROM+1913429+ORDER+BY+ST_Distance(geolocation,+'.$latlng.')+LIMIT+5';
		$r = new RestfulService($sql,$expiry = 360);
		$resp = $r->request();
		
		if($resp->getStatusCode() == 200){
		$stops = explode("\n",$resp->getBody());
		Session::set('stops', $stops);
		
		//Perform Query on Fusion Table for nearby stops
		if($stops[1]==''){
					//Blank result. try a different address.
					echo "No Results";
					exit;
		}
		
		$stopids = json_encode($stops);
		$schedules = array();
		$aRoute = array();
		$routes = array();
		$nearbyStops = new DataObjectSet();
		$allRoutes = new DataObjectSet();
				//return $stopids;
				//var_dump($stops);
				//var_dump(date('g:i a'));
				//Make sense of the stopids
				foreach($stops as $num=>$results){
					if($num > 0){
					if(!empty($results)){
					$r = str_getcsv($results);
					
					$stopid = $r[0];
						if($stopid != ""){
							//Check Stop ID
							$getroute = 'http://www3.septa.org/hackathon/BusSchedules/?req1='.$stopid;
							
							
							Session::set('stop_id', $stopid);
							$r = new RestfulService($getroute,$expiry = 60);
							$resp = $r->request();
							//Parse Response
							$info = json_decode($resp->getBody());
							$i = (array) $info;
							//itterate through the information
							foreach ($i as $t){
								$t = (array) $t;
								foreach($t as $z){
									$z = (array) $z;
									array_push($routes,$z["Route"]);
									array_push($schedules,$z);
								}
							}
							//array_push($routes,$info->32);
						}	
					}
					}
				}
				
				
				
				Session::set('Routes', $routes);
				
				Session::set('Schedules', $schedules);
				foreach($schedules as $key=>$value){
					if(!empty($value)){
						$aRoute = array(
							"RouteNumber" => $value["Route"]
						);
					$allRoutes->push(new ArrayData($aRoute));
					}
				}
				$d = array(
				"Address" => $q,
				"SuggestedRoutes" => $allRoutes
				);
				return $this->customise($d)->renderWith('SelectRoute');
				
			}else if($locationtype == 'street_address'){
				//User entered a street address. Run Select query on fusion table using circle to find nearby stop id's
				$returning[0] = "invalid";
				return json_encode($returning);
			}else{
				//Location type probably locality. Probably invalid address
				$returning[0] = "invalid";
				return json_encode($returning);
			}
			//var_dump($locationtype);
		}
		//$r = new RestfulService('https://www.google.com/fusiontables/api/query?sql=SELECT+stop_name+FROM+1779726+WHERE+stop_name+CONTAINS+\'3rd\'+AND+stop_name+CONTAINS+\'Poplar\'',$expiry = 3600);
		//$resp = $r->request();
		//$stops = explode("\n",$resp->getBody());
	
	public function routesByStop($arguments){
		$params = $arguments->requestVars();
		$urlseg = $arguments->latestParams();
		$stop_id = @$params['stop_id'];
		$stopname ='';
		$routenum = @$params['route'];
		$route = @$params['route'];
		$routes = array();
		$schedules = array();
		$mySchedules = new DataObjectSet();
		$aRoute = array();
		$allRoutes = new DataObjectSet();
		//var_dump();
		//We have two street params. Lets query for stop id
		$sql = 'https://www.google.com/fusiontables/api/query?sql=SELECT+stop_name+FROM+1779726+WHERE+stop_id+='.$stop_id;
		$r = new RestfulService($sql,$expiry = 3600);
		$resp = $r->request();
		$stops = explode("\n",$resp->getBody());
		foreach($stops as $num=>$stopnam){
			if($num > 0){
				if($stopnam != ""){
				$stopname = $stopnam;
				}
			}
		}					
		
		$getroute = 'http://www3.septa.org/hackathon/BusSchedules/?req1='.$stop_id;
		$b = new RestfulService($getroute,$expiry = 30);
		$bresp = $b->request();
		//Parse Response
		$info = json_decode($bresp->getBody());
		$i = (array) $info;
		//itterate through the information
		foreach ($i as $t){
			$t = (array) $t;
			foreach($t as $z){
				$z = (array) $z;
				array_push($routes,$z["Route"]);
				array_push($schedules,$z);
			}
		}
		//var_dump($stop_id);
		$sql = 'https://www.google.com/fusiontables/api/query?sql=SELECT+route_long_name+FROM+1779806+WHERE+route_short_name+=+\''.$routenum.'\'';
		$r = new RestfulService($sql,$expiry = 3600);
		$resp = $r->request();
		$rname = explode("\n",$resp->getBody());
		$routename = $rname[1];
		foreach($schedules as $key=>$value){
			if(!empty($value)){
				//Route Found. See if it matches our query
				if($route == $value["Route"]){
				$q = $route;
				//Route information found. Sweet send results and exit
				//Lets get some Route Info from our Fusion Table
				
				//Parse Route Name
				$route = array();
				$end = $toloc = strstr($routename, "to ");
				$route[$value["Direction"]] = substr($end,3);
				if($value["Direction"] == 0){
					$route[1] = strstr($routename, 'to ', true);
				}else{
					$route[0] = strstr($routename, 'to ', true);
				}
				
				$s = array(
					"Time" => $value["date"],
					"Day" => $value["day"],
					"Direction" => $value["Direction"],
					"RouteName" => $routename,
					"Destination1" => $route[0],
					"Destination2" => $route[1]
				);
				$mySchedules->push(new ArrayData($s));
				}
			}
		}
		//var_dump();
		$ThisURL = Director::absoluteURL(urlencode('/home/routesByStop?stop_id='.$stop_id.'%26route='.$routenum));
		$d = array(
		"StopName"=>$stopname,
		"Route" => $routename,
		"Schedules" => $mySchedules,
		"ThisURL" => $ThisURL
		);
		
		if($urlseg["ID"] == 'voice'){
			//Print xml for twilio voice
			
		}else if($urlseg["ID"] == 'sms'){
			//Print xml for twilio sms
			header("content-type: text/xml");
				echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
				echo '<Response>';
				echo '<Sms>Oh boy. This is embarassing. Our monkeys have stepped out for lunch. We will get you that sweet transit information as soon as they return to their iMacs. In the meantime visit JustMissedIt.mobi for the latest happenings with this project. :)</Sms>';
				echo '</Response>';
		}else if($urlseg["ID"] == 'qrcode'){
			//Print just qr code
			echo '<img src="http://www.sparqcode.com/qrgen?qt=url&data='.$ThisURL.'&cap=Just Missed It!&col=144B88" />';
		}else{
			return $this->customise($d)->renderWith(array('MobiPage','SelectDirection'));	
		}		
		
	}
	
	public function checkRoute($arguments){
		$params = $arguments->requestVars();
		$q = @$params['q'];
		if(!@$params['q']){
			$d = array(
			'Invalid' => true
			);
			return $this->customise($d)->renderWith('SelectDirection');
		}
		if(!is_numeric($q)){
			$d = array(
			'Invalid' => true
			);
			return $this->customise($d)->renderWith('SelectDirection');
		}
		//Check to see if The route entered is in the session
		$mySchedules = new DataObjectSet();
		
		$schedules = Session::get('Schedules');
		foreach($schedules as $key=>$value){
			if(!empty($value)){
				//Route Found. See if it matches our query
				if($q == $value["Route"]){
				//Route information found. Sweet send results and exit
				
				/*Lets get some Route Info from our Fusion Table*/
				$sql = 'https://www.google.com/fusiontables/api/query?sql=SELECT+route_long_name+FROM+1779806+WHERE+route_short_name+=+\''.$q.'\'';
				$r = new RestfulService($sql,$expiry = 3600);
				$resp = $r->request();
				$rname = explode("\n",$resp->getBody());
				$routename = $rname[1];
				
				//Parse Route Name
				$route = array();
				$end = $toloc = strstr($routename, "to ");
				$route[$value["Direction"]] = substr($end,3);
				if($value["Direction"] == 0){
					$route[1] = strstr($routename, 'to ', true);
				}else{
					$route[0] = strstr($routename, 'to ', true);
				}
				
				$s = array(
					"Time" => $value["date"],
					"Day" => $value["day"],
					"Direction" => $value["Direction"],
					"RouteName" => $routename,
					"Destination1" => $route[0],
					"Destination2" => $route[1]
				);
				$mySchedules->push(new ArrayData($s));
				}
			}
		}
		$stop_id = Session::get('stop_id');
		$ThisURL = Director::absoluteURL('/home/routesByStop?stop_id='.$stop_id.'%26route='.$q);
		
		$d = array(
		"Route" => $q,
		"Schedules" => $mySchedules,
		"ThisURL" => $ThisURL
		);
		
		return $this->customise($d)->renderWith('SelectDirection');
		
		//If route was not in session, it means that the route they entered is not associated with the stop they entered
		//Suggest Route Numbers near the location they entered
	}

	public function init() {
		parent::init();

		// Note: you should use SS template require tags inside your templates 
		// instead of putting Requirements calls here.  However these are 
		// included so that our older themes still work
	}
}
