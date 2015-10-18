<?php defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/Kohana/Core'.EXT;

if (is_file(APPPATH.'classes/Kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/Kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/Kohana'.EXT;
}

/**
 * Set the default time zone.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/timezones
 */
date_default_timezone_set('Europe/Kiev');

/**
 * Set the default locale.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/function.setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @link http://kohanaframework.org/guide/using.autoloading
 * @link http://www.php.net/manual/function.spl-autoload-register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Optionally, you can enable a compatibility auto-loader for use with
 * older modules that have not been updated for PSR-0.
 *
 * It is recommended to not enable this unless absolutely necessary.
 */
//spl_autoload_register(array('Kohana', 'auto_load_lowercase'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @link http://www.php.net/manual/function.spl-autoload-call
 * @link http://www.php.net/manual/var.configuration#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

/**
 * Set the mb_substitute_character to "none"
 *
 * @link http://www.php.net/manual/function.mb-substitute-character.php
 */
mb_substitute_character('none');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('Ru-ru');

if (isset($_SERVER['SERVER_PROTOCOL']))
{
	// Replace the default protocol.
	HTTP::$protocol = $_SERVER['SERVER_PROTOCOL'];
}

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
if (isset($_SERVER['KOHANA_ENV']))
{
	Kohana::$environment = constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));
}

Cookie::$salt = 'sdhhfdhfg563hdfghb4576575bhfhfh';

//Определяем место хранения сесий
Session::$default = 'cookie';

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - integer  cache_life  lifetime, in seconds, of items cached              60
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 * - boolean  expose      set the X-Powered-By header                        FALSE
 */
Kohana::init(array(
	'base_url'   => '/',
    'index_file'   => FALSE,
));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	'auth'       => MODPATH.'auth',       // Basic authentication
	//'cache'      => MODPATH.'cache',      // Caching with multiple backends
	// 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
	'database'   => MODPATH.'database',   // Database access
	'image'      => MODPATH.'image',      // Image manipulation
	// 'minion'     => MODPATH.'minion',     // CLI Tasks
	'orm'        => MODPATH.'orm',        // Object Relationship Mapping
	// 'unittest'   => MODPATH.'unittest',   // Unit testing
	// 'userguide'  => MODPATH.'userguide',  // User guide and API documentation
    'email'       => MODPATH.'email', // E-mail
	));

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */

//Виджеты витрины
Route::set('indexblocks', 'indexblocks(/<controller>(/<param>))', array('param' => '.+'))
	->defaults(array(
            'directory'  => 'Indexblocks',
            'action'     => 'index',
	));

//Виджеты админпанели
Route::set('adminblocks', 'adminblocks(/<controller>(/<param>))', array('param' => '.+'))
	->defaults(array(
            'directory'  => 'Adminblocks',
            'action'     => 'index',
	));

//Админпанель
Route::set('admin', 'admin(/<controller>(/<action>(/<id>)))')
	->defaults(array(
            'directory'  => 'admin',
            'controller' => 'main',
            'action'     => 'index',
	));

//Авторизация
Route::set('auth', '<action>', array('action' => 'login|logout|register'))
	->defaults(array(
        'directory'  => 'index',
		'controller' => 'auth',
	));

//Страници
Route::set('page', 'page(/<id>(/<alias>))')
        ->defaults(array(
            'directory'  => 'index',
            'action' => 'index',
            'controller' => 'page',
	));

//Категория
Route::set('ca', 'ca(/<id>(/<param>))', array('param' => '.+'))
        ->defaults(array(
            'directory'  => 'index',
            'action' => 'index',
            'controller' => 'ca',
	));

//Категория добавлене переменной в сесию
Route::set('ca_run', 'ca_run/<br>/<id>/<param>')
        ->defaults(array(
            'directory'  => 'index',
            'action' => 'run',
            'controller' => 'ca',
	));

//Категория добавлене переменной в сесию
Route::set('arun', 'arun/<br>/<id>/<param>')
        ->defaults(array(
            'directory'  => 'admin',
            'action' => 'run',
            'controller' => 'arun',
	));

//Товар
Route::set('go', 'go(/<id>(/<titlen>))')
        ->defaults(array(
            'directory'  => 'index',
            'action' => 'index',
            'controller' => 'go',
	));
    
//В корзину
Route::set('vcart', 'vcart(/<id>(/<num>)(/<action>))')
        ->defaults(array(
            'directory'  => 'index',
            'action' => 'index',
            'controller' => 'vcart',
	));

//Ксталог товаров в списке
Route::set('calist', 'calist/<ca>/<br>/<list>', array( 'ca' => '[0-9]+', 'go' => '[0-9]+'))
    ->defaults(array(
        'directory'  => 'Indexblocks',
        'controller' => 'calist',
        'action' => 'index'
    ));

//Ксталог товаров плиткой
Route::set('caplitka', 'caplitka/<ca>/<br>/<list>', array( 'ca' => '[0-9]+', 'go' => '[0-9]+'))
    ->defaults(array(
        'directory'  => 'Indexblocks',
        'controller' => 'caplitka',
        'action' => 'index'
    ));
    
//Ксталог товаров плиткой
Route::set('goods', 'goods/<ca>/<br>/<list>', array( 'ca' => '[0-9]+', 'go' => '[0-9]+'))
    ->defaults(array(
        'directory'  => 'Indexblocks',
        'controller' => 'goods',
        'action' => 'index'
    ));

//Ксталог товаров в списке админке
Route::set('editlist', 'editlist/<ca>/<br>/<list>', array( 'ca' => '[0-9]+', 'go' => '[0-9]+'))
    ->defaults(array(
        'directory'  => 'Adminblocks',
        'controller' => 'editlist',
        'action' => 'index'
    ));

//Фото товаров
Route::set('goodimg', 'goodimg/<go>/<num>/<width>/<height>', array( 'width' => '[0-9]+', 'height' => '[0-9]+'))
    ->defaults(array(
        'controller' => 'goodimg',
        'action' => 'index'
    ));

//Фото для брендов
Route::set('imgbrend', 'imgbrend/<go>/<width>/<height>', array( 'width' => '[0-9]+', 'height' => '[0-9]+'))
    ->defaults(array(
        'controller' => 'imgbrend',
        'action' => 'index'
    ));
    
//Поиск товаров
Route::set('searchgo', 'searchgo(/<search>)')
    ->defaults(array(
        'controller' => 'searchgo',
        'action' => 'index'
    ));

Route::set('css', 'css(/<id>)')
    ->defaults(array(
        'controller' => 'css',
        'action' => 'index'
    ));

//Роут по умолчанию
Route::set('default', '(<controller>(/<action>(/<id>)))')
	->defaults(array(
		'directory'  => 'Index',
        'controller' => 'main',
		'action'     => 'index',
	));
