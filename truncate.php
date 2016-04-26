<?php
/* Use your namespace */
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Truncate extends AbstractHelper
{
	/**
	 * Will truncate the string with both words and chars count
	 */
	protected function both($text, $words, $chars)
	{
		$explodeWords = preg_split('/[\s,]+/', $text);
		if(!count($explodeWords)) return substr($text,0,$chars);

		$newText = "";
		$i       = 1;
		foreach($explodeWords as $word):
			if((strlen($newText)<$chars) || ($i < $words))
				$newText .= " {$word}";
			else break;
			$i++;
		endforeach;
		return $newText;
	}

	/**
	 * Will truncate the string with the words count
	 */
	protected function words($text, $words)
	{
		return preg_replace('/((\w+\W*){'.$words.'}(\w+))(.*)/', '${1}', $text);
	}
	/**
	 *  Will truncate the string with the chars count
	 */
	protected function chars($text, $chars)
	{
		if(strlen($text) < $chars) return $text;
		else return substr($text, 0, strpos(substr($text, 0, $chars), ' '));
	}

	/**
	 * Invoke the class as a function to execute the actions
	 */
	public function __invoke($text, $words=false, $chars=false, $end="...")
	{
		if($words && $chars):
			$string = $this->both($text,$words,$chars);
		elseif($words && !$chars):
			$string = $this->words($text,$chars);
		elseif($chars && !$words):
			$string = $this->chars($text,$chars);
		else:
			$string  = $text;
		endif;
		$endChar = (!$end) ? null : $end;
		return ($string != $text) ? rtrim($string,'.,;:?!¿¡').$endChar : $string ;
	}
}
