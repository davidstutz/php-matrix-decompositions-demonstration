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
$app = new \Slim\Slim( array(
    'templates.path' => './Views',
    'view' => new \Slim\View(),
    'base' => 'matrix-decompositions',
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

$app->get('/', function() use ($app) {
    $app->redirect('/matrix-decompositions' . $app->router()->urlFor('matrix-decompositions'));
});

/**
 * Code overview.
 */
$app->get('/code', function() use ($app) {
    $app->render('Code/Overview.php', array('app' => $app));
})->name('code');

/**
 * Matrix class code.
 */
$app->get('/code/matrix', function() use ($app) {
    $app->render('Code/Matrix.php', array('app' => $app));
})->name('code/matrix');

/**
 * Vector class code.
 */
$app->get('/code/vector', function() use ($app) {
    $app->render('Code/Vector.php', array('app' => $app));
})->name('code/vector');

/**
 * Test code.
 */
$app->get('/code/tests', function() use ($app) {
    $app->render('Code/Tests.php', array('app' => $app));
})->name('code/tests');

/**
 * Problem overview.
 * Quick introduction into the topic.
 */
$app->get('/matrix-decompositions', function() use ($app) {
    $app->render('MatrixDecompositions/Overview.php', array('app' => $app));
})->name('matrix-decompositions');

/**
 * Overview of the LU decomposition: Theoretical basics and algorithm.
 * Demo will call lu-decomposition.
 */
$app->get('/matrix-decompositions/lu', function() use ($app) {
    $app->render('MatrixDecompositions/LU.php', array('app' => $app));
})->name('matrix-decompositions/lu');

/**
 * Demonstrate the lu decomposition on the given matrix.
 */
$app->post('/matrix-decompositions/lu/demo', function() use ($app) {

    $input = $app->request()->post('matrix');
    
    $array = array();
    $i = 0;
    foreach (explode("\n", trim($input)) as $line) {
        $j = 0;
        $array[$i] = array();
        foreach (explode(" ", trim($line)) as $entry) {
            $array[$i][$j] = (double)$entry;
            $j++;
        }
        $i++;
    }
    
    // Create the matrix from the above generated array.
    $matrix = new \Libraries\Matrix(sizeof($array), sizeof($array[0]));
    $matrix->fromArray($array);

    $decomposition = new \Libraries\Decompositions\LUWithTrace($matrix);

    $app->render('MatrixDecompositions/LU.php', array(
        'app' => $app,
        'original' => $matrix,
        'l' => $decomposition->getL(),
        'u' => $decomposition->getU(),
        'trace' => $decomposition->getTrace(),
        'permutation' => $decomposition->getPermutation(),
        'determinant' => $decomposition->getDeterminant()
    ));
})->name('matrix-decompositions/lu/demo');

/**
 * Overview of the cholesky decomposition including definitions.
 */
$app->get('/matrix-decompositions/cholesky', function() use ($app) {
    $app->render('MatrixDecompositions/Cholesky.php', array('app' => $app));
})->name('matrix-decompositions/cholesky');

/**
 * Demonstrate the cholesky deocmposition on the given matrix.
 * If the matrix is not symmetric, positive definit an error will be thrown.
 */
$app->post('/matrix-decompositions/cholesky/demo', function() use ($app) {
    $input = $app->request()->post('matrix');

    $array = array();
    $i = 0;
    foreach (explode("\n", trim($input)) as $line) {
        $j = 0;
        $array[$i] = array();
        foreach (explode(" ", trim($line)) as $entry) {
            $array[$i][$j] = (double)$entry;
            $j++;
        }
        $i++;
    }

    // Create the matrix from the above generated array.
    $matrix = new \Libraries\Matrix(sizeof($array), sizeof($array[0]));
    $matrix->fromArray($array);
    
    $decomposition = new \Libraries\Decompositions\Cholesky($matrix);
    
    $app->render('MatrixDecompositions/Cholesky.php', array(
        'app' => $app,
        'original' => $matrix,
        'l' => $decomposition->getL(),
        'd' => $decomposition->getD(),
    ));
})->name('matrix-decompositions/cholesky/demo');

/**
 * QR decomposition overview: theoretical background and introduction ot givens and householders.
 */
$app->get('/matrix-decompositions/qr', function() use ($app) {
    $app->render('MatrixDecompositions/QR.php', array('app' => $app));
})->name('matrix-decompositions/qr');

/**
 * Overview of givens rotations: theoretical background and algorithm.
 */
$app->get('/matrix-decompositions/givens', function() use ($app) {
    $app->render('MatrixDecompositions/Givens.php', array('app' => $app));
})->name('matrix-decompositions/givens');

/**
 * Demonstrate the givens rotation on the given matrix.
 */
$app->post('/matrix-decompositions/givens/demo', function() use ($app) {
    $input = $app->request()->post('matrix');

    $array = array();
    $i = 0;
    foreach (explode("\n", trim($input)) as $line) {
        $j = 0;
        $array[$i] = array();
        foreach (explode(" ", trim($line)) as $entry) {
            $array[$i][$j] = (double)$entry;
            $j++;
        }
        $i++;
    }

    // Create the matrix from the above generated array.
    $matrix = new \Libraries\Matrix(sizeof($array), sizeof($array[0]));
    $matrix->fromArray($array);

    $decomposition = new \Libraries\Decompositions\QRGivensWithTrace($matrix);

    $q = new \Libraries\Matrix(max($matrix->rows(), $matrix->columns()), max($matrix->rows(), $matrix->columns()));
    $q->setAll(0);
    
    for ($i = 0; $i < $q->rows(); $i++) {
        $q->set($i, $i, 1);
    }

    $app->render('MatrixDecompositions/Givens.php', array(
        'app' => $app,
        'original' => $matrix,
        'r' => $decomposition->getR(),
        'q' => $q,
        'trace' => $decomposition->getTrace(),
    ));
})->name('matrix-decompositions/givens/demo');

/**
 * Overview of householder transformations.
 */
$app->get('/matrix-decompositions/householder', function() use ($app) {
    $app->render('MatrixDecompositions/Householder.php', array('app' => $app));
})->name('matrix-decompositions/householder');

/**
 * Demonstrate the householder transformations on the given matrix.
 */
$app->post('/matrix-decompositions/householder/demo', function() use ($app) {
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
    $tau = new \Libraries\Vector($matrix->columns());

    \Libraries\Matrix::qrDecompositionHouseholder($matrix, $tau);

    $r = $matrix->copy();

    // Extract R.
    for ($i = 0; $i < $matrix->rows(); $i++) {
        for ($j = 0; $j < $matrix->columns(); $j++) {
            if ($j < $i) {
                $r->set($i, $j, 0.);
            }
        }
    }
    
    $app->render('MatrixDecompositions/Householder.php', array('app' => $app, 'original' => $original, 'matrix' => $matrix, 'r' => $r));
})->name('matrix-decompositions/householder/demo');

/**
 * Overview over the applications ofr matrix decompositions.
 */
$app->get('/applications', function() use ($app) {
    $app->render('Applications/Overview.php', array('app' => $app));
})->name('applications');

/**
 * Credits. About me, used literatur and used software.
 */
$app->get('/credits', function() use ($app) {
    $app->render('Credits.php', array('app' => $app));
})->name('credits');

/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();
