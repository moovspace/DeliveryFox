<?php
use MyApp\App\Component;

class View extends Component
{
	static function Show($arr = null)
	{
		// $data =  self::Data();		
		return "<h1>Page html</h1>";
	}

	static function Head()
	{
		return "";
	}
}

echo View::Show();
// exit;
?>

<?php
// use PhpApix\Router\Hooks\Hooks;

// $hooks = Hooks::GetInstance();

// // Z klasą
// $hooks->add_action('header_action','MyApp\Web\Home\View::Show');

// // Z funkcją ok
// $hooks->add_action('header_action_2','echo_this_in_header');

// // Uruchom hook
// $hooks->do_action('header_action', 'Works with static method');

// function echo_this_in_header(){
// 	return '!!!! This came from a hooked function !!!!';
// }
?>

<?php
/*
// Add hooks to app
use PhpApix\Hooks\Hooks;

// Singleton instance of this class (one in app)
$hooks = Hooks::getInstance();

$hooks->add_action('header_action','echo_this_in_header');

function echo_this_in_header(){
   return '!!!! This came from a hooked function !!!!';
}


// Change hooks
function filter_echo_this_in_header($tag, $val = ''){
  // Get args
  // print_r(func_get_args());

  $arr = explode("a ", $tag);
  $tag = join($arr, $val);

  echo '<h1>' . $tag . '</h1>';
}

// Run hooks in app, singleton
$hooks = Hooks::getInstance();

// Remove action
// $hooks->remove_action('header_action', 'echo_this_in_header');

// Add filter
$hooks->add_filter('header_action', 'filter_echo_this_in_header');

// Aply filter
$hooks->apply_filters('header_action', null, '<span style="color: #f00">[PASSED TEXT]</span> ');

// Display tag
echo '<div id="extra_header">';
$hooks->do_action('header_action');
echo '</div>';
*/
?>