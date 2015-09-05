function validateEmail(email) {
  var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
  return re.test(email);
}

var app = angular.module('poemApp', []);

app.directive('ngEnter', function() {
  return function(scope, element, attrs) {
    element.bind("keydown keypress", function(event) {
      if (event.which === 13) {
        scope.$apply(function() {
          scope.$eval(attrs.ngEnter, {'event': event});
        });

        event.preventDefault();
      }
    });
  };
});

app.controller('MainController', ['$scope', '$http',
  function($scope, $http) {
    $scope.email = '';
    $scope.text = '';
	$scope.disableSubmit = false;
	
	function addText(text) {
	  $scope.text = text + "\r\n" + $scope.text;
	}
	
	$scope.submit = function submit() {
	  if (!validateEmail($scope.email)) {
	    addText($scope.email + " is not a valid email. Try again...");
	  }
	  else {
	    addText("Processing...");
	  	$scope.disableSubmit = true;

      addText("Getting number of pdfs...");

      $http.get('/countitems', function(data) {
        console.log(data);
      });

      for (var i = 0; i < 10; i++) {
      }
	  }
	}
  }
]); 