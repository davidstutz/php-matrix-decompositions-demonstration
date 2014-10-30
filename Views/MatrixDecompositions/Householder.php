<!DOCTYPE html>
<html>
    <head>
        <title><?php echo __('Matrix Decompositions - QR Decomposition - Householder Transformations'); ?></title>
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
                <h1><?php echo __('Matrix Decompositions'); ?> <span class="muted">//</span> <?php echo __('QR'); ?> <span class="muted">//</span> <?php echo __('Householder Transformations'); ?></h1>
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
                        <li><a href="/<?php echo $app->config('base'); ?><?php echo $app->router()->urlFor('matrix-decompositions/givens'); ?>"><?php echo __('Givens rotations'); ?></a></li>
                        <li class="active"><a href="#"><?php echo __('Householder transformations'); ?></a></li>
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
 * Calculate a QR decomposition by using householder transformation.
 *
 * @author  David Stutz
 * @license http://www.gnu.org/licenses/gpl-3.0
 */
class QRHouseholder {
    
    /**
     * @var matrix
     */
    protected $_matrix;
    
    /**
     * @var vector
     */
    protected $_tau;
    
    /**
     * Constructor: Get the qr decomposition of the given matrix using householder transformations.
     * The single householder matrizes are stores within the matrix.
     *
     * @param matrix  matrix to get the composition of
     */
    public function __construct(&$matrix) {
        new Assertion($matrix instanceof Matrix, 'Given matrix not of class Matrix.');

        $this->_tau = new Vector($matrix->columns());
        $this->_matrix = $matrix->copy();

        for ($j = 0; $j < $this->_matrix->columns(); $j++) {

            $norm = 0.;
            for ($i = $j; $i < $this->_matrix->rows(); $i++) {
                $norm += pow($this->_matrix->get($i, $j), 2);
            }
            $norm = sqrt($norm);

            $sign = 1.;
            if ($this->_matrix->get($j, $j) < 0) {
                $sign = -1.;
            }

            $v1 = $this->_matrix->get($j, $j) + $sign * $norm;
            $scalar = 1;

            for ($i = $j + 1; $i < $this->_matrix->rows(); $i++) {
                $this->_matrix->set($i, $j, $this->_matrix->get($i, $j) / $v1);
                $scalar += pow($this->_matrix->get($i, $j), 2);
            }

            $this->_tau->set($j, 2. / $scalar);

            $w = new Vector($this->_matrix->columns());
            $w->setAll(0.);

            // First calculate w = v_j^T * A.
            for ($i = $j; $i < $this->_matrix->columns(); $i++) {
                $w->set($i, $this->_matrix->get($j, $i));
                for ($k = $j + 1; $k < $this->_matrix->rows(); $k++) {
                    if ($i == $j) {
                        $w->set($i, $w->get($i) + $this->_matrix->get($k, $j) * $this->_matrix->get($k, $i) * $v1);
                    }
                    else {
                        $w->set($i, $w->get($i) + $this->_matrix->get($k, $j) * $this->_matrix->get($k, $i));
                    }
                }

                $this->_matrix->set($j, $i, $this->_matrix->get($j, $i) - $this->_tau->get($j) * $w->get($i));
                for ($k = $j + 1; $k < $this->_matrix->rows(); $k++) {
                    if ($i > $j) {
                        $this->_matrix->set($k, $i, $this->_matrix->get($k, $i) - $this->_tau->get($j) * $this->_matrix->get($k, $j) * $w->get($i));
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
        // Q is an m x m matrix if m is the maximum of the number of rows and thenumber of columns.
        $m = max($this->_matrix->columns(), $this->_matrix->rows());
        $Q = new Matrix($m, $m);
        $Q->setAll(0.);
        
        // Begin with the identity matrix.
        for ($i = 0; $i < min($Q->rows(), $Q->columns()); $i++) {
            $Q->set($i, $i, 1.);
        }
        
        // Got backwards through all householder transformations and apply them on
        for ($k = $this->_matrix->columns() - 1; $k >= 0; $k--) {
            for ($j = $k; $j < $Q->columns(); $j++) {
                
                // First compute w^T(j) = v^T * Q(j) where Q(j) is the j-th column of Q.
                $w = $Q->get($k, $j)*1.;
                for ($i = $k + 1; $i < $Q->rows(); $i++) {
                    $w += $this->_matrix->get($i, $k)*$Q->get($i, $j);
                }
                
                // Now : Q(i,j) = Q(i,j) - tau(k)*v(i)*w(j).
                $Q->set($k, $j, $Q->get($k, $j) - $this->_tau->get($k)*1.*$w);
                for ($i = $k + 1; $i < $Q->rows(); $i++) {
                    $Q->set($i, $j, $Q->get($i, $j) - $this->_tau->get($k)*$this->_matrix->get($i, $k)*$w);
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
                                    <?php echo __('A householder transformation is a reflection about a hyperplane described using a normal vector $v$. The housholder transformation is then defined as:'); ?>
                                </p>
                                
                                <p>
                                    <?php echo __('$Q_v = I - 2 \frac{vv^T}{v^Tv}$'); ?>
                                </p>
                                
                                <p>
                                    <?php echo __('Where $I$ is the identity matrix. It is easy to see the following properties of the householder transformation $Q_v$:'); ?>
                                </p>
                                
                                <p>
                                    <ul>
                                        <li><?php echo __('$Q_v = Q_v^T$.'); ?></li>
                                        <li><?php echo __('$Q_v^2 = I$.'); ?></li>
                                    </ul>
                                </p>
                                
                                <p>
                                    <?php echo __('Thus, $Q_v$ is orthogonal and symmetric. To eliminate all entries of $A$ below the diagonal we consider the following task: Given a vector $a \in \mathbb{R}^n$ find $v \in \mathbb{R}^n$ such that'); ?>
                                </p>
                                
                                <p>
                                    $Q_v a = (I - 2 \frac{vv^T}{v^Tv}) \cdot a = 
                                    \left[\begin{array}{c} 
                                    \ast \\
                                    0 \\
                                    \vdots \\
                                    0\ \\
                                    \end{array} \right]
                                    $
                                </p>
                                
                                <p>
                                    <?php echo __('The solution is given by $v = a + sign(a_1)\|a\|_2$ where $sign(a_1)$ is the sign of the first entry of $a$ and $\|\cdot\|_2$ is the 2-norm. The QR decomposition is then accomplished by eliminating all entries below the diagonal by using the appropriate householder transformation on the first column of the submatrix $A[i:m,i:n] \in \mathbb{R}^{m-i+1 \times n-i+1}$ for each $i = 1, \ldots , min(m,n) -1$.'); ?>
                                </p>
                                
                                <p>
                                    <b><?php echo __('Algorithm.'); ?></b>
                                    <ul style="list-style-type:none;">
                                        <li><?php echo __('For $i = 1, \ldots, n - 1$:'); ?>
                                            <ul style="list-style-type:none;">
                                                <li><?php echo __('Consider the submatrix $\bar{A} := A[i:m,i:n]$'); ?>.</li>
                                                <li><?php echo __('Calculate $v_i = \bar{a_i} + sign(\bar{a_{i,i}})\|\bar{a_i}\|_2$ where $\bar{a_i}$ is the $i$-th column of $\bar{A}$.'); ?></li>
                                                <li><?php echo __('$A[i:m,i:n] := Q_v A[i:m,i:n]$.'); ?></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </p>
                                
                                <p>
                                    <?php echo __('For the implementation of the above algorithm the following trick is useful. Instead of setting up $Q_v$ and then calculating $Q_v A$ it is easier to calculate $w^T = v^T \cdot A$ and then:'); ?>
                                </p>
                                
                                <p>
                                    <?php echo __('$A - \frac{2}{v^Tv} v w^T$'); ?>
                                </p>
                                
                                <p>
                                    <?php echo __('In addition $v$ can be stored below the diagonal within the matrix by normalizing $v$ such that $v_1 = 1$.'); ?>
                                </p>
                                
                                
                            </div>
                            <div class="tab-pane <?php if (!isset($matrix)): ?>active<?php endif; ?>" id="demo">
                                <form class="form-horizontal" method="POST" action="/<?php echo $app->config('base') . $app->router()->urlFor('matrix-decompositions/householder/demo'); ?>">
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
                                    
                                    <?php foreach ($trace as $array): ?>
                                        <p>
                                            $\leadsto$ <?php echo $app->render('Utilities/Matrix.php', array('matrix' => $array['matrix'])); ?> <?php echo __('with'); ?> $v = $ <?php echo $app->render('Utilities/Vector.php', array('vector' => $array['v'])); ?>
                                        </p>
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
                &copy; 2013 David Stutz - <a href="/<?php echo $app->config('base'); ?><?php echo $app->router()->urlFor('credits'); ?>"><?php echo __('Credits'); ?></a> - <a href="http://davidstutz.de/impressum-legal-notice/"><?php echo __('Impressum - Legal Notice'); ?></a>
            </p>
        </div>
    </body>
</html>