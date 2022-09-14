<?php

namespace App\Util;

class Censurator
{
    public function purify(string $text): string
    {
        $messages = ['test','mot'];

        // $index = array_rand($messages);

        foreach($messages as $msg){
            $text = str_replace($msg,'****',$text);
        }

        return $text;
    }
}

?>