<?php

namespace Tqdev\PhpCrudUi\Template;

class Template
{
    private $escape;
    private $functions;

    public function __construct(string $escape, array $functions)
    {
        $this->escape = $escape;
        $this->functions = $functions;
    }

    private function escape(string $string): string
    {
        switch ($this->escape) {
            case 'html':
                return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
        }
        return $string;
    }

    public function render(string $template, array $data): TemplateString
    {
        $tokens = $this->tokenize($template);
        $tree = $this->createSyntaxTree($tokens);
        $string = $this->renderChildren($tree, $data);
        return new TemplateString($string);
    }

    private function createNode(string $type, string $expression)/*: object*/
    {
        return (object) array('type' => $type, 'expression' => $expression, 'children' => array(), 'value' => null);
    }

    private function tokenize(string $template): array
    {
        $parts = ['', $template];
        $tokens = [];
        while (true) {
            $parts = explode('{{', $parts[1], 2);
            $tokens[] = $parts[0];
            if (count($parts) != 2) {
                break;
            }
            $parts = $this->explode('}}', $parts[1], 2);
            $tokens[] = $parts[0];
            if (count($parts) != 2) {
                break;
            }
        }
        return $tokens;
    }

    // performance optimization possible?
    private function explode(string $separator, string $str, int $count = -1): array
    {
        $tokens = [];
        $token = '';
        $quote = '"';
        $escape = '\\';
        $escaped = false;
        $quoted = false;
        for ($i = 0; $i < strlen($str); $i++) {
            $c = $str[$i];
            if (!$quoted) {
                if ($c == $quote) {
                    $quoted = true;
                } elseif (substr($str, $i, strlen($separator)) == $separator) {
                    $tokens[] = $token;
                    if (count($tokens) == $count - 1) {
                        $token = substr($str, $i + strlen($separator));
                        break;
                    }
                    $token = '';
                    $i += strlen($separator) - 1;
                    continue;
                }
            } else {
                if (!$escaped) {
                    if ($c == $quote) {
                        $quoted = false;
                    } elseif ($c == $escape) {
                        $escaped = true;
                    }
                } else {
                    $escaped = false;
                }
            }
            $token .= $c;
        }
        $tokens[] = $token;
        return $tokens;
    }

    private function createSyntaxTree(array $tokens)/*: object*/
    {
        $root = $this->createNode('root', '');
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
                } elseif (substr($token, 0, 7) == 'elseif:') {
                    $type = 'elseif';
                    $expression = substr($token, 7);
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
                if (in_array($type, array('endif', 'endfor', 'elseif', 'else'))) {
                    if (count($stack)) {
                        $current = array_pop($stack);
                    }
                }
                if (in_array($type, array('if', 'for', 'var', 'elseif', 'else'))) {
                    $node = $this->createNode($type, $expression);
                    array_push($current->children, $node);
                }
                if (in_array($type, array('if', 'for', 'elseif', 'else'))) {
                    array_push($stack, $current);
                    $current = $node;
                }
            } else {
                array_push($current->children, $this->createNode('lit', $token));
            }
        }
        return $root;
    }

    private function renderChildren(/*object*/$node, array $data): string
    {
        $result = '';
        $ifNodes = array();
        foreach ($node->children as $child) {
            switch ($child->type) {
                case 'if':
                    $result .= $this->renderIfNode($child, $data);
                    $ifNodes = array($child);
                    break;
                case 'elseif':
                    $result .= $this->renderElseIfNode($child, $ifNodes, $data);
                    array_push($ifNodes, $child);
                    break;
                case 'else':
                    $result .= $this->renderElseNode($child, $ifNodes, $data);
                    $ifNodes = array();
                    break;
                case 'for':
                    $result .= $this->renderForNode($child, $data);
                    $ifNodes = array();
                    break;
                case 'var':
                    $result .= $this->renderVarNode($child, $data);
                    $ifNodes = array();
                    break;
                case 'lit':
                    $result .= $child->expression;
                    $ifNodes = array();
                    break;
            }
        }
        return $result;
    }

    private function renderIfNode(/*object*/$node, array $data): string
    {
        $parts = $this->explode('|', $node->expression);
        $path = array_shift($parts);
        try {
            $value = $this->resolvePath($path, $data);
            $value = $this->applyFunctions($value, $parts, $data);
        } catch (\Throwable $e) {
            return $this->escape('{{if:' . $node->expression . '!!' . $e->getMessage() . '}}');
        }
        $result = '';
        if ($value) {
            $result .= $this->renderChildren($node, $data);
        }
        $node->value = $value;
        return $result;
    }

    private function renderElseIfNode(/*object*/$node, array $ifNodes, array $data): string
    {
        if (count($ifNodes) < 1 || $ifNodes[0]->type != 'if') {
            return $this->escape("{{elseif!!could not find matching `if`}}");
        }
        $result = '';
        $value = false;
        for ($i = 0; $i < count($ifNodes); $i++) {
            $value = $value || $ifNodes[$i]->value;
        }
        if (!$value) {
            $parts = $this->explode('|', $node->expression);
            $path = array_shift($parts);
            try {
                $value = $this->resolvePath($path, $data);
                $value = $this->applyFunctions($value, $parts, $data);
            } catch (\Throwable $e) {
                return $this->escape('{{elseif:' . $node->expression . '!!' . $e->getMessage() . '}}');
            }
            if ($value) {
                $result .= $this->renderChildren($node, $data);
            }
        }
        $node->value = $value;
        return $result;
    }

    private function renderElseNode(/*object*/$node, array $ifNodes, array $data): string
    {
        if (count($ifNodes) < 1 || $ifNodes[0]->type != 'if') {
            return $this->escape("{{else!!could not find matching `if`}}");
        }
        $result = '';
        $value = false;
        for ($i = 0; $i < count($ifNodes); $i++) {
            $value = $value || $ifNodes[$i]->value;
        }
        if (!$value) {
            $result .= $this->renderChildren($node, $data);
        }
        return $result;
    }

    private function renderForNode(/*object*/$node, array $data): string
    {
        $parts = $this->explode('|', $node->expression);
        $pathParts = $this->explode(':', array_shift($parts), 3);
        if (count($pathParts) == 2) {
            list($var, $path) = $pathParts;
            $key = false;
        } elseif (count($pathParts) == 3) {
            list($var, $key, $path) = $pathParts;
        } else {
            return $this->escape('{{for:' . $node->expression . '!!' . "for must have `for:var:array` format" . '}}');
        }
        try {
            $value = $this->resolvePath($path, $data);
            $value = $this->applyFunctions($value, $parts, $data);
        } catch (\Throwable $e) {
            return $this->escape('{{for:' . $node->expression . '!!' . $e->getMessage() . '}}');
        }
        if (!is_array($value)) {
            return $this->escape('{{for:' . $node->expression . '!!' . "expression must evaluate to an array" . '}}');
        }
        $result = '';
        foreach ($value as $k => $v) {
            $data = array_merge($data, $key ? [$var => $v, $key => $k] : [$var => $v]);
            $result .= $this->renderChildren($node, $data);
        }
        return $result;
    }

    private function renderVarNode(/*object*/$node, array $data): string
    {
        $parts = $this->explode('|', $node->expression);
        $path = array_shift($parts);
        try {
            $value = $this->resolvePath($path, $data);
            $value = $this->applyFunctions($value, $parts, $data);
        } catch (\Throwable $e) {
            return $this->escape('{{' . $node->expression . '!!' . $e->getMessage() . '}}');
        }
        if ($value instanceof TemplateString) {
            return $value;
        }
        return $this->escape((string) $value);
    }

    private function resolvePath(string $path, array $data)/*: object*/
    {
        $current = $data;
        foreach ($this->explode('.', $path) as $p) {
            if (!array_key_exists($p, $current)) {
                throw new \Exception("path `$p` not found");
            }
            $current = &$current[$p];
        }
        return $current;
    }

    private function applyFunctions(/*object*/$value, array $parts, array $data)/*: object*/
    {
        foreach ($parts as $part) {
            $function = $this->explode('(', rtrim($part, ')'), 2);
            $f = $function[0];
            $arguments = isset($function[1]) ? $this->explode(',', $function[1]) : array();
            $arguments = array_map(function ($argument) use ($data) {
                $argument = trim($argument);
                $len = strlen($argument);
                if ($argument[0] == '"' && $argument[$len - 1] == '"') {
                    $argument = stripcslashes(substr($argument, 1, $len - 2));
                } else if (!is_numeric($argument)) {
                    $argument = $this->resolvePath($argument, $data);
                }
                return $argument;
            }, $arguments);
            array_unshift($arguments, $value);
            if (isset($this->functions[$f])) {
                $value = call_user_func_array($this->functions[$f], $arguments);
            } else {
                throw new \Exception("function `$f` not found");
            }
        }
        return $value;
    }
}
