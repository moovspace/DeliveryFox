<?php
namespace MyApp\Web\Error;
use MyApp\Web\Html\Html;

class ErrorPage
{
    static function Error404()
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

    static function Error500()
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