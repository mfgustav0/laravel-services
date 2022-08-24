<?php

namespace App\Helper;

class ShowExceptionError
{
	public static function handle(mixed $e, array $seen=null): string
	{
		$starter = $seen ? 'Caused by: ' : '';
	    $result = [];
	    if (!$seen)
	    	$seen = [];
	    $trace  = $e->getTrace();
	    $prev   = $e->getPrevious();
	    $result[] = sprintf('%s%s: %s', $starter, get_class($e), $e->getMessage());
	    $file = $e->getFile();
	    $line = $e->getLine();
	    while (true) {
	        $current = "$file:$line";
	        if (is_array($seen) && in_array($current, $seen)) {
	            $result[] = sprintf(' ... %d more', count($trace)+1);
	            break;
	        }

	        $result[] = sprintf(' at %s%s%s(%s%s%s)',
                        count($trace) && array_key_exists('class', $trace[0]) ? str_replace('\\', '.', $trace[0]['class']) : '',
                        count($trace) && array_key_exists('class', $trace[0]) && array_key_exists('function', $trace[0]) ? '.' : '',
                        count($trace) && array_key_exists('function', $trace[0]) ? str_replace('\\', '.', $trace[0]['function']) : '(main)',
                        $line === null ? $file : basename($file),
                        $line === null ? '' : ':',
                        $line === null ? '' : $line
                    );
	        if (is_array($seen))
	            $seen[] = "$file:$line";

	        if (!count($trace))
	            break;

	        $file = array_key_exists('file', $trace[0]) ? $trace[0]['file'] : 'Unknown Source';
	        $line = array_key_exists('file', $trace[0]) && array_key_exists('line', $trace[0]) && $trace[0]['line'] ? $trace[0]['line'] : null;
	        array_shift($trace);
	    }
	    $result = join("\n", $result);
	    if ($prev)
	        $result  .= "\n" . self::handle($prev, $seen);

	    return $result;
	}
}