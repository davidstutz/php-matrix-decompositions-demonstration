<!DOCTYPE html>
<html>
    <head>
        <title><?php echo __('PHP Matrix Decompositions'); ?></title>
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
                <h1><?php echo __('Matrix Decompositions'); ?></h1>
            </div>
            
            <div class="row">
                <div class="span3">
                    <ul class="nav nav-pills nav-stacked">
                        <li class="active">
                            <a href="#"><?php echo __('Matrix Decompositions'); ?></a>
                            <ul class="nav nav-pills nav-stacked" style="margin-left: 20px;">
                                <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('matrix-decompositions/lu'); ?>"><?php echo __('LU Decomposition'); ?></a></li>
                                <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('matrix-decompositions/cholesky'); ?>"><?php echo __('Cholesky Decomposition'); ?></a></li>
                                <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('matrix-decompositions/qr'); ?>"><?php echo __('QR Decomposition'); ?></a></li>
                            </ul>
                        </li>
                        <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('applications'); ?>"><?php echo __('Applications'); ?></a></li>
                        <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('credits'); ?>"><?php echo __('Credits'); ?></a></li>
                    </ul>
                </div>
                <div class="span9">
                    <p>
                        <?php echo __('This demonstration application discusses several common matrix decompositions. A matrix decomposition is a factorization of a given matrix $A \in \mathbb{R}^{m \times n}$ into a product of matrices.'); ?>
                        <?php echo __('Matrix decompositions are widely used to solve common problems in computer science as well as numerical analysis.'); ?>
                    </p>
                    
                    <p>
                        <?php echo __('On this site we want to discuss some numerical methods for computing matrix decompositions implemented in PHP.'); ?>
                        <?php echo __('The following table gives an overview of the decompositions covered here:'); ?>
                    </p>
                    
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th><?php echo __('Decomposition'); ?></th>
                                <th><?php echo __('Factorizazion'); ?></th>
                                <th><?php echo __('Applicable for'); ?></th>
                                <th><?php echo __('Runtime'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="/<?php echo $app->config('base'); ?><?php echo $app->router()->urlFor('matrix-decompositions/lu'); ?>"><?php echo __('LU'); ?></a></td>
                                <td><?php echo __('$A = LU$'); ?></td>
                                <td><?php echo __('$A \in \mathbb{R}^{n \times n}$, $A$ regular'); ?></td>
                                <td><?php echo __('$\mathcal{O}(\frac{1}{3}n^3)$'); ?></td>
                            </tr>
                            <tr>
                                <td><a href="/<?php echo $app->config('base'); ?><?php echo $app->router()->urlFor('matrix-decompositions/cholesky'); ?>"><?php echo __('Cholesky'); ?></a></td>
                                <td><?php echo __('$A = LDL^T$'); ?></td>
                                <td><?php echo __('$A \in \mathbb{R}^{n \times n}$, $A$ symmetric and positive definite'); ?></td>
                                <td><?php echo __('$\mathcal{O}(\frac{1}{6}n^3)$'); ?></td>
                            </tr>
                            <tr>
                                <td><a href="/<?php echo $app->config('base'); ?><?php echo $app->router()->urlFor('matrix-decompositions/givens'); ?>"><?php echo __('QR: Givens Rotations'); ?></a></td>
                                <td><?php echo __('$A = QR$'); ?></td>
                                <td><?php echo __('$A \in \mathbb{R}^{m \times n}$'); ?></td>
                                <td><?php echo __('$\mathcal{O}(\frac{4}{3}n^3)$'); ?></td>
                            </tr>
                            <tr>
                                <td><a href="/<?php echo $app->config('base'); ?><?php echo $app->router()->urlFor('matrix-decompositions/householder'); ?>"><?php echo __('QR: Householder Transformations'); ?></a></td>
                                <td><?php echo __('$A = QR$'); ?></td>
                                <td><?php echo __('$A \in \mathbb{R}^{m \times n}$'); ?></td>
                                <td><?php echo __('$\mathcal{O}(\frac{2}{3}n^3)$'); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr>
            <p>
                &copy; 2013 David Stutz - <a href="/<?php echo $app->config('base'); ?><?php echo $app->router()->urlFor('credits'); ?>"><?php echo __('Credits'); ?></a> - <a href="https://davidstutz.de/impressum/">Impressum</a> - <a href="https://davidstutz.de/datenschutz/">Datenschutz</a>
            </p>
        </div>
    </body>
</html>