<?php
namespace App;

class Tools {
	
	public static function odmiana($int, $odmiany){ // $odmiany = Array('jeden','dwa','pięć')
		if(!is_array($odmiany)){
			return $odmiany;
		}
		$txt = $odmiany[2];
		if ($int == 1) $txt = $odmiany[0];
		$jednosci = (int) substr($int,-1);
		$reszta = $int % 100;
		if (($jednosci > 1 && $jednosci < 5) &! ($reszta > 10 && $reszta < 20))
			$txt = $odmiany[1];
		return str_replace('%d', $int, $txt);
	}

    public static function escapeJs($string){

        $string = preg_replace_callback('#[^a-zA-Z0-9,\._]#Su', function ($matches) {
            $char = $matches[0];

            /*
             * A few characters have short escape sequences in JSON and JavaScript.
             * Escape sequences supported only by JavaScript, not JSON, are omitted.
             * \" is also supported but omitted, because the resulting string is not HTML safe.
             */
            static $shortMap = [
                '\\' => '\\\\',
                '/' => '\\/',
                "\x08" => '\b',
                "\x0C" => '\f',
                "\x0A" => '\n',
                "\x0D" => '\r',
                "\x09" => '\t',
            ];

            if (isset($shortMap[$char])) {
                return $shortMap[$char];
            }

            $codepoint = mb_ord($char, 'UTF-8');
            if (0x10000 > $codepoint) {
                return sprintf('\u%04X', $codepoint);
            }

            // Split characters outside the BMP into surrogate pairs
            // https://tools.ietf.org/html/rfc2781.html#section-2.1
            $u = $codepoint - 0x10000;
            $high = 0xD800 | ($u >> 10);
            $low = 0xDC00 | ($u & 0x3FF);

            return sprintf('\u%04X\u%04X', $high, $low);
        }, $string);

        return $string;
    }

}
