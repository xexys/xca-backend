<?php

return array(
    
    'backbone'=>array(
        'baseUrl'=>'js/backbone',
        'js'=>array('backbone-min.js', 'backbone-super-min.js'),
        'depends'=>array('underscore')
    ),
    
    'underscore'=>array(
        'baseUrl'=>'js/underscore',
        'js'=>array('underscore-min.js'),
    ),
    
    'handlebars'=>array(
        'baseUrl'=>'js',
        'js'=>array('handlebars.js'),
    ),
    
    'dustjs'=>array(
        'baseUrl'=>'js/dustjs/linkedin',
        'js'=>array('dust-full-1.2.5.min.js', 'dust-helpers-1.1.1.min.js'),
    ),
    
    'bootstrap'=>array(
        'baseUrl'=>'bootstrap',
        'css'=>array(YII_DEBUG ? 'css/bootstrap.css' : 'css/bootstrap.min.css'),
        'js'=>array('js/bootstrap.min.js'),
        'depends'=>array('jquery')
    ),
    
    'requirejs'=>array(
        'baseUrl'=>'js/requirejs',
        'js'=>array('require.min.js'),
    ),
    
    // jQuery + plugins
    'jquery'=>array(
        'baseUrl'=>'js/jquery',
        'js'=>array('jquery-1.7.2.min.js'),
    ),
    // jQuery.UI
    'jquery.ui'=>array(
        'baseUrl'=>'js/jquery/ui',
        'css'=>array("css/ui-lightness/jquery-ui-1.8.19.custom.css"),
        'js'=>array("jquery-ui-ru.min.js"),
        'depends'=>array("jquery")
    ),
    'jquery.watermark'=>array(
        'baseUrl'=>'js/jquery',
        'js'=>array('jquery.watermark.min.js'),
        'depends'=>array('jquery')
    ),
    'jquery.template'=>array(
        'baseUrl'=>'js/jquery/tmpl',
        'js'=>array('jquery.tmpl.min.js'),
        'depends'=>array('jquery')
    ),
    'classy'=>array(
        'baseUrl'=>'js/jquery',
        'js'=>array('classy.js'),
        'depends'=>array('jquery')
    ),
    
    // Аналоги PHP функций
    'print_r'=>array(
        'baseUrl'=>'js/php',
        'js'=>array('print_r.js'),
    ),
    
    'tinymce'=>array(
        'baseUrl'=>'js/tinymce',
        'js'=>array('tinymce.min.js'),
    ),
    // Модальные окна
    'jqModal'=>array(
        'baseUrl'=>"js/jquery/jqModal",
        'js'=>array("jqModal.min.js"),
        'css'=>array("jqModal.css"),
        'depends'=>array("jquery")
    ),

    
);