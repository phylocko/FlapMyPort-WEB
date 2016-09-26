<?php
 require('config.php');
?>
<!DOCTYPE html>
<html ng-app="AnalyzerApp">
<head>

<script src="https://code.jquery.com/jquery-2.2.4.js"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">


<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.min.js"></script>

<!-- DateTimePicker -->

<!--link rel="stylesheet" type="text/css" media="screen" href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css"-->
<!--link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet"-->
<!--link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet"-->

<!--script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script-->
<!--script type="text/javascript" src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.pt-BR.js"></script-->

<script src="app.php"></script>

<script>
 $(function () {
  $('[data-toggle="tooltip"]').tooltip()
 })
</script>


</head>
<body ng-controller="HostListController" data-ng-init="get('')" style="padding-left: 10px; padding-top: 70px; padding-right: 10px;">



<!--script type="text/javascript">
$(function() {
    $('#datetimepicker1').datetimepicker({
	pickDate: true,
	pickTime: true,
	pick12HourFormat: false
   });
});
</script-->


<nav class="navbar navbar-default navbar-fixed-top" style="opacity: 0.95;">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?=url ?>">i<b>Sweet</b>Home</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

    	<form class="navbar-form navbar-left" role="search">
    		<div class="form-group">
    			<div class='input-group date' id='datetimepicker1'>
    				<input
				data-format="yyyy-MM-dd hh:mm:ss"
				type='text' ng-disabled="isLoading" class="form-control" ng-model="start" placeholder="Time From"/>
    				<span class="input-group-addon">
    					<span class="glyphicon glyphicon-calendar"></span>
    				</span>
    			</div>

    			<div class='input-group date' id='datetimepicker2'>
    				<input
					data-format="yyyy-MM-ss HH:mm:ss"
					type='text' ng-disabled="isLoading" class="form-control" ng-model="end" placeholder="Time To"/>

    				<span class="input-group-addon">
    					<span class="glyphicon glyphicon-calendar"></span>
    				</span>
    			</div>


    			<div class='input-group date' id='filter'>
    				<input 
					data-toggle="tooltip" data-placement="bottom" title="Filter value"
					type='text' ng-disabled="isLoading" class="form-control" ng-model="fil" placeholder="Filter"/>
    			</div>

    			<button type="submit" ng-disabled="isLoading" class="btn btn-default"
    				ng-click="get('<?=api_url?>/?review&format=json&start=' + start + '&end=' + end + '&filter=' + fil)">Show
			</button>

    			</div>
		</div>
    	</form>

    </div>


    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div ng-repeat="(hostIndex, host) in hosts">

	<h4>{{ host.name }} ({{host.ipaddress}})</h4>

	<table class="table table-hover table-striped">

	<tr ng-repeat="(portIndex, port) in host.ports">
		<td style="width: 30px;"> <input type="checkbox"></td>
		<td style="width: 30px;">
			<div ng-show="port.isBlacklisted" class="text-danger">
				<span class="glyphicon glyphicon-play" aria-hidden="true"></span>
			</div>
			<div ng-hide="port.isBlacklisted" class="text-success">
				<span class="glyphicon glyphicon-pause" aria-hidden="true"></span>
			</div>
		</td>
		<td style="width: 100px;">
			<span ng-if="port.ifOperStatus == 'up'" class="label label-success">{{ port.ifName }}</span>
			<span ng-if="port.ifOperStatus == 'down'" class="label label-danger">{{ port.ifName }}</span>
		</td> 
		<td style="width: 230px;"> {{ port.ifAlias }} </td>
		<td> {{ port.firstFlapTime }} — {{ port.lastFlapTime }}</td> 
		<td class="text-right"> 
			<div>
			<img class="img-rounded" ng-src="<?=api_url?>/?ifindex={{port.ifIndex}}&flapchart&host={{host.ipaddress}}&start={{start}}&end={{end}}">

			<!--button class="btn btn-default btn-xs" ng-click="getFlaps(hostIndex, portIndex, port.ifIndex, host.ipaddress)">Show flaps</button-->
			</div>
			<!--div style="width: 200px; float: right; margin-top: 10px;">
			<ul class="list-group">
				<li ng-repeat="flap in port.flaps"	class="list-group-item">
					<span ng-if="flap.ifOperStatus == 'up'">	{{flap.time}} <span class="label label-success">Up</span></span>
					<span ng-if="flap.ifOperStatus == 'down'">	{{flap.time}} <span class="label label-danger">Dn</span></span>
				</li>
			</ul>
			</div-->
		
		</td>
		<td class="text-right" style="width: 60px;">
			
			<span ng-if="port.ifOperStatus == 'up'" class="label label-success">{{ port.flapCount }}</span>
			<span ng-if="port.ifOperStatus == 'down'" class="label label-danger">{{ port.flapCount }}</span>
		</td>
	</tr>

	</table>
</div>

</body>
</html>
