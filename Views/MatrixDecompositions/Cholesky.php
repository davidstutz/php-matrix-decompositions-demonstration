<!DOCTYPE html>
<html>
    <head>
        <title><?php echo __('Matrix Decompositions - Cholesky Decomposition'); ?></title>
        <script type="text/javascript" src="/<?php echo $app->config('base'); ?>/Assets/Js/jquery.min.js"></script>
        <script type="text/javascript" src="/<?php echo $app->config('base'); ?>/Assets/Js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://c328740.ssl.cf1.rackcdn.com/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
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
            <h1><?php echo __('Matrix Decompositions'); ?> <span class="muted">//</span> <?php echo __('Cholesky'); ?></h1>
            </div>
            <div class="row">
                <div class="span3">
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('code'); ?>"><?php echo __('Code Base'); ?></a></li>
                        <li>
                            <a href="/matrix-decompositions<?php echo $app->router()->urlFor('matrix-decompositions'); ?>"><?php echo __('Matrix Decompositions'); ?></a>
                            <ul class="nav nav-pills nav-stacked" style="margin-left: 20px;">
                                <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('matrix-decompositions/lu'); ?>"><?php echo __('LU Decomposition'); ?></a></li>
                                <li class="active"><a href="#"><?php echo __('Cholesky Decomposition'); ?></a></li>
                                <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('matrix-decompositions/qr'); ?>"><?php echo __('QR Decomposition'); ?></a></li>
                            </ul>
                        </li>
                        <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('applications'); ?>"><?php echo __('Applications'); ?></a></li>
                        <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('credits'); ?>"><?php echo __('Credits'); ?></a></li>
                    </ul>
                </div>
                <div class="span9">
                    <p>
                       <b><?php echo __('Definition.'); ?></b> <?php echo __('$A \in \mathbb{R}^{n \times n}$ is called symmetric, if $A = A^T$.'); ?>
                        <?php echo __('In addition $A$ is called positive definite, if $x^TAx > 0$ for all $x \in \mathbb{R}^{n}$, $x \neq 0$.'); ?>
                    </p>
                    
                    <p>
                        <b><?php echo __('Remark.'); ?></b> <?php echo __('If $A \in \mathbb{R}^{n \times n}$ is symmetric, positive definite then $A$ is regular and $A^{-1}$ is symmetric, positive definite, too.'); ?>
                    </p>
                    
                    <p>
                        <?php echo __('Using the Cholesky decomposition a symmetric, positive definite matrix $A \in \mathbb{R}^{n \times n}$ can be decomposed into the product $LDL^T$ of a normed lower triangular matrix $L \in \mathbb{R}^{n \times n}$ and an upper triangular matrix $R \in \mathbb{R}^{n \times n}$.'); ?>
                    </p>
                    
                    <p>
                        <b><?php echo __('Applications.'); ?></b>
                        <ul>
                            <li><?php echo __('The problem $Ax = LDL^Tx = b$ is reduced to solving $Ly = b$ and $L^Tx = D^{-1}y$.'); ?></li>
                            <li><?php echo __('The used algorithm can be used to check whether the given matrix $A$ is symmetric, positive definite.'); ?></li>
                        </ul>
                    </p>
                    
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
 * Helper class to provide methods concerning the cholesky decomposition.
 *
 * @author  David Stutz
 * @license http://www.gnu.org/licenses/gpl-3.0
 */
class Cholesky {
    
    const TOLERANCE = 0.00001;
    
    /**
     * @var matrix
     */
    protected $_matrix;
    
    /**
     * Constructor: Generate cholesky deocmposition of given matrix.
     * 
     * @param   matrix
     */
    public function __construct(&$matrix) {
        new \Libraries\Assertion($matrix instanceof \Libraries\Matrix, 'Given matrix not of class Matrix.');
        new \Libraries\Assertion($matrix->isSquare(), 'Given matrix is not square.');

        $this->_matrix = $matrix->copy();

        for ($j = 0; $j < $this->_matrix->columns(); $j++) {
            $d = $this->_matrix->get($j, $j);
            for ($k = 0; $k < $j; $k++) {
                $d -= pow($this->_matrix->get($j, $k), 2) * $this->_matrix->get($k, $k);
            }

            // Test if symmetric, positive definit can be guaranteed.
            new \Libraries\Assertion($d > Cholesky::TOLERANCE * (double)$this->_matrix->get($j, $j), 'Symmetric, positive definit can not be guaranteed: ' . $d . ' > ' . Cholesky::TOLERANCE * (double)$this->_matrix->get($j, $j));

            $this->_matrix->set($j, $j, $d);

            for ($i = $j + 1; $i < $this->_matrix->rows(); $i++) {
                $this->_matrix->set($i, $j, $this->_matrix->get($i, $j));
                for ($k = 0; $k < $j; $k++) {
                    $this->_matrix->set($i, $j, $this->_matrix->get($i, $j) - $this->_matrix->get($i, $k) * $this->_matrix->get($k, $k) * $this->_matrix->get($j, $k));
                }
                $this->_matrix->set($i, $j, $this->_matrix->get($i, $j) / ((double)$this->_matrix->get($j, $j)));
            }
        }
    }
    
    /**
     * Get the L of the composition L^T*D*L.
     * 
     * @return  matrix  L
     */
    public function getL() {
        $L = $this->_matrix->copy();
        
        // L is the lower triangular matrix.
        for ($i = 0; $i < $L->rows(); $i++) {
            for ($j = $i; $j < $L->columns(); $j++) {
                if ($j == $i) {
                    $L->set($i, $j, 1);
                }
                else {
                    $L->set($i, $j, 0);
                }
            }
        }
        
        return $L;
    }
    
    /**
     * Get D - the diagonal matrix.
     * 
     * @return  matrix  D
     */
    public function getD() {
        $D = new \Libraries\Matrix($this->_matrix->rows(), $this->_matrix->columns());
        
        for ($i = 0; $i < $D->rows(); $i++) {
            $D->set($i, $i, $this->_matrix->get($i, $i));
        }
        
        return $D;
    }
}
                                </pre>
                            </div>
                            <div class="tab-pane" id="algorithm">
                            
                                <p>
                                    <?php echo __('There are explicit formulars to compute the entries for $L$ and $D$:'); ?>
                                </p>
                                
                                <ul style="list-style-type:none;">
                                    <li><?php echo __('$d_{j,k} = a_{j,j} - \sum _{k = 1} ^{j - 1} l_{j,k}^2 d_{k,k}$ for the columns $j = 1, \ldots, n$.'); ?></li>
                                    <li><?php echo __('$l_{i,j} = \frac{a_{i,j} - \sum _{k = 1} ^{j - 1} l_{i,k} d_{k,k} l_{j,k}}{d_{j,j}}$ for the columns $j = 1, \ldots, n$.'); ?></li>
                                </ul>
                                
                                <p>
                                    <?php echo __('The formulars can be seen as result of an entry-wise comparison:'); ?>
                                </p>
                                
                                <p>
                                  $A = 
                                  \left[\begin{array}{c c c} 
                                    a_{1,1} & \ldots & a_{1,n} \\
                                    \vdots & \ddots & \vdots \\
                                    a_{n,1} & \ldots & a_{n,n} \\
                                  \end{array} \right]
                                   = 
                                  \left[\begin{array}{c c c} 
                                    l_{1,1} & \ldots & l_{1,n} \\
                                    \vdots & \ddots & \vdots \\
                                    l_{n,1} & \ldots & l_{n,n} \\
                                  \end{array} \right]
                                  \left[\begin{array}{c c c} 
                                    d_{1,1} & & \varnothing \\
                                     & \ddots &  \\
                                    \varnothing & & d_{n,n} \\
                                  \end{array} \right]
                                  \left[\begin{array}{c c c} 
                                    l_{1,1} & \ldots & l_{n,1} \\
                                    \vdots & \ddots & \vdots \\
                                    l_{1,n} & \ldots & l_{n,n} \\
                                  \end{array} \right]
                                   = LDL^T
                                  $
                                </p>
                                
                                <p>
                                    <?php echo __('Based on the symmetry of $A$ the entry-wise analysis can be restricted to the lower triangular part of the matrix.'); ?>
                                </p>
                                
                                <p>
                                    <?php echo __('The algorithm can easily be derived from the above formulars:'); ?>
                                </p>
                                
                                <p>
                                    <b><?php echo __('Algorithm.'); ?></b>
                                    <ul style="list-style-type:none;">
                                        <li><?php echo __('For $j = 1,2, \ldots, n$:'); ?>
                                            <ul style="list-style-type:none;">
                                                <li><?php echo __('$d := a _{j,j} - \sum _{k = 1} ^{j - 1} a _{j,k}^2 a_{k,k}$'); ?></li>
                                                <li><?php echo __('If $diag > \epsilon \cdot a_{j,j}$:'); ?>
                                                    <ul style="list-style-type:none;">
                                                        <li><?php echo __('$a_{j,j} := d$'); ?></li>
                                                        <li><?php echo __('For $i = j+1, \ldots, n$:'); ?>
                                                            <ul style="list-style-type:none;">
                                                                <li><?php echo __('$a_{i,j} := \frac{a_{i,j} - \sum _{k = 1} ^{j - 1} a_{i,k} a_{k,k} a_{j,k}}{a_{j,j}}$'); ?></li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </p>
                                
                                <p>
                                    <?php echo __('For each column $j$: Computing the diagonal entry needs $j - 1$ substractions and $2(j - 1)$ multiplications. Computing the entries of L needs $(n - j)$ divisions, $(n - j) (j - 1)$ additions and $2 (n - j) (j - 1)$ multiplications:'); ?>
                                </p>
                                
                                <p><b><?php echo __('Runtime.'); ?></b></p>
                                
                                <p>
                                    <?php echo __('$T(n) = \sum _{j = 1} ^{n} 3 (j - 1) + (n - j) + 3 (n - j) (j - 1) = \ldots = 3 \frac{n(n - 1)}{2} + \frac{n(n + 1)}{2} + 3 \frac{n(n + 1)(2n + 1)}{6} \in \mathcal{O}(\frac{1}{3} n^3)$'); ?>
                                </p>
                                
                                <p>
                                    <b><?php echo __('Remark.'); ?></b> <?php echo __('The runtime can be reduced to $\mathcal{O}(\frac{1}{6} n^3)$ by using a slightly modified algorithm computing a decomposition $A = LL^T$.'); ?>
                                </p>
                            
                            </div>
                            <div class="tab-pane <?php if (!isset($matrix)): ?>active<?php endif; ?>" id="demo">
                                <form class="form-horizontal" method="POST" action="/<?php echo $app->config('base') . $app->router()->urlFor('matrix-decompositions/cholesky/demo'); ?>">
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
                                        <button class="btn btn-primary" type="submit"><?php echo __('Calculate Cholesky Decomposition'); ?></button>
                                    </div>
                                </form>
                            </div>
                            <?php if (isset($matrix)): ?>
                                <div class="tab-pane active" id="result">
                                    <p><b><?php echo __('Given matrix.'); ?></b></p>
                                    
                                    <p>
                                        $A = $ <?php echo $app->render('Utilities/Matrix.php', array('matrix' => $matrix)); ?> $\in \mathbb{R}^{<?php echo $matrix->rows(); ?> \times <?php echo $matrix->columns(); ?>}$
                                    </p>
                                    
                                    <p><b><?php echo __('Decomposition.'); ?></b></p>
                                    
                                    <p>
                                        $L = $ <?php echo $app->render('Utilities/Matrix.php', array('matrix' => $l)); ?>
                                    </p>
                                    
                                    <p>
                                        $D = $ <?php echo $app->render('Utilities/Matrix.php', array('matrix' => $d)); ?>
                                    </p>
                                    
                                    <p><b><?php echo __('Check.'); ?></b></p>
                                        
                                    <p>
                                        <?php $lt = $l->copy()->transpose(); ?>
                                        $LDL^T = $ <?php echo $app->render('Utilities/Matrix.php', array('matrix' => \Libraries\Matrix::multiply($l, \Libraries\Matrix::multiply($d, $lt)))); ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <p>
                &copy; 2013 David Stutz - <a href="/matrix-decompositions<?php echo $app->router()->urlFor('credits'); ?>"><?php echo __('Credits'); ?></a> - <a href="http://davidstutz.de/impressum-legal-notice/"><?php echo __('Impressum - Legal Notice'); ?></a>
            </p>
        </div>
    </body>
</html>