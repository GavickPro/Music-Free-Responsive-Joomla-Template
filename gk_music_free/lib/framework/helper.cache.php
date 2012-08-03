<?php 

//
// Function for CSS/JS compression
//

class GKTemplateCache {
    //
    private $parent;
    //
    function __construct($parent) {
    	$this->parent = $parent;
    }
    //
  	function registerCache() {
          $dispatcher = JDispatcher::getInstance();
          $dispatcher->register('onBeforeRender', 'useCache');
     }
    
     function registerJSCompression() {
          $dispatcher = JDispatcher::getInstance();
          $dispatcher->register('onBeforeRender', 'useJSCompression');
     }
}
 
if(!function_exists('useCache')){
	function useCache() {
		$document = &JFactory::getDocument();
		$cache_css = $document->params->get('css_compression');
		$overwrite = $document->params->get('css_cache');
		$toAddURLs = array();
		$toRemove = array();
		$scripts = array();
		$css_urls = array();
		
		if($document->params->get('jscss_excluded') != '') {
			$toRemove = explode(',',$document->params->get('jscss_excluded'));
		}
		
		if ($cache_css) {
			foreach ($document->_styleSheets as $strSrc => $strAttr) { 
				if (!preg_match('/\?.{1,}$/', $strSrc) && (!isset($strAttr['media']) || $strAttr['media'] == '')) {
					$break = false;
					
					foreach ($toRemove as $remove) {
						$remove = str_replace(' ', '', $remove);
						if(strpos($strSrc, $remove) !== false) {
							$toAddURLs[] = $strSrc;
							$break = true;
							continue;
						}
					}
		
					if(!$break) {    
						if (!preg_match('/\?.{1,}$/', $strSrc)) {
							$srcurl =cleanUrl($strSrc);
							if (!$srcurl) continue;
							//remove this css and add later
							if($srcurl != 'components/com_community/templates/gk_style/css/style.css') {
								unset($document->_styleSheets[$strSrc]);
								$path = str_replace('/', DS, $srcurl);
								$css_urls[] = array(JPATH_SITE . DS . $path, JURI::base(true) . '/' . $srcurl);
							}
		
							//$document->_styleSheets = array();
						}
					}
				}
			}
		}
		
		// re-add external scripts
		foreach($toAddURLs as $url) $document->addStylesheet($url);
		
		if ($cache_css) {
			$url = optimizecss($css_urls, $overwrite);
			if ($url) {
				$document->addStylesheet($url);
			} else {
				foreach ($css_urls as $urls) $document->addStylesheet($url[1]); //re-add stylesheet to head
			}
		}
	}
}

if(!function_exists('useJSCompression')){
	function useJSCompression() {
        $js_urls = array();
        $toAddURLs = array();
        $document = &JFactory::getDocument();
        $toRemove = array();
        $break = false;
          if($document->params->get('jscss_excluded') != '') {
               $toRemove = explode(',',$document->params->get('jscss_excluded'));
          }
         
         foreach ($document->_scripts as $strSrc => $strAttr) {
                $break = false;
               foreach ($toRemove as $remove){
                    $remove = str_replace(' ', '', $remove);
                    if(strpos($strSrc, $remove) !== false) {
                          $toAddURLs[] = $strSrc;
                          $break = true;
                          continue;
                    }
               }
               
               if(!$break) {        
               $srcurl = cleanUrl($strSrc);
               if (!$srcurl){
                     $toAddURLs[] = $strSrc;
                     continue;
               }
              
                unset($document->_scripts[$strSrc]);
                $path = str_replace('/', DS, $srcurl);
                $js_urls[] = array(JPATH_SITE . DS . $path, JURI::base(true) . '/' . $srcurl);
               }
          }
         
          // clean all scripts
          $document->_scripts = array();
           
          // re-add external scripts
          foreach($toAddURLs as $url) $document->addScript($url);
         
          // optimize or re-add
       $url = optimizejs($js_urls, false);
       if ($url) {
            $document->addScript($url);
            } else {
         foreach ($js_urls as $urls) $document->addScript($url[1]); //re-add stylesheet to head
          }
    }
}

if(!function_exists('cleanUrl')){
	function cleanUrl($strSrc) {
			if (preg_match('/^https?\:/', $strSrc)) {
				if (!preg_match('#^' . preg_quote(JURI::base()) . '#', $strSrc)) return false; //external css
				$strSrc = str_replace(JURI::base(), '', $strSrc);
			} else {
				if (preg_match('/^\//', $strSrc)) {
					if (!preg_match('#^' . preg_quote(JURI::base(true)) . '#', $strSrc)) return false; //same server, but outsite website
					$strSrc = preg_replace('#^' . preg_quote(JURI::base(true)) . '#', '', $strSrc);
				}
			  }
			$strSrc = str_replace('//', '/', $strSrc);
			$strSrc = preg_replace('/^\//', '', $strSrc);
			return $strSrc;
		}
}

if(!function_exists('optimizecss')){
	function optimizecss($css_urls, $overwrite = false) {
			$content = '';
			$files = '';
			jimport('joomla.filesystem.file');
			foreach ($css_urls as $url) {
				$files .= $url[1];
				//join css files into one file
				$content .= "/* FILE: {$url[1]} */\n" . compresscss(@JFile::read($url[0]), $url[1]) . "\n\n";
			}
			$file = md5($files) . '.css';
			$url = store_file($content, $file, $overwrite);
			return $url;
		}
}

if(!function_exists('optimizejs')){
	function optimizejs($css_urls, $overwrite = false) {
			$content = '';
			$files = '';
			jimport('joomla.filesystem.file');
			foreach ($css_urls as $url) {
				$files .= $url[1];
				//join js files into one file
			   $content .= "/* FILE: {$url[1]} */\n" . compressjs(@JFile::read($url[0]), $url[1]) . "\n\n";
			}
			$file = md5($files) . '.js';
			 
			$url = store_file($content, $file, true);
			return $url;
		}
}

if(!function_exists('compressjs')){
function compressjs($data) {
        require_once(dirname(__file__) . DS . 'minify' . DS . 'JSMin.php');
            $data = JSMin::minify($data);
        return $data;
    }    
}

if(!function_exists('compresscss')){
	 function compresscss($data, $url) {
			global $current_css_url;
			$current_css_url = $url;
			/* remove comments */
			$data = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $data);
			/* remove tabs, spaces, new lines, etc. */
			$data = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), ' ', $data);
			/* remove unnecessary spaces */
			$data = preg_replace('/[ ]+([{};,:])/', '\1', $data);
			$data = preg_replace('/([{};,:])[ ]+/', '\1', $data);
			/* remove empty class */
			$data = preg_replace('/(\}([^\}]*\{\})+)/', '}', $data);
			/* remove PHP code */
			$data = preg_replace('/<\?(.*?)\?>/mix', '', $data);
			/* replace url*/
			$data = preg_replace_callback('/url\(([^\)]*)\)/', 'replaceurl', $data);
			return $data;
		}
}

if(!function_exists('replaceurl')){
     function replaceurl($matches) {
        $url = str_replace(array('"', '\''), '', $matches[1]);
        global $current_css_url;
        $url = converturl($url, $current_css_url);
        return "url('$url')";
    }
}

if(!function_exists('converturl')){
     function converturl($url, $cssurl) {
        $base = dirname($cssurl);
        if (preg_match('/^(\/|http)/', $url))
            return $url;
        /*absolute or root*/
        while (preg_match('/^\.\.\//', $url)) {
            $base = dirname($base);
            $url = substr($url, 3);
        }
        $url = $base . '/' . $url;
        return $url;
    }
}

if(!function_exists('store_file')){
  function store_file($data, $filename, $overwrite = false) {
        $path = JPATH_SITE . DS . 'cache' . DS . 'gk';
        if (!is_dir($path)) @JFolder::create($path);
        $path = $path . DS . $filename;
        $url = JURI::base(true) . '/cache/gk/' . $filename;
        if (is_file($path) && !$overwrite) return $url;
        @file_put_contents($path, $data);
        return is_file($path) ? $url : false;
    }
}

// EOF