function validateEmail(email) {
  var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
  return re.test(email);
}

var app = angular.module('poemApp', []);

app.directive('ngEnter', function () {
  return function (scope, element, attrs) {
    element.bind("keydown keypress", function (event) {
      if (event.which === 13) {
        scope.$apply(function () {
          scope.$eval(attrs.ngEnter, {'event': event});
        });

        event.preventDefault();
      }
    });
  };
});

app.controller('MainController', ['$scope', '$http', '$timeout',
  function ($scope, $http, $timeout) {
    $scope.email = '';
    $scope.text = '';
    $scope.disableSubmit = false;
    var numberOfItems = 0;

    var items = [];

    function addText(text) {
      $scope.text = $scope.text + "\r\n" + text;

      window.scrollTo(0,document.body.scrollHeight);
    }

    function addLine(text) {
      $scope.text = $scope.text + text;
    }

    function getItems(index, callback) {
      if (index >= 10) {
        callback();
      }
      else {
        index++;
        var rand = Math.floor(Math.random() * numberOfItems);

        addText("Generating random number in range 0-" + (numberOfItems - 1) + " (numberOfItems - 1)... " + rand);

        addText("Getting name for pdf with index " + rand + "... ");

        $http.get('/getnameforitem.php?index=' + rand)
          .success(function (data) {
            addLine(data);

            var title = data;

            $http.get('/countpages.php?name=' + title).success(function (numberOfPages) {
              addText('Getting number of pages... ' + numberOfPages);

              addText('Selecting random page in range 1-' + numberOfPages + "... ");

              var randPage = Math.floor(Math.random() * numberOfPages + 1);

              addLine(randPage);

              addText("");

              items.push(
                {
                  page: randPage,
                  title: title,
                  index: rand
                }
              );

              $timeout(function () {
                getItems(index, callback);
              }, 500);
            });
          });
      }
    }

    $scope.submit = function submit() {
      if (!validateEmail($scope.email)) {
        addText($scope.email + " is not a valid email. Try again...");
      }
      else {
        addText("Processing...");
        $scope.disableSubmit = true;

        addText("Getting number of pdfs... ");

        $http.get('/countitems.php')
          .success(function (data) {
            addLine(data.numberOfItems);

            numberOfItems = data.numberOfItems;

            getItems(0, function () {
              $http.post('/process.php', {
                "items": items,
                "email": $scope.email
              }).then(
                function success(data) {
                  addText("Success!");
                  addText("Restarting in 5 seconds...");
                  $timeout(function() {
                    window.location.reload();
                  }, 5000);
                },
                function error(reason) {
                  console.log(reason);
                }
              );
            });
          });
      }
    }
  }
]); 