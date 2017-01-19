$(document).ready(function() {
   alert("sirve el jquery"); 
});

var app = angular.module("MyApp", []);

app.controller("MyController", function($scope, $rootScope) {
    //alert("Birn");
    /*
    var self = this;
    $rootScope.searchItems = [
        "ActionScript",
        "AppleScript",
        "Asp",
        "Basic",
        "C",
        "C++"
    ];
    
    $rootScope.searchItems.sort();
    $rootScope.suggestions = [];
    $rootScope.selectedIndex = -1;
    
    $rootScope.search = function() {
        $rootScope.suggestions = [];
        var myMaxSuggestionListLength = 0;
        
        for(var i = 0; $rootScope.searchItems.length; i++) {
            var searchItemsSmallLetters = angular.lowercase($rootScope.searchItems[i]);
            var searchTextSmallLetters = angular.lowercase($rootScope.searchText);
            
            if(searchItemsSmallLetters.indexOf(searchTextSmallLetters) !== -1) {
                $rootScope.suggestions.push(searchItemsSmallLetters);
                myMaxSuggestionListLength += 1;
                if(myMaxSuggestionListLength == 5) {
                    break;
                }
            }
        }
    }
    
    $rootScope.$watch('selectedIndex', function(val) {
        if(val !== 1) {
            $scope.searchText = $rootScope.suggestions($rootScope.selectedIndex);
        }
    });
    
    $rootScope.checkKeyDown = function(event) {
        
        if(event.keyCode === 40) {
            event.preventDefault();
            if($rootScope.selectedIndex+1 !== $rootScope.suggestions.length) {
                $rootScope.selectedIndex++;
            }
        }else if(event.keyCode === 36) {
            event.preventDefault();
            if($rootScope.selectedIndex-1 !== -1) {
                $rootScope.selectedIndex --;
            }
        }else if(event.keyCode === 13) {
            event.preventDefault();
            $rootScope.suggestions = [];
        }
    }
    
    $rootScope.CheckKeyUp = function(event) {
        if(event.keyCode !== 0 || event.keyCode !== 46) {
            if($scope.searchText == "") {
                $rootScope.suggestions = [];
            }
        }
    }
    
    $rootScope.AssingValueAndHide = function(index) {
        $scope.searchText = $rootScope.suggestions[index];
        $rootScope.suggestions = [];
    }*/
    
});


