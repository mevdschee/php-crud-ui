<?php

function removeIgnored(string $dir, array &$entries, array $ignore)
{
    foreach ($entries as $i => $entry) {
        if (isset($ignore[$dir . '/' . $entry])) {
            unset($entries[$i]);
        }
    }
}

function runDir(string $base, string $dir, array &$lines, array $ignore): int
{
    $count = 0;
    $entries = scandir($dir);
    removeIgnored($dir, $entries, $ignore);
    sort($entries);
    foreach ($entries as $entry) {
        if ($entry === '.' || $entry === '..') {
            continue;
        }
        $filename = "$base/$dir/$entry";
        if (is_dir($filename)) {
            $count += runDir($base, "$dir/$entry", $lines, $ignore);
        }
    }
    foreach ($entries as $entry) {
        $filename = "$base/$dir/$entry";
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        if (is_file($filename)) {
            if ($extension == 'php') {
                $data = file_get_contents($filename);
                $data = preg_replace('/\s*<\?php\s+/s', '', $data, 1);
                $data = preg_replace('/^.*?(vendor\/autoload|declare\s*\(\s*strict_types\s*=\s*1).*?$/m', '', $data);
                array_push($lines, "// file: $dir/$entry");
                foreach (explode("\n", trim($data)) as $line) {
                    if ($line) {
                        $line = '    ' . $line;
                    }
                    $line = preg_replace('/^\s*(namespace[^;]+);/', '\1 {', $line);
                    array_push($lines, $line);
                }
                array_push($lines, '}');
                array_push($lines, '');
                $count++;
            } elseif ($extension == 'html') {
                $data = file_get_contents($filename);
                $id = explode('.', explode('/', "$dir/$entry", 2)[1], 2)[0];
                array_push($lines, "// file: $dir/$entry");
                array_push($lines, 'namespace {');
                array_push($lines, "\$_HTML['$id'] = <<<'END_OF_HTML'");
                foreach (explode("\n", $data) as $line) {
                    array_push($lines, $line);
                }
                array_push($lines, 'END_OF_HTML;', '}', '');
                $count++;
            } elseif (in_array($extension, ['css', 'svg', 'js', 'woff', 'woff2', 'ico'])) {
                $data = base64_encode(file_get_contents($filename));
                $id = substr("$dir/$entry", 7);
                array_push($lines, "// file: $dir/$entry");
                array_push($lines, 'namespace {');
                array_push($lines, "\$_STATIC['$id'] = <<<'END_OF_STATIC_FILE'");
                foreach (explode("\n", $data) as $line) {
                    array_push($lines, $line);
                }
                array_push($lines, 'END_OF_STATIC_FILE;', '}', '');
                $count++;
            }
        }
    }
    return $count;
}

function addHeader(array &$lines)
{
    $head = <<<'EOF'
<?php
/**
 * PHP-CRUD-UI v2               License: MIT
 * Maurits van der Schee: maurits@vdschee.nl
 * https://github.com/mevdschee/php-crud-ui
 *
 * Dependencies:
 * - vendor/psr/*: PHP-FIG
 *   https://github.com/php-fig
 * - vendor/nyholm/*: Tobias Nyholm
 *   https://github.com/Nyholm
 **/

namespace {
    global $_HTML;
    $_HTML = array();

    global $_STATIC;
    $_STATIC = array();
}

EOF;
    foreach (explode("\n", $head) as $line) {
        array_push($lines, $line);
    }
}

function run(string $base, array $dirs, string $filename, array $ignore)
{
    $lines = [];
    $start = microtime(true);
    addHeader($lines);
    $ignore = array_flip($ignore);
    $count = 0;
    foreach ($dirs as $dir) {
        $count += runDir($base, $dir, $lines, $ignore);
    }
    $data = implode("\n", $lines);
    $data = preg_replace('/\n({)?\s*\n\s*\n/', "\n$1\n", $data);
    file_put_contents('tmp_' . $filename, $data);
    ob_start();
    include 'tmp_' . $filename;
    ob_end_clean();
    rename('tmp_' . $filename, $filename);
    $data = substr($data, 0, strrpos($data, "\n// file: webroot/index.php"));
    file_put_contents(str_replace('.php', '.include.php', $filename), $data);
    $end = microtime(true);
    $time = ($end - $start) * 1000;
    echo sprintf("%d files combined in %d ms into '%s'\n", $count, $time, $filename);
}

$ignore = [
    'vendor/nyholm/psr7/src/Factory/HttplugFactory.php',
];

$dirs = [
    'templates',
    'vendor/nyholm',
    'vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi',
    'src',
    'webroot',
];

if (!extension_loaded('psr')) {
    array_unshift($directories, 'vendor/psr');
}

run(__DIR__, $dirs, 'ui.php', $ignore);
