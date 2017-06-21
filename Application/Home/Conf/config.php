<?php
return array(
    "URL_MODE" => "2",
    'CONTROLLER_LEVEL' => 2,
    'DEFAULT_CONTROLLER' => 'Common/Index',

//    "DB_TYPE" => "mysql",
//    "DB_HOST" => "localhost",
//    'DB_NAME' => 'sj_erp',
//    'DB_USER' => 'root',
//    'DB_PWD' => '',
//    'DB_PORT' => '3306',
//    'DB_PREFIX' => 'sj_',

    "URL_CASE_INSENSITIVE" => false,
    'LOAD_EXT_FILE' => 'common',

    'LOAD_EXT_CONFIG' => 'db,authConfig,debugConfig',

    'URL_HTML_SUFFIX'=>'sj_html',

//    'URL_DENY_SUFFIX' => 'pdf|ico|png|gif|jpg',//可防止资源泄露？
);