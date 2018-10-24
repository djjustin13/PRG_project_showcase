<?php

if (! function_exists('scriptStripper')) {
    function scriptStripper($input)
    {
        $doc = new DOMDocument();

        // load the HTML string we want to strip
        $doc->loadHTML($input);

        // get all the script tags
        $script_tags = $doc->getElementsByTagName('script');

        $length = $script_tags->length;

        // for each tag, remove it from the DOM
        for ($i = 0; $i < $length; $i++) {
            $script_tags->item($i)->parentNode->removeChild($script_tags->item($i));
        }

        // get the HTML string back
        $no_script = $doc->saveHTML();
        return $no_script;
    }
}