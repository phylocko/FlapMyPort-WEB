<?php
 require('config.php');
?>
var AnalyzerApp = angular.module('AnalyzerApp', []);

AnalyzerApp.controller('HostListController', function HostListController($scope, $http, $filter) { 

	var today = new Date();
	var hourago = new Date(today.getTime() - (1000*60*60));
	var format = "yyyy-MM-dd HH:mm:ss";

	$scope.start = $filter('date')(new Date(hourago), format);
	$scope.end = '';
	//$scope.end = $filter('date')(new Date(), format);

	$scope.isLoading = false;

	$scope.get = function ($url)
	{
		if($url == "") 
		{
			$url = "<?=api_url ?>/?review&format=json";
		}

		$scope.isLoading = true;
		$http.get($url).then(function(value) {
			$scope.hosts = value.data.hosts;
			$scope.firstFlapTime = value.data.params.firstFlapTime;
			$scope.lastFlapTime = value.data.params.lastFlapTime;
			$scope.isLoading = false;
		});
	}

	$scope.getFlaps = function (hostIndex, portIndex, $ifIndex, $ipAddress)
	{
		$url = "<?=api_url ?>/?ifindex=" + $ifIndex + "&flaphistory&host=" + $ipAddress + "&start=" + $scope.start + "&end=" + $scope.end;
		$scope.tmp = $url;
		$scope.isLoading = true;

		$http.get($url).then(function(value) {
		        $scope.hosts[hostIndex].ports[portIndex].flaps = value.data;
		        $scope.isLoading = false;
		});

	}

});
