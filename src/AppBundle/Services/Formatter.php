<?php

namespace AppBundle\Services;

class Formatter
{
	public function formatScientific($someFloat)
    {
		if($someFloat==0) {
			return 0;
		} else {
	        $magnitude = floor(log10(abs($someFloat)));
	        $significant = round(pow(10, -$magnitude) * $someFloat, 2);
	
	        return $significant . "e" . $magnitude;
		}
    }
}