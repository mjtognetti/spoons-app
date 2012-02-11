<?php

require_once '../config/config.php';
require_once '../app/lib/Slim/Slim.php';
require_once '../app/lib/Slim/MustacheView.php';

MustacheView::$mustacheDirectory = '../app/lib/';

$app = new Slim(array(
   'view' => 'MustacheView',
   'templates.path' => 'views/'
));

//===================
// Helper Functions
//===================

$protect = function() {
   global $app;
   if (!Guard::hasLoggedInUser()) {
      $app->redirect('login');
   }
};

$app->get('/', function()
{
   global $app;
   $app->render('main.mustache');
});

require_once '../app/api/tweets.php';
require_once '../app/api/timeseries.php';
require_once '../app/api/events.php';

require_once '../app/crazyQuery.php';

$app->run();

?> 
