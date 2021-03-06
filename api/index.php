<?php
/**
 * module-reference:/api/index.php
 *
 * @created   2019-03-29
 * @version   1.0
 * @package   module-reference
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2019-02-20
 */
namespace OP;

/* @var $app UNIT\App */

//	...
$json = [];
$json['status'] = true;
$json['errors'] = null;
$json['result'] = null;

//	...
list($catg, $file) = explode('-', ($app->Request()['md'] ?? null) .'-' );

//	...
switch( $catg ){
	case 'core':
		$path = ConvertPath( ($file ? "op:/readme/{$file}.md":'op:/README.md') );
		break;

	case 'unit':
		$path = ConvertPath("asset:/unit/{$file}/README.md");
		break;

	case 'javascript':
		$path = ConvertPath("app:/webpack/js/op/README.md");
		break;

	default:
	case 'app':
		if( $file ){
			$path = ConvertPath("asset:/readme/{$file}.md");
		}else{
			$path = ConvertPath('app:/README.md');
		};
	break;
};

//	...
if( empty($path) ){
	$markdown = "File path is empty.";
}else if( 'md' !== ($ext = substr($path, strpos($path, '.')+1)) ){
	$markdown = "File extension has not match. ($ext)";
}else if( file_exists($path) ){
	$markdown = file_get_contents($path);
}else{
	$markdown = "This readme file has not been exists. ({$catg}, {$file})";
};

//	...
$json['result']['markdown'] = $markdown;

//	...
Env::Mime('text/json');

//	...
echo json_encode($json);
