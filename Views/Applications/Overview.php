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
    <div class="container">
      <div class="page-header">
        <h1><?php echo __('Matrix Decompositions'); ?></h1>
      </div>
      
      <div class="row">
        <div class="span3">
          <ul class="nav nav-pills nav-stacked">
            <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('matrix-decompositions'); ?>"><?php echo __('Matrix Decompositions'); ?></a></li>
            <li class="active"><a href="#"><?php echo __('Applications'); ?></a></li>
            <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('credits'); ?>"><?php echo __('Credits'); ?></a></li>
          </ul>
        </div>
        <div class="span9">
          <p>
            <?php echo __('This section will discuss some common applications of the introduced matrix decompositions. Among others there are:'); ?>
          </p>
          
          <p>
            <ul>
              <li><?php echo __('Solve systems of linear equations $Ax = b$ for $A \in \mathbb{R}^{n \times n}$, $x,b \in \mathbb{R}^n$.'); ?></li>
              <li><?php echo __('Solve the linear least square problem using a QR decomposition or the nonlinear least square problem using iterative methods.'); ?></li>
              <li><?php echo __('Compute eigenvalues and eigenvectors using the vector iteration or the QR algorithm.'); ?></li>
            </ul>
          </p>
        </div>
      </div>
      <hr>
      <p>
        David Stutz - <a href="/matrix-decompositions<?php echo $app->router()->urlFor('credits'); ?>"><?php echo __('Credits'); ?></a>
      </p>
    </div>
  </body>
</html>
</html>