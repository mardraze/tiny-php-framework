<?php
namespace App;

class HttpEngine {
	
	private $routing = [
		'example' => '/example-{param}',
		'home' => '/'
	];
	
	private static $instance;
	
	
	public static function boot(){
		return self::getInstance();
	}
	
	public static function getInstance(){
		if(!self::$instance){
			self::$instance = new HttpEngine();
		}
		return self::$instance;
	}
	
	public function run(){
		if(isset($_SERVER['REQUEST_URI'])){
			$urlParts = explode('?', $_SERVER['REQUEST_URI']);
			$route = $this->urlToRoute($urlParts[0]);
			
			if($route){
				switch($route['name']){
					case 'example':
						$controller = new NotFoundController();
						$controller->run($route);
					break;
					default:
						$controller = new NotFoundController();
						$controller->run($route);
				}
			}else{
				$controller = new NotFoundController();
				$controller->run($route);
			}
		}else{
			throw new \ErrorException('REQUEST_URI is not set');
		}
	}
	
    public function url($name, $params = [])
    {
        if(isset($this->routing[$name])){
            $url = $this->routing[$name];
            foreach ($params as $key => $value) {
                $url = str_replace('{'.$key.'}', $value, $url);
            }
            $url2 = $url;
            $url = preg_replace('@\{\w+\}@', '', $url);
            if($url2 !== $url){
                throw new \ErrorException('Za mało parametrów '.$this->routing[$name].' '.$url2);
            }
            return $url;
        }
		
		throw new \ErrorException('Nie znaleziono routingu "'.$name.'"');
    }

    private function urlToRoute($url)
    {
        foreach ($this->routing as $key => $itemRaw) {
            $item = preg_quote($itemRaw, '@');
            $regexp = '@^'.preg_replace('@\\\{.+\}@Umsi', '(.+)', $item).'$@';
            if(preg_match($regexp, $url, $matches)){
                $params = [];
                if(preg_match_all('@\{(.+)\}@Umsi', $itemRaw, $matches2)){
                    foreach ($matches2[1] as $k => $name) {
                        $params[$name] = $matches[$k+1];
                    }
                }

                return [
                    'name' => $key,
                    'params' => $params
                ];
            }
        }
    }
}

