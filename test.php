<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="http://localhost/demo/static/css/style.css"/>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    </head>
    <body ng-app="myApp">
        <section  ng-controller="Note" class="mySection">
            <div class="container"  ng-init="list = [];">
                <div class="row">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6 col-md-6 form-container">
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" ng-model="title" class="form-control" id="title">
                        </div>
                        <div class="form-group">
                            <label for="story">Story:</label>
                            <textarea ng-model="story" class="form-control" id="story"></textarea>
                        </div>
                        <button ng-click="addPost()" class="btn btn-success submit">Post</button>
                    </div>
                    <div class="col-lg-3"></div>
                </div>
                <div class="row" id="posts">
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Post</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="edit-title">Title:</label>
                                <input type="text" ng-model="editTitle" class="form-control" id="edit-title">
                            </div>
                            <div class="form-group">
                                <label for="edit-story">Story:</label>
                                <textarea ng-model="editStory" class="form-control" id="edit-story"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" ng-click="savePost()">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>

        </section>






    </body>
    <script>

        angular.module('myApp', [])
                .controller('Note', ['$scope', '$rootScope', '$http', '$compile', '$timeout', function ($scope, $rootScope, $http, $compile, $timeout) {
                        $scope.count = 0;

                        $scope.pullPosts = function () {

                            $http({
                                method: 'POST',
                                url: 'http://localhost/demo/pullpost.php'

                            }).then(function (response) {// on success

                                if (response.data.length == 0) {
                                    $rootScope.maxId = 0;
                                } else {
                                    $rootScope.maxId = response.data[0].id;
                                }


                                $scope.pullPostData = response.data;

                                //console.log($scope.pullPostData);

                                $("#posts").html($compile('<post-card data="pullPostData"></post-card>')($scope));


                            }, function (response) {

                                console.log(response.data, response.status);

                            });

                        };
                        $scope.pullPosts();

                        $scope.addPost = function () {

                            if ($scope.title != "" && $scope.story != "") {

                                $rootScope.maxId++;
                                $rootScope.formData = {
                                    "title": $scope.title,
                                    "story": $scope.story,
                                    "id": $rootScope.maxId
                                }

                                $http({
                                    method: 'POST',
                                    url: 'http://localhost/demo/addpost.php',
                                    headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'},
                                    data: $.param($rootScope.formData)

                                }).then(function (response) {// on success

                                    alert(response.data);

                                    $scope.pullPostData.push($rootScope.formData);

                                    // $("#posts").append($compile('<post-card data="addPostDataArray"></post-card>')($scope));
                                    console.log("added");
                                    

                                    //$scope.addPostData=null;


                                }, function (response) {

                                    console.log(response.data, response.status);

                                });



                            } else {

                                alert("Please fill all the fields");

                            }

                            $scope.title = "";
                            $scope.story = "";

                        };

                        $scope.editPost = function (item) {

                            var title = $("#title" + item).html();
                            var story = $("#story" + item).html();

                            $scope.editPostId = item;
                            $scope.editTitle = title;
                            $scope.editStory = story;

                        };

                        $scope.savePost = function () {
                            
                            if ($scope.editTitle != "" && $scope.editStory != "") {
                                $scope.editFormData = {
                                    "id": $scope.editPostId,
                                    "title": $scope.editTitle,
                                    "story": $scope.editStory
                                };

                                $http({
                                    method: 'POST',
                                    url: 'http://localhost/demo/editpost.php',
                                    headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'},
                                    data: $.param($scope.editFormData)

                                }).then(function (response) {// on success

                                    alert(response.data);
                                    
//                                    $("#title"+item).html($scope.editTitle);
//                                    console.log("---"+$("#title" + item).html());
//                                    $("#story"+item).html($scope.editStory);
                                $scope.pullPostData.forEach(function(element) {
                                    
                                    if(element.id == $scope.editPostId){
                                        console.log("elementtitle");

                                        element.title = $scope.editTitle,
                                        element.story = $scope.editStory

                                    }
                                });

                                }, function (response) {

                                    console.log(response.data, response.status);

                                });
                            } else {
                                alert("Please fill all the fields");
                            }

                        };
                        
                        $scope.deletePost = function(item) {
                            
                            $scope.formData = {
                                "id": item
                            };

                            $http({
                                method: 'POST',
                                url: 'http://localhost/demo/deletepost.php',
                                headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'},
                                data: $.param($scope.formData)

                            }).then(function (response) {// on success

                                alert(response.data);
                                $("#" + item).fadeOut();

                            }, function (response) {

                                console.log(response.data, response.status);

                            });
                        };



                    }]).directive("postCard", function () {

            return {
                restrict: 'E',
                replace: true,
                scope: {
                    data: '=',
                },
                templateUrl: 'http://localhost/demo/postcard.html',
                controller: ['$scope', '$rootScope', '$http', function ($scope, $rootScope, $http) {
                        console.log("directive");
                        console.log($scope.data);

                    }]
            };

        });
    </script>
</html>
