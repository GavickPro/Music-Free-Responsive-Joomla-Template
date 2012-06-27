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
    function useCache($cache_css, $overwrite = false) {
        $document = JFactory::getDocument();

        $scripts = array();
        $css_urls = array();

        if ($cache_css) {
            foreach ($document->_styleSheets as $strSrc => $strAttr) { 
                if (!preg_match('/\?.{1,}$/', $strSrc) && (!isset($strAttr['media']) || $strAttr['media'] == '')) {
                    $srcurl = $this->cleanUrl($strSrc);
                    if (!$srcurl) continue;
                    //remove this css and add later
                    
                    if($srcurl != 'components/com_community/templates/gk_style/css/style.css') {
                     unset($document->_styleSheets[$strSrc]);
                     $path = str_replace('/', DS, $srcurl);
                     $css_urls[] = array(JPATH_SITE . DS . $path, JURI::base(true) . '/' . $srcurl);
                    }
                }
            }
       
            $url = $this->optimizecss($css_urls, $overwrite);
            if ($url) {
                $document->addStylesheet($url);
            } else {
                foreach ($css_urls as $urls) $document->addStylesheet($url[1]); //re-add stylesheet to head
            }
        }
    }
	//
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
	//
    function optimizecss($css_urls, $overwrite = false) {
        $content = '';
        $files = '';
        jimport('joomla.filesystem.file');
        foreach ($css_urls as $url) {
            $files .= $url[1];
            //join css files into one file
            $content .= "/* FILE: {$url[1]} */\n" . $this->compresscss(@JFile::read($url[0]), $url[1]) . "\n\n";
        }

        $file = md5($files) . '.css';
        $url = $this->store_file($content, $file, $overwrite);
        return $url;
    }
	//
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
        $data = preg_replace_callback('/url\(([^\)]*)\)/', array('GKTemplateCache', 'replaceurl'), $data);
        return $data;
    }
	//
    function replaceurl($matches) {
        $url = str_replace(array('"', '\''), '', $matches[1]);
        global $current_css_url;
        $url = GKTemplateCache::converturl($url, $current_css_url);
        return "url('$url')";
    }
	//
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
	//
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