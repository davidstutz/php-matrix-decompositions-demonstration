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
    $app->render('Code.php', array('app' => $app));
})->name('code');

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
        'matrix' => $matrix,
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
 * If the matrix is not symmetric and positive definite an error will be thrown.
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
        'matrix' => $matrix,
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
        'matrix' => $matrix,
        'r' => $decomposition->getR(),
        'q' => $decomposition->getQ(),
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
    foreach (explode("\n", trim($input)) as $line) {
        $j = 0;
        $array[$i] = array();
        foreach (explode(" ", $line) as $entry) {
            $array[$i][$j] = (double)$entry;
            $j++;
        }
        $i++;
    }

    // Create the matrix from the above generated array.
    $matrix = new \Libraries\Matrix(sizeof($array), sizeof($array[0]));
    $matrix->fromArray($array);

    $decomposition = new \Libraries\Decompositions\QRHouseholderWithTrace($matrix);
    
    $app->render('MatrixDecompositions/Householder.php', array(
        'app' => $app,
        'matrix' => $matrix,
        'r' => $decomposition->getR(),
        'q' => $decomposition->getQ(),
        'trace' => $decomposition->getTrace(),
    ));
})->name('matrix-decompositions/householder/demo');

/**
 * Overview over the applications ofr matrix decompositions.
 */
$app->get('/applications', function() use ($app) {
    $app->render('Applications/Overview.php', array('app' => $app));
})->name('applications');

/**
 * Application: System of Linear Equations.
 */
$app->get('/applications/system-of-linear-equations', function() use ($app) {
    $app->render('Applications/SystemOfLinearEquations.php', array('app' => $app));
})->name('applications/system-of-linear-equations');

/**
 * Application Demo: System of Linear Equations.
 */
$app->post('/applications/system-of-linear-equations/demo', function() use ($app) {
    $matrixInput = $app->request()->post('matrix');
    $vectorInput = $app->request()->post('vector');

    $matrixArray = array();
    $i = 0;
    foreach (explode("\n", trim($matrixInput)) as $line) {
        $j = 0;
        $matrixArray[$i] = array();
        foreach (explode(" ", trim($line)) as $entry) {
            $matrixArray[$i][$j] = (double) $entry;
            $j++;
        }
        $i++;
    }
    
    $vectorArray = array();
    $i = 0;
    foreach (explode("\n", trim($vectorInput)) as $line) {
        $vectorArray[$i] = (double) trim($line);
        $i++;
    }
    
    // Create the matrix from the above generated array.
    $matrix = new \Libraries\Matrix(sizeof($matrixArray), sizeof($matrixArray[0]));
    $matrix->fromArray($matrixArray);
    
    // Get the vector from input.
    $vector = new \Libraries\Vector(sizeof($vectorArray));
    $vector->fromArray($vectorArray);
    
    $decomposition = new \Libraries\Decompositions\LU($matrix);
    
    $app->render('Applications/SystemOfLinearEquations.php', array(
        'app' => $app,
        'matrix' => $matrix,
        'vector' => $vector,
        'x' => $decomposition->solve($vector),
        'l' => $decomposition->getL(),
        'u' => $decomposition->getU(),
    ));
})->name('applications/system-of-linear-equations/demo');

/**
 * Application: Linear Least Squares.
 */
$app->get('/applications/linear-least-squares', function() use ($app) {
    $app->render('Applications/LinearLeastSquares.php', array('app' => $app));
})->name('applications/linear-least-squares');

/**
 * Application Demo: Linear Least Squares.
 */
$app->post('/applications/linear-least-squares/demo', function() use ($app) {
    $matrixInput = $app->request()->post('matrix');
    $vectorInput = $app->request()->post('vector');

    $matrixArray = array();
    $i = 0;
    foreach (explode("\n", trim($matrixInput)) as $line) {
        $j = 0;
        $matrixArray[$i] = array();
        foreach (explode(" ", trim($line)) as $entry) {
            $matrixArray[$i][$j] = (double) $entry;
            $j++;
        }
        $i++;
    }
    
    $vectorArray = array();
    $i = 0;
    foreach (explode("\n", trim($vectorInput)) as $line) {
        $vectorArray[$i] = (double) trim($line);
        $i++;
    }
    
    // Create the matrix from the above generated array.
    $matrix = new \Libraries\Matrix(sizeof($matrixArray), sizeof($matrixArray[0]));
    $matrix->fromArray($matrixArray);
    
    // Get the vector from input.
    $vector = new \Libraries\Vector(sizeof($vectorArray));
    $vector->fromArray($vectorArray);
    
    $decomposition = new \Libraries\Decompositions\QRHouseholder($matrix);
    
    $r = $decomposition->getR();
    $r->resize($matrix->columns(), $r->columns());
    
    $q = $decomposition->getQ();
    
    $b = \Libraries\Matrix::operate($q->copy()->transpose(), $vector);
    
    $error = 0.;
    if ($matrix->rows() - $matrix->columns() > 0) {
        $b2 = new \Libraries\Vector($matrix->rows() - $matrix->columns());
        for ($i = 0; $i < $b2->size(); $i++) {
            $b2->set($i, $b->get($i + $matrix->columns()));
        }
        
        $error = $b2->l2();
    }
    
    $b1 = $b->copy();
    $b1->resize($matrix->columns());
    
    $x = $b1->copy();
    
    // Backsubstitution to solve R x = b_1.
    for ($i = $r->rows() - 1; $i >= 0; $i--) {
        for ($j = $r->columns() - 1; $j > $i; $j--) {
            $x->set($i, $x->get($i) - $x->get($j) * $r->get($i, $j));
        }
        $x->set($i, $x->get($i) / $r->get($i, $i));
    }
    
    $app->render('Applications/LinearLeastSquares.php', array(
        'app' => $app,
        'matrix' => $matrix,
        'vector' => $vector,
        'x' => $x,
        'q' => $decomposition->getQ(),
        'r' => $r,
        'b' => $b,
        'b1' => $b1,
        'error' => $error,
    ));
})->name('applications/linear-least-squares/demo');

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
