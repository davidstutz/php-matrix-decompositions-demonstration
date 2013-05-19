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
                <h1><?php echo __('Code Base'); ?> <span class="muted">//</span> <?php echo __('Vector Class'); ?></h1>
            </div>
            
            <div class="row">
                <div class="span3">
                    <ul class="nav nav-pills nav-stacked">
                        <li>
                            <a href="/<?php echo $app->config('base') . $app->router()->urlFor('code'); ?>"><?php echo __('Code Base'); ?></a>
                            <ul class="nav nav-pills nav-stacked" style="margin-left: 20px;">
                                <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('code/matrix'); ?>"><?php echo __('Matrix Class'); ?></a></li>
                                <li class="active"><a href="#"><?php echo __('Vector Class'); ?></a></li>
                                <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('code/tests'); ?>"><?php echo __('Tests'); ?></a></li>
                            </ul>
                        </li>
                        <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('matrix-decompositions'); ?>"><?php echo __('Matrix Decompositions'); ?></a></li>
                        <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('applications'); ?>"><?php echo __('Applications'); ?></a></li>
                        <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('credits'); ?>"><?php echo __('Credits'); ?></a></li>
                    </ul>
                </div>
                <div class="span9">
                    <pre class="prettyprint linenums">
/**
 * Vector class.
 *
 * @author  David Stutz
 * @license http://www.gnu.org/licenses/gpl-3.0
 */
class Vector {

    /**
     * @var array   data
     */
    private $_data;

    /**
     * @var int size
     */
    private $_size;

    /**
     * Constructor.
     *
     * @param   int     size
     * @return  vector  vector
     */
    public function __construct($size) {
        $this->_data = array();

        $size = (int)$size;
        new \Libraries\Assertion($size > 0, 'Invalid size given.');

        $this->_size = (int)$size;
    }

    /**
     * Resizes the dimensions of the matrix.
     *
     * @param   int     size
     * @return  vector  this
     */
    public function resize($size) {
        $this->_size = (int)$size;

        return $this;
    }

    /**
     * Compares the matrix with the given matrix for equality.
     *
     * @param   matrix  matrix
     * @return  boolean equals
     */
    public function equals($vector) {
        new \Libraries\Assertion($vector instanceof Vector, 'Given vector not of class Vector.');
        new \Libraries\Assertion($this->size() == $vector->size(), 'The dimensions do not match.');

        for ($i = 0; $i < $this->size(); $i++) {
            if ($vector->get($i) != $this->get($i)) {
                return FALSE;
            }
        }

        return TRUE;
    }

    /**
     * Get number of rows.
     *
     * @return  int rows
     */
    public function size() {
        return $this->_size;
    }

    /**
     * Get the matrix entry on the position specified by $position.
     *
     * @param   int     position
     * @param   mixed   value
     */
    public function get($position) {
        $position = (int)$position;

        new \Libraries\Assertion($position >= 0 AND $position < $this->size(), 'Tried to access invalid position.');

        $value = 0;
        if (isset($this->_data[$position])) {
            $value = $this->_data[$position];
        }

        return $value;
    }

    /**
     * Set the vector entry on the specified $position.
     *
     * @param   int     position
     * @param   mixed   value
     * @return  matrix  this
     */
    public function set($position, $value) {
        $position = (int)$position;

        new \Libraries\Assertion($position >= 0 AND $position < $this->size(), 'Tried to access invalid position.');

        $this->_data[$position] = $value;

        return $this;
    }

    /**
     * Sets all entries of the matrix to the given value.
     *
     * @param   mixed   value
     * @return  matrix  this
     */
    public function setAll($value) {
        for ($i = 0; $i < $this->size(); $i++) {
            $this->set($i, $value);
        }
    }

    /**
     * Copy this matrix.
     *
     * @return  matrix  copy
     */
    public function copy() {
        $vector = new Vector($this->size());

        for ($i = 0; $i < $this->size(); $i++) {
            $vector->set($i, $this->get($i));
        }

        return $vector;
    }

    /**
     * Sets the entries form the given array.
     * 
     * @param   array   entries
     * @return  vector  this
     */
    public function fromArray($array) {
        new \Libraries\Assertion(sizeof($array) == $this->size(), 'Array has invalid size.');
        
        for ($i = 0; $i < $this->size(); $i++) {
            $this->set($i, $array[$i]);
        }
        
        return $this;
    }
    
    /**
     * Gets the vector as array.
     * 
     * @return  array   vector
     */
    public function asArray() {
        $array = array();
        
        for ($i = 0; $i < $this->size(); $i++) {
            $array[$i] = $this->get($i);
        }
        
        return $array;
    }
    

    /**
     * Swap the given columns.
     *
     * @param   int column
     * @param   int column
     * @return  matrix  this
     */
    public function swapEntries($i, $j) {
        new \Libraries\Assertion($i >= 0 AND $i < $this->size(), 'Tried to access invalid position.');
        new \Libraries\Assertion($j >= 0 AND $j < $this->size(), 'Tried to access invalid position.');

        $tmp = $this->get($i);
        $this->set($i, $this->get($j));
        $this->set($j, $tmp);

        return $this;
    }

    /**
     * Build the inner product of two vectors.
     *
     * @param   vector  $a
     * @param   vector  $b
     * @return  vector  inner product
     */
    public static function inner($a, $b) {
        new \Libraries\Assertion($a instanceof Vector, 'Given first vector not of class Vector.');
        new \Libraries\Assertion($b instanceof Vector, 'Given second vector not of class Vector.');
        new \Libraries\Assertion($a->size() == $b->size(), 'Dimensions do not match.');

        $size = $a->size();
        $result = 0;

        for ($i = 0; $i < $size; $i++) {
            $result += $a->get($i) * $b->get($i);
        }

        return $result;
    }

}
                    </pre>
                </div>
            </div>
            <hr>
            <p>
                &copy; 2013 David Stutz - <a href="/matrix-decompositions<?php echo $app->router()->urlFor('credits'); ?>"><?php echo __('Credits'); ?></a> - <a href="http://davidstutz.de/impressum-legal-notice/"><?php echo __('Impressum - Legal Notice'); ?></a>
            </p>
        </div>
    </body>
</html>