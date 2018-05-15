<!DOCTYPE html>
<html>
    <head>
        <title><?php echo __('PHP Matrix Decompositions - Applications'); ?></title>
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
                <h1><?php echo __('Applications'); ?> <span class="muted">//</span> <?php echo __('System of Linear Equations'); ?></h1>
            </div>
              
            <div class="row">
                <div class="span3">
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('matrix-decompositions'); ?>"><?php echo __('Matrix Decompositions'); ?></a></li>
                        <li>
                            <a href="/<?php echo $app->config('base') . $app->router()->urlFor('applications'); ?>"><?php echo __('Applications'); ?></a>
                            <ul class="nav nav-pills nav-stacked" style="margin-left: 20px;">
                                <li class="active"><a href="#"><?php echo __('System of Linear Equations'); ?></a></li>
                                <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('applications/linear-least-squares'); ?>"><?php echo __('Linear Least Squares'); ?></a></li>
                            </ul>
                        </li>
                        <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('credits'); ?>"><?php echo __('Credits'); ?></a></li>
                    </ul>
                </div>
                <div class="span9">
                    <p>
                        <?php echo __('In computer science a lot of applications lead to the problem of solving systems of linear equations. In linear algebra the problem is specified as follows:'); ?>
                    </p>
                    
                    <p>
                        <b><?php echo __('Problem.'); ?></b> <?php echo __('Given a regular matrix $A \in \mathbb{R}^{n \times n}$ and a column vector $b \in \mathbb{R}^n$ find $x \in \mathbb{R}^n$ such that $Ax = b$.'); ?>
                    </p>
                    
                    <p>
                        <?php echo __('Given a LU decomposition the problem can be solved the following way:'); ?>
                        <ol>
                            <li><?php echo __('Solve $Ly = Pb$ where $P \in \mathbb{R}^{n \times n}$ is the permutation matrix of the LU decomposition.'); ?></li>
                            <li><?php echo __('Solve $Rx = y$.'); ?></li>
                        </ol>
                    </p>
                    
                    <p>
                        <?php echo __('Because $L$ and $R$ are both triangular matrices solving $Ly = PB$ and $Rx = y$ can be done by forward- and backward substitution respectively. As example see the following algorithm for solving $Rx = b$ with $R \in \mathbb{R}^{n \times n}$ an regular upper triangular matrix and $x,b \in \mathbb{R}^n$.'); ?>
                    </p>
                    
                    <p>
                        <b><?php echo __('Algorihm'); ?></b> <?php echo __('(Backward substitution)'); ?>
                        <ul style="list-style-type:none;">
                            <li><?php echo __('For $j = n, \ldots, 1$:'); ?>
                                <ul style="list-style-type:none;">
                                    <li><?php echo __('$x_j = \frac{b_j - \sum _{i = j+1} ^n r_{j,i} x_k}{r_{j,j}}$'); ?></li>
                                </ul>
                            </li>
                        </ul>
                    </p>
                    
                    <div class="tabbable">
                        <ul class="nav nav-tabs">
                            <li <?php if (!isset($matrix)): ?>class="active"<?php endif; ?>><a href="#demo" data-toggle="tab"><?php echo __('Demo'); ?></a></li>
                            <?php if (isset($matrix)): ?>
                                <li class="active"><a href="#result" data-toggle="tab"><?php echo __('Result'); ?></a></li>
                            <?php endif; ?>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane <?php if (!isset($matrix)): ?>active<?php endif; ?>" id="demo">
                                <form class="form-horizontal" method="POST" action="/<?php echo $app->config('base') . $app->router()->urlFor('applications/system-of-linear-equations/demo'); ?>">
                                    <div class="control-group">
                                        <label class="control-label"><?php echo __('Matrix/Vector'); ?></label>
                                        <div class="controls">
                                            <div class="input-append">
                                                <textarea name="matrix" rows="10" class="span4">
1 0 0
0 1 0
0 0 1
                                                </textarea>
                                                <textarea name="vector" rows="10" class="span2" style="margin-left:10px;">
1
1
1
                                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <button class="btn btn-primary" type="submit"><?php echo __('Solve'); ?></button>
                                    </div>
                                </form>
                            </div>
                            <?php if (isset($matrix)): ?>
                                <div class="tab-pane active" id="result">
                                    <p><b><?php echo __('Given matrix.'); ?></b></p>
                                    
                                    <p><?php echo $app->render('Utilities/Matrix.php', array('matrix' => $matrix)); ?> $\in \mathbb{R}^{<?php echo $matrix->rows(); ?> \times <?php echo $matrix->columns(); ?>}$</p>
                                    
                                    <p><b><?php echo __('Given vector.'); ?></b></p>
                                    
                                    <p><?php echo $app->render('Utilities/Vector.php', array('vector' => $vector)); ?> $\in \mathbb{R}^{<?php echo $vector->size(); ?>}$</p>
                                    
                                    <p><b><?php echo __('Decomposition.'); ?></b></p>
                                    
                                    <p>
                                        $L = $ <?php echo $app->render('Utilities/Matrix.php', array('vector' => $l)); ?>
                                    </p>
                                    
                                    <p>
                                        $U = $ <?php echo $app->render('Utilities/Matrix.php', array('vector' => $u)); ?>
                                    </p>
                                    
                                    <p><b><?php echo __('Solution $x$ such that $Ax = b$.'); ?></b></p>
                                    
                                    <p><?php echo $app->render('Utilities/Vector.php', array('vector' => $x)); ?> $\in \mathbb{R}^{<?php echo $x->size(); ?>}$</p>
                                    
                                    <p><b><?php echo __('Check.'); ?></b></p>
                                    
                                    <p>
                                        $Ax = $ <?php echo $app->render('Utilities/Matrix.php', array('matrix' => $matrix)); ?> <?php echo $app->render('Utilities/Vector.php', array('vector' => $x)); ?> $ = $ <?php echo $app->render('Utilities/Vector.php', array('vector' => Vector::multiply($matrix, $x))); ?>
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