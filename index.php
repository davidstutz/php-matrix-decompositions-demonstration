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

if (!function_exists('__')) {
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

/**
 * Problem overview.
 * Quick introduction into the topic.
 */
$app->get('/overview', function () use ($app) {
   	$app->render('Overview.php', array('app' => $app));
})->name('overview');

/**
 * Overview of the LU decomposition: Theoretical basics and algorithm.
 * Demo will call lu-decomposition.
 */
$app->get('/lu', function () use ($app) {
   	$app->render('LU.php', array('app' => $app));
})->name('lu');

/**
 * Demonstrate the lu decomposition on the given matrix.
 */
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
	
	// Create the matrix from the above generated array.
	$matrix = new \Libraries\Matrix($i, $j);
	$matrix->fromArray($array);
	$original = $matrix->copy();
  
	$trace = array();
	$permutation = \Libraries\Matrix::luDecompositionWithTrace($matrix, $trace);
	$determinant = \Libraries\Matrix::luDeterminant($matrix, $permutation);
	
	$l = $matrix->copy();
	$u = $matrix->copy();
  
	// Extract L and U.
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
	
	$app->render('LU.php', array('app' => $app, 'original' => $original, 'l' => $l, 'u' => $u, 'trace' => $trace, 'permutation' => $permutation, 'determinant' => $determinant));
})->name('lu-decomposition');

/**
 * Overview of the cholesky decomposition including definitions.
 */
$app->get('/cholesky', function () use ($app) {
    $app->render('Cholesky.php', array('app' => $app));
})->name('cholesky');

/**
 * Demonstrate the cholesky deocmposition on the given matrix.
 * If the matrix is not symmetric, positive definit an error will be thrown.
 */
$app->post('/cholesky-decomposition', function () use ($app) {
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
  
  // Create the matrix from the above generated array.
  $matrix = new \Libraries\Matrix($i, $j);
  $matrix->fromArray($array);
  $original = $matrix->copy();
  
  try {
    \Libraries\Matrix::choleskyDecomposition($matrix);
  }
  catch (\Libraries\Exception\MatrixException $e) {
    
  }
  
  $l = $matrix->copy();
  $d = $matrix->copy();
  
  // Extract L and U.
  for ($i = 0; $i < $matrix->rows(); $i++) {
    for ($j = 0; $j < $matrix->columns(); $j++) {
      if ($i > $j) {
        $d->set($i, $j, 0.);
      }
      if ($i < $j) {
        $d->set($i, $j, 0.);
        $l->set($i, $j, 0.);
      }
      if ($i == $j) {
        $l->set($i, $j, 1.);
      }
    }
  }
  
  $app->render('Cholesky.php', array('app' => $app, 'original' => $original, 'l' => $l, 'd' => $d));
})->name('cholesky-decomposition');

/**
 * QR decomposition overview: theoretical background and introduction ot givens and householders.
 */
$app->get('/qr', function () use ($app) {
  	$app->redirect('/matrix-decompositions' . $app->router()->urlFor('givens'));
})->name('qr');

/**
 * Overview of givens rotations: theoretical background and algorithm.
 */
$app->get('/givens', function() use ($app) {
	$app->render('Givens.php', array('app' => $app));
})->name('givens');

/**
 * Demonstrate the givens rotation on the given matrix.
 */
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
	
  // Create the matrix from the above generated array.
	$matrix = new \Libraries\Matrix($i, $j);
	$matrix->fromArray($array);
	$original = $matrix->copy();
  
	$trace = array();
	\Libraries\Matrix::qrDecompositionGivensWithTrace($matrix, $trace);
	
	$r = $matrix->copy();
  
	// Extract R.
	for ($i = 0; $i < $matrix->rows(); $i++) {
	  for ($j = 0; $j < $matrix->columns(); $j++) {
	    if ($j < $i) {
	      $r->set($i, $j, 0.);
	    }
	  }
	}
  
  // Q will be given as identity matrix.
  // Q will be computed within the view, because the single givens rotations are shwon each step.
  $q = new \Libraries\Matrix(max($matrix->columns(), $matrix->rows()), max($matrix->columns(), $matrix->rows()));
  $q->setAll(0.);
  
  for ($i = 0; $i < $q->rows(); $i++) {
    $q->set($i, $i, 1.);
  }
  
	$app->render('Givens.php', array('app' => $app, 'original' => $original, 'r' => $r, 'q' => $q, 'trace' => $trace));
})->name('givens-decomposition');

/**
 * Overview of householder transformations.
 */
$app->get('/householder', function() use ($app) {
	$app->redirect('/matrix-decompositions' . $app->router()->urlFor('givens'));
	$app->render('Householder.php', array('app' => $app));
})->name('householder');

/**
 * Credits. About me, used literatur and used software.
 */
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
