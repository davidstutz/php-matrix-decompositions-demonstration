<!DOCTYPE html>
<html>
    <head>
        <title><?php echo __('Matrix Decompositions - Code Base'); ?></title>
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
                <h1><?php echo __('Code Base'); ?></h1>
            </div>
            
            <div class="row">
                <div class="span3">
                    <ul class="nav nav-pills nav-stacked">
                        <li class="active">
                            <a href="#"><?php echo __('Code Base'); ?></a>
                            <ul class="nav nav-pills nav-stacked" style="margin-left: 20px;">
                                <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('code/matrix'); ?>"><?php echo __('Matrix Class'); ?></a></li>
                                <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('code/vector'); ?>"><?php echo __('Vector Class'); ?></a></li>
                                <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('code/tests'); ?>"><?php echo __('Tests'); ?></a></li>
                            </ul>
                        </li>
                        <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('matrix-decompositions'); ?>"><?php echo __('Matrix Decompositions'); ?></a></li>
                        <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('applications'); ?>"><?php echo __('Applications'); ?></a></li>
                        <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('credits'); ?>"><?php echo __('Credits'); ?></a></li>
                    </ul>
                </div>
                <div class="span9">
                    <p>
                        <?php echo __('For working with matrices and vectors using PHP the following classes will be used. I know there are already many solutions of data structures for matrices and vectors, and they will most likely be more efficient or more flexible then these, but for demonstrating common used matrix decompositions the given classes will most likely do their jobs.'); ?>
                    </p>
                    
                    <p>
                        <?php echo __('Thus the aspects I focussed on are readable and clean code. Thus efficiency concerning the runtime as well as the needed memory of the written code is less important.'); ?>
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