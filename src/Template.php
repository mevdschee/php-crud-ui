<?php

class Template
{
    public static function render($template, $data, $functions = array())
    {
        $tokens = Template::tokenize($template);
        $tree = Template::createSyntaxTree($tokens);
        return Template::renderChildren($tree, $data, $functions);
    }

    private static function createNode($type, $expression)
    {
        return (object) array('type' => $type, 'expression' => $expression, 'children' => array(), 'value' => null);
    }

    private static function tokenize($template)
    {
        $parts = ['', $template];
        $tokens = [];
        while (true) {
            $parts = explode('{{', $parts[1], 2);
            $tokens[] = $parts[0];
            if (count($parts) != 2) {
                break;
            }
            $parts = explode('}}', $parts[1], 2);
            $tokens[] = $parts[0];
            if (count($parts) != 2) {
                break;
            }
        }
        return $tokens;
    }

    private static function createSyntaxTree(&$tokens)
    {
        $root = Template::createNode('root', false);
        $current = $root;
        $stack = array();
        foreach ($tokens as $i => $token) {
            if ($i % 2 == 1) {
                if ($token == 'endif') {
                    $type = 'endif';
                    $expression = false;
                } elseif ($token == 'endfor') {
                    $type = 'endfor';
                    $expression = false;
                } elseif ($token == 'else') {
                    $type = 'else';
                    $expression = false;
                } elseif (substr($token, 0, 3) == 'if:') {
                    $type = 'if';
                    $expression = substr($token, 3);
                } elseif (substr($token, 0, 4) == 'for:') {
                    $type = 'for';
                    $expression = substr($token, 4);
                } else {
                    $type = 'var';
                    $expression = $token;
                }
                if (in_array($type, array('endif', 'endfor', 'else'))) {
                    if (count($stack)) {
                        $current = array_pop($stack);
                    }
                }
                if (in_array($type, array('if', 'for', 'var', 'else'))) {
                    $node = Template::createNode($type, $expression);
                    array_push($current->children, $node);
                }
                if (in_array($type, array('if', 'for', 'else'))) {
                    array_push($stack, $current);
                    $current = $node;
                }
            } else {
                array_push($current->children, Template::createNode('lit', $token));
            }
        }
        return $root;
    }

    private static function renderChildren($node, $data, $functions)
    {
        $result = '';
        $previousChild = null;
        foreach ($node->children as $child) {
            switch ($child->type) {
                case 'if':
                    $result .= Template::renderIfNode($child, $data, $functions);
                    break;
                case 'else':
                    $result .= Template::renderElseNode($child, $previousChild, $data, $functions);
                    break;
                case 'for':
                    $result .= Template::renderForNode($child, $data, $functions);
                    break;
                case 'var':
                    $result .= Template::renderVarNode($child, $data, $functions);
                    break;
                case 'lit':
                    $result .= $child->expression;
                    break;
            }
            $previousChild = $child;
        }
        return $result;
    }

    private static function renderIfNode($node, $data, $functions)
    {
        $parts = explode('|', $node->expression);
        $path = array_shift($parts);
        try {
            $value = Template::resolvePath($path, $data);
            $value = Template::applyFunctions($value, $parts, $functions);
        } catch (\Throwable $e) {
            return '{{if:' . $node->expression . '!!' . $e->getMessage() . '}}';
        }
        $result = '';
        if ($value) {
            $result .= Template::renderChildren($node, $data, $functions);
            $node->value = $value;
        }
        return $result;
    }

    private static function renderElseNode($node, $previousNode, $data, $functions)
    {
        if ($previousNode->type != 'if') {
            return "{{else!!could not find matching 'if'}}";
        }
        $result = '';
        if (!$previousNode->value) {
            $result .= Template::renderChildren($node, $data, $functions);
        }
        return $result;
    }

    private static function renderForNode($node, $data, $functions)
    {
        $parts = explode('|', $node->expression);
        $path = array_shift($parts);
        $path = explode(':', $path, 3);
        if (count($path) == 2) {
            list($var, $path) = $path;
            $key = false;
        } elseif (count($path) == 3) {
            list($var, $key, $path) = $path;
        } else {
            return '{{for:' . $node->expression . '!!' . "for must have 'for:var:array' format" . '}}';
        }
        try {
            $value = Template::resolvePath($path, $data);
            $value = Template::applyFunctions($value, $parts, $functions);
        } catch (\Throwable $e) {
            return '{{for:' . $node->expression . '!!' . $e->getMessage() . '}}';
        }
        if (!is_array($value)) {
            return '{{for:' . $node->expression . '!!' . "expression must evaluate to an array" . '}}';
        }
        $result = '';
        foreach ($value as $k => $v) {
            $data = array_merge($data, $key ? [$var => $v, $key => $k] : [$var => $v]);
            $result .= Template::renderChildren($node, $data, $functions);
        }
        return $result;
    }

    private static function renderVarNode($node, $data, $functions)
    {
        $parts = explode('|', $node->expression);
        $path = array_shift($parts);
        try {
            $value = Template::resolvePath($path, $data);
            $value = Template::applyFunctions($value, $parts, $functions);
        } catch (\Throwable $e) {
            return '{{' . $node->expression . '!!' . $e->getMessage() . '}}';
        }
        return $value;
    }

    private static function resolvePath($path, $data)
    {
        $current = $data;
        foreach (explode('.', $path) as $p) {
            if (!array_key_exists($p, $current)) {
                throw new \Exception("path '$p' not found");
            }
            $current = &$current[$p];
        }
        return $current;
    }

    private static function applyFunctions($value, $parts, $functions)
    {
        foreach ($parts as $part) {
            $function = explode('(', rtrim($part, ')'));
            $f = $function[0];
            $arguments = isset($function[1]) ? explode(',', $function[1]) : array();
            array_unshift($arguments, $value);
            if (isset($functions[$f])) {
                $value = call_user_func_array($functions[$f], $arguments);
            } else {
                throw new \Exception("function '$f' not found");
            }
        }
        return $value;
    }

}
