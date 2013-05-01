<!DOCTYPE html>
<html>
  <head>
    <title><?php echo __('Matrix Decompositions - LU Decomposition'); ?></title>
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
        <h1><?php echo __('Matrix Decompositions'); ?></h1>
      </div>
      
        <ul class="nav nav-pills">
          <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('overview'); ?>"><?php echo __('Problem Overview'); ?></a></li>
          <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('lu'); ?>"><?php echo __('LU Decomposition'); ?></a></li>
          <li class="active"><a href="#"><?php echo __('Cholesky Decomposition'); ?></a></li>
          <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('qr'); ?>"><?php echo __('QR Decomposition'); ?></a></li>
          <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('credits'); ?>"><?php echo __('Credits'); ?></a></li>
        </ul>
        
        <p>
          <?php echo __('Using the Cholesky decomposition a symmetry, positive definit matrix $A \in \mathbb{R}^{n \times n}$ can be decomposed into the product $LDL^T$ of a normed lower triangular matrix $L \in \mathbb{R}^{n \times n}$ and an upper triangular matrix $R \in \mathbb{R}^{n \times n}$.'); ?>
        </p>
        
        <p>
          <?php echo __('$A \in \mathbb{R}^{n \times n}$ is called symmetric, if $A = A^T$.'); ?>
          <?php echo __('In addition $A$ is called positive definit, if $x^TAx > 0$ for all $x \in \mathbb{R}^{n}$, $x \neq 0$.'); ?>
        </p>
        
        <p>
          <?php echo __('Beneath computing the decomposition the algorithm can also be used to determine if the given matrix is symmetric, positive definit - if the algorithm fails the matrix is not symmetric, positive definit.'); ?>
        </p>
        
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
              <form class="form-horizontal" method="POST" action="/matrix-decompositions<?php echo $app->router()->urlFor('givens-decomposition'); ?>">
                <div class="control-group">
                  <label class="control-label"><?php echo __('Matrix'); ?></label>
                  <div class="controls">
                    <textarea name="matrix" rows="10" class="span6"></textarea>
                  </div>
                </div>
                <div class="form-actions">
                  <button class="btn btn-primary type="submit"><?php echo __('Calculate Cholesky Decomposition'); ?></button>
                </div>
              </form>
            </div>
            <?php if (isset($original)): ?>
              <div class="tab-pane active" id="result">
                
              </div>
            <?php endif; ?>
          </div>
      </div>
      <hr>
      <p>
        <a href="/matrix-decompositions<?php echo $app->router()->urlFor('credits'); ?>"><?php echo __('Credits'); ?></a>
      </p>
    </div>
  </body>
</html>
</html>