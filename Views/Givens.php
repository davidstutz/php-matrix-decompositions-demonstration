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
			    <li class="active"><a href="#"><?php echo __('QR Decomposition'); ?></a></li>
			    <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('credits'); ?>"><?php echo __('Credits'); ?></a></li>
		    </ul>
		    
		    <p>
		    	<?php echo __('The QR decomposition is a factorization $A = QR$ of a matrix $A \in \mathbb{R}^{m \times n}$ in an orthogonal Matrix $Q \in \mathbb{R}^{m \times m}$ and an upper triangular matrix $R \in \mathbb{R}^{m \times n}$.'); ?>
		    </p>
		    
		    <p>
		    	<?php echo __('Among others there are two popular methods to compute a QR decompositions:'); ?>
		    </p>
		    
		    <ul class="nav nav-pills">
			    <li class="active"><a href="#"><?php echo __('Givens rotations'); ?></a></li>
			    <li class="disabled"><a href="#"><?php echo __('Householder transformations'); ?></a></li>
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
/**
 * Get the qr decomposition of the given matrix using givens rotations.
 * 
 * @param	matrix	matrix to get the qr decomposition of
 */
public static function qrDecompositionGivens(&$original)
{
	Matrix::_assert($original instanceof Matrix, 'Given matrix not of class Matrix.');
	
	for ($j = 0; $j < $original->columns(); $j++) {
		for ($i = $j + 1; $i < $original->rows(); $i++) {
			$r = sqrt(pow($original->get($j, $j), 2) + pow($original->get($i, $j), 2));
			
			if ($original->get($i, $j) < 0) {
				$r = -$r;
			}
			
			$s = $original->get($i, $j)/$r;
			$c = $original->get($j, $j)/$r;
			
			for ($k = $j; $k < $original->columns(); $k++) {
				$jk = $original->get($j ,$k);
				$ik = $original->get($i, $k);
				$original->set($j, $k, $c*$jk + $s*$ik);
				$original->set($i, $k, -$s*$jk + $c*$ik);
			}
			
			if ($c == 0) {
				$original->set($i, $j, 1);
			}
			else if (abs($s) < abs($c)) {
				if ($c < 0) {
					$original->set($i, $j, -.5*$s);
				}
				else {
					$original->set($i, $j, .5*$s);
				}
			}
			else {
				$original->set($i, $j, 2./$c);
			}
		}
	}
}
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
								<button class="btn btn-primary type="submit"><?php echo __('Calculate QR Decomposition'); ?></button>
							</div>
						</form>
					</div>
				</div>
				<?php if (isset($original)): ?>
					<div class="tab-pane active" id="result">
						<?php if (isset($original)): ?>
							<p><b><?php echo __('Given matrix.'); ?></b></p>
							
							<p><?php echo $app->render('Matrix.php', array('matrix' => $original)); ?> $\in \mathbb{R}^{<?php echo $original->rows(); ?> \times <?php echo $original->columns(); ?>}$</p>
							
							<p><b><?php echo __('Algorithm.'); ?></b></p>
							
							<?php foreach ($trace as $j => $column): ?>
							  <p><?php echo __('Column'); ?> $<?php echo $j; ?>$</p>
							  <?php foreach ($column as $i => $array): ?>
							    <p><?php echo __('Row'); ?> $<?php echo $i; ?>$</p>
							    <p>$c = <?php echo $array['c']; ?>$, $s = <?php echo $array['s']; ?>$</p>
  								<p>
  									$\leadsto$ <?php echo $app->render('Matrix.php', array('matrix' => $array['matrix'])); ?>
  								</p>
  							<?php endforeach; ?>
							<?php endforeach; ?>
							
							<p><b><?php echo __('Decomposition.'); ?></b></p>
							
							<p>
								$Q = $ <?php echo $app->render('Matrix.php', array('matrix' => $q)); ?>
							</p>
							
							<p>
								$R = $ <?php echo $app->render('Matrix.php', array('matrix' => $r)); ?>
							</p>
							
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
			<hr>
			<p>
				<a href="/matrix-decompositions<?php echo $app->router()->urlFor('credits'); ?>"><?php echo __('Credits'); ?></a>
			</p>
		</div>
	</body>
</html>
</html>


