<?php


namespace App\Controller\Services\Censurator;


class Censurator
{


    public  function purify(string $text)
    {
        $tableauDeCensure = array('enculer','salaud','salope','petasse','connard','nique','niquer','pute');
            $phrasePurify = str_ireplace($tableauDeCensure, "*", $text);
            return $phrasePurify;

    }
}