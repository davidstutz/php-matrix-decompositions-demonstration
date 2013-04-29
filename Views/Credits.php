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
				<h1><?php echo __('Credits'); ?></h1>
			</div>
			
		    <ul class="nav nav-pills">
			    <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('overview'); ?>"><?php echo __('Problem Overview'); ?></a></li>
          <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('basics'); ?>"><?php echo __('Basics'); ?></a></li>
			    <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('lu'); ?>"><?php echo __('LU Decomposition'); ?></a></li>
			    <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('qr'); ?>"><?php echo __('QR Decomposition'); ?></a></li>
			    <li class="active"><a href="#"><?php echo __('Credits'); ?></a></li>
		    </ul>
			
			<p><b><?php echo __('About me.'); ?></b></p>
			
			<p>
				<?php echo __('Visit my personal website:'); ?> <a href="http://davidstutz.de">davidstutz.de</a>.
			</p>
			
			<p><b><?php echo __('Code.'); ?></b></p>
			
			<p>
				<?php echo __('Visit the project on GitHub:'); ?> <a href="https://github.com/davidstutz/matrix-decompositions" target="_blank">davidstutz/matrix-decompositions</a>
			</p>
			
			<p><b><?php echo __('Sources.'); ?></b></p>
			
			<p>
				<ul>
					<li><a href="http://en.wikipedia.org/wiki/Triangular_matrix" target="_blank"><?php echo __('Wikipedia: Triangular Matrix'); ?></a> <span class="muted"><?php echo __(' - visited february 2013'); ?></span></li>
					<li><a href="http://en.wikipedia.org/wiki/Lu_decomposition" target="_blank"><?php echo __('Wikipedia: LU Decomposition'); ?></a> <span class="muted"><?php echo __(' - visited february 2013'); ?></span></li>
					<li><a href="http://en.wikipedia.org/wiki/Gaussian_elimination" target="_blank"><?php echo __('Wikipedia: Gaussian Elimination'); ?></a> <span class="muted"><?php echo __(' - visited february 2013'); ?></span></li>
					<li><?php echo __('"Numerik f&uuml;r Ingeneure und Naturwissenschaftler", W. Dahmen, A.Resuken, Springer Verlag, 2. Auflage'); ?></li>
				</ul>
			</p>
			
			<p><b><?php echo __('Built with.'); ?></b></p>
			
			<p>
				<ul>
					<li><a href="http://twitter.github.com/bootstrap/" target="_blank">Twitter Bootstrap</a></li>
					<li><a href="http://www.mathjax.org/" target="_blank">MathJax</a></li>
					<li><a href="http://www.slimframework.com/">Slim</a></li>
				</ul>
			</p>
			<hr>
			<p>
				<a href="/matrix-decompositions<?php echo $app->router()->urlFor('credits'); ?>"><?php echo __('Credits'); ?></a>
			</p>
		</div>
	</body>
</html>
</html>