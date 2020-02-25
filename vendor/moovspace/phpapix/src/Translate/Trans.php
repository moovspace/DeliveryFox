<?php
namespace PhpApix\Translate;
use \Exception;
use PhpApix\Translate\Lang;

/**
 * Trans
 *
 * Load file with translated strings *
 * File name:  Lang/messages-pl.trans
 * File format:
 * UNIQUE_ID| Translated string here
 */
class Trans
{
    protected $Default = 'en';
	protected $Messages = '';

	function __construct()
	{
        $this->SetLang($this->LoadSess());
    }

	/**
	 * LoadFile Load messages from file
	 *
	 * @param string $path Path to file
	 * @param string $lang 2 letter strings: pl, en
	 * @return void
	 */
	function LoadFile($path){
		if(file_exists($path)){
			$this->Messages = file_get_contents($path);
		}else{
			throw new Exception("Error translate file path", 1);
		}
	}

	/**
	 * Find() search text translation in file
	 *
	 * @param  string $txt  Unique text id
	 * @param  string $file File name default 'messages' -> messages-en.trans
	 * @return string       Return translated string or empty if string does not exist
	 */
	function Find($txt = '')
	{
		preg_match('/('.$txt.')\|(.+)\n/', $this->Messages, $match);
		if(!empty($match[0])){
			return rtrim(ltrim(end(explode("|", $match[0]))),"\r");
		}
		return 'ADD_TRANSLATE_ID: '.$txt;
	}

	/**
	 * SetLang Set current languge code
	 *
	 * @param string $lang Language code 2 characters
	 * @return void
	 */
    function SetLang($lang = 'en'){
		$lang = Lang::Valid($lang);
        if(!empty($lang)){
			$_SESSION['app']['language'] = strtolower($lang);
        }else{
            return $this->Default;
        }
	}

	/**
	 * GetLang Get current code language
	 *
	 * @return void
	 */
	function GetLang(){
		return strtolower($_SESSION['app']['language']);
	}

	/**
	 * LoadSess Get language code from session
	 *
	 * @return void
	 */
	protected function LoadSess(){
        if(!empty($_SESSION['app']['language'])){
            return strtolower($_SESSION['app']['language']);
        }else{
            return $this->Default;
        }
    }
}
?>