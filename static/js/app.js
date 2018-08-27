var app = angular.module('myApp', []);
app.controller('Note', function ($scope, $rootScope, $http, $compile) {
    $scope.count = 0;
    console.log("ASd");

    $scope.pullPosts = function () {

        $http({
            method: 'POST',
            url: 'http://localhost/demo/pullpost.php'

        }).then(function (response) {// on success
            console.log(response);
            $scope.postlength = response.data.length;
            $("#posts").html($compile('<post-card postdata="data" class="col-lg-3"></post-card>')($scope.data=response.data));

        }, function (response) {

            console.log(response.data, response.status);

        });

    };
    $scope.pullPosts();

    $scope.addPost = function () {

        if ($scope.title != "" && $scope.story != "") {
            //$scope.list.push({count: "c" + $scope.count, title: $scope.title, story: $scope.story});

            //$scope.data = $scope.list;
            //$rootScope.list = $scope.list;
            $rootScope.formData = {
                "title1": $scope.title,
                "story1": $scope.story
            }
                console.log($rootScope.formData);

            $http({
                method: 'POST',
                url: 'http://localhost/demo/addpost.php',
                headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'},
                data: $.param($rootScope.formData)

            }).then(function (response) {// on success
               
                alert(response.data);
                $scope.obj = {};
                $scope.obj.id = $scope.postlength+1;
                $scope.obj.title = $scope.title;
                $scope.obj.story = $scope.story;
                
                console.log($rootScope.formData);
                
//                $scope.postData = [];
//                $scope.postData.push($scope.obj);
//                console.log($scope.postData);
               // $("#posts").append($compile('<post-card postdata="data" class="col-lg-3"></post-card>')($scope.data=$scope.postData));


            }, function (response) {
                
                console.log(response.data, response.status);
            });

            

        } else {

            alert("Please fill all the fields");

        }
        
        $scope.title = "";
            $scope.story = "";
            $scope.count++;
    };



}).directive("postCard", function () {

    return {
        restrict: 'E',
        scope: {
            postlist: '=postdata',
        },
        templateUrl: 'http://localhost/demo/postcard.html',
        controller: ['$scope', '$rootScope', function ($scope, $rootScope) {
                $scope.deletePost = function (item) {
                    $scope.postlist.splice(item, 1);
                    //console.log($rootScope.list);
                };
            }]
    };

});