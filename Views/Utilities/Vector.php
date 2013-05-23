$\left[\begin{array}{r} 
    <?php for ($j = 0; $j < $vector->size(); $j++): ?>
        <?php echo $vector->get($j); ?>
        \\
    <?php endfor; ?>
\end{array} \right] $