<?php
/**
 * Step 1: Require the Slim Framework
 *
 * If you are not using Composer, you need to require the
 * Slim Framework and register its PSR-0 autoloader.
 *
 * If you are using Composer, you can skip this step.
 */
require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */
$app = new \Slim\Slim(array(
	'templates.path' => './Views',
	'view' => new \Slim\View(),
));

\Slim\I18n::setPath('I18n');

if ( !function_exists('__') ) {
	/**
	 * Translation function
	 * 
	 * Will translate given string into current set language.
	 */
	 function __($string, array $args = NULL) {
	 	$translation = \Slim\I18n::getTranslation($string);
		
		return is_null($args) ? $translation : strtr($translation, $args);
	 }
}

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, and `Slim::delete`
 * is an anonymous function.
 */

$app->get('/', function () use ($app) {
   $app->redirect('/matrix-decompositions' . $app->router()->urlFor('overview'));
});

$app->get('/overview', function () use ($app) {
   	$app->render('Overview.php', array('app' => $app));
})->name('overview');

$app->get('/lu', function () use ($app) {
   	$app->render('LU.php', array('app' => $app));
})->name('lu');

$app->post('/lu-decomposition', function() use ($app) {
	
	$input = $app->request()->post('matrix');
	
	$array = array();
	
	$i = 0;
	foreach (explode("\n", $input) as $line) {
		$j = 0;
		$array[$i] = array();
		foreach (explode(" ", $line) as $entry) {
			$array[$i][$j] = (double)$entry;
			$j++;
		}
		$i++;
	}
	
	$matrix = new \Libraries\Matrix($i, $j);
	$matrix->fromArray($array);
	
	$trace = array();
	$permutation = \Libraries\Matrix::luDecompositionWithTrace($matrix, $trace);
	
	$determinant = \Libraries\Matrix::luDeterminant($matrix, $permutation);
	
	$l = $matrix->copy();
	$u = $matrix->copy();
	for ($i = 0; $i < $matrix->rows(); $i++) {
		for ($j = 0; $j < $matrix->columns(); $j++) {
			if ($i > $j) {
				$u->set($i, $j, 0.);
			}
			if ($i < $j) {
				$l->set($i, $j, 0.);
			}
			if ($i == $j) {
				$l->set($i, $j, 1.);
			}
		}
	}
	
	$app->render('LU.php', array('app' => $app, 'matrix' => $matrix, 'l' => $l, 'u' => $u, 'trace' => $trace, 'permutation' => $permutation, 'determinant' => $determinant));
})->name('lu-decomposition');

$app->get('/qr', function () use ($app) {
  	$app->redirect('/matrix-decompositions' . $app->router()->urlFor('givens'));
})->name('qr');

$app->get('/givens', function() use ($app) {
	$app->render('Givens.php', array('app' => $app));
})->name('givens');

$app->post('/givens-decomposition', function() use ($app) {
	$input = $app->request()->post('matrix');
	
	$array = array();
	
	$i = 0;
	foreach (explode("\n", $input) as $line) {
		$j = 0;
		$array[$i] = array();
		foreach (explode(" ", $line) as $entry) {
			$array[$i][$j] = (double)$entry;
			$j++;
		}
		$i++;
	}
	
	$matrix = new \Libraries\Matrix($i, $j);
	$matrix->fromArray($array);
	
	$trace = array();
	$permutation = \Libraries\Matrix::qrDecompositionGivensWithTrace($matrix, $trace);
	
	$q = $matrix->copy();
	$r = $matrix->copy();
	for ($i = 0; $i < $matrix->rows(); $i++) {
		for ($j = 0; $j < $matrix->columns(); $j++) {
			if ($i > $j) {
				$u->set($i, $j, 0.);
			}
		}
	}
	
	$app->render('LU.php', array('app' => $app, 'matrix' => $matrix, 'q' => $q, 'r' => $r, 'trace' => $trace));
})->name('givens-decomposition');

$app->get('/householder', function() use ($app) {
	$app->redirect('/matrix-decompositions' . $app->router()->urlFor('givens'));
	$app->render('Householder.php', array('app' => $app));
})->name('householder');

$app->get('/credits', function () use ($app) {
  	$app->render('Credits.php', array('app' => $app));
})->name('credits');

/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();
