<!DOCTYPE>
<html lang="es" ng-app="MyApp">
    <head>
        <title>Prueba</title>
        <meta charset="utf-8" />
        <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
        
        
        <script type="text/javascript" src="<?php echo base_url();?>public/js/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>public/js/jquery-ui.min.js"></script>
        <link href="<?php echo base_url();?>public/css/jquery-ui.min.css" rel="stylesheet">
        <script type="text/javascript" src="<?php echo base_url().'public/js/prueba.js';?>"></script>
    </head>
    <!-- ng-controller="MyController as ul" -->
    <body ng-controller="MyController">
        
        <div>
            Busque mijo
        </div>
        <div>
            <input type="text" placeholder="Busque" ng-keydown="checkKeyDown($event)" ng-keyup="CheckKeyUp($event)" ng-model="searchText" ng-change="search()" />
        </div>
        
        <ul>
            <li ng-repeat="suggestion in suggestions track by $index" ng-class="{active : selectedIndex === $index}" ng-click="AssingValueAndHide($index)">
                {{suggestion}}
            </li>
        </ul>
    </body>
</html>
<!-- {{item.display}}-->