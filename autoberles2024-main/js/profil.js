let app = angular.module('renterApp', []);
app.controller('RenterController', function($scope, $http) {
    //adatok beolvasása
    $http.get('http://localhost/autoberles2024.03.04/autoberles2024-main/backend/profil.php').then(function(response) {
                $scope.renterData = response.data.renterData;
                $scope.settlementData = response.data.settlementData;
                $scope.reservationData = response.data.reservationData;
                console.log($scope.renterData, $scope.settlementData, $scope.reservationData)
            });

    $http.get('http://localhost/autoberles2024.03.04/autoberles2024-main/backend/get_cars.php').then(function(response) {
                $scope.Cars = response.data;
                //console.log($scope.Cars);
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

    $scope.getCarName = function(carID) {
        // Keresd meg az autót a $scope.Cars tömbben a CarID alapján
        let car = $scope.Cars.find(car => car.CarID === carID);
        /*let name = car.BrandName;
        console.log(name);
        let model = car.CarModelName;
        console.log(model);*/
        // Ha találtunk autót, akkor adja vissza az autó nevét, különben üres stringet
        return car ? { Tipus: car.BrandName, Fajta: car.CarModelName } : {};
    };
 });