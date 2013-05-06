<!DOCTYPE html>
<html>
	<head>
		<title><?php echo __('Credits'); ?></title>
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
				<h1><?php echo __('Credits'); ?></h1>
			</div>
			
			<div class="row">
        <div class="span3">
          <ul class="nav nav-pills nav-stacked">
            <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('matrix-decompositions'); ?>"><?php echo __('Matrix Decompositions'); ?></a></li>
            <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('applications'); ?>"><?php echo __('Applications'); ?></a></li>
            <li class="active"><a href="#"><?php echo __('Credits'); ?></a></li>
          </ul>
    	  </div>
    	  <div class="span9">
    			<p>
    				<b><?php echo __('About me.'); ?></b> <?php echo __('Visit my personal website:'); ?> <a href="http://davidstutz.de" target="_blank">davidstutz.de</a>.
    			</p>
    		  			
    			<p>
    				<b><?php echo __('Code.'); ?></b> <?php echo __('Visit the project on GitHub:'); ?> <a href="https://github.com/davidstutz/matrix-decompositions" target="_blank">davidstutz/matrix-decompositions</a>
    			</p>
    			
    			<p><b><?php echo __('Sources.'); ?></b></p>
    			
    			<p>
    				<ul>
    					<li><a href="http://en.wikipedia.org/wiki/Triangular_matrix" target="_blank"><?php echo __('Wikipedia: Triangular Matrix'); ?></a> <span class="muted"><?php echo __(' - visited february 2013'); ?></span></li>
    					<li><a href="http://en.wikipedia.org/wiki/Lu_decomposition" target="_blank"><?php echo __('Wikipedia: LU Decomposition'); ?></a> <span class="muted"><?php echo __(' - visited february 2013'); ?></span></li>
    					<li><a href="http://en.wikipedia.org/wiki/Gaussian_elimination" target="_blank"><?php echo __('Wikipedia: Gaussian Elimination'); ?></a> <span class="muted"><?php echo __(' - visited february 2013'); ?></span></li>
              <li><a href="http://en.wikipedia.org/wiki/Orthogonal_matrix" target="_blank"><?php echo __('Wikipedia: Orthogonal Matrix'); ?></a> <span class="muted"><?php echo __(' - visited april 2013'); ?></span></li>
              <li><a href="http://en.wikipedia.org/wiki/Wallace_Givens" target="_blank"><?php echo __('Wikipedia: Wallace Givens'); ?></a> <span class="muted"><?php echo __(' - visited april 2013'); ?></span></li>
              <li><a href="http://en.wikipedia.org/wiki/Cholesky_decomposition" target="_blank"><?php echo __('Wikipedia: Cholesky Decomposition'); ?></a> <span class="muted"><?php echo __(' - visited april 2013'); ?></span></li>
              <li><a href="http://en.wikipedia.org/wiki/Analysis_of_algorithms" target="_blank"><?php echo __('Wikipedia: Analysis of Algorithms'); ?></a> <span class="muted"><?php echo __(' - visited april 2013'); ?></span></li>
    					<li><?php echo __('"Introduction to Algorithms", T. Cormen, C. Leiserson, R. Rivest, C. Stein, MIT Press, Third Edition'); ?></li>
    					<li><?php echo __('"Numerik f&uuml;r Ingeneure und Naturwissenschaftler", W. Dahmen, A.Resuken, Springer Verlag, Second Edition'); ?></li>
    				</ul>
    			</p>
    			
    			<p><b><?php echo __('Built with.'); ?></b></p>
    			
    			<p>
    				<ul>
    					<li><a href="http://twitter.github.com/bootstrap/" target="_blank">Twitter Bootstrap</a></li>
    					<li><a href="http://www.mathjax.org/" target="_blank">MathJax</a></li>
    					<li><a href="http://www.slimframework.com/" target="_blank">Slim</a></li>
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