<!DOCTYPE html>
<html>
    <head>
        <title><?php echo __('Matrix Decompositions - QR Decomposition - Householder Transformations'); ?></title>
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
        <link rel="stylesheet" type="text/css" href="/<?php echo $app->config('base'); ?>/Assets/Css/matrix-decompositions.css">
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
                        <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('code'); ?>"><?php echo __('Code Base'); ?></a></li>
                        <li>
                            <a href="/matrix-decompositions<?php echo $app->router()->urlFor('matrix-decompositions'); ?>"><?php echo __('Matrix Decompositions'); ?></a>
                            <ul class="nav nav-pills nav-stacked" style="margin-left: 20px;">
                                <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('matrix-decompositions/lu'); ?>"><?php echo __('LU Decomposition'); ?></a></li>
                                <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('matrix-decompositions/cholesky'); ?>"><?php echo __('Cholesky Decomposition'); ?></a></li>
                                <li class="active"><a href="#"><?php echo __('QR Decomposition'); ?></a></li>
                            </ul>
                        </li>
                        <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('applications'); ?>"><?php echo __('Applications'); ?></a></li>
                        <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('credits'); ?>"><?php echo __('Credits'); ?></a></li>
                    </ul>
                </div>
                <div class="span9">
                    <p>
                        <?php echo __('The QR decomposition is a factorization $A = QR$ of a matrix $A \in \mathbb{R}^{m \times n}$ in an orthogonal Matrix $Q \in \mathbb{R}^{m \times m}$ and an upper triangular matrix $R \in \mathbb{R}^{m \times n}$.'); ?>
                    </p>
                    
                    <p>
                        <?php echo __('Some basic characteristics of orthogonal matrices. Let $Q \in \mathbb{R}^{n \times n}$ be an orthogonal matrix.'); ?>
                        <ul>
                            <li><?php echo __('$Q^T$ is orthogonal.'); ?></li>
                            <li><?php echo __('Let $\bar{Q} \in \mathbb{R}^{n \times n}$ be orthogonal, then $Q \cdot \bar{Q}$ is orthogonal.'); ?></li>
                            <li><?php echo __('The columns of $Q$ form an orthonormal basis of $\mathbb{R}^n$.'); ?></li>
                        </ul>
                    </p>
                    
                    <p>
                        <b><?php echo __('Applications.'); ?></b>
                        <ul>
                            <li><?php echo __('The problem $Ax = b$ is reduced to solving $Rx = Q^{-1}b = Q^Tb$.'); ?></li>
                            <li><?php echo __('The QR decompositions is widely used to solve the linear least squares problem as well as the nonlinear least squares problem.'); ?></li>
                            <li><?php echo __('The so called "QR algorithm" uses QR decompositions to compute the eigenvalues of a matrix.'); ?></li>
                        </ul>
                    </p>
                    
                    <p>
                        <?php echo __('Among others there are two popular methods to compute a QR decompositions:'); ?>
                    </p>
                    
                    <ul class="nav nav-pills">
                        <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('matrix-decompositions/givens'); ?>"><?php echo __('Givens rotations'); ?></a></li>
                        <li class="active"><a href="#"><?php echo __('Householder transformations'); ?></a></li>
                    </ul>
                    
                    <div class="tabbable">
                        <ul class="nav nav-tabs">
                            <li><a href="#code" data-toggle="tab"><?php echo __('Code'); ?></a></li>
                            <li><a href="#algorithm" data-toggle="tab"><?php echo __('Algorithm'); ?></a></li>
                            <li <?php if (!isset($original)): ?>class="active"<?php endif; ?>><a href="#demo" data-toggle="tab"><?php echo __('Demo'); ?></a></li>
                            <?php if (isset($original)): ?>
                                <li class="active"><a href="#result" data-toggle="tab"><?php echo __('Result'); ?></a></li>
                            <?php endif; ?>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane" id="code">
                                <pre class="prettyprint linenums">
                                </pre>
                            </div>
                            <div class="tab-pane" id="algorithm">
                            
                            </div>
                            <div class="tab-pane <?php if (!isset($original)): ?>active<?php endif; ?>" id="demo">
                                <form class="form-horizontal" method="POST" action="/<?php echo $app->config('base') . $app->router()->urlFor('matrix-decompositions/householder/demo'); ?>">
                                    <div class="control-group">
                                        <label class="control-label"><?php echo __('Matrix'); ?></label>
                                        <div class="controls">
                                            <textarea name="matrix" rows="10" class="span6"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <button class="btn btn-primary type="submit"><?php echo __('Calculate QR Decomposition'); ?></button>
                                    </div>
                                </form>
                            </div>
                            <?php if (isset($original)): ?>
                                <div class="tab-pane active" id="result">
                                
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