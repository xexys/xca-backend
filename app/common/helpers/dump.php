<?php
/**
 * Функция печатает переменную в виде дерева
 *
 * @author Васильев-Люлин А.В.
 */

function dump($var, $_level=1, $_first=true) {

    static $_recursion;

    if ($_first) {
        $_recursion = array();
        echo "<pre>".PHP_EOL;
        if (is_scalar($var)|| is_resource($var))
            echo gettype($var).": ";
        dump($var, $_level, false);
        echo "</pre>".PHP_EOL;
    } else {
        if (is_array($var)) {
            echo "Array[".count($var)."] of:".PHP_EOL;
            foreach ($var as $key=>$val) {
                if ($key==='GLOBALS')
                    continue;
                echo str_repeat (" ", $_level*9);
                echo "<b>".$key."</b> => ", dump($val, $_level+1, false);
            }
        } elseif (is_object($var)) {
            echo "Object(".  get_class($var).")".PHP_EOL;
            if (!in_array($var, $_recursion, true)) {
                $_recursion[] = $var;
                foreach ($var as $key=>$val) {
                    echo str_repeat (" ", $_level*9);
                    echo "<b>".$key."</b> => ", dump($val, $_level+1, false);
                }
            } else {
                echo str_repeat (" ", $_level*9)."*RECURSION*".PHP_EOL;
            }
        } else {
            echo '"'.htmlspecialchars($var, ENT_QUOTES).'"'.PHP_EOL;
        }
    }
}

function ddump($var)
{
    dump($var); die;
}

/**
 * Функция для отладки, печатает переменную с подсветкой синтаксиса
 * @param mixed $var
 */
function d($var)
{
    CVarDumper::dump($var, 10, true);
}

function dd($var)
{
    d($var); die;
}