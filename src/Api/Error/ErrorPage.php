<?php
namespace PhpApix\Api\Error;
use PhpApix\Api\Home\Html;

class ErrorPage
{
    static function Error404($router)
    {
		// Include header
		Html::Header();

		?>

		<div class="box">
			<img src="/media/img/phpapix-logo.jpg" width="156" height="156">
			<h1>Error 404! Page not found!</h1>
		</div>

		<?php

		// Include footer
		Html::Footer();
    }

    static function Error500($router)
    {
        // Include header
		Html::Header();

		?>

		<div class="box">
			<img src="/media/img/phpapix-logo.jpg" width="156" height="156">
			<h1>Error 500! Internal Server Error!</h1>
		</div>

		<?php

		// Include footer
		Html::Footer();
    }
}
?>