<?php
namespace MyApp\Web\Home;

use PhpApix\Mysql\Db;
use MyApp\App\Component;

class View extends Component
{
    static function Data(){
        try
		{
            // Mysql from static method with singleton (Db class)
            $db = Db::getInstance();
            $stm = $db->Pdo->query("SELECT * FROM user");
            $rows = $stm->fetchAll();
            // $db->Pdo->lastInsertId();
            // PDO::lastInsertId();
            return $rows;
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
        }
    }

    static function Show($text = 'Hello World')
    {
        // Get data
        $d = self::Data();
        print_r($d);
        ?>

        <div class="box">
			<h1> <?php echo $text; ?> </h1>
        </div>

        <?php
	}
}
?>