<?php

class PHP_CRUD_UI {

    protected $settings;
    
    function call($method, $url, $data = false) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_URL, $url);
        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Content-Length: ' . strlen($data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response,true);
    }

    function url($base,$subject,$action,$id='',$field='') {
        return $base.trim("$subject/$action/$id/$field",'/');
    }

    function menu($parameters) {
        extract($parameters);
        
        $html= '<ul class="nav nav-pills nav-stacked">';
        foreach ($definition['tags'] as $tag) {
            $active = $tag['name']==$subject?' class="active"':'';
            $html.= '<li'.$active.'><a href="'.$this->url($base,$tag['name'],'list').'">'.$tag['name'].'</a></li>';
        }
        $html.= '</ul>';
        return $html;
    }

    function home($parameters) {
        extract($parameters);
        
        $html = 'Nothing';
        return $html;
    }

    function head() {
        $html = '<!DOCTYPE html><html lang="en">';
        $html.= '<head><title>PHP-CRUD-UI</title>';
        $html.= '<meta name="viewport" content="width=device-width, initial-scale=1">';
        $html.= '<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">';
        $html.= '<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" rel="stylesheet">';
        $html.= '</head><body><div class="container">';
        $html.= '<div class="row">';
        $html.= '<div class="col-md-3"><h3>PHP-CRUD-UI</h3></div>';
        $html.= '</div>';
        return $html;
    }

    function foot() {
        $html = '</div></body></html>';
        return $html;
    }

    function displayColumn($columns) {
        // TODO: make configurable
        $names = array('name','title','description','username');
        foreach ($names as $name) {
            if (isset($columns[$name])) return $columns[$name];
        }
        return false;
    }


    function referenceText($subject,$data,$field,$id,$definition) {
        $properties = $this->properties($subject,'read',$definition);
        $references = $this->references($subject,$properties);
        $referenced = $this->referenced($subject,$properties);
        $primaryKey = $this->primaryKey($subject,$properties);
        
        $indices = array_flip($data[$subject]['columns']);
        $displayColumn = $this->displayColumn($indices);
        
        $records = $data[$subject]['records'];
        foreach ($records as $record) {
            if ($record[$indices[$field]]==$id) {
                if ($displayColumn===false) {
                    $text = '';
                    $first = true;
                    foreach ($record as $i=>$value) {
                        if (!$references[$i] && $i!=$primaryKey) {
                            if (!$first) $text.= ' - ';
                            $text.= $value;
                            $first = false;
                        }
                    } 
                    return $text;
                } else {
                    return $record[$displayColumn];
                }
            }
        }
        return false;
    }

    function listRecords($parameters) {
        extract($parameters);
        
        $properties = $this->properties($subject,$action,$definition);
        $references = $this->references($subject,$properties);
        $referenced = $this->referenced($subject,$properties);
        $primaryKey = $this->primaryKey($subject,$properties);
        
        $related = !empty(array_filter($referenced));
        
        $args = array();
        if ($field) {
            $args['filter']=$field.',eq,'.$id;
        }
        $include = implode(',',array_filter(array_map(function($v){ return $v[0]; },$references)));
        if ($include) {
            $args['include']=$include; 
        }
        $data = $this->call('GET',$url.'/'.$subject.'?'.http_build_query($args));
        
        $html = '<h4>'.$subject.': list</h4>';
        if ($field) {
            $html .= '<div class="alert alert-info" role="alert">Filtered where "'.$field.'" = "'.$id.'".';
            $href = $this->url($base,$subject,'list');
            $html .= '<div style="float:right;"><a href="'.$href.'">Show all</a></div></div>';
        }    
        $html.= '<table class="table">';
        $html.= '<thead><tr>';
        foreach ($data[$subject]['columns'] as $i=>$column) {
            $html.= '<th>'.$column.'</th>';
        }
        if ($related) {
            $html.= '<th>related</th>';
        }
        $html.= '<th>actions</th>';
        $html.= '</tr></thead><tbody>';
        foreach ($data[$subject]['records'] as $record) {
            $html.= '<tr>';
            foreach ($record as $i=>$value) {
                if ($references[$i]) {
                    $html.= '<td>';
                    $href = $this->url($base,$references[$i][0],'list',$value,$references[$i][1]);
                    $html.= '<a href="'.$href.'">';
                    $html.= $this->referenceText($references[$i][0],$data,$references[$i][1],$value,$definition);
                    $html.= '</a>';
                    $html.= '</td>';
                } else {
                    $html.= '<td>'.$value.'</td>';
                }
            }
            if ($related) {
                $html.= '<td>';
                foreach ($referenced as $i=>$relations) {
                    $id = $record[$i];
                    if ($relations) foreach ($relations as $j=>$relation) {
                        if ($j) $html.= ', ';
                        $href = $this->url($base,$relation[0],'list',$id,$relation[1]); 
                        $html.= '<a href="'.$href.'">'.$relation[0].'</a>';
                    }
                }
                $html.= '</td>';
            }
            $html.= '<td>';
            $href = $this->url($base,$subject,'edit',$record[$primaryKey]);
            $html.= '<a href="'.$href.'">edit</a>';
            $href = $this->url($base,$subject,'delete',$record[$primaryKey]);
            $html.= ' | ';
            $html.= '<a href="'.$href.'">delete</a>';
            $html.= '</td>';
            $html.= '</tr>';
        }
        $html.= '</tbody></table>';
        $href = $this->url($base,$subject,'add');
        $html.= '<p><a href="'.$href.'" class="btn btn-primary">Add</a></p>';
        return $html;
    }

    function selectSubject($url,$subject,$name,$value,$definition) {
        $properties = $this->properties($subject,'list',$definition);
        $references = $this->references($subject,$properties);
        $primaryKey = $this->primaryKey($subject,$properties);
        
        $data = $this->call('GET',$url.'/'.$subject);
        
        $indices = array_flip($data[$subject]['columns']);
        $displayColumn = $this->displayColumn($indices);
        
        $html = '<select id="'.$name.'" name="'.$name.'" class="form-control">';
        $html.= '<option value=""></option>';
        foreach ($data[$subject]['records'] as $record) {
            $selected = $record[$primaryKey]==$value?' selected':'';
            $html.= '<option value="'.$record[$primaryKey].'"'.$selected.'>';
            if ($displayColumn===false) {
                $text = '';
                $first = true;
                foreach ($record as $i=>$field) {
                    if (!$references[$i] && $i!=$primaryKey) {
                        if (!$first) $text.= ' - ';
                        $text.= $field;
                        $first = false;
                    }
                } 
                $html.= $text;
            } else {
                $html.= $record[$displayColumn];
            }
            $html.= '</option>';
        }
        $html.= '</select>';
        return $html;
    }

    function addRecord($parameters) {
        extract($parameters);
        
        $properties = $this->properties($subject,$action,$definition);
        $references = $this->references($subject,$properties);
        $referenced = $this->referenced($subject,$properties);
        $primaryKey = $this->primaryKey($subject,$properties);
        
        $html = '<h4>'.$subject.': add</h4>';
        $html.= '<form method="post">';
        $data = array_keys($properties);
        
        foreach ($data as $i=>$column) {
            $html.= '<div class="form-group">';
            $html.= '<label for="'.$column.'">'.$column.'</label>';
            if ($references[$i]) {
                $html.= $this->selectSubject($url,$references[$i][0],$column,$field,$definition);
            } else {
                $disabled = $i==$primaryKey?' disabled':'';
                $html.= '<input class="form-control" id="'.$column.'" name="'.$column.'" value=""'.$disabled.'/>';
            }
            $html.= '</div>';
        }
        $html.= '<button type="submit" class="btn btn-primary">Save</button>';
        $html.= '</form>';
        return $html;
    }
    
    function editRecord($parameters) {
        extract($parameters);
        
        $properties = $this->properties($subject,$action,$definition);
        $references = $this->references($subject,$properties);
        $referenced = $this->referenced($subject,$properties);
        $primaryKey = $this->primaryKey($subject,$properties);
        
        $data = $this->call('GET',$url.'/'.$subject.'/'.$id);
        $html = '<h4>'.$subject.': edit</h4>';
        $html.= '<form method="post">';
        $i=0;
        foreach ($data as $column=>$field) {
            $html.= '<div class="form-group">';
            $html.= '<label for="'.$column.'">'.$column.'</label>';
            if ($references[$i]) {
                $html.= $this->selectSubject($url,$references[$i][0],$column,$field,$definition);
            } else {
                $readonly = $i==$primaryKey?' readonly':'';
                $html.= '<input class="form-control" id="'.$column.'" name="'.$column.'" value="'.$field.'"'.$readonly.'/>';
            }
            $html.= '</div>';
            $i++;
        }
        $html.= '<button type="submit" class="btn btn-primary">Save</button>';
        $html.= '</form>';
        return $html;
    }

    function confirmDelete($parameters) {
        extract($parameters);
        
        $properties = $this->properties($subject,$action,$definition);
        $references = $this->references($subject,$properties);
        $referenced = $this->referenced($subject,$properties);
        $primaryKey = $this->primaryKey($subject,$properties);
        
        $data = $this->call('GET',$url.'/'.$subject.'/'.$id);
        $html = '<h4>Are you sure?</h4>';
        $html.= '<form method="post">';
        $i=0;
        foreach ($data as $column=>$field) {
            if ($i==$primaryKey) {
                $html.= '<input type="hidden" name="'.$column.'" value="'.$field.'"/>';
            }
            $i++;
        }
        $html.= '<button type="submit" class="btn btn-primary">Yes</button>';
        $href = $this->url($base,$subject,'list');
        $html.= ' <a href="'.$href.'" class="btn btn-default">Cancel</a>';
        $html.= '</form>';
        return $html;
    }

    function deleteRecord($parameters) {
        extract($parameters);

        $this->call('DELETE',$url.'/'.$subject.'/'.$id);
        return '<p>Deleted</p>';
    }

    function updateRecord($parameters) {
        extract($parameters);

        $this->call('PUT',$url.'/'.$subject.'/'.$id,json_encode($post));
        return '<p>Updated</p>';
    }
    
    function insertRecord($parameters) {
        extract($parameters);

        $this->call('POST',$url.'/'.$subject,json_encode($post));
        return '<p>Added</p>';
    }

    function get_properties($definition,$path) {
        while (null!==($element = array_shift($path))) {
            //echo '"'.$element.'",';
            if (!isset($definition[$element])) return false;
            $definition = $definition[$element];
        }
        return $definition;
    }

    function properties($subject,$action,$definition) {
        if (!$subject || !$definition) return false;
        switch ($action) {
            case 'list': $path = array('paths','/'.$subject,'get','responses','200','schema','items','properties'); break;
            case 'read': $path = array('paths','/'.$subject.'/{id}','get','responses','200','schema','properties'); break;
            case 'add' : $path = array('paths','/'.$subject,'post','parameters',0,'schema','properties'); break;
            case 'edit': $path = array('paths','/'.$subject.'/{id}','put','parameters',1,'schema','properties'); break;
            case 'delete': $path = array('paths','/'.$subject.'/{id}','delete','parameters',1,'schema','properties'); break;
        }
        return $this->get_properties($definition,$path);
    }

    function references($subject,$properties) {
        if (!$subject || !$properties) return false;
        $references = array();
        foreach ($properties as $field=>$property) {
            $references[] = isset($property['x-references'])?$property['x-references']:false;
        }
        return $references;
    }

    function referenced($subject,$properties) {
        if (!$subject || !$properties) return false;
        $referenced = array();
        foreach ($properties as $field=>$property) {
            $referenced[] = isset($property['x-referenced'])?$property['x-referenced']:false;
        }
        return $referenced;
    }

    function primaryKey($subject,$properties) {
        if (!$subject || !$properties) return false;
        $i = 0;
        foreach ($properties as $field=>$property) {
            if (isset($property['x-primary-key'])) return $i;
            $i++;
        }
        return false;
    }
    
    public function __construct($config) {
        extract($config);
        
        // initialize
        $url = isset($url)?$url:null;
        
        $base = isset($base)?$base:null;
        $definition = isset($definition)?$definition:null;
        $method = isset($method)?$method:null;
        $request = isset($request)?$request:null;
        $get = isset($get)?$get:null;
        $post = isset($post)?$post:null;
        
        // defaults
        if (!$definition) {
            $definition = isset($_SESSION['definition'])?$_SESSION['definition']:null;
            if (!$definition) {
                $definition = $this->call('GET',$url);
                $_SESSION['definition'] = $definition;
            }
        }
        if (!$method) {
            $method = $_SERVER['REQUEST_METHOD'];
        }
        if (!$request) {
            $request = isset($_SERVER['PATH_INFO'])?$_SERVER['PATH_INFO']:'';
            if (!$request) {
                $request = isset($_SERVER['ORIG_PATH_INFO'])?$_SERVER['ORIG_PATH_INFO']:'';
            }
        }
        if (!$get) {
            $get = $_GET;
        }
        if (!$post) {
            $post = $_POST;
        }
                
        $request = trim($request,'/');

        if (!$base) {
            $count = $request?(-1*strlen($request)):strlen($_SERVER['REQUEST_URI']);
            $base = rtrim(substr($_SERVER['REQUEST_URI'],0,$count),'/').'/';
        }
        
        $this->settings = compact('url', 'base', 'definition', 'method', 'request', 'get', 'post');
    }
    
    protected function parseRequestParameter(&$request,$characters) {
        if (!$request) return false;
        $pos = strpos($request,'/');
        $value = $pos?substr($request,0,$pos):$request;
        $request = $pos?substr($request,$pos+1):'';
        if (!$characters) return $value;
        return preg_replace("/[^$characters]/",'',$value);
    }
    
    protected function getParameters($settings) {
        extract($settings);

        $subject   = $this->parseRequestParameter($request, 'a-zA-Z0-9\-_');
        $action    = $this->parseRequestParameter($request, 'a-zA-Z0-9\-_');
        $id        = $this->parseRequestParameter($request, 'a-zA-Z0-9\-_');
        $field     = $this->parseRequestParameter($request, 'a-zA-Z0-9\-_');

        return compact('url','base','definition','method','subject','action','id','field','get','post');
    }
    
    function executeCommand() {
        $parameters = $this->getParameters($this->settings);
        
        $html = $this->head();
        $html.= '<div class="row">';
        $html.= '<div class="col-md-3">';
        $html.= $this->menu($parameters);
        $html.= '</div>';
        
        $html.= '<div class="col-md-9">';
        $action = $parameters['method'].'.'.($parameters['action']?:'home');
        switch($action){
            case 'GET.home':  $html.= $this->home($parameters); break;
            case 'GET.list':  $html.= $this->listRecords($parameters); break;
            case 'GET.add':   $html.= $this->addRecord($parameters); break;
            case 'GET.edit':  $html.= $this->editRecord($parameters); break;
            case 'GET.delete': $html.= $this->confirmDelete($parameters); break;
            case 'POST.add':  $html.= $this->insertRecord($parameters); break;
            case 'POST.edit': $html.= $this->updateRecord($parameters); break;
            case 'POST.delete': $html.= $this->deleteRecord($parameters); break;
        }
        $html.= '</div>';
        
        $html.= '</div>';
        $html.= $this->foot();
        return $html;
    }
}

//session_start();
//$ui = new PHP_CRUD_UI(array(
//    'url' => 'http://localhost/api.php',
//));
//echo $ui->executeCommand();