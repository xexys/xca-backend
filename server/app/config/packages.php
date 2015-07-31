<?php

$bowerComponents = 'client.bower_components';

return array(

    // jQuery + plugins
    'jquery' => array(
        'basePath' => $bowerComponents,
        'js' => array('jquery/jquery.js'),
    ),
    'jquery.cookie' => array(
        'basePath' => $bowerComponents,
        'js' => array('jquery.cookie/jquery.cookie.js'),
        'depends' => array('jquery')
    ),
    // YiiDebugToolbar alias
    'cookie' => array(
        'depends' => array('jquery.cookie')
    ),
    'bootstrap3-typeahead' => array(
        'basePath' => $bowerComponents,
        'js' => array('bootstrap3-typeahead/bootstrap3-typeahead.js'),
        'depends' => array('jquery')
    ),
    'bootstrap-select' => array(
        'basePath' => $bowerComponents,
        'js' => array('bootstrap-select/dist/js/bootstrap-select.js'),
        'css' => array('bootstrap-select/dist/css/bootstrap-select.css'),
        'depends' => array('jquery')
    ),

    // Шрифты
    'font-awesome-latest' => array(
        'basePath' => $bowerComponents,
        'css' => array('components-font-awesome/css/font-awesome.css')
    )

    //    // jQuery.UI
    //    'jquery.ui'=>array(
    //        'baseUrl'=>'js/jquery/ui',
    //        'css'=>array("css/ui-lightness/jquery-ui-1.8.19.custom.css"),
    //        'js'=>array("jquery-ui-ru.min.js"),
    //        'depends'=>array("jquery")
    //    ),
    //    'jquery.watermark'=>array(
    //        'baseUrl'=>'js/jquery',
    //        'js'=>array('jquery.watermark.min.js'),
    //        'depends'=>array('jquery')
    //    ),
    //    'jquery.template'=>array(
    //        'baseUrl'=>'js/jquery/tmpl',
    //        'js'=>array('jquery.tmpl.min.js'),
    //        'depends'=>array('jquery')
    //    ),
    //    'classy'=>array(
    //        'baseUrl'=>'js/jquery',
    //        'js'=>array('classy.js'),
    //        'depends'=>array('jquery')
    //    ),
    //
    //    'backbone'=>array(
    //        'baseUrl'=>'js/backbone',
    //        'js'=>array('backbone-min.js', 'backbone-super-min.js'),
    //        'depends'=>array('underscore')
    //    ),
    //
    //    'underscore'=>array(
    //        'baseUrl'=>'js/underscore',
    //        'js'=>array('underscore-min.js'),
    //    ),
    //
    //    'handlebars'=>array(
    //        'baseUrl'=>'js',
    //        'js'=>array('handlebars.js'),
    //    ),
    //
    //    'dustjs'=>array(
    //        'baseUrl'=>'js/dustjs/linkedin',
    //        'js'=>array('dust-full-1.2.5.min.js', 'dust-helpers-1.1.1.min.js'),
    //    ),
    //
    //    'bootstrap'=>array(
    //        'baseUrl'=>'bootstrap',
    //        'css'=>array(YII_DEBUG ? 'css/bootstrap.css' : 'css/bootstrap.min.css'),
    //        'js'=>array('js/bootstrap.min.js'),
    //        'depends'=>array('jquery')
    //    ),
    //
    //    'requirejs'=>array(
    //        'baseUrl'=>'js/requirejs',
    //        'js'=>array('require.min.js'),
    //    ),
    //
    //    // Аналоги PHP функций
    //    'print_r'=>array(
    //        'baseUrl'=>'js/php',
    //        'js'=>array('print_r.js'),
    //    ),
    //
    //    'tinymce'=>array(
    //        'baseUrl'=>'js/tinymce',
    //        'js'=>array('tinymce.min.js'),
    //    ),
    //    // Модальные окна
    //    'jqModal'=>array(
    //        'baseUrl'=>"js/jquery/jqModal",
    //        'js'=>array("jqModal.min.js"),
    //        'css'=>array("jqModal.css"),
    //        'depends'=>array("jquery")
    //    ),


);
