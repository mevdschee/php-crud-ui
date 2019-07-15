<?php

class PHP_CRUD_UI
{
    protected $config;

    public function call($method, $url, $data = false)
    {
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
        return json_decode($response, true);
    }

    public function url($base, $subject, $action, $id = '', $field = '', $name = '')
    {
        return $base . trim("$subject/$action/$id/$field/$name", '/');
    }

    public function menu($subject, $base, $definition)
    {
        $items = array();
        if (isset($definition['tags'])) {
            foreach ($definition['tags'] as $tag) {
                $item = array(
                    'active' => $tag['name'] == $subject,
                    'name' => $tag['name'],
                    'url' => $this->url($base, $tag['name'], 'list'),
                );
                array_push($items, $item);
            }
        }
        return $items;
    }

    public function executeHome($url, $base, $definition, $method, $request)
    {
        $template = file_get_contents('../templates/home.html');
        return Template::render($template, array());
    }

    public function getDisplayColumn($columns)
    {
        // TODO: make configurable
        $names = array('name', 'title', 'description', 'username');
        foreach ($names as $name) {
            if (in_array($name, $columns)) {
                return $name;
            }

        }
        return $columns[0];
    }

    public function referenceText($subject, $record, $definition)
    {
        $properties = $this->getProperties($subject, 'read', $definition);
        $displayColumn = $this->getDisplayColumn(array_keys($properties));
        return $record[$displayColumn];
    }

    public function referenceId($subject, $record, $definition)
    {
        $properties = $this->getProperties($subject, 'read', $definition);
        $primaryKey = $this->getPrimaryKey($subject, $properties);
        return $record[$primaryKey];
    }

    public function executeList($url, $base, $definition, $method, $request)
    {
        $subject = $this->getParameter($request, 0);
        $action = $this->getParameter($request, 1);
        $field = $this->getParameter($request, 2);
        $id = $this->getParameter($request, 3);
        $name = $this->getParameter($request, 4);

        $properties = $this->getProperties($subject, $action, $definition);
        $references = $this->getReferences($subject, $properties);
        $referenced = $this->getReferenced($subject, $properties);
        $primaryKey = $this->getPrimaryKey($subject, $properties);

        $related = !empty(array_merge(array_filter($referenced), array_filter($references)));

        list($pageNumber, $pageSize) = explode(',', @$_GET['page'] ?: '1,5', 2);

        $args = array();
        if ($field) {
            $args['filter'] = $field . ',eq,' . $id;
        }
        $args['join'] = array_values(array_filter($references));
        $args['page'] = "$pageNumber,$pageSize";
        $urlArgs = rtrim('?' . preg_replace('|%5B[0-9]+%5D|', '', http_build_query($args)), '?');
        $data = $this->call('GET', $url . '/records/' . urlencode($subject) . $urlArgs);

        $html = '<h2>' . $subject . ': list</h2>';

        if ($field) {
            $href = $this->url($base, $subject, 'list');
            $html .= '<div class="well well-sm"><div style="float:right;">';
            $html .= '<a class="btn btn-default btn-xs" href="' . $href . '">Clear filter</a>';
            $html .= '</div>Filtered by: ' . $field . ' = ' . $name . '</div>';
        }

        $html .= '<table class="table">';
        $html .= '<thead><tr>';
        if ($primaryKey) {
            $html .= '<th>actions</th>';
        }
        foreach (array_keys($properties) as $column) {
            $html .= '<th>' . $column . '</th>';
        }
        $html .= '</tr></thead><tbody>';
        foreach ($data['records'] as $record) {
            $html .= '<tr>';
            if ($primaryKey) {
                $html .= '<td>';
                $href = $this->url($base, $subject, 'read', $record[$primaryKey]);
                $html .= '<a class="btn btn-default btn-xs" href="' . $href . '">view</a> ';
                $html .= '</td>';
            }
            foreach ($record as $key => $value) {
                $html .= '<td>';
                if ($references[$key]) {
                    $html .= htmlentities($this->referenceText($references[$key], $record[$key], $definition));
                } else {
                    $html .= htmlentities($value);
                }
                $html .= '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody></table>';

        $maxPage = ceil($data['results'] / $pageSize);
        if ($maxPage > 1) {
            if ($pageNumber - 1 >= 1) {
                $href = '?page=' . ($pageNumber - 1) . ',' . $pageSize;
                $html .= '<a href="' . $href . '" class="btn btn-default">Prev</a> ';
            } else {
                $html .= '<a href="javascript:void(0);" class="btn btn-default" disabled>Prev</a> ';
            }
            $html .= "$pageNumber / $maxPage ";
            if ($pageNumber + 1 <= $maxPage) {
                $href = '?page=' . ($pageNumber + 1) . ',' . $pageSize;
                $html .= '<a href="' . $href . '" class="btn btn-default">Next</a> ';
            } else {
                $html .= '<a href="javascript:void(0);" class="btn btn-default" disabled>Next</a> ';
            }
        }

        if ($primaryKey) {
            $href = $this->url($base, $subject, 'create');
            $html .= '<a href="' . $href . '" class="btn btn-primary">Add</a> ';
        }

        if ($related) {
            $html .= '<br/><br/><h4>Related</h4>';
            $html .= '<ul>';
            foreach ($references as $field => $relation) {
                if ($relation) {
                    $href = $this->url($base, $relation, 'list');
                    $html .= '<li><a href="' . $href . '">' . $relation . '</a></li>';
                }
            }
            foreach ($referenced as $relation) {
                $href = $this->url($base, $relation[0], 'list');
                $html .= '<li><a href="' . $href . '">' . $relation[0] . '</a></li>';
            }
            $html .= '</ul>';
        }

        return $html;
    }

    public function selectSubject($url, $subject, $name, $value, $definition)
    {
        $properties = $this->getProperties($subject, 'list', $definition);
        $references = $this->getReferences($subject, $properties);
        $primaryKey = $this->getPrimaryKey($subject, $properties);

        $data = $this->call('GET', $url . '/records/' . urlencode($subject));

        $displayColumn = $this->getDisplayColumn(array_keys($properties));

        $html = '<select id="' . $name . '" name="' . $name . '" class="form-control">';
        $html .= '<option value=""></option>';
        foreach ($data['records'] as $record) {
            $selected = $record[$primaryKey] == $value ? ' selected' : '';
            $html .= '<option value="' . $record[$primaryKey] . '"' . $selected . '>';
            if ($displayColumn === false) {
                $text = '';
                $first = true;
                foreach ($record as $column => $value) {
                    if (!$references[$column] && $column != $primaryKey) {
                        if (!$first) {
                            $text .= ' - ';
                        }

                        $text .= $value;
                        $first = false;
                    }
                }
                $html .= $text;
            } else {
                $html .= $record[$displayColumn];
            }
            $html .= '</option>';
        }
        $html .= '</select>';
        return $html;
    }

    public function executeAdd($url, $base, $definition, $method, $request, $post)
    {
        $subject = $this->getParameter($request, 0);
        $action = $this->getParameter($request, 1);

        if ($method == 'POST') {
            $this->call('POST', $url . '/records/' . urlencode($subject), json_encode($post));
            return '<p>Added</p>';
        }

        $properties = $this->getProperties($subject, $action, $definition);
        $references = $this->getReferences($subject, $properties);
        $referenced = $this->getReferenced($subject, $properties);
        $primaryKey = $this->getPrimaryKey($subject, $properties);

        $html = '<h2>' . $subject . ': create</h2>';
        $html .= '<form method="post">';
        $data = array_keys($properties);

        foreach ($data as $column) {
            $html .= '<div class="form-group">';
            $html .= '<label for="' . $column . '">' . $column . '</label>';
            if ($references[$column]) {
                $html .= $this->selectSubject($url, $references[$column], $column, false, $definition);
            } else {
                $disabled = $column == $primaryKey ? ' disabled' : '';
                $html .= '<input class="form-control" id="' . $column . '" name="' . $column . '" value=""' . $disabled . '/>';
            }
            $html .= '</div>';
        }
        $html .= '<button type="submit" class="btn btn-primary">Save</button>';
        $html .= '</form>';
        return $html;
    }

    public function executeView($url, $base, $definition, $method, $request)
    {
        $subject = $this->getParameter($request, 0);
        $action = $this->getParameter($request, 1);
        $id = $this->getParameter($request, 2);

        $properties = $this->getProperties($subject, $action, $definition);
        $references = $this->getReferences($subject, $properties);
        $referenced = $this->getReferenced($subject, $properties);
        $primaryKey = $this->getPrimaryKey($subject, $properties);

        $related = !empty(array_merge(array_filter($referenced), array_filter($references)));

        $args = array();
        $args['join'] = array_values(array_filter($references));
        $urlArgs = rtrim('?' . preg_replace('|%5B[0-9]+%5D|', '', http_build_query($args)), '?');
        $record = $this->call('GET', $url . '/records/' . urlencode($subject) . '/' . $id . $urlArgs);

        $html = '<h2>' . $subject . ': view</h2>';
        $html .= '<table class="table">';
        $html .= '<thead><tr><th>action</th><th>key</th><th>value</th>';
        $html .= '</tr></thead><tbody>';
        foreach ($record as $key => $value) {
            $html .= '<tr>';
            $html .= '<td>';
            if ($references[$key]) {
                $id = $this->referenceId($references[$key], $record[$key], $definition);
                $href = $this->url($base, $references[$key], 'read', $id);
                $html .= '<a class="btn btn-default btn-xs" href="' . $href . '">view</a>';
            } else {
                $html .= '&nbsp;';
            }
            $html .= '</td>';
            $html .= '<td>' . $key . '</td>';
            $html .= '<td>';
            if ($references[$key]) {
                $html .= htmlentities($this->referenceText($references[$key], $record[$key], $definition));
            } else {
                $html .= htmlentities($value);
            }
            $html .= '</td>';
            $html .= '</tr>';
        }
        $html .= '</tbody></table>';

        $href = $this->url($base, $subject, 'update', $record[$primaryKey]);
        $html .= '<a class="btn btn-primary" href="' . $href . '">Edit</a> ';
        $href = $this->url($base, $subject, 'delete', $record[$primaryKey]);
        $html .= '<a class="btn btn-danger" href="' . $href . '">Delete</a> ';

        if ($related) {
            $html .= '<br/><br/><h4>Related</h4>';
            $html .= '<ul>';
            foreach ($references as $field => $relation) {
                if ($relation) {
                    $href = $this->url($base, $relation, 'list');
                    $html .= '<li><a href="' . $href . '">' . $relation . '</a></li>';
                }
            }
            foreach ($referenced as $i => $relation) {
                $name = $this->referenceText($subject, $record, $definition);
                $href = $this->url($base, $relation[0], 'list', $relation[1], $record[$primaryKey], $name);
                $html .= '<li><a href="' . $href . '">' . $relation[0] . ' (filtered)</a></li>';
            }
            $html .= '</ul>';
        }

        return $html;
    }

    public function executeEdit($url, $base, $definition, $method, $request, $post)
    {
        $subject = $this->getParameter($request, 0);
        $action = $this->getParameter($request, 1);
        $id = $this->getParameter($request, 2);

        if ($method == 'POST') {
            $result = $this->call('PUT', $url . '/records/' . urlencode($subject) . '/' . $id, json_encode($post));
            $succeeded = $result ? 'succeeded' : 'failed';
            $html = "<p>Update $succeeded</p>";
            $href = $this->url($base, $subject, 'read', $id);
            $html .= ' <a href="' . $href . '" class="btn btn-primary">Ok</a>';
            return $html;
        }

        $properties = $this->getProperties($subject, $action, $definition);
        $references = $this->getReferences($subject, $properties);
        $referenced = $this->getReferenced($subject, $properties);
        $primaryKey = $this->getPrimaryKey($subject, $properties);

        $data = $this->call('GET', $url . '/records/' . urlencode($subject) . '/' . $id);
        $html = '<h2>' . $subject . ': edit</h2>';
        $html .= '<form method="post">';
        foreach ($data as $column => $value) {
            $html .= '<div class="form-group">';
            $html .= '<label for="' . $column . '">' . $column . '</label>';
            if ($references[$column]) {
                $html .= $this->selectSubject($url, $references[$column], $column, $value, $definition);
            } else {
                $readonly = $column == $primaryKey ? ' readonly' : '';
                $html .= '<input class="form-control" id="' . $column . '" name="' . $column . '" value="' . htmlentities($value) . '"' . $readonly . '/>';
            }
            $html .= '</div>';
        }
        $html .= '<button type="submit" class="btn btn-primary">Save</button>';
        $html .= '</form>';
        return $html;
    }

    public function executeDelete($url, $base, $definition, $method, $request)
    {
        $subject = $this->getParameter($request, 0);
        $action = $this->getParameter($request, 1);
        $id = $this->getParameter($request, 2);

        if ($method == 'POST') {
            $result = $this->call('DELETE', $url . '/records/' . urlencode($subject) . '/' . $id);
            $succeeded = $result ? 'succeeded' : 'failed';
            $html = "<p>Delete $succeeded</p>";
            $href = $this->url($base, $subject, 'list');
            $html .= ' <a href="' . $href . '" class="btn btn-primary">Ok</a>';
            return $html;
        }

        $properties = $this->getProperties($subject, 'read', $definition);
        $primaryKey = $this->getPrimaryKey($subject, $properties);

        $html = '<h2>' . $subject . ': delete #' . $id . '</h2>';
        $html .= '<p>The action cannot be undone.</p>';
        $html .= '<form method="post">';
        $html .= '<input type="hidden" name="' . $primaryKey . '" value="' . $id . '"/>';
        $html .= '<button type="submit" class="btn btn-danger">Delete</button>';
        $href = $this->url($base, $subject, 'read', $id);
        $html .= ' <a href="' . $href . '" class="btn btn-default">Cancel</a>';
        $html .= '</form>';
        return $html;
    }

    public function resolve($definition, $path)
    {
        while (null !== ($element = array_shift($path))) {
            //echo '"'.$element.'",';
            if (!isset($definition[$element])) {
                return false;
            }

            $definition = $definition[$element];
        }
        return $definition;
    }

    public function getProperties($subject, $action, $definition)
    {
        if (!$subject || !$definition) {
            return false;
        }
        if ($action == 'list') {
            $path = array('components', 'schemas', $action . '-' . $subject, 'properties', 'records', 'items', 'properties');
        } else {
            $path = array('components', 'schemas', $action . '-' . $subject, 'properties');
        }
        return $this->resolve($definition, $path);
    }

    public function getReferences($subject, $properties)
    {
        if (!$subject || !$properties) {
            return false;
        }

        $references = array();
        foreach ($properties as $field => $property) {
            $references[$field] = isset($property['x-references']) ? $property['x-references'] : false;
        }
        return $references;
    }

    public function getReferenced($subject, $properties)
    {
        if (!$subject || !$properties) {
            return false;
        }

        $referenced = array();
        foreach ($properties as $field => $property) {
            if (isset($property['x-referenced'])) {
                $referenced = array_merge($referenced, $property['x-referenced']);
            }
        }
        for ($i = 0; $i < count($referenced); $i++) {
            $referenced[$i] = explode('.', $referenced[$i]);
        }
        return $referenced;
    }

    public function getPrimaryKey($subject, $properties)
    {
        if (!$subject || !$properties) {
            return false;
        }

        foreach ($properties as $field => $property) {
            if (isset($property['x-primary-key'])) {
                return $field;
            }
        }
        return false;
    }

    public function __construct($config)
    {
        $this->config = $config;
    }

    protected function getUrl($config)
    {
        if (isset($config['url'])) {
            return $config['url'];
        }
        return null;
    }

    protected function getBase($config, $request)
    {
        if (isset($config['base'])) {
            return $config['base'];
        }
        @list($path, $query) = explode('?', $_SERVER['REQUEST_URI'], 2);
        $count = $request ? (-1 * strlen($request)) : strlen(urldecode($path));
        return rtrim(substr(urldecode($path), 0, $count), '/') . '/';
    }

    protected function getDefinition($config, $url)
    {
        if (isset($config['definition'])) {
            return $config['definition'];
        }
        $definition = $this->call('GET', $url . '/openapi');
        $_SESSION['definition'] = $definition;
        return $definition;
    }

    protected function getMethod($config)
    {
        if (isset($config['method'])) {
            return $config['method'];
        }
        return $_SERVER['REQUEST_METHOD'];
    }

    protected function getRequest($config)
    {
        if (isset($config['request'])) {
            return trim($config['request'], '/');
        }
        $request = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
        if (!$request) {
            $request = isset($_SERVER['ORIG_PATH_INFO']) ? $_SERVER['ORIG_PATH_INFO'] : '';
        }
        return trim($request, '/');
    }

    protected function getPost($config)
    {
        if (isset($config['post'])) {
            return $config['post'];
        }
        return $_POST;
    }

    protected function getParameter($request, $position)
    {
        if (!$request) {
            return false;
        }
        $parameters = explode('/', $request);
        return isset($parameters[$position]) ? $parameters[$position] : '';
    }

    public function executeCommand()
    {
        $config = $this->config;

        $url = $this->getUrl($config);
        $request = $this->getRequest($config);
        $base = $this->getBase($config, $request);
        $definition = $this->getDefinition($config, $url);
        $method = $this->getMethod($config);
        $post = $this->getPost($config);

        $subject = $this->getParameter($request, 0);
        $action = $this->getParameter($request, 1);

        $content = '';
        $menu = $this->menu($subject, $base, $definition);

        switch ($action) {
            case '':
                $content = $this->executeHome($url, $base, $definition, $method, $request);
                break;
            case 'read':
                $content = $this->executeView($url, $base, $definition, $method, $request);
                break;
            case 'create':
                $content = $this->executeAdd($url, $base, $definition, $method, $request, $post);
                break;
            case 'update':
                $content = $this->executeEdit($url, $base, $definition, $method, $request, $post);
                break;
            case 'delete':
                $content = $this->executeDelete($url, $base, $definition, $method, $request);
                break;
            case 'list':
                $content = $this->executeList($url, $base, $definition, $method, $request);
                break;
        }

        $template = file_get_contents('../templates/layout.html');
        return Template::render($template, array('menu' => $menu, 'content' => $content));
    }
}

//session_start();
//$ui = new PHP_CRUD_UI(array(
//    'url' => 'http://localhost:8000/api.php',
//));
//echo $ui->executeCommand();
