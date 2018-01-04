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
            <h1><?php echo __('Matrix Decompositions'); ?> <span class="muted">//</span> <?php echo __('QR'); ?></h1>
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
                        <li><a href="/<?php echo $app->config('base'); ?><?php echo $app->router()->urlFor('matrix-decompositions/householder'); ?>"><?php echo __('Householder transformations'); ?></a></li>
                    </ul>
                </div>
            </div>
            <hr>
            <p>
                &copy; 2013 David Stutz - <a href="/<?php echo $app->config('base'); ?><?php echo $app->router()->urlFor('credits'); ?>"><?php echo __('Credits'); ?></a> - <a href="http://davidstutz.de/impressum-legal-notice/"><?php echo __('Impressum - Legal Notice'); ?></a>
            </p>
        </div>
    </body>
</html>