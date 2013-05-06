<!DOCTYPE html>
<html>
  <head>
    <title><?php echo __('Matrix Decompositions - Cholesky Decomposition'); ?></title>
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
    <link rel="stylesheet" type="text/css" href="/<?php echo $app->config('base'); ?>/Assets/Css/bootstrap.min.css">
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
            <li>
              <a href="/matrix-decompositions<?php echo $app->router()->urlFor('matrix-decompositions'); ?>"><?php echo __('Matrix Decompositions'); ?></a>
              <ul class="nav nav-pills nav-stacked" style="margin-left: 20px;">
                <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('matrix-decompositions/lu'); ?>"><?php echo __('LU Decomposition'); ?></a></li>
                <li class="active"><a href="#"><?php echo __('Cholesky Decomposition'); ?></a></li>
                <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('matrix-decompositions/qr'); ?>"><?php echo __('QR Decomposition'); ?></a></li>
              </ul>
            <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('applications'); ?>"><?php echo __('Applications'); ?></a></li>
            <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('credits'); ?>"><?php echo __('Credits'); ?></a></li>
          </ul>
        </div>
        <div class="span9">
          <p>
            <?php echo __('Using the Cholesky decomposition a symmetric, positive definit matrix $A \in \mathbb{R}^{n \times n}$ can be decomposed into the product $LDL^T$ of a normed lower triangular matrix $L \in \mathbb{R}^{n \times n}$ and an upper triangular matrix $R \in \mathbb{R}^{n \times n}$.'); ?>
          </p>
          
          <p>
            <?php echo __('$A \in \mathbb{R}^{n \times n}$ is called symmetric, if $A = A^T$.'); ?>
            <?php echo __('In addition $A$ is called positive definit, if $x^TAx > 0$ for all $x \in \mathbb{R}^{n}$, $x \neq 0$.'); ?>
          </p>
          
          <p>
            <b><?php echo __('Applications.'); ?></b>
            <ul>
              <li><?php echo __('Solving $Ax = LDL^Tx = b$ is reduced to solve $Ly = b$ and $L^Tx = D^{-1}y$.'); ?></li>
              <li><?php echo __('The used algorithm can be used to check whether the given matrix $A$ is symmetric, positive definit.'); ?></li>
            </ul>
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
  /**
   * Get the cholesky decomposition of the given matrix.
   * 
   * @param matrix  matrix to get the cholesky decomposition of
   */
  public static function choleskyDecomposition(&$matrix, double $tolerance = NULL) {
    Matrix::_assert($matrix instanceof Matrix, 'Given matrix not of class Matrix.');
    
    if ($tolerance === NULL) {
      $tolerance = (double)0.00001;
    }
    
    for ($j = 0; $j < $matrix->columns(); $j++) {
    $d = $matrix->get($j, $j);
    for ($k = 0; $k < $j; $k++) {
      $d -= pow($matrix->get($j, $k), 2)*$matrix->get($k, $k);
    }
    
    // Test if symmetric, positive definit can be guaranteed.
    Matrix::_assert($d > $tolerance*(double)$matrix->get($j, $j), 'Symmetric, positive definit can not be guaranteed: ' . $d . ' > ' . $tolerance*(double)$matrix->get($j, $j));
    
    $matrix->set($j, $j, $d);
    
    for ($i = $j + 1; $i < $matrix->rows(); $i++) {
      $matrix->set($i, $j, $matrix->get($i, $j));
      for ($k = 0; $k < $j; $k++) {
        $matrix->set($i, $j, $matrix->get($i, $j) - $matrix->get($i, $k)*$matrix->get($k, $k)*$matrix->get($j, $k));
      }
      $matrix->set($i, $j, $matrix->get($i, $j)/((double)$matrix->get($j, $j)));
    }
  }
                </pre>
              </div>
              <div class="tab-pane" id="algorithm">
                
                <p>
                  <?php echo __('There are explicit formulars to compute the entries for $L$ and $D$:'); ?>
                </p>
                
                <ul style="list-style-type:none;">
                  <li><?php echo __('$d_{j,k} = a_{j,j} - \sum _{k = 1} ^{j - 1} l_{j,k}^2 d_{k,k}$ for the columns $j = 1,...,n$.'); ?></li>
                  <li><?php echo __('$l_{i,j} = \frac{a_{i,j} - \sum _{k = 1} ^{j - 1} l_{i,k} d_{k,k} l_{j,k}}{d_{j,j}}$ for the columns $j = 1,...,n$.'); ?></li>
                </ul>
                
                <p>
                  <?php echo __('The formulars can be seen as result of an entry-wise comparison:'); ?>
                </p>
                
                <p>
                  $A = 
                  \left[\begin{array}{c c c} 
                    a_{1,1} & \ldots & a_{1,n} \\
                    \vdots & \ddots & \vdots \\
                    a_{n,1} & \ldots & a_{n,n} \\
                  \end{array} \right]
                   = 
                  \left[\begin{array}{c c c} 
                    l_{1,1} & \ldots & l_{1,n} \\
                    \vdots & \ddots & \vdots \\
                    l_{n,1} & \ldots & l_{n,n} \\
                  \end{array} \right]
                  \left[\begin{array}{c c c} 
                    d_{1,1} & & \varnothing \\
                     & \ddots &  \\
                    \varnothing & & d_{n,n} \\
                  \end{array} \right]
                  \left[\begin{array}{c c c} 
                    l_{1,1} & \ldots & l_{n,1} \\
                    \vdots & \ddots & \vdots \\
                    l_{1,n} & \ldots & l_{n,n} \\
                  \end{array} \right]
                   = LDL^T
                  $
                </p>
                
                <p>
                  <?php echo __('Based on the symmetry of $A$ the entry-wise analysis can be restricted to the lower triangular part of the matrix.'); ?>
                </p>
                
                <p>
                  <?php echo __('The algorithm can easily be derived from the above formulars:'); ?>
                </p>
                
                <ul style="list-style-type:none;">
                  <li><?php echo __('For $j = 1,2,...,n$:'); ?>
                    <ul style="list-style-type:none;">
                      <li><?php echo __('$d := a _{j,j} - \sum _{k = 1} ^{j - 1} a _{j,k}^2 a_{k,k}$'); ?></li>
                      <li><?php echo __('If $diag > \epsilon \cdot a_{j,j}$:'); ?>
                        <ul style="list-style-type:none;">
                          <li><?php echo __('$a_{j,j} := d$'); ?></li>
                          <li><?php echo __('For $i = j+1,...,n$:'); ?>
                            <ul style="list-style-type:none;">
                              <li><?php echo __('$a_{i,j} := \frac{a_{i,j} - \sum _{k = 1} ^{j - 1} a_{i,k} a_{k,k} a_{j,k}}{a_{j,j}}$'); ?></li>
                            </ul>
                          </li>
                        </ul>
                      </li>
                    </ul>
                  </li>
                </ul>
                
                <p>
                  <?php echo __('For each column $j$: Computing the diagonal entry needs $j - 1$ substractions and $2(j - 1)$ multiplications. Computing the entries of L needs $(n - j)$ divisions, $(n - j) (j - 1)$ additions and $2 (n - j) (j - 1)$ multiplications:'); ?>
                </p>
                
                <p><b><?php echo __('Runtime.'); ?></b></p>
                
                <p>
                  <?php echo __('$T(n) = \sum _{j = 1} ^{n} 3 (j - 1) + (n - j) + 3 (n - j) (j - 1) = \ldots = 3 \frac{n(n - 1)}{2} + \frac{n(n + 1)}{2} + 3 \frac{n(n + 1)(2n + 1)}{6} \in \mathcal{O}(\frac{1}{3} n^3)$'); ?>
                </p>
                
                <p>
                  <b><?php echo __('Remark.'); ?></b> <?php echo __('The runtime can be reduced to $\mathcal{O}(\frac{1}{6} n^3)$ by using a slightly modified algorithm computing a decomposition $A = LL^T$.'); ?>
                </p>
                
              </div>
              <div class="tab-pane <?php if (!isset($original)): ?>active<?php endif; ?>" id="demo">
                <form class="form-horizontal" method="POST" action="/<?php echo $app->config('base') . $app->router()->urlFor('cholesky-decomposition'); ?>">
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
                  <p><b><?php echo __('Given matrix.'); ?></b></p>
                
                  <p><?php echo $app->render('Matrix.php', array('matrix' => $original)); ?> $\in \mathbb{R}^{<?php echo $original->rows(); ?> \times <?php echo $original->columns(); ?>}$</p>
                  
                  <p><b><?php echo __('Decomposition.'); ?></b></p>
                  
                  <p>
                    $L = $ <?php echo $app->render('Matrix.php', array('matrix' => $l)); ?>
                  </p>
                  
                  <p>
                    $D = $ <?php echo $app->render('Matrix.php', array('matrix' => $d)); ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>
          </div>
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