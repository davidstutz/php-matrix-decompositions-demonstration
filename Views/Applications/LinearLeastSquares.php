<!DOCTYPE html>
<html>
    <head>
        <title><?php echo __('Matrix Decompositions - Applications'); ?></title>
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
                <h1><?php echo __('Applications'); ?></h1>
            </div>
              
            <div class="row">
                <div class="span3">
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('code'); ?>"><?php echo __('Code Base'); ?></a></li>
                        <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('matrix-decompositions'); ?>"><?php echo __('Matrix Decompositions'); ?></a></li>
                        <li>
                            <a href="/<?php echo $app->config('base') . $app->router()->urlFor('applications'); ?>"><?php echo __('Applications'); ?></a>
                            <ul class="nav nav-pills nav-stacked" style="margin-left: 20px;">
                                <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('applications/system-of-linear-equations'); ?>"><?php echo __('System of Linear Equations'); ?></a></li>
                                <li class="active"><a href="#"><?php echo __('Linear Least Squares'); ?></a></li>
                            </ul>
                        </li>
                        <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('credits'); ?>"><?php echo __('Credits'); ?></a></li>
                    </ul>
                </div>
                <div class="span9">
                    <p>
                        <?php echo __('Given a mathematical model and some data, linear least squares is a method to fit the model to the data. As concrete example consider the following basic curve fitting problem. Imagine some points within a plane. We want to find a line within this plane such that the sum over all distances between the line and each point is minimized - so the line which has the best "fit" to the given data points. In general the problem can be described as (approximately) solving an overdetermined system of linear equations.'); ?>
                    </p>
                    
                    <p><b><?php echo __('Remark.'); ?></b> <?php echo __('A system of linear equations is overdetermined if it has more equations than unknowns.'); ?></p>
                    
                    <p><b><?php echo __('Problem.'); ?></b> <?php echo __('Given $A \in \mathbb{R}^{m \times n}$ with $m \geq n$ and full rank and $b \in \mathbb{R}^m$. Find $x \in \mathbb{R}^n$ such that $\|Ax - b\|_2 = min_{y \in \mathbb{R}^n} \|Ay - b\|_2$.'); ?></p>
                    
                    <p>
                        <?php echo __('Using the QR decomposition the problem can easily be solved including computing the error $\|Ax - b\|_2$ of the found solution $x$. First calculate a QR decomposition $A = QR$. Then:'); ?>
                    </p>
                    
                    <p>
                        $Q^TA = R = \left[\begin{array}{c} 
                                    \bar{R} \\
                                    \emptyset \\
                                  \end{array} \right]$
                        <?php echo __('with $\bar{R} \in \mathbb{R}^{n \times n}$ and upper triangular matrix and'); ?>
                        $Q^Tb = \left[\begin{array}{c} 
                                    \bar{b} \\
                                    e \\
                                  \end{array} \right]$
                        <?php echo __('with $\bar{b} \in \mathbb{R}^{n}$.'); ?>
                    </p>
                    
                    <p>
                        <?php echo __('$\bar{R}$ has full rank and the solution $x \in \mathbb{R}^{n}$ of $\bar{R}c = \bar{b}$ is the solution of the linear least squares problem. In addition $\|e\|_2$ is the error.'); ?>
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
                                <form class="form-horizontal" method="POST" action="/<?php echo $app->config('base') . $app->router()->urlFor('applications/linear-least-squares/demo'); ?>">
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
                                        $Q = $ <?php echo $app->render('Utilities/Matrix.php', array('vector' => $q)); ?>
                                    </p>
                                    
                                    <p>
                                        $R = $ <?php echo $app->render('Utilities/Matrix.php', array('vector' => $r)); ?>
                                    </p>
                                    
                                    <p><b><?php echo __('Solution $x$.'); ?></b></p>
                                    
                                    <p><?php echo $app->render('Utilities/Vector.php', array('vector' => $x)); ?> $\in \mathbb{R}^{<?php echo $x->size(); ?>}$</p>
                                    
                                    <p><b><?php echo __('Check.'); ?></b></p>
                                    
                                    
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