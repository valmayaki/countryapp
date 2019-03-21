<?php
namespace App\Core\Utils;
class Tokenizer 
{
    static function file_get_php_classes($filepath,$onlypublic=true) {
        $php_code = file_get_contents($filepath);
        $classes = static::get_php_classes($php_code,$onlypublic);
        return $classes;
    }
    
    static function get_php_classes($php_code,$onlypublic) {
        $classes = array();
        $methods=array();
        $tokens = token_get_all($php_code);
        $count = count($tokens);
        for ($i = 2; $i < $count; $i++) {
            if ($tokens[$i - 2][0] == T_CLASS
            && $tokens[$i - 1][0] == T_WHITESPACE
            && $tokens[$i][0] == T_STRING) {
                $class_name = $tokens[$i][1];
                $methods[$class_name] = array();
            }
            if ($tokens[$i - 2][0] == T_FUNCTION
            && $tokens[$i - 1][0] == T_WHITESPACE
            && $tokens[$i][0] == T_STRING) {
                if ($onlypublic) {
                    if ( !in_array($tokens[$i-4][0],array(T_PROTECTED, T_PRIVATE))) {
                        $method_name = $tokens[$i][1];
                        $methods[$class_name][] = $method_name;
                    }
                } else {
                    $method_name = $tokens[$i][1];
                    $methods[$class_name][] = $method_name;
                }
            }
        }
        return $methods;
    }

    /**
     * 
     * Looks what classes and namespaces are defined in that file and returns the first found
     * @param String $file Path to file
     * @return Returns NULL if none is found or an array with namespaces and classes found in file
     */
    static function classes_in_file($file)
    {
    
        $classes = $nsPos = $final = array();
        $foundNS = FALSE;
        $ii = 0;
    
        if (!file_exists($file)) return NULL;
    
        $er = error_reporting();
        error_reporting(E_ALL ^ E_NOTICE);
    
        $php_code = file_get_contents($file);
        $tokens = token_get_all($php_code);
        $count = count($tokens);
    
        for ($i = 0; $i < $count; $i++) 
        {
            if(!$foundNS && $tokens[$i][0] == T_NAMESPACE)
            {
                $nsPos[$ii]['start'] = $i;
                $foundNS = TRUE;
            }
            elseif( $foundNS && ($tokens[$i] == ';' || $tokens[$i] == '{') )
            {
                $nsPos[$ii]['end']= $i;
                $ii++;
                $foundNS = FALSE;
            }
            elseif ($i-2 >= 0 && $tokens[$i - 2][0] == T_CLASS && $tokens[$i - 1][0] == T_WHITESPACE && $tokens[$i][0] == T_STRING) 
            {
                if($i-4 >=0 && $tokens[$i - 4][0] == T_ABSTRACT)
                {
                    $classes[$ii][] = array('name' => $tokens[$i][1], 'type' => 'ABSTRACT CLASS');
                }
                else
                {
                    $classes[$ii][] = array('name' => $tokens[$i][1], 'type' => 'CLASS');
                }
            }
            elseif ($i-2 >= 0 && $tokens[$i - 2][0] == T_INTERFACE && $tokens[$i - 1][0] == T_WHITESPACE && $tokens[$i][0] == T_STRING)
            {
                $classes[$ii][] = array('name' => $tokens[$i][1], 'type' => 'INTERFACE');
            }
        }
        error_reporting($er);
        if (empty($classes)) return NULL;
    
        if(!empty($nsPos))
        {
            foreach($nsPos as $k => $p)
            {
                $ns = '';
                for($i = $p['start'] + 1; $i < $p['end']; $i++)
                    $ns .= $tokens[$i][1];
    
                $ns = trim($ns);
                $final[$k] = array('namespace' => $ns, 'classes' => $classes[$k+1]);
            }
            $classes = $final;
        }
        return $classes;
    }
    static function getPhpClasses($phpcode) {
        $classes = array();
    
        $namespace = 0;  
        $tokens = token_get_all($phpcode); 
        $count = count($tokens); 
        $dlm = false;
        for ($i = 2; $i < $count; $i++) { 
            if ((isset($tokens[$i - 2][1]) && ($tokens[$i - 2][1] == "phpnamespace" || $tokens[$i - 2][1] == "namespace")) || 
                ($dlm && $tokens[$i - 1][0] == T_NS_SEPARATOR && $tokens[$i][0] == T_STRING)) { 
                if (!$dlm) $namespace = 0; 
                if (isset($tokens[$i][1])) {
                    $namespace = $namespace ? $namespace . "\\" . $tokens[$i][1] : $tokens[$i][1];
                    $dlm = true; 
                }   
            }       
            elseif ($dlm && ($tokens[$i][0] != T_NS_SEPARATOR) && ($tokens[$i][0] != T_STRING)) {
                $dlm = false; 
            } 
            if (($tokens[$i - 2][0] == T_CLASS || (isset($tokens[$i - 2][1]) && $tokens[$i - 2][1] == "phpclass")) 
                    && $tokens[$i - 1][0] == T_WHITESPACE && $tokens[$i][0] == T_STRING) {
                $class_name = $tokens[$i][1]; 
                if (!isset($classes[$namespace])) $classes[$namespace] = array();
                $classes[$namespace][] = $class_name;
            }
        } 
        return $classes;
    }
}
