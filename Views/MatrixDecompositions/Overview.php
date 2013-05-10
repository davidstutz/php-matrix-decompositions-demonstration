<!DOCTYPE html>
<html>
    <head>
        <title><?php echo __('Matrix Decompositions'); ?></title>
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
                <h1><?php echo __('Matrix Decompositions'); ?></h1>
            </div>
            
            <div class="row">
                <div class="span3">
                    <ul class="nav nav-pills nav-stacked">
                        <li class="active"><a href="#"><?php echo __('Matrix Decompositions'); ?></a>
                        <ul class="nav nav-pills nav-stacked" style="margin-left: 20px;">
                            <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('matrix-decompositions/lu'); ?>"><?php echo __('LU Decomposition'); ?></a></li>
                            <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('matrix-decompositions/cholesky'); ?>"><?php echo __('Cholesky Decomposition'); ?></a></li>
                            <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('matrix-decompositions/qr'); ?>"><?php echo __('QR Decomposition'); ?></a></li>
                        </ul>
                        <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('applications'); ?>"><?php echo __('Applications'); ?></a></li>
                        <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('credits'); ?>"><?php echo __('Credits'); ?></a></li>
                    </ul>
                </div>
                <div class="span9">
                    <p>
                        <?php echo __('In computer science a lot of applications lead to the problem of solving systems of linear equations. In linear algebra the problem is specified as follows:'); ?>
                    </p>
                    
                    <p>
                        <b><?php echo __('Problem.'); ?></b> <?php echo __('Given $A \in \mathbb{R}^{n \times n}$ and $b \in \mathbb{R}^n$. Find $x \in \mathbb{R}^n$ such that $Ax = b$.'); ?>
                    </p>
                    
                    <p>
                        <?php echo __('In this experiment we want to examine some numerical methods to solve this problem implemented in PHP.'); ?>
                    </p>
                    
                    <p>
                        <b><?php echo __('Remark.'); ?></b> <?php echo __('If $A$ is regular the following statements hold:'); ?>
                        <ul>
                            <li><?php echo __('$det(A) \neq 0$'); ?></li>
                            <li><?php echo __('The system $Ax = b$ has a single unique solution for each $b \in \mathbb{R}^n$.'); ?></li>
                            <li><?php echo __('The matrix $A$ has full rank: $rank(A) = n$.'); ?></li>
                        </ul>
                    </p>
                    
                    <p>
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
                                <td><a href="/matrix-decompositions<?php echo $app->router()->urlFor('matrix-decompositions/lu'); ?>"><?php echo __('LU'); ?></a></td>
                                <td><?php echo __('$A = LU$'); ?></td>
                                <td><?php echo __('$A \in \mathbb{R}^{n \times n}$, $A$ regular'); ?></td>
                                <td><?php echo __('$\mathcal{O}(\frac{1}{3}n^3)$'); ?></td>
                            </tr>
                            <tr>
                                <td><a href="/matrix-decompositions<?php echo $app->router()->urlFor('matrix-decompositions/cholesky'); ?>"><?php echo __('Cholesky'); ?></a></td>
                                <td><?php echo __('$A = LDL^T$'); ?></td>
                                <td><?php echo __('$A \in \mathbb{R}^{n \times n}$, $A$ symmetric, positive definit'); ?></td>
                                <td><?php echo __('$\mathcal{O}(\frac{1}{6}n^3)$'); ?></td>
                            </tr>
                            <tr>
                                <td><a href="/matrix-decompositions<?php echo $app->router()->urlFor('matrix-decompositions/givens'); ?>"><?php echo __('QR: Givens Rotations'); ?></a></td>
                                <td><?php echo __('$A = QR$'); ?></td>
                                <td><?php echo __('$A \in \mathbb{R}^{m \times n}$'); ?></td>
                                <td><?php echo __('$\mathcal{O}(\frac{4}{3}n^3)$'); ?></td>
                            </tr>
                            <tr>
                                <td><a href="/matrix-decompositions<?php echo $app->router()->urlFor('matrix-decompositions/householder'); ?>"><?php echo __('QR: Householder Transformations'); ?></a></td>
                                <td><?php echo __('$A = QR$'); ?></td>
                                <td><?php echo __('$A \in \mathbb{R}^{m \times n}$'); ?></td>
                                <td><?php echo __('$\mathcal{O}(\frac{2}{3}n^3)$'); ?></td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <p>
                        <?php echo __('For working with matrices and vectors using PHP the following classes will be used. I know there are already many solutions of data structures for matrices and vectors, and they will most likely be more efficient or more flexible then these, but for demonstrating common used matrix decompositions the given classes will most likely do their jobs.'); ?>
                    </p>
                    
                    <div class="tabbable">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#matrix" data-toggle="tab"><?php echo __('Matrix Class'); ?></a></li>
                            <li><a href="#vector" data-toggle="tab"><?php echo __('Vector Class'); ?></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="matrix">
                                <pre class="prettyprint linenums">
                                </pre>
                            </div>
                            <div class="tab-pane" id="vector">
                                <pre class="prettyprint linenums">
                                </pre>
                            </div>
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