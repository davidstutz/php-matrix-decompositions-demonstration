$\left[\begin{array}{<?php for ($i = 0; $i < $matrix->rows(); $i++) echo 'r'; ?>} 
	<?php for ($i = 0; $i < $matrix->rows(); $i++): ?>
		<?php for ($j = 0; $j < $matrix->columns(); $j++): ?>
			<?php echo $matrix->get($i, $j); ?>
				<?php if ($j < $matrix->columns() - 1): ?> & <?php endif; ?>
			<?php endfor; ?>
			\\
		<?php endfor; ?>
 \end{array} \right] $