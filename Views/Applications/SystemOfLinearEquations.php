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
        <link rel="stylesheet" type="text/css" href="/<?php echo $app->config('base'); ?>/Assets/Css/matrix-decompositions.css">
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
                                <li class="active"><a href="#"><?php echo __('System of Linear Equations'); ?></a></li>
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
                        <b><?php echo __('Problem.'); ?></b> <?php echo __('Given $A \in \mathbb{R}^{n \times n}$ and $b \in \mathbb{R}^n$. Find $x \in \mathbb{R}^n$ such that $Ax = b$.'); ?>
                    </p>
                    
                    <!--
                    <p>
                        $a_{1,1} x_1 + a_{1,2} x_2 + \ldots + a_{1,n} x_n = b_1$<br>
                        $a_{2,1} x_1 + a_{2,2} x_2 + \ldots + a_{2,n} x_n = b_2$<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$\vdots$<br>
                        $a_{n,1} x_1 + a_{n,2} x_2 + \ldots + a_{n,n} x_n = b_n$<br>
                    </p>
                    -->
                    
                    <p>
                        
                    </p>
                </div>
            </div>
            <hr>
            <p>
                &copy; 2013 David Stutz - <a href="/matrix-decompositions<?php echo $app->router()->urlFor('credits'); ?>"><?php echo __('Credits'); ?></a> - <a href="http://davidstutz.de/impressum-legal-notice/"><?php echo __('Impressum - Legal Notice'); ?></a>
            </p>
        </div>
    </body>
</html>