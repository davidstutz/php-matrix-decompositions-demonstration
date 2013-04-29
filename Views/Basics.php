<!DOCTYPE html>
<html>
  <head>
    <title><?php echo __('Matrix Decompositions - Credits'); ?></title>
    <script type="text/javascript" src="Assets/jquery.min.js"></script>
    <script type="text/javascript" src="Assets/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://c328740.ssl.cf1.rackcdn.com/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
    <script type="text/javascript" src="Assets/prettify.js"></script>
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
    <link rel="stylesheet" type="text/css" href="Assets/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="Assets/prettify.css">
  </head>
  <body>
    <div class="container">
      <div class="page-header">
        <h1><?php echo __('Basics'); ?></h1>
      </div>
      
      <ul class="nav nav-pills">
        <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('overview'); ?>"><?php echo __('Problem Overview'); ?></a></li>
        <li class="active"><a href="#"><?php echo __('Problem Overview'); ?></a></li>
        <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('lu'); ?>"><?php echo __('LU Decomposition'); ?></a></li>
        <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('qr'); ?>"><?php echo __('QR Decomposition'); ?></a></li>
        <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('credits'); ?>"><?php echo __('Credits'); ?></a></li>
      </ul>
      
      <div class="tabbable">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#multiplication" data-toggle="tab"><?php echo __('Multiplication'); ?></a></li>
          <li><a href="#transpose" data-toggle="tab"><?php echo __('Transpose'); ?></a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane" id="multiplication">
            
          </div>
          <div class="tab-pane" id="transpose">
            
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
</html>