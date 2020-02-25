<?php
namespace PhpApix\Translate;

class Lang
{
    const EN = 'en';
    const PL = 'pl';

    static protected $Allow = ['en','pl'];
    static protected $Lang = 'en';

    /**
     * Valid Get valid language code
     *
     * @param string $l Language code
     * @return string   Valid language code
     */
    static function Valid($l){
        $l = strtolower($l);
        if(in_array($l, self::$Allow)){
            return $l;
        }
        return self::$Lang;
    }

    /**
     * Addlang
     * Add language
     *
     * @param array $arr Allowed languages array
     * @return void
     */
    function AddLang($arr = []){
        foreach($arr as $l){
            $this->Allow[] = strtolower($l);
        }
    }
}
?>