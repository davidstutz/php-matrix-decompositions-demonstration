<!DOCTYPE html>
<html>
	<head>
		<title><?php echo __('PHP Matrix Decompositions - QR Decomposition - Givens Rotations'); ?></title>
        <meta NAME="description" content="Matrix decompositions (matrix factorizations) implemented and demonstrated in PHP;
            including LU, QR and Cholesky decompositions.">
        <meta NAME="keyword" content="matrix,decomposition,php,php matrix decomposition,matrix decomposition,
            factorization,matrix factorization,php matrix factorization,lu decomposition,lu factorization,pivoting,qr decomposition,
            qr factorization,givens,givens rotation,householder,householder transformation,cholesky,cholesky decomposition,
            cholesky factorization,gaussian elimination,linear equations,linear least squares">

		<script type="text/javascript" src="/<?php echo $app->config('base'); ?>/Assets/Js/jquery.min.js"></script>
        <script type="text/javascript" src="/<?php echo $app->config('base'); ?>/Assets/Js/bootstrap.min.js"></script>
        <script type="text/javascript" src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
        <script type="text/javascript" src="/<?php echo $app->config('base'); ?>/Assets/Js/prettify.js"></script>
        <script type="text/x-mathjax-config">
            MathJax.Hub.Config({
                tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
                });
        </script>
        <script type="text/javascript">
    		$(document).ready(function() {
    			window.prettyPrint() && prettyPrint();
    		});
        </script>
        <link rel="stylesheet" type="text/css" href="/<?php echo $app->config('base'); ?>/Assets/Css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="/<?php echo $app->config('base'); ?>/Assets/Css/prettify.css">
	</head>
	<body>
        <a href="https://github.com/davidstutz/matrix-decompositions"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_right_red_aa0000.png" alt="Fork me on GitHub"></a>
		<div class="container">
			<div class="page-header">
				<h1><?php echo __('Matrix Decompositions'); ?> <span class="muted">//</span> <?php echo __('QR'); ?> <span class="muted">//</span> <?php echo __('Givens Rotations'); ?></h1>
			</div>
			
            <div class="row">
                <div class="span3">
                    <ul class="nav nav-pills nav-stacked">
                        <li>
                            <a href="/<?php echo $app->config('base'); ?><?php echo $app->router()->urlFor('matrix-decompositions'); ?>"><?php echo __('Matrix Decompositions'); ?></a>
                            <ul class="nav nav-pills nav-stacked" style="margin-left: 20px;">
                                <li><a href="/<?php echo $app->config('base'); ?><?php echo $app->router()->urlFor('matrix-decompositions/lu'); ?>"><?php echo __('LU Decomposition'); ?></a></li>
                                <li><a href="/<?php echo $app->config('base'); ?><?php echo $app->router()->urlFor('matrix-decompositions/cholesky'); ?>"><?php echo __('Cholesky Decomposition'); ?></a></li>
                                <li class="active"><a href="#"><?php echo __('QR Decomposition'); ?></a></li>
                            </ul>
                        </li>
                        <li><a href="/<?php echo $app->config('base'); ?><?php echo $app->router()->urlFor('applications'); ?>"><?php echo __('Applications'); ?></a></li>
                        <li><a href="/<?php echo $app->config('base'); ?><?php echo $app->router()->urlFor('credits'); ?>"><?php echo __('Credits'); ?></a></li>
                    </ul>
                    </div>
                <div class="span9">
                    <p>
                        <b><?php echo __('Definition.'); ?></b> <?php echo __('A matrix $Q \in \mathbb{R}^{m \times m}$ is called orthogonal if the columns $q_i$, $1 \leq i \leq m$ of $Q$ form an orthonormal basis of $\mathbb{R}^m$.'); ?>
                    </p>
                    
                    <p>
                        <?php echo __('Let $Q \in \mathbb{R}^{m \times m}$ be an orthogonal matrix. Then'); ?>
                        <ul>
                            <li><?php echo __('$Q^TQ = I$, where $I \in \mathbb{R}^{m \times m}$ is the identity matrix.'); ?></li>
                            <li><?php echo __('$Q^T$ is orthogonal,'); ?></li>
                            <li><?php echo __('$Q\bar{Q}$ is orthogonal for $\bar{Q} \in \mathbb{R}^{m \times m}$ orthogonal.'); ?></li>
                        </ul>
                    </p>
                    
                    <p>
                        <?php echo __('The QR decomposition is a factorization $A = QR$ of a matrix $A \in \mathbb{R}^{m \times n}$ in an orthogonal Matrix $Q \in \mathbb{R}^{m \times m}$ and an upper triangular matrix $R \in \mathbb{R}^{m \times n}$.'); ?>
                    </p>

                    
                    <p>
                        <b><?php echo __('Applications.'); ?></b>
                        <ul>
                            <li><?php echo __('The problem $Ax = b$ is reduced to solving $Rx = Q^{-1}b = Q^Tb$.'); ?></li>
                            <li><?php echo __('The QR decomposition is widely used to solve the linear least squares problem as well as the nonlinear least squares problem.'); ?></li>
                        </ul>
                    </p>
                    
                    <p>
                        <?php echo __('We discuss two methods of computing a QR decompositions:'); ?>
                    </p>
                    
                    <ul class="nav nav-pills">
                        <li class="active"><a href="#"><?php echo __('Givens rotations'); ?></a></li>
                        <li><a href="/<?php echo $app->config('base'); ?><?php echo $app->router()->urlFor('matrix-decompositions/householder'); ?>"><?php echo __('Householder transformations'); ?></a></li>
                    </ul>
                    
                    <div class="tabbable">
                        <ul class="nav nav-tabs">
                            <li><a href="#code" data-toggle="tab"><?php echo __('Code'); ?></a></li>
                            <li><a href="#algorithm" data-toggle="tab"><?php echo __('Algorithm'); ?></a></li>
                            <li <?php if (!isset($matrix)): ?>class="active"<?php endif; ?>><a href="#demo" data-toggle="tab"><?php echo __('Demo'); ?></a></li>
                            <?php if (isset($matrix)): ?>
                                <li class="active"><a href="#result" data-toggle="tab"><?php echo __('Result'); ?></a></li>
                            <?php endif; ?>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane" id="code">
                                <pre class="prettyprint linenums">
/**
 * Calculate a QR decomposition by using givens rotations.
 *
 * @author  David Stutz
 * @license http://www.gnu.org/licenses/gpl-3.0
 */
class QRGivens {

    /**
     * @var matrix
     */
    protected $_matrix;
     
    /**
     * Constructor: Get the qr decomposition of the given matrix using givens rotations.
     * The single givens rotations are stored within the matrix.
     *
     * @param   matrix  matrix to get the qr decomposition of
     */
    public function __construct(&$matrix) {
        new Assertion($matrix instanceof Matrix, 'Given matrix not of class Matrix.');

        $this->_matrix = $matrix->copy();

        // Check in all columns except the n-th one for entries to eliminate.
        for ($j = 0; $j < $this->_matrix->columns() - 1; $j++) {
            for ($i = $j + 1; $i < $this->_matrix->rows(); $i++) {
                // If the entry is zero it can be skipped.
                if ($this->_matrix->get($i, $j) != 0) {
                    $r = sqrt(pow($this->_matrix->get($j, $j), 2) + pow($this->_matrix->get($i, $j), 2));

                    if ($this->_matrix->get($i, $j) < 0) {
                        $r = -$r;
                    }

                    $s = $this->_matrix->get($i, $j) / $r;
                    $c = $this->_matrix->get($j, $j) / $r;

                    // Apply the givens rotation:
                    for ($k = $j; $k < $this->_matrix->columns(); $k++) {
                        $jk = $this->_matrix->get($j, $k);
                        $ik = $this->_matrix->get($i, $k);
                        $this->_matrix->set($j, $k, $c * $jk + $s * $ik);
                        $this->_matrix->set($i, $k, -$s * $jk + $c * $ik);
                    }

                    // c and s can be stored in one matrix entry:
                    if ($c == 0) {
                        $this->_matrix->set($i, $j, 1);
                    }
                    else if (abs($s) < abs($c)) {
                        if ($c < 0) {
                            $this->_matrix->set($i, $j, -.5 * $s);
                        }
                        else {
                            $this->_matrix->set($i, $j, .5 * $s);
                        }
                    }
                    else {
                        $this->_matrix->set($i, $j, 2. / $c);
                    }
                }
            }
        }
    }

    /**
     * Assembles Q using the single givens rotations.
     * 
     * @return  matrix  Q
     */
    public function getQ() {
        // Q is an mxm matrix if m is the maximum of the number of rows and thenumber of columns.
        $m = max($this->_matrix->columns(), $this->_matrix->rows());
        $Q = new Matrix($m, $m);
        $Q->setAll(0.);
        
        // Begin with the identity matrix.
        for ($i = 0; $i < $Q->rows(); $i++) {
            $Q->set($i, $i, 1.);
        }
        
        for ($j = $this->_matrix->columns() - 1; $j >= 0 ; $j--) {
            for ($i = $this->_matrix->rows() - 1; $i > $j; $i--) {
                
                // Get c and s which are stored in the i-th row, j-th column.
                $aij = $this->_matrix->get($i, $j);
                
                $c = 0;
                $s = 0;
                if ($aij == 0) {
                    $c = 0.;
                    $s = 1.;
                }
                else if (abs($aij) < 1) {
                    $s = 2.*abs($aij);
                    $c = sqrt(1 - pow($s, 2));
                    if ($aij < 0) {
                        $c = -$c;
                    }
                }
                else {
                    $c = 2./$aij;
                    $s = sqrt(1 - pow($c, 2));
                }
                
                for ($k = 0; $k < $this->_matrix->columns(); $k++) {
                    $jk = $Q->get($j, $k);
                    $ik = $Q->get($i, $k);
                    
                    $Q->set($j, $k, $c*$jk - $s*$ik);
                    $Q->set($i, $k, $s*$jk + $c*$ik);
                }
            }
        }
        
        return $Q;
    }
    
    /**
     * Gets the upper triangular matrix R.
     */
    public function getR() {
        $R = $this->_matrix->copy();
        
        for ($i = 0; $i < $R->rows(); $i++) {
            for ($j = 0; $j < $i; $j++) {
                $R->set($i, $j, 0);
            }
        }
        
        // Resize R to a square matrix.
        $n = min($R->rows(), $R->columns());
        return $R->resize($n, $n);
    }
}

                                </pre>
                            </div>
                            <div class="tab-pane" id="algorithm">
                                <p>
                                    <?php echo __('The algorithm is based on the so called givens rotations which are orthogonal. Using a sequence of givens rotations the given matrix can be transformed to an upper triangular matrix.'); ?>
                                    <?php echo __('Using givens rotations we can eliminate a single entry of a vector (or column) $x \in \mathbb{R}^n$:'); ?>
                                </p>
                                
                                <p>
                                  $G = 
                                  \left[\begin{array}{c c c c c c c} 
                                    1 & & & & \ldots & & & & 0\\
                                     & \ddots & & & & & & & \\
                                     & & & c & \ldots & -s & & & \\
                                    \vdots & & & \vdots & & \vdots & & & \vdots \\
                                     & & & s & \ldots & c & & & \\
                                     & & & & & & & \ddots & \\
                                    0 & & & & \ldots & & & & 1 \\
                                  \end{array} \right]
                                  \left[\begin{array}{c} 
                                    x_1 \\
                                    \vdots \\
                                    x_i \\
                                    \vdots \\
                                    x_j \\
                                    \vdots \\
                                    x_n \\
                                  \end{array} \right]
                                   = 
                                  \left[\begin{array}{c} 
                                    x_1 \\
                                    \vdots \\
                                    r \\
                                    \vdots \\
                                    0\ \\
                                    \vdots \\
                                    x_n \\
                                  \end{array} \right]
                                  $
                                </p>
                                
                                <p>
                                    <?php echo __('where $r = \sqrt{x_i^2 + x_j^2}$ and $c$ and $s$ can be computed using: $c = \frac{x_i}{r}$, $s = \frac{x_j}{r}$.'); ?>
                                </p>
                                
                                <p>
                                    <?php echo __('$G$ is orthogonal because the columns form an orthonormal basis of $\mathbb{R}^n$. In addition note that $G$ is only affecting the $i$-th row and $j$-th row when applied on a matrix.'); ?>
                                    <?php echo __('Thus, the matrix $A$ can be reduced to an upper triangular matrix by eliminating all entries below the diagonal:'); ?>
                                </p>
                                
                                <p>
                                    $G_{m,n-1} \ldots G_{3,1} G_{2,1} G_{1,1} A = R$
                                </p>
                                
                                <p>
                                    <?php echo __('Where $G_{i,j}$ is the givens rotation eliminating the $i$-th entry in the $j$-th column of $A$. So the decomposition is given by:'); ?>
                                </p>
                                
                                <p>
                                    $A = G_{1,1}^T G_{2,1}^T G_{3,1}^T \ldots G_{m,n}^T R = QR$
                                </p>
                                
                                <p>
                                    <?php echo __('The algorithm computes $c$ and $s$ for each entry below the diagonal and eliminates the entry using the corresponding givens rotation:'); ?>
                                </p>
                                
                                <p>
                                    <b><?php echo __('Algorithm.'); ?></b>
                                    <ul style="list-style-type:none;">
                                        <li><?php echo __('For $i = 1, \ldots, n - 1$:'); ?>
                                            <ul style="list-style-type:none;">
                                                <li><?php echo __('For $i = j + 1, \ldots, m$:'); ?>
                                                    <ul style="list-style-type:none;">
                                                        <li><?php echo __('If $a_{i, j} \neq 0$:'); ?>
                                                            <ul style="list-style-type:none;">
                                                                <li><?php echo __('Set up $G_{i, j}$ by computing $r := \sqrt{a_{j, j}^2 + x_{i,j}^2}$, $c := \frac{a_{j, j}}{r}$, $s := \frac{x_{i, j}}{r}$'); ?></li>
                                                                <li><?php echo __('Apply $G_{i, j}$ on $A$.'); ?></li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </p>
                                
                                <p><?php echo __('In addition $G_{i, j}$ can be saved in $a_{i, j}$ the following way:'); ?></p>
                                
                                <p>
                                    <ul style="list-style-type:none;">
                                        <li><?php echo __('If $c = 0$:'); ?>
                                            <ul style="list-style-type:none;">
                                                <li><?php echo __('$a_{i, j} := 0$'); ?></li>
                                            </ul>
                                        </li>
                                        <li><?php echo __('If $|s| < |c|$:'); ?>
                                            <ul style="list-style-type:none;">
                                                <li><?php echo __('$a_{i, j} := \frac{1}{2}sign(c)s$'); ?></li>
                                            </ul>
                                        </li>
                                        <li><?php echo __('If $|c| \leq |s|$:'); ?>
                                            <ul style="list-style-type:none;">
                                                <li><?php echo __('$a_{i, j} := 2\frac{sign(s)}{c}$'); ?></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </p>
                            </div>
                            <div class="tab-pane <?php if (!isset($matrix)): ?>active<?php endif; ?>" id="demo">
                                <form class="form-horizontal" method="POST" action="/<?php echo $app->config('base') . $app->router()->urlFor('matrix-decompositions/givens/demo'); ?>">
                                    <div class="control-group">
                                        <label class="control-label"><?php echo __('Matrix'); ?></label>
                                        <div class="controls">
                                            <textarea name="matrix" rows="10" class="span6">
4 2 2
2 4 2
2 2 4
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <button class="btn btn-primary" type="submit"><?php echo __('Calculate QR Decomposition'); ?></button>
                                    </div>
                                </form>
                            </div>
                            <?php if (isset($matrix)): ?>
                                <div class="tab-pane active" id="result">
                                    <p><b><?php echo __('Given matrix.'); ?></b></p>
                                    
                                    <p>
                                        $A = $ <?php echo $app->render('Utilities/Matrix.php', array('matrix' => $matrix)); ?> $\in \mathbb{R}^{<?php echo $matrix->rows(); ?> \times <?php echo $matrix->columns(); ?>}$
                                    </p>
                                    
                                    <p><b><?php echo __('Algorithm.'); ?></b></p>
                                    
                                    <?php $givens = new Matrix(max($matrix->columns(), $matrix->rows()), max($matrix->columns(), $matrix->rows())); ?>
                                    <?php foreach ($trace as $j => $column): ?>
                                        <?php foreach ($column as $i => $array): ?>
                                            <?php
                                            // Dirty way for tracing the givens rotations.
                                            $givens->setAll(0);
                                            for ($k = 0; $k < $givens->rows(); $k++) {
                                                $givens->set($k, $k, 1.);
                                            }
                                            
                                            $givens->set($j, $j, $array['c']);
                                            $givens->set($j, $i, $array['s']);
                                            $givens->set($i, $i, $array['c']);
                                            $givens->set($i, $j, -$array['s']);
                                            ?>
                                            <p>
                                                $\overset{G_{<?php echo $i + 1; ?>,<?php echo $j + 1; ?>}}{\leadsto}$ <?php echo $app->render('Utilities/Matrix.php', array('matrix' => $array['matrix'])); ?> <br>
                                            </p>
                                            <p>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <?php echo __('with'); ?> $G_{<?php echo $i + 1; ?>,<?php echo $j + 1; ?>} = $ <?php echo $app->render('Utilities/Matrix.php', array('matrix' => $givens)); ?>
                                            </p>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                    
                                    <p><b><?php echo __('Decomposition.'); ?></b></p>
                                    
                                    <p>
                                        $R = $ <?php echo $app->render('Utilities/Matrix.php', array('matrix' => $r)); ?>
                                    </p>
                                    
                                    <p>
                                        $Q = $ <?php echo $app->render('Utilities/Matrix.php', array('matrix' => $q)); ?>
                                    </p>
                                    
                                    <p><b><?php echo __('Check.'); ?></b></p>
                                        
                                    <p>
                                        $QR = $ <?php echo $app->render('Utilities/Matrix.php', array('matrix' => Matrix::multiply($q, $r))); ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <p>
                &copy; 2013 David Stutz - <a href="/<?php echo $app->config('base'); ?><?php echo $app->router()->urlFor('credits'); ?>"><?php echo __('Credits'); ?></a> - <a href="https://davidstutz.de/impressum/">Impressum</a> - <a href="https://davidstutz.de/datenschutz/">Datenschutz</a>
            </p>
        </div>
    </body>
</html>