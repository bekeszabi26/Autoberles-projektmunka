let app = angular.module('renterApp', []);
app.controller('RenterController', function($scope, $http) {
    //adatok beolvasása
    $http.get('http://localhost/autoberles2024.03.04/autoberles2024-main/backend/profil.php').then(function(response) {
                $scope.renterData = response.data.renterData;
                $scope.settlementData = response.data.settlementData;
                $scope.reservationData = response.data.reservationData;
                console.log($scope.renterData, $scope.settlementData, $scope.reservationData)
                
            });
    //adatok módodosítása ezt meg kell írnotok
    $scope.onCityChange = function () {
        let selectedCity = $scope.settlementData; 
        //var selectedCityId = $scope.selectedCity;
        //var selectedCity = $scope.settlementData.find(city => city.SettlementID === selectedCityId);
        if (selectedCity) {
            $scope.selectedZipCode = selectedCity.ZipCode;
           //$scope.selectedCounty = selectedCity.County;
        }
    };

    
 });