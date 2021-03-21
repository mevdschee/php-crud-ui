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

// file: templates/error/show.html
namespace {
$_HTML['error/show'] = <<<'END_OF_HTML'
<ul class="breadcrumb">
    <li><a href="{{base}}/">Home</a></li>
    <li><a href="{{base}}/column/{{table}}/list">{{table}}</a></li>
</ul>

<h2>Error</h2>

<strong>code:</strong><br/>
<p>{{code}}</p>

<strong>message:</strong><br/>
<p>{{message}}</p>

<strong>details:</strong><br/>
<pre>{{details}}</pre>
END_OF_HTML;
}

// file: templates/layouts/default.html
namespace {
$_HTML['layouts/default'] = <<<'END_OF_HTML'
<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{info.title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{base}}/css/style.css">
    <!--<link rel="stylesheet" type="text/css" href="{{base}}/css/music.css">-->
    <link rel="shortcut icon" href="{{base}}/img/favicon.ico">
</head>

<body class="{{table}}">
    <div class="content">
        <div class="navigation">
            <a href="{{base}}/" class="title"><span>{{info.title}}</span>{{info.x-subtitle}}</a>
            <a class="hamburger" href="{{base}}/menu" title="Open menu"><span></span><span></span><span></span></a>
        </div>
        <div class="body">
            {{content}}
        </div>
    </div>
</body>

</html>
END_OF_HTML;
}

// file: templates/layouts/error.html
namespace {
$_HTML['layouts/error'] = <<<'END_OF_HTML'
<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{info.title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{base}}/css/style.css">
    <!--<link rel="stylesheet" type="text/css" href="{{base}}/css/music.css">-->
    <link rel="shortcut icon" href="{{base}}/img/favicon.ico">
</head>

<body class="{{table}}">
    <div class="content">
        <div class="navigation">
            <a href="{{base}}/" class="title"><span>{{info.title}}</span>{{info.x-subtitle}}</a>
            <a class="hamburger" href="{{base}}/menu" title="Open menu"><span></span><span></span><span></span></a>
        </div>
        <div class="body">
            {{content}}
        </div>
    </div>
</body>

</html>
END_OF_HTML;
}

// file: templates/layouts/menu.html
namespace {
$_HTML['layouts/menu'] = <<<'END_OF_HTML'
<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{info.title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{base}}/css/style.css">
    <!--<link rel="stylesheet" type="text/css" href="{{base}}/css/music.css">-->
    <link rel="shortcut icon" href="{{base}}/img/favicon.ico">
</head>

<body class="{{table}}">
    <div class="content">
        <div class="navigation">
            <a href="{{base}}/" class="title"><span>{{info.title}}</span>{{info.x-subtitle}}</a>
            <a class="hamburger close" href="javascript:window.history.go(-1);"
                title="Close menu"><span></span><span></span><span></span></a>
        </div>
        <div class="body">
            {{content}}
        </div>
    </div>
</body>

</html>
END_OF_HTML;
}

// file: templates/record/create.html
namespace {
$_HTML['record/create'] = <<<'END_OF_HTML'
<ul class="breadcrumb">
    <li><a href="{{base}}/">Home</a></li>
    <li><a href="{{base}}/{{table}}/list">{{table|humanize}}</a></li>
</ul>

<h1>New item</h1>

<form method="post">
    {{for:value:key:record}}
    {{if:key|neq(primaryKey)}}
    <div>
        <label for="{{key}}" class="col-sm-2 col-form-label" title="{{key|humanize}}">{{key|humanize}}</label>
        {{if:value.values}}
        <select id="{{key}}" name="{{key}}" class="form-control">
            <option value=""></option>
            {{for:v:k:value.values}}
            <option value="{{k}}" {{if:k|eq(value.value)}} selected{{endif}}>{{v}}</option>
            {{endfor}}
        </select>
        {{else}}
        {{if:value.type.format|eq("int32")}}
        <input class="form-control" id="{{key}}" type="number" name="{{key}}" value="{{value.value}}" />
        {{elseif:value.type.format|eq("int64")}}
        <input class="form-control" id="{{key}}" type="number" name="{{key}}" value="{{value.value}}" />
        {{elseif:value.type.format|eq("decimal")}}
        <input class="form-control" id="{{key}}" type="number" step="any" name="{{key}}" value="{{value.value}}" />
        {{elseif:value.type.format|eq("date-time")}}
        <input class="form-control" id="{{key}}" type="datetime-local" name="{{key}}" value="{{value.value}}" />
        {{elseif:value.type.format|eq("date")}}
        <input class="form-control" id="{{key}}" type="date" name="{{key}}" value="{{value.value}}" />
        {{elseif:value.type.format|eq("time")}}
        <input class="form-control" id="{{key}}" type="time" name="{{key}}" value="" />
        {{elseif:value.type.format|eq("large-string")}}
        <textarea class="form-control" id="{{key}}" name="{{key}}">{{value.value}}</textarea>
        {{elseif:value.type.format|eq("boolean")}}
        <input class="form-control" id="{{key}}" name="{{key}}" type="checkbox" {{if:value.value}} checked{{endif}} />
        {{else}}
        <input class="form-control" id="{{key}}" name="{{key}}" value="{{value.value}}" />
        {{endif}}
        {{endif}}
    </div>
    {{endif}}
    {{endfor}}
    <button type="submit" class="btn btn-primary">Save</button>
</form>
END_OF_HTML;
}

// file: templates/record/created.html
namespace {
$_HTML['record/created'] = <<<'END_OF_HTML'
<ul class="breadcrumb">
    <li><a href="{{base}}/">Home</a></li>
    <li><a href="{{base}}/{{table}}/list">{{table|humanize}}</a></li>
</ul>

<h1>create {{table}}</h1>

<p>Added with {{primaryKey}} {{id}}</p>

<p><a href="{{base}}/{{table}}/list" class="btn btn-primary">Ok</a></p>
END_OF_HTML;
}

// file: templates/record/delete.html
namespace {
$_HTML['record/delete'] = <<<'END_OF_HTML'
<ul class="breadcrumb">
    <li><a href="{{base}}/">Home</a></li>
    <li><a href="{{base}}/{{table}}/list">{{table|humanize}}</a></li>
</ul>

<h1>{{name|or("Delete item")}}</h1>

{{if:name}}
<p>Are you sure you want to delete '{{name}}'?</p>
{{else}}
<p>Are you sure you want to delete item #{{id}}?</p>
{{endif}}
<p>The action cannot be undone.</p>

<form method="post">
    <input type="hidden" name="{{primaryKey}}" value="{{id}}" />
    <button type="submit" class="btn btn-danger">Delete</button>
    <a href="{{base}}/{{table}}/read/{{id}}" class="btn btn-default">Cancel</a>
</form>
END_OF_HTML;
}

// file: templates/record/deleted.html
namespace {
$_HTML['record/deleted'] = <<<'END_OF_HTML'
<ul class="breadcrumb">
    <li><a href="{{base}}/">Home</a></li>
    <li><a href="{{base}}/{{table}}/list">{{table|humanize}}</a></li>
</ul>

<h1>delete {{table}}</h1>

<p>Deleted with {{primaryKey}} {{id}}</p>

<p><a href="{{base}}/{{table}}/list" class="btn btn-primary">Ok</a></p>
END_OF_HTML;
}

// file: templates/record/home.html
namespace {
$_HTML['record/home'] = <<<'END_OF_HTML'
<ul class="breadcrumb">
    <li><a href="{{base}}/">Home</a></li>
</ul>

<h1>{{info.title}}</h1>
<br />
<ul class="home">
    {{for:item:menu}}
    <li>
        <a href="{{base}}/{{item}}/list">{{item|humanize}}</a>
    </li>
    {{endfor}}
</ul>
END_OF_HTML;
}

// file: templates/record/list.html
namespace {
$_HTML['record/list'] = <<<'END_OF_HTML'
<ul class="breadcrumb">
    <li><a href="{{base}}/">Home</a></li>
    <li><a href="{{base}}/{{table}}/list">{{table|humanize}}</a></li>
</ul>

<div class="titlebar">
    <h1>{{table|humanize}}</h1>
    <div>
        <a onclick="document.querySelector('.addFilter').classList.toggle('visible');" href="#" class="icon filter">Add
            filter</a>
        <a onclick="document.querySelector('.addSearch').classList.toggle('visible');" href="#"
            class="icon search">Search</a>
        {{if:primaryKey}}
        <a href="{{base}}/{{table}}/create" class="btn">New item</a>
        {{endif}}
    </div>
</div>

<script src="{{base}}/js/list.js"></script>

{{for:filter:i:filters}}
{{if:filter.type|eq("search")}}
<div class="filterbar" data-index="{{i}}" data-filter="{{filter.type}},{{filter.operator}},{{filter.value}}">
    <div>
        <a href="{{base}}/{{table}}/list" title="Edit filter" onclick="return editFilter('{{i}}');">
            Search '{{filter.value}}'
        </a>
    </div>
    <a class="close" href="{{base}}/{{table}}/list" title="Clear filters" onclick="return closeFilter('{{i}}');"></a>
</div>
{{elseif:filter.type|eq("value")}}
<div class="filterbar" data-index="{{i}}"
    data-filter="{{filter.type}},{{filter.field}},{{filter.operator}},{{filter.value}}">
    <div>
        <a href="{{base}}/{{table}}/list" title="Edit filter" onclick="return editFilter('{{i}}');">
            {{filter.field|humanize}}
            {{if:filter.operator|eq("cs")}}~
            {{elseif:filter.operator|eq("eq")}}=
            {{elseif:filter.operator|eq("lt")}}&lt;
            {{elseif:filter.operator|eq("gt")}}&gt;
            {{else}}{{filter.operator}}{{endif}}
            '{{filter.value}}'
        </a>
    </div>
    <a class="close" href="{{base}}/{{table}}/list" title="Clear filters" onclick="return closeFilter('{{i}}');"></a>
</div>
{{elseif:filter.type|eq("reference")}}
<div class="filterbar" data-index="{{i}}"
    data-filter="{{filter.type}},{{filter.field}},{{filter.operator}},{{filter.value}},{{filter.text}}">
    <div>
        <a href="{{base}}/{{table}}/list" title="Edit filter" onclick="return editFilter('{{i}}');">
            {{filter.field|humanize}} {{if:filter.operator|eq("in")}}={{else}}~{{endif}} '{{filter.text}}'
        </a>
    </div>
    <a class="close" href="{{base}}/{{table}}/list" title="Clear filters" onclick="return closeFilter('{{i}}');"></a>
</div>
{{endif}}
{{endfor}}

<div class="addFilter">
    <form style="display:inline" method="post" action="#">
        <select name="field" onchange="updateAddFilter();">
            {{for:column:columns}}
            {{if:column|neq(primaryKey)}}
            <option value="{{column}}" data-references="{{references|prop(column)}}"
                data-format="{{types|prop(column)|prop("format")}}">
                {{column|humanize}}
            </option>
            {{endif}}
            {{endfor}}
        </select>
        <select name="operator">
            <option value="cs">~</option>
            <option value="eq">=</option>
            <option value="lt">&lt;</option>
            <option value="gt">&gt;</option>
        </select>
        <input type="hidden" name="value" />
        <select name="values" onchange="updateTextAndValue();" multiple style="height: 5rem;"></select>
        <input type="hidden" name="text" />
        <input type="submit" value="Filter" />
    </form>
</div>

<div class="addSearch">
    <form style="display:inline" method="post" action="#">
        <input type="text" name="search" />
        <input type="submit" value="Search" />
    </form>
</div>

<table class="table list">
    <thead>
        <tr>
            {{if:primaryKey}}
            <th>Action</th>
            {{endif}}
            {{for:column:columns}}
            {{if:column|neq(primaryKey)}}
            <th>{{column|humanize}}</th>
            {{endif}}
            {{endfor}}
        </tr>
    </thead>
    <tbody>
        {{for:record:records}}
        <tr>
            {{for:field:name:record}}
            {{if:name|eq(primaryKey)}}
            <td><a href="{{base}}/{{table}}/read/{{field.value}}">view</a></td>
            {{endif}}
            {{if:name|neq(primaryKey)}}
            {{if:field.table}}
            <td><a href="{{base}}/{{field.table}}/read/{{field.value}}">{{field.text}}</a></td>
            {{else}}
            <td>{{field.text}}</td>
            {{endif}}
            {{endif}}
            {{endfor}}
        </tr>
        {{endfor}}
    </tbody>
</table>
{{if:maxPage|gt(1)}}
<div class="pagination" data-page="{{pageNumber}},{{pageSize}}">
    {{if:pageNumber|gt(1)}}
    <a href="?page={{pageNumber|sub(1)}},{{pageSize}}" class="icon prev"
        onclick="return navigatePage('{{pageNumber|sub(1)}},{{pageSize}}')">&lt;</a>
    {{else}}
    <a href="javascript:void(0);" class="icon prev disabled">&lt;</a>
    {{endif}}
    &nbsp;page {{pageNumber}}/{{maxPage}}&nbsp;
    {{if:pageNumber|lt(maxPage)}}
    <a href="?page={{pageNumber|add(1)}},{{pageSize}}" class="icon next"
        onclick="return navigatePage('{{pageNumber|add(1)}},{{pageSize}}')">&gt;</a>
    {{else}}
    <a href="javascript:void(0);" class="icon next disabled">&gt;</a>
    {{endif}}
</div>
{{endif}}
<div class="footeractions">
    <a href="{{base}}/{{table}}/export" class="btn">Export</a>

</div>
END_OF_HTML;
}

// file: templates/record/menu.html
namespace {
$_HTML['record/menu'] = <<<'END_OF_HTML'
<br />
<ul class="home">
    {{for:item:menu}}
    <li>
        <a href="{{base}}/{{item}}/list">{{item|humanize}}</a>
    </li>
    {{endfor}}
</ul>
END_OF_HTML;
}

// file: templates/record/read.html
namespace {
$_HTML['record/read'] = <<<'END_OF_HTML'
<ul class="breadcrumb">
    <li><a href="{{base}}/">Home</a></li>
    <li><a href="{{base}}/{{table}}/list">{{table|humanize}}</a></li>
</ul>

<h1>{{name|or("View item")}}</h1>

<table class="table read">
    <thead>
        <tr>
            <th>Key</th>
            <th>Value</th>
        </tr>
    </thead>
    <tbody>
        {{for:field:name:record}}
        {{if:name|neq(primaryKey)}}
        <tr>
            <td>{{name|humanize}}</td>
            </td>
            <td>
                {{if:field.table|and(field.text)}}
                <a href="{{base}}/{{field.table}}/read/{{field.value}}">{{field.text}}</a>
                {{else}}
                {{if:field.type.format|eq("large-string")}}
                <div style="white-space: pre-wrap;">{{field.text}}</div>
                {{else}}
                {{if:field.text}}{{field.text}}{{else}}<span class="mobile-only">-</span>{{endif}}
                {{endif}}
                {{endif}}
            </td>
        </tr>
        {{endif}}
        {{endfor}}
    </tbody>
</table>

<p>
    <a class="btn btn-primary" href="{{base}}/{{table}}/update/{{id}}">Edit</a>
    <a class="btn btn-danger" href="{{base}}/{{table}}/delete/{{id}}">Delete</a>
</p>
{{if:referenced|has(0)}}
<br />
<br />
<h2>Related</h2>
<ul class="related">
    {{for:relation:referenced}}
    <li>
        <a href="{{base}}/{{relation.0}}/list?filter=reference,{{relation.1}},in,{{id}},{{name}}">
            {{relation.0|humanize}}
        </a>
    </li>
    {{endfor}}
    {{endif}}
</ul>
END_OF_HTML;
}

// file: templates/record/update.html
namespace {
$_HTML['record/update'] = <<<'END_OF_HTML'
<ul class="breadcrumb">
    <li><a href="{{base}}/">Home</a></li>
    <li><a href="{{base}}/{{table}}/list">{{table|humanize}}</a></li>
</ul>

<h1>{{name|or("Edit item")}}</h1>

<form method="post">
    {{for:value:key:record}}
    {{if:key|neq(primaryKey)}}
    <div>
        <label for="{{key}}" class="col-sm-2 col-form-label" title="{{key|humanize}}">{{key|humanize}}</label>
        {{if:value.values}}
        <select id="{{key}}" name="{{key}}" class="form-control">
            <option value=""></option>
            {{for:v:k:value.values}}
            <option value="{{k}}" {{if:k|eq(value.value)}} selected{{endif}}>{{v}}</option>
            {{endfor}}
        </select>
        {{else}}
        {{if:value.type.format|eq("int32")}}
        <input class="form-control" id="{{key}}" type="number" name="{{key}}" value="{{value.value}}" />
        {{elseif:value.type.format|eq("int64")}}
        <input class="form-control" id="{{key}}" type="number" name="{{key}}" value="{{value.value}}" />
        {{elseif:value.type.format|eq("decimal")}}
        <input class="form-control" id="{{key}}" type="number" step="any" name="{{key}}" value="{{value.value}}" />
        {{elseif:value.type.format|eq("date-time")}}
        <input class="form-control" id="{{key}}" type="datetime-local" name="{{key}}" value="{{value.value}}" />
        {{elseif:value.type.format|eq("date")}}
        <input class="form-control" id="{{key}}" type="date" name="{{key}}" value="{{value.value}}" />
        {{elseif:value.type.format|eq("time")}}
        <input class="form-control" id="{{key}}" type="time" name="{{key}}" value="" />
        {{elseif:value.type.format|eq("large-string")}}
        <textarea class="form-control" id="{{key}}" name="{{key}}">{{value.value}}</textarea>
        {{elseif:value.type.format|eq("boolean")}}
        <input class="form-control" id="{{key}}" name="{{key}}" type="checkbox" {{if:value.value}} checked{{endif}} />
        {{else}}
        <input class="form-control" id="{{key}}" name="{{key}}" value="{{value.value}}" />
        {{endif}}
        {{endif}}
    </div>
    {{endif}}
    {{endfor}}
    <button type="submit" class="btn">Save</button>
</form>
END_OF_HTML;
}

// file: templates/record/updated.html
namespace {
$_HTML['record/updated'] = <<<'END_OF_HTML'
<ul class="breadcrumb">
    <li><a href="{{base}}/">Home</a></li>
    <li><a href="{{base}}/{{table}}/list">{{table|humanize}}</a></li>
</ul>

<h1>update {{table}}</h1>

<p>Updated with {{primaryKey}} {{id}}</p>

<p><a href="{{base}}/{{table}}/list" class="btn btn-primary">Ok</a></p>
END_OF_HTML;
}

// file: vendor/psr/http-factory/src/RequestFactoryInterface.php
namespace Psr\Http\Message {

    interface RequestFactoryInterface
    {
        /**
         * Create a new request.
         *
         * @param string $method The HTTP method associated with the request.
         * @param UriInterface|string $uri The URI associated with the request. If
         *     the value is a string, the factory MUST create a UriInterface
         *     instance based on it.
         *
         * @return RequestInterface
         */
        public function createRequest(string $method, $uri): RequestInterface;
    }
}

// file: vendor/psr/http-factory/src/ResponseFactoryInterface.php
namespace Psr\Http\Message {

    interface ResponseFactoryInterface
    {
        /**
         * Create a new response.
         *
         * @param int $code HTTP status code; defaults to 200
         * @param string $reasonPhrase Reason phrase to associate with status code
         *     in generated response; if none is provided implementations MAY use
         *     the defaults as suggested in the HTTP specification.
         *
         * @return ResponseInterface
         */
        public function createResponse(int $code = 200, string $reasonPhrase = ''): ResponseInterface;
    }
}

// file: vendor/psr/http-factory/src/ServerRequestFactoryInterface.php
namespace Psr\Http\Message {

    interface ServerRequestFactoryInterface
    {
        /**
         * Create a new server request.
         *
         * Note that server-params are taken precisely as given - no parsing/processing
         * of the given values is performed, and, in particular, no attempt is made to
         * determine the HTTP method or URI, which must be provided explicitly.
         *
         * @param string $method The HTTP method associated with the request.
         * @param UriInterface|string $uri The URI associated with the request. If
         *     the value is a string, the factory MUST create a UriInterface
         *     instance based on it.
         * @param array $serverParams Array of SAPI parameters with which to seed
         *     the generated request instance.
         *
         * @return ServerRequestInterface
         */
        public function createServerRequest(string $method, $uri, array $serverParams = []): ServerRequestInterface;
    }
}

// file: vendor/psr/http-factory/src/StreamFactoryInterface.php
namespace Psr\Http\Message {

    interface StreamFactoryInterface
    {
        /**
         * Create a new stream from a string.
         *
         * The stream SHOULD be created with a temporary resource.
         *
         * @param string $content String content with which to populate the stream.
         *
         * @return StreamInterface
         */
        public function createStream(string $content = ''): StreamInterface;

        /**
         * Create a stream from an existing file.
         *
         * The file MUST be opened using the given mode, which may be any mode
         * supported by the `fopen` function.
         *
         * The `$filename` MAY be any string supported by `fopen()`.
         *
         * @param string $filename Filename or stream URI to use as basis of stream.
         * @param string $mode Mode with which to open the underlying filename/stream.
         *
         * @return StreamInterface
         * @throws \RuntimeException If the file cannot be opened.
         * @throws \InvalidArgumentException If the mode is invalid.
         */
        public function createStreamFromFile(string $filename, string $mode = 'r'): StreamInterface;

        /**
         * Create a new stream from an existing resource.
         *
         * The stream MUST be readable and may be writable.
         *
         * @param resource $resource PHP resource to use as basis of stream.
         *
         * @return StreamInterface
         */
        public function createStreamFromResource($resource): StreamInterface;
    }
}

// file: vendor/psr/http-factory/src/UploadedFileFactoryInterface.php
namespace Psr\Http\Message {

    interface UploadedFileFactoryInterface
    {
        /**
         * Create a new uploaded file.
         *
         * If a size is not provided it will be determined by checking the size of
         * the file.
         *
         * @see http://php.net/manual/features.file-upload.post-method.php
         * @see http://php.net/manual/features.file-upload.errors.php
         *
         * @param StreamInterface $stream Underlying stream representing the
         *     uploaded file content.
         * @param int $size in bytes
         * @param int $error PHP file upload error
         * @param string $clientFilename Filename as provided by the client, if any.
         * @param string $clientMediaType Media type as provided by the client, if any.
         *
         * @return UploadedFileInterface
         *
         * @throws \InvalidArgumentException If the file resource is not readable.
         */
        public function createUploadedFile(
            StreamInterface $stream,
            int $size = null,
            int $error = \UPLOAD_ERR_OK,
            string $clientFilename = null,
            string $clientMediaType = null
        ): UploadedFileInterface;
    }
}

// file: vendor/psr/http-factory/src/UriFactoryInterface.php
namespace Psr\Http\Message {

    interface UriFactoryInterface
    {
        /**
         * Create a new URI.
         *
         * @param string $uri
         *
         * @return UriInterface
         *
         * @throws \InvalidArgumentException If the given URI cannot be parsed.
         */
        public function createUri(string $uri = ''): UriInterface;
    }
}

// file: vendor/psr/http-message/src/MessageInterface.php
namespace Psr\Http\Message {

    /**
     * HTTP messages consist of requests from a client to a server and responses
     * from a server to a client. This interface defines the methods common to
     * each.
     *
     * Messages are considered immutable; all methods that might change state MUST
     * be implemented such that they retain the internal state of the current
     * message and return an instance that contains the changed state.
     *
     * @link http://www.ietf.org/rfc/rfc7230.txt
     * @link http://www.ietf.org/rfc/rfc7231.txt
     */
    interface MessageInterface
    {
        /**
         * Retrieves the HTTP protocol version as a string.
         *
         * The string MUST contain only the HTTP version number (e.g., "1.1", "1.0").
         *
         * @return string HTTP protocol version.
         */
        public function getProtocolVersion();

        /**
         * Return an instance with the specified HTTP protocol version.
         *
         * The version string MUST contain only the HTTP version number (e.g.,
         * "1.1", "1.0").
         *
         * This method MUST be implemented in such a way as to retain the
         * immutability of the message, and MUST return an instance that has the
         * new protocol version.
         *
         * @param string $version HTTP protocol version
         * @return static
         */
        public function withProtocolVersion($version);

        /**
         * Retrieves all message header values.
         *
         * The keys represent the header name as it will be sent over the wire, and
         * each value is an array of strings associated with the header.
         *
         *     // Represent the headers as a string
         *     foreach ($message->getHeaders() as $name => $values) {
         *         echo $name . ": " . implode(", ", $values);
         *     }
         *
         *     // Emit headers iteratively:
         *     foreach ($message->getHeaders() as $name => $values) {
         *         foreach ($values as $value) {
         *             header(sprintf('%s: %s', $name, $value), false);
         *         }
         *     }
         *
         * While header names are not case-sensitive, getHeaders() will preserve the
         * exact case in which headers were originally specified.
         *
         * @return string[][] Returns an associative array of the message's headers. Each
         *     key MUST be a header name, and each value MUST be an array of strings
         *     for that header.
         */
        public function getHeaders();

        /**
         * Checks if a header exists by the given case-insensitive name.
         *
         * @param string $name Case-insensitive header field name.
         * @return bool Returns true if any header names match the given header
         *     name using a case-insensitive string comparison. Returns false if
         *     no matching header name is found in the message.
         */
        public function hasHeader($name);

        /**
         * Retrieves a message header value by the given case-insensitive name.
         *
         * This method returns an array of all the header values of the given
         * case-insensitive header name.
         *
         * If the header does not appear in the message, this method MUST return an
         * empty array.
         *
         * @param string $name Case-insensitive header field name.
         * @return string[] An array of string values as provided for the given
         *    header. If the header does not appear in the message, this method MUST
         *    return an empty array.
         */
        public function getHeader($name);

        /**
         * Retrieves a comma-separated string of the values for a single header.
         *
         * This method returns all of the header values of the given
         * case-insensitive header name as a string concatenated together using
         * a comma.
         *
         * NOTE: Not all header values may be appropriately represented using
         * comma concatenation. For such headers, use getHeader() instead
         * and supply your own delimiter when concatenating.
         *
         * If the header does not appear in the message, this method MUST return
         * an empty string.
         *
         * @param string $name Case-insensitive header field name.
         * @return string A string of values as provided for the given header
         *    concatenated together using a comma. If the header does not appear in
         *    the message, this method MUST return an empty string.
         */
        public function getHeaderLine($name);

        /**
         * Return an instance with the provided value replacing the specified header.
         *
         * While header names are case-insensitive, the casing of the header will
         * be preserved by this function, and returned from getHeaders().
         *
         * This method MUST be implemented in such a way as to retain the
         * immutability of the message, and MUST return an instance that has the
         * new and/or updated header and value.
         *
         * @param string $name Case-insensitive header field name.
         * @param string|string[] $value Header value(s).
         * @return static
         * @throws \InvalidArgumentException for invalid header names or values.
         */
        public function withHeader($name, $value);

        /**
         * Return an instance with the specified header appended with the given value.
         *
         * Existing values for the specified header will be maintained. The new
         * value(s) will be appended to the existing list. If the header did not
         * exist previously, it will be added.
         *
         * This method MUST be implemented in such a way as to retain the
         * immutability of the message, and MUST return an instance that has the
         * new header and/or value.
         *
         * @param string $name Case-insensitive header field name to add.
         * @param string|string[] $value Header value(s).
         * @return static
         * @throws \InvalidArgumentException for invalid header names or values.
         */
        public function withAddedHeader($name, $value);

        /**
         * Return an instance without the specified header.
         *
         * Header resolution MUST be done without case-sensitivity.
         *
         * This method MUST be implemented in such a way as to retain the
         * immutability of the message, and MUST return an instance that removes
         * the named header.
         *
         * @param string $name Case-insensitive header field name to remove.
         * @return static
         */
        public function withoutHeader($name);

        /**
         * Gets the body of the message.
         *
         * @return StreamInterface Returns the body as a stream.
         */
        public function getBody();

        /**
         * Return an instance with the specified message body.
         *
         * The body MUST be a StreamInterface object.
         *
         * This method MUST be implemented in such a way as to retain the
         * immutability of the message, and MUST return a new instance that has the
         * new body stream.
         *
         * @param StreamInterface $body Body.
         * @return static
         * @throws \InvalidArgumentException When the body is not valid.
         */
        public function withBody(StreamInterface $body);
    }
}

// file: vendor/psr/http-message/src/RequestInterface.php
namespace Psr\Http\Message {

    /**
     * Representation of an outgoing, client-side request.
     *
     * Per the HTTP specification, this interface includes properties for
     * each of the following:
     *
     * - Protocol version
     * - HTTP method
     * - URI
     * - Headers
     * - Message body
     *
     * During construction, implementations MUST attempt to set the Host header from
     * a provided URI if no Host header is provided.
     *
     * Requests are considered immutable; all methods that might change state MUST
     * be implemented such that they retain the internal state of the current
     * message and return an instance that contains the changed state.
     */
    interface RequestInterface extends MessageInterface
    {
        /**
         * Retrieves the message's request target.
         *
         * Retrieves the message's request-target either as it will appear (for
         * clients), as it appeared at request (for servers), or as it was
         * specified for the instance (see withRequestTarget()).
         *
         * In most cases, this will be the origin-form of the composed URI,
         * unless a value was provided to the concrete implementation (see
         * withRequestTarget() below).
         *
         * If no URI is available, and no request-target has been specifically
         * provided, this method MUST return the string "/".
         *
         * @return string
         */
        public function getRequestTarget();

        /**
         * Return an instance with the specific request-target.
         *
         * If the request needs a non-origin-form request-target — e.g., for
         * specifying an absolute-form, authority-form, or asterisk-form —
         * this method may be used to create an instance with the specified
         * request-target, verbatim.
         *
         * This method MUST be implemented in such a way as to retain the
         * immutability of the message, and MUST return an instance that has the
         * changed request target.
         *
         * @link http://tools.ietf.org/html/rfc7230#section-5.3 (for the various
         *     request-target forms allowed in request messages)
         * @param mixed $requestTarget
         * @return static
         */
        public function withRequestTarget($requestTarget);

        /**
         * Retrieves the HTTP method of the request.
         *
         * @return string Returns the request method.
         */
        public function getMethod();

        /**
         * Return an instance with the provided HTTP method.
         *
         * While HTTP method names are typically all uppercase characters, HTTP
         * method names are case-sensitive and thus implementations SHOULD NOT
         * modify the given string.
         *
         * This method MUST be implemented in such a way as to retain the
         * immutability of the message, and MUST return an instance that has the
         * changed request method.
         *
         * @param string $method Case-sensitive method.
         * @return static
         * @throws \InvalidArgumentException for invalid HTTP methods.
         */
        public function withMethod($method);

        /**
         * Retrieves the URI instance.
         *
         * This method MUST return a UriInterface instance.
         *
         * @link http://tools.ietf.org/html/rfc3986#section-4.3
         * @return UriInterface Returns a UriInterface instance
         *     representing the URI of the request.
         */
        public function getUri();

        /**
         * Returns an instance with the provided URI.
         *
         * This method MUST update the Host header of the returned request by
         * default if the URI contains a host component. If the URI does not
         * contain a host component, any pre-existing Host header MUST be carried
         * over to the returned request.
         *
         * You can opt-in to preserving the original state of the Host header by
         * setting `$preserveHost` to `true`. When `$preserveHost` is set to
         * `true`, this method interacts with the Host header in the following ways:
         *
         * - If the Host header is missing or empty, and the new URI contains
         *   a host component, this method MUST update the Host header in the returned
         *   request.
         * - If the Host header is missing or empty, and the new URI does not contain a
         *   host component, this method MUST NOT update the Host header in the returned
         *   request.
         * - If a Host header is present and non-empty, this method MUST NOT update
         *   the Host header in the returned request.
         *
         * This method MUST be implemented in such a way as to retain the
         * immutability of the message, and MUST return an instance that has the
         * new UriInterface instance.
         *
         * @link http://tools.ietf.org/html/rfc3986#section-4.3
         * @param UriInterface $uri New request URI to use.
         * @param bool $preserveHost Preserve the original state of the Host header.
         * @return static
         */
        public function withUri(UriInterface $uri, $preserveHost = false);
    }
}

// file: vendor/psr/http-message/src/ResponseInterface.php
namespace Psr\Http\Message {

    /**
     * Representation of an outgoing, server-side response.
     *
     * Per the HTTP specification, this interface includes properties for
     * each of the following:
     *
     * - Protocol version
     * - Status code and reason phrase
     * - Headers
     * - Message body
     *
     * Responses are considered immutable; all methods that might change state MUST
     * be implemented such that they retain the internal state of the current
     * message and return an instance that contains the changed state.
     */
    interface ResponseInterface extends MessageInterface
    {
        /**
         * Gets the response status code.
         *
         * The status code is a 3-digit integer result code of the server's attempt
         * to understand and satisfy the request.
         *
         * @return int Status code.
         */
        public function getStatusCode();

        /**
         * Return an instance with the specified status code and, optionally, reason phrase.
         *
         * If no reason phrase is specified, implementations MAY choose to default
         * to the RFC 7231 or IANA recommended reason phrase for the response's
         * status code.
         *
         * This method MUST be implemented in such a way as to retain the
         * immutability of the message, and MUST return an instance that has the
         * updated status and reason phrase.
         *
         * @link http://tools.ietf.org/html/rfc7231#section-6
         * @link http://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml
         * @param int $code The 3-digit integer result code to set.
         * @param string $reasonPhrase The reason phrase to use with the
         *     provided status code; if none is provided, implementations MAY
         *     use the defaults as suggested in the HTTP specification.
         * @return static
         * @throws \InvalidArgumentException For invalid status code arguments.
         */
        public function withStatus($code, $reasonPhrase = '');

        /**
         * Gets the response reason phrase associated with the status code.
         *
         * Because a reason phrase is not a required element in a response
         * status line, the reason phrase value MAY be null. Implementations MAY
         * choose to return the default RFC 7231 recommended reason phrase (or those
         * listed in the IANA HTTP Status Code Registry) for the response's
         * status code.
         *
         * @link http://tools.ietf.org/html/rfc7231#section-6
         * @link http://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml
         * @return string Reason phrase; must return an empty string if none present.
         */
        public function getReasonPhrase();
    }
}

// file: vendor/psr/http-message/src/ServerRequestInterface.php
namespace Psr\Http\Message {

    /**
     * Representation of an incoming, server-side HTTP request.
     *
     * Per the HTTP specification, this interface includes properties for
     * each of the following:
     *
     * - Protocol version
     * - HTTP method
     * - URI
     * - Headers
     * - Message body
     *
     * Additionally, it encapsulates all data as it has arrived to the
     * application from the CGI and/or PHP environment, including:
     *
     * - The values represented in $_SERVER.
     * - Any cookies provided (generally via $_COOKIE)
     * - Query string arguments (generally via $_GET, or as parsed via parse_str())
     * - Upload files, if any (as represented by $_FILES)
     * - Deserialized body parameters (generally from $_POST)
     *
     * $_SERVER values MUST be treated as immutable, as they represent application
     * state at the time of request; as such, no methods are provided to allow
     * modification of those values. The other values provide such methods, as they
     * can be restored from $_SERVER or the request body, and may need treatment
     * during the application (e.g., body parameters may be deserialized based on
     * content type).
     *
     * Additionally, this interface recognizes the utility of introspecting a
     * request to derive and match additional parameters (e.g., via URI path
     * matching, decrypting cookie values, deserializing non-form-encoded body
     * content, matching authorization headers to users, etc). These parameters
     * are stored in an "attributes" property.
     *
     * Requests are considered immutable; all methods that might change state MUST
     * be implemented such that they retain the internal state of the current
     * message and return an instance that contains the changed state.
     */
    interface ServerRequestInterface extends RequestInterface
    {
        /**
         * Retrieve server parameters.
         *
         * Retrieves data related to the incoming request environment,
         * typically derived from PHP's $_SERVER superglobal. The data IS NOT
         * REQUIRED to originate from $_SERVER.
         *
         * @return array
         */
        public function getServerParams();

        /**
         * Retrieve cookies.
         *
         * Retrieves cookies sent by the client to the server.
         *
         * The data MUST be compatible with the structure of the $_COOKIE
         * superglobal.
         *
         * @return array
         */
        public function getCookieParams();

        /**
         * Return an instance with the specified cookies.
         *
         * The data IS NOT REQUIRED to come from the $_COOKIE superglobal, but MUST
         * be compatible with the structure of $_COOKIE. Typically, this data will
         * be injected at instantiation.
         *
         * This method MUST NOT update the related Cookie header of the request
         * instance, nor related values in the server params.
         *
         * This method MUST be implemented in such a way as to retain the
         * immutability of the message, and MUST return an instance that has the
         * updated cookie values.
         *
         * @param array $cookies Array of key/value pairs representing cookies.
         * @return static
         */
        public function withCookieParams(array $cookies);

        /**
         * Retrieve query string arguments.
         *
         * Retrieves the deserialized query string arguments, if any.
         *
         * Note: the query params might not be in sync with the URI or server
         * params. If you need to ensure you are only getting the original
         * values, you may need to parse the query string from `getUri()->getQuery()`
         * or from the `QUERY_STRING` server param.
         *
         * @return array
         */
        public function getQueryParams();

        /**
         * Return an instance with the specified query string arguments.
         *
         * These values SHOULD remain immutable over the course of the incoming
         * request. They MAY be injected during instantiation, such as from PHP's
         * $_GET superglobal, or MAY be derived from some other value such as the
         * URI. In cases where the arguments are parsed from the URI, the data
         * MUST be compatible with what PHP's parse_str() would return for
         * purposes of how duplicate query parameters are handled, and how nested
         * sets are handled.
         *
         * Setting query string arguments MUST NOT change the URI stored by the
         * request, nor the values in the server params.
         *
         * This method MUST be implemented in such a way as to retain the
         * immutability of the message, and MUST return an instance that has the
         * updated query string arguments.
         *
         * @param array $query Array of query string arguments, typically from
         *     $_GET.
         * @return static
         */
        public function withQueryParams(array $query);

        /**
         * Retrieve normalized file upload data.
         *
         * This method returns upload metadata in a normalized tree, with each leaf
         * an instance of Psr\Http\Message\UploadedFileInterface.
         *
         * These values MAY be prepared from $_FILES or the message body during
         * instantiation, or MAY be injected via withUploadedFiles().
         *
         * @return array An array tree of UploadedFileInterface instances; an empty
         *     array MUST be returned if no data is present.
         */
        public function getUploadedFiles();

        /**
         * Create a new instance with the specified uploaded files.
         *
         * This method MUST be implemented in such a way as to retain the
         * immutability of the message, and MUST return an instance that has the
         * updated body parameters.
         *
         * @param array $uploadedFiles An array tree of UploadedFileInterface instances.
         * @return static
         * @throws \InvalidArgumentException if an invalid structure is provided.
         */
        public function withUploadedFiles(array $uploadedFiles);

        /**
         * Retrieve any parameters provided in the request body.
         *
         * If the request Content-Type is either application/x-www-form-urlencoded
         * or multipart/form-data, and the request method is POST, this method MUST
         * return the contents of $_POST.
         *
         * Otherwise, this method may return any results of deserializing
         * the request body content; as parsing returns structured content, the
         * potential types MUST be arrays or objects only. A null value indicates
         * the absence of body content.
         *
         * @return null|array|object The deserialized body parameters, if any.
         *     These will typically be an array or object.
         */
        public function getParsedBody();

        /**
         * Return an instance with the specified body parameters.
         *
         * These MAY be injected during instantiation.
         *
         * If the request Content-Type is either application/x-www-form-urlencoded
         * or multipart/form-data, and the request method is POST, use this method
         * ONLY to inject the contents of $_POST.
         *
         * The data IS NOT REQUIRED to come from $_POST, but MUST be the results of
         * deserializing the request body content. Deserialization/parsing returns
         * structured data, and, as such, this method ONLY accepts arrays or objects,
         * or a null value if nothing was available to parse.
         *
         * As an example, if content negotiation determines that the request data
         * is a JSON payload, this method could be used to create a request
         * instance with the deserialized parameters.
         *
         * This method MUST be implemented in such a way as to retain the
         * immutability of the message, and MUST return an instance that has the
         * updated body parameters.
         *
         * @param null|array|object $data The deserialized body data. This will
         *     typically be in an array or object.
         * @return static
         * @throws \InvalidArgumentException if an unsupported argument type is
         *     provided.
         */
        public function withParsedBody($data);

        /**
         * Retrieve attributes derived from the request.
         *
         * The request "attributes" may be used to allow injection of any
         * parameters derived from the request: e.g., the results of path
         * match operations; the results of decrypting cookies; the results of
         * deserializing non-form-encoded message bodies; etc. Attributes
         * will be application and request specific, and CAN be mutable.
         *
         * @return array Attributes derived from the request.
         */
        public function getAttributes();

        /**
         * Retrieve a single derived request attribute.
         *
         * Retrieves a single derived request attribute as described in
         * getAttributes(). If the attribute has not been previously set, returns
         * the default value as provided.
         *
         * This method obviates the need for a hasAttribute() method, as it allows
         * specifying a default value to return if the attribute is not found.
         *
         * @see getAttributes()
         * @param string $name The attribute name.
         * @param mixed $default Default value to return if the attribute does not exist.
         * @return mixed
         */
        public function getAttribute($name, $default = null);

        /**
         * Return an instance with the specified derived request attribute.
         *
         * This method allows setting a single derived request attribute as
         * described in getAttributes().
         *
         * This method MUST be implemented in such a way as to retain the
         * immutability of the message, and MUST return an instance that has the
         * updated attribute.
         *
         * @see getAttributes()
         * @param string $name The attribute name.
         * @param mixed $value The value of the attribute.
         * @return static
         */
        public function withAttribute($name, $value);

        /**
         * Return an instance that removes the specified derived request attribute.
         *
         * This method allows removing a single derived request attribute as
         * described in getAttributes().
         *
         * This method MUST be implemented in such a way as to retain the
         * immutability of the message, and MUST return an instance that removes
         * the attribute.
         *
         * @see getAttributes()
         * @param string $name The attribute name.
         * @return static
         */
        public function withoutAttribute($name);
    }
}

// file: vendor/psr/http-message/src/StreamInterface.php
namespace Psr\Http\Message {

    /**
     * Describes a data stream.
     *
     * Typically, an instance will wrap a PHP stream; this interface provides
     * a wrapper around the most common operations, including serialization of
     * the entire stream to a string.
     */
    interface StreamInterface
    {
        /**
         * Reads all data from the stream into a string, from the beginning to end.
         *
         * This method MUST attempt to seek to the beginning of the stream before
         * reading data and read the stream until the end is reached.
         *
         * Warning: This could attempt to load a large amount of data into memory.
         *
         * This method MUST NOT raise an exception in order to conform with PHP's
         * string casting operations.
         *
         * @see http://php.net/manual/en/language.oop5.magic.php#object.tostring
         * @return string
         */
        public function __toString();

        /**
         * Closes the stream and any underlying resources.
         *
         * @return void
         */
        public function close();

        /**
         * Separates any underlying resources from the stream.
         *
         * After the stream has been detached, the stream is in an unusable state.
         *
         * @return resource|null Underlying PHP stream, if any
         */
        public function detach();

        /**
         * Get the size of the stream if known.
         *
         * @return int|null Returns the size in bytes if known, or null if unknown.
         */
        public function getSize();

        /**
         * Returns the current position of the file read/write pointer
         *
         * @return int Position of the file pointer
         * @throws \RuntimeException on error.
         */
        public function tell();

        /**
         * Returns true if the stream is at the end of the stream.
         *
         * @return bool
         */
        public function eof();

        /**
         * Returns whether or not the stream is seekable.
         *
         * @return bool
         */
        public function isSeekable();

        /**
         * Seek to a position in the stream.
         *
         * @link http://www.php.net/manual/en/function.fseek.php
         * @param int $offset Stream offset
         * @param int $whence Specifies how the cursor position will be calculated
         *     based on the seek offset. Valid values are identical to the built-in
         *     PHP $whence values for `fseek()`.  SEEK_SET: Set position equal to
         *     offset bytes SEEK_CUR: Set position to current location plus offset
         *     SEEK_END: Set position to end-of-stream plus offset.
         * @throws \RuntimeException on failure.
         */
        public function seek($offset, $whence = SEEK_SET);

        /**
         * Seek to the beginning of the stream.
         *
         * If the stream is not seekable, this method will raise an exception;
         * otherwise, it will perform a seek(0).
         *
         * @see seek()
         * @link http://www.php.net/manual/en/function.fseek.php
         * @throws \RuntimeException on failure.
         */
        public function rewind();

        /**
         * Returns whether or not the stream is writable.
         *
         * @return bool
         */
        public function isWritable();

        /**
         * Write data to the stream.
         *
         * @param string $string The string that is to be written.
         * @return int Returns the number of bytes written to the stream.
         * @throws \RuntimeException on failure.
         */
        public function write($string);

        /**
         * Returns whether or not the stream is readable.
         *
         * @return bool
         */
        public function isReadable();

        /**
         * Read data from the stream.
         *
         * @param int $length Read up to $length bytes from the object and return
         *     them. Fewer than $length bytes may be returned if underlying stream
         *     call returns fewer bytes.
         * @return string Returns the data read from the stream, or an empty string
         *     if no bytes are available.
         * @throws \RuntimeException if an error occurs.
         */
        public function read($length);

        /**
         * Returns the remaining contents in a string
         *
         * @return string
         * @throws \RuntimeException if unable to read or an error occurs while
         *     reading.
         */
        public function getContents();

        /**
         * Get stream metadata as an associative array or retrieve a specific key.
         *
         * The keys returned are identical to the keys returned from PHP's
         * stream_get_meta_data() function.
         *
         * @link http://php.net/manual/en/function.stream-get-meta-data.php
         * @param string $key Specific metadata to retrieve.
         * @return array|mixed|null Returns an associative array if no key is
         *     provided. Returns a specific key value if a key is provided and the
         *     value is found, or null if the key is not found.
         */
        public function getMetadata($key = null);
    }
}

// file: vendor/psr/http-message/src/UploadedFileInterface.php
namespace Psr\Http\Message {

    /**
     * Value object representing a file uploaded through an HTTP request.
     *
     * Instances of this interface are considered immutable; all methods that
     * might change state MUST be implemented such that they retain the internal
     * state of the current instance and return an instance that contains the
     * changed state.
     */
    interface UploadedFileInterface
    {
        /**
         * Retrieve a stream representing the uploaded file.
         *
         * This method MUST return a StreamInterface instance, representing the
         * uploaded file. The purpose of this method is to allow utilizing native PHP
         * stream functionality to manipulate the file upload, such as
         * stream_copy_to_stream() (though the result will need to be decorated in a
         * native PHP stream wrapper to work with such functions).
         *
         * If the moveTo() method has been called previously, this method MUST raise
         * an exception.
         *
         * @return StreamInterface Stream representation of the uploaded file.
         * @throws \RuntimeException in cases when no stream is available or can be
         *     created.
         */
        public function getStream();

        /**
         * Move the uploaded file to a new location.
         *
         * Use this method as an alternative to move_uploaded_file(). This method is
         * guaranteed to work in both SAPI and non-SAPI environments.
         * Implementations must determine which environment they are in, and use the
         * appropriate method (move_uploaded_file(), rename(), or a stream
         * operation) to perform the operation.
         *
         * $targetPath may be an absolute path, or a relative path. If it is a
         * relative path, resolution should be the same as used by PHP's rename()
         * function.
         *
         * The original file or stream MUST be removed on completion.
         *
         * If this method is called more than once, any subsequent calls MUST raise
         * an exception.
         *
         * When used in an SAPI environment where $_FILES is populated, when writing
         * files via moveTo(), is_uploaded_file() and move_uploaded_file() SHOULD be
         * used to ensure permissions and upload status are verified correctly.
         *
         * If you wish to move to a stream, use getStream(), as SAPI operations
         * cannot guarantee writing to stream destinations.
         *
         * @see http://php.net/is_uploaded_file
         * @see http://php.net/move_uploaded_file
         * @param string $targetPath Path to which to move the uploaded file.
         * @throws \InvalidArgumentException if the $targetPath specified is invalid.
         * @throws \RuntimeException on any error during the move operation, or on
         *     the second or subsequent call to the method.
         */
        public function moveTo($targetPath);
        
        /**
         * Retrieve the file size.
         *
         * Implementations SHOULD return the value stored in the "size" key of
         * the file in the $_FILES array if available, as PHP calculates this based
         * on the actual size transmitted.
         *
         * @return int|null The file size in bytes or null if unknown.
         */
        public function getSize();
        
        /**
         * Retrieve the error associated with the uploaded file.
         *
         * The return value MUST be one of PHP's UPLOAD_ERR_XXX constants.
         *
         * If the file was uploaded successfully, this method MUST return
         * UPLOAD_ERR_OK.
         *
         * Implementations SHOULD return the value stored in the "error" key of
         * the file in the $_FILES array.
         *
         * @see http://php.net/manual/en/features.file-upload.errors.php
         * @return int One of PHP's UPLOAD_ERR_XXX constants.
         */
        public function getError();
        
        /**
         * Retrieve the filename sent by the client.
         *
         * Do not trust the value returned by this method. A client could send
         * a malicious filename with the intention to corrupt or hack your
         * application.
         *
         * Implementations SHOULD return the value stored in the "name" key of
         * the file in the $_FILES array.
         *
         * @return string|null The filename sent by the client or null if none
         *     was provided.
         */
        public function getClientFilename();
        
        /**
         * Retrieve the media type sent by the client.
         *
         * Do not trust the value returned by this method. A client could send
         * a malicious media type with the intention to corrupt or hack your
         * application.
         *
         * Implementations SHOULD return the value stored in the "type" key of
         * the file in the $_FILES array.
         *
         * @return string|null The media type sent by the client or null if none
         *     was provided.
         */
        public function getClientMediaType();
    }
}

// file: vendor/psr/http-message/src/UriInterface.php
namespace Psr\Http\Message {

    /**
     * Value object representing a URI.
     *
     * This interface is meant to represent URIs according to RFC 3986 and to
     * provide methods for most common operations. Additional functionality for
     * working with URIs can be provided on top of the interface or externally.
     * Its primary use is for HTTP requests, but may also be used in other
     * contexts.
     *
     * Instances of this interface are considered immutable; all methods that
     * might change state MUST be implemented such that they retain the internal
     * state of the current instance and return an instance that contains the
     * changed state.
     *
     * Typically the Host header will be also be present in the request message.
     * For server-side requests, the scheme will typically be discoverable in the
     * server parameters.
     *
     * @link http://tools.ietf.org/html/rfc3986 (the URI specification)
     */
    interface UriInterface
    {
        /**
         * Retrieve the scheme component of the URI.
         *
         * If no scheme is present, this method MUST return an empty string.
         *
         * The value returned MUST be normalized to lowercase, per RFC 3986
         * Section 3.1.
         *
         * The trailing ":" character is not part of the scheme and MUST NOT be
         * added.
         *
         * @see https://tools.ietf.org/html/rfc3986#section-3.1
         * @return string The URI scheme.
         */
        public function getScheme();

        /**
         * Retrieve the authority component of the URI.
         *
         * If no authority information is present, this method MUST return an empty
         * string.
         *
         * The authority syntax of the URI is:
         *
         * <pre>
         * [user-info@]host[:port]
         * </pre>
         *
         * If the port component is not set or is the standard port for the current
         * scheme, it SHOULD NOT be included.
         *
         * @see https://tools.ietf.org/html/rfc3986#section-3.2
         * @return string The URI authority, in "[user-info@]host[:port]" format.
         */
        public function getAuthority();

        /**
         * Retrieve the user information component of the URI.
         *
         * If no user information is present, this method MUST return an empty
         * string.
         *
         * If a user is present in the URI, this will return that value;
         * additionally, if the password is also present, it will be appended to the
         * user value, with a colon (":") separating the values.
         *
         * The trailing "@" character is not part of the user information and MUST
         * NOT be added.
         *
         * @return string The URI user information, in "username[:password]" format.
         */
        public function getUserInfo();

        /**
         * Retrieve the host component of the URI.
         *
         * If no host is present, this method MUST return an empty string.
         *
         * The value returned MUST be normalized to lowercase, per RFC 3986
         * Section 3.2.2.
         *
         * @see http://tools.ietf.org/html/rfc3986#section-3.2.2
         * @return string The URI host.
         */
        public function getHost();

        /**
         * Retrieve the port component of the URI.
         *
         * If a port is present, and it is non-standard for the current scheme,
         * this method MUST return it as an integer. If the port is the standard port
         * used with the current scheme, this method SHOULD return null.
         *
         * If no port is present, and no scheme is present, this method MUST return
         * a null value.
         *
         * If no port is present, but a scheme is present, this method MAY return
         * the standard port for that scheme, but SHOULD return null.
         *
         * @return null|int The URI port.
         */
        public function getPort();

        /**
         * Retrieve the path component of the URI.
         *
         * The path can either be empty or absolute (starting with a slash) or
         * rootless (not starting with a slash). Implementations MUST support all
         * three syntaxes.
         *
         * Normally, the empty path "" and absolute path "/" are considered equal as
         * defined in RFC 7230 Section 2.7.3. But this method MUST NOT automatically
         * do this normalization because in contexts with a trimmed base path, e.g.
         * the front controller, this difference becomes significant. It's the task
         * of the user to handle both "" and "/".
         *
         * The value returned MUST be percent-encoded, but MUST NOT double-encode
         * any characters. To determine what characters to encode, please refer to
         * RFC 3986, Sections 2 and 3.3.
         *
         * As an example, if the value should include a slash ("/") not intended as
         * delimiter between path segments, that value MUST be passed in encoded
         * form (e.g., "%2F") to the instance.
         *
         * @see https://tools.ietf.org/html/rfc3986#section-2
         * @see https://tools.ietf.org/html/rfc3986#section-3.3
         * @return string The URI path.
         */
        public function getPath();

        /**
         * Retrieve the query string of the URI.
         *
         * If no query string is present, this method MUST return an empty string.
         *
         * The leading "?" character is not part of the query and MUST NOT be
         * added.
         *
         * The value returned MUST be percent-encoded, but MUST NOT double-encode
         * any characters. To determine what characters to encode, please refer to
         * RFC 3986, Sections 2 and 3.4.
         *
         * As an example, if a value in a key/value pair of the query string should
         * include an ampersand ("&") not intended as a delimiter between values,
         * that value MUST be passed in encoded form (e.g., "%26") to the instance.
         *
         * @see https://tools.ietf.org/html/rfc3986#section-2
         * @see https://tools.ietf.org/html/rfc3986#section-3.4
         * @return string The URI query string.
         */
        public function getQuery();

        /**
         * Retrieve the fragment component of the URI.
         *
         * If no fragment is present, this method MUST return an empty string.
         *
         * The leading "#" character is not part of the fragment and MUST NOT be
         * added.
         *
         * The value returned MUST be percent-encoded, but MUST NOT double-encode
         * any characters. To determine what characters to encode, please refer to
         * RFC 3986, Sections 2 and 3.5.
         *
         * @see https://tools.ietf.org/html/rfc3986#section-2
         * @see https://tools.ietf.org/html/rfc3986#section-3.5
         * @return string The URI fragment.
         */
        public function getFragment();

        /**
         * Return an instance with the specified scheme.
         *
         * This method MUST retain the state of the current instance, and return
         * an instance that contains the specified scheme.
         *
         * Implementations MUST support the schemes "http" and "https" case
         * insensitively, and MAY accommodate other schemes if required.
         *
         * An empty scheme is equivalent to removing the scheme.
         *
         * @param string $scheme The scheme to use with the new instance.
         * @return static A new instance with the specified scheme.
         * @throws \InvalidArgumentException for invalid or unsupported schemes.
         */
        public function withScheme($scheme);

        /**
         * Return an instance with the specified user information.
         *
         * This method MUST retain the state of the current instance, and return
         * an instance that contains the specified user information.
         *
         * Password is optional, but the user information MUST include the
         * user; an empty string for the user is equivalent to removing user
         * information.
         *
         * @param string $user The user name to use for authority.
         * @param null|string $password The password associated with $user.
         * @return static A new instance with the specified user information.
         */
        public function withUserInfo($user, $password = null);

        /**
         * Return an instance with the specified host.
         *
         * This method MUST retain the state of the current instance, and return
         * an instance that contains the specified host.
         *
         * An empty host value is equivalent to removing the host.
         *
         * @param string $host The hostname to use with the new instance.
         * @return static A new instance with the specified host.
         * @throws \InvalidArgumentException for invalid hostnames.
         */
        public function withHost($host);

        /**
         * Return an instance with the specified port.
         *
         * This method MUST retain the state of the current instance, and return
         * an instance that contains the specified port.
         *
         * Implementations MUST raise an exception for ports outside the
         * established TCP and UDP port ranges.
         *
         * A null value provided for the port is equivalent to removing the port
         * information.
         *
         * @param null|int $port The port to use with the new instance; a null value
         *     removes the port information.
         * @return static A new instance with the specified port.
         * @throws \InvalidArgumentException for invalid ports.
         */
        public function withPort($port);

        /**
         * Return an instance with the specified path.
         *
         * This method MUST retain the state of the current instance, and return
         * an instance that contains the specified path.
         *
         * The path can either be empty or absolute (starting with a slash) or
         * rootless (not starting with a slash). Implementations MUST support all
         * three syntaxes.
         *
         * If the path is intended to be domain-relative rather than path relative then
         * it must begin with a slash ("/"). Paths not starting with a slash ("/")
         * are assumed to be relative to some base path known to the application or
         * consumer.
         *
         * Users can provide both encoded and decoded path characters.
         * Implementations ensure the correct encoding as outlined in getPath().
         *
         * @param string $path The path to use with the new instance.
         * @return static A new instance with the specified path.
         * @throws \InvalidArgumentException for invalid paths.
         */
        public function withPath($path);

        /**
         * Return an instance with the specified query string.
         *
         * This method MUST retain the state of the current instance, and return
         * an instance that contains the specified query string.
         *
         * Users can provide both encoded and decoded query characters.
         * Implementations ensure the correct encoding as outlined in getQuery().
         *
         * An empty query string value is equivalent to removing the query string.
         *
         * @param string $query The query string to use with the new instance.
         * @return static A new instance with the specified query string.
         * @throws \InvalidArgumentException for invalid query strings.
         */
        public function withQuery($query);

        /**
         * Return an instance with the specified URI fragment.
         *
         * This method MUST retain the state of the current instance, and return
         * an instance that contains the specified URI fragment.
         *
         * Users can provide both encoded and decoded fragment characters.
         * Implementations ensure the correct encoding as outlined in getFragment().
         *
         * An empty fragment value is equivalent to removing the fragment.
         *
         * @param string $fragment The fragment to use with the new instance.
         * @return static A new instance with the specified fragment.
         */
        public function withFragment($fragment);

        /**
         * Return the string representation as a URI reference.
         *
         * Depending on which components of the URI are present, the resulting
         * string is either a full URI or relative reference according to RFC 3986,
         * Section 4.1. The method concatenates the various components of the URI,
         * using the appropriate delimiters:
         *
         * - If a scheme is present, it MUST be suffixed by ":".
         * - If an authority is present, it MUST be prefixed by "//".
         * - The path can be concatenated without delimiters. But there are two
         *   cases where the path has to be adjusted to make the URI reference
         *   valid as PHP does not allow to throw an exception in __toString():
         *     - If the path is rootless and an authority is present, the path MUST
         *       be prefixed by "/".
         *     - If the path is starting with more than one "/" and no authority is
         *       present, the starting slashes MUST be reduced to one.
         * - If a query is present, it MUST be prefixed by "?".
         * - If a fragment is present, it MUST be prefixed by "#".
         *
         * @see http://tools.ietf.org/html/rfc3986#section-4.1
         * @return string
         */
        public function __toString();
    }
}

// file: vendor/psr/http-server-handler/src/RequestHandlerInterface.php
namespace Psr\Http\Server {

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;

    /**
     * Handles a server request and produces a response.
     *
     * An HTTP request handler process an HTTP request in order to produce an
     * HTTP response.
     */
    interface RequestHandlerInterface
    {
        /**
         * Handles a request and produces a response.
         *
         * May call other collaborating code to generate the response.
         */
        public function handle(ServerRequestInterface $request): ResponseInterface;
    }
}

// file: vendor/psr/http-server-middleware/src/MiddlewareInterface.php
namespace Psr\Http\Server {

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;

    /**
     * Participant in processing a server request and response.
     *
     * An HTTP middleware component participates in processing an HTTP message:
     * by acting on the request, generating the response, or forwarding the
     * request to a subsequent middleware and possibly acting on its response.
     */
    interface MiddlewareInterface
    {
        /**
         * Process an incoming server request.
         *
         * Processes an incoming server request in order to produce a response.
         * If unable to produce the response itself, it may delegate to the provided
         * request handler to do so.
         */
        public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface;
    }
}

// file: vendor/nyholm/psr7/src/Factory/Psr17Factory.php
namespace Nyholm\Psr7\Factory {

    use Nyholm\Psr7\{Request, Response, ServerRequest, Stream, UploadedFile, Uri};
    use Psr\Http\Message\{RequestFactoryInterface, RequestInterface, ResponseFactoryInterface, ResponseInterface, ServerRequestFactoryInterface, ServerRequestInterface, StreamFactoryInterface, StreamInterface, UploadedFileFactoryInterface, UploadedFileInterface, UriFactoryInterface, UriInterface};

    /**
     * @author Tobias Nyholm <tobias.nyholm@gmail.com>
     * @author Martijn van der Ven <martijn@vanderven.se>
     *
     * @final This class should never be extended. See https://github.com/Nyholm/psr7/blob/master/doc/final.md
     */
    class Psr17Factory implements RequestFactoryInterface, ResponseFactoryInterface, ServerRequestFactoryInterface, StreamFactoryInterface, UploadedFileFactoryInterface, UriFactoryInterface
    {
        public function createRequest(string $method, $uri): RequestInterface
        {
            return new Request($method, $uri);
        }

        public function createResponse(int $code = 200, string $reasonPhrase = ''): ResponseInterface
        {
            if (2 > \func_num_args()) {
                // This will make the Response class to use a custom reasonPhrase
                $reasonPhrase = null;
            }

            return new Response($code, [], null, '1.1', $reasonPhrase);
        }

        public function createStream(string $content = ''): StreamInterface
        {
            return Stream::create($content);
        }

        public function createStreamFromFile(string $filename, string $mode = 'r'): StreamInterface
        {
            $resource = @\fopen($filename, $mode);
            if (false === $resource) {
                if ('' === $mode || false === \in_array($mode[0], ['r', 'w', 'a', 'x', 'c'])) {
                    throw new \InvalidArgumentException('The mode ' . $mode . ' is invalid.');
                }

                throw new \RuntimeException('The file ' . $filename . ' cannot be opened.');
            }

            return Stream::create($resource);
        }

        public function createStreamFromResource($resource): StreamInterface
        {
            return Stream::create($resource);
        }

        public function createUploadedFile(StreamInterface $stream, int $size = null, int $error = \UPLOAD_ERR_OK, string $clientFilename = null, string $clientMediaType = null): UploadedFileInterface
        {
            if (null === $size) {
                $size = $stream->getSize();
            }

            return new UploadedFile($stream, $size, $error, $clientFilename, $clientMediaType);
        }

        public function createUri(string $uri = ''): UriInterface
        {
            return new Uri($uri);
        }

        public function createServerRequest(string $method, $uri, array $serverParams = []): ServerRequestInterface
        {
            return new ServerRequest($method, $uri, [], null, '1.1', $serverParams);
        }
    }
}

// file: vendor/nyholm/psr7/src/MessageTrait.php
namespace Nyholm\Psr7 {

    use Psr\Http\Message\StreamInterface;

    /**
     * Trait implementing functionality common to requests and responses.
     *
     * @author Michael Dowling and contributors to guzzlehttp/psr7
     * @author Tobias Nyholm <tobias.nyholm@gmail.com>
     * @author Martijn van der Ven <martijn@vanderven.se>
     *
     * @internal should not be used outside of Nyholm/Psr7 as it does not fall under our BC promise
     */
    trait MessageTrait
    {
        /** @var array Map of all registered headers, as original name => array of values */
        private $headers = [];

        /** @var array Map of lowercase header name => original name at registration */
        private $headerNames = [];

        /** @var string */
        private $protocol = '1.1';

        /** @var StreamInterface|null */
        private $stream;

        public function getProtocolVersion(): string
        {
            return $this->protocol;
        }

        public function withProtocolVersion($version): self
        {
            if ($this->protocol === $version) {
                return $this;
            }

            $new = clone $this;
            $new->protocol = $version;

            return $new;
        }

        public function getHeaders(): array
        {
            return $this->headers;
        }

        public function hasHeader($header): bool
        {
            return isset($this->headerNames[\strtr($header, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz')]);
        }

        public function getHeader($header): array
        {
            $header = \strtr($header, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz');
            if (!isset($this->headerNames[$header])) {
                return [];
            }

            $header = $this->headerNames[$header];

            return $this->headers[$header];
        }

        public function getHeaderLine($header): string
        {
            return \implode(', ', $this->getHeader($header));
        }

        public function withHeader($header, $value): self
        {
            $value = $this->validateAndTrimHeader($header, $value);
            $normalized = \strtr($header, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz');

            $new = clone $this;
            if (isset($new->headerNames[$normalized])) {
                unset($new->headers[$new->headerNames[$normalized]]);
            }
            $new->headerNames[$normalized] = $header;
            $new->headers[$header] = $value;

            return $new;
        }

        public function withAddedHeader($header, $value): self
        {
            if (!\is_string($header) || '' === $header) {
                throw new \InvalidArgumentException('Header name must be an RFC 7230 compatible string.');
            }

            $new = clone $this;
            $new->setHeaders([$header => $value]);

            return $new;
        }

        public function withoutHeader($header): self
        {
            $normalized = \strtr($header, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz');
            if (!isset($this->headerNames[$normalized])) {
                return $this;
            }

            $header = $this->headerNames[$normalized];
            $new = clone $this;
            unset($new->headers[$header], $new->headerNames[$normalized]);

            return $new;
        }

        public function getBody(): StreamInterface
        {
            if (null === $this->stream) {
                $this->stream = Stream::create('');
            }

            return $this->stream;
        }

        public function withBody(StreamInterface $body): self
        {
            if ($body === $this->stream) {
                return $this;
            }

            $new = clone $this;
            $new->stream = $body;

            return $new;
        }

        private function setHeaders(array $headers) /*:void*/
        {
            foreach ($headers as $header => $value) {
                if (\is_int($header)) {
                    // If a header name was set to a numeric string, PHP will cast the key to an int.
                    // We must cast it back to a string in order to comply with validation.
                    $header = (string) $header;
                }
                $value = $this->validateAndTrimHeader($header, $value);
                $normalized = \strtr($header, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz');
                if (isset($this->headerNames[$normalized])) {
                    $header = $this->headerNames[$normalized];
                    $this->headers[$header] = \array_merge($this->headers[$header], $value);
                } else {
                    $this->headerNames[$normalized] = $header;
                    $this->headers[$header] = $value;
                }
            }
        }

        /**
         * Make sure the header complies with RFC 7230.
         *
         * Header names must be a non-empty string consisting of token characters.
         *
         * Header values must be strings consisting of visible characters with all optional
         * leading and trailing whitespace stripped. This method will always strip such
         * optional whitespace. Note that the method does not allow folding whitespace within
         * the values as this was deprecated for almost all instances by the RFC.
         *
         * header-field = field-name ":" OWS field-value OWS
         * field-name   = 1*( "!" / "#" / "$" / "%" / "&" / "'" / "*" / "+" / "-" / "." / "^"
         *              / "_" / "`" / "|" / "~" / %x30-39 / ( %x41-5A / %x61-7A ) )
         * OWS          = *( SP / HTAB )
         * field-value  = *( ( %x21-7E / %x80-FF ) [ 1*( SP / HTAB ) ( %x21-7E / %x80-FF ) ] )
         *
         * @see https://tools.ietf.org/html/rfc7230#section-3.2.4
         */
        private function validateAndTrimHeader($header, $values): array
        {
            if (!\is_string($header) || 1 !== \preg_match("@^[!#$%&'*+.^_`|~0-9A-Za-z-]+$@", $header)) {
                throw new \InvalidArgumentException('Header name must be an RFC 7230 compatible string.');
            }

            if (!\is_array($values)) {
                // This is simple, just one value.
                if ((!\is_numeric($values) && !\is_string($values)) || 1 !== \preg_match("@^[ \t\x21-\x7E\x80-\xFF]*$@", (string) $values)) {
                    throw new \InvalidArgumentException('Header values must be RFC 7230 compatible strings.');
                }

                return [\trim((string) $values, " \t")];
            }

            if (empty($values)) {
                throw new \InvalidArgumentException('Header values must be a string or an array of strings, empty array given.');
            }

            // Assert Non empty array
            $returnValues = [];
            foreach ($values as $v) {
                if ((!\is_numeric($v) && !\is_string($v)) || 1 !== \preg_match("@^[ \t\x21-\x7E\x80-\xFF]*$@", (string) $v)) {
                    throw new \InvalidArgumentException('Header values must be RFC 7230 compatible strings.');
                }

                $returnValues[] = \trim((string) $v, " \t");
            }

            return $returnValues;
        }
    }
}

// file: vendor/nyholm/psr7/src/Request.php
namespace Nyholm\Psr7 {

    use Psr\Http\Message\{RequestInterface, StreamInterface, UriInterface};

    /**
     * @author Tobias Nyholm <tobias.nyholm@gmail.com>
     * @author Martijn van der Ven <martijn@vanderven.se>
     *
     * @final This class should never be extended. See https://github.com/Nyholm/psr7/blob/master/doc/final.md
     */
    class Request implements RequestInterface
    {
        use MessageTrait;
        use RequestTrait;

        /**
         * @param string $method HTTP method
         * @param string|UriInterface $uri URI
         * @param array $headers Request headers
         * @param string|resource|StreamInterface|null $body Request body
         * @param string $version Protocol version
         */
        public function __construct(string $method, $uri, array $headers = [], $body = null, string $version = '1.1')
        {
            if (!($uri instanceof UriInterface)) {
                $uri = new Uri($uri);
            }

            $this->method = $method;
            $this->uri = $uri;
            $this->setHeaders($headers);
            $this->protocol = $version;

            if (!$this->hasHeader('Host')) {
                $this->updateHostFromUri();
            }

            // If we got no body, defer initialization of the stream until Request::getBody()
            if ('' !== $body && null !== $body) {
                $this->stream = Stream::create($body);
            }
        }
    }
}

// file: vendor/nyholm/psr7/src/RequestTrait.php
namespace Nyholm\Psr7 {

    use Psr\Http\Message\UriInterface;

    /**
     * @author Michael Dowling and contributors to guzzlehttp/psr7
     * @author Tobias Nyholm <tobias.nyholm@gmail.com>
     * @author Martijn van der Ven <martijn@vanderven.se>
     *
     * @internal should not be used outside of Nyholm/Psr7 as it does not fall under our BC promise
     */
    trait RequestTrait
    {
        /** @var string */
        private $method;

        /** @var string|null */
        private $requestTarget;

        /** @var UriInterface|null */
        private $uri;

        public function getRequestTarget(): string
        {
            if (null !== $this->requestTarget) {
                return $this->requestTarget;
            }

            if ('' === $target = $this->uri->getPath()) {
                $target = '/';
            }
            if ('' !== $this->uri->getQuery()) {
                $target .= '?' . $this->uri->getQuery();
            }

            return $target;
        }

        public function withRequestTarget($requestTarget): self
        {
            if (\preg_match('#\s#', $requestTarget)) {
                throw new \InvalidArgumentException('Invalid request target provided; cannot contain whitespace');
            }

            $new = clone $this;
            $new->requestTarget = $requestTarget;

            return $new;
        }

        public function getMethod(): string
        {
            return $this->method;
        }

        public function withMethod($method): self
        {
            if (!\is_string($method)) {
                throw new \InvalidArgumentException('Method must be a string');
            }

            $new = clone $this;
            $new->method = $method;

            return $new;
        }

        public function getUri(): UriInterface
        {
            return $this->uri;
        }

        public function withUri(UriInterface $uri, $preserveHost = false): self
        {
            if ($uri === $this->uri) {
                return $this;
            }

            $new = clone $this;
            $new->uri = $uri;

            if (!$preserveHost || !$this->hasHeader('Host')) {
                $new->updateHostFromUri();
            }

            return $new;
        }

        private function updateHostFromUri() /*:void*/
        {
            if ('' === $host = $this->uri->getHost()) {
                return;
            }

            if (null !== ($port = $this->uri->getPort())) {
                $host .= ':' . $port;
            }

            if (isset($this->headerNames['host'])) {
                $header = $this->headerNames['host'];
            } else {
                $this->headerNames['host'] = $header = 'Host';
            }

            // Ensure Host is the first header.
            // See: http://tools.ietf.org/html/rfc7230#section-5.4
            $this->headers = [$header => [$host]] + $this->headers;
        }
    }
}

// file: vendor/nyholm/psr7/src/Response.php
namespace Nyholm\Psr7 {

    use Psr\Http\Message\{ResponseInterface, StreamInterface};

    /**
     * @author Michael Dowling and contributors to guzzlehttp/psr7
     * @author Tobias Nyholm <tobias.nyholm@gmail.com>
     * @author Martijn van der Ven <martijn@vanderven.se>
     *
     * @final This class should never be extended. See https://github.com/Nyholm/psr7/blob/master/doc/final.md
     */
    class Response implements ResponseInterface
    {
        use MessageTrait;

        /** @var array Map of standard HTTP status code/reason phrases */
        /*private*/ const PHRASES = [
            100 => 'Continue', 101 => 'Switching Protocols', 102 => 'Processing',
            200 => 'OK', 201 => 'Created', 202 => 'Accepted', 203 => 'Non-Authoritative Information', 204 => 'No Content', 205 => 'Reset Content', 206 => 'Partial Content', 207 => 'Multi-status', 208 => 'Already Reported',
            300 => 'Multiple Choices', 301 => 'Moved Permanently', 302 => 'Found', 303 => 'See Other', 304 => 'Not Modified', 305 => 'Use Proxy', 306 => 'Switch Proxy', 307 => 'Temporary Redirect',
            400 => 'Bad Request', 401 => 'Unauthorized', 402 => 'Payment Required', 403 => 'Forbidden', 404 => 'Not Found', 405 => 'Method Not Allowed', 406 => 'Not Acceptable', 407 => 'Proxy Authentication Required', 408 => 'Request Time-out', 409 => 'Conflict', 410 => 'Gone', 411 => 'Length Required', 412 => 'Precondition Failed', 413 => 'Request Entity Too Large', 414 => 'Request-URI Too Large', 415 => 'Unsupported Media Type', 416 => 'Requested range not satisfiable', 417 => 'Expectation Failed', 418 => 'I\'m a teapot', 422 => 'Unprocessable Entity', 423 => 'Locked', 424 => 'Failed Dependency', 425 => 'Unordered Collection', 426 => 'Upgrade Required', 428 => 'Precondition Required', 429 => 'Too Many Requests', 431 => 'Request Header Fields Too Large', 451 => 'Unavailable For Legal Reasons',
            500 => 'Internal Server Error', 501 => 'Not Implemented', 502 => 'Bad Gateway', 503 => 'Service Unavailable', 504 => 'Gateway Time-out', 505 => 'HTTP Version not supported', 506 => 'Variant Also Negotiates', 507 => 'Insufficient Storage', 508 => 'Loop Detected', 511 => 'Network Authentication Required',
        ];

        /** @var string */
        private $reasonPhrase = '';

        /** @var int */
        private $statusCode;

        /**
         * @param int $status Status code
         * @param array $headers Response headers
         * @param string|resource|StreamInterface|null $body Response body
         * @param string $version Protocol version
         * @param string|null $reason Reason phrase (when empty a default will be used based on the status code)
         */
        public function __construct(int $status = 200, array $headers = [], $body = null, string $version = '1.1', string $reason = null)
        {
            // If we got no body, defer initialization of the stream until Response::getBody()
            if ('' !== $body && null !== $body) {
                $this->stream = Stream::create($body);
            }

            $this->statusCode = $status;
            $this->setHeaders($headers);
            if (null === $reason && isset(self::PHRASES[$this->statusCode])) {
                $this->reasonPhrase = self::PHRASES[$status];
            } else {
                $this->reasonPhrase = $reason ?? '';
            }

            $this->protocol = $version;
        }

        public function getStatusCode(): int
        {
            return $this->statusCode;
        }

        public function getReasonPhrase(): string
        {
            return $this->reasonPhrase;
        }

        public function withStatus($code, $reasonPhrase = ''): self
        {
            if (!\is_int($code) && !\is_string($code)) {
                throw new \InvalidArgumentException('Status code has to be an integer');
            }

            $code = (int) $code;
            if ($code < 100 || $code > 599) {
                throw new \InvalidArgumentException(\sprintf('Status code has to be an integer between 100 and 599. A status code of %d was given', $code));
            }

            $new = clone $this;
            $new->statusCode = $code;
            if ((null === $reasonPhrase || '' === $reasonPhrase) && isset(self::PHRASES[$new->statusCode])) {
                $reasonPhrase = self::PHRASES[$new->statusCode];
            }
            $new->reasonPhrase = $reasonPhrase;

            return $new;
        }
    }
}

// file: vendor/nyholm/psr7/src/ServerRequest.php
namespace Nyholm\Psr7 {

    use Psr\Http\Message\{ServerRequestInterface, StreamInterface, UploadedFileInterface, UriInterface};

    /**
     * @author Michael Dowling and contributors to guzzlehttp/psr7
     * @author Tobias Nyholm <tobias.nyholm@gmail.com>
     * @author Martijn van der Ven <martijn@vanderven.se>
     *
     * @final This class should never be extended. See https://github.com/Nyholm/psr7/blob/master/doc/final.md
     */
    class ServerRequest implements ServerRequestInterface
    {
        use MessageTrait;
        use RequestTrait;

        /** @var array */
        private $attributes = [];

        /** @var array */
        private $cookieParams = [];

        /** @var array|object|null */
        private $parsedBody;

        /** @var array */
        private $queryParams = [];

        /** @var array */
        private $serverParams;

        /** @var UploadedFileInterface[] */
        private $uploadedFiles = [];

        /**
         * @param string $method HTTP method
         * @param string|UriInterface $uri URI
         * @param array $headers Request headers
         * @param string|resource|StreamInterface|null $body Request body
         * @param string $version Protocol version
         * @param array $serverParams Typically the $_SERVER superglobal
         */
        public function __construct(string $method, $uri, array $headers = [], $body = null, string $version = '1.1', array $serverParams = [])
        {
            $this->serverParams = $serverParams;

            if (!($uri instanceof UriInterface)) {
                $uri = new Uri($uri);
            }

            $this->method = $method;
            $this->uri = $uri;
            $this->setHeaders($headers);
            $this->protocol = $version;

            if (!$this->hasHeader('Host')) {
                $this->updateHostFromUri();
            }

            // If we got no body, defer initialization of the stream until ServerRequest::getBody()
            if ('' !== $body && null !== $body) {
                $this->stream = Stream::create($body);
            }
        }

        public function getServerParams(): array
        {
            return $this->serverParams;
        }

        public function getUploadedFiles(): array
        {
            return $this->uploadedFiles;
        }

        public function withUploadedFiles(array $uploadedFiles)
        {
            $new = clone $this;
            $new->uploadedFiles = $uploadedFiles;

            return $new;
        }

        public function getCookieParams(): array
        {
            return $this->cookieParams;
        }

        public function withCookieParams(array $cookies)
        {
            $new = clone $this;
            $new->cookieParams = $cookies;

            return $new;
        }

        public function getQueryParams(): array
        {
            return $this->queryParams;
        }

        public function withQueryParams(array $query)
        {
            $new = clone $this;
            $new->queryParams = $query;

            return $new;
        }

        public function getParsedBody()
        {
            return $this->parsedBody;
        }

        public function withParsedBody($data)
        {
            if (!\is_array($data) && !\is_object($data) && null !== $data) {
                throw new \InvalidArgumentException('First parameter to withParsedBody MUST be object, array or null');
            }

            $new = clone $this;
            $new->parsedBody = $data;

            return $new;
        }

        public function getAttributes(): array
        {
            return $this->attributes;
        }

        public function getAttribute($attribute, $default = null)
        {
            if (false === \array_key_exists($attribute, $this->attributes)) {
                return $default;
            }

            return $this->attributes[$attribute];
        }

        public function withAttribute($attribute, $value): self
        {
            $new = clone $this;
            $new->attributes[$attribute] = $value;

            return $new;
        }

        public function withoutAttribute($attribute): self
        {
            if (false === \array_key_exists($attribute, $this->attributes)) {
                return $this;
            }

            $new = clone $this;
            unset($new->attributes[$attribute]);

            return $new;
        }
    }
}

// file: vendor/nyholm/psr7/src/Stream.php
namespace Nyholm\Psr7 {

    use Psr\Http\Message\StreamInterface;
    use Symfony\Component\Debug\ErrorHandler as SymfonyLegacyErrorHandler;
    use Symfony\Component\ErrorHandler\ErrorHandler as SymfonyErrorHandler;

    /**
     * @author Michael Dowling and contributors to guzzlehttp/psr7
     * @author Tobias Nyholm <tobias.nyholm@gmail.com>
     * @author Martijn van der Ven <martijn@vanderven.se>
     *
     * @final This class should never be extended. See https://github.com/Nyholm/psr7/blob/master/doc/final.md
     */
    class Stream implements StreamInterface
    {
        /** @var resource|null A resource reference */
        private $stream;

        /** @var bool */
        private $seekable;

        /** @var bool */
        private $readable;

        /** @var bool */
        private $writable;

        /** @var array|mixed|void|bool|null */
        private $uri;

        /** @var int|null */
        private $size;

        /** @var array Hash of readable and writable stream types */
        /*private*/ const READ_WRITE_HASH = [
            'read' => [
                'r' => true, 'w+' => true, 'r+' => true, 'x+' => true, 'c+' => true,
                'rb' => true, 'w+b' => true, 'r+b' => true, 'x+b' => true,
                'c+b' => true, 'rt' => true, 'w+t' => true, 'r+t' => true,
                'x+t' => true, 'c+t' => true, 'a+' => true,
            ],
            'write' => [
                'w' => true, 'w+' => true, 'rw' => true, 'r+' => true, 'x+' => true,
                'c+' => true, 'wb' => true, 'w+b' => true, 'r+b' => true,
                'x+b' => true, 'c+b' => true, 'w+t' => true, 'r+t' => true,
                'x+t' => true, 'c+t' => true, 'a' => true, 'a+' => true,
            ],
        ];

        private function __construct()
        {
        }

        /**
         * Creates a new PSR-7 stream.
         *
         * @param string|resource|StreamInterface $body
         *
         * @throws \InvalidArgumentException
         */
        public static function create($body = ''): StreamInterface
        {
            if ($body instanceof StreamInterface) {
                return $body;
            }

            if (\is_string($body)) {
                $resource = \fopen('php://temp', 'rw+');
                \fwrite($resource, $body);
                $body = $resource;
            }

            if (\is_resource($body)) {
                $new = new self();
                $new->stream = $body;
                $meta = \stream_get_meta_data($new->stream);
                $new->seekable = $meta['seekable'] && 0 === \fseek($new->stream, 0, \SEEK_CUR);
                $new->readable = isset(self::READ_WRITE_HASH['read'][$meta['mode']]);
                $new->writable = isset(self::READ_WRITE_HASH['write'][$meta['mode']]);

                return $new;
            }

            throw new \InvalidArgumentException('First argument to Stream::create() must be a string, resource or StreamInterface.');
        }

        /**
         * Closes the stream when the destructed.
         */
        public function __destruct()
        {
            $this->close();
        }

        /**
         * @return string
         */
        public function __toString()
        {
            try {
                if ($this->isSeekable()) {
                    $this->seek(0);
                }

                return $this->getContents();
            } catch (\Throwable $e) {
                if (\PHP_VERSION_ID >= 70400) {
                    throw $e;
                }

                if (\is_array($errorHandler = \set_error_handler('var_dump'))) {
                    $errorHandler = $errorHandler[0] ?? null;
                }
                \restore_error_handler();

                if ($e instanceof \Error || $errorHandler instanceof SymfonyErrorHandler || $errorHandler instanceof SymfonyLegacyErrorHandler) {
                    return \trigger_error((string) $e, \E_USER_ERROR);
                }

                return '';
            }
        }

        public function close() /*:void*/
        {
            if (isset($this->stream)) {
                if (\is_resource($this->stream)) {
                    \fclose($this->stream);
                }
                $this->detach();
            }
        }

        public function detach()
        {
            if (!isset($this->stream)) {
                return null;
            }

            $result = $this->stream;
            unset($this->stream);
            $this->size = $this->uri = null;
            $this->readable = $this->writable = $this->seekable = false;

            return $result;
        }

        public function getSize() /*:?int*/
        {
            if (null !== $this->size) {
                return $this->size;
            }

            if (!isset($this->stream)) {
                return null;
            }

            // Clear the stat cache if the stream has a URI
            if ($uri = $this->getUri()) {
                \clearstatcache(true, $uri);
            }

            $stats = \fstat($this->stream);
            if (isset($stats['size'])) {
                $this->size = $stats['size'];

                return $this->size;
            }

            return null;
        }

        public function tell(): int
        {
            if (false === $result = \ftell($this->stream)) {
                throw new \RuntimeException('Unable to determine stream position');
            }

            return $result;
        }

        public function eof(): bool
        {
            return !$this->stream || \feof($this->stream);
        }

        public function isSeekable(): bool
        {
            return $this->seekable;
        }

        public function seek($offset, $whence = \SEEK_SET) /*:void*/
        {
            if (!$this->seekable) {
                throw new \RuntimeException('Stream is not seekable');
            }

            if (-1 === \fseek($this->stream, $offset, $whence)) {
                throw new \RuntimeException('Unable to seek to stream position ' . $offset . ' with whence ' . \var_export($whence, true));
            }
        }

        public function rewind() /*:void*/
        {
            $this->seek(0);
        }

        public function isWritable(): bool
        {
            return $this->writable;
        }

        public function write($string): int
        {
            if (!$this->writable) {
                throw new \RuntimeException('Cannot write to a non-writable stream');
            }

            // We can't know the size after writing anything
            $this->size = null;

            if (false === $result = \fwrite($this->stream, $string)) {
                throw new \RuntimeException('Unable to write to stream');
            }

            return $result;
        }

        public function isReadable(): bool
        {
            return $this->readable;
        }

        public function read($length): string
        {
            if (!$this->readable) {
                throw new \RuntimeException('Cannot read from non-readable stream');
            }

            if (false === $result = \fread($this->stream, $length)) {
                throw new \RuntimeException('Unable to read from stream');
            }

            return $result;
        }

        public function getContents(): string
        {
            if (!isset($this->stream)) {
                throw new \RuntimeException('Unable to read stream contents');
            }

            if (false === $contents = \stream_get_contents($this->stream)) {
                throw new \RuntimeException('Unable to read stream contents');
            }

            return $contents;
        }

        public function getMetadata($key = null)
        {
            if (!isset($this->stream)) {
                return $key ? null : [];
            }

            $meta = \stream_get_meta_data($this->stream);

            if (null === $key) {
                return $meta;
            }

            return $meta[$key] ?? null;
        }
    }
}

// file: vendor/nyholm/psr7/src/UploadedFile.php
namespace Nyholm\Psr7 {

    use Psr\Http\Message\{StreamInterface, UploadedFileInterface};

    /**
     * @author Michael Dowling and contributors to guzzlehttp/psr7
     * @author Tobias Nyholm <tobias.nyholm@gmail.com>
     * @author Martijn van der Ven <martijn@vanderven.se>
     *
     * @final This class should never be extended. See https://github.com/Nyholm/psr7/blob/master/doc/final.md
     */
    class UploadedFile implements UploadedFileInterface
    {
        /** @var array */
        /*private*/ const ERRORS = [
            \UPLOAD_ERR_OK => 1,
            \UPLOAD_ERR_INI_SIZE => 1,
            \UPLOAD_ERR_FORM_SIZE => 1,
            \UPLOAD_ERR_PARTIAL => 1,
            \UPLOAD_ERR_NO_FILE => 1,
            \UPLOAD_ERR_NO_TMP_DIR => 1,
            \UPLOAD_ERR_CANT_WRITE => 1,
            \UPLOAD_ERR_EXTENSION => 1,
        ];

        /** @var string */
        private $clientFilename;

        /** @var string */
        private $clientMediaType;

        /** @var int */
        private $error;

        /** @var string|null */
        private $file;

        /** @var bool */
        private $moved = false;

        /** @var int */
        private $size;

        /** @var StreamInterface|null */
        private $stream;

        /**
         * @param StreamInterface|string|resource $streamOrFile
         * @param int $size
         * @param int $errorStatus
         * @param string|null $clientFilename
         * @param string|null $clientMediaType
         */
        public function __construct($streamOrFile, $size, $errorStatus, $clientFilename = null, $clientMediaType = null)
        {
            if (false === \is_int($errorStatus) || !isset(self::ERRORS[$errorStatus])) {
                throw new \InvalidArgumentException('Upload file error status must be an integer value and one of the "UPLOAD_ERR_*" constants.');
            }

            if (false === \is_int($size)) {
                throw new \InvalidArgumentException('Upload file size must be an integer');
            }

            if (null !== $clientFilename && !\is_string($clientFilename)) {
                throw new \InvalidArgumentException('Upload file client filename must be a string or null');
            }

            if (null !== $clientMediaType && !\is_string($clientMediaType)) {
                throw new \InvalidArgumentException('Upload file client media type must be a string or null');
            }

            $this->error = $errorStatus;
            $this->size = $size;
            $this->clientFilename = $clientFilename;
            $this->clientMediaType = $clientMediaType;

            if (\UPLOAD_ERR_OK === $this->error) {
                // Depending on the value set file or stream variable.
                if (\is_string($streamOrFile)) {
                    $this->file = $streamOrFile;
                } elseif (\is_resource($streamOrFile)) {
                    $this->stream = Stream::create($streamOrFile);
                } elseif ($streamOrFile instanceof StreamInterface) {
                    $this->stream = $streamOrFile;
                } else {
                    throw new \InvalidArgumentException('Invalid stream or file provided for UploadedFile');
                }
            }
        }

        /**
         * @throws \RuntimeException if is moved or not ok
         */
        private function validateActive() /*:void*/
        {
            if (\UPLOAD_ERR_OK !== $this->error) {
                throw new \RuntimeException('Cannot retrieve stream due to upload error');
            }

            if ($this->moved) {
                throw new \RuntimeException('Cannot retrieve stream after it has already been moved');
            }
        }

        public function getStream(): StreamInterface
        {
            $this->validateActive();

            if ($this->stream instanceof StreamInterface) {
                return $this->stream;
            }

            $resource = \fopen($this->file, 'r');

            return Stream::create($resource);
        }

        public function moveTo($targetPath) /*:void*/
        {
            $this->validateActive();

            if (!\is_string($targetPath) || '' === $targetPath) {
                throw new \InvalidArgumentException('Invalid path provided for move operation; must be a non-empty string');
            }

            if (null !== $this->file) {
                $this->moved = 'cli' === \PHP_SAPI ? \rename($this->file, $targetPath) : \move_uploaded_file($this->file, $targetPath);
            } else {
                $stream = $this->getStream();
                if ($stream->isSeekable()) {
                    $stream->rewind();
                }

                // Copy the contents of a stream into another stream until end-of-file.
                $dest = Stream::create(\fopen($targetPath, 'w'));
                while (!$stream->eof()) {
                    if (!$dest->write($stream->read(1048576))) {
                        break;
                    }
                }

                $this->moved = true;
            }

            if (false === $this->moved) {
                throw new \RuntimeException(\sprintf('Uploaded file could not be moved to %s', $targetPath));
            }
        }

        public function getSize(): int
        {
            return $this->size;
        }

        public function getError(): int
        {
            return $this->error;
        }

        public function getClientFilename() /*:?string*/
        {
            return $this->clientFilename;
        }

        public function getClientMediaType() /*:?string*/
        {
            return $this->clientMediaType;
        }
    }
}

// file: vendor/nyholm/psr7/src/Uri.php
namespace Nyholm\Psr7 {

    use Psr\Http\Message\UriInterface;

    /**
     * PSR-7 URI implementation.
     *
     * @author Michael Dowling
     * @author Tobias Schultze
     * @author Matthew Weier O'Phinney
     * @author Tobias Nyholm <tobias.nyholm@gmail.com>
     * @author Martijn van der Ven <martijn@vanderven.se>
     *
     * @final This class should never be extended. See https://github.com/Nyholm/psr7/blob/master/doc/final.md
     */
    class Uri implements UriInterface
    {
        use LowercaseTrait;

        /*private*/ const SCHEMES = ['http' => 80, 'https' => 443];

        /*private*/ const CHAR_UNRESERVED = 'a-zA-Z0-9_\-\.~';

        /*private*/ const CHAR_SUB_DELIMS = '!\$&\'\(\)\*\+,;=';

        /** @var string Uri scheme. */
        private $scheme = '';

        /** @var string Uri user info. */
        private $userInfo = '';

        /** @var string Uri host. */
        private $host = '';

        /** @var int|null Uri port. */
        private $port;

        /** @var string Uri path. */
        private $path = '';

        /** @var string Uri query string. */
        private $query = '';

        /** @var string Uri fragment. */
        private $fragment = '';

        public function __construct(string $uri = '')
        {
            if ('' !== $uri) {
                if (false === $parts = \parse_url($uri)) {
                    throw new \InvalidArgumentException("Unable to parse URI: $uri");
                }

                // Apply parse_url parts to a URI.
                $this->scheme = isset($parts['scheme']) ? \strtr($parts['scheme'], 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz') : '';
                $this->userInfo = $parts['user'] ?? '';
                $this->host = isset($parts['host']) ? \strtr($parts['host'], 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz') : '';
                $this->port = isset($parts['port']) ? $this->filterPort($parts['port']) : null;
                $this->path = isset($parts['path']) ? $this->filterPath($parts['path']) : '';
                $this->query = isset($parts['query']) ? $this->filterQueryAndFragment($parts['query']) : '';
                $this->fragment = isset($parts['fragment']) ? $this->filterQueryAndFragment($parts['fragment']) : '';
                if (isset($parts['pass'])) {
                    $this->userInfo .= ':' . $parts['pass'];
                }
            }
        }

        public function __toString(): string
        {
            return self::createUriString($this->scheme, $this->getAuthority(), $this->path, $this->query, $this->fragment);
        }

        public function getScheme(): string
        {
            return $this->scheme;
        }

        public function getAuthority(): string
        {
            if ('' === $this->host) {
                return '';
            }

            $authority = $this->host;
            if ('' !== $this->userInfo) {
                $authority = $this->userInfo . '@' . $authority;
            }

            if (null !== $this->port) {
                $authority .= ':' . $this->port;
            }

            return $authority;
        }

        public function getUserInfo(): string
        {
            return $this->userInfo;
        }

        public function getHost(): string
        {
            return $this->host;
        }

        public function getPort() /*:?int*/
        {
            return $this->port;
        }

        public function getPath(): string
        {
            return $this->path;
        }

        public function getQuery(): string
        {
            return $this->query;
        }

        public function getFragment(): string
        {
            return $this->fragment;
        }

        public function withScheme($scheme): self
        {
            if (!\is_string($scheme)) {
                throw new \InvalidArgumentException('Scheme must be a string');
            }

            if ($this->scheme === $scheme = \strtr($scheme, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz')) {
                return $this;
            }

            $new = clone $this;
            $new->scheme = $scheme;
            $new->port = $new->filterPort($new->port);

            return $new;
        }

        public function withUserInfo($user, $password = null): self
        {
            $info = $user;
            if (null !== $password && '' !== $password) {
                $info .= ':' . $password;
            }

            if ($this->userInfo === $info) {
                return $this;
            }

            $new = clone $this;
            $new->userInfo = $info;

            return $new;
        }

        public function withHost($host): self
        {
            if (!\is_string($host)) {
                throw new \InvalidArgumentException('Host must be a string');
            }

            if ($this->host === $host = \strtr($host, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz')) {
                return $this;
            }

            $new = clone $this;
            $new->host = $host;

            return $new;
        }

        public function withPort($port): self
        {
            if ($this->port === $port = $this->filterPort($port)) {
                return $this;
            }

            $new = clone $this;
            $new->port = $port;

            return $new;
        }

        public function withPath($path): self
        {
            if ($this->path === $path = $this->filterPath($path)) {
                return $this;
            }

            $new = clone $this;
            $new->path = $path;

            return $new;
        }

        public function withQuery($query): self
        {
            if ($this->query === $query = $this->filterQueryAndFragment($query)) {
                return $this;
            }

            $new = clone $this;
            $new->query = $query;

            return $new;
        }

        public function withFragment($fragment): self
        {
            if ($this->fragment === $fragment = $this->filterQueryAndFragment($fragment)) {
                return $this;
            }

            $new = clone $this;
            $new->fragment = $fragment;

            return $new;
        }

        /**
         * Create a URI string from its various parts.
         */
        private static function createUriString(string $scheme, string $authority, string $path, string $query, string $fragment): string
        {
            $uri = '';
            if ('' !== $scheme) {
                $uri .= $scheme . ':';
            }

            if ('' !== $authority) {
                $uri .= '//' . $authority;
            }

            if ('' !== $path) {
                if ('/' !== $path[0]) {
                    if ('' !== $authority) {
                        // If the path is rootless and an authority is present, the path MUST be prefixed by "/"
                        $path = '/' . $path;
                    }
                } elseif (isset($path[1]) && '/' === $path[1]) {
                    if ('' === $authority) {
                        // If the path is starting with more than one "/" and no authority is present, the
                        // starting slashes MUST be reduced to one.
                        $path = '/' . \ltrim($path, '/');
                    }
                }

                $uri .= $path;
            }

            if ('' !== $query) {
                $uri .= '?' . $query;
            }

            if ('' !== $fragment) {
                $uri .= '#' . $fragment;
            }

            return $uri;
        }

        /**
         * Is a given port non-standard for the current scheme?
         */
        private static function isNonStandardPort(string $scheme, int $port): bool
        {
            return !isset(self::SCHEMES[$scheme]) || $port !== self::SCHEMES[$scheme];
        }

        private function filterPort($port) /*:?int*/
        {
            if (null === $port) {
                return null;
            }

            $port = (int) $port;
            if (0 > $port || 0xffff < $port) {
                throw new \InvalidArgumentException(\sprintf('Invalid port: %d. Must be between 0 and 65535', $port));
            }

            return self::isNonStandardPort($this->scheme, $port) ? $port : null;
        }

        private function filterPath($path): string
        {
            if (!\is_string($path)) {
                throw new \InvalidArgumentException('Path must be a string');
            }

            return \preg_replace_callback('/(?:[^' . self::CHAR_UNRESERVED . self::CHAR_SUB_DELIMS . '%:@\/]++|%(?![A-Fa-f0-9]{2}))/', [__CLASS__, 'rawurlencodeMatchZero'], $path);
        }

        private function filterQueryAndFragment($str): string
        {
            if (!\is_string($str)) {
                throw new \InvalidArgumentException('Query and fragment must be a string');
            }

            return \preg_replace_callback('/(?:[^' . self::CHAR_UNRESERVED . self::CHAR_SUB_DELIMS . '%:@\/\?]++|%(?![A-Fa-f0-9]{2}))/', [__CLASS__, 'rawurlencodeMatchZero'], $str);
        }

        private static function rawurlencodeMatchZero(array $match): string
        {
            return \rawurlencode($match[0]);
        }
    }
}

// file: vendor/nyholm/psr7-server/src/ServerRequestCreator.php
namespace Nyholm\Psr7Server {

    use Psr\Http\Message\ServerRequestFactoryInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Psr\Http\Message\StreamFactoryInterface;
    use Psr\Http\Message\StreamInterface;
    use Psr\Http\Message\UploadedFileFactoryInterface;
    use Psr\Http\Message\UploadedFileInterface;
    use Psr\Http\Message\UriFactoryInterface;
    use Psr\Http\Message\UriInterface;

    /**
     * @author Tobias Nyholm <tobias.nyholm@gmail.com>
     * @author Martijn van der Ven <martijn@vanderven.se>
     */
    final class ServerRequestCreator implements ServerRequestCreatorInterface
    {
        private $serverRequestFactory;

        private $uriFactory;

        private $uploadedFileFactory;

        private $streamFactory;

        public function __construct(
            ServerRequestFactoryInterface $serverRequestFactory,
            UriFactoryInterface $uriFactory,
            UploadedFileFactoryInterface $uploadedFileFactory,
            StreamFactoryInterface $streamFactory
        ) {
            $this->serverRequestFactory = $serverRequestFactory;
            $this->uriFactory = $uriFactory;
            $this->uploadedFileFactory = $uploadedFileFactory;
            $this->streamFactory = $streamFactory;
        }

        /**
         * {@inheritdoc}
         */
        public function fromGlobals(): ServerRequestInterface
        {
            $server = $_SERVER;
            if (false === isset($server['REQUEST_METHOD'])) {
                $server['REQUEST_METHOD'] = 'GET';
            }

            $headers = \function_exists('getallheaders') ? getallheaders() : static::getHeadersFromServer($_SERVER);

            $post = null;
            if ('POST' === $this->getMethodFromEnv($server)) {
                foreach ($headers as $headerName => $headerValue) {
                    if ('content-type' !== \strtolower($headerName)) {
                        continue;
                    }
                    if (\in_array(
                        \strtolower(\trim(\explode(';', $headerValue, 2)[0])),
                        ['application/x-www-form-urlencoded', 'multipart/form-data']
                    )) {
                        $post = $_POST;

                        break;
                    }
                }
            }

            return $this->fromArrays($server, $headers, $_COOKIE, $_GET, $post, $_FILES, \fopen('php://input', 'r') ?: null);
        }

        /**
         * {@inheritdoc}
         */
        public function fromArrays(array $server, array $headers = [], array $cookie = [], array $get = [], /*?array*/ $post = null, array $files = [], $body = null): ServerRequestInterface
        {
            $method = $this->getMethodFromEnv($server);
            $uri = $this->getUriFromEnvWithHTTP($server);
            $protocol = isset($server['SERVER_PROTOCOL']) ? \str_replace('HTTP/', '', $server['SERVER_PROTOCOL']) : '1.1';

            $serverRequest = $this->serverRequestFactory->createServerRequest($method, $uri, $server);
            foreach ($headers as $name => $value) {
                // Because PHP automatically casts array keys set with numeric strings to integers, we have to make sure
                // that numeric headers will not be sent along as integers, as withAddedHeader can only accept strings.
                if (\is_int($name)) {
                    $name = (string) $name;
                }
                $serverRequest = $serverRequest->withAddedHeader($name, $value);
            }

            $serverRequest = $serverRequest
                ->withProtocolVersion($protocol)
                ->withCookieParams($cookie)
                ->withQueryParams($get)
                ->withParsedBody($post)
                ->withUploadedFiles($this->normalizeFiles($files));

            if (null === $body) {
                return $serverRequest;
            }

            if (\is_resource($body)) {
                $body = $this->streamFactory->createStreamFromResource($body);
            } elseif (\is_string($body)) {
                $body = $this->streamFactory->createStream($body);
            } elseif (!$body instanceof StreamInterface) {
                throw new \InvalidArgumentException('The $body parameter to ServerRequestCreator::fromArrays must be string, resource or StreamInterface');
            }

            return $serverRequest->withBody($body);
        }

        /**
         * Implementation from Zend\Diactoros\marshalHeadersFromSapi().
         */
        public static function getHeadersFromServer(array $server): array
        {
            $headers = [];
            foreach ($server as $key => $value) {
                // Apache prefixes environment variables with REDIRECT_
                // if they are added by rewrite rules
                if (0 === \strpos($key, 'REDIRECT_')) {
                    $key = \substr($key, 9);

                    // We will not overwrite existing variables with the
                    // prefixed versions, though
                    if (\array_key_exists($key, $server)) {
                        continue;
                    }
                }

                if ($value && 0 === \strpos($key, 'HTTP_')) {
                    $name = \strtr(\strtolower(\substr($key, 5)), '_', '-');
                    $headers[$name] = $value;

                    continue;
                }

                if ($value && 0 === \strpos($key, 'CONTENT_')) {
                    $name = 'content-'.\strtolower(\substr($key, 8));
                    $headers[$name] = $value;

                    continue;
                }
            }

            return $headers;
        }

        private function getMethodFromEnv(array $environment): string
        {
            if (false === isset($environment['REQUEST_METHOD'])) {
                throw new \InvalidArgumentException('Cannot determine HTTP method');
            }

            return $environment['REQUEST_METHOD'];
        }

        private function getUriFromEnvWithHTTP(array $environment): UriInterface
        {
            $uri = $this->createUriFromArray($environment);
            if (empty($uri->getScheme())) {
                $uri = $uri->withScheme('http');
            }

            return $uri;
        }

        /**
         * Return an UploadedFile instance array.
         *
         * @param array $files A array which respect $_FILES structure
         *
         * @return UploadedFileInterface[]
         *
         * @throws \InvalidArgumentException for unrecognized values
         */
        private function normalizeFiles(array $files): array
        {
            $normalized = [];

            foreach ($files as $key => $value) {
                if ($value instanceof UploadedFileInterface) {
                    $normalized[$key] = $value;
                } elseif (\is_array($value) && isset($value['tmp_name'])) {
                    $normalized[$key] = $this->createUploadedFileFromSpec($value);
                } elseif (\is_array($value)) {
                    $normalized[$key] = $this->normalizeFiles($value);
                } else {
                    throw new \InvalidArgumentException('Invalid value in files specification');
                }
            }

            return $normalized;
        }

        /**
         * Create and return an UploadedFile instance from a $_FILES specification.
         *
         * If the specification represents an array of values, this method will
         * delegate to normalizeNestedFileSpec() and return that return value.
         *
         * @param array $value $_FILES struct
         *
         * @return array|UploadedFileInterface
         */
        private function createUploadedFileFromSpec(array $value)
        {
            if (\is_array($value['tmp_name'])) {
                return $this->normalizeNestedFileSpec($value);
            }

            try {
                $stream = $this->streamFactory->createStreamFromFile($value['tmp_name']);
            } catch (\RuntimeException $e) {
                $stream = $this->streamFactory->createStream();
            }

            return $this->uploadedFileFactory->createUploadedFile(
                $stream,
                (int) $value['size'],
                (int) $value['error'],
                $value['name'],
                $value['type']
            );
        }

        /**
         * Normalize an array of file specifications.
         *
         * Loops through all nested files and returns a normalized array of
         * UploadedFileInterface instances.
         *
         * @return UploadedFileInterface[]
         */
        private function normalizeNestedFileSpec(array $files = []): array
        {
            $normalizedFiles = [];

            foreach (\array_keys($files['tmp_name']) as $key) {
                $spec = [
                    'tmp_name' => $files['tmp_name'][$key],
                    'size' => $files['size'][$key],
                    'error' => $files['error'][$key],
                    'name' => $files['name'][$key],
                    'type' => $files['type'][$key],
                ];
                $normalizedFiles[$key] = $this->createUploadedFileFromSpec($spec);
            }

            return $normalizedFiles;
        }

        /**
         * Create a new uri from server variable.
         *
         * @param array $server typically $_SERVER or similar structure
         */
        private function createUriFromArray(array $server): UriInterface
        {
            $uri = $this->uriFactory->createUri('');

            if (isset($server['HTTP_X_FORWARDED_PROTO'])) {
                $uri = $uri->withScheme($server['HTTP_X_FORWARDED_PROTO']);
            } else {
                if (isset($server['REQUEST_SCHEME'])) {
                    $uri = $uri->withScheme($server['REQUEST_SCHEME']);
                } elseif (isset($server['HTTPS'])) {
                    $uri = $uri->withScheme('on' === $server['HTTPS'] ? 'https' : 'http');
                }

                if (isset($server['SERVER_PORT'])) {
                    $uri = $uri->withPort($server['SERVER_PORT']);
                }
            }

            if (isset($server['HTTP_HOST'])) {
                if (1 === \preg_match('/^(.+)\:(\d+)$/', $server['HTTP_HOST'], $matches)) {
                    $uri = $uri->withHost($matches[1])->withPort($matches[2]);
                } else {
                    $uri = $uri->withHost($server['HTTP_HOST']);
                }
            } elseif (isset($server['SERVER_NAME'])) {
                $uri = $uri->withHost($server['SERVER_NAME']);
            }

            if (isset($server['REQUEST_URI'])) {
                $uri = $uri->withPath(\current(\explode('?', $server['REQUEST_URI'])));
            }

            if (isset($server['QUERY_STRING'])) {
                $uri = $uri->withQuery($server['QUERY_STRING']);
            }

            return $uri;
        }
    }
}

// file: vendor/nyholm/psr7-server/src/ServerRequestCreatorInterface.php
namespace Nyholm\Psr7Server {

    use Psr\Http\Message\ServerRequestInterface;
    use Psr\Http\Message\StreamInterface;

    /**
     * @author Tobias Nyholm <tobias.nyholm@gmail.com>
     * @author Martijn van der Ven <martijn@vanderven.se>
     */
    interface ServerRequestCreatorInterface
    {
        /**
         * Create a new server request from the current environment variables.
         * Defaults to a GET request to minimise the risk of an \InvalidArgumentException.
         * Includes the current request headers as supplied by the server through `getallheaders()`.
         * If `getallheaders()` is unavailable on the current server it will fallback to its own `getHeadersFromServer()` method.
         * Defaults to php://input for the request body.
         *
         * @throws \InvalidArgumentException if no valid method or URI can be determined
         */
        public function fromGlobals(): ServerRequestInterface;

        /**
         * Create a new server request from a set of arrays.
         *
         * @param array                                $server  typically $_SERVER or similar structure
         * @param array                                $headers typically the output of getallheaders() or similar structure
         * @param array                                $cookie  typically $_COOKIE or similar structure
         * @param array                                $get     typically $_GET or similar structure
         * @param array|null                           $post    typically $_POST or similar structure, represents parsed request body
         * @param array                                $files   typically $_FILES or similar structure
         * @param StreamInterface|resource|string|null $body    Typically stdIn
         *
         * @throws \InvalidArgumentException if no valid method or URI can be determined
         */
        public function fromArrays(
            array $server,
            array $headers = [],
            array $cookie = [],
            array $get = [], /*?array*/ $post = null,
            array $files = [],
            $body = null
        ): ServerRequestInterface;

        /**
         * Get parsed headers from ($_SERVER) array.
         *
         * @param array $server typically $_SERVER or similar structure
         */
        public static function getHeadersFromServer(array $server): array;
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Cache/Base/BaseCache.php
namespace Tqdev\PhpCrudApi\Cache\Base {

    use Tqdev\PhpCrudApi\Cache\Cache;

    class BaseCache implements Cache
    {
        public function __construct()
        {
        }

        public function set(string $key, string $value, int $ttl = 0): bool
        {
            return true;
        }

        public function get(string $key): string
        {
            return '';
        }

        public function clear(): bool
        {
            return true;
        }
        
        public function ping(): int
        {
            $start = microtime(true);
            $this->get('__ping__');
            return intval((microtime(true)-$start)*1000000);
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Cache/Cache.php
namespace Tqdev\PhpCrudApi\Cache {

    interface Cache
    {
        public function set(string $key, string $value, int $ttl = 0): bool;
        public function get(string $key): string;
        public function clear(): bool;
        public function ping(): int;
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Cache/CacheFactory.php
namespace Tqdev\PhpCrudApi\Cache {

    class CacheFactory
    {
        public static function create(string $type, string $prefix, string $config): Cache
        {
            switch ($type) {
                case 'TempFile':
                    $cache = new TempFileCache($prefix, $config);
                    break;
                case 'Redis':
                    $cache = new RedisCache($prefix, $config);
                    break;
                case 'Memcache':
                    $cache = new MemcacheCache($prefix, $config);
                    break;
                case 'Memcached':
                    $cache = new MemcachedCache($prefix, $config);
                    break;
                default:
                    $cache = new NoCache();
            }
            return $cache;
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Cache/MemcacheCache.php
namespace Tqdev\PhpCrudApi\Cache {

    use Tqdev\PhpCrudApi\Cache\Base\BaseCache;

    class MemcacheCache extends BaseCache implements Cache
    {
        protected $prefix;
        protected $memcache;

        public function __construct(string $prefix, string $config)
        {
            $this->prefix = $prefix;
            if ($config == '') {
                $address = 'localhost';
                $port = 11211;
            } elseif (strpos($config, ':') === false) {
                $address = $config;
                $port = 11211;
            } else {
                list($address, $port) = explode(':', $config);
            }
            $this->memcache = $this->create();
            $this->memcache->addServer($address, $port);
        }

        protected function create() /*: \Memcache*/
        {
            return new \Memcache();
        }

        public function set(string $key, string $value, int $ttl = 0): bool
        {
            return $this->memcache->set($this->prefix . $key, $value, 0, $ttl);
        }

        public function get(string $key): string
        {
            return $this->memcache->get($this->prefix . $key) ?: '';
        }

        public function clear(): bool
        {
            return $this->memcache->flush();
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Cache/MemcachedCache.php
namespace Tqdev\PhpCrudApi\Cache {

    class MemcachedCache extends MemcacheCache
    {
        protected function create() /*: \Memcached*/
        {
            return new \Memcached();
        }

        public function set(string $key, string $value, int $ttl = 0): bool
        {
            return $this->memcache->set($this->prefix . $key, $value, $ttl);
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Cache/NoCache.php
namespace Tqdev\PhpCrudApi\Cache {

    use Tqdev\PhpCrudApi\Cache\Base\BaseCache;

    class NoCache extends BaseCache implements Cache
    {
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Cache/RedisCache.php
namespace Tqdev\PhpCrudApi\Cache {

    use Tqdev\PhpCrudApi\Cache\Base\BaseCache;

    class RedisCache extends BaseCache implements Cache
    {
        protected $prefix;
        protected $redis;

        public function __construct(string $prefix, string $config)
        {
            $this->prefix = $prefix;
            if ($config == '') {
                $config = '127.0.0.1';
            }
            $params = explode(':', $config, 6);
            if (isset($params[3])) {
                $params[3] = null;
            }
            $this->redis = new \Redis();
            call_user_func_array(array($this->redis, 'pconnect'), $params);
        }

        public function set(string $key, string $value, int $ttl = 0): bool
        {
            return $this->redis->set($this->prefix . $key, $value, $ttl);
        }

        public function get(string $key): string
        {
            return $this->redis->get($this->prefix . $key) ?: '';
        }

        public function clear(): bool
        {
            return $this->redis->flushDb();
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Cache/TempFileCache.php
namespace Tqdev\PhpCrudApi\Cache {

    use Tqdev\PhpCrudApi\Cache\Base\BaseCache;

    class TempFileCache extends BaseCache implements Cache
    {
        const SUFFIX = 'cache';

        private $path;
        private $segments;

        public function __construct(string $prefix, string $config)
        {
            $this->segments = [];
            $s = DIRECTORY_SEPARATOR;
            $ps = PATH_SEPARATOR;
            if ($config == '') {
                $this->path = sys_get_temp_dir() . $s . $prefix . self::SUFFIX;
            } elseif (strpos($config, $ps) === false) {
                $this->path = $config;
            } else {
                list($path, $segments) = explode($ps, $config);
                $this->path = $path;
                $this->segments = explode(',', $segments);
            }
            if (file_exists($this->path) && is_dir($this->path)) {
                $this->clean($this->path, array_filter($this->segments), strlen(md5('')), false);
            }
        }

        private function getFileName(string $key): string
        {
            $s = DIRECTORY_SEPARATOR;
            $md5 = md5($key);
            $filename = rtrim($this->path, $s) . $s;
            $i = 0;
            foreach ($this->segments as $segment) {
                $filename .= substr($md5, $i, $segment) . $s;
                $i += $segment;
            }
            $filename .= substr($md5, $i);
            return $filename;
        }

        public function set(string $key, string $value, int $ttl = 0): bool
        {
            $filename = $this->getFileName($key);
            $dirname = dirname($filename);
            if (!file_exists($dirname)) {
                if (!mkdir($dirname, 0755, true)) {
                    return false;
                }
            }
            $string = $ttl . '|' . $value;
            return $this->filePutContents($filename, $string) !== false;
        }

        private function filePutContents($filename, $string)
        {
            return file_put_contents($filename, $string, LOCK_EX);
        }

        private function fileGetContents($filename)
        {
            $file = fopen($filename, 'rb');
            if ($file === false) {
                return false;
            }
            $lock = flock($file, LOCK_SH);
            if (!$lock) {
                fclose($file);
                return false;
            }
            $string = '';
            while (!feof($file)) {
                $string .= fread($file, 8192);
            }
            flock($file, LOCK_UN);
            fclose($file);
            return $string;
        }

        private function getString($filename): string
        {
            $data = $this->fileGetContents($filename);
            if ($data === false) {
                return '';
            }
            if (strpos($data, '|') === false) {
                return '';
            }
            list($ttl, $string) = explode('|', $data, 2);
            if ($ttl > 0 && time() - filemtime($filename) > $ttl) {
                return '';
            }
            return $string;
        }

        public function get(string $key): string
        {
            $filename = $this->getFileName($key);
            if (!file_exists($filename)) {
                return '';
            }
            $string = $this->getString($filename);
            if ($string == null) {
                return '';
            }
            return $string;
        }

        private function clean(string $path, array $segments, int $len, bool $all) /*: void*/
        {
            $entries = scandir($path);
            foreach ($entries as $entry) {
                if ($entry === '.' || $entry === '..') {
                    continue;
                }
                $filename = $path . DIRECTORY_SEPARATOR . $entry;
                if (count($segments) == 0) {
                    if (strlen($entry) != $len) {
                        continue;
                    }
                    if (file_exists($filename) && is_file($filename)) {
                        if ($all || $this->getString($filename) == null) {
                            @unlink($filename);
                        }
                    }
                } else {
                    if (strlen($entry) != $segments[0]) {
                        continue;
                    }
                    if (file_exists($filename) && is_dir($filename)) {
                        $this->clean($filename, array_slice($segments, 1), $len - $segments[0], $all);
                        @rmdir($filename);
                    }
                }
            }
        }

        public function clear(): bool
        {
            if (!file_exists($this->path) || !is_dir($this->path)) {
                return false;
            }
            $this->clean($this->path, array_filter($this->segments), strlen(md5('')), true);
            return true;
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Column/Reflection/ReflectedColumn.php
namespace Tqdev\PhpCrudApi\Column\Reflection {

    use Tqdev\PhpCrudApi\Database\GenericReflection;

    class ReflectedColumn implements \JsonSerializable
    {
        const DEFAULT_LENGTH = 255;
        const DEFAULT_PRECISION = 19;
        const DEFAULT_SCALE = 4;

        private $name;
        private $type;
        private $length;
        private $precision;
        private $scale;
        private $nullable;
        private $pk;
        private $fk;

        public function __construct(string $name, string $type, int $length, int $precision, int $scale, bool $nullable, bool $pk, string $fk)
        {
            $this->name = $name;
            $this->type = $type;
            $this->length = $length;
            $this->precision = $precision;
            $this->scale = $scale;
            $this->nullable = $nullable;
            $this->pk = $pk;
            $this->fk = $fk;
            $this->sanitize();
        }

        private static function parseColumnType(string $columnType, int &$length, int &$precision, int &$scale) /*: void*/
        {
            if (!$columnType) {
                return;
            }
            $pos = strpos($columnType, '(');
            if ($pos) {
                $dataSize = rtrim(substr($columnType, $pos + 1), ')');
                if ($length) {
                    $length = (int) $dataSize;
                } else {
                    $pos = strpos($dataSize, ',');
                    if ($pos) {
                        $precision = (int) substr($dataSize, 0, $pos);
                        $scale = (int) substr($dataSize, $pos + 1);
                    } else {
                        $precision = (int) $dataSize;
                        $scale = 0;
                    }
                }
            }
        }

        private static function getDataSize(int $length, int $precision, int $scale): string
        {
            $dataSize = '';
            if ($length) {
                $dataSize = $length;
            } elseif ($precision) {
                if ($scale) {
                    $dataSize = $precision . ',' . $scale;
                } else {
                    $dataSize = $precision;
                }
            }
            return $dataSize;
        }

        public static function fromReflection(GenericReflection $reflection, array $columnResult): ReflectedColumn
        {
            $name = $columnResult['COLUMN_NAME'];
            $dataType = $columnResult['DATA_TYPE'];
            $length = (int) $columnResult['CHARACTER_MAXIMUM_LENGTH'];
            $precision = (int) $columnResult['NUMERIC_PRECISION'];
            $scale = (int) $columnResult['NUMERIC_SCALE'];
            $columnType = $columnResult['COLUMN_TYPE'];
            self::parseColumnType($columnType, $length, $precision, $scale);
            $dataSize = self::getDataSize($length, $precision, $scale);
            $type = $reflection->toJdbcType($dataType, $dataSize);
            $nullable = in_array(strtoupper($columnResult['IS_NULLABLE']), ['TRUE', 'YES', 'T', 'Y', '1']);
            $pk = false;
            $fk = '';
            return new ReflectedColumn($name, $type, $length, $precision, $scale, $nullable, $pk, $fk);
        }

        public static function fromJson(/* object */$json): ReflectedColumn
        {
            $name = $json->name;
            $type = $json->type;
            $length = isset($json->length) ? (int) $json->length : 0;
            $precision = isset($json->precision) ? (int) $json->precision : 0;
            $scale = isset($json->scale) ? (int) $json->scale : 0;
            $nullable = isset($json->nullable) ? (bool) $json->nullable : false;
            $pk = isset($json->pk) ? (bool) $json->pk : false;
            $fk = isset($json->fk) ? $json->fk : '';
            return new ReflectedColumn($name, $type, $length, $precision, $scale, $nullable, $pk, $fk);
        }

        private function sanitize()
        {
            $this->length = $this->hasLength() ? $this->getLength() : 0;
            $this->precision = $this->hasPrecision() ? $this->getPrecision() : 0;
            $this->scale = $this->hasScale() ? $this->getScale() : 0;
        }

        public function getName(): string
        {
            return $this->name;
        }

        public function getNullable(): bool
        {
            return $this->nullable;
        }

        public function getType(): string
        {
            return $this->type;
        }

        public function getLength(): int
        {
            return $this->length ?: self::DEFAULT_LENGTH;
        }

        public function getPrecision(): int
        {
            return $this->precision ?: self::DEFAULT_PRECISION;
        }

        public function getScale(): int
        {
            return $this->scale ?: self::DEFAULT_SCALE;
        }

        public function hasLength(): bool
        {
            return in_array($this->type, ['varchar', 'varbinary']);
        }

        public function hasPrecision(): bool
        {
            return $this->type == 'decimal';
        }

        public function hasScale(): bool
        {
            return $this->type == 'decimal';
        }

        public function isBinary(): bool
        {
            return in_array($this->type, ['blob', 'varbinary']);
        }

        public function isBoolean(): bool
        {
            return $this->type == 'boolean';
        }

        public function isGeometry(): bool
        {
            return $this->type == 'geometry';
        }

        public function isInteger(): bool
        {
            return in_array($this->type, ['integer', 'bigint', 'smallint', 'tinyint']);
        }

        public function setPk($value) /*: void*/
        {
            $this->pk = $value;
        }

        public function getPk(): bool
        {
            return $this->pk;
        }

        public function setFk($value) /*: void*/
        {
            $this->fk = $value;
        }

        public function getFk(): string
        {
            return $this->fk;
        }

        public function serialize()
        {
            return [
                'name' => $this->name,
                'type' => $this->type,
                'length' => $this->length,
                'precision' => $this->precision,
                'scale' => $this->scale,
                'nullable' => $this->nullable,
                'pk' => $this->pk,
                'fk' => $this->fk,
            ];
        }

        public function jsonSerialize()
        {
            return array_filter($this->serialize());
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Column/Reflection/ReflectedDatabase.php
namespace Tqdev\PhpCrudApi\Column\Reflection {

    use Tqdev\PhpCrudApi\Database\GenericReflection;

    class ReflectedDatabase implements \JsonSerializable
    {
        private $tableTypes;

        public function __construct(array $tableTypes)
        {
            $this->tableTypes = $tableTypes;
        }

        public static function fromReflection(GenericReflection $reflection): ReflectedDatabase
        {
            $tableTypes = [];
            foreach ($reflection->getTables() as $table) {
                $tableName = $table['TABLE_NAME'];
                $tableType = $table['TABLE_TYPE'];
                if (in_array($tableName, $reflection->getIgnoredTables())) {
                    continue;
                }
                $tableTypes[$tableName] = $tableType;
            }
            return new ReflectedDatabase($tableTypes);
        }

        public static function fromJson(/* object */$json): ReflectedDatabase
        {
            $tableTypes = (array) $json->tables;
            return new ReflectedDatabase($tableTypes);
        }

        public function hasTable(string $tableName): bool
        {
            return isset($this->tableTypes[$tableName]);
        }

        public function getType(string $tableName): string
        {
            return isset($this->tableTypes[$tableName]) ? $this->tableTypes[$tableName] : '';
        }

        public function getTableNames(): array
        {
            return array_keys($this->tableTypes);
        }

        public function removeTable(string $tableName): bool
        {
            if (!isset($this->tableTypes[$tableName])) {
                return false;
            }
            unset($this->tableTypes[$tableName]);
            return true;
        }

        public function serialize()
        {
            return [
                'tables' => $this->tableTypes,
            ];
        }

        public function jsonSerialize()
        {
            return $this->serialize();
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Column/Reflection/ReflectedTable.php
namespace Tqdev\PhpCrudApi\Column\Reflection {

    use Tqdev\PhpCrudApi\Database\GenericReflection;

    class ReflectedTable implements \JsonSerializable
    {
        private $name;
        private $type;
        private $columns;
        private $pk;
        private $fks;

        public function __construct(string $name, string $type, array $columns)
        {
            $this->name = $name;
            $this->type = $type;
            // set columns
            $this->columns = [];
            foreach ($columns as $column) {
                $columnName = $column->getName();
                $this->columns[$columnName] = $column;
            }
            // set primary key
            $this->pk = null;
            foreach ($columns as $column) {
                if ($column->getPk() == true) {
                    $this->pk = $column;
                }
            }
            // set foreign keys
            $this->fks = [];
            foreach ($columns as $column) {
                $columnName = $column->getName();
                $referencedTableName = $column->getFk();
                if ($referencedTableName != '') {
                    $this->fks[$columnName] = $referencedTableName;
                }
            }
        }

        public static function fromReflection(GenericReflection $reflection, string $name, string $type): ReflectedTable
        {
            // set columns
            $columns = [];
            foreach ($reflection->getTableColumns($name, $type) as $tableColumn) {
                $column = ReflectedColumn::fromReflection($reflection, $tableColumn);
                $columns[$column->getName()] = $column;
            }
            // set primary key
            $columnName = false;
            if ($type == 'view') {
                $columnName = 'id';
            } else {
                $columnNames = $reflection->getTablePrimaryKeys($name);
                if (count($columnNames) == 1) {
                    $columnName = $columnNames[0];
                }
            }
            if ($columnName && isset($columns[$columnName])) {
                $pk = $columns[$columnName];
                $pk->setPk(true);
            }
            // set foreign keys
            if ($type == 'view') {
                $tables = $reflection->getTables();
                foreach ($columns as $columnName => $column) {
                    if (substr($columnName, -3) == '_id') {
                        foreach ($tables as $table) {
                            $tableName = $table['TABLE_NAME'];
                            $suffix = $tableName . '_id';
                            if (substr($columnName, -1 * strlen($suffix)) == $suffix) {
                                $column->setFk($tableName);
                            }
                        }
                    }
                }
            } else {
                $fks = $reflection->getTableForeignKeys($name);
                foreach ($fks as $columnName => $table) {
                    $columns[$columnName]->setFk($table);
                }
            }
            return new ReflectedTable($name, $type, array_values($columns));
        }

        public static function fromJson( /* object */$json): ReflectedTable
        {
            $name = $json->name;
            $type = isset($json->type) ? $json->type : 'table';
            $columns = [];
            if (isset($json->columns) && is_array($json->columns)) {
                foreach ($json->columns as $column) {
                    $columns[] = ReflectedColumn::fromJson($column);
                }
            }
            return new ReflectedTable($name, $type, $columns);
        }

        public function hasColumn(string $columnName): bool
        {
            return isset($this->columns[$columnName]);
        }

        public function hasPk(): bool
        {
            return $this->pk != null;
        }

        public function getPk() /*: ?ReflectedColumn */
        {
            return $this->pk;
        }

        public function getName(): string
        {
            return $this->name;
        }

        public function getType(): string
        {
            return $this->type;
        }

        public function getColumnNames(): array
        {
            return array_keys($this->columns);
        }

        public function getColumn($columnName): ReflectedColumn
        {
            return $this->columns[$columnName];
        }

        public function getFksTo(string $tableName): array
        {
            $columns = array();
            foreach ($this->fks as $columnName => $referencedTableName) {
                if ($tableName == $referencedTableName && !is_null($this->columns[$columnName])) {
                    $columns[] = $this->columns[$columnName];
                }
            }
            return $columns;
        }

        public function removeColumn(string $columnName): bool
        {
            if (!isset($this->columns[$columnName])) {
                return false;
            }
            unset($this->columns[$columnName]);
            return true;
        }

        public function serialize()
        {
            return [
                'name' => $this->name,
                'type' => $this->type,
                'columns' => array_values($this->columns),
            ];
        }

        public function jsonSerialize()
        {
            return $this->serialize();
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Column/DefinitionService.php
namespace Tqdev\PhpCrudApi\Column {

    use Tqdev\PhpCrudApi\Column\Reflection\ReflectedColumn;
    use Tqdev\PhpCrudApi\Column\Reflection\ReflectedTable;
    use Tqdev\PhpCrudApi\Database\GenericDB;

    class DefinitionService
    {
        private $db;
        private $reflection;

        public function __construct(GenericDB $db, ReflectionService $reflection)
        {
            $this->db = $db;
            $this->reflection = $reflection;
        }

        public function updateTable(string $tableName, /* object */ $changes): bool
        {
            $table = $this->reflection->getTable($tableName);
            $newTable = ReflectedTable::fromJson((object) array_merge((array) $table->jsonSerialize(), (array) $changes));
            if ($table->getName() != $newTable->getName()) {
                if (!$this->db->definition()->renameTable($table->getName(), $newTable->getName())) {
                    return false;
                }
            }
            return true;
        }

        public function updateColumn(string $tableName, string $columnName, /* object */ $changes): bool
        {
            $table = $this->reflection->getTable($tableName);
            $column = $table->getColumn($columnName);

            // remove constraints on other column
            $newColumn = ReflectedColumn::fromJson((object) array_merge((array) $column->jsonSerialize(), (array) $changes));
            if ($newColumn->getPk() != $column->getPk() && $table->hasPk()) {
                $oldColumn = $table->getPk();
                if ($oldColumn->getName() != $columnName) {
                    $oldColumn->setPk(false);
                    if (!$this->db->definition()->removeColumnPrimaryKey($table->getName(), $oldColumn->getName(), $oldColumn)) {
                        return false;
                    }
                }
            }

            // remove constraints
            $newColumn = ReflectedColumn::fromJson((object) array_merge((array) $column->jsonSerialize(), ['pk' => false, 'fk' => false]));
            if ($newColumn->getPk() != $column->getPk() && !$newColumn->getPk()) {
                if (!$this->db->definition()->removeColumnPrimaryKey($table->getName(), $column->getName(), $newColumn)) {
                    return false;
                }
            }
            if ($newColumn->getFk() != $column->getFk() && !$newColumn->getFk()) {
                if (!$this->db->definition()->removeColumnForeignKey($table->getName(), $column->getName(), $newColumn)) {
                    return false;
                }
            }

            // name and type
            $newColumn = ReflectedColumn::fromJson((object) array_merge((array) $column->jsonSerialize(), (array) $changes));
            $newColumn->setPk(false);
            $newColumn->setFk('');
            if ($newColumn->getName() != $column->getName()) {
                if (!$this->db->definition()->renameColumn($table->getName(), $column->getName(), $newColumn)) {
                    return false;
                }
            }
            if (
                $newColumn->getType() != $column->getType() ||
                $newColumn->getLength() != $column->getLength() ||
                $newColumn->getPrecision() != $column->getPrecision() ||
                $newColumn->getScale() != $column->getScale()
            ) {
                if (!$this->db->definition()->retypeColumn($table->getName(), $newColumn->getName(), $newColumn)) {
                    return false;
                }
            }
            if ($newColumn->getNullable() != $column->getNullable()) {
                if (!$this->db->definition()->setColumnNullable($table->getName(), $newColumn->getName(), $newColumn)) {
                    return false;
                }
            }

            // add constraints
            $newColumn = ReflectedColumn::fromJson((object) array_merge((array) $column->jsonSerialize(), (array) $changes));
            if ($newColumn->getFk()) {
                if (!$this->db->definition()->addColumnForeignKey($table->getName(), $newColumn->getName(), $newColumn)) {
                    return false;
                }
            }
            if ($newColumn->getPk()) {
                if (!$this->db->definition()->addColumnPrimaryKey($table->getName(), $newColumn->getName(), $newColumn)) {
                    return false;
                }
            }
            return true;
        }

        public function addTable(/* object */$definition)
        {
            $newTable = ReflectedTable::fromJson($definition);
            if (!$this->db->definition()->addTable($newTable)) {
                return false;
            }
            return true;
        }

        public function addColumn(string $tableName, /* object */ $definition)
        {
            $newColumn = ReflectedColumn::fromJson($definition);
            if (!$this->db->definition()->addColumn($tableName, $newColumn)) {
                return false;
            }
            if ($newColumn->getFk()) {
                if (!$this->db->definition()->addColumnForeignKey($tableName, $newColumn->getName(), $newColumn)) {
                    return false;
                }
            }
            if ($newColumn->getPk()) {
                if (!$this->db->definition()->addColumnPrimaryKey($tableName, $newColumn->getName(), $newColumn)) {
                    return false;
                }
            }
            return true;
        }

        public function removeTable(string $tableName)
        {
            if (!$this->db->definition()->removeTable($tableName)) {
                return false;
            }
            return true;
        }

        public function removeColumn(string $tableName, string $columnName)
        {
            $table = $this->reflection->getTable($tableName);
            $newColumn = $table->getColumn($columnName);
            if ($newColumn->getPk()) {
                $newColumn->setPk(false);
                if (!$this->db->definition()->removeColumnPrimaryKey($table->getName(), $newColumn->getName(), $newColumn)) {
                    return false;
                }
            }
            if ($newColumn->getFk()) {
                $newColumn->setFk("");
                if (!$this->db->definition()->removeColumnForeignKey($tableName, $columnName, $newColumn)) {
                    return false;
                }
            }
            if (!$this->db->definition()->removeColumn($tableName, $columnName)) {
                return false;
            }
            return true;
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Column/ReflectionService.php
namespace Tqdev\PhpCrudApi\Column {

    use Tqdev\PhpCrudApi\Cache\Cache;
    use Tqdev\PhpCrudApi\Column\Reflection\ReflectedDatabase;
    use Tqdev\PhpCrudApi\Column\Reflection\ReflectedTable;
    use Tqdev\PhpCrudApi\Database\GenericDB;

    class ReflectionService
    {
        private $db;
        private $cache;
        private $ttl;
        private $database;
        private $tables;

        public function __construct(GenericDB $db, Cache $cache, int $ttl)
        {
            $this->db = $db;
            $this->cache = $cache;
            $this->ttl = $ttl;
            $this->database = null;
            $this->tables = [];
        }

        private function database(): ReflectedDatabase
        {
            if ($this->database) {
                return $this->database;
            }
            $this->database = $this->loadDatabase(true);
            return $this->database;
        }

        private function loadDatabase(bool $useCache): ReflectedDatabase
        {
            $key = sprintf('%s-ReflectedDatabase', $this->db->getCacheKey());
            $data = $useCache ? $this->cache->get($key) : '';
            if ($data != '') {
                $database = ReflectedDatabase::fromJson(json_decode(gzuncompress($data)));
            } else {
                $database = ReflectedDatabase::fromReflection($this->db->reflection());
                $data = gzcompress(json_encode($database, JSON_UNESCAPED_UNICODE));
                $this->cache->set($key, $data, $this->ttl);
            }
            return $database;
        }

        private function loadTable(string $tableName, bool $useCache): ReflectedTable
        {
            $key = sprintf('%s-ReflectedTable(%s)', $this->db->getCacheKey(), $tableName);
            $data = $useCache ? $this->cache->get($key) : '';
            if ($data != '') {
                $table = ReflectedTable::fromJson(json_decode(gzuncompress($data)));
            } else {
                $tableType = $this->database()->getType($tableName);
                $table = ReflectedTable::fromReflection($this->db->reflection(), $tableName, $tableType);
                $data = gzcompress(json_encode($table, JSON_UNESCAPED_UNICODE));
                $this->cache->set($key, $data, $this->ttl);
            }
            return $table;
        }

        public function refreshTables()
        {
            $this->database = $this->loadDatabase(false);
        }

        public function refreshTable(string $tableName)
        {
            $this->tables[$tableName] = $this->loadTable($tableName, false);
        }

        public function hasTable(string $tableName): bool
        {
            return $this->database()->hasTable($tableName);
        }

        public function getType(string $tableName): string
        {
            return $this->database()->getType($tableName);
        }

        public function getTable(string $tableName): ReflectedTable
        {
            if (!isset($this->tables[$tableName])) {
                $this->tables[$tableName] = $this->loadTable($tableName, true);
            }
            return $this->tables[$tableName];
        }

        public function getTableNames(): array
        {
            return $this->database()->getTableNames();
        }

        public function removeTable(string $tableName): bool
        {
            unset($this->tables[$tableName]);
            return $this->database()->removeTable($tableName);
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Controller/CacheController.php
namespace Tqdev\PhpCrudApi\Controller {

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Tqdev\PhpCrudApi\Cache\Cache;
    use Tqdev\PhpCrudApi\Middleware\Router\Router;

    class CacheController
    {
        private $cache;
        private $responder;

        public function __construct(Router $router, Responder $responder, Cache $cache)
        {
            $router->register('GET', '/cache/clear', array($this, 'clear'));
            $this->cache = $cache;
            $this->responder = $responder;
        }

        public function clear(ServerRequestInterface $request): ResponseInterface
        {
            return $this->responder->success($this->cache->clear());
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Controller/ColumnController.php
namespace Tqdev\PhpCrudApi\Controller {

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Tqdev\PhpCrudApi\Column\DefinitionService;
    use Tqdev\PhpCrudApi\Column\ReflectionService;
    use Tqdev\PhpCrudApi\Middleware\Router\Router;
    use Tqdev\PhpCrudApi\Record\ErrorCode;
    use Tqdev\PhpCrudApi\RequestUtils;

    class ColumnController
    {
        private $responder;
        private $reflection;
        private $definition;

        public function __construct(Router $router, Responder $responder, ReflectionService $reflection, DefinitionService $definition)
        {
            $router->register('GET', '/columns', array($this, 'getDatabase'));
            $router->register('GET', '/columns/*', array($this, 'getTable'));
            $router->register('GET', '/columns/*/*', array($this, 'getColumn'));
            $router->register('PUT', '/columns/*', array($this, 'updateTable'));
            $router->register('PUT', '/columns/*/*', array($this, 'updateColumn'));
            $router->register('POST', '/columns', array($this, 'addTable'));
            $router->register('POST', '/columns/*', array($this, 'addColumn'));
            $router->register('DELETE', '/columns/*', array($this, 'removeTable'));
            $router->register('DELETE', '/columns/*/*', array($this, 'removeColumn'));
            $this->responder = $responder;
            $this->reflection = $reflection;
            $this->definition = $definition;
        }

        public function getDatabase(ServerRequestInterface $request): ResponseInterface
        {
            $tables = [];
            foreach ($this->reflection->getTableNames() as $table) {
                $tables[] = $this->reflection->getTable($table);
            }
            $database = ['tables' => $tables];
            return $this->responder->success($database);
        }

        public function getTable(ServerRequestInterface $request): ResponseInterface
        {
            $tableName = RequestUtils::getPathSegment($request, 2);
            if (!$this->reflection->hasTable($tableName)) {
                return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $tableName);
            }
            $table = $this->reflection->getTable($tableName);
            return $this->responder->success($table);
        }

        public function getColumn(ServerRequestInterface $request): ResponseInterface
        {
            $tableName = RequestUtils::getPathSegment($request, 2);
            $columnName = RequestUtils::getPathSegment($request, 3);
            if (!$this->reflection->hasTable($tableName)) {
                return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $tableName);
            }
            $table = $this->reflection->getTable($tableName);
            if (!$table->hasColumn($columnName)) {
                return $this->responder->error(ErrorCode::COLUMN_NOT_FOUND, $columnName);
            }
            $column = $table->getColumn($columnName);
            return $this->responder->success($column);
        }

        public function updateTable(ServerRequestInterface $request): ResponseInterface
        {
            $tableName = RequestUtils::getPathSegment($request, 2);
            if (!$this->reflection->hasTable($tableName)) {
                return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $tableName);
            }
            $success = $this->definition->updateTable($tableName, $request->getParsedBody());
            if ($success) {
                $this->reflection->refreshTables();
            }
            return $this->responder->success($success);
        }

        public function updateColumn(ServerRequestInterface $request): ResponseInterface
        {
            $tableName = RequestUtils::getPathSegment($request, 2);
            $columnName = RequestUtils::getPathSegment($request, 3);
            if (!$this->reflection->hasTable($tableName)) {
                return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $tableName);
            }
            $table = $this->reflection->getTable($tableName);
            if (!$table->hasColumn($columnName)) {
                return $this->responder->error(ErrorCode::COLUMN_NOT_FOUND, $columnName);
            }
            $success = $this->definition->updateColumn($tableName, $columnName, $request->getParsedBody());
            if ($success) {
                $this->reflection->refreshTable($tableName);
            }
            return $this->responder->success($success);
        }

        public function addTable(ServerRequestInterface $request): ResponseInterface
        {
            $tableName = $request->getParsedBody()->name;
            if ($this->reflection->hasTable($tableName)) {
                return $this->responder->error(ErrorCode::TABLE_ALREADY_EXISTS, $tableName);
            }
            $success = $this->definition->addTable($request->getParsedBody());
            if ($success) {
                $this->reflection->refreshTables();
            }
            return $this->responder->success($success);
        }

        public function addColumn(ServerRequestInterface $request): ResponseInterface
        {
            $tableName = RequestUtils::getPathSegment($request, 2);
            if (!$this->reflection->hasTable($tableName)) {
                return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $tableName);
            }
            $columnName = $request->getParsedBody()->name;
            $table = $this->reflection->getTable($tableName);
            if ($table->hasColumn($columnName)) {
                return $this->responder->error(ErrorCode::COLUMN_ALREADY_EXISTS, $columnName);
            }
            $success = $this->definition->addColumn($tableName, $request->getParsedBody());
            if ($success) {
                $this->reflection->refreshTable($tableName);
            }
            return $this->responder->success($success);
        }

        public function removeTable(ServerRequestInterface $request): ResponseInterface
        {
            $tableName = RequestUtils::getPathSegment($request, 2);
            if (!$this->reflection->hasTable($tableName)) {
                return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $tableName);
            }
            $success = $this->definition->removeTable($tableName);
            if ($success) {
                $this->reflection->refreshTables();
            }
            return $this->responder->success($success);
        }

        public function removeColumn(ServerRequestInterface $request): ResponseInterface
        {
            $tableName = RequestUtils::getPathSegment($request, 2);
            $columnName = RequestUtils::getPathSegment($request, 3);
            if (!$this->reflection->hasTable($tableName)) {
                return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $tableName);
            }
            $table = $this->reflection->getTable($tableName);
            if (!$table->hasColumn($columnName)) {
                return $this->responder->error(ErrorCode::COLUMN_NOT_FOUND, $columnName);
            }
            $success = $this->definition->removeColumn($tableName, $columnName);
            if ($success) {
                $this->reflection->refreshTable($tableName);
            }
            return $this->responder->success($success);
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Controller/GeoJsonController.php
namespace Tqdev\PhpCrudApi\Controller {

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Tqdev\PhpCrudApi\GeoJson\GeoJsonService;
    use Tqdev\PhpCrudApi\Middleware\Router\Router;
    use Tqdev\PhpCrudApi\Record\ErrorCode;
    use Tqdev\PhpCrudApi\RequestUtils;

    class GeoJsonController
    {
        private $service;
        private $responder;

        public function __construct(Router $router, Responder $responder, GeoJsonService $service)
        {
            $router->register('GET', '/geojson/*', array($this, '_list'));
            $router->register('GET', '/geojson/*/*', array($this, 'read'));
            $this->service = $service;
            $this->responder = $responder;
        }

        public function _list(ServerRequestInterface $request): ResponseInterface
        {
            $table = RequestUtils::getPathSegment($request, 2);
            $params = RequestUtils::getParams($request);
            if (!$this->service->hasTable($table)) {
                return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $table);
            }
            return $this->responder->success($this->service->_list($table, $params));
        }

        public function read(ServerRequestInterface $request): ResponseInterface
        {
            $table = RequestUtils::getPathSegment($request, 2);
            if (!$this->service->hasTable($table)) {
                return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $table);
            }
            if ($this->service->getType($table) != 'table') {
                return $this->responder->error(ErrorCode::OPERATION_NOT_SUPPORTED, __FUNCTION__);
            }
            $id = RequestUtils::getPathSegment($request, 3);
            $params = RequestUtils::getParams($request);
            if (strpos($id, ',') !== false) {
                $ids = explode(',', $id);
                $result = (object) array('type' => 'FeatureCollection', 'features' => array());
                for ($i = 0; $i < count($ids); $i++) {
                    array_push($result->features, $this->service->read($table, $ids[$i], $params));
                }
                return $this->responder->success($result);
            } else {
                $response = $this->service->read($table, $id, $params);
                if ($response === null) {
                    return $this->responder->error(ErrorCode::RECORD_NOT_FOUND, $id);
                }
                return $this->responder->success($response);
            }
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Controller/JsonResponder.php
namespace Tqdev\PhpCrudApi\Controller {

    use Psr\Http\Message\ResponseInterface;
    use Tqdev\PhpCrudApi\Record\Document\ErrorDocument;
    use Tqdev\PhpCrudApi\Record\ErrorCode;
    use Tqdev\PhpCrudApi\ResponseFactory;
    use Tqdev\PhpCrudApi\ResponseUtils;

    class JsonResponder implements Responder
    {
        private $debug;

        public function __construct(bool $debug)
        {
            $this->debug = $debug;
        }

        public function error(int $error, string $argument, $details = null): ResponseInterface
        {
            $document = new ErrorDocument(new ErrorCode($error), $argument, $details);
            return ResponseFactory::fromObject($document->getStatus(), $document);
        }

        public function success($result): ResponseInterface
        {
            return ResponseFactory::fromObject(ResponseFactory::OK, $result);
        }

        public function exception($exception): ResponseInterface
        {
            $document = ErrorDocument::fromException($exception, $this->debug);
            $response = ResponseFactory::fromObject($document->getStatus(), $document);
            if ($this->debug) {
                $response = ResponseUtils::addExceptionHeaders($response, $exception);
            }
            return $response;
        }

        public function multi($results): ResponseInterface
        {
            $documents = array();
            $errors = array();
            $success = true;
            foreach ($results as $i => $result) {
                if ($result instanceof \Throwable) {
                    $documents[$i] = null;
                    $errors[$i] = ErrorDocument::fromException($result, $this->debug);
                    $success = false;
                } else {
                    $documents[$i] = $result;
                    $errors[$i] = new ErrorDocument(new ErrorCode(0), '', null);
                }
            }
            $status = $success ? ResponseFactory::OK : ResponseFactory::FAILED_DEPENDENCY;
            $document = $success ? $documents : $errors;
            $response = ResponseFactory::fromObject($status, $document);
            foreach ($results as $i => $result) {
                if ($result instanceof \Throwable) {
                    if ($this->debug) {
                        $response = ResponseUtils::addExceptionHeaders($response, $result);
                    }
                }
            }
            return $response;
        }

    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Controller/OpenApiController.php
namespace Tqdev\PhpCrudApi\Controller {

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Tqdev\PhpCrudApi\Middleware\Router\Router;
    use Tqdev\PhpCrudApi\OpenApi\OpenApiService;

    class OpenApiController
    {
        private $openApi;
        private $responder;

        public function __construct(Router $router, Responder $responder, OpenApiService $openApi)
        {
            $router->register('GET', '/openapi', array($this, 'openapi'));
            $this->openApi = $openApi;
            $this->responder = $responder;
        }

        public function openapi(ServerRequestInterface $request): ResponseInterface
        {
            return $this->responder->success($this->openApi->get());
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Controller/RecordController.php
namespace Tqdev\PhpCrudApi\Controller {

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Tqdev\PhpCrudApi\Middleware\Router\Router;
    use Tqdev\PhpCrudApi\Record\ErrorCode;
    use Tqdev\PhpCrudApi\Record\RecordService;
    use Tqdev\PhpCrudApi\RequestUtils;

    class RecordController
    {
        private $service;
        private $responder;

        public function __construct(Router $router, Responder $responder, RecordService $service)
        {
            $router->register('GET', '/records/*', array($this, '_list'));
            $router->register('POST', '/records/*', array($this, 'create'));
            $router->register('GET', '/records/*/*', array($this, 'read'));
            $router->register('PUT', '/records/*/*', array($this, 'update'));
            $router->register('DELETE', '/records/*/*', array($this, 'delete'));
            $router->register('PATCH', '/records/*/*', array($this, 'increment'));
            $this->service = $service;
            $this->responder = $responder;
        }

        public function _list(ServerRequestInterface $request): ResponseInterface
        {
            $table = RequestUtils::getPathSegment($request, 2);
            $params = RequestUtils::getParams($request);
            if (!$this->service->hasTable($table)) {
                return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $table);
            }
            return $this->responder->success($this->service->_list($table, $params));
        }

        public function read(ServerRequestInterface $request): ResponseInterface
        {
            $table = RequestUtils::getPathSegment($request, 2);
            if (!$this->service->hasTable($table)) {
                return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $table);
            }
            $id = RequestUtils::getPathSegment($request, 3);
            $params = RequestUtils::getParams($request);
            if (strpos($id, ',') !== false) {
                $ids = explode(',', $id);
                $argumentLists = array();
                for ($i = 0; $i < count($ids); $i++) {
                    $argumentLists[] = array($table, $ids[$i], $params);
                }
                return $this->responder->multi($this->multiCall([$this->service, 'read'], $argumentLists));
            } else {
                $response = $this->service->read($table, $id, $params);
                if ($response === null) {
                    return $this->responder->error(ErrorCode::RECORD_NOT_FOUND, $id);
                }
                return $this->responder->success($response);
            }
        }

        private function multiCall(callable $method, array $argumentLists): array
        {
            $result = array();
            $success = true;
            $this->service->beginTransaction();
            foreach ($argumentLists as $arguments) {
                try {
                    $result[] = call_user_func_array($method, $arguments);
                } catch (\Throwable $e) {
                    $success = false;
                    $result[] = $e;
                }
            }
            if ($success) {
                $this->service->commitTransaction();
            } else {
                $this->service->rollBackTransaction();
            }
            return $result;
        }

        public function create(ServerRequestInterface $request): ResponseInterface
        {
            $table = RequestUtils::getPathSegment($request, 2);
            if (!$this->service->hasTable($table)) {
                return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $table);
            }
            if ($this->service->getType($table) != 'table') {
                return $this->responder->error(ErrorCode::OPERATION_NOT_SUPPORTED, __FUNCTION__);
            }
            $record = $request->getParsedBody();
            if ($record === null) {
                return $this->responder->error(ErrorCode::HTTP_MESSAGE_NOT_READABLE, '');
            }
            $params = RequestUtils::getParams($request);
            if (is_array($record)) {
                $argumentLists = array();
                foreach ($record as $r) {
                    $argumentLists[] = array($table, $r, $params);
                }
                return $this->responder->multi($this->multiCall([$this->service, 'create'], $argumentLists));
            } else {
                return $this->responder->success($this->service->create($table, $record, $params));
            }
        }

        public function update(ServerRequestInterface $request): ResponseInterface
        {
            $table = RequestUtils::getPathSegment($request, 2);
            if (!$this->service->hasTable($table)) {
                return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $table);
            }
            if ($this->service->getType($table) != 'table') {
                return $this->responder->error(ErrorCode::OPERATION_NOT_SUPPORTED, __FUNCTION__);
            }
            $id = RequestUtils::getPathSegment($request, 3);
            $params = RequestUtils::getParams($request);
            $record = $request->getParsedBody();
            if ($record === null) {
                return $this->responder->error(ErrorCode::HTTP_MESSAGE_NOT_READABLE, '');
            }
            $ids = explode(',', $id);
            if (is_array($record)) {
                if (count($ids) != count($record)) {
                    return $this->responder->error(ErrorCode::ARGUMENT_COUNT_MISMATCH, $id);
                }
                $argumentLists = array();
                for ($i = 0; $i < count($ids); $i++) {
                    $argumentLists[] = array($table, $ids[$i], $record[$i], $params);
                }
                return $this->responder->multi($this->multiCall([$this->service, 'update'], $argumentLists));
            } else {
                if (count($ids) != 1) {
                    return $this->responder->error(ErrorCode::ARGUMENT_COUNT_MISMATCH, $id);
                }
                return $this->responder->success($this->service->update($table, $id, $record, $params));
            }
        }

        public function delete(ServerRequestInterface $request): ResponseInterface
        {
            $table = RequestUtils::getPathSegment($request, 2);
            if (!$this->service->hasTable($table)) {
                return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $table);
            }
            if ($this->service->getType($table) != 'table') {
                return $this->responder->error(ErrorCode::OPERATION_NOT_SUPPORTED, __FUNCTION__);
            }
            $id = RequestUtils::getPathSegment($request, 3);
            $params = RequestUtils::getParams($request);
            $ids = explode(',', $id);
            if (count($ids) > 1) {
                $argumentLists = array();
                for ($i = 0; $i < count($ids); $i++) {
                    $argumentLists[] = array($table, $ids[$i], $params);
                }
                return $this->responder->multi($this->multiCall([$this->service, 'delete'], $argumentLists));
            } else {
                return $this->responder->success($this->service->delete($table, $id, $params));
            }
        }

        public function increment(ServerRequestInterface $request): ResponseInterface
        {
            $table = RequestUtils::getPathSegment($request, 2);
            if (!$this->service->hasTable($table)) {
                return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $table);
            }
            if ($this->service->getType($table) != 'table') {
                return $this->responder->error(ErrorCode::OPERATION_NOT_SUPPORTED, __FUNCTION__);
            }
            $id = RequestUtils::getPathSegment($request, 3);
            $record = $request->getParsedBody();
            if ($record === null) {
                return $this->responder->error(ErrorCode::HTTP_MESSAGE_NOT_READABLE, '');
            }
            $params = RequestUtils::getParams($request);
            $ids = explode(',', $id);
            if (is_array($record)) {
                if (count($ids) != count($record)) {
                    return $this->responder->error(ErrorCode::ARGUMENT_COUNT_MISMATCH, $id);
                }
                $argumentLists = array();
                for ($i = 0; $i < count($ids); $i++) {
                    $argumentLists[] = array($table, $ids[$i], $record[$i], $params);
                }
                return $this->responder->multi($this->multiCall([$this->service, 'increment'], $argumentLists));
            } else {
                if (count($ids) != 1) {
                    return $this->responder->error(ErrorCode::ARGUMENT_COUNT_MISMATCH, $id);
                }
                return $this->responder->success($this->service->increment($table, $id, $record, $params));
            }
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Controller/Responder.php
namespace Tqdev\PhpCrudApi\Controller {

    use Psr\Http\Message\ResponseInterface;

    interface Responder
    {
        public function error(int $error, string $argument, $details = null): ResponseInterface;

        public function success($result): ResponseInterface;

        public function multi($results): ResponseInterface;

        public function exception($exception): ResponseInterface;

    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Controller/StatusController.php
namespace Tqdev\PhpCrudApi\Controller {

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Tqdev\PhpCrudApi\Cache\Cache;
    use Tqdev\PhpCrudApi\Database\GenericDB;
    use Tqdev\PhpCrudApi\Middleware\Router\Router;

    class StatusController
    {
        private $db;
        private $cache;
        private $responder;

        public function __construct(Router $router, Responder $responder, Cache $cache, GenericDB $db)
        {
            $router->register('GET', '/status/ping', array($this, 'ping'));
            $this->db = $db;
            $this->cache = $cache;
            $this->responder = $responder;
        }

        public function ping(ServerRequestInterface $request): ResponseInterface
        {
            $result = [
                'db' => $this->db->ping(),
                'cache' => $this->cache->ping(),
            ];
            return $this->responder->success($result);
        }

    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Database/ColumnConverter.php
namespace Tqdev\PhpCrudApi\Database {

    use Tqdev\PhpCrudApi\Column\Reflection\ReflectedColumn;

    class ColumnConverter
    {
        private $driver;

        public function __construct(string $driver)
        {
            $this->driver = $driver;
        }

        public function convertColumnValue(ReflectedColumn $column): string
        {
            if ($column->isBoolean()) {
                switch ($this->driver) {
                    case 'mysql':
                        return "IFNULL(IF(?,TRUE,FALSE),NULL)";
                    case 'pgsql':
                        return "?";
                    case 'sqlsrv':
                        return "?";
                }
            }
            if ($column->isBinary()) {
                switch ($this->driver) {
                    case 'mysql':
                        return "FROM_BASE64(?)";
                    case 'pgsql':
                        return "decode(?, 'base64')";
                    case 'sqlsrv':
                        return "CONVERT(XML, ?).value('.','varbinary(max)')";
                }
            }
            if ($column->isGeometry()) {
                switch ($this->driver) {
                    case 'mysql':
                    case 'pgsql':
                        return "ST_GeomFromText(?)";
                    case 'sqlsrv':
                        return "geometry::STGeomFromText(?,0)";
                }
            }
            return '?';
        }

        public function convertColumnName(ReflectedColumn $column, $value): string
        {
            if ($column->isBinary()) {
                switch ($this->driver) {
                    case 'mysql':
                        return "TO_BASE64($value) as $value";
                    case 'pgsql':
                        return "encode($value::bytea, 'base64') as $value";
                    case 'sqlsrv':
                        return "CASE WHEN $value IS NULL THEN NULL ELSE (SELECT CAST($value as varbinary(max)) FOR XML PATH(''), BINARY BASE64) END as $value";
                }
            }
            if ($column->isGeometry()) {
                switch ($this->driver) {
                    case 'mysql':
                    case 'pgsql':
                        return "ST_AsText($value) as $value";
                    case 'sqlsrv':
                        return "REPLACE($value.STAsText(),' (','(') as $value";
                }
            }
            return $value;
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Database/ColumnsBuilder.php
namespace Tqdev\PhpCrudApi\Database {

    use Tqdev\PhpCrudApi\Column\Reflection\ReflectedColumn;
    use Tqdev\PhpCrudApi\Column\Reflection\ReflectedTable;

    class ColumnsBuilder
    {
        private $driver;
        private $converter;

        public function __construct(string $driver)
        {
            $this->driver = $driver;
            $this->converter = new ColumnConverter($driver);
        }

        public function getOffsetLimit(int $offset, int $limit): string
        {
            if ($limit < 0 || $offset < 0) {
                return '';
            }
            switch ($this->driver) {
                case 'mysql':
                    return " LIMIT $offset, $limit";
                case 'pgsql':
                    return " LIMIT $limit OFFSET $offset";
                case 'sqlsrv':
                    return " OFFSET $offset ROWS FETCH NEXT $limit ROWS ONLY";
                case 'sqlite':
                    return " LIMIT $limit OFFSET $offset";
            }
        }

        private function quoteColumnName(ReflectedColumn $column): string
        {
            return '"' . $column->getName() . '"';
        }

        public function getOrderBy(ReflectedTable $table, array $columnOrdering): string
        {
            if (count($columnOrdering) == 0) {
                return '';
            }
            $results = array();
            foreach ($columnOrdering as $i => list($columnName, $ordering)) {
                $column = $table->getColumn($columnName);
                $quotedColumnName = $this->quoteColumnName($column);
                $results[] = $quotedColumnName . ' ' . $ordering;
            }
            return ' ORDER BY ' . implode(',', $results);
        }

        public function getSelect(ReflectedTable $table, array $columnNames): string
        {
            $results = array();
            foreach ($columnNames as $columnName) {
                $column = $table->getColumn($columnName);
                $quotedColumnName = $this->quoteColumnName($column);
                $quotedColumnName = $this->converter->convertColumnName($column, $quotedColumnName);
                $results[] = $quotedColumnName;
            }
            return implode(',', $results);
        }

        public function getInsert(ReflectedTable $table, array $columnValues): string
        {
            $columns = array();
            $values = array();
            foreach ($columnValues as $columnName => $columnValue) {
                $column = $table->getColumn($columnName);
                $quotedColumnName = $this->quoteColumnName($column);
                $columns[] = $quotedColumnName;
                $columnValue = $this->converter->convertColumnValue($column);
                $values[] = $columnValue;
            }
            $columnsSql = '(' . implode(',', $columns) . ')';
            $valuesSql = '(' . implode(',', $values) . ')';
            $outputColumn = $this->quoteColumnName($table->getPk());
            switch ($this->driver) {
                case 'mysql':
                    return "$columnsSql VALUES $valuesSql";
                case 'pgsql':
                    return "$columnsSql VALUES $valuesSql RETURNING $outputColumn";
                case 'sqlsrv':
                    return "$columnsSql OUTPUT INSERTED.$outputColumn VALUES $valuesSql";
                case 'sqlite':
                    return "$columnsSql VALUES $valuesSql";
            }
        }

        public function getUpdate(ReflectedTable $table, array $columnValues): string
        {
            $results = array();
            foreach ($columnValues as $columnName => $columnValue) {
                $column = $table->getColumn($columnName);
                $quotedColumnName = $this->quoteColumnName($column);
                $columnValue = $this->converter->convertColumnValue($column);
                $results[] = $quotedColumnName . '=' . $columnValue;
            }
            return implode(',', $results);
        }

        public function getIncrement(ReflectedTable $table, array $columnValues): string
        {
            $results = array();
            foreach ($columnValues as $columnName => $columnValue) {
                if (!is_numeric($columnValue)) {
                    continue;
                }
                $column = $table->getColumn($columnName);
                $quotedColumnName = $this->quoteColumnName($column);
                $columnValue = $this->converter->convertColumnValue($column);
                $results[] = $quotedColumnName . '=' . $quotedColumnName . '+' . $columnValue;
            }
            return implode(',', $results);
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Database/ConditionsBuilder.php
namespace Tqdev\PhpCrudApi\Database {

    use Tqdev\PhpCrudApi\Column\Reflection\ReflectedColumn;
    use Tqdev\PhpCrudApi\Record\Condition\AndCondition;
    use Tqdev\PhpCrudApi\Record\Condition\ColumnCondition;
    use Tqdev\PhpCrudApi\Record\Condition\Condition;
    use Tqdev\PhpCrudApi\Record\Condition\NoCondition;
    use Tqdev\PhpCrudApi\Record\Condition\NotCondition;
    use Tqdev\PhpCrudApi\Record\Condition\OrCondition;
    use Tqdev\PhpCrudApi\Record\Condition\SpatialCondition;

    class ConditionsBuilder
    {
        private $driver;

        public function __construct(string $driver)
        {
            $this->driver = $driver;
        }

        private function getConditionSql(Condition $condition, array &$arguments): string
        {
            if ($condition instanceof AndCondition) {
                return $this->getAndConditionSql($condition, $arguments);
            }
            if ($condition instanceof OrCondition) {
                return $this->getOrConditionSql($condition, $arguments);
            }
            if ($condition instanceof NotCondition) {
                return $this->getNotConditionSql($condition, $arguments);
            }
            if ($condition instanceof SpatialCondition) {
                return $this->getSpatialConditionSql($condition, $arguments);
            }
            if ($condition instanceof ColumnCondition) {
                return $this->getColumnConditionSql($condition, $arguments);
            }
            throw new \Exception('Unknown Condition: ' . get_class($condition));
        }

        private function getAndConditionSql(AndCondition $and, array &$arguments): string
        {
            $parts = [];
            foreach ($and->getConditions() as $condition) {
                $parts[] = $this->getConditionSql($condition, $arguments);
            }
            return '(' . implode(' AND ', $parts) . ')';
        }

        private function getOrConditionSql(OrCondition $or, array &$arguments): string
        {
            $parts = [];
            foreach ($or->getConditions() as $condition) {
                $parts[] = $this->getConditionSql($condition, $arguments);
            }
            return '(' . implode(' OR ', $parts) . ')';
        }

        private function getNotConditionSql(NotCondition $not, array &$arguments): string
        {
            $condition = $not->getCondition();
            return '(NOT ' . $this->getConditionSql($condition, $arguments) . ')';
        }

        private function quoteColumnName(ReflectedColumn $column): string
        {
            return '"' . $column->getName() . '"';
        }

        private function escapeLikeValue(string $value): string
        {
            return addcslashes($value, '%_');
        }

        private function getColumnConditionSql(ColumnCondition $condition, array &$arguments): string
        {
            $column = $this->quoteColumnName($condition->getColumn());
            $operator = $condition->getOperator();
            $value = $condition->getValue();
            switch ($operator) {
                case 'cs':
                    $sql = "$column LIKE ?";
                    $arguments[] = '%' . $this->escapeLikeValue($value) . '%';
                    break;
                case 'sw':
                    $sql = "$column LIKE ?";
                    $arguments[] = $this->escapeLikeValue($value) . '%';
                    break;
                case 'ew':
                    $sql = "$column LIKE ?";
                    $arguments[] = '%' . $this->escapeLikeValue($value);
                    break;
                case 'eq':
                    $sql = "$column = ?";
                    $arguments[] = $value;
                    break;
                case 'lt':
                    $sql = "$column < ?";
                    $arguments[] = $value;
                    break;
                case 'le':
                    $sql = "$column <= ?";
                    $arguments[] = $value;
                    break;
                case 'ge':
                    $sql = "$column >= ?";
                    $arguments[] = $value;
                    break;
                case 'gt':
                    $sql = "$column > ?";
                    $arguments[] = $value;
                    break;
                case 'bt':
                    $parts = explode(',', $value, 2);
                    $count = count($parts);
                    if ($count == 2) {
                        $sql = "($column >= ? AND $column <= ?)";
                        $arguments[] = $parts[0];
                        $arguments[] = $parts[1];
                    } else {
                        $sql = "FALSE";
                    }
                    break;
                case 'in':
                    $parts = explode(',', $value);
                    $count = count($parts);
                    if ($count > 0) {
                        $qmarks = implode(',', str_split(str_repeat('?', $count)));
                        $sql = "$column IN ($qmarks)";
                        for ($i = 0; $i < $count; $i++) {
                            $arguments[] = $parts[$i];
                        }
                    } else {
                        $sql = "FALSE";
                    }
                    break;
                case 'is':
                    $sql = "$column IS NULL";
                    break;
            }
            return $sql;
        }

        private function getSpatialFunctionName(string $operator): string
        {
            switch ($operator) {
                case 'co':
                    return 'ST_Contains';
                case 'cr':
                    return 'ST_Crosses';
                case 'di':
                    return 'ST_Disjoint';
                case 'eq':
                    return 'ST_Equals';
                case 'in':
                    return 'ST_Intersects';
                case 'ov':
                    return 'ST_Overlaps';
                case 'to':
                    return 'ST_Touches';
                case 'wi':
                    return 'ST_Within';
                case 'ic':
                    return 'ST_IsClosed';
                case 'is':
                    return 'ST_IsSimple';
                case 'iv':
                    return 'ST_IsValid';
            }
        }

        private function hasSpatialArgument(string $operator): bool
        {
            return in_array($operator, ['ic', 'is', 'iv']) ? false : true;
        }

        private function getSpatialFunctionCall(string $functionName, string $column, bool $hasArgument): string
        {
            switch ($this->driver) {
                case 'mysql':
                case 'pgsql':
                    $argument = $hasArgument ? 'ST_GeomFromText(?)' : '';
                    return "$functionName($column, $argument)=TRUE";
                case 'sqlsrv':
                    $functionName = str_replace('ST_', 'ST', $functionName);
                    $argument = $hasArgument ? 'geometry::STGeomFromText(?,0)' : '';
                    return "$column.$functionName($argument)=1";
                case 'sqlite':
                    $argument = $hasArgument ? '?' : '0';
                    return "$functionName($column, $argument)=1";
            }
        }

        private function getSpatialConditionSql(ColumnCondition $condition, array &$arguments): string
        {
            $column = $this->quoteColumnName($condition->getColumn());
            $operator = $condition->getOperator();
            $value = $condition->getValue();
            $functionName = $this->getSpatialFunctionName($operator);
            $hasArgument = $this->hasSpatialArgument($operator);
            $sql = $this->getSpatialFunctionCall($functionName, $column, $hasArgument);
            if ($hasArgument) {
                $arguments[] = $value;
            }
            return $sql;
        }

        public function getWhereClause(Condition $condition, array &$arguments): string
        {
            if ($condition instanceof NoCondition) {
                return '';
            }
            return ' WHERE ' . $this->getConditionSql($condition, $arguments);
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Database/DataConverter.php
namespace Tqdev\PhpCrudApi\Database {

    use Tqdev\PhpCrudApi\Column\Reflection\ReflectedColumn;
    use Tqdev\PhpCrudApi\Column\Reflection\ReflectedTable;

    class DataConverter
    {
        private $driver;

        public function __construct(string $driver)
        {
            $this->driver = $driver;
        }

        private function convertRecordValue($conversion, $value)
        {
            $args = explode('|', $conversion);
            $type = array_shift($args);
            switch ($type) {
                case 'boolean':
                    return $value ? true : false;
                case 'integer':
                    return (int) $value;
                case 'float':
                    return (float) $value;
                case 'decimal':
                    return number_format($value, $args[0], '.', '');
            }
            return $value;
        }

        private function getRecordValueConversion(ReflectedColumn $column): string
        {
            if ($column->isBoolean()) {
                return 'boolean';
            }
            if (in_array($column->getType(), ['integer', 'bigint'])) {
                return 'integer';
            }
            if (in_array($column->getType(), ['float', 'double'])) {
                return 'float';
            }
            if (in_array($this->driver, ['sqlite']) && in_array($column->getType(), ['decimal'])) {
                return 'decimal|' . $column->getScale();
            }
            return 'none';
        }

        public function convertRecords(ReflectedTable $table, array $columnNames, array &$records) /*: void*/
        {
            foreach ($columnNames as $columnName) {
                $column = $table->getColumn($columnName);
                $conversion = $this->getRecordValueConversion($column);
                if ($conversion != 'none') {
                    foreach ($records as $i => $record) {
                        $value = $records[$i][$columnName];
                        if ($value === null) {
                            continue;
                        }
                        $records[$i][$columnName] = $this->convertRecordValue($conversion, $value);
                    }
                }
            }
        }

        private function convertInputValue($conversion, $value)
        {
            switch ($conversion) {
                case 'boolean':
                    return $value ? 1 : 0;
                case 'base64url_to_base64':
                    return str_pad(strtr($value, '-_', '+/'), ceil(strlen($value) / 4) * 4, '=', STR_PAD_RIGHT);
            }
            return $value;
        }

        private function getInputValueConversion(ReflectedColumn $column): string
        {
            if ($column->isBoolean()) {
                return 'boolean';
            }
            if ($column->isBinary()) {
                return 'base64url_to_base64';
            }
            return 'none';
        }

        public function convertColumnValues(ReflectedTable $table, array &$columnValues) /*: void*/
        {
            $columnNames = array_keys($columnValues);
            foreach ($columnNames as $columnName) {
                $column = $table->getColumn($columnName);
                $conversion = $this->getInputValueConversion($column);
                if ($conversion != 'none') {
                    $value = $columnValues[$columnName];
                    if ($value !== null) {
                        $columnValues[$columnName] = $this->convertInputValue($conversion, $value);
                    }
                }
            }
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Database/GenericDB.php
namespace Tqdev\PhpCrudApi\Database {

    use Tqdev\PhpCrudApi\Column\Reflection\ReflectedTable;
    use Tqdev\PhpCrudApi\Middleware\Communication\VariableStore;
    use Tqdev\PhpCrudApi\Record\Condition\ColumnCondition;
    use Tqdev\PhpCrudApi\Record\Condition\Condition;

    class GenericDB
    {
        private $driver;
        private $address;
        private $port;
        private $database;
        private $tables;
        private $username;
        private $password;
        private $pdo;
        private $reflection;
        private $definition;
        private $conditions;
        private $columns;
        private $converter;

        private function getDsn(): string
        {
            switch ($this->driver) {
                case 'mysql':
                    return "$this->driver:host=$this->address;port=$this->port;dbname=$this->database;charset=utf8mb4";
                case 'pgsql':
                    return "$this->driver:host=$this->address port=$this->port dbname=$this->database options='--client_encoding=UTF8'";
                case 'sqlsrv':
                    return "$this->driver:Server=$this->address,$this->port;Database=$this->database";
                case 'sqlite':
                    return "$this->driver:$this->address";
            }
        }

        private function getCommands(): array
        {
            switch ($this->driver) {
                case 'mysql':
                    return [
                        'SET SESSION sql_warnings=1;',
                        'SET NAMES utf8mb4;',
                        'SET SESSION sql_mode = "ANSI,TRADITIONAL";',
                    ];
                case 'pgsql':
                    return [
                        "SET NAMES 'UTF8';",
                    ];
                case 'sqlsrv':
                    return [];
                case 'sqlite':
                    return [
                        'PRAGMA foreign_keys = on;',
                    ];
            }
        }

        private function getOptions(): array
        {
            $options = array(
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            );
            switch ($this->driver) {
                case 'mysql':
                    return $options + [
                        \PDO::MYSQL_ATTR_FOUND_ROWS => true,
                        \PDO::ATTR_PERSISTENT => true,
                    ];
                case 'pgsql':
                    return $options + [
                        \PDO::ATTR_PERSISTENT => true,
                    ];
                case 'sqlsrv':
                    return $options + [];
                case 'sqlite':
                    return $options + [];
            }
        }

        private function initPdo(): bool
        {
            if ($this->pdo) {
                $result = $this->pdo->reconstruct($this->getDsn(), $this->username, $this->password, $this->getOptions());
            } else {
                $this->pdo = new LazyPdo($this->getDsn(), $this->username, $this->password, $this->getOptions());
                $result = true;
            }
            $commands = $this->getCommands();
            foreach ($commands as $command) {
                $this->pdo->addInitCommand($command);
            }
            $this->reflection = new GenericReflection($this->pdo, $this->driver, $this->database, $this->tables);
            $this->definition = new GenericDefinition($this->pdo, $this->driver, $this->database, $this->tables);
            $this->conditions = new ConditionsBuilder($this->driver);
            $this->columns = new ColumnsBuilder($this->driver);
            $this->converter = new DataConverter($this->driver);
            return $result;
        }

        public function __construct(string $driver, string $address, int $port, string $database, array $tables, string $username, string $password)
        {
            $this->driver = $driver;
            $this->address = $address;
            $this->port = $port;
            $this->database = $database;
            $this->tables = $tables;
            $this->username = $username;
            $this->password = $password;
            $this->initPdo();
        }

        public function reconstruct(string $driver, string $address, int $port, string $database, array $tables, string $username, string $password): bool
        {
            if ($driver) {
                $this->driver = $driver;
            }
            if ($address) {
                $this->address = $address;
            }
            if ($port) {
                $this->port = $port;
            }
            if ($database) {
                $this->database = $database;
            }
            if ($tables) {
                $this->tables = $tables;
            }
            if ($username) {
                $this->username = $username;
            }
            if ($password) {
                $this->password = $password;
            }
            return $this->initPdo();
        }

        public function pdo(): LazyPdo
        {
            return $this->pdo;
        }

        public function reflection(): GenericReflection
        {
            return $this->reflection;
        }

        public function definition(): GenericDefinition
        {
            return $this->definition;
        }

        public function beginTransaction() /*: void*/
        {
            $this->pdo->beginTransaction();
        }

        public function commitTransaction() /*: void*/
        {
            $this->pdo->commit();
        }

        public function rollBackTransaction() /*: void*/
        {
            $this->pdo->rollBack();
        }

        private function addMiddlewareConditions(string $tableName, Condition $condition): Condition
        {
            $condition1 = VariableStore::get("authorization.conditions.$tableName");
            if ($condition1) {
                $condition = $condition->_and($condition1);
            }
            $condition2 = VariableStore::get("multiTenancy.conditions.$tableName");
            if ($condition2) {
                $condition = $condition->_and($condition2);
            }
            return $condition;
        }

        public function createSingle(ReflectedTable $table, array $columnValues) /*: ?String*/
        {
            $this->converter->convertColumnValues($table, $columnValues);
            $insertColumns = $this->columns->getInsert($table, $columnValues);
            $tableName = $table->getName();
            $pkName = $table->getPk()->getName();
            $parameters = array_values($columnValues);
            $sql = 'INSERT INTO "' . $tableName . '" ' . $insertColumns;
            $stmt = $this->query($sql, $parameters);
            // return primary key value if specified in the input
            if (isset($columnValues[$pkName])) {
                return $columnValues[$pkName];
            }
            // work around missing "returning" or "output" in mysql
            switch ($this->driver) {
                case 'mysql':
                    $stmt = $this->query('SELECT LAST_INSERT_ID()', []);
                    break;
                case 'sqlite':
                    $stmt = $this->query('SELECT LAST_INSERT_ROWID()', []);
                    break;
            }
            $pkValue = $stmt->fetchColumn(0);
            if ($table->getPk()->getType() == 'bigint') {
                return (int) $pkValue;
            }
            if (in_array($table->getPk()->getType(), ['integer', 'bigint'])) {
                return (int) $pkValue;
            }
            return $pkValue;
        }

        public function selectSingle(ReflectedTable $table, array $columnNames, string $id) /*: ?array*/
        {
            $selectColumns = $this->columns->getSelect($table, $columnNames);
            $tableName = $table->getName();
            $condition = new ColumnCondition($table->getPk(), 'eq', $id);
            $condition = $this->addMiddlewareConditions($tableName, $condition);
            $parameters = array();
            $whereClause = $this->conditions->getWhereClause($condition, $parameters);
            $sql = 'SELECT ' . $selectColumns . ' FROM "' . $tableName . '" ' . $whereClause;
            $stmt = $this->query($sql, $parameters);
            $record = $stmt->fetch() ?: null;
            if ($record === null) {
                return null;
            }
            $records = array($record);
            $this->converter->convertRecords($table, $columnNames, $records);
            return $records[0];
        }

        public function selectMultiple(ReflectedTable $table, array $columnNames, array $ids): array
        {
            if (count($ids) == 0) {
                return [];
            }
            $selectColumns = $this->columns->getSelect($table, $columnNames);
            $tableName = $table->getName();
            $condition = new ColumnCondition($table->getPk(), 'in', implode(',', $ids));
            $condition = $this->addMiddlewareConditions($tableName, $condition);
            $parameters = array();
            $whereClause = $this->conditions->getWhereClause($condition, $parameters);
            $sql = 'SELECT ' . $selectColumns . ' FROM "' . $tableName . '" ' . $whereClause;
            $stmt = $this->query($sql, $parameters);
            $records = $stmt->fetchAll();
            $this->converter->convertRecords($table, $columnNames, $records);
            return $records;
        }

        public function selectCount(ReflectedTable $table, Condition $condition): int
        {
            $tableName = $table->getName();
            $condition = $this->addMiddlewareConditions($tableName, $condition);
            $parameters = array();
            $whereClause = $this->conditions->getWhereClause($condition, $parameters);
            $sql = 'SELECT COUNT(*) FROM "' . $tableName . '"' . $whereClause;
            $stmt = $this->query($sql, $parameters);
            return $stmt->fetchColumn(0);
        }

        public function selectAll(ReflectedTable $table, array $columnNames, Condition $condition, array $columnOrdering, int $offset, int $limit): array
        {
            if ($limit == 0) {
                return array();
            }
            $selectColumns = $this->columns->getSelect($table, $columnNames);
            $tableName = $table->getName();
            $condition = $this->addMiddlewareConditions($tableName, $condition);
            $parameters = array();
            $whereClause = $this->conditions->getWhereClause($condition, $parameters);
            $orderBy = $this->columns->getOrderBy($table, $columnOrdering);
            $offsetLimit = $this->columns->getOffsetLimit($offset, $limit);
            $sql = 'SELECT ' . $selectColumns . ' FROM "' . $tableName . '"' . $whereClause . $orderBy . $offsetLimit;
            $stmt = $this->query($sql, $parameters);
            $records = $stmt->fetchAll();
            $this->converter->convertRecords($table, $columnNames, $records);
            return $records;
        }

        public function updateSingle(ReflectedTable $table, array $columnValues, string $id)
        {
            if (count($columnValues) == 0) {
                return 0;
            }
            $this->converter->convertColumnValues($table, $columnValues);
            $updateColumns = $this->columns->getUpdate($table, $columnValues);
            $tableName = $table->getName();
            $condition = new ColumnCondition($table->getPk(), 'eq', $id);
            $condition = $this->addMiddlewareConditions($tableName, $condition);
            $parameters = array_values($columnValues);
            $whereClause = $this->conditions->getWhereClause($condition, $parameters);
            $sql = 'UPDATE "' . $tableName . '" SET ' . $updateColumns . $whereClause;
            $stmt = $this->query($sql, $parameters);
            return $stmt->rowCount();
        }

        public function deleteSingle(ReflectedTable $table, string $id)
        {
            $tableName = $table->getName();
            $condition = new ColumnCondition($table->getPk(), 'eq', $id);
            $condition = $this->addMiddlewareConditions($tableName, $condition);
            $parameters = array();
            $whereClause = $this->conditions->getWhereClause($condition, $parameters);
            $sql = 'DELETE FROM "' . $tableName . '" ' . $whereClause;
            $stmt = $this->query($sql, $parameters);
            return $stmt->rowCount();
        }

        public function incrementSingle(ReflectedTable $table, array $columnValues, string $id)
        {
            if (count($columnValues) == 0) {
                return 0;
            }
            $this->converter->convertColumnValues($table, $columnValues);
            $updateColumns = $this->columns->getIncrement($table, $columnValues);
            $tableName = $table->getName();
            $condition = new ColumnCondition($table->getPk(), 'eq', $id);
            $condition = $this->addMiddlewareConditions($tableName, $condition);
            $parameters = array_values($columnValues);
            $whereClause = $this->conditions->getWhereClause($condition, $parameters);
            $sql = 'UPDATE "' . $tableName . '" SET ' . $updateColumns . $whereClause;
            $stmt = $this->query($sql, $parameters);
            return $stmt->rowCount();
        }

        private function query(string $sql, array $parameters): \PDOStatement
        {
            $stmt = $this->pdo->prepare($sql);
            //echo "- $sql -- " . json_encode($parameters, JSON_UNESCAPED_UNICODE) . "\n";
            $stmt->execute($parameters);
            return $stmt;
        }

        public function ping(): int
        {
            $start = microtime(true);
            $stmt = $this->pdo->prepare('SELECT 1');
            $stmt->execute();
            return intval((microtime(true) - $start) * 1000000);
        }

        public function getCacheKey(): string
        {
            return md5(json_encode([
                $this->driver,
                $this->address,
                $this->port,
                $this->database,
                $this->tables,
                $this->username,
            ]));
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Database/GenericDefinition.php
namespace Tqdev\PhpCrudApi\Database {

    use Tqdev\PhpCrudApi\Column\Reflection\ReflectedColumn;
    use Tqdev\PhpCrudApi\Column\Reflection\ReflectedTable;
    use Tqdev\PhpCrudApi\Database\LazyPdo;

    class GenericDefinition
    {
        private $pdo;
        private $driver;
        private $database;
        private $typeConverter;
        private $reflection;

        public function __construct(LazyPdo $pdo, string $driver, string $database, array $tables)
        {
            $this->pdo = $pdo;
            $this->driver = $driver;
            $this->database = $database;
            $this->typeConverter = new TypeConverter($driver);
            $this->reflection = new GenericReflection($pdo, $driver, $database, $tables);
        }

        private function quote(string $identifier): string
        {
            return '"' . str_replace('"', '', $identifier) . '"';
        }

        public function getColumnType(ReflectedColumn $column, bool $update): string
        {
            if ($this->driver == 'pgsql' && !$update && $column->getPk() && $this->canAutoIncrement($column)) {
                return 'serial';
            }
            $type = $this->typeConverter->fromJdbc($column->getType());
            if ($column->hasPrecision() && $column->hasScale()) {
                $size = '(' . $column->getPrecision() . ',' . $column->getScale() . ')';
            } elseif ($column->hasPrecision()) {
                $size = '(' . $column->getPrecision() . ')';
            } elseif ($column->hasLength()) {
                $size = '(' . $column->getLength() . ')';
            } else {
                $size = '';
            }
            $null = $this->getColumnNullType($column, $update);
            $auto = $this->getColumnAutoIncrement($column, $update);
            return $type . $size . $null . $auto;
        }

        private function getPrimaryKey(string $tableName): string
        {
            $pks = $this->reflection->getTablePrimaryKeys($tableName);
            if (count($pks) == 1) {
                return $pks[0];
            }
            return "";
        }

        private function canAutoIncrement(ReflectedColumn $column): bool
        {
            return in_array($column->getType(), ['integer', 'bigint']);
        }

        private function getColumnAutoIncrement(ReflectedColumn $column, bool $update): string
        {
            if (!$this->canAutoIncrement($column)) {
                return '';
            }
            switch ($this->driver) {
                case 'mysql':
                    return $column->getPk() ? ' AUTO_INCREMENT' : '';
                case 'pgsql':
                case 'sqlsrv':
                    return $column->getPk() ? ' IDENTITY(1,1)' : '';
                case 'sqlite':
                    return $column->getPk() ? ' AUTOINCREMENT' : '';
            }
        }

        private function getColumnNullType(ReflectedColumn $column, bool $update): string
        {
            if ($this->driver == 'pgsql' && $update) {
                return '';
            }
            return $column->getNullable() ? ' NULL' : ' NOT NULL';
        }

        private function getTableRenameSQL(string $tableName, string $newTableName): string
        {
            $p1 = $this->quote($tableName);
            $p2 = $this->quote($newTableName);

            switch ($this->driver) {
                case 'mysql':
                    return "RENAME TABLE $p1 TO $p2";
                case 'pgsql':
                    return "ALTER TABLE $p1 RENAME TO $p2";
                case 'sqlsrv':
                    return "EXEC sp_rename $p1, $p2";
                case 'sqlite':
                    return "ALTER TABLE $p1 RENAME TO $p2";
            }
        }

        private function getColumnRenameSQL(string $tableName, string $columnName, ReflectedColumn $newColumn): string
        {
            $p1 = $this->quote($tableName);
            $p2 = $this->quote($columnName);
            $p3 = $this->quote($newColumn->getName());

            switch ($this->driver) {
                case 'mysql':
                    $p4 = $this->getColumnType($newColumn, true);
                    return "ALTER TABLE $p1 CHANGE $p2 $p3 $p4";
                case 'pgsql':
                    return "ALTER TABLE $p1 RENAME COLUMN $p2 TO $p3";
                case 'sqlsrv':
                    $p4 = $this->quote($tableName . '.' . $columnName);
                    return "EXEC sp_rename $p4, $p3, 'COLUMN'";
                case 'sqlite':
                    return "ALTER TABLE $p1 RENAME COLUMN $p2 TO $p3";
            }
        }

        private function getColumnRetypeSQL(string $tableName, string $columnName, ReflectedColumn $newColumn): string
        {
            $p1 = $this->quote($tableName);
            $p2 = $this->quote($columnName);
            $p3 = $this->quote($newColumn->getName());
            $p4 = $this->getColumnType($newColumn, true);

            switch ($this->driver) {
                case 'mysql':
                    return "ALTER TABLE $p1 CHANGE $p2 $p3 $p4";
                case 'pgsql':
                    return "ALTER TABLE $p1 ALTER COLUMN $p3 TYPE $p4";
                case 'sqlsrv':
                    return "ALTER TABLE $p1 ALTER COLUMN $p3 $p4";
            }
        }

        private function getSetColumnNullableSQL(string $tableName, string $columnName, ReflectedColumn $newColumn): string
        {
            $p1 = $this->quote($tableName);
            $p2 = $this->quote($columnName);
            $p3 = $this->quote($newColumn->getName());
            $p4 = $this->getColumnType($newColumn, true);

            switch ($this->driver) {
                case 'mysql':
                    return "ALTER TABLE $p1 CHANGE $p2 $p3 $p4";
                case 'pgsql':
                    $p5 = $newColumn->getNullable() ? 'DROP NOT NULL' : 'SET NOT NULL';
                    return "ALTER TABLE $p1 ALTER COLUMN $p2 $p5";
                case 'sqlsrv':
                    return "ALTER TABLE $p1 ALTER COLUMN $p2 $p4";
            }
        }

        private function getSetColumnPkConstraintSQL(string $tableName, string $columnName, ReflectedColumn $newColumn): string
        {
            $p1 = $this->quote($tableName);
            $p2 = $this->quote($columnName);
            $p3 = $this->quote($tableName . '_pkey');

            switch ($this->driver) {
                case 'mysql':
                    $p4 = $newColumn->getPk() ? "ADD PRIMARY KEY ($p2)" : 'DROP PRIMARY KEY';
                    return "ALTER TABLE $p1 $p4";
                case 'pgsql':
                case 'sqlsrv':
                    $p4 = $newColumn->getPk() ? "ADD CONSTRAINT $p3 PRIMARY KEY ($p2)" : "DROP CONSTRAINT $p3";
                    return "ALTER TABLE $p1 $p4";
            }
        }

        private function getSetColumnPkSequenceSQL(string $tableName, string $columnName, ReflectedColumn $newColumn): string
        {
            $p1 = $this->quote($tableName);
            $p2 = $this->quote($columnName);
            $p3 = $this->quote($tableName . '_' . $columnName . '_seq');

            switch ($this->driver) {
                case 'mysql':
                    return "select 1";
                case 'pgsql':
                    return $newColumn->getPk() ? "CREATE SEQUENCE $p3 OWNED BY $p1.$p2" : "DROP SEQUENCE $p3";
                case 'sqlsrv':
                    return $newColumn->getPk() ? "CREATE SEQUENCE $p3" : "DROP SEQUENCE $p3";
            }
        }

        private function getSetColumnPkSequenceStartSQL(string $tableName, string $columnName, ReflectedColumn $newColumn): string
        {
            $p1 = $this->quote($tableName);
            $p2 = $this->quote($columnName);

            switch ($this->driver) {
                case 'mysql':
                    return "select 1";
                case 'pgsql':
                    $p3 = $this->pdo->quote($tableName . '_' . $columnName . '_seq');
                    return "SELECT setval($p3, (SELECT max($p2)+1 FROM $p1));";
                case 'sqlsrv':
                    $p3 = $this->quote($tableName . '_' . $columnName . '_seq');
                    $p4 = $this->pdo->query("SELECT max($p2)+1 FROM $p1")->fetchColumn();
                    return "ALTER SEQUENCE $p3 RESTART WITH $p4";
            }
        }

        private function getSetColumnPkDefaultSQL(string $tableName, string $columnName, ReflectedColumn $newColumn): string
        {
            $p1 = $this->quote($tableName);
            $p2 = $this->quote($columnName);

            switch ($this->driver) {
                case 'mysql':
                    $p3 = $this->quote($newColumn->getName());
                    $p4 = $this->getColumnType($newColumn, true);
                    return "ALTER TABLE $p1 CHANGE $p2 $p3 $p4";
                case 'pgsql':
                    if ($newColumn->getPk()) {
                        $p3 = $this->pdo->quote($tableName . '_' . $columnName . '_seq');
                        $p4 = "SET DEFAULT nextval($p3)";
                    } else {
                        $p4 = 'DROP DEFAULT';
                    }
                    return "ALTER TABLE $p1 ALTER COLUMN $p2 $p4";
                case 'sqlsrv':
                    $p3 = $this->quote($tableName . '_' . $columnName . '_seq');
                    $p4 = $this->quote($tableName . '_' . $columnName . '_def');
                    if ($newColumn->getPk()) {
                        return "ALTER TABLE $p1 ADD CONSTRAINT $p4 DEFAULT NEXT VALUE FOR $p3 FOR $p2";
                    } else {
                        return "ALTER TABLE $p1 DROP CONSTRAINT $p4";
                    }
            }
        }

        private function getAddColumnFkConstraintSQL(string $tableName, string $columnName, ReflectedColumn $newColumn): string
        {
            $p1 = $this->quote($tableName);
            $p2 = $this->quote($columnName);
            $p3 = $this->quote($tableName . '_' . $columnName . '_fkey');
            $p4 = $this->quote($newColumn->getFk());
            $p5 = $this->quote($this->getPrimaryKey($newColumn->getFk()));

            return "ALTER TABLE $p1 ADD CONSTRAINT $p3 FOREIGN KEY ($p2) REFERENCES $p4 ($p5)";
        }

        private function getRemoveColumnFkConstraintSQL(string $tableName, string $columnName, ReflectedColumn $newColumn): string
        {
            $p1 = $this->quote($tableName);
            $p2 = $this->quote($tableName . '_' . $columnName . '_fkey');

            switch ($this->driver) {
                case 'mysql':
                    return "ALTER TABLE $p1 DROP FOREIGN KEY $p2";
                case 'pgsql':
                case 'sqlsrv':
                    return "ALTER TABLE $p1 DROP CONSTRAINT $p2";
            }
        }

        private function getAddTableSQL(ReflectedTable $newTable): string
        {
            $tableName = $newTable->getName();
            $p1 = $this->quote($tableName);
            $fields = [];
            $constraints = [];
            foreach ($newTable->getColumnNames() as $columnName) {
                $pkColumn = $this->getPrimaryKey($tableName);
                $newColumn = $newTable->getColumn($columnName);
                $f1 = $this->quote($columnName);
                $f2 = $this->getColumnType($newColumn, false);
                $f3 = $this->quote($tableName . '_' . $columnName . '_fkey');
                $f4 = $this->quote($newColumn->getFk());
                $f5 = $this->quote($this->getPrimaryKey($newColumn->getFk()));
                $f6 = $this->quote($tableName . '_' . $pkColumn . '_pkey');
                if ($this->driver == 'sqlite') {
                    if ($newColumn->getPk()) {
                        $f2 = str_replace('NULL', 'NULL PRIMARY KEY', $f2);
                    }
                    $fields[] = "$f1 $f2";
                    if ($newColumn->getFk()) {
                        $constraints[] = "FOREIGN KEY ($f1) REFERENCES $f4 ($f5)";
                    }
                } else {
                    $fields[] = "$f1 $f2";
                    if ($newColumn->getPk()) {
                        $constraints[] = "CONSTRAINT $f6 PRIMARY KEY ($f1)";
                    }
                    if ($newColumn->getFk()) {
                        $constraints[] = "CONSTRAINT $f3 FOREIGN KEY ($f1) REFERENCES $f4 ($f5)";
                    }
                }
            }
            $p2 = implode(',', array_merge($fields, $constraints));

            return "CREATE TABLE $p1 ($p2);";
        }

        private function getAddColumnSQL(string $tableName, ReflectedColumn $newColumn): string
        {
            $p1 = $this->quote($tableName);
            $p2 = $this->quote($newColumn->getName());
            $p3 = $this->getColumnType($newColumn, false);

            switch ($this->driver) {
                case 'mysql':
                case 'pgsql':
                    return "ALTER TABLE $p1 ADD COLUMN $p2 $p3";
                case 'sqlsrv':
                    return "ALTER TABLE $p1 ADD $p2 $p3";
                case 'sqlite':
                    return "ALTER TABLE $p1 ADD COLUMN $p2 $p3";
            }
        }

        private function getRemoveTableSQL(string $tableName): string
        {
            $p1 = $this->quote($tableName);

            switch ($this->driver) {
                case 'mysql':
                case 'pgsql':
                    return "DROP TABLE $p1 CASCADE;";
                case 'sqlsrv':
                    return "DROP TABLE $p1;";
                case 'sqlite':
                    return "DROP TABLE $p1;";
            }
        }

        private function getRemoveColumnSQL(string $tableName, string $columnName): string
        {
            $p1 = $this->quote($tableName);
            $p2 = $this->quote($columnName);

            switch ($this->driver) {
                case 'mysql':
                case 'pgsql':
                    return "ALTER TABLE $p1 DROP COLUMN $p2 CASCADE;";
                case 'sqlsrv':
                    return "ALTER TABLE $p1 DROP COLUMN $p2;";
                case 'sqlite':
                    return "ALTER TABLE $p1 DROP COLUMN $p2;";
            }
        }

        public function renameTable(string $tableName, string $newTableName)
        {
            $sql = $this->getTableRenameSQL($tableName, $newTableName);
            return $this->query($sql, []);
        }

        public function renameColumn(string $tableName, string $columnName, ReflectedColumn $newColumn)
        {
            $sql = $this->getColumnRenameSQL($tableName, $columnName, $newColumn);
            return $this->query($sql, []);
        }

        public function retypeColumn(string $tableName, string $columnName, ReflectedColumn $newColumn)
        {
            $sql = $this->getColumnRetypeSQL($tableName, $columnName, $newColumn);
            return $this->query($sql, []);
        }

        public function setColumnNullable(string $tableName, string $columnName, ReflectedColumn $newColumn)
        {
            $sql = $this->getSetColumnNullableSQL($tableName, $columnName, $newColumn);
            return $this->query($sql, []);
        }

        public function addColumnPrimaryKey(string $tableName, string $columnName, ReflectedColumn $newColumn)
        {
            $sql = $this->getSetColumnPkConstraintSQL($tableName, $columnName, $newColumn);
            $this->query($sql, []);
            if ($this->canAutoIncrement($newColumn)) {
                $sql = $this->getSetColumnPkSequenceSQL($tableName, $columnName, $newColumn);
                $this->query($sql, []);
                $sql = $this->getSetColumnPkSequenceStartSQL($tableName, $columnName, $newColumn);
                $this->query($sql, []);
                $sql = $this->getSetColumnPkDefaultSQL($tableName, $columnName, $newColumn);
                $this->query($sql, []);
            }
            return true;
        }

        public function removeColumnPrimaryKey(string $tableName, string $columnName, ReflectedColumn $newColumn)
        {
            if ($this->canAutoIncrement($newColumn)) {
                $sql = $this->getSetColumnPkDefaultSQL($tableName, $columnName, $newColumn);
                $this->query($sql, []);
                $sql = $this->getSetColumnPkSequenceSQL($tableName, $columnName, $newColumn);
                $this->query($sql, []);
            }
            $sql = $this->getSetColumnPkConstraintSQL($tableName, $columnName, $newColumn);
            $this->query($sql, []);
            return true;
        }

        public function addColumnForeignKey(string $tableName, string $columnName, ReflectedColumn $newColumn)
        {
            $sql = $this->getAddColumnFkConstraintSQL($tableName, $columnName, $newColumn);
            return $this->query($sql, []);
        }

        public function removeColumnForeignKey(string $tableName, string $columnName, ReflectedColumn $newColumn)
        {
            $sql = $this->getRemoveColumnFkConstraintSQL($tableName, $columnName, $newColumn);
            return $this->query($sql, []);
        }

        public function addTable(ReflectedTable $newTable)
        {
            $sql = $this->getAddTableSQL($newTable);
            return $this->query($sql, []);
        }

        public function addColumn(string $tableName, ReflectedColumn $newColumn)
        {
            $sql = $this->getAddColumnSQL($tableName, $newColumn);
            return $this->query($sql, []);
        }

        public function removeTable(string $tableName)
        {
            $sql = $this->getRemoveTableSQL($tableName);
            return $this->query($sql, []);
        }

        public function removeColumn(string $tableName, string $columnName)
        {
            $sql = $this->getRemoveColumnSQL($tableName, $columnName);
            return $this->query($sql, []);
        }

        private function query(string $sql, array $arguments): bool
        {
            $stmt = $this->pdo->prepare($sql);
            // echo "- $sql -- " . json_encode($arguments) . "\n";
            return $stmt->execute($arguments);
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Database/GenericReflection.php
namespace Tqdev\PhpCrudApi\Database {

    use Tqdev\PhpCrudApi\Database\LazyPdo;

    class GenericReflection
    {
        private $pdo;
        private $driver;
        private $database;
        private $tables;
        private $typeConverter;

        public function __construct(LazyPdo $pdo, string $driver, string $database, array $tables)
        {
            $this->pdo = $pdo;
            $this->driver = $driver;
            $this->database = $database;
            $this->tables = $tables;
            $this->typeConverter = new TypeConverter($driver);
        }

        public function getIgnoredTables(): array
        {
            switch ($this->driver) {
                case 'mysql':
                    return [];
                case 'pgsql':
                    return ['spatial_ref_sys', 'raster_columns', 'raster_overviews', 'geography_columns', 'geometry_columns'];
                case 'sqlsrv':
                    return [];
                case 'sqlite':
                    return [];
            }
        }

        private function getTablesSQL(): string
        {
            switch ($this->driver) {
                case 'mysql':
                    return 'SELECT "TABLE_NAME", "TABLE_TYPE" FROM "INFORMATION_SCHEMA"."TABLES" WHERE "TABLE_TYPE" IN (\'BASE TABLE\' , \'VIEW\') AND "TABLE_SCHEMA" = ? ORDER BY BINARY "TABLE_NAME"';
                case 'pgsql':
                    return 'SELECT c.relname as "TABLE_NAME", c.relkind as "TABLE_TYPE" FROM pg_catalog.pg_class c LEFT JOIN pg_catalog.pg_namespace n ON n.oid = c.relnamespace WHERE c.relkind IN (\'r\', \'v\') AND n.nspname <> \'pg_catalog\' AND n.nspname <> \'information_schema\' AND n.nspname !~ \'^pg_toast\' AND pg_catalog.pg_table_is_visible(c.oid) AND \'\' <> ? ORDER BY "TABLE_NAME";';
                case 'sqlsrv':
                    return 'SELECT o.name as "TABLE_NAME", o.xtype as "TABLE_TYPE" FROM sysobjects o WHERE o.xtype IN (\'U\', \'V\') ORDER BY "TABLE_NAME"';
                case 'sqlite':
                    return 'SELECT t.name as "TABLE_NAME", t.type as "TABLE_TYPE" FROM sqlite_master t WHERE t.type IN (\'table\', \'view\') AND \'\' <> ? ORDER BY "TABLE_NAME"';
            }
        }

        private function getTableColumnsSQL(): string
        {
            switch ($this->driver) {
                case 'mysql':
                    return 'SELECT "COLUMN_NAME", "IS_NULLABLE", "DATA_TYPE", "CHARACTER_MAXIMUM_LENGTH" as "CHARACTER_MAXIMUM_LENGTH", "NUMERIC_PRECISION", "NUMERIC_SCALE", "COLUMN_TYPE" FROM "INFORMATION_SCHEMA"."COLUMNS" WHERE "TABLE_NAME" = ? AND "TABLE_SCHEMA" = ? ORDER BY "ORDINAL_POSITION"';
                case 'pgsql':
                    return 'SELECT a.attname AS "COLUMN_NAME", case when a.attnotnull then \'NO\' else \'YES\' end as "IS_NULLABLE", pg_catalog.format_type(a.atttypid, -1) as "DATA_TYPE", case when a.atttypmod < 0 then NULL else a.atttypmod-4 end as "CHARACTER_MAXIMUM_LENGTH", case when a.atttypid != 1700 then NULL else ((a.atttypmod - 4) >> 16) & 65535 end as "NUMERIC_PRECISION", case when a.atttypid != 1700 then NULL else (a.atttypmod - 4) & 65535 end as "NUMERIC_SCALE", \'\' AS "COLUMN_TYPE" FROM pg_attribute a JOIN pg_class pgc ON pgc.oid = a.attrelid WHERE pgc.relname = ? AND \'\' <> ? AND a.attnum > 0 AND NOT a.attisdropped ORDER BY a.attnum;';
                case 'sqlsrv':
                    return 'SELECT c.name AS "COLUMN_NAME", c.is_nullable AS "IS_NULLABLE", t.Name AS "DATA_TYPE", (c.max_length/2) AS "CHARACTER_MAXIMUM_LENGTH", c.precision AS "NUMERIC_PRECISION", c.scale AS "NUMERIC_SCALE", \'\' AS "COLUMN_TYPE" FROM sys.columns c INNER JOIN sys.types t ON c.user_type_id = t.user_type_id WHERE c.object_id = OBJECT_ID(?) AND \'\' <> ? ORDER BY c.column_id';
                case 'sqlite':
                    return 'SELECT "name" AS "COLUMN_NAME", case when "notnull"==1 then \'no\' else \'yes\' end as "IS_NULLABLE", lower("type") AS "DATA_TYPE", 2147483647 AS "CHARACTER_MAXIMUM_LENGTH", 0 AS "NUMERIC_PRECISION", 0 AS "NUMERIC_SCALE", \'\' AS "COLUMN_TYPE" FROM pragma_table_info(?) WHERE \'\' <> ? ORDER BY "cid"';
            }
        }

        private function getTablePrimaryKeysSQL(): string
        {
            switch ($this->driver) {
                case 'mysql':
                    return 'SELECT "COLUMN_NAME" FROM "INFORMATION_SCHEMA"."KEY_COLUMN_USAGE" WHERE "CONSTRAINT_NAME" = \'PRIMARY\' AND "TABLE_NAME" = ? AND "TABLE_SCHEMA" = ?';
                case 'pgsql':
                    return 'SELECT a.attname AS "COLUMN_NAME" FROM pg_attribute a JOIN pg_constraint c ON (c.conrelid, c.conkey[1]) = (a.attrelid, a.attnum) JOIN pg_class pgc ON pgc.oid = a.attrelid WHERE pgc.relname = ? AND \'\' <> ? AND c.contype = \'p\'';
                case 'sqlsrv':
                    return 'SELECT c.NAME as "COLUMN_NAME" FROM sys.key_constraints kc inner join sys.objects t on t.object_id = kc.parent_object_id INNER JOIN sys.index_columns ic ON kc.parent_object_id = ic.object_id and kc.unique_index_id = ic.index_id INNER JOIN sys.columns c ON ic.object_id = c.object_id AND ic.column_id = c.column_id WHERE kc.type = \'PK\' and t.object_id = OBJECT_ID(?) and \'\' <> ?';
                case 'sqlite':
                    return 'SELECT "name" as "COLUMN_NAME" FROM pragma_table_info(?) WHERE "pk"=1 AND \'\' <> ?';
            }
        }

        private function getTableForeignKeysSQL(): string
        {
            switch ($this->driver) {
                case 'mysql':
                    return 'SELECT "COLUMN_NAME", "REFERENCED_TABLE_NAME" FROM "INFORMATION_SCHEMA"."KEY_COLUMN_USAGE" WHERE "REFERENCED_TABLE_NAME" IS NOT NULL AND "TABLE_NAME" = ? AND "TABLE_SCHEMA" = ?';
                case 'pgsql':
                    return 'SELECT a.attname AS "COLUMN_NAME", c.confrelid::regclass::text AS "REFERENCED_TABLE_NAME" FROM pg_attribute a JOIN pg_constraint c ON (c.conrelid, c.conkey[1]) = (a.attrelid, a.attnum) JOIN pg_class pgc ON pgc.oid = a.attrelid WHERE pgc.relname = ? AND \'\' <> ? AND c.contype  = \'f\'';
                case 'sqlsrv':
                    return 'SELECT COL_NAME(fc.parent_object_id, fc.parent_column_id) AS "COLUMN_NAME", OBJECT_NAME (f.referenced_object_id) AS "REFERENCED_TABLE_NAME" FROM sys.foreign_keys AS f INNER JOIN sys.foreign_key_columns AS fc ON f.OBJECT_ID = fc.constraint_object_id WHERE f.parent_object_id = OBJECT_ID(?) and \'\' <> ?';
                case 'sqlite':
                    return 'SELECT "from" AS "COLUMN_NAME", "table" AS "REFERENCED_TABLE_NAME" FROM pragma_foreign_key_list(?) WHERE \'\' <> ?';
            }
        }

        public function getDatabaseName(): string
        {
            return $this->database;
        }

        public function getTables(): array
        {
            $sql = $this->getTablesSQL();
            $results = $this->query($sql, [$this->database]);
            $tables = $this->tables;
            $results = array_filter($results, function ($v) use ($tables) {
                return !$tables || in_array($v['TABLE_NAME'], $tables);
            });
            foreach ($results as &$result) {
                $map = [];
                switch ($this->driver) {
                    case 'mysql':
                        $map = ['BASE TABLE' => 'table', 'VIEW' => 'view'];
                        break;
                    case 'pgsql':
                        $map = ['r' => 'table', 'v' => 'view'];
                        break;
                    case 'sqlsrv':
                        $map = ['U' => 'table', 'V' => 'view'];
                        break;
                    case 'sqlite':
                        $map = ['table' => 'table', 'view' => 'view'];
                        break;
                }
                $result['TABLE_TYPE'] = $map[trim($result['TABLE_TYPE'])];
            }
            return $results;
        }

        public function getTableColumns(string $tableName, string $type): array
        {
            $sql = $this->getTableColumnsSQL();
            $results = $this->query($sql, [$tableName, $this->database]);
            if ($type == 'view') {
                foreach ($results as &$result) {
                    $result['IS_NULLABLE'] = false;
                }
            }
            if ($this->driver == 'mysql') {
                foreach ($results as &$result) {
                    // mysql does not properly reflect display width of types
                    preg_match('|([a-z]+)(\(([0-9]+)(,([0-9]+))?\))?|', $result['DATA_TYPE'], $matches);
                    $result['DATA_TYPE'] = $matches[1];
                    if (!$result['CHARACTER_MAXIMUM_LENGTH']) {
                        if (isset($matches[3])) {
                            $result['NUMERIC_PRECISION'] = $matches[3];
                        }
                        if (isset($matches[5])) {
                            $result['NUMERIC_SCALE'] = $matches[5];
                        }
                    }
                }
            }
            if ($this->driver == 'sqlite') {
                foreach ($results as &$result) {
                    // sqlite does not reflect types on view columns
                    preg_match('|([a-z]+)(\(([0-9]+)(,([0-9]+))?\))?|', $result['DATA_TYPE'], $matches);
                    if (isset($matches[1])) {
                        $result['DATA_TYPE'] = $matches[1];
                    } else {
                        $result['DATA_TYPE'] = 'text';
                    }
                    if (isset($matches[5])) {
                        $result['NUMERIC_PRECISION'] = $matches[3];
                        $result['NUMERIC_SCALE'] = $matches[5];
                    } else if (isset($matches[3])) {
                        $result['CHARACTER_MAXIMUM_LENGTH'] = $matches[3];
                    }
                }
            }
            return $results;
        }

        public function getTablePrimaryKeys(string $tableName): array
        {
            $sql = $this->getTablePrimaryKeysSQL();
            $results = $this->query($sql, [$tableName, $this->database]);
            $primaryKeys = [];
            foreach ($results as $result) {
                $primaryKeys[] = $result['COLUMN_NAME'];
            }
            return $primaryKeys;
        }

        public function getTableForeignKeys(string $tableName): array
        {
            $sql = $this->getTableForeignKeysSQL();
            $results = $this->query($sql, [$tableName, $this->database]);
            $foreignKeys = [];
            foreach ($results as $result) {
                $foreignKeys[$result['COLUMN_NAME']] = $result['REFERENCED_TABLE_NAME'];
            }
            return $foreignKeys;
        }

        public function toJdbcType(string $type, string $size): string
        {
            return $this->typeConverter->toJdbc($type, $size);
        }

        private function query(string $sql, array $parameters): array
        {
            $stmt = $this->pdo->prepare($sql);
            //echo "- $sql -- " . json_encode($parameters, JSON_UNESCAPED_UNICODE) . "\n";
            $stmt->execute($parameters);
            return $stmt->fetchAll();
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Database/LazyPdo.php
namespace Tqdev\PhpCrudApi\Database {

    class LazyPdo extends \PDO
    {
        private $dsn;
        private $user;
        private $password;
        private $options;
        private $commands;

        private $pdo = null;

        public function __construct(string $dsn, /*?string*/ $user = null, /*?string*/ $password = null, array $options = array())
        {
            $this->dsn = $dsn;
            $this->user = $user;
            $this->password = $password;
            $this->options = $options;
            $this->commands = array();
            // explicitly NOT calling super::__construct
        }

        public function addInitCommand(string $command)/*: void*/
        {
            $this->commands[] = $command;
        }

        private function pdo()
        {
            if (!$this->pdo) {
                $this->pdo = new \PDO($this->dsn, $this->user, $this->password, $this->options);
                foreach ($this->commands as $command) {
                    $this->pdo->query($command);
                }
            }
            return $this->pdo;
        }

        public function reconstruct(string $dsn, /*?string*/ $user = null, /*?string*/ $password = null, array $options = array()): bool
        {
            $this->dsn = $dsn;
            $this->user = $user;
            $this->password = $password;
            $this->options = $options;
            $this->commands = array();
            if ($this->pdo) {
                $this->pdo = null;
                return true;
            }
            return false;
        }

        public function inTransaction(): bool
        {
            // Do not call parent method if there is no pdo object
            return $this->pdo && parent::inTransaction();
        }

        public function setAttribute($attribute, $value): bool
        {
            if ($this->pdo) {
                return $this->pdo()->setAttribute($attribute, $value);
            }
            $this->options[$attribute] = $value;
            return true;
        }

        public function getAttribute($attribute): mixed
        {
            return $this->pdo()->getAttribute($attribute);
        }

        public function beginTransaction(): bool
        {
            return $this->pdo()->beginTransaction();
        }

        public function commit(): bool
        {
            return $this->pdo()->commit();
        }

        public function rollBack(): bool
        {
            return $this->pdo()->rollBack();
        }

        public function errorCode(): mixed
        {
            return $this->pdo()->errorCode();
        }

        public function errorInfo(): array
        {
            return $this->pdo()->errorInfo();
        }

        public function exec($query): int
        {
            return $this->pdo()->exec($query);
        }

        public function prepare($statement, $options = array())
        {
            return $this->pdo()->prepare($statement, $options);
        }

        public function quote($string, $parameter_type = null): string
        {
            return $this->pdo()->quote($string, $parameter_type);
        }

        public function lastInsertId(/* ?string */$name = null): string
        {
            return $this->pdo()->lastInsertId($name);
        }

        public function query($query, /* ?int */$fetchMode = null, ...$fetchModeArgs): \PDOStatement
        {
            return call_user_func_array(array($this->pdo(), 'query'), func_get_args());
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Database/TypeConverter.php
namespace Tqdev\PhpCrudApi\Database {

    class TypeConverter
    {
        private $driver;

        public function __construct(string $driver)
        {
            $this->driver = $driver;
        }

        private $fromJdbc = [
            'mysql' => [
                'clob' => 'longtext',
                'boolean' => 'tinyint(1)',
                'blob' => 'longblob',
                'timestamp' => 'datetime',
            ],
            'pgsql' => [
                'clob' => 'text',
                'blob' => 'bytea',
                'float' => 'real',
                'double' => 'double precision',
                'varbinary' => 'bytea',
            ],
            'sqlsrv' => [
                'boolean' => 'bit',
                'varchar' => 'nvarchar',
                'clob' => 'ntext',
                'blob' => 'image',
                'time' => 'time(0)',
                'timestamp' => 'datetime2(0)',
                'double' => 'float',
                'float' => 'real',
            ],
        ];

        private $toJdbc = [
            'simplified' => [
                'char' => 'varchar',
                'longvarchar' => 'clob',
                'nchar' => 'varchar',
                'nvarchar' => 'varchar',
                'longnvarchar' => 'clob',
                'binary' => 'varbinary',
                'longvarbinary' => 'blob',
                'tinyint' => 'integer',
                'smallint' => 'integer',
                'real' => 'float',
                'numeric' => 'decimal',
                'nclob' => 'clob',
                'time_with_timezone' => 'time',
                'timestamp_with_timezone' => 'timestamp',
            ],
            'mysql' => [
                'tinyint(1)' => 'boolean',
                'bit(1)' => 'boolean',
                'tinyblob' => 'blob',
                'mediumblob' => 'blob',
                'longblob' => 'blob',
                'tinytext' => 'clob',
                'mediumtext' => 'clob',
                'longtext' => 'clob',
                'text' => 'clob',
                'mediumint' => 'integer',
                'int' => 'integer',
                'polygon' => 'geometry',
                'point' => 'geometry',
                'datetime' => 'timestamp',
                'year' => 'integer',
                'enum' => 'varchar',
                'set' => 'varchar',
                'json' => 'clob',
            ],
            'pgsql' => [
                'bigserial' => 'bigint',
                'bit varying' => 'bit',
                'box' => 'geometry',
                'bytea' => 'blob',
                'bpchar' => 'char',
                'character varying' => 'varchar',
                'character' => 'char',
                'cidr' => 'varchar',
                'circle' => 'geometry',
                'double precision' => 'double',
                'inet' => 'integer',
                //'interval [ fields ]'
                'json' => 'clob',
                'jsonb' => 'clob',
                'line' => 'geometry',
                'lseg' => 'geometry',
                'macaddr' => 'varchar',
                'money' => 'decimal',
                'path' => 'geometry',
                'point' => 'geometry',
                'polygon' => 'geometry',
                'real' => 'float',
                'serial' => 'integer',
                'text' => 'clob',
                'time without time zone' => 'time',
                'time with time zone' => 'time_with_timezone',
                'timestamp without time zone' => 'timestamp',
                'timestamp with time zone' => 'timestamp_with_timezone',
                //'tsquery'=
                //'tsvector'
                //'txid_snapshot'
                'uuid' => 'char',
                'xml' => 'clob',
            ],
            // source: https://docs.microsoft.com/en-us/sql/connect/jdbc/using-basic-data-types?view=sql-server-2017
            'sqlsrv' => [
                'varbinary()' => 'blob',
                'bit' => 'boolean',
                'datetime' => 'timestamp',
                'datetime2' => 'timestamp',
                'float' => 'double',
                'image' => 'blob',
                'int' => 'integer',
                'money' => 'decimal',
                'ntext' => 'clob',
                'smalldatetime' => 'timestamp',
                'smallmoney' => 'decimal',
                'text' => 'clob',
                'timestamp' => 'binary',
                'udt' => 'varbinary',
                'uniqueidentifier' => 'char',
                'xml' => 'clob',
            ],
            'sqlite' => [
                'tinytext' => 'clob',
                'text' => 'clob',
                'mediumtext' => 'clob',
                'longtext' => 'clob',
                'mediumint' => 'integer',
                'int' => 'integer',
                'bigint' => 'bigint',
                'int2' => 'smallint',
                'int4' => 'integer',
                'int8' => 'bigint',
                'double precision' => 'double',
                'datetime' => 'timestamp'
            ],
        ];

        // source: https://docs.oracle.com/javase/9/docs/api/java/sql/Types.html
        private $valid = [
            //'array' => true,
            'bigint' => true,
            'binary' => true,
            'bit' => true,
            'blob' => true,
            'boolean' => true,
            'char' => true,
            'clob' => true,
            //'datalink' => true,
            'date' => true,
            'decimal' => true,
            //'distinct' => true,
            'double' => true,
            'float' => true,
            'integer' => true,
            //'java_object' => true,
            'longnvarchar' => true,
            'longvarbinary' => true,
            'longvarchar' => true,
            'nchar' => true,
            'nclob' => true,
            //'null' => true,
            'numeric' => true,
            'nvarchar' => true,
            //'other' => true,
            'real' => true,
            //'ref' => true,
            //'ref_cursor' => true,
            //'rowid' => true,
            'smallint' => true,
            //'sqlxml' => true,
            //'struct' => true,
            'time' => true,
            'time_with_timezone' => true,
            'timestamp' => true,
            'timestamp_with_timezone' => true,
            'tinyint' => true,
            'varbinary' => true,
            'varchar' => true,
            // extra:
            'geometry' => true,
        ];

        public function toJdbc(string $type, string $size): string
        {
            $jdbcType = strtolower($type);
            if (isset($this->toJdbc[$this->driver]["$jdbcType($size)"])) {
                $jdbcType = $this->toJdbc[$this->driver]["$jdbcType($size)"];
            }
            if (isset($this->toJdbc[$this->driver][$jdbcType])) {
                $jdbcType = $this->toJdbc[$this->driver][$jdbcType];
            }
            if (isset($this->toJdbc['simplified'][$jdbcType])) {
                $jdbcType = $this->toJdbc['simplified'][$jdbcType];
            }
            if (!isset($this->valid[$jdbcType])) {
                //throw new \Exception("Unsupported type '$jdbcType' for driver '$this->driver'");
                $jdbcType = 'clob';
            }
            return $jdbcType;
        }

        public function fromJdbc(string $type): string
        {
            $jdbcType = strtolower($type);
            if (isset($this->fromJdbc[$this->driver][$jdbcType])) {
                $jdbcType = $this->fromJdbc[$this->driver][$jdbcType];
            }
            return $jdbcType;
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/GeoJson/Feature.php
namespace Tqdev\PhpCrudApi\GeoJson {

    class Feature implements \JsonSerializable
    {
        private $id;
        private $properties;
        private $geometry;

        public function __construct($id, array $properties, /*?Geometry*/ $geometry)
        {
            $this->id = $id;
            $this->properties = $properties;
            $this->geometry = $geometry;
        }

        public function serialize()
        {
            return [
                'type' => 'Feature',
                'id' => $this->id,
                'properties' => $this->properties,
                'geometry' => $this->geometry,
            ];
        }

        public function jsonSerialize()
        {
            return $this->serialize();
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/GeoJson/FeatureCollection.php
namespace Tqdev\PhpCrudApi\GeoJson {

    class FeatureCollection implements \JsonSerializable
    {
        private $features;

        private $results;

        public function __construct(array $features, int $results)
        {
            $this->features = $features;
            $this->results = $results;
        }

        public function serialize()
        {
            return [
                'type' => 'FeatureCollection',
                'features' => $this->features,
                'results' => $this->results,
            ];
        }

        public function jsonSerialize()
        {
            return array_filter($this->serialize(), function ($v) {
                return $v !== -1;
            });
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/GeoJson/GeoJsonService.php
namespace Tqdev\PhpCrudApi\GeoJson {

    use Tqdev\PhpCrudApi\Column\ReflectionService;
    use Tqdev\PhpCrudApi\GeoJson\FeatureCollection;
    use Tqdev\PhpCrudApi\Record\RecordService;

    class GeoJsonService
    {
        private $reflection;
        private $records;

        public function __construct(ReflectionService $reflection, RecordService $records)
        {
            $this->reflection = $reflection;
            $this->records = $records;
        }

        public function hasTable(string $table): bool
        {
            return $this->reflection->hasTable($table);
        }

        public function getType(string $table): string
        {
            return $this->reflection->getType($table);
        }

        private function getGeometryColumnName(string $tableName, array &$params): string
        {
            $geometryParam = isset($params['geometry']) ? $params['geometry'][0] : '';
            $table = $this->reflection->getTable($tableName);
            $geometryColumnName = '';
            foreach ($table->getColumnNames() as $columnName) {
                if ($geometryParam && $geometryParam != $columnName) {
                    continue;
                }
                $column = $table->getColumn($columnName);
                if ($column->isGeometry()) {
                    $geometryColumnName = $columnName;
                    break;
                }
            }
            if ($geometryColumnName) {
                $params['mandatory'][] = $tableName . "." . $geometryColumnName;
            }
            return $geometryColumnName;
        }

        private function setBoudingBoxFilter(string $geometryColumnName, array &$params)
        {
            $boundingBox = isset($params['bbox']) ? $params['bbox'][0] : '';
            if ($boundingBox) {
                $c = explode(',', $boundingBox);
                if (!isset($params['filter'])) {
                    $params['filter'] = array();
                }
                $params['filter'][] = "$geometryColumnName,sin,POLYGON(($c[0] $c[1],$c[2] $c[1],$c[2] $c[3],$c[0] $c[3],$c[0] $c[1]))";
            }
            $tile = isset($params['tile']) ? $params['tile'][0] : '';
            if ($tile) {
                $zxy = explode(',', $tile);
                if (count($zxy) == 3) {
                    list($z, $x, $y) = $zxy;
                    $c = array();
                    $c = array_merge($c, $this->convertTileToLatLonOfUpperLeftCorner($z, $x, $y));
                    $c = array_merge($c, $this->convertTileToLatLonOfUpperLeftCorner($z, $x + 1, $y + 1));
                    $params['filter'][] = "$geometryColumnName,sin,POLYGON(($c[0] $c[1],$c[2] $c[1],$c[2] $c[3],$c[0] $c[3],$c[0] $c[1]))";
                }
            }
        }

        private function convertTileToLatLonOfUpperLeftCorner($z, $x, $y): array
        {
            $n = pow(2, $z);
            $lon = $x / $n * 360.0 - 180.0;
            $lat = rad2deg(atan(sinh(pi() * (1 - 2 * $y / $n))));
            return [$lon, $lat];
        }

        private function convertRecordToFeature(/*object*/$record, string $primaryKeyColumnName, string $geometryColumnName)
        {
            $id = null;
            if ($primaryKeyColumnName) {
                $id = $record[$primaryKeyColumnName];
            }
            $geometry = null;
            if (isset($record[$geometryColumnName])) {
                $geometry = Geometry::fromWkt($record[$geometryColumnName]);
            }
            $properties = array_diff_key($record, [$primaryKeyColumnName => true, $geometryColumnName => true]);
            return new Feature($id, $properties, $geometry);
        }

        private function getPrimaryKeyColumnName(string $tableName, array &$params): string
        {
            $primaryKeyColumn = $this->reflection->getTable($tableName)->getPk();
            if (!$primaryKeyColumn) {
                return '';
            }
            $primaryKeyColumnName = $primaryKeyColumn->getName();
            $params['mandatory'][] = $tableName . "." . $primaryKeyColumnName;
            return $primaryKeyColumnName;
        }

        public function _list(string $tableName, array $params): FeatureCollection
        {
            $geometryColumnName = $this->getGeometryColumnName($tableName, $params);
            $this->setBoudingBoxFilter($geometryColumnName, $params);
            $primaryKeyColumnName = $this->getPrimaryKeyColumnName($tableName, $params);
            $records = $this->records->_list($tableName, $params);
            $features = array();
            foreach ($records->getRecords() as $record) {
                $features[] = $this->convertRecordToFeature($record, $primaryKeyColumnName, $geometryColumnName);
            }
            return new FeatureCollection($features, $records->getResults());
        }

        public function read(string $tableName, string $id, array $params): Feature
        {
            $geometryColumnName = $this->getGeometryColumnName($tableName, $params);
            $primaryKeyColumnName = $this->getPrimaryKeyColumnName($tableName, $params);
            $record = $this->records->read($tableName, $id, $params);
            return $this->convertRecordToFeature($record, $primaryKeyColumnName, $geometryColumnName);
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/GeoJson/Geometry.php
namespace Tqdev\PhpCrudApi\GeoJson {

    class Geometry implements \JsonSerializable
    {
        private $type;
        private $geometry;

        public static $types = [
            "Point",
            "MultiPoint",
            "LineString",
            "MultiLineString",
            "Polygon",
            "MultiPolygon",
            //"GeometryCollection",
        ];

        public function __construct(string $type, array $coordinates)
        {
            $this->type = $type;
            $this->coordinates = $coordinates;
        }

        public static function fromWkt(string $wkt): Geometry
        {
            $bracket = strpos($wkt, '(');
            $type = strtoupper(trim(substr($wkt, 0, $bracket)));
            $supported = false;
            foreach (Geometry::$types as $typeName) {
                if (strtoupper($typeName) == $type) {
                    $type = $typeName;
                    $supported = true;
                }
            }
            if (!$supported) {
                throw new \Exception('Geometry type not supported: ' . $type);
            }
            $coordinates = substr($wkt, $bracket);
            if (substr($type, -5) != 'Point' || ($type == 'MultiPoint' && $coordinates[1] != '(')) {
                $coordinates = preg_replace('|([0-9\-\.]+ )+([0-9\-\.]+)|', '[\1\2]', $coordinates);
            }
            $coordinates = str_replace(['(', ')', ', ', ' '], ['[', ']', ',', ','], $coordinates);
            $coordinates = json_decode($coordinates);
            if (!$coordinates) {
                throw new \Exception('Could not decode WKT: ' . $wkt);
            }
            return new Geometry($type, $coordinates);
        }

        public function serialize()
        {
            return [
                'type' => $this->type,
                'coordinates' => $this->coordinates,
            ];
        }

        public function jsonSerialize()
        {
            return $this->serialize();
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Middleware/Base/Middleware.php
namespace Tqdev\PhpCrudApi\Middleware\Base {

    use Psr\Http\Server\MiddlewareInterface;
    use Tqdev\PhpCrudApi\Controller\Responder;
    use Tqdev\PhpCrudApi\Middleware\Router\Router;

    abstract class Middleware implements MiddlewareInterface
    {
        protected $next;
        protected $responder;
        private $properties;

        public function __construct(Router $router, Responder $responder, array $properties)
        {
            $router->load($this);
            $this->responder = $responder;
            $this->properties = $properties;
        }

        protected function getArrayProperty(string $key, string $default): array
        {
            return array_filter(array_map('trim', explode(',', $this->getProperty($key, $default))));
        }

        protected function getMapProperty(string $key, string $default): array
        {
            $pairs = $this->getArrayProperty($key, $default);
            $result = array();
            foreach ($pairs as $pair) {
                if (strpos($pair, ':')) {
                    list($k, $v) = explode(':', $pair, 2);
                    $result[trim($k)] = trim($v);
                } else {
                    $result[] = trim($pair);
                }
            }
            return $result;
        }

        protected function getProperty(string $key, $default)
        {
            return isset($this->properties[$key]) ? $this->properties[$key] : $default;
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Middleware/Communication/VariableStore.php
namespace Tqdev\PhpCrudApi\Middleware\Communication {

    class VariableStore
    {
        public static $values = array();

        public static function get(string $key)
        {
            if (isset(self::$values[$key])) {
                return self::$values[$key];
            }
            return null;
        }

        public static function set(string $key, /* object */ $value)
        {
            self::$values[$key] = $value;
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Middleware/Router/Router.php
namespace Tqdev\PhpCrudApi\Middleware\Router {

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Psr\Http\Server\RequestHandlerInterface;
    use Tqdev\PhpCrudApi\Middleware\Base\Middleware;

    interface Router extends RequestHandlerInterface
    {
        public function register(string $method, string $path, array $handler);

        public function load(Middleware $middleware);

        public function route(ServerRequestInterface $request): ResponseInterface;
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Middleware/Router/SimpleRouter.php
namespace Tqdev\PhpCrudApi\Middleware\Router {

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Tqdev\PhpCrudApi\Cache\Cache;
    use Tqdev\PhpCrudApi\Controller\Responder;
    use Tqdev\PhpCrudApi\Middleware\Base\Middleware;
    use Tqdev\PhpCrudApi\Record\ErrorCode;
    use Tqdev\PhpCrudApi\Record\PathTree;
    use Tqdev\PhpCrudApi\RequestUtils;
    use Tqdev\PhpCrudApi\ResponseUtils;

    class SimpleRouter implements Router
    {
        private $basePath;
        private $responder;
        private $cache;
        private $ttl;
        private $registration;
        private $routes;
        private $routeHandlers;
        private $middlewares;

        public function __construct(string $basePath, Responder $responder, Cache $cache, int $ttl)
        {
            $this->basePath = rtrim($this->detectBasePath($basePath), '/');
            $this->responder = $responder;
            $this->cache = $cache;
            $this->ttl = $ttl;
            $this->registration = true;
            $this->routes = $this->loadPathTree();
            $this->routeHandlers = [];
            $this->middlewares = array();
        }

        private function detectBasePath(string $basePath): string
        {
            if ($basePath) {
                return $basePath;
            }
            if (isset($_SERVER['REQUEST_URI'])) {
                $fullPath = urldecode(explode('?', $_SERVER['REQUEST_URI'])[0]);
                if (isset($_SERVER['PATH_INFO'])) {
                    $path = $_SERVER['PATH_INFO'];
                    if (substr($fullPath, -1 * strlen($path)) == $path) {
                        return substr($fullPath, 0, -1 * strlen($path));
                    }
                }
                if ('/' . basename(__FILE__) == $fullPath) {
                    return $fullPath;
                }
            }
            return '/';
        }

        private function loadPathTree(): PathTree
        {
            $data = $this->cache->get('PathTree');
            if ($data != '') {
                $tree = PathTree::fromJson(json_decode(gzuncompress($data)));
                $this->registration = false;
            } else {
                $tree = new PathTree();
            }
            return $tree;
        }

        public function register(string $method, string $path, array $handler)
        {
            $routeNumber = count($this->routeHandlers);
            $this->routeHandlers[$routeNumber] = $handler;
            if ($this->registration) {
                $path = trim($path, '/');
                $parts = array();
                if ($path) {
                    $parts = explode('/', $path);
                }
                array_unshift($parts, $method);
                $this->routes->put($parts, $routeNumber);
            }
        }

        public function load(Middleware $middleware) /*: void*/
        {
            array_push($this->middlewares, $middleware);
        }

        public function route(ServerRequestInterface $request): ResponseInterface
        {
            if ($this->registration) {
                $data = gzcompress(json_encode($this->routes, JSON_UNESCAPED_UNICODE));
                $this->cache->set('PathTree', $data, $this->ttl);
            }

            return $this->handle($request);
        }

        private function getRouteNumbers(ServerRequestInterface $request): array
        {
            $method = strtoupper($request->getMethod());
            $path = array();
            $segment = $method;
            for ($i = 1; strlen($segment) > 0; $i++) {
                array_push($path, $segment);
                $segment = RequestUtils::getPathSegment($request, $i);
            }
            return $this->routes->match($path);
        }

        private function removeBasePath(ServerRequestInterface $request): ServerRequestInterface
        {
            $path = $request->getUri()->getPath();
            if (substr($path, 0, strlen($this->basePath)) == $this->basePath) {
                $path = substr($path, strlen($this->basePath));
                $request = $request->withUri($request->getUri()->withPath($path));
            }
            return $request;
        }

        public function getBasePath(): string
        {
            return $this->basePath;
        }

        public function handle(ServerRequestInterface $request): ResponseInterface
        {
            $request = $this->removeBasePath($request);

            if (count($this->middlewares)) {
                $handler = array_pop($this->middlewares);
                return $handler->process($request, $this);
            }

            $routeNumbers = $this->getRouteNumbers($request);
            if (count($routeNumbers) == 0) {
                return $this->responder->error(ErrorCode::ROUTE_NOT_FOUND, $request->getUri()->getPath());
            }
            try {
                $response = call_user_func($this->routeHandlers[$routeNumbers[0]], $request);
            } catch (\Throwable $exception) {
                $response = $this->responder->exception($exception);
            }
            return $response;
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Middleware/AjaxOnlyMiddleware.php
namespace Tqdev\PhpCrudApi\Middleware {

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Psr\Http\Server\RequestHandlerInterface;
    use Tqdev\PhpCrudApi\Controller\Responder;
    use Tqdev\PhpCrudApi\Middleware\Base\Middleware;
    use Tqdev\PhpCrudApi\Record\ErrorCode;
    use Tqdev\PhpCrudApi\RequestUtils;

    class AjaxOnlyMiddleware extends Middleware
    {
        public function process(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
        {
            $method = $request->getMethod();
            $excludeMethods = $this->getArrayProperty('excludeMethods', 'OPTIONS,GET');
            if (!in_array($method, $excludeMethods)) {
                $headerName = $this->getProperty('headerName', 'X-Requested-With');
                $headerValue = $this->getProperty('headerValue', 'XMLHttpRequest');
                if ($headerValue != RequestUtils::getHeader($request, $headerName)) {
                    return $this->responder->error(ErrorCode::ONLY_AJAX_REQUESTS_ALLOWED, $method);
                }
            }
            return $next->handle($request);
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Middleware/AuthorizationMiddleware.php
namespace Tqdev\PhpCrudApi\Middleware {

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Psr\Http\Server\RequestHandlerInterface;
    use Tqdev\PhpCrudApi\Column\ReflectionService;
    use Tqdev\PhpCrudApi\Controller\Responder;
    use Tqdev\PhpCrudApi\Middleware\Base\Middleware;
    use Tqdev\PhpCrudApi\Middleware\Communication\VariableStore;
    use Tqdev\PhpCrudApi\Middleware\Router\Router;
    use Tqdev\PhpCrudApi\Record\ErrorCode;
    use Tqdev\PhpCrudApi\Record\FilterInfo;
    use Tqdev\PhpCrudApi\RequestUtils;

    class AuthorizationMiddleware extends Middleware
    {
        private $reflection;

        public function __construct(Router $router, Responder $responder, array $properties, ReflectionService $reflection)
        {
            parent::__construct($router, $responder, $properties);
            $this->reflection = $reflection;
        }

        private function handleColumns(string $operation, string $tableName) /*: void*/
        {
            $columnHandler = $this->getProperty('columnHandler', '');
            if ($columnHandler) {
                $table = $this->reflection->getTable($tableName);
                foreach ($table->getColumnNames() as $columnName) {
                    $allowed = call_user_func($columnHandler, $operation, $tableName, $columnName);
                    if (!$allowed) {
                        $table->removeColumn($columnName);
                    }
                }
            }
        }

        private function handleTable(string $operation, string $tableName) /*: void*/
        {
            if (!$this->reflection->hasTable($tableName)) {
                return;
            }
            $allowed = true;
            $tableHandler = $this->getProperty('tableHandler', '');
            if ($tableHandler) {
                $allowed = call_user_func($tableHandler, $operation, $tableName);
            }
            if (!$allowed) {
                $this->reflection->removeTable($tableName);
            } else {
                $this->handleColumns($operation, $tableName);
            }
        }

        private function handleRecords(string $operation, string $tableName) /*: void*/
        {
            if (!$this->reflection->hasTable($tableName)) {
                return;
            }
            $recordHandler = $this->getProperty('recordHandler', '');
            if ($recordHandler) {
                $query = call_user_func($recordHandler, $operation, $tableName);
                $filters = new FilterInfo();
                $table = $this->reflection->getTable($tableName);
                $query = str_replace('][]=', ']=', str_replace('=', '[]=', $query));
                parse_str($query, $params);
                $condition = $filters->getCombinedConditions($table, $params);
                VariableStore::set("authorization.conditions.$tableName", $condition);
            }
        }

        private function pathHandler(string $path) /*: bool*/
        {
            $pathHandler = $this->getProperty('pathHandler', '');
            return $pathHandler ? call_user_func($pathHandler, $path) : true;
        }

        public function process(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
        {
            $path = RequestUtils::getPathSegment($request, 1);

            if (!$this->pathHandler($path)) {
                return $this->responder->error(ErrorCode::ROUTE_NOT_FOUND, $request->getUri()->getPath());
            }

            $operation = RequestUtils::getOperation($request);
            $tableNames = RequestUtils::getTableNames($request, $this->reflection);
            foreach ($tableNames as $tableName) {
                $this->handleTable($operation, $tableName);
                if ($path == 'records') {
                    $this->handleRecords($operation, $tableName);
                }
            }
            if ($path == 'openapi') {
                VariableStore::set('authorization.tableHandler', $this->getProperty('tableHandler', ''));
                VariableStore::set('authorization.columnHandler', $this->getProperty('columnHandler', ''));
            }
            return $next->handle($request);
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Middleware/BasicAuthMiddleware.php
namespace Tqdev\PhpCrudApi\Middleware {

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Psr\Http\Server\RequestHandlerInterface;
    use Tqdev\PhpCrudApi\Controller\Responder;
    use Tqdev\PhpCrudApi\Middleware\Base\Middleware;
    use Tqdev\PhpCrudApi\Record\ErrorCode;
    use Tqdev\PhpCrudApi\RequestUtils;

    class BasicAuthMiddleware extends Middleware
    {
        private function hasCorrectPassword(string $username, string $password, array &$passwords): bool
        {
            $hash = isset($passwords[$username]) ? $passwords[$username] : false;
            if ($hash && password_verify($password, $hash)) {
                if (password_needs_rehash($hash, PASSWORD_DEFAULT)) {
                    $passwords[$username] = password_hash($password, PASSWORD_DEFAULT);
                }
                return true;
            }
            return false;
        }

        private function getValidUsername(string $username, string $password, string $passwordFile): string
        {
            $passwords = $this->readPasswords($passwordFile);
            $valid = $this->hasCorrectPassword($username, $password, $passwords);
            $this->writePasswords($passwordFile, $passwords);
            return $valid ? $username : '';
        }

        private function readPasswords(string $passwordFile): array
        {
            $passwords = [];
            $passwordLines = file($passwordFile);
            foreach ($passwordLines as $passwordLine) {
                if (strpos($passwordLine, ':') !== false) {
                    list($username, $hash) = explode(':', trim($passwordLine), 2);
                    if (strlen($hash) > 0 && $hash[0] != '$') {
                        $hash = password_hash($hash, PASSWORD_DEFAULT);
                    }
                    $passwords[$username] = $hash;
                }
            }
            return $passwords;
        }

        private function writePasswords(string $passwordFile, array $passwords): bool
        {
            $success = false;
            $passwordFileContents = '';
            foreach ($passwords as $username => $hash) {
                $passwordFileContents .= "$username:$hash\n";
            }
            if (file_get_contents($passwordFile) != $passwordFileContents) {
                $success = file_put_contents($passwordFile, $passwordFileContents) !== false;
            }
            return $success;
        }

        private function getAuthorizationCredentials(ServerRequestInterface $request): string
        {
            if (isset($_SERVER['PHP_AUTH_USER'])) {
                return $_SERVER['PHP_AUTH_USER'] . ':' . $_SERVER['PHP_AUTH_PW'];
            }
            $header = RequestUtils::getHeader($request, 'Authorization');
            $parts = explode(' ', trim($header), 2);
            if (count($parts) != 2) {
                return '';
            }
            if ($parts[0] != 'Basic') {
                return '';
            }
            return base64_decode(strtr($parts[1], '-_', '+/'));
        }

        public function process(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
        {
            if (session_status() == PHP_SESSION_NONE) {
                if (!headers_sent()) {
                    $sessionName = $this->getProperty('sessionName', '');
                    if ($sessionName) {
                        session_name($sessionName);
                    }
                    session_start();
                }
            }
            $credentials = $this->getAuthorizationCredentials($request);
            if ($credentials) {
                list($username, $password) = array('', '');
                if (strpos($credentials, ':') !== false) {
                    list($username, $password) = explode(':', $credentials, 2);
                }
                $passwordFile = $this->getProperty('passwordFile', '.htpasswd');
                $validUser = $this->getValidUsername($username, $password, $passwordFile);
                $_SESSION['username'] = $validUser;
                if (!$validUser) {
                    return $this->responder->error(ErrorCode::AUTHENTICATION_FAILED, $username);
                }
                if (!headers_sent()) {
                    session_regenerate_id();
                }
            }
            if (!isset($_SESSION['username']) || !$_SESSION['username']) {
                $authenticationMode = $this->getProperty('mode', 'required');
                if ($authenticationMode == 'required') {
                    $response = $this->responder->error(ErrorCode::AUTHENTICATION_REQUIRED, '');
                    $realm = $this->getProperty('realm', 'Username and password required');
                    $response = $response->withHeader('WWW-Authenticate', "Basic realm=\"$realm\"");
                    return $response;
                }
            }
            return $next->handle($request);
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Middleware/CorsMiddleware.php
namespace Tqdev\PhpCrudApi\Middleware {

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Psr\Http\Server\RequestHandlerInterface;
    use Tqdev\PhpCrudApi\Controller\Responder;
    use Tqdev\PhpCrudApi\Middleware\Base\Middleware;
    use Tqdev\PhpCrudApi\Middleware\Router\Router;
    use Tqdev\PhpCrudApi\Record\ErrorCode;
    use Tqdev\PhpCrudApi\ResponseFactory;
    use Tqdev\PhpCrudApi\ResponseUtils;

    class CorsMiddleware extends Middleware
    {
        private $debug;

        public function __construct(Router $router, Responder $responder, array $properties, bool $debug)
        {
            parent::__construct($router, $responder, $properties);
            $this->debug = $debug;
        }

        private function isOriginAllowed(string $origin, string $allowedOrigins): bool
        {
            $found = false;
            foreach (explode(',', $allowedOrigins) as $allowedOrigin) {
                $hostname = preg_quote(strtolower(trim($allowedOrigin)),'/');
                $regex = '/^' . str_replace('\*', '.*', $hostname) . '$/';
                if (preg_match($regex, $origin)) {
                    $found = true;
                    break;
                }
            }
            return $found;
        }

        public function process(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
        {
            $method = $request->getMethod();
            $origin = count($request->getHeader('Origin')) ? $request->getHeader('Origin')[0] : '';
            $allowedOrigins = $this->getProperty('allowedOrigins', '*');
            if ($origin && !$this->isOriginAllowed($origin, $allowedOrigins)) {
                $response = $this->responder->error(ErrorCode::ORIGIN_FORBIDDEN, $origin);
            } elseif ($method == 'OPTIONS') {
                $response = ResponseFactory::fromStatus(ResponseFactory::OK);
                $allowHeaders = $this->getProperty('allowHeaders', 'Content-Type, X-XSRF-TOKEN, X-Authorization');
                if ($this->debug) {
                    $allowHeaders = implode(', ', array_filter([$allowHeaders, 'X-Exception-Name, X-Exception-Message, X-Exception-File']));
                }
                if ($allowHeaders) {
                    $response = $response->withHeader('Access-Control-Allow-Headers', $allowHeaders);
                }
                $allowMethods = $this->getProperty('allowMethods', 'OPTIONS, GET, PUT, POST, DELETE, PATCH');
                if ($allowMethods) {
                    $response = $response->withHeader('Access-Control-Allow-Methods', $allowMethods);
                }
                $allowCredentials = $this->getProperty('allowCredentials', 'true');
                if ($allowCredentials) {
                    $response = $response->withHeader('Access-Control-Allow-Credentials', $allowCredentials);
                }
                $maxAge = $this->getProperty('maxAge', '1728000');
                if ($maxAge) {
                    $response = $response->withHeader('Access-Control-Max-Age', $maxAge);
                }
                $exposeHeaders = $this->getProperty('exposeHeaders', '');
                if ($this->debug) {
                    $exposeHeaders = implode(', ', array_filter([$exposeHeaders, 'X-Exception-Name, X-Exception-Message, X-Exception-File']));
                }
                if ($exposeHeaders) {
                    $response = $response->withHeader('Access-Control-Expose-Headers', $exposeHeaders);
                }
            } else {
                $response = null;
                try {
                    $response = $next->handle($request);
                } catch (\Throwable $e) {
                    $response = $this->responder->error(ErrorCode::ERROR_NOT_FOUND, $e->getMessage());
                    if ($this->debug) {
                        $response = ResponseUtils::addExceptionHeaders($response, $e);
                    }
                }
            }
            if ($origin) {
                $allowCredentials = $this->getProperty('allowCredentials', 'true');
                if ($allowCredentials) {
                    $response = $response->withHeader('Access-Control-Allow-Credentials', $allowCredentials);
                }
                $response = $response->withHeader('Access-Control-Allow-Origin', $origin);
            }
            return $response;
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Middleware/CustomizationMiddleware.php
namespace Tqdev\PhpCrudApi\Middleware {

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Psr\Http\Server\RequestHandlerInterface;
    use Tqdev\PhpCrudApi\Column\ReflectionService;
    use Tqdev\PhpCrudApi\Controller\Responder;
    use Tqdev\PhpCrudApi\Middleware\Base\Middleware;
    use Tqdev\PhpCrudApi\Middleware\Router\Router;
    use Tqdev\PhpCrudApi\RequestUtils;

    class CustomizationMiddleware extends Middleware
    {
        private $reflection;

        public function __construct(Router $router, Responder $responder, array $properties, ReflectionService $reflection)
        {
            parent::__construct($router, $responder, $properties);
            $this->reflection = $reflection;
        }

        public function process(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
        {
            $operation = RequestUtils::getOperation($request);
            $tableName = RequestUtils::getPathSegment($request, 2);
            $beforeHandler = $this->getProperty('beforeHandler', '');
            $environment = (object) array();
            if ($beforeHandler !== '') {
                $result = call_user_func($beforeHandler, $operation, $tableName, $request, $environment);
                $request = $result ?: $request;
            }
            $response = $next->handle($request);
            $afterHandler = $this->getProperty('afterHandler', '');
            if ($afterHandler !== '') {
                $result = call_user_func($afterHandler, $operation, $tableName, $response, $environment);
                $response = $result ?: $response;
            }
            return $response;
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Middleware/DbAuthMiddleware.php
namespace Tqdev\PhpCrudApi\Middleware {

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Psr\Http\Server\RequestHandlerInterface;
    use Tqdev\PhpCrudApi\Column\ReflectionService;
    use Tqdev\PhpCrudApi\Controller\Responder;
    use Tqdev\PhpCrudApi\Database\GenericDB;
    use Tqdev\PhpCrudApi\Middleware\Base\Middleware;
    use Tqdev\PhpCrudApi\Middleware\Router\Router;
    use Tqdev\PhpCrudApi\Record\Condition\ColumnCondition;
    use Tqdev\PhpCrudApi\Record\ErrorCode;
    use Tqdev\PhpCrudApi\Record\OrderingInfo;
    use Tqdev\PhpCrudApi\RequestUtils;

    class DbAuthMiddleware extends Middleware
    {
        private $reflection;
        private $db;
        private $ordering;

        public function __construct(Router $router, Responder $responder, array $properties, ReflectionService $reflection, GenericDB $db)
        {
            parent::__construct($router, $responder, $properties);
            $this->reflection = $reflection;
            $this->db = $db;
            $this->ordering = new OrderingInfo();
        }

        public function process(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
        {
            if (session_status() == PHP_SESSION_NONE) {
                if (!headers_sent()) {
                    $sessionName = $this->getProperty('sessionName', '');
                    if ($sessionName) {
                        session_name($sessionName);
                    }
                    session_start();
                }
            }
            $path = RequestUtils::getPathSegment($request, 1);
            $method = $request->getMethod();
            if ($method == 'POST' && in_array($path, ['login', 'register', 'password'])) {
                $body = $request->getParsedBody();
                $username = isset($body->username) ? $body->username : '';
                $password = isset($body->password) ? $body->password : '';
                $newPassword = isset($body->newPassword) ? $body->newPassword : '';
                $tableName = $this->getProperty('usersTable', 'users');
                $table = $this->reflection->getTable($tableName);
                $usernameColumnName = $this->getProperty('usernameColumn', 'username');
                $usernameColumn = $table->getColumn($usernameColumnName);
                $passwordColumnName = $this->getProperty('passwordColumn', 'password');
                $passwordLength = $this->getProperty('passwordLength', '12');
                $pkName = $table->getPk()->getName();
                $registerUser = $this->getProperty('registerUser', '');
                $condition = new ColumnCondition($usernameColumn, 'eq', $username);
                $returnedColumns = $this->getProperty('returnedColumns', '');
                if (!$returnedColumns) {
                    $columnNames = $table->getColumnNames();
                } else {
                    $columnNames = array_map('trim', explode(',', $returnedColumns));
                    $columnNames[] = $passwordColumnName;
                    $columnNames = array_values(array_unique($columnNames));
                }
                $columnOrdering = $this->ordering->getDefaultColumnOrdering($table);
                if ($path == 'register') {
                    if (!$registerUser) {
                        return $this->responder->error(ErrorCode::AUTHENTICATION_FAILED, $username);
                    }
                    if (strlen($password) < $passwordLength) {
                        return $this->responder->error(ErrorCode::PASSWORD_TOO_SHORT, $passwordLength);
                    }
                    $users = $this->db->selectAll($table, $columnNames, $condition, $columnOrdering, 0, 1);
                    if (!empty($users)) {
                        return $this->responder->error(ErrorCode::USER_ALREADY_EXIST, $username);
                    }
                    $data = json_decode($registerUser, true);
                    $data = is_array($data) ? $data : [];
                    $data[$usernameColumnName] = $username;
                    $data[$passwordColumnName] = password_hash($password, PASSWORD_DEFAULT);
                    $this->db->createSingle($table, $data);
                    $users = $this->db->selectAll($table, $columnNames, $condition, $columnOrdering, 0, 1);
                    foreach ($users as $user) {
                        unset($user[$passwordColumnName]);
                        return $this->responder->success($user);
                    }
                    return $this->responder->error(ErrorCode::AUTHENTICATION_FAILED, $username);
                }
                if ($path == 'login') {
                    $users = $this->db->selectAll($table, $columnNames, $condition, $columnOrdering, 0, 1);
                    foreach ($users as $user) {
                        if (password_verify($password, $user[$passwordColumnName]) == 1) {
                            if (!headers_sent()) {
                                session_regenerate_id(true);
                            }
                            unset($user[$passwordColumnName]);
                            $_SESSION['user'] = $user;
                            return $this->responder->success($user);
                        }
                    }
                    return $this->responder->error(ErrorCode::AUTHENTICATION_FAILED, $username);
                }
                if ($path == 'password') {
                    if ($username != ($_SESSION['user'][$usernameColumnName] ?? '')) {
                        return $this->responder->error(ErrorCode::AUTHENTICATION_FAILED, $username);
                    }
                    if (strlen($newPassword) < $passwordLength) {
                        return $this->responder->error(ErrorCode::PASSWORD_TOO_SHORT, $passwordLength);
                    }
                    $users = $this->db->selectAll($table, $columnNames, $condition, $columnOrdering, 0, 1);
                    foreach ($users as $user) {
                        if (password_verify($password, $user[$passwordColumnName]) == 1) {
                            if (!headers_sent()) {
                                session_regenerate_id(true);
                            }
                            $data = [$passwordColumnName => password_hash($newPassword, PASSWORD_DEFAULT)];
                            $this->db->updateSingle($table, $data, $user[$pkName]);
                            unset($user[$passwordColumnName]);
                            return $this->responder->success($user);
                        }
                    }
                    return $this->responder->error(ErrorCode::AUTHENTICATION_FAILED, $username);
                }
            }
            if ($method == 'POST' && $path == 'logout') {
                if (isset($_SESSION['user'])) {
                    $user = $_SESSION['user'];
                    unset($_SESSION['user']);
                    if (session_status() != PHP_SESSION_NONE) {
                        session_destroy();
                    }
                    return $this->responder->success($user);
                }
                return $this->responder->error(ErrorCode::AUTHENTICATION_REQUIRED, '');
            }
            if ($method == 'GET' && $path == 'me') {
                if (isset($_SESSION['user'])) {
                    return $this->responder->success($_SESSION['user']);
                }
                return $this->responder->error(ErrorCode::AUTHENTICATION_REQUIRED, '');
            }
            if (!isset($_SESSION['user']) || !$_SESSION['user']) {
                $authenticationMode = $this->getProperty('mode', 'required');
                if ($authenticationMode == 'required') {
                    return $this->responder->error(ErrorCode::AUTHENTICATION_REQUIRED, '');
                }
            }
            return $next->handle($request);
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Middleware/FirewallMiddleware.php
namespace Tqdev\PhpCrudApi\Middleware {

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Psr\Http\Server\RequestHandlerInterface;
    use Tqdev\PhpCrudApi\Controller\Responder;
    use Tqdev\PhpCrudApi\Middleware\Base\Middleware;
    use Tqdev\PhpCrudApi\Record\ErrorCode;

    class FirewallMiddleware extends Middleware
    {
        private function ipMatch(string $ip, string $cidr): bool
        {
            if (strpos($cidr, '/') !== false) {
                list($subnet, $mask) = explode('/', trim($cidr));
                if ((ip2long($ip) & ~((1 << (32 - $mask)) - 1)) == ip2long($subnet)) {
                    return true;
                }
            } else {
                if (ip2long($ip) == ip2long($cidr)) {
                    return true;
                }
            }
            return false;
        }

        private function isIpAllowed(string $ipAddress, string $allowedIpAddresses): bool
        {
            foreach (explode(',', $allowedIpAddresses) as $allowedIp) {
                if ($this->ipMatch($ipAddress, $allowedIp)) {
                    return true;
                }
            }
            return false;
        }

        public function process(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
        {
            $reverseProxy = $this->getProperty('reverseProxy', '');
            if ($reverseProxy) {
                $ipAddress = array_pop(explode(',', $request->getHeader('X-Forwarded-For')));
            } elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $ipAddress = $_SERVER['REMOTE_ADDR'];
            } else {
                $ipAddress = '127.0.0.1';
            }
            $allowedIpAddresses = $this->getProperty('allowedIpAddresses', '');
            if (!$this->isIpAllowed($ipAddress, $allowedIpAddresses)) {
                $response = $this->responder->error(ErrorCode::TEMPORARY_OR_PERMANENTLY_BLOCKED, '');
            } else {
                $response = $next->handle($request);
            }
            return $response;
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Middleware/IpAddressMiddleware.php
namespace Tqdev\PhpCrudApi\Middleware {

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Psr\Http\Server\RequestHandlerInterface;
    use Tqdev\PhpCrudApi\Column\Reflection\ReflectedTable;
    use Tqdev\PhpCrudApi\Column\ReflectionService;
    use Tqdev\PhpCrudApi\Controller\Responder;
    use Tqdev\PhpCrudApi\Middleware\Base\Middleware;
    use Tqdev\PhpCrudApi\Middleware\Router\Router;
    use Tqdev\PhpCrudApi\RequestUtils;

    class IpAddressMiddleware extends Middleware
    {
        private $reflection;

        public function __construct(Router $router, Responder $responder, array $properties, ReflectionService $reflection)
        {
            parent::__construct($router, $responder, $properties);
            $this->reflection = $reflection;
        }

        private function callHandler($record, string $operation, ReflectedTable $table) /*: object */
        {
            $context = (array) $record;
            $columnNames = $this->getProperty('columns', '');
            if ($columnNames) {
                foreach (explode(',', $columnNames) as $columnName) {
                    if ($table->hasColumn($columnName)) {
                        if ($operation == 'create') {
                            $context[$columnName] = $_SERVER['REMOTE_ADDR'];
                        } else {
                            unset($context[$columnName]);
                        }
                    }
                }
            }
            return (object) $context;
        }

        public function process(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
        {
            $operation = RequestUtils::getOperation($request);
            if (in_array($operation, ['create', 'update', 'increment'])) {
                $tableNames = $this->getProperty('tables', '');
                $tableName = RequestUtils::getPathSegment($request, 2);
                if (!$tableNames || in_array($tableName, explode(',', $tableNames))) {
                    if ($this->reflection->hasTable($tableName)) {
                        $record = $request->getParsedBody();
                        if ($record !== null) {
                            $table = $this->reflection->getTable($tableName);
                            if (is_array($record)) {
                                foreach ($record as &$r) {
                                    $r = $this->callHandler($r, $operation, $table);
                                }
                            } else {
                                $record = $this->callHandler($record, $operation, $table);
                            }
                            $request = $request->withParsedBody($record);
                        }
                    }
                }
            }
            return $next->handle($request);
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Middleware/JoinLimitsMiddleware.php
namespace Tqdev\PhpCrudApi\Middleware {

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Psr\Http\Server\RequestHandlerInterface;
    use Tqdev\PhpCrudApi\Column\ReflectionService;
    use Tqdev\PhpCrudApi\Controller\Responder;
    use Tqdev\PhpCrudApi\Middleware\Base\Middleware;
    use Tqdev\PhpCrudApi\Middleware\Communication\VariableStore;
    use Tqdev\PhpCrudApi\Middleware\Router\Router;
    use Tqdev\PhpCrudApi\RequestUtils;

    class JoinLimitsMiddleware extends Middleware
    {
        private $reflection;

        public function __construct(Router $router, Responder $responder, array $properties, ReflectionService $reflection)
        {
            parent::__construct($router, $responder, $properties);
            $this->reflection = $reflection;
        }

        public function process(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
        {
            $operation = RequestUtils::getOperation($request);
            $params = RequestUtils::getParams($request);
            if (in_array($operation, ['read', 'list']) && isset($params['join'])) {
                $maxDepth = (int) $this->getProperty('depth', '3');
                $maxTables = (int) $this->getProperty('tables', '10');
                $maxRecords = (int) $this->getProperty('records', '1000');
                $tableCount = 0;
                $joinPaths = array();
                for ($i = 0; $i < count($params['join']); $i++) {
                    $joinPath = array();
                    $tables = explode(',', $params['join'][$i]);
                    for ($depth = 0; $depth < min($maxDepth, count($tables)); $depth++) {
                        array_push($joinPath, $tables[$depth]);
                        $tableCount += 1;
                        if ($tableCount == $maxTables) {
                            break;
                        }
                    }
                    array_push($joinPaths, implode(',', $joinPath));
                    if ($tableCount == $maxTables) {
                        break;
                    }
                }
                $params['join'] = $joinPaths;
                $request = RequestUtils::setParams($request, $params);
                VariableStore::set("joinLimits.maxRecords", $maxRecords);
            }
            return $next->handle($request);
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Middleware/JsonMiddleware.php
namespace Tqdev\PhpCrudApi\Middleware {

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Psr\Http\Server\RequestHandlerInterface;
    use Tqdev\PhpCrudApi\Middleware\Base\Middleware;
    use Tqdev\PhpCrudApi\RequestUtils;
    use Tqdev\PhpCrudApi\ResponseFactory;

    class JsonMiddleware extends Middleware
    {
        private function convertJsonRequestValue($value) /*: object */
        {
            if (is_array($value) || is_object($value)) {
                $value = json_encode($value,JSON_UNESCAPED_UNICODE);
            }
            return $value;
        }
        
        private function convertJsonRequest($object, array $columnNames) /*: object */
        {
            if (is_array($object)) {
                foreach ($object as $i => $obj) {
                    foreach ($obj as $k => $v) {
                        if (in_array('all', $columnNames) || in_array($k, $columnNames)) {
                            $object[$i]->$k = $this->convertJsonRequestValue($v);
                        }
                    }
                }
            } else if (is_object($object)) {
                foreach ($object as $k => $v) {
                    if (in_array('all', $columnNames) || in_array($k, $columnNames)) {
                        $object->$k = $this->convertJsonRequestValue($v);
                    }
                }
            }
            return $object;
        }

        private function convertJsonResponseValue(string $value) /*: object */
        {
            if (strlen($value) > 0 && in_array($value[0],['[','{'])) {
                $parsed = json_decode($value);
                if (json_last_error() == JSON_ERROR_NONE) {
                    $value = $parsed;
                }
            }
            return $value;
        }

        private function convertJsonResponse($object, array $columnNames) /*: object */
        {
            if (is_array($object)) {
                foreach ($object as $k => $v) {
                    $object[$k] = $this->convertJsonResponse($v, $columnNames);
                }
            } else if (is_object($object)) {
                foreach ($object as $k => $v) {
                    if (in_array('all', $columnNames) || in_array($k, $columnNames)) {
                        $object->$k = $this->convertJsonResponse($v, $columnNames);
                    }
                }
            } else if (is_string($object)) {
                $object = $this->convertJsonResponseValue($object);
            }
            return $object;
        }

        public function process(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
        {
            $operation = RequestUtils::getOperation($request);
            $controllerPath = RequestUtils::getPathSegment($request, 1);
            $tableName = RequestUtils::getPathSegment($request, 2);

            $controllerPaths = $this->getArrayProperty('controllers', 'records,geojson');
    		$tableNames = $this->getArrayProperty('tables', 'all');
    		$columnNames = $this->getArrayProperty('columns', 'all');
    		if (
    			(in_array('all', $controllerPaths) || in_array($controllerPath, $controllerPaths)) &&
    			(in_array('all', $tableNames) || in_array($tableName, $tableNames))
    		) {
                if (in_array($operation, ['create', 'update'])) {
                    $records = $request->getParsedBody();
                    $records = $this->convertJsonRequest($records,$columnNames);
                    $request = $request->withParsedBody($records);
                }
                $response = $next->handle($request);
                if (in_array($operation, ['read', 'list'])) {
                    $records = json_decode($response->getBody()->getContents());
                    $records = $this->convertJsonResponse($records, $columnNames);
                    $response = ResponseFactory::fromObject($response->getStatusCode(), $records);
                }
            } else {
                $response = $next->handle($request);
            }
            return $response;
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Middleware/JwtAuthMiddleware.php
namespace Tqdev\PhpCrudApi\Middleware {

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Psr\Http\Server\RequestHandlerInterface;
    use Tqdev\PhpCrudApi\Middleware\Base\Middleware;
    use Tqdev\PhpCrudApi\Record\ErrorCode;
    use Tqdev\PhpCrudApi\RequestUtils;

    class JwtAuthMiddleware extends Middleware
    {
        private function getVerifiedClaims(string $token, int $time, int $leeway, int $ttl, array $secrets, array $requirements): array
        {
            $algorithms = array(
                'HS256' => 'sha256',
                'HS384' => 'sha384',
                'HS512' => 'sha512',
                'RS256' => 'sha256',
                'RS384' => 'sha384',
                'RS512' => 'sha512',
            );
            $token = explode('.', $token);
            if (count($token) < 3) {
                return array();
            }
            $header = json_decode(base64_decode(strtr($token[0], '-_', '+/')), true);
            $kid = 0;
            if (isset($header['kid'])) {
                $kid = $header['kid'];
            }
            if (!isset($secrets[$kid])) {
                return array();
            }
            $secret = $secrets[$kid];
            if ($header['typ'] != 'JWT') {
                return array();
            }
            $algorithm = $header['alg'];
            if (!isset($algorithms[$algorithm])) {
                return array();
            }
            if (!empty($requirements['alg']) && !in_array($algorithm, $requirements['alg'])) {
                return array();
            }
            $hmac = $algorithms[$algorithm];
            $signature = base64_decode(strtr($token[2], '-_', '+/'));
            $data = "$token[0].$token[1]";
            switch ($algorithm[0]) {
                case 'H':
                    $hash = hash_hmac($hmac, $data, $secret, true);
                    $equals = hash_equals($hash, $signature);
                    if (!$equals) {
                        return array();
                    }
                    break;
                case 'R':
                    $equals = openssl_verify($data, $signature, $secret, $hmac) == 1;
                    if (!$equals) {
                        return array();
                    }
                    break;
            }
            $claims = json_decode(base64_decode(strtr($token[1], '-_', '+/')), true);
            if (!$claims) {
                return array();
            }
            foreach ($requirements as $field => $values) {
                if (!empty($values)) {
                    if ($field != 'alg') {
                        if (!isset($claims[$field]) || !in_array($claims[$field], $values)) {
                            return array();
                        }
                    }
                }
            }
            if (isset($claims['nbf']) && $time + $leeway < $claims['nbf']) {
                return array();
            }
            if (isset($claims['iat']) && $time + $leeway < $claims['iat']) {
                return array();
            }
            if (isset($claims['exp']) && $time - $leeway > $claims['exp']) {
                return array();
            }
            if (isset($claims['iat']) && !isset($claims['exp'])) {
                if ($time - $leeway > $claims['iat'] + $ttl) {
                    return array();
                }
            }
            return $claims;
        }

        private function getClaims(string $token): array
        {
            $time = (int) $this->getProperty('time', time());
            $leeway = (int) $this->getProperty('leeway', '5');
            $ttl = (int) $this->getProperty('ttl', '30');
            $secrets = $this->getMapProperty('secrets', '');
            if (!$secrets) {
                $secrets = [$this->getProperty('secret', '')];
            }
            $requirements = array(
                'alg' => $this->getArrayProperty('algorithms', ''),
                'aud' => $this->getArrayProperty('audiences', ''),
                'iss' => $this->getArrayProperty('issuers', ''),
            );
            return $this->getVerifiedClaims($token, $time, $leeway, $ttl, $secrets, $requirements);
        }

        private function getAuthorizationToken(ServerRequestInterface $request): string
        {
            $headerName = $this->getProperty('header', 'X-Authorization');
            $headerValue = RequestUtils::getHeader($request, $headerName);
            $parts = explode(' ', trim($headerValue), 2);
            if (count($parts) != 2) {
                return '';
            }
            if ($parts[0] != 'Bearer') {
                return '';
            }
            return $parts[1];
        }

        public function process(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
        {
            if (session_status() == PHP_SESSION_NONE) {
                if (!headers_sent()) {
                    $sessionName = $this->getProperty('sessionName', '');
                    if ($sessionName) {
                        session_name($sessionName);
                    }
                    session_start();
                }
            }
            $token = $this->getAuthorizationToken($request);
            if ($token) {
                $claims = $this->getClaims($token);
                $_SESSION['claims'] = $claims;
                if (empty($claims)) {
                    return $this->responder->error(ErrorCode::AUTHENTICATION_FAILED, 'JWT');
                }
                if (!headers_sent()) {
                    session_regenerate_id();
                }
            }
            if (empty($_SESSION['claims'])) {
                $authenticationMode = $this->getProperty('mode', 'required');
                if ($authenticationMode == 'required') {
                    return $this->responder->error(ErrorCode::AUTHENTICATION_REQUIRED, '');
                }
            }
            return $next->handle($request);
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Middleware/MultiTenancyMiddleware.php
namespace Tqdev\PhpCrudApi\Middleware {

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Psr\Http\Server\RequestHandlerInterface;
    use Tqdev\PhpCrudApi\Column\ReflectionService;
    use Tqdev\PhpCrudApi\Controller\Responder;
    use Tqdev\PhpCrudApi\Middleware\Base\Middleware;
    use Tqdev\PhpCrudApi\Middleware\Communication\VariableStore;
    use Tqdev\PhpCrudApi\Middleware\Router\Router;
    use Tqdev\PhpCrudApi\Record\Condition\ColumnCondition;
    use Tqdev\PhpCrudApi\Record\Condition\Condition;
    use Tqdev\PhpCrudApi\Record\Condition\NoCondition;
    use Tqdev\PhpCrudApi\RequestUtils;

    class MultiTenancyMiddleware extends Middleware
    {
        private $reflection;

        public function __construct(Router $router, Responder $responder, array $properties, ReflectionService $reflection)
        {
            parent::__construct($router, $responder, $properties);
            $this->reflection = $reflection;
        }

        private function getCondition(string $tableName, array $pairs): Condition
        {
            $condition = new NoCondition();
            $table = $this->reflection->getTable($tableName);
            foreach ($pairs as $k => $v) {
                $condition = $condition->_and(new ColumnCondition($table->getColumn($k), 'eq', $v));
            }
            return $condition;
        }

        private function getPairs($handler, string $operation, string $tableName): array
        {
            $result = array();
            $pairs = call_user_func($handler, $operation, $tableName) ?: [];
            $table = $this->reflection->getTable($tableName);
            foreach ($pairs as $k => $v) {
                if ($table->hasColumn($k)) {
                    $result[$k] = $v;
                }
            }
            return $result;
        }

        private function handleRecord(ServerRequestInterface $request, string $operation, array $pairs): ServerRequestInterface
        {
            $record = $request->getParsedBody();
            if ($record === null) {
                return $request;
            }
            $multi = is_array($record);
            $records = $multi ? $record : [$record];
            foreach ($records as &$record) {
                foreach ($pairs as $column => $value) {
                    if ($operation == 'create') {
                        $record->$column = $value;
                    } else {
                        if (isset($record->$column)) {
                            unset($record->$column);
                        }
                    }
                }
            }
            return $request->withParsedBody($multi ? $records : $records[0]);
        }

        public function process(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
        {
            $handler = $this->getProperty('handler', '');
            if ($handler !== '') {
                $path = RequestUtils::getPathSegment($request, 1);
                if ($path == 'records') {
                    $operation = RequestUtils::getOperation($request);
                    $tableNames = RequestUtils::getTableNames($request, $this->reflection);
                    foreach ($tableNames as $i => $tableName) {
                        if (!$this->reflection->hasTable($tableName)) {
                            continue;
                        }
                        $pairs = $this->getPairs($handler, $operation, $tableName);
                        if ($i == 0) {
                            if (in_array($operation, ['create', 'update', 'increment'])) {
                                $request = $this->handleRecord($request, $operation, $pairs);
                            }
                        }
                        $condition = $this->getCondition($tableName, $pairs);
                        VariableStore::set("multiTenancy.conditions.$tableName", $condition);
                    }
                }
            }
            return $next->handle($request);
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Middleware/PageLimitsMiddleware.php
namespace Tqdev\PhpCrudApi\Middleware {

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Psr\Http\Server\RequestHandlerInterface;
    use Tqdev\PhpCrudApi\Column\ReflectionService;
    use Tqdev\PhpCrudApi\Controller\Responder;
    use Tqdev\PhpCrudApi\Middleware\Base\Middleware;
    use Tqdev\PhpCrudApi\Middleware\Router\Router;
    use Tqdev\PhpCrudApi\Record\ErrorCode;
    use Tqdev\PhpCrudApi\RequestUtils;

    class PageLimitsMiddleware extends Middleware
    {
        private $reflection;

        public function __construct(Router $router, Responder $responder, array $properties, ReflectionService $reflection)
        {
            parent::__construct($router, $responder, $properties);
            $this->reflection = $reflection;
        }

        public function process(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
        {
            $operation = RequestUtils::getOperation($request);
            if ($operation == 'list') {
                $params = RequestUtils::getParams($request);
                $maxPage = (int) $this->getProperty('pages', '100');
                if (isset($params['page']) && $params['page'] && $maxPage > 0) {
                    if (strpos($params['page'][0], ',') === false) {
                        $page = $params['page'][0];
                    } else {
                        list($page, $size) = explode(',', $params['page'][0], 2);
                    }
                    if ($page > $maxPage) {
                        return $this->responder->error(ErrorCode::PAGINATION_FORBIDDEN, '');
                    }
                }
                $maxSize = (int) $this->getProperty('records', '1000');
                if (!isset($params['size']) || !$params['size'] && $maxSize > 0) {
                    $params['size'] = array($maxSize);
                } else {
                    $params['size'] = array(min($params['size'][0], $maxSize));
                }
                $request = RequestUtils::setParams($request, $params);
            }
            return $next->handle($request);
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Middleware/ReconnectMiddleware.php
namespace Tqdev\PhpCrudApi\Middleware {

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Psr\Http\Server\RequestHandlerInterface;
    use Tqdev\PhpCrudApi\Column\ReflectionService;
    use Tqdev\PhpCrudApi\Controller\Responder;
    use Tqdev\PhpCrudApi\Database\GenericDB;
    use Tqdev\PhpCrudApi\Middleware\Base\Middleware;
    use Tqdev\PhpCrudApi\Middleware\Router\Router;

    class ReconnectMiddleware extends Middleware
    {
        private $reflection;
        private $db;

        public function __construct(Router $router, Responder $responder, array $properties, ReflectionService $reflection, GenericDB $db)
        {
            parent::__construct($router, $responder, $properties);
            $this->reflection = $reflection;
            $this->db = $db;
        }

        private function getDriver(): string
        {
            $driverHandler = $this->getProperty('driverHandler', '');
            if ($driverHandler) {
                return call_user_func($driverHandler);
            }
            return '';
        }

        private function getAddress(): string
        {
            $addressHandler = $this->getProperty('addressHandler', '');
            if ($addressHandler) {
                return call_user_func($addressHandler);
            }
            return '';
        }

        private function getPort(): int
        {
            $portHandler = $this->getProperty('portHandler', '');
            if ($portHandler) {
                return call_user_func($portHandler);
            }
            return 0;
        }

        private function getDatabase(): string
        {
            $databaseHandler = $this->getProperty('databaseHandler', '');
            if ($databaseHandler) {
                return call_user_func($databaseHandler);
            }
            return '';
        }

        private function getTables(): array
        {
            $tablesHandler = $this->getProperty('tablesHandler', '');
            if ($tablesHandler) {
                return call_user_func($tablesHandler);
            }
            return [];
        }

        private function getUsername(): string
        {
            $usernameHandler = $this->getProperty('usernameHandler', '');
            if ($usernameHandler) {
                return call_user_func($usernameHandler);
            }
            return '';
        }

        private function getPassword(): string
        {
            $passwordHandler = $this->getProperty('passwordHandler', '');
            if ($passwordHandler) {
                return call_user_func($passwordHandler);
            }
            return '';
        }

        public function process(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
        {
            $driver = $this->getDriver();
            $address = $this->getAddress();
            $port = $this->getPort();
            $database = $this->getDatabase();
            $tables = $this->getTables();
            $username = $this->getUsername();
            $password = $this->getPassword();
            if ($driver || $address || $port || $database || $tables || $username || $password) {
                $this->db->reconstruct($driver, $address, $port, $database, $tables, $username, $password);
            }
            return $next->handle($request);
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Middleware/SanitationMiddleware.php
namespace Tqdev\PhpCrudApi\Middleware {

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Psr\Http\Server\RequestHandlerInterface;
    use Tqdev\PhpCrudApi\Column\Reflection\ReflectedTable;
    use Tqdev\PhpCrudApi\Column\Reflection\ReflectedColumn;
    use Tqdev\PhpCrudApi\Column\ReflectionService;
    use Tqdev\PhpCrudApi\Controller\Responder;
    use Tqdev\PhpCrudApi\Middleware\Base\Middleware;
    use Tqdev\PhpCrudApi\Middleware\Router\Router;
    use Tqdev\PhpCrudApi\RequestUtils;

    class SanitationMiddleware extends Middleware
    {
        private $reflection;

        public function __construct(Router $router, Responder $responder, array $properties, ReflectionService $reflection)
        {
            parent::__construct($router, $responder, $properties);
            $this->reflection = $reflection;
        }

        private function callHandler($handler, $record, string $operation, ReflectedTable $table) /*: object */
        {
            $context = (array) $record;
            $tableName = $table->getName();
            foreach ($context as $columnName => &$value) {
                if ($table->hasColumn($columnName)) {
                    $column = $table->getColumn($columnName);
                    $value = call_user_func($handler, $operation, $tableName, $column->serialize(), $value);
                    $value = $this->sanitizeType($table, $column, $value);
                }
            }
            return (object) $context;
        }

        private function sanitizeType(ReflectedTable $table, ReflectedColumn $column, $value)
        {
            $tables = $this->getArrayProperty('tables', 'all');
            $types = $this->getArrayProperty('types', 'all');
            if (
                (in_array('all', $tables) || in_array($table->getName(), $tables)) &&
                (in_array('all', $types) || in_array($column->getType(), $types))
            ) {
                if (is_null($value)) {
                    return $value;
                }
                if (is_string($value)) {
                    $newValue = null;
                    switch ($column->getType()) {
                        case 'integer':
                        case 'bigint':
                            $newValue = filter_var(trim($value), FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            break;
                        case 'decimal':
                            $newValue = filter_var(trim($value), FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE);
                            if (is_float($newValue)) {
                                $newValue = number_format($newValue, $column->getScale(), '.', '');
                            }
                            break;
                        case 'float':
                        case 'double':
                            $newValue = filter_var(trim($value), FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE);
                            break;
                        case 'boolean':
                            $newValue = filter_var(trim($value), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
                            break;
                        case 'date':
                            $time = strtotime(trim($value));
                            if ($time !== false) {
                                $newValue = date('Y-m-d', $time);
                            }
                            break;
                        case 'time':
                            $time = strtotime(trim($value));
                            if ($time !== false) {
                                $newValue = date('H:i:s', $time);
                            }
                            break;
                        case 'timestamp':
                            $time = strtotime(trim($value));
                            if ($time !== false) {
                                $newValue = date('Y-m-d H:i:s', $time);
                            }
                            break;
                        case 'blob':
                        case 'varbinary':
                            // allow base64url format
                            $newValue = strtr(trim($value), '-_', '+/');
                            break;
                        case 'clob':
                        case 'varchar':
                            $newValue = $value;
                            break;
                        case 'geometry':
                            $newValue = trim($value);
                            break;
                    }
                    if (!is_null($newValue)) {
                        $value = $newValue;
                    }
                } else {
                    switch ($column->getType()) {
                        case 'integer':
                        case 'bigint':
                            if (is_float($value)) {
                                $value = (int) round($value);
                            }
                            break;
                        case 'decimal':
                            if (is_float($value) || is_int($value)) {
                                $value = number_format((float) $value, $column->getScale(), '.', '');
                            }
                            break;
                    }
                }
                // post process
            }
            return $value;
        }

        public function process(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
        {
            $operation = RequestUtils::getOperation($request);
            if (in_array($operation, ['create', 'update', 'increment'])) {
                $tableName = RequestUtils::getPathSegment($request, 2);
                if ($this->reflection->hasTable($tableName)) {
                    $record = $request->getParsedBody();
                    if ($record !== null) {
                        $handler = $this->getProperty('handler', '');
                        if ($handler !== '') {
                            $table = $this->reflection->getTable($tableName);
                            if (is_array($record)) {
                                foreach ($record as &$r) {
                                    $r = $this->callHandler($handler, $r, $operation, $table);
                                }
                            } else {
                                $record = $this->callHandler($handler, $record, $operation, $table);
                            }
                            $request = $request->withParsedBody($record);
                        }
                    }
                }
            }
            return $next->handle($request);
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Middleware/SslRedirectMiddleware.php
namespace Tqdev\PhpCrudApi\Middleware {

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Psr\Http\Server\RequestHandlerInterface;
    use Tqdev\PhpCrudApi\Middleware\Base\Middleware;
    use Tqdev\PhpCrudApi\ResponseFactory;

    class SslRedirectMiddleware extends Middleware
    {
        public function process(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
        {
            $uri = $request->getUri();
            $scheme = $uri->getScheme();
            if ($scheme == 'http') {
                $uri = $request->getUri();
                $uri = $uri->withScheme('https');
                $response = ResponseFactory::fromStatus(301);
                $response = $response->withHeader('Location', $uri->__toString());
            } else {
                $response = $next->handle($request);
            }
            return $response;
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Middleware/ValidationMiddleware.php
namespace Tqdev\PhpCrudApi\Middleware {

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Psr\Http\Server\RequestHandlerInterface;
    use Tqdev\PhpCrudApi\Column\ReflectionService;
    use Tqdev\PhpCrudApi\Column\Reflection\ReflectedTable;
    use Tqdev\PhpCrudApi\Column\Reflection\ReflectedColumn;
    use Tqdev\PhpCrudApi\Controller\Responder;
    use Tqdev\PhpCrudApi\Middleware\Base\Middleware;
    use Tqdev\PhpCrudApi\Middleware\Router\Router;
    use Tqdev\PhpCrudApi\Record\ErrorCode;
    use Tqdev\PhpCrudApi\RequestUtils;

    class ValidationMiddleware extends Middleware
    {
    	private $reflection;

    	public function __construct(Router $router, Responder $responder, array $properties, ReflectionService $reflection)
    	{
    		parent::__construct($router, $responder, $properties);
    		$this->reflection = $reflection;
    	}

    	private function callHandler($handler, $record, string $operation, ReflectedTable $table) /*: ResponseInterface?*/
    	{
    		$context = (array) $record;
    		$details = array();
    		$tableName = $table->getName();
    		foreach ($context as $columnName => $value) {
    			if ($table->hasColumn($columnName)) {
    				$column = $table->getColumn($columnName);
    				$valid = call_user_func($handler, $operation, $tableName, $column->serialize(), $value, $context);
    				if ($valid === true || $valid === '') {
    					$valid = $this->validateType($table, $column, $value);
    				}
    				if ($valid !== true && $valid !== '') {
    					$details[$columnName] = $valid;
    				}
    			}
    		}
    		if (count($details) > 0) {
    			return $this->responder->error(ErrorCode::INPUT_VALIDATION_FAILED, $tableName, $details);
    		}
    		return null;
    	}

    	private function validateType(ReflectedTable $table, ReflectedColumn $column, $value)
    	{
    		$tables = $this->getArrayProperty('tables', 'all');
    		$types = $this->getArrayProperty('types', 'all');
    		if (
    			(in_array('all', $tables) || in_array($table->getName(), $tables)) &&
    			(in_array('all', $types) || in_array($column->getType(), $types))
    		) {
    			if (is_null($value)) {
    				return ($column->getNullable() ? true : "cannot be null");
    			}
    			if (is_string($value)) {
    				// check for whitespace
    				switch ($column->getType()) {
    					case 'varchar':
    					case 'clob':
    						break;
    					default:
    						if (strlen(trim($value)) != strlen($value)) {
    							return 'illegal whitespace';
    						}
    						break;
    				}
    				// try to parse
    				switch ($column->getType()) {
    					case 'integer':
    					case 'bigint':
    						if (
    							filter_var($value, FILTER_SANITIZE_NUMBER_INT) !== $value ||
    							filter_var($value, FILTER_VALIDATE_INT) === false
    						) {
    							return 'invalid integer';
    						}
    						break;
    					case 'decimal':
    						if (strpos($value, '.') !== false) {
    							list($whole, $decimals) = explode('.', ltrim($value, '-'), 2);
    						} else {
    							list($whole, $decimals) = array(ltrim($value, '-'), '');
    						}
    						if (strlen($whole) > 0 && !ctype_digit($whole)) {
    							return 'invalid decimal';
    						}
    						if (strlen($decimals) > 0 && !ctype_digit($decimals)) {
    							return 'invalid decimal';
    						}
    						if (strlen($whole) > $column->getPrecision() - $column->getScale()) {
    							return 'decimal too large';
    						}
    						if (strlen($decimals) > $column->getScale()) {
    							return 'decimal too precise';
    						}
    						break;
    					case 'float':
    					case 'double':
    						if (
    							filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT) !== $value ||
    							filter_var($value, FILTER_VALIDATE_FLOAT) === false
    						) {
    							return 'invalid float';
    						}
    						break;
    					case 'boolean':
    						if (!in_array(strtolower($value), array('true', 'false'))) {
    							return 'invalid boolean';
    						}
    						break;
    					case 'date':
    						if (date_create_from_format('Y-m-d', $value) === false) {
    							return 'invalid date';
    						}
    						break;
    					case 'time':
    						if (date_create_from_format('H:i:s', $value) === false) {
    							return 'invalid time';
    						}
    						break;
    					case 'timestamp':
    						if (date_create_from_format('Y-m-d H:i:s', $value) === false) {
    							return 'invalid timestamp';
    						}
    						break;
    					case 'clob':
    					case 'varchar':
    						if ($column->hasLength() && mb_strlen($value, 'UTF-8') > $column->getLength()) {
    							return 'string too long';
    						}
    						break;
    					case 'blob':
    					case 'varbinary':
    						if (base64_decode($value, true) === false) {
    							return 'invalid base64';
    						}
    						if ($column->hasLength() && strlen(base64_decode($value)) > $column->getLength()) {
    							return 'string too long';
    						}
    						break;
    					case 'geometry':
    						// no checks yet
    						break;
    				}
    			} else { // check non-string types
    				switch ($column->getType()) {
    					case 'integer':
    					case 'bigint':
    						if (!is_int($value)) {
    							return 'invalid integer';
    						}
    						break;
    					case 'float':
    					case 'double':
    						if (!is_float($value) && !is_int($value)) {
    							return 'invalid float';
    						}
    						break;
    					case 'boolean':
    						if (!is_bool($value) && ($value !== 0) && ($value !== 1)) {
    							return 'invalid boolean';
    						}
    						break;
    					default:
    						return 'invalid ' . $column->getType();
    				}
    			}
    			// extra checks
    			switch ($column->getType()) {
    				case 'integer': // 4 byte signed
    					$value = filter_var($value, FILTER_VALIDATE_INT);
    					if ($value > 2147483647 || $value < -2147483648) {
    						return 'invalid integer';
    					}
    					break;
    			}
    		}
    		return (true);
    	}

    	public function process(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
    	{
    		$operation = RequestUtils::getOperation($request);
    		if (in_array($operation, ['create', 'update', 'increment'])) {
    			$tableName = RequestUtils::getPathSegment($request, 2);
    			if ($this->reflection->hasTable($tableName)) {
    				$record = $request->getParsedBody();
    				if ($record !== null) {
    					$handler = $this->getProperty('handler', '');
    					if ($handler !== '') {
    						$table = $this->reflection->getTable($tableName);
    						if (is_array($record)) {
    							foreach ($record as $r) {
    								$response = $this->callHandler($handler, $r, $operation, $table);
    								if ($response !== null) {
    									return $response;
    								}
    							}
    						} else {
    							$response = $this->callHandler($handler, $record, $operation, $table);
    							if ($response !== null) {
    								return $response;
    							}
    						}
    					}
    				}
    			}
    		}
    		return $next->handle($request);
    	}
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Middleware/XmlMiddleware.php
namespace Tqdev\PhpCrudApi\Middleware {

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Psr\Http\Server\RequestHandlerInterface;
    use Tqdev\PhpCrudApi\Column\ReflectionService;
    use Tqdev\PhpCrudApi\Controller\Responder;
    use Tqdev\PhpCrudApi\Middleware\Base\Middleware;
    use Tqdev\PhpCrudApi\Middleware\Router\Router;
    use Tqdev\PhpCrudApi\RequestUtils;
    use Tqdev\PhpCrudApi\ResponseFactory;

    class XmlMiddleware extends Middleware
    {
        private $reflection;

        public function __construct(Router $router, Responder $responder, array $properties, ReflectionService $reflection)
        {
            parent::__construct($router, $responder, $properties);
            $this->reflection = $reflection;
        }

        private function json2xml($json, $types = 'null,boolean,number,string,object,array')
        {
            $a = json_decode($json);
            $d = new \DOMDocument();
            $c = $d->createElement("root");
            $d->appendChild($c);
            $t = function ($v) {
                $type = gettype($v);
                switch ($type) {
                    case 'integer':
                        return 'number';
                    case 'double':
                        return 'number';
                    default:
                        return strtolower($type);
                }
            };
            $ts = explode(',', $types);
            $f = function ($f, $c, $a, $s = false) use ($t, $d, $ts) {
                if (in_array($t($a), $ts)) {
                    $c->setAttribute('type', $t($a));
                }
                if ($t($a) != 'array' && $t($a) != 'object') {
                    if ($t($a) == 'boolean') {
                        $c->appendChild($d->createTextNode($a ? 'true' : 'false'));
                    } else {
                        $c->appendChild($d->createTextNode($a));
                    }
                } else {
                    foreach ($a as $k => $v) {
                        if ($k == '__type' && $t($a) == 'object') {
                            $c->setAttribute('__type', $v);
                        } else {
                            if ($t($v) == 'object') {
                                $ch = $c->appendChild($d->createElementNS(null, $s ? 'item' : $k));
                                $f($f, $ch, $v);
                            } else if ($t($v) == 'array') {
                                $ch = $c->appendChild($d->createElementNS(null, $s ? 'item' : $k));
                                $f($f, $ch, $v, true);
                            } else {
                                $va = $d->createElementNS(null, $s ? 'item' : $k);
                                if ($t($v) == 'boolean') {
                                    $va->appendChild($d->createTextNode($v ? 'true' : 'false'));
                                } else {
                                    $va->appendChild($d->createTextNode($v));
                                }
                                $ch = $c->appendChild($va);
                                if (in_array($t($v), $ts)) {
                                    $ch->setAttribute('type', $t($v));
                                }
                            }
                        }
                    }
                }
            };
            $f($f, $c, $a, $t($a) == 'array');
            return $d->saveXML($d->documentElement);
        }

        private function xml2json($xml)
        {
            $o = @simplexml_load_string($xml);
            if ($o===false) {
                return null;
            }
            $a = @dom_import_simplexml($o);
            if (!$a) {
                return null;
            }
            $t = function ($v) {
                $t = $v->getAttribute('type');
                $txt = $v->firstChild->nodeType == XML_TEXT_NODE;
                return $t ?: ($txt ? 'string' : 'object');
            };
            $f = function ($f, $a) use ($t) {
                $c = null;
                if ($t($a) == 'null') {
                    $c = null;
                } else if ($t($a) == 'boolean') {
                    $b = substr(strtolower($a->textContent), 0, 1);
                    $c = in_array($b, array('1', 't'));
                } else if ($t($a) == 'number') {
                    $c = $a->textContent + 0;
                } else if ($t($a) == 'string') {
                    $c = $a->textContent;
                } else if ($t($a) == 'object') {
                    $c = array();
                    if ($a->getAttribute('__type')) {
                        $c['__type'] = $a->getAttribute('__type');
                    }
                    for ($i = 0; $i < $a->childNodes->length; $i++) {
                        $v = $a->childNodes[$i];
                        $c[$v->nodeName] = $f($f, $v);
                    }
                    $c = (object) $c;
                } else if ($t($a) == 'array') {
                    $c = array();
                    for ($i = 0; $i < $a->childNodes->length; $i++) {
                        $v = $a->childNodes[$i];
                        $c[$i] = $f($f, $v);
                    }
                }
                return $c;
            };
            $c = $f($f, $a);
            return json_encode($c);
        }

        public function process(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
        {
            parse_str($request->getUri()->getQuery(), $params);
            $isXml = isset($params['format']) && $params['format'] == 'xml';
            if ($isXml) {
                $body = $request->getBody()->getContents();
                if ($body) {
                    $json = $this->xml2json($body);
                    $request = $request->withParsedBody(json_decode($json));
                }
            }
            $response = $next->handle($request);
            if ($isXml) {
                $body = $response->getBody()->getContents();
                if ($body) {
                    $types = implode(',', $this->getArrayProperty('types', 'null,array'));
                    if ($types == '' || $types == 'all') {
                        $xml = $this->json2xml($body);
                    } else {
                        $xml = $this->json2xml($body, $types);
                    }
                    $response = ResponseFactory::fromXml(ResponseFactory::OK, $xml);
                }
            }
            return $response;
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Middleware/XsrfMiddleware.php
namespace Tqdev\PhpCrudApi\Middleware {

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Psr\Http\Server\RequestHandlerInterface;
    use Tqdev\PhpCrudApi\Controller\Responder;
    use Tqdev\PhpCrudApi\Middleware\Base\Middleware;
    use Tqdev\PhpCrudApi\Record\ErrorCode;

    class XsrfMiddleware extends Middleware
    {
        private function getToken(): string
        {
            $cookieName = $this->getProperty('cookieName', 'XSRF-TOKEN');
            if (isset($_COOKIE[$cookieName])) {
                $token = $_COOKIE[$cookieName];
            } else {
                $secure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on';
                $token = bin2hex(random_bytes(8));
                if (!headers_sent()) {
                    setcookie($cookieName, $token, 0, '', '', $secure);
                }
            }
            return $token;
        }

        public function process(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
        {
            $token = $this->getToken();
            $method = $request->getMethod();
            $excludeMethods = $this->getArrayProperty('excludeMethods', 'OPTIONS,GET');
            if (!in_array($method, $excludeMethods)) {
                $headerName = $this->getProperty('headerName', 'X-XSRF-TOKEN');
                if ($token != $request->getHeader($headerName)) {
                    return $this->responder->error(ErrorCode::BAD_OR_MISSING_XSRF_TOKEN, '');
                }
            }
            return $next->handle($request);
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/OpenApi/OpenApiBuilder.php
namespace Tqdev\PhpCrudApi\OpenApi {

    use Tqdev\PhpCrudApi\Column\ReflectionService;
    use Tqdev\PhpCrudApi\OpenApi\OpenApiDefinition;

    class OpenApiBuilder
    {
        private $openapi;
        private $records;
        private $columns;
        private $builders;

        public function __construct(ReflectionService $reflection, array $base, array $controllers, array $builders)
        {
            $this->openapi = new OpenApiDefinition($base);
            $this->records = in_array('records', $controllers) ? new OpenApiRecordsBuilder($this->openapi, $reflection) : null;
            $this->columns = in_array('columns', $controllers) ? new OpenApiColumnsBuilder($this->openapi) : null;
            $this->status = in_array('status', $controllers) ? new OpenApiStatusBuilder($this->openapi) : null;
            $this->builders = array();
            foreach ($builders as $className) {
                $this->builders[] = new $className($this->openapi, $reflection);
            }
        }

        private function getServerUrl(): string
        {
            $protocol = @$_SERVER['HTTP_X_FORWARDED_PROTO'] ?: @$_SERVER['REQUEST_SCHEME'] ?: ((isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") ? "https" : "http");
            $port = @intval($_SERVER['HTTP_X_FORWARDED_PORT']) ?: @intval($_SERVER["SERVER_PORT"]) ?: (($protocol === 'https') ? 443 : 80);
            $host = @explode(":", $_SERVER['HTTP_HOST'])[0] ?: @$_SERVER['SERVER_NAME'] ?: @$_SERVER['SERVER_ADDR'];
            $port = ($protocol === 'https' && $port === 443) || ($protocol === 'http' && $port === 80) ? '' : ':' . $port;
            $path = @trim(substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '/openapi')), '/');
            return sprintf('%s://%s%s/%s', $protocol, $host, $port, $path);
        }

        public function build(): OpenApiDefinition
        {
            $this->openapi->set("openapi", "3.0.0");
            if (!$this->openapi->has("servers") && isset($_SERVER['REQUEST_URI'])) {
                $this->openapi->set("servers|0|url", $this->getServerUrl());
            }
            if ($this->records) {
                $this->records->build();
            }
            if ($this->columns) {
                $this->columns->build();
            }
            if ($this->status) {
                $this->status->build();
            }
            foreach ($this->builders as $builder) {
                $builder->build();
            }
            return $this->openapi;
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/OpenApi/OpenApiColumnsBuilder.php
namespace Tqdev\PhpCrudApi\OpenApi {

    use Tqdev\PhpCrudApi\OpenApi\OpenApiDefinition;

    class OpenApiColumnsBuilder
    {
        private $openapi;
        private $operations = [
            'database' => [
                'read' => 'get',
            ],
            'table' => [
                'create' => 'post',
                'read' => 'get',
                'update' => 'put', //rename
                'delete' => 'delete',
            ],
            'column' => [
                'create' => 'post',
                'read' => 'get',
                'update' => 'put',
                'delete' => 'delete',
            ],
        ];

        public function __construct(OpenApiDefinition $openapi)
        {
            $this->openapi = $openapi;
        }

        public function build() /*: void*/
        {
            $this->setPaths();
            $this->openapi->set("components|responses|bool-success|description", "boolean indicating success or failure");
            $this->openapi->set("components|responses|bool-success|content|application/json|schema|type", "boolean");
            $this->setComponentSchema();
            $this->setComponentResponse();
            $this->setComponentRequestBody();
            $this->setComponentParameters();
            foreach (array_keys($this->operations) as $index => $type) {
                $this->setTag($index, $type);
            }
        }

        private function setPaths() /*: void*/
        {
            foreach (array_keys($this->operations) as $type) {
                foreach ($this->operations[$type] as $operation => $method) {
                    $parameters = [];
                    switch ($type) {
                        case 'database':
                            $path = '/columns';
                            break;
                        case 'table':
                            $path = $operation == 'create' ? '/columns' : '/columns/{table}';
                            break;
                        case 'column':
                            $path = $operation == 'create' ? '/columns/{table}' : '/columns/{table}/{column}';
                            break;
                    }
                    if (strpos($path, '{table}')) {
                        $parameters[] = 'table';
                    }
                    if (strpos($path, '{column}')) {
                        $parameters[] = 'column';
                    }
                    foreach ($parameters as $p => $parameter) {
                        $this->openapi->set("paths|$path|$method|parameters|$p|\$ref", "#/components/parameters/$parameter");
                    }
                    if (in_array($operation, ['create', 'update'])) {
                        $this->openapi->set("paths|$path|$method|requestBody|\$ref", "#/components/requestBodies/$operation-$type");
                    }
                    $this->openapi->set("paths|$path|$method|tags|0", "$type");
                    $this->openapi->set("paths|$path|$method|operationId", "$operation" . "_" . "$type");
                    if ($operation - $type == 'updateTable') {
                        $this->openapi->set("paths|$path|$method|description", "rename table");
                    } else {
                        $this->openapi->set("paths|$path|$method|description", "$operation $type");
                    }
                    switch ($operation) {
                        case 'read':
                            $this->openapi->set("paths|$path|$method|responses|200|\$ref", "#/components/responses/$operation-$type");
                            break;
                        case 'create':
                        case 'update':
                        case 'delete':
                            $this->openapi->set("paths|$path|$method|responses|200|\$ref", "#/components/responses/bool-success");
                            break;
                    }
                }
            }
        }

        private function setComponentSchema() /*: void*/
        {
            foreach (array_keys($this->operations) as $type) {
                foreach (array_keys($this->operations[$type]) as $operation) {
                    if ($operation == 'delete') {
                        continue;
                    }
                    $prefix = "components|schemas|$operation-$type";
                    $this->openapi->set("$prefix|type", "object");
                    switch ($type) {
                        case 'database':
                            $this->openapi->set("$prefix|properties|tables|type", 'array');
                            $this->openapi->set("$prefix|properties|tables|items|\$ref", "#/components/schemas/readTable");
                            break;
                        case 'table':
                            if ($operation == 'update') {
                                $this->openapi->set("$prefix|required", ['name']);
                                $this->openapi->set("$prefix|properties|name|type", 'string');
                            } else {
                                $this->openapi->set("$prefix|properties|name|type", 'string');
                                if ($operation == 'read') {
                                    $this->openapi->set("$prefix|properties|type|type", 'string');
                                }
                                $this->openapi->set("$prefix|properties|columns|type", 'array');
                                $this->openapi->set("$prefix|properties|columns|items|\$ref", "#/components/schemas/readColumn");
                            }
                            break;
                        case 'column':
                            $this->openapi->set("$prefix|required", ['name', 'type']);
                            $this->openapi->set("$prefix|properties|name|type", 'string');
                            $this->openapi->set("$prefix|properties|type|type", 'string');
                            $this->openapi->set("$prefix|properties|length|type", 'integer');
                            $this->openapi->set("$prefix|properties|length|format", "int64");
                            $this->openapi->set("$prefix|properties|precision|type", 'integer');
                            $this->openapi->set("$prefix|properties|precision|format", "int64");
                            $this->openapi->set("$prefix|properties|scale|type", 'integer');
                            $this->openapi->set("$prefix|properties|scale|format", "int64");
                            $this->openapi->set("$prefix|properties|nullable|type", 'boolean');
                            $this->openapi->set("$prefix|properties|pk|type", 'boolean');
                            $this->openapi->set("$prefix|properties|fk|type", 'string');
                            break;
                    }
                }
            }
        }

        private function setComponentResponse() /*: void*/
        {
            foreach (array_keys($this->operations) as $type) {
                foreach (array_keys($this->operations[$type]) as $operation) {
                    if ($operation != 'read') {
                        continue;
                    }
                    $this->openapi->set("components|responses|$operation-$type|description", "single $type record");
                    $this->openapi->set("components|responses|$operation-$type|content|application/json|schema|\$ref", "#/components/schemas/$operation-$type");
                }
            }
        }

        private function setComponentRequestBody() /*: void*/
        {
            foreach (array_keys($this->operations) as $type) {
                foreach (array_keys($this->operations[$type]) as $operation) {
                    if (!in_array($operation, ['create', 'update'])) {
                        continue;
                    }
                    $this->openapi->set("components|requestBodies|$operation-$type|description", "single $type record");
                    $this->openapi->set("components|requestBodies|$operation-$type|content|application/json|schema|\$ref", "#/components/schemas/$operation-$type");
                }
            }
        }

        private function setComponentParameters() /*: void*/
        {
            $this->openapi->set("components|parameters|table|name", "table");
            $this->openapi->set("components|parameters|table|in", "path");
            $this->openapi->set("components|parameters|table|schema|type", "string");
            $this->openapi->set("components|parameters|table|description", "table name");
            $this->openapi->set("components|parameters|table|required", true);

            $this->openapi->set("components|parameters|column|name", "column");
            $this->openapi->set("components|parameters|column|in", "path");
            $this->openapi->set("components|parameters|column|schema|type", "string");
            $this->openapi->set("components|parameters|column|description", "column name");
            $this->openapi->set("components|parameters|column|required", true);
        }

        private function setTag(int $index, string $type) /*: void*/
        {
            $this->openapi->set("tags|$index|name", "$type");
            $this->openapi->set("tags|$index|description", "$type operations");
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/OpenApi/OpenApiDefinition.php
namespace Tqdev\PhpCrudApi\OpenApi {

    class OpenApiDefinition implements \JsonSerializable
    {
        private $root;

        public function __construct(array $base)
        {
            $this->root = $base;
        }

        public function set(string $path, $value) /*: void*/
        {
            $parts = explode('|', trim($path, '|'));
            $current = &$this->root;
            while (count($parts) > 0) {
                $part = array_shift($parts);
                if (!isset($current[$part])) {
                    $current[$part] = [];
                }
                $current = &$current[$part];
            }
            $current = $value;
        }

        public function has(string $path): bool
        {
            $parts = explode('|', trim($path, '|'));
            $current = &$this->root;
            while (count($parts) > 0) {
                $part = array_shift($parts);
                if (!isset($current[$part])) {
                    return false;
                }
                $current = &$current[$part];
            }
            return true;
        }

        public function jsonSerialize()
        {
            return $this->root;
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/OpenApi/OpenApiRecordsBuilder.php
namespace Tqdev\PhpCrudApi\OpenApi {

    use Tqdev\PhpCrudApi\Column\ReflectionService;
    use Tqdev\PhpCrudApi\Column\Reflection\ReflectedColumn;
    use Tqdev\PhpCrudApi\Middleware\Communication\VariableStore;
    use Tqdev\PhpCrudApi\OpenApi\OpenApiDefinition;

    class OpenApiRecordsBuilder
    {
        private $openapi;
        private $reflection;
        private $operations = [
            'list' => 'get',
            'create' => 'post',
            'read' => 'get',
            'update' => 'put',
            'delete' => 'delete',
            'increment' => 'patch',
        ];
        private $types = [
            'integer' => ['type' => 'integer', 'format' => 'int32'],
            'bigint' => ['type' => 'integer', 'format' => 'int64'],
            'varchar' => ['type' => 'string'],
            'clob' => ['type' => 'string', 'format' => 'large-string'], //custom format
            'varbinary' => ['type' => 'string', 'format' => 'byte'],
            'blob' => ['type' => 'string', 'format' => 'large-byte'], //custom format
            'decimal' => ['type' => 'string', 'format' => 'decimal'], //custom format
            'float' => ['type' => 'number', 'format' => 'float'],
            'double' => ['type' => 'number', 'format' => 'double'],
            'date' => ['type' => 'string', 'format' => 'date'],
            'time' => ['type' => 'string', 'format' => 'time'], //custom format
            'timestamp' => ['type' => 'string', 'format' => 'date-time'],
            'geometry' => ['type' => 'string', 'format' => 'geometry'], //custom format
            'boolean' => ['type' => 'boolean'],
        ];

        private function normalize(string $value): string
        {
            return iconv('UTF-8', 'ASCII//TRANSLIT', $value);
        }

        public function __construct(OpenApiDefinition $openapi, ReflectionService $reflection)
        {
            $this->openapi = $openapi;
            $this->reflection = $reflection;
        }

        private function getAllTableReferences(): array
        {
            $tableReferences = array();
            foreach ($this->reflection->getTableNames() as $tableName) {
                $table = $this->reflection->getTable($tableName);
                foreach ($table->getColumnNames() as $columnName) {
                    $column = $table->getColumn($columnName);
                    $referencedTableName = $column->getFk();
                    if ($referencedTableName) {
                        if (!isset($tableReferences[$referencedTableName])) {
                            $tableReferences[$referencedTableName] = array();
                        }
                        $tableReferences[$referencedTableName][] = "$tableName.$columnName";
                    }
                }
            }
            return $tableReferences;
        }

        public function build() /*: void*/
        {
            $tableNames = $this->reflection->getTableNames();
            foreach ($tableNames as $tableName) {
                $this->setPath($tableName);
            }
            $this->openapi->set("components|responses|pk_integer|description", "inserted primary key value (integer)");
            $this->openapi->set("components|responses|pk_integer|content|application/json|schema|type", "integer");
            $this->openapi->set("components|responses|pk_integer|content|application/json|schema|format", "int64");
            $this->openapi->set("components|responses|pk_string|description", "inserted primary key value (string)");
            $this->openapi->set("components|responses|pk_string|content|application/json|schema|type", "string");
            $this->openapi->set("components|responses|pk_string|content|application/json|schema|format", "uuid");
            $this->openapi->set("components|responses|rows_affected|description", "number of rows affected (integer)");
            $this->openapi->set("components|responses|rows_affected|content|application/json|schema|type", "integer");
            $this->openapi->set("components|responses|rows_affected|content|application/json|schema|format", "int64");
            $tableReferences = $this->getAllTableReferences();
            foreach ($tableNames as $tableName) {
                $references = isset($tableReferences[$tableName]) ? $tableReferences[$tableName] : array();
                $this->setComponentSchema($tableName, $references);
                $this->setComponentResponse($tableName);
                $this->setComponentRequestBody($tableName);
            }
            $this->setComponentParameters();
            foreach ($tableNames as $index => $tableName) {
                $this->setTag($index, $tableName);
            }
        }

        private function isOperationOnTableAllowed(string $operation, string $tableName): bool
        {
            $tableHandler = VariableStore::get('authorization.tableHandler');
            if (!$tableHandler) {
                return true;
            }
            return (bool) call_user_func($tableHandler, $operation, $tableName);
        }

        private function isOperationOnColumnAllowed(string $operation, string $tableName, string $columnName): bool
        {
            $columnHandler = VariableStore::get('authorization.columnHandler');
            if (!$columnHandler) {
                return true;
            }
            return (bool) call_user_func($columnHandler, $operation, $tableName, $columnName);
        }

        private function setPath(string $tableName) /*: void*/
        {
            $normalizedTableName = $this->normalize($tableName);
            $table = $this->reflection->getTable($tableName);
            $type = $table->getType();
            $pk = $table->getPk();
            $pkName = $pk ? $pk->getName() : '';
            foreach ($this->operations as $operation => $method) {
                if (!$pkName && $operation != 'list') {
                    continue;
                }
                if ($type != 'table' && $operation != 'list') {
                    continue;
                }
                if (!$this->isOperationOnTableAllowed($operation, $tableName)) {
                    continue;
                }
                $parameters = [];
                if (in_array($operation, ['list', 'create'])) {
                    $path = sprintf('/records/%s', $tableName);
                    if ($operation == 'list') {
                        $parameters = ['filter', 'include', 'exclude', 'order', 'size', 'page', 'join'];
                    }
                } else {
                    $path = sprintf('/records/%s/{id}', $tableName);
                    if ($operation == 'read') {
                        $parameters = ['pk', 'include', 'exclude', 'join'];
                    } else {
                        $parameters = ['pk'];
                    }
                }
                foreach ($parameters as $p => $parameter) {
                    $this->openapi->set("paths|$path|$method|parameters|$p|\$ref", "#/components/parameters/$parameter");
                }
                if (in_array($operation, ['create', 'update', 'increment'])) {
                    $this->openapi->set("paths|$path|$method|requestBody|\$ref", "#/components/requestBodies/$operation-$normalizedTableName");
                }
                $this->openapi->set("paths|$path|$method|tags|0", "$tableName");
                $this->openapi->set("paths|$path|$method|operationId", "$operation" . "_" . "$normalizedTableName");
                $this->openapi->set("paths|$path|$method|description", "$operation $tableName");
                switch ($operation) {
                    case 'list':
                        $this->openapi->set("paths|$path|$method|responses|200|\$ref", "#/components/responses/$operation-$normalizedTableName");
                        break;
                    case 'create':
                        if ($pk->getType() == 'integer') {
                            $this->openapi->set("paths|$path|$method|responses|200|\$ref", "#/components/responses/pk_integer");
                        } else {
                            $this->openapi->set("paths|$path|$method|responses|200|\$ref", "#/components/responses/pk_string");
                        }
                        break;
                    case 'read':
                        $this->openapi->set("paths|$path|$method|responses|200|\$ref", "#/components/responses/$operation-$normalizedTableName");
                        break;
                    case 'update':
                    case 'delete':
                    case 'increment':
                        $this->openapi->set("paths|$path|$method|responses|200|\$ref", "#/components/responses/rows_affected");
                        break;
                }
            }
        }

        private function getPattern(ReflectedColumn $column): string
        {
            switch ($column->getType()) {
                case 'integer':
                    $n = strlen(pow(2, 31));
                    return '^-?[0-9]{1,' . $n . '}$';
                case 'bigint':
                    $n = strlen(pow(2, 63));
                    return '^-?[0-9]{1,' . $n . '}$';
                case 'varchar':
                    $l = $column->getLength();
                    return '^.{0,' . $l . '}$';
                case 'clob':
                    return '^.*$';
                case 'varbinary':
                    $l = $column->getLength();
                    $b = (int) 4 * ceil($l / 3);
                    return '^[A-Za-z0-9+/]{0,' . $b . '}=*$';
                case 'blob':
                    return '^[A-Za-z0-9+/]*=*$';
                case 'decimal':
                    $p = $column->getPrecision();
                    $s = $column->getScale();
                    return '^-?[0-9]{1,' . ($p - $s) . '}(\.[0-9]{1,' . $s . '})?$';
                case 'float':
                    return '^-?[0-9]+(\.[0-9]+)?([eE]-?[0-9]+)?$';
                case 'double':
                    return '^-?[0-9]+(\.[0-9]+)?([eE]-?[0-9]+)?$';
                case 'date':
                    return '^[0-9]{4}-[0-9]{2}-[0-9]{2}$';
                case 'time':
                    return '^[0-9]{2}:[0-9]{2}:[0-9]{2}$';
                case 'timestamp':
                    return '^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$';
                    return '';
                case 'geometry':
                    return '^(POINT|LINESTRING|POLYGON|MULTIPOINT|MULTILINESTRING|MULTIPOLYGON)\s*\(.*$';
                case 'boolean':
                    return '^(true|false)$';
            }
            return '';
        }

        private function setComponentSchema(string $tableName, array $references) /*: void*/
        {
            $normalizedTableName = $this->normalize($tableName);
            $table = $this->reflection->getTable($tableName);
            $type = $table->getType();
            $pk = $table->getPk();
            $pkName = $pk ? $pk->getName() : '';
            foreach ($this->operations as $operation => $method) {
                if (!$pkName && $operation != 'list') {
                    continue;
                }
                if ($type == 'view' && !in_array($operation, array('read', 'list'))) {
                    continue;
                }
                if ($type == 'view' && !$pkName && $operation == 'read') {
                    continue;
                }
                if ($operation == 'delete') {
                    continue;
                }
                if (!$this->isOperationOnTableAllowed($operation, $tableName)) {
                    continue;
                }
                if ($operation == 'list') {
                    $this->openapi->set("components|schemas|$operation-$normalizedTableName|type", "object");
                    $this->openapi->set("components|schemas|$operation-$normalizedTableName|properties|results|type", "integer");
                    $this->openapi->set("components|schemas|$operation-$normalizedTableName|properties|results|format", "int64");
                    $this->openapi->set("components|schemas|$operation-$normalizedTableName|properties|records|type", "array");
                    $prefix = "components|schemas|$operation-$normalizedTableName|properties|records|items";
                } else {
                    $prefix = "components|schemas|$operation-$normalizedTableName";
                }
                $this->openapi->set("$prefix|type", "object");
                foreach ($table->getColumnNames() as $columnName) {
                    if (!$this->isOperationOnColumnAllowed($operation, $tableName, $columnName)) {
                        continue;
                    }
                    $column = $table->getColumn($columnName);
                    $properties = $this->types[$column->getType()];
                    $properties['maxLength'] = $column->hasLength() ? $column->getLength() : 0;
                    $properties['nullable'] = $column->getNullable();
                    $properties['pattern'] = $this->getPattern($column);
                    foreach ($properties as $key => $value) {
                        if ($value) {
                            $this->openapi->set("$prefix|properties|$columnName|$key", $value);
                        }
                    }
                    if ($column->getPk()) {
                        $this->openapi->set("$prefix|properties|$columnName|x-primary-key", true);
                        $this->openapi->set("$prefix|properties|$columnName|x-referenced", $references);
                    }
                    $fk = $column->getFk();
                    if ($fk) {
                        $this->openapi->set("$prefix|properties|$columnName|x-references", $fk);
                    }
                }
            }
        }

        private function setComponentResponse(string $tableName) /*: void*/
        {
            $normalizedTableName = $this->normalize($tableName);
            $table = $this->reflection->getTable($tableName);
            $type = $table->getType();
            $pk = $table->getPk();
            $pkName = $pk ? $pk->getName() : '';
            foreach (['list', 'read'] as $operation) {
                if (!$pkName && $operation != 'list') {
                    continue;
                }
                if ($type != 'table' && $operation != 'list') {
                    continue;
                }
                if (!$this->isOperationOnTableAllowed($operation, $tableName)) {
                    continue;
                }
                if ($operation == 'list') {
                    $this->openapi->set("components|responses|$operation-$normalizedTableName|description", "list of $tableName records");
                } else {
                    $this->openapi->set("components|responses|$operation-$normalizedTableName|description", "single $tableName record");
                }
                $this->openapi->set("components|responses|$operation-$normalizedTableName|content|application/json|schema|\$ref", "#/components/schemas/$operation-$normalizedTableName");
            }
        }

        private function setComponentRequestBody(string $tableName) /*: void*/
        {
            $normalizedTableName = $this->normalize($tableName);
            $table = $this->reflection->getTable($tableName);
            $type = $table->getType();
            $pk = $table->getPk();
            $pkName = $pk ? $pk->getName() : '';
            if ($pkName && $type == 'table') {
                foreach (['create', 'update', 'increment'] as $operation) {
                    if (!$this->isOperationOnTableAllowed($operation, $tableName)) {
                        continue;
                    }
                    $this->openapi->set("components|requestBodies|$operation-$normalizedTableName|description", "single $tableName record");
                    $this->openapi->set("components|requestBodies|$operation-$normalizedTableName|content|application/json|schema|\$ref", "#/components/schemas/$operation-$normalizedTableName");
                }
            }
        }

        private function setComponentParameters() /*: void*/
        {
            $this->openapi->set("components|parameters|pk|name", "id");
            $this->openapi->set("components|parameters|pk|in", "path");
            $this->openapi->set("components|parameters|pk|schema|type", "string");
            $this->openapi->set("components|parameters|pk|description", "primary key value");
            $this->openapi->set("components|parameters|pk|required", true);

            $this->openapi->set("components|parameters|filter|name", "filter");
            $this->openapi->set("components|parameters|filter|in", "query");
            $this->openapi->set("components|parameters|filter|schema|type", "array");
            $this->openapi->set("components|parameters|filter|schema|items|type", "string");
            $this->openapi->set("components|parameters|filter|description", "Filters to be applied. Each filter consists of a column, an operator and a value (comma separated). Example: id,eq,1");
            $this->openapi->set("components|parameters|filter|required", false);

            $this->openapi->set("components|parameters|include|name", "include");
            $this->openapi->set("components|parameters|include|in", "query");
            $this->openapi->set("components|parameters|include|schema|type", "string");
            $this->openapi->set("components|parameters|include|description", "Columns you want to include in the output (comma separated). Example: posts.*,categories.name");
            $this->openapi->set("components|parameters|include|required", false);

            $this->openapi->set("components|parameters|exclude|name", "exclude");
            $this->openapi->set("components|parameters|exclude|in", "query");
            $this->openapi->set("components|parameters|exclude|schema|type", "string");
            $this->openapi->set("components|parameters|exclude|description", "Columns you want to exclude from the output (comma separated). Example: posts.content");
            $this->openapi->set("components|parameters|exclude|required", false);

            $this->openapi->set("components|parameters|order|name", "order");
            $this->openapi->set("components|parameters|order|in", "query");
            $this->openapi->set("components|parameters|order|schema|type", "array");
            $this->openapi->set("components|parameters|order|schema|items|type", "string");
            $this->openapi->set("components|parameters|order|description", "Column you want to sort on and the sort direction (comma separated). Example: id,desc");
            $this->openapi->set("components|parameters|order|required", false);

            $this->openapi->set("components|parameters|size|name", "size");
            $this->openapi->set("components|parameters|size|in", "query");
            $this->openapi->set("components|parameters|size|schema|type", "string");
            $this->openapi->set("components|parameters|size|description", "Maximum number of results (for top lists). Example: 10");
            $this->openapi->set("components|parameters|size|required", false);

            $this->openapi->set("components|parameters|page|name", "page");
            $this->openapi->set("components|parameters|page|in", "query");
            $this->openapi->set("components|parameters|page|schema|type", "string");
            $this->openapi->set("components|parameters|page|description", "Page number and page size (comma separated). Example: 1,10");
            $this->openapi->set("components|parameters|page|required", false);

            $this->openapi->set("components|parameters|join|name", "join");
            $this->openapi->set("components|parameters|join|in", "query");
            $this->openapi->set("components|parameters|join|schema|type", "array");
            $this->openapi->set("components|parameters|join|schema|items|type", "string");
            $this->openapi->set("components|parameters|join|description", "Paths (comma separated) to related entities that you want to include. Example: comments,users");
            $this->openapi->set("components|parameters|join|required", false);
        }

        private function setTag(int $index, string $tableName) /*: void*/
        {
            $this->openapi->set("tags|$index|name", "$tableName");
            $this->openapi->set("tags|$index|description", "$tableName operations");
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/OpenApi/OpenApiService.php
namespace Tqdev\PhpCrudApi\OpenApi {

    use Tqdev\PhpCrudApi\Column\ReflectionService;
    use Tqdev\PhpCrudApi\OpenApi\OpenApiBuilder;

    class OpenApiService
    {
        private $builder;

        public function __construct(ReflectionService $reflection, array $base, array $controllers, array $customBuilders)
        {
            $this->builder = new OpenApiBuilder($reflection, $base, $controllers, $customBuilders);
        }

        public function get(): OpenApiDefinition
        {
            return $this->builder->build();
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/OpenApi/OpenApiStatusBuilder.php
namespace Tqdev\PhpCrudApi\OpenApi {

    use Tqdev\PhpCrudApi\OpenApi\OpenApiDefinition;

    class OpenApiStatusBuilder
    {
        private $openapi;
        private $operations = [
            'status' => [
                'ping' => 'get',
            ],
        ];

        public function __construct(OpenApiDefinition $openapi)
        {
            $this->openapi = $openapi;
        }

        public function build() /*: void*/
        {
            $this->setPaths();
            $this->setComponentSchema();
            $this->setComponentResponse();
            foreach (array_keys($this->operations) as $index => $type) {
                $this->setTag($index, $type);
            }
        }

        private function setPaths() /*: void*/
        {
            foreach ($this->operations as $type => $operationPair) {
                foreach ($operationPair as $operation => $method) {
                    $path = "/$type/$operation";
                    $this->openapi->set("paths|$path|$method|tags|0", "$type");
                    $this->openapi->set("paths|$path|$method|operationId", "$operation" . "_" . "$type");
                    $this->openapi->set("paths|$path|$method|description", "Request API '$operation' status");
                    $this->openapi->set("paths|$path|$method|responses|200|\$ref", "#/components/responses/$operation-$type");

                }
            }
        }

        private function setComponentSchema() /*: void*/
        {
            foreach ($this->operations as $type => $operationPair) {
                foreach ($operationPair as $operation => $method) {
                    $prefix = "components|schemas|$operation-$type";
                    $this->openapi->set("$prefix|type", "object");
                    switch ($operation) {
                        case 'ping':
                            $this->openapi->set("$prefix|required", ['db', 'cache']);
                            $this->openapi->set("$prefix|properties|db|type", 'integer');
                            $this->openapi->set("$prefix|properties|db|format", "int64");
                            $this->openapi->set("$prefix|properties|cache|type", 'integer');
                            $this->openapi->set("$prefix|properties|cache|format", "int64");
                            break;
                    }
                }
            }
        }

        private function setComponentResponse() /*: void*/
        {
            foreach ($this->operations as $type => $operationPair) {
                foreach ($operationPair as $operation => $method) {
                    $this->openapi->set("components|responses|$operation-$type|description", "$operation status record");
                    $this->openapi->set("components|responses|$operation-$type|content|application/json|schema|\$ref", "#/components/schemas/$operation-$type");
                }
            }
        }

        private function setTag(int $index, string $type) /*: void*/
        {
            $this->openapi->set("tags|$index|name", "$type");
            $this->openapi->set("tags|$index|description", "$type operations");
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Record/Condition/AndCondition.php
namespace Tqdev\PhpCrudApi\Record\Condition {

    class AndCondition extends Condition
    {
        private $conditions;

        public function __construct(Condition $condition1, Condition $condition2)
        {
            $this->conditions = [$condition1, $condition2];
        }

        public function _and(Condition $condition): Condition
        {
            if ($condition instanceof NoCondition) {
                return $this;
            }
            $this->conditions[] = $condition;
            return $this;
        }

        public function getConditions(): array
        {
            return $this->conditions;
        }

        public static function fromArray(array $conditions): Condition
        {
            $condition = new NoCondition();
            foreach ($conditions as $c) {
                $condition = $condition->_and($c);
            }
            return $condition;
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Record/Condition/ColumnCondition.php
namespace Tqdev\PhpCrudApi\Record\Condition {

    use Tqdev\PhpCrudApi\Column\Reflection\ReflectedColumn;

    class ColumnCondition extends Condition
    {
        private $column;
        private $operator;
        private $value;

        public function __construct(ReflectedColumn $column, string $operator, string $value)
        {
            $this->column = $column;
            $this->operator = $operator;
            $this->value = $value;
        }

        public function getColumn(): ReflectedColumn
        {
            return $this->column;
        }

        public function getOperator(): string
        {
            return $this->operator;
        }

        public function getValue(): string
        {
            return $this->value;
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Record/Condition/Condition.php
namespace Tqdev\PhpCrudApi\Record\Condition {

    use Tqdev\PhpCrudApi\Column\Reflection\ReflectedTable;

    abstract class Condition
    {
        public function _and(Condition $condition): Condition
        {
            if ($condition instanceof NoCondition) {
                return $this;
            }
            return new AndCondition($this, $condition);
        }

        public function _or(Condition $condition): Condition
        {
            if ($condition instanceof NoCondition) {
                return $this;
            }
            return new OrCondition($this, $condition);
        }

        public function _not(): Condition
        {
            return new NotCondition($this);
        }

        public static function fromString(ReflectedTable $table, string $value): Condition
        {
            $condition = new NoCondition();
            $parts = explode(',', $value, 3);
            if (count($parts) < 2) {
                return $condition;
            }
            if (count($parts) < 3) {
                $parts[2] = '';
            }
            $field = $table->getColumn($parts[0]);
            $command = $parts[1];
            $negate = false;
            $spatial = false;
            if (strlen($command) > 2) {
                if (substr($command, 0, 1) == 'n') {
                    $negate = true;
                    $command = substr($command, 1);
                } else if (substr($command, 0, 1) == 's') {
                    $spatial = true;
                    $command = substr($command, 1);
                }
            }
            if ($spatial) {
                if (in_array($command, ['co', 'cr', 'di', 'eq', 'in', 'ov', 'to', 'wi', 'ic', 'is', 'iv'])) {
                    $condition = new SpatialCondition($field, $command, $parts[2]);
                }
            } else {
                if (in_array($command, ['cs', 'sw', 'ew', 'eq', 'lt', 'le', 'ge', 'gt', 'bt', 'in', 'is'])) {
                    $condition = new ColumnCondition($field, $command, $parts[2]);
                }
            }
            if ($negate) {
                $condition = $condition->_not();
            }
            return $condition;
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Record/Condition/NoCondition.php
namespace Tqdev\PhpCrudApi\Record\Condition {

    class NoCondition extends Condition
    {
        public function _and(Condition $condition): Condition
        {
            return $condition;
        }

        public function _or(Condition $condition): Condition
        {
            return $condition;
        }

        public function _not(): Condition
        {
            return $this;
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Record/Condition/NotCondition.php
namespace Tqdev\PhpCrudApi\Record\Condition {

    class NotCondition extends Condition
    {
        private $condition;

        public function __construct(Condition $condition)
        {
            $this->condition = $condition;
        }

        public function getCondition(): Condition
        {
            return $this->condition;
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Record/Condition/OrCondition.php
namespace Tqdev\PhpCrudApi\Record\Condition {

    class OrCondition extends Condition
    {
        private $conditions;

        public function __construct(Condition $condition1, Condition $condition2)
        {
            $this->conditions = [$condition1, $condition2];
        }

        public function _or(Condition $condition): Condition
        {
            if ($condition instanceof NoCondition) {
                return $this;
            }
            $this->conditions[] = $condition;
            return $this;
        }

        public function getConditions(): array
        {
            return $this->conditions;
        }

        public static function fromArray(array $conditions): Condition
        {
            $condition = new NoCondition();
            foreach ($conditions as $c) {
                $condition = $condition->_or($c);
            }
            return $condition;
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Record/Condition/SpatialCondition.php
namespace Tqdev\PhpCrudApi\Record\Condition {

    class SpatialCondition extends ColumnCondition
    {
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Record/Document/ErrorDocument.php
namespace Tqdev\PhpCrudApi\Record\Document {

    use Tqdev\PhpCrudApi\Record\ErrorCode;

    class ErrorDocument implements \JsonSerializable
    {
        public $errorCode;
        public $argument;
        public $details;

        public function __construct(ErrorCode $errorCode, string $argument, $details)
        {
            $this->errorCode = $errorCode;
            $this->argument = $argument;
            $this->details = $details;
        }

        public function getStatus(): int
        {
            return $this->errorCode->getStatus();
        }

        public function getCode(): int
        {
            return $this->errorCode->getCode();
        }

        public function getMessage(): string
        {
            return $this->errorCode->getMessage($this->argument);
        }

        public function serialize()
        {
            return [
                'code' => $this->getCode(),
                'message' => $this->getMessage(),
                'details' => $this->details,
            ];
        }

        public function jsonSerialize()
        {
            return array_filter($this->serialize(), function($v) {return $v!==null;});
        }

        public static function fromException(\Throwable $exception, bool $debug)
        {
            $document = new ErrorDocument(new ErrorCode(ErrorCode::ERROR_NOT_FOUND), $exception->getMessage(), null);
            if ($exception instanceof \PDOException) {
                if (strpos(strtolower($exception->getMessage()), 'duplicate') !== false) {
                    $document = new ErrorDocument(new ErrorCode(ErrorCode::DUPLICATE_KEY_EXCEPTION), '', null);
                } elseif (strpos(strtolower($exception->getMessage()), 'unique constraint') !== false) {
                    $document = new ErrorDocument(new ErrorCode(ErrorCode::DUPLICATE_KEY_EXCEPTION), '', null);
                } elseif (strpos(strtolower($exception->getMessage()), 'default value') !== false) {
                    $document = new ErrorDocument(new ErrorCode(ErrorCode::DATA_INTEGRITY_VIOLATION), '', null);
                } elseif (strpos(strtolower($exception->getMessage()), 'allow nulls') !== false) {
                    $document = new ErrorDocument(new ErrorCode(ErrorCode::DATA_INTEGRITY_VIOLATION), '', null);
                } elseif (strpos(strtolower($exception->getMessage()), 'constraint') !== false) {
                    $document = new ErrorDocument(new ErrorCode(ErrorCode::DATA_INTEGRITY_VIOLATION), '', null);
                } else {
                    $message = $debug?$exception->getMessage():'PDOException occurred (enable debug mode)';
                    $document = new ErrorDocument(new ErrorCode(ErrorCode::ERROR_NOT_FOUND), $message, null);
                }
            }
            return $document;
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Record/Document/ListDocument.php
namespace Tqdev\PhpCrudApi\Record\Document {

    class ListDocument implements \JsonSerializable
    {
        private $records;

        private $results;

        public function __construct(array $records, int $results)
        {
            $this->records = $records;
            $this->results = $results;
        }

        public function getRecords(): array
        {
            return $this->records;
        }

        public function getResults(): int
        {
            return $this->results;
        }

        public function serialize()
        {
            return [
                'records' => $this->records,
                'results' => $this->results,
            ];
        }

        public function jsonSerialize()
        {
            return array_filter($this->serialize(), function ($v) {
                return $v !== -1;
            });
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Record/ColumnIncluder.php
namespace Tqdev\PhpCrudApi\Record {

    use Tqdev\PhpCrudApi\Column\Reflection\ReflectedTable;

    class ColumnIncluder
    {
        private function isMandatory(string $tableName, string $columnName, array $params): bool
        {
            return isset($params['mandatory']) && in_array($tableName . "." . $columnName, $params['mandatory']);
        }

        private function select(
            string $tableName,
            bool $primaryTable,
            array $params,
            string $paramName,
            array $columnNames,
            bool $include
        ): array {
            if (!isset($params[$paramName])) {
                return $columnNames;
            }
            $columns = array();
            foreach (explode(',', $params[$paramName][0]) as $columnName) {
                $columns[$columnName] = true;
            }
            $result = array();
            foreach ($columnNames as $columnName) {
                $match = isset($columns['*.*']);
                if (!$match) {
                    $match = isset($columns[$tableName . '.*']) || isset($columns[$tableName . '.' . $columnName]);
                }
                if ($primaryTable && !$match) {
                    $match = isset($columns['*']) || isset($columns[$columnName]);
                }
                if ($match) {
                    if ($include || $this->isMandatory($tableName, $columnName, $params)) {
                        $result[] = $columnName;
                    }
                } else {
                    if (!$include || $this->isMandatory($tableName, $columnName, $params)) {
                        $result[] = $columnName;
                    }
                }
            }
            return $result;
        }

        public function getNames(ReflectedTable $table, bool $primaryTable, array $params): array
        {
            $tableName = $table->getName();
            $results = $table->getColumnNames();
            $results = $this->select($tableName, $primaryTable, $params, 'include', $results, true);
            $results = $this->select($tableName, $primaryTable, $params, 'exclude', $results, false);
            return $results;
        }

        public function getValues(ReflectedTable $table, bool $primaryTable, /* object */ $record, array $params): array
        {
            $results = array();
            $columnNames = $this->getNames($table, $primaryTable, $params);
            foreach ($columnNames as $columnName) {
                if (property_exists($record, $columnName)) {
                    $results[$columnName] = $record->$columnName;
                }
            }
            return $results;
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Record/ErrorCode.php
namespace Tqdev\PhpCrudApi\Record {

    use Tqdev\PhpCrudApi\ResponseFactory;

    class ErrorCode
    {
        private $code;
        private $message;
        private $status;

        const ERROR_NOT_FOUND = 9999;
        const ROUTE_NOT_FOUND = 1000;
        const TABLE_NOT_FOUND = 1001;
        const ARGUMENT_COUNT_MISMATCH = 1002;
        const RECORD_NOT_FOUND = 1003;
        const ORIGIN_FORBIDDEN = 1004;
        const COLUMN_NOT_FOUND = 1005;
        const TABLE_ALREADY_EXISTS = 1006;
        const COLUMN_ALREADY_EXISTS = 1007;
        const HTTP_MESSAGE_NOT_READABLE = 1008;
        const DUPLICATE_KEY_EXCEPTION = 1009;
        const DATA_INTEGRITY_VIOLATION = 1010;
        const AUTHENTICATION_REQUIRED = 1011;
        const AUTHENTICATION_FAILED = 1012;
        const INPUT_VALIDATION_FAILED = 1013;
        const OPERATION_FORBIDDEN = 1014;
        const OPERATION_NOT_SUPPORTED = 1015;
        const TEMPORARY_OR_PERMANENTLY_BLOCKED = 1016;
        const BAD_OR_MISSING_XSRF_TOKEN = 1017;
        const ONLY_AJAX_REQUESTS_ALLOWED = 1018;
        const PAGINATION_FORBIDDEN = 1019;
        const USER_ALREADY_EXIST = 1020;
        const PASSWORD_TOO_SHORT = 1021;

        private $values = [
            0000 => ["Success", ResponseFactory::OK],
            1000 => ["Route '%s' not found", ResponseFactory::NOT_FOUND],
            1001 => ["Table '%s' not found", ResponseFactory::NOT_FOUND],
            1002 => ["Argument count mismatch in '%s'", ResponseFactory::UNPROCESSABLE_ENTITY],
            1003 => ["Record '%s' not found", ResponseFactory::NOT_FOUND],
            1004 => ["Origin '%s' is forbidden", ResponseFactory::FORBIDDEN],
            1005 => ["Column '%s' not found", ResponseFactory::NOT_FOUND],
            1006 => ["Table '%s' already exists", ResponseFactory::CONFLICT],
            1007 => ["Column '%s' already exists", ResponseFactory::CONFLICT],
            1008 => ["Cannot read HTTP message", ResponseFactory::UNPROCESSABLE_ENTITY],
            1009 => ["Duplicate key exception", ResponseFactory::CONFLICT],
            1010 => ["Data integrity violation", ResponseFactory::CONFLICT],
            1011 => ["Authentication required", ResponseFactory::UNAUTHORIZED],
            1012 => ["Authentication failed for '%s'", ResponseFactory::FORBIDDEN],
            1013 => ["Input validation failed for '%s'", ResponseFactory::UNPROCESSABLE_ENTITY],
            1014 => ["Operation forbidden", ResponseFactory::FORBIDDEN],
            1015 => ["Operation '%s' not supported", ResponseFactory::METHOD_NOT_ALLOWED],
            1016 => ["Temporary or permanently blocked", ResponseFactory::FORBIDDEN],
            1017 => ["Bad or missing XSRF token", ResponseFactory::FORBIDDEN],
            1018 => ["Only AJAX requests allowed for '%s'", ResponseFactory::FORBIDDEN],
            1019 => ["Pagination forbidden", ResponseFactory::FORBIDDEN],
            1020 => ["User '%s' already exists", ResponseFactory::CONFLICT],
            1021 => ["Password too short (<%d characters)", ResponseFactory::UNPROCESSABLE_ENTITY],
            9999 => ["%s", ResponseFactory::INTERNAL_SERVER_ERROR],
        ];

        public function __construct(int $code)
        {
            if (!isset($this->values[$code])) {
                $code = 9999;
            }
            $this->code = $code;
            $this->message = $this->values[$code][0];
            $this->status = $this->values[$code][1];
        }

        public function getCode(): int
        {
            return $this->code;
        }

        public function getMessage(string $argument): string
        {
            return sprintf($this->message, $argument);
        }

        public function getStatus(): int
        {
            return $this->status;
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Record/FilterInfo.php
namespace Tqdev\PhpCrudApi\Record {

    use Tqdev\PhpCrudApi\Column\Reflection\ReflectedTable;
    use Tqdev\PhpCrudApi\Record\Condition\AndCondition;
    use Tqdev\PhpCrudApi\Record\Condition\Condition;
    use Tqdev\PhpCrudApi\Record\Condition\NoCondition;
    use Tqdev\PhpCrudApi\Record\Condition\OrCondition;

    class FilterInfo
    {
        private function getConditionsAsPathTree(ReflectedTable $table, array $params): PathTree
        {
            $conditions = new PathTree();
            foreach ($params as $key => $filters) {
                if (substr($key, 0, 6) == 'filter') {
                    preg_match_all('/\d+|\D+/', substr($key, 6), $matches);
                    $path = $matches[0];
                    foreach ($filters as $filter) {
                        $condition = Condition::fromString($table, $filter);
                        if (($condition instanceof NoCondition) == false) {
                            $conditions->put($path, $condition);
                        }
                    }
                }
            }
            return $conditions;
        }

        private function combinePathTreeOfConditions(PathTree $tree): Condition
        {
            $andConditions = $tree->getValues();
            $and = AndCondition::fromArray($andConditions);
            $orConditions = [];
            foreach ($tree->getKeys() as $p) {
                $orConditions[] = $this->combinePathTreeOfConditions($tree->get($p));
            }
            $or = OrCondition::fromArray($orConditions);
            return $and->_and($or);
        }

        public function getCombinedConditions(ReflectedTable $table, array $params): Condition
        {
            return $this->combinePathTreeOfConditions($this->getConditionsAsPathTree($table, $params));
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Record/HabtmValues.php
namespace Tqdev\PhpCrudApi\Record {

    class HabtmValues
    {
        public $pkValues;
        public $fkValues;

        public function __construct(array $pkValues, array $fkValues)
        {
            $this->pkValues = $pkValues;
            $this->fkValues = $fkValues;
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Record/OrderingInfo.php
namespace Tqdev\PhpCrudApi\Record {

    use Tqdev\PhpCrudApi\Column\Reflection\ReflectedTable;

    class OrderingInfo
    {
        public function getColumnOrdering(ReflectedTable $table, array $params): array
        {
            $fields = array();
            if (isset($params['order'])) {
                foreach ($params['order'] as $order) {
                    $parts = explode(',', $order, 3);
                    $columnName = $parts[0];
                    if (!$table->hasColumn($columnName)) {
                        continue;
                    }
                    $ascending = 'ASC';
                    if (count($parts) > 1) {
                        if (substr(strtoupper($parts[1]), 0, 4) == "DESC") {
                            $ascending = 'DESC';
                        }
                    }
                    $fields[] = [$columnName, $ascending];
                }
            }
            if (count($fields) == 0) {
                return $this->getDefaultColumnOrdering($table);
            }
            return $fields;
        }

        public function getDefaultColumnOrdering(ReflectedTable $table): array
        {
            $fields = array();
            $pk = $table->getPk();
            if ($pk) {
                $fields[] = [$pk->getName(), 'ASC'];
            } else {
                foreach ($table->getColumnNames() as $columnName) {
                    $fields[] = [$columnName, 'ASC'];
                }
            }
            return $fields;
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Record/PaginationInfo.php
namespace Tqdev\PhpCrudApi\Record {

    class PaginationInfo
    {
        public $DEFAULT_PAGE_SIZE = 20;

        public function hasPage(array $params): bool
        {
            return isset($params['page']);
        }

        public function getPageOffset(array $params): int
        {
            $offset = 0;
            $pageSize = $this->getPageSize($params);
            if (isset($params['page'])) {
                foreach ($params['page'] as $page) {
                    $parts = explode(',', $page, 2);
                    $page = intval($parts[0]) - 1;
                    $offset = $page * $pageSize;
                }
            }
            return $offset;
        }

        private function getPageSize(array $params): int
        {
            $pageSize = $this->DEFAULT_PAGE_SIZE;
            if (isset($params['page'])) {
                foreach ($params['page'] as $page) {
                    $parts = explode(',', $page, 2);
                    if (count($parts) > 1) {
                        $pageSize = intval($parts[1]);
                    }
                }
            }
            return $pageSize;
        }

        public function getResultSize(array $params): int
        {
            $numberOfRows = -1;
            if (isset($params['size'])) {
                foreach ($params['size'] as $size) {
                    $numberOfRows = intval($size);
                }
            }
            return $numberOfRows;
        }

        public function getPageLimit(array $params): int
        {
            $pageLimit = -1;
            if ($this->hasPage($params)) {
                $pageLimit = $this->getPageSize($params);
            }
            $resultSize = $this->getResultSize($params);
            if ($resultSize >= 0) {
                if ($pageLimit >= 0) {
                    $pageLimit = min($pageLimit, $resultSize);
                } else {
                    $pageLimit = $resultSize;
                }
            }
            return $pageLimit;
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Record/PathTree.php
namespace Tqdev\PhpCrudApi\Record {

    class PathTree implements \JsonSerializable
    {
        const WILDCARD = '*';

        private $tree;

        public function __construct(/* object */&$tree = null)
        {
            if (!$tree) {
                $tree = $this->newTree();
            }
            $this->tree = &$tree;
        }

        public function newTree()
        {
            return (object) ['values' => [], 'branches' => (object) []];
        }

        public function getKeys(): array
        {
            $branches = (array) $this->tree->branches;
            return array_keys($branches);
        }

        public function getValues(): array
        {
            return $this->tree->values;
        }

        public function get(string $key): PathTree
        {
            if (!isset($this->tree->branches->$key)) {
                return null;
            }
            return new PathTree($this->tree->branches->$key);
        }

        public function put(array $path, $value)
        {
            $tree = &$this->tree;
            foreach ($path as $key) {
                if (!isset($tree->branches->$key)) {
                    $tree->branches->$key = $this->newTree();
                }
                $tree = &$tree->branches->$key;
            }
            $tree->values[] = $value;
        }

        public function match(array $path): array
        {
            $star = self::WILDCARD;
            $tree = &$this->tree;
            foreach ($path as $key) {
                if (isset($tree->branches->$key)) {
                    $tree = &$tree->branches->$key;
                } elseif (isset($tree->branches->$star)) {
                    $tree = &$tree->branches->$star;
                } else {
                    return [];
                }
            }
            return $tree->values;
        }

        public static function fromJson(/* object */$tree): PathTree
        {
            return new PathTree($tree);
        }

        public function jsonSerialize()
        {
            return $this->tree;
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Record/RecordService.php
namespace Tqdev\PhpCrudApi\Record {

    use Tqdev\PhpCrudApi\Column\ReflectionService;
    use Tqdev\PhpCrudApi\Database\GenericDB;
    use Tqdev\PhpCrudApi\Record\Document\ListDocument;

    class RecordService
    {
        private $db;
        private $reflection;
        private $columns;
        private $joiner;
        private $filters;
        private $ordering;
        private $pagination;

        public function __construct(GenericDB $db, ReflectionService $reflection)
        {
            $this->db = $db;
            $this->reflection = $reflection;
            $this->columns = new ColumnIncluder();
            $this->joiner = new RelationJoiner($reflection, $this->columns);
            $this->filters = new FilterInfo();
            $this->ordering = new OrderingInfo();
            $this->pagination = new PaginationInfo();
        }

        private function sanitizeRecord(string $tableName, /* object */ $record, string $id)
        {
            $keyset = array_keys((array) $record);
            foreach ($keyset as $key) {
                if (!$this->reflection->getTable($tableName)->hasColumn($key)) {
                    unset($record->$key);
                }
            }
            if ($id != '') {
                $pk = $this->reflection->getTable($tableName)->getPk();
                foreach ($this->reflection->getTable($tableName)->getColumnNames() as $key) {
                    $field = $this->reflection->getTable($tableName)->getColumn($key);
                    if ($field->getName() == $pk->getName()) {
                        unset($record->$key);
                    }
                }
            }
        }

        public function hasTable(string $table): bool
        {
            return $this->reflection->hasTable($table);
        }

        public function getType(string $table): string
        {
            return $this->reflection->getType($table);
        }

        public function beginTransaction() /*: void*/
        {
            $this->db->beginTransaction();
        }

        public function commitTransaction() /*: void*/
        {
            $this->db->commitTransaction();
        }

        public function rollBackTransaction() /*: void*/
        {
            $this->db->rollBackTransaction();
        }

        public function create(string $tableName, /* object */ $record, array $params) /*: ?int*/
        {
            $this->sanitizeRecord($tableName, $record, '');
            $table = $this->reflection->getTable($tableName);
            $columnValues = $this->columns->getValues($table, true, $record, $params);
            return $this->db->createSingle($table, $columnValues);
        }

        public function read(string $tableName, string $id, array $params) /*: ?object*/
        {
            $table = $this->reflection->getTable($tableName);
            $this->joiner->addMandatoryColumns($table, $params);
            $columnNames = $this->columns->getNames($table, true, $params);
            $record = $this->db->selectSingle($table, $columnNames, $id);
            if ($record == null) {
                return null;
            }
            $records = array($record);
            $this->joiner->addJoins($table, $records, $params, $this->db);
            return $records[0];
        }

        public function update(string $tableName, string $id, /* object */ $record, array $params) /*: ?int*/
        {
            $this->sanitizeRecord($tableName, $record, $id);
            $table = $this->reflection->getTable($tableName);
            $columnValues = $this->columns->getValues($table, true, $record, $params);
            return $this->db->updateSingle($table, $columnValues, $id);
        }

        public function delete(string $tableName, string $id, array $params) /*: ?int*/
        {
            $table = $this->reflection->getTable($tableName);
            return $this->db->deleteSingle($table, $id);
        }

        public function increment(string $tableName, string $id, /* object */ $record, array $params) /*: ?int*/
        {
            $this->sanitizeRecord($tableName, $record, $id);
            $table = $this->reflection->getTable($tableName);
            $columnValues = $this->columns->getValues($table, true, $record, $params);
            return $this->db->incrementSingle($table, $columnValues, $id);
        }

        public function _list(string $tableName, array $params): ListDocument
        {
            $table = $this->reflection->getTable($tableName);
            $this->joiner->addMandatoryColumns($table, $params);
            $columnNames = $this->columns->getNames($table, true, $params);
            $condition = $this->filters->getCombinedConditions($table, $params);
            $columnOrdering = $this->ordering->getColumnOrdering($table, $params);
            if (!$this->pagination->hasPage($params)) {
                $offset = 0;
                $limit = $this->pagination->getPageLimit($params);
                $count = -1;
            } else {
                $offset = $this->pagination->getPageOffset($params);
                $limit = $this->pagination->getPageLimit($params);
                $count = $this->db->selectCount($table, $condition);
            }
            $records = $this->db->selectAll($table, $columnNames, $condition, $columnOrdering, $offset, $limit);
            $this->joiner->addJoins($table, $records, $params, $this->db);
            return new ListDocument($records, $count);
        }

        public function ping(): int
        {
            return $this->db->ping();
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Record/RelationJoiner.php
namespace Tqdev\PhpCrudApi\Record {

    use Tqdev\PhpCrudApi\Column\Reflection\ReflectedTable;
    use Tqdev\PhpCrudApi\Column\ReflectionService;
    use Tqdev\PhpCrudApi\Database\GenericDB;
    use Tqdev\PhpCrudApi\Middleware\Communication\VariableStore;
    use Tqdev\PhpCrudApi\Record\Condition\ColumnCondition;
    use Tqdev\PhpCrudApi\Record\Condition\OrCondition;

    class RelationJoiner
    {
        private $reflection;
        private $ordering;
        private $columns;

        public function __construct(ReflectionService $reflection, ColumnIncluder $columns)
        {
            $this->reflection = $reflection;
            $this->ordering = new OrderingInfo();
            $this->columns = $columns;
        }

        public function addMandatoryColumns(ReflectedTable $table, array &$params) /*: void*/
        {
            if (!isset($params['join']) || !isset($params['include'])) {
                return;
            }
            $params['mandatory'] = array();
            foreach ($params['join'] as $tableNames) {
                $t1 = $table;
                foreach (explode(',', $tableNames) as $tableName) {
                    if (!$this->reflection->hasTable($tableName)) {
                        continue;
                    }
                    $t2 = $this->reflection->getTable($tableName);
                    $fks1 = $t1->getFksTo($t2->getName());
                    $t3 = $this->hasAndBelongsToMany($t1, $t2);
                    if ($t3 != null || count($fks1) > 0) {
                        $params['mandatory'][] = $t2->getName() . '.' . $t2->getPk()->getName();
                    }
                    foreach ($fks1 as $fk) {
                        $params['mandatory'][] = $t1->getName() . '.' . $fk->getName();
                    }
                    $fks2 = $t2->getFksTo($t1->getName());
                    if ($t3 != null || count($fks2) > 0) {
                        $params['mandatory'][] = $t1->getName() . '.' . $t1->getPk()->getName();
                    }
                    foreach ($fks2 as $fk) {
                        $params['mandatory'][] = $t2->getName() . '.' . $fk->getName();
                    }
                    $t1 = $t2;
                }
            }
        }

        private function getJoinsAsPathTree(array $params): PathTree
        {
            $joins = new PathTree();
            if (isset($params['join'])) {
                foreach ($params['join'] as $tableNames) {
                    $path = array();
                    foreach (explode(',', $tableNames) as $tableName) {
                        if (!$this->reflection->hasTable($tableName)) {
                            continue;
                        }
                        $t = $this->reflection->getTable($tableName);
                        if ($t != null) {
                            $path[] = $t->getName();
                        }
                    }
                    $joins->put($path, true);
                }
            }
            return $joins;
        }

        public function addJoins(ReflectedTable $table, array &$records, array $params, GenericDB $db) /*: void*/
        {
            $joins = $this->getJoinsAsPathTree($params);
            $this->addJoinsForTables($table, $joins, $records, $params, $db);
        }

        private function hasAndBelongsToMany(ReflectedTable $t1, ReflectedTable $t2) /*: ?ReflectedTable*/
        {
            foreach ($this->reflection->getTableNames() as $tableName) {
                $t3 = $this->reflection->getTable($tableName);
                if (count($t3->getFksTo($t1->getName())) > 0 && count($t3->getFksTo($t2->getName())) > 0) {
                    return $t3;
                }
            }
            return null;
        }

        private function addJoinsForTables(ReflectedTable $t1, PathTree $joins, array &$records, array $params, GenericDB $db)
        {
            foreach ($joins->getKeys() as $t2Name) {
                $t2 = $this->reflection->getTable($t2Name);

                $belongsTo = count($t1->getFksTo($t2->getName())) > 0;
                $hasMany = count($t2->getFksTo($t1->getName())) > 0;
                if (!$belongsTo && !$hasMany) {
                    $t3 = $this->hasAndBelongsToMany($t1, $t2);
                } else {
                    $t3 = null;
                }
                $hasAndBelongsToMany = ($t3 != null);

                $newRecords = array();
                $fkValues = null;
                $pkValues = null;
                $habtmValues = null;

                if ($belongsTo) {
                    $fkValues = $this->getFkEmptyValues($t1, $t2, $records);
                    $this->addFkRecords($t2, $fkValues, $params, $db, $newRecords);
                }
                if ($hasMany) {
                    $pkValues = $this->getPkEmptyValues($t1, $records);
                    $this->addPkRecords($t1, $t2, $pkValues, $params, $db, $newRecords);
                }
                if ($hasAndBelongsToMany) {
                    $habtmValues = $this->getHabtmEmptyValues($t1, $t2, $t3, $db, $records);
                    $this->addFkRecords($t2, $habtmValues->fkValues, $params, $db, $newRecords);
                }

                $this->addJoinsForTables($t2, $joins->get($t2Name), $newRecords, $params, $db);

                if ($fkValues != null) {
                    $this->fillFkValues($t2, $newRecords, $fkValues);
                    $this->setFkValues($t1, $t2, $records, $fkValues);
                }
                if ($pkValues != null) {
                    $this->fillPkValues($t1, $t2, $newRecords, $pkValues);
                    $this->setPkValues($t1, $t2, $records, $pkValues);
                }
                if ($habtmValues != null) {
                    $this->fillFkValues($t2, $newRecords, $habtmValues->fkValues);
                    $this->setHabtmValues($t1, $t2, $records, $habtmValues);
                }
            }
        }

        private function getFkEmptyValues(ReflectedTable $t1, ReflectedTable $t2, array $records): array
        {
            $fkValues = array();
            $fks = $t1->getFksTo($t2->getName());
            foreach ($fks as $fk) {
                $fkName = $fk->getName();
                foreach ($records as $record) {
                    if (isset($record[$fkName])) {
                        $fkValue = $record[$fkName];
                        $fkValues[$fkValue] = null;
                    }
                }
            }
            return $fkValues;
        }

        private function addFkRecords(ReflectedTable $t2, array $fkValues, array $params, GenericDB $db, array &$records) /*: void*/
        {
            $columnNames = $this->columns->getNames($t2, false, $params);
            $fkIds = array_keys($fkValues);

            foreach ($db->selectMultiple($t2, $columnNames, $fkIds) as $record) {
                $records[] = $record;
            }
        }

        private function fillFkValues(ReflectedTable $t2, array $fkRecords, array &$fkValues) /*: void*/
        {
            $pkName = $t2->getPk()->getName();
            foreach ($fkRecords as $fkRecord) {
                $pkValue = $fkRecord[$pkName];
                $fkValues[$pkValue] = $fkRecord;
            }
        }

        private function setFkValues(ReflectedTable $t1, ReflectedTable $t2, array &$records, array $fkValues) /*: void*/
        {
            $fks = $t1->getFksTo($t2->getName());
            foreach ($fks as $fk) {
                $fkName = $fk->getName();
                foreach ($records as $i => $record) {
                    if (isset($record[$fkName])) {
                        $key = $record[$fkName];
                        $records[$i][$fkName] = $fkValues[$key];
                    }
                }
            }
        }

        private function getPkEmptyValues(ReflectedTable $t1, array $records): array
        {
            $pkValues = array();
            $pkName = $t1->getPk()->getName();
            foreach ($records as $record) {
                $key = $record[$pkName];
                $pkValues[$key] = array();
            }
            return $pkValues;
        }

        private function addPkRecords(ReflectedTable $t1, ReflectedTable $t2, array $pkValues, array $params, GenericDB $db, array &$records) /*: void*/
        {
            $fks = $t2->getFksTo($t1->getName());
            $columnNames = $this->columns->getNames($t2, false, $params);
            $pkValueKeys = implode(',', array_keys($pkValues));
            $conditions = array();
            foreach ($fks as $fk) {
                $conditions[] = new ColumnCondition($fk, 'in', $pkValueKeys);
            }
            $condition = OrCondition::fromArray($conditions);
            $columnOrdering = array();
            $limit = VariableStore::get("joinLimits.maxRecords") ?: -1;
            if ($limit != -1) {
                $columnOrdering = $this->ordering->getDefaultColumnOrdering($t2);
            }
            foreach ($db->selectAll($t2, $columnNames, $condition, $columnOrdering, 0, $limit) as $record) {
                $records[] = $record;
            }
        }

        private function fillPkValues(ReflectedTable $t1, ReflectedTable $t2, array $pkRecords, array &$pkValues) /*: void*/
        {
            $fks = $t2->getFksTo($t1->getName());
            foreach ($fks as $fk) {
                $fkName = $fk->getName();
                foreach ($pkRecords as $pkRecord) {
                    $key = $pkRecord[$fkName];
                    if (isset($pkValues[$key])) {
                        $pkValues[$key][] = $pkRecord;
                    }
                }
            }
        }

        private function setPkValues(ReflectedTable $t1, ReflectedTable $t2, array &$records, array $pkValues) /*: void*/
        {
            $pkName = $t1->getPk()->getName();
            $t2Name = $t2->getName();

            foreach ($records as $i => $record) {
                $key = $record[$pkName];
                $records[$i][$t2Name] = $pkValues[$key];
            }
        }

        private function getHabtmEmptyValues(ReflectedTable $t1, ReflectedTable $t2, ReflectedTable $t3, GenericDB $db, array $records): HabtmValues
        {
            $pkValues = $this->getPkEmptyValues($t1, $records);
            $fkValues = array();

            $fk1 = $t3->getFksTo($t1->getName())[0];
            $fk2 = $t3->getFksTo($t2->getName())[0];

            $fk1Name = $fk1->getName();
            $fk2Name = $fk2->getName();

            $columnNames = array($fk1Name, $fk2Name);

            $pkIds = implode(',', array_keys($pkValues));
            $condition = new ColumnCondition($t3->getColumn($fk1Name), 'in', $pkIds);
            $columnOrdering = array();

            $limit = VariableStore::get("joinLimits.maxRecords") ?: -1;
            if ($limit != -1) {
                $columnOrdering = $this->ordering->getDefaultColumnOrdering($t3);
            }
            $records = $db->selectAll($t3, $columnNames, $condition, $columnOrdering, 0, $limit);
            foreach ($records as $record) {
                $val1 = $record[$fk1Name];
                $val2 = $record[$fk2Name];
                $pkValues[$val1][] = $val2;
                $fkValues[$val2] = null;
            }

            return new HabtmValues($pkValues, $fkValues);
        }

        private function setHabtmValues(ReflectedTable $t1, ReflectedTable $t2, array &$records, HabtmValues $habtmValues) /*: void*/
        {
            $pkName = $t1->getPk()->getName();
            $t2Name = $t2->getName();
            foreach ($records as $i => $record) {
                $key = $record[$pkName];
                $val = array();
                $fks = $habtmValues->pkValues[$key];
                foreach ($fks as $fk) {
                    $val[] = $habtmValues->fkValues[$fk];
                }
                $records[$i][$t2Name] = $val;
            }
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Api.php
namespace Tqdev\PhpCrudApi {

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Psr\Http\Server\RequestHandlerInterface;
    use Tqdev\PhpCrudApi\Cache\CacheFactory;
    use Tqdev\PhpCrudApi\Column\DefinitionService;
    use Tqdev\PhpCrudApi\Column\ReflectionService;
    use Tqdev\PhpCrudApi\Controller\CacheController;
    use Tqdev\PhpCrudApi\Controller\ColumnController;
    use Tqdev\PhpCrudApi\Controller\GeoJsonController;
    use Tqdev\PhpCrudApi\Controller\JsonResponder;
    use Tqdev\PhpCrudApi\Controller\OpenApiController;
    use Tqdev\PhpCrudApi\Controller\RecordController;
    use Tqdev\PhpCrudApi\Controller\StatusController;
    use Tqdev\PhpCrudApi\Database\GenericDB;
    use Tqdev\PhpCrudApi\GeoJson\GeoJsonService;
    use Tqdev\PhpCrudApi\Middleware\AuthorizationMiddleware;
    use Tqdev\PhpCrudApi\Middleware\BasicAuthMiddleware;
    use Tqdev\PhpCrudApi\Middleware\CorsMiddleware;
    use Tqdev\PhpCrudApi\Middleware\CustomizationMiddleware;
    use Tqdev\PhpCrudApi\Middleware\DbAuthMiddleware;
    use Tqdev\PhpCrudApi\Middleware\FirewallMiddleware;
    use Tqdev\PhpCrudApi\Middleware\IpAddressMiddleware;
    use Tqdev\PhpCrudApi\Middleware\JoinLimitsMiddleware;
    use Tqdev\PhpCrudApi\Middleware\JsonMiddleware;
    use Tqdev\PhpCrudApi\Middleware\JwtAuthMiddleware;
    use Tqdev\PhpCrudApi\Middleware\MultiTenancyMiddleware;
    use Tqdev\PhpCrudApi\Middleware\PageLimitsMiddleware;
    use Tqdev\PhpCrudApi\Middleware\ReconnectMiddleware;
    use Tqdev\PhpCrudApi\Middleware\Router\SimpleRouter;
    use Tqdev\PhpCrudApi\Middleware\SanitationMiddleware;
    use Tqdev\PhpCrudApi\Middleware\SslRedirectMiddleware;
    use Tqdev\PhpCrudApi\Middleware\ValidationMiddleware;
    use Tqdev\PhpCrudApi\Middleware\XmlMiddleware;
    use Tqdev\PhpCrudApi\Middleware\XsrfMiddleware;
    use Tqdev\PhpCrudApi\OpenApi\OpenApiService;
    use Tqdev\PhpCrudApi\Record\ErrorCode;
    use Tqdev\PhpCrudApi\Record\RecordService;
    use Tqdev\PhpCrudApi\ResponseUtils;

    class Api implements RequestHandlerInterface
    {
        private $router;
        private $responder;
        private $debug;

        public function __construct(Config $config)
        {
            $db = new GenericDB(
                $config->getDriver(),
                $config->getAddress(),
                $config->getPort(),
                $config->getDatabase(),
                $config->getTables(),
                $config->getUsername(),
                $config->getPassword()
            );
            $prefix = sprintf('phpcrudapi-%s-', substr(md5(__FILE__), 0, 8));
            $cache = CacheFactory::create($config->getCacheType(), $prefix, $config->getCachePath());
            $reflection = new ReflectionService($db, $cache, $config->getCacheTime());
            $responder = new JsonResponder($config->getDebug());
            $router = new SimpleRouter($config->getBasePath(), $responder, $cache, $config->getCacheTime());
            foreach ($config->getMiddlewares() as $middleware => $properties) {
                switch ($middleware) {
                    case 'sslRedirect':
                        new SslRedirectMiddleware($router, $responder, $properties);
                        break;
                    case 'cors':
                        new CorsMiddleware($router, $responder, $properties, $config->getDebug());
                        break;
                    case 'firewall':
                        new FirewallMiddleware($router, $responder, $properties);
                        break;
                    case 'basicAuth':
                        new BasicAuthMiddleware($router, $responder, $properties);
                        break;
                    case 'jwtAuth':
                        new JwtAuthMiddleware($router, $responder, $properties);
                        break;
                    case 'dbAuth':
                        new DbAuthMiddleware($router, $responder, $properties, $reflection, $db);
                        break;
                    case 'reconnect':
                        new ReconnectMiddleware($router, $responder, $properties, $reflection, $db);
                        break;
                    case 'validation':
                        new ValidationMiddleware($router, $responder, $properties, $reflection);
                        break;
                    case 'ipAddress':
                        new IpAddressMiddleware($router, $responder, $properties, $reflection);
                        break;
                    case 'sanitation':
                        new SanitationMiddleware($router, $responder, $properties, $reflection);
                        break;
                    case 'multiTenancy':
                        new MultiTenancyMiddleware($router, $responder, $properties, $reflection);
                        break;
                    case 'authorization':
                        new AuthorizationMiddleware($router, $responder, $properties, $reflection);
                        break;
                    case 'xsrf':
                        new XsrfMiddleware($router, $responder, $properties);
                        break;
                    case 'pageLimits':
                        new PageLimitsMiddleware($router, $responder, $properties, $reflection);
                        break;
                    case 'joinLimits':
                        new JoinLimitsMiddleware($router, $responder, $properties, $reflection);
                        break;
                    case 'customization':
                        new CustomizationMiddleware($router, $responder, $properties, $reflection);
                        break;
                    case 'xml':
                        new XmlMiddleware($router, $responder, $properties, $reflection);
                        break;
                    case 'json':
                        new JsonMiddleware($router, $responder, $properties);
                        break;
                    }
            }
            foreach ($config->getControllers() as $controller) {
                switch ($controller) {
                    case 'records':
                        $records = new RecordService($db, $reflection);
                        new RecordController($router, $responder, $records);
                        break;
                    case 'columns':
                        $definition = new DefinitionService($db, $reflection);
                        new ColumnController($router, $responder, $reflection, $definition);
                        break;
                    case 'cache':
                        new CacheController($router, $responder, $cache);
                        break;
                    case 'openapi':
                        $openApi = new OpenApiService($reflection, $config->getOpenApiBase(), $config->getControllers(), $config->getCustomOpenApiBuilders());
                        new OpenApiController($router, $responder, $openApi);
                        break;
                    case 'geojson':
                        $records = new RecordService($db, $reflection);
                        $geoJson = new GeoJsonService($reflection, $records);
                        new GeoJsonController($router, $responder, $geoJson);
                        break;
                    case 'status':
                        new StatusController($router, $responder, $cache, $db);
                        break;                    
                }
            }
            foreach ($config->getCustomControllers() as $className) {
                if (class_exists($className)) {
                    $records = new RecordService($db, $reflection);
                    new $className($router, $responder, $records);
                }
            }
            $this->router = $router;
            $this->responder = $responder;
            $this->debug = $config->getDebug();
        }

        private function parseBody(string $body) /*: ?object*/
        {
            $first = substr($body, 0, 1);
            if ($first == '[' || $first == '{') {
                $object = json_decode($body);
                $causeCode = json_last_error();
                if ($causeCode !== JSON_ERROR_NONE) {
                    $object = null;
                }
            } else {
                parse_str($body, $input);
                foreach ($input as $key => $value) {
                    if (substr($key, -9) == '__is_null') {
                        $input[substr($key, 0, -9)] = null;
                        unset($input[$key]);
                    }
                }
                $object = (object) $input;
            }
            return $object;
        }

        private function addParsedBody(ServerRequestInterface $request): ServerRequestInterface
        {
            $parsedBody = $request->getParsedBody();
            if ($parsedBody) {
                $request = $this->applyParsedBodyHack($request);
            } else {
                $body = $request->getBody();
                if ($body->isReadable()) {
                    if ($body->isSeekable()) {
                        $body->rewind();
                    }
                    $contents = $body->getContents();
                    if ($body->isSeekable()) {
                        $body->rewind();
                    }
                    if ($contents) {
                        $parsedBody = $this->parseBody($contents);
                        $request = $request->withParsedBody($parsedBody);
                    }
                }
            }
            return $request;
        }

        private function applyParsedBodyHack(ServerRequestInterface $request): ServerRequestInterface
        {
            $parsedBody = $request->getParsedBody();
            if (is_array($parsedBody)) { // is it really?
                $contents = json_encode($parsedBody);
                $parsedBody = $this->parseBody($contents);
                $request = $request->withParsedBody($parsedBody);
            }
            return $request;
        }

        public function handle(ServerRequestInterface $request): ResponseInterface
        {
            return $this->router->route($this->addParsedBody($request));
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/Config.php
namespace Tqdev\PhpCrudApi {

    class Config
    {
        private $values = [
            'driver' => null,
            'address' => 'localhost',
            'port' => null,
            'username' => null,
            'password' => null,
            'database' => null,
            'tables' => '',
            'middlewares' => 'cors,errors',
            'controllers' => 'records,geojson,openapi,status',
            'customControllers' => '',
            'customOpenApiBuilders' => '',
            'cacheType' => 'TempFile',
            'cachePath' => '',
            'cacheTime' => 10,
            'debug' => false,
            'basePath' => '',
            'openApiBase' => '{"info":{"title":"PHP-CRUD-API","version":"1.0.0"}}',
        ];

        private function getDefaultDriver(array $values): string
        {
            if (isset($values['driver'])) {
                return $values['driver'];
            }
            return 'mysql';
        }

        private function getDefaultPort(string $driver): int
        {
            switch ($driver) {
                case 'mysql':
                    return 3306;
                case 'pgsql':
                    return 5432;
                case 'sqlsrv':
                    return 1433;
                case 'sqlite':
                    return 0;
            }
        }

        private function getDefaultAddress(string $driver): string
        {
            switch ($driver) {
                case 'mysql':
                    return 'localhost';
                case 'pgsql':
                    return 'localhost';
                case 'sqlsrv':
                    return 'localhost';
                case 'sqlite':
                    return 'data.db';
            }
        }

        private function getDriverDefaults(string $driver): array
        {
            return [
                'driver' => $driver,
                'address' => $this->getDefaultAddress($driver),
                'port' => $this->getDefaultPort($driver),
            ];
        }

        private function applyEnvironmentVariables(array $values): array
        {
            $newValues = array();
            foreach ($values as $key => $value) {
                $environmentKey = 'PHP_CRUD_API_' . strtoupper(preg_replace('/(?<!^)[A-Z]/', '_$0', str_replace('.', '_', $key)));
                $newValues[$key] = getenv($environmentKey, true) ?: $value;
            }
            return $newValues;
        }

        public function __construct(array $values)
        {
            $driver = $this->getDefaultDriver($values);
            $defaults = $this->getDriverDefaults($driver);
            $newValues = array_merge($this->values, $defaults, $values);
            $newValues = $this->parseMiddlewares($newValues);
            $diff = array_diff_key($newValues, $this->values);
            if (!empty($diff)) {
                $key = array_keys($diff)[0];
                throw new \Exception("Config has invalid value '$key'");
            }
            $newValues = $this->applyEnvironmentVariables($newValues);
            $this->values = $newValues;
        }

        private function parseMiddlewares(array $values): array
        {
            $newValues = array();
            $properties = array();
            $middlewares = array_map('trim', explode(',', $values['middlewares']));
            foreach ($middlewares as $middleware) {
                $properties[$middleware] = [];
            }
            foreach ($values as $key => $value) {
                if (strpos($key, '.') === false) {
                    $newValues[$key] = $value;
                } else {
                    list($middleware, $key2) = explode('.', $key, 2);
                    if (isset($properties[$middleware])) {
                        $properties[$middleware][$key2] = $value;
                    } else {
                        throw new \Exception("Config has invalid value '$key'");
                    }
                }
            }
            $newValues['middlewares'] = array_reverse($properties, true);
            return $newValues;
        }

        public function getDriver(): string
        {
            return $this->values['driver'];
        }

        public function getAddress(): string
        {
            return $this->values['address'];
        }

        public function getPort(): int
        {
            return $this->values['port'];
        }

        public function getUsername(): string
        {
            return $this->values['username'];
        }

        public function getPassword(): string
        {
            return $this->values['password'];
        }

        public function getDatabase(): string
        {
            return $this->values['database'];
        }

        public function getTables(): array
        {
            return array_filter(array_map('trim', explode(',', $this->values['tables'])));
        }

        public function getMiddlewares(): array
        {
            return $this->values['middlewares'];
        }

        public function getControllers(): array
        {
            return array_filter(array_map('trim', explode(',', $this->values['controllers'])));
        }

        public function getCustomControllers(): array
        {
            return array_filter(array_map('trim', explode(',', $this->values['customControllers'])));
        }

        public function getCustomOpenApiBuilders(): array
        {
            return array_filter(array_map('trim', explode(',', $this->values['customOpenApiBuilders'])));
        }

        public function getCacheType(): string
        {
            return $this->values['cacheType'];
        }

        public function getCachePath(): string
        {
            return $this->values['cachePath'];
        }

        public function getCacheTime(): int
        {
            return $this->values['cacheTime'];
        }

        public function getDebug(): bool
        {
            return $this->values['debug'];
        }

        public function getBasePath(): string
        {
            return $this->values['basePath'];
        }

        public function getOpenApiBase(): array
        {
            return json_decode($this->values['openApiBase'], true);
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/RequestFactory.php
namespace Tqdev\PhpCrudApi {

    use Nyholm\Psr7\Factory\Psr17Factory;
    use Nyholm\Psr7Server\ServerRequestCreator;
    use Psr\Http\Message\ServerRequestInterface;

    class RequestFactory
    {
        public static function fromGlobals(): ServerRequestInterface
        {
            $psr17Factory = new Psr17Factory();
            $creator = new ServerRequestCreator($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);
            $serverRequest = $creator->fromGlobals();
            $stream = $psr17Factory->createStreamFromFile('php://input');
            $serverRequest = $serverRequest->withBody($stream);
            return $serverRequest;
        }

        public static function fromString(string $request): ServerRequestInterface
        {
            $parts = explode("\n\n", trim($request), 2);
            $lines = explode("\n", $parts[0]);
            $first = explode(' ', trim(array_shift($lines)), 2);
            $method = $first[0];
            $body = isset($parts[1]) ? $parts[1] : '';
            $url = isset($first[1]) ? $first[1] : '';

            $psr17Factory = new Psr17Factory();
            $serverRequest = $psr17Factory->createServerRequest($method, $url);
            foreach ($lines as $line) {
                list($key, $value) = explode(':', $line, 2);
                $serverRequest = $serverRequest->withAddedHeader($key, $value);
            }
            if ($body) {
                $stream = $psr17Factory->createStream($body);
                $stream->rewind();
                $serverRequest = $serverRequest->withBody($stream);
            }
            return $serverRequest;
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/RequestUtils.php
namespace Tqdev\PhpCrudApi {

    use Psr\Http\Message\ServerRequestInterface;
    use Tqdev\PhpCrudApi\Column\ReflectionService;

    class RequestUtils
    {
        public static function setParams(ServerRequestInterface $request, array $params): ServerRequestInterface
        {
            $query = preg_replace('|%5B[0-9]+%5D=|', '=', http_build_query($params));
            return $request->withUri($request->getUri()->withQuery($query));
        }

        public static function getHeader(ServerRequestInterface $request, string $header): string
        {
            $headers = $request->getHeader($header);
            return isset($headers[0]) ? $headers[0] : '';
        }

        public static function getParams(ServerRequestInterface $request): array
        {
            $params = array();
            $query = $request->getUri()->getQuery();
            //$query = str_replace('][]=', ']=', str_replace('=', '[]=', $query));
            $query = str_replace('%5D%5B%5D=', '%5D=', str_replace('=', '%5B%5D=', $query));
            parse_str($query, $params);
            return $params;
        }

        public static function getPathSegment(ServerRequestInterface $request, int $part): string
        {
            $path = $request->getUri()->getPath();
            $pathSegments = explode('/', rtrim($path, '/'));
            if ($part < 0 || $part >= count($pathSegments)) {
                return '';
            }
            return urldecode($pathSegments[$part]);
        }

        public static function getOperation(ServerRequestInterface $request): string
        {
            $method = $request->getMethod();
            $path = RequestUtils::getPathSegment($request, 1);
            $hasPk = RequestUtils::getPathSegment($request, 3) != '';
            switch ($path) {
                case 'openapi':
                    return 'document';
                case 'columns':
                    return $method == 'get' ? 'reflect' : 'remodel';
                case 'geojson':
                case 'records':
                    switch ($method) {
                        case 'POST':
                            return 'create';
                        case 'GET':
                            return $hasPk ? 'read' : 'list';
                        case 'PUT':
                            return 'update';
                        case 'DELETE':
                            return 'delete';
                        case 'PATCH':
                            return 'increment';
                    }
            }
            return 'unknown';
        }

        private static function getJoinTables(string $tableName, array $parameters): array
        {
            $uniqueTableNames = array();
            $uniqueTableNames[$tableName] = true;
            if (isset($parameters['join'])) {
                foreach ($parameters['join'] as $parameter) {
                    $tableNames = explode(',', trim($parameter));
                    foreach ($tableNames as $tableName) {
                        $uniqueTableNames[$tableName] = true;
                    }
                }
            }
            return array_keys($uniqueTableNames);
        }

        public static function getTableNames(ServerRequestInterface $request, ReflectionService $reflection): array
        {
            $path = RequestUtils::getPathSegment($request, 1);
            $tableName = RequestUtils::getPathSegment($request, 2);
            $allTableNames = $reflection->getTableNames();
            switch ($path) {
                case 'openapi':
                    return $allTableNames;
                case 'columns':
                    return $tableName ? [$tableName] : $allTableNames;
                case 'records':
                    return self::getJoinTables($tableName, RequestUtils::getParams($request));
            }
            return $allTableNames;
        }

        public static function toString(ServerRequestInterface $request): string
        {
            $method = $request->getMethod();
            $uri = $request->getUri()->__toString();
            $headers = $request->getHeaders();
            $request->getBody()->rewind();
            $body = $request->getBody()->getContents();

            $str = "$method $uri\n";
            foreach ($headers as $key => $values) {
                foreach ($values as $value) {
                    $str .= "$key: $value\n";
                }
            }
            if ($body !== '') {
                $str .= "\n";
                $str .= "$body\n";
            }
            return $str;
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/ResponseFactory.php
namespace Tqdev\PhpCrudApi {

    use Nyholm\Psr7\Factory\Psr17Factory;
    use Psr\Http\Message\ResponseInterface;

    class ResponseFactory
    {
        const OK = 200;
        const MOVED_PERMANENTLY = 301;
        const FOUND = 302;
        const UNAUTHORIZED = 401;
        const FORBIDDEN = 403;
        const NOT_FOUND = 404;
        const METHOD_NOT_ALLOWED = 405;
        const CONFLICT = 409;
        const UNPROCESSABLE_ENTITY = 422;
        const FAILED_DEPENDENCY = 424;
        const INTERNAL_SERVER_ERROR = 500;

        public static function fromXml(int $status, string $xml): ResponseInterface
        {
            return self::from($status, 'text/xml', $xml);
        }

        public static function fromCsv(int $status, string $csv): ResponseInterface
        {
            return self::from($status, 'text/csv', $csv);
        }

        public static function fromHtml(int $status, string $html): ResponseInterface
        {
            return self::from($status, 'text/html', $html);
        }

        public static function fromObject(int $status, $body): ResponseInterface
        {
            $content = json_encode($body, JSON_UNESCAPED_UNICODE);
            return self::from($status, 'application/json', $content);
        }

        public static function from(int $status, string $contentType, string $content): ResponseInterface
        {
            $psr17Factory = new Psr17Factory();
            $response = $psr17Factory->createResponse($status);
            $stream = $psr17Factory->createStream($content);
            $stream->rewind();
            $response = $response->withBody($stream);
            $response = $response->withHeader('Content-Type', $contentType . '; charset=utf-8');
            $response = $response->withHeader('Content-Length', strlen($content));
            return $response;
        }

        public static function fromStatus(int $status): ResponseInterface
        {
            $psr17Factory = new Psr17Factory();
            return $psr17Factory->createResponse($status);
        }
    }
}

// file: vendor/mevdschee/php-crud-api/src/Tqdev/PhpCrudApi/ResponseUtils.php
namespace Tqdev\PhpCrudApi {

    use Psr\Http\Message\ResponseInterface;

    class ResponseUtils
    {
        public static function output(ResponseInterface $response)
        {
            $status = $response->getStatusCode();
            $headers = $response->getHeaders();
            $body = $response->getBody()->getContents();

            http_response_code($status);
            foreach ($headers as $key => $values) {
                foreach ($values as $value) {
                    header("$key: $value");
                }
            }
            echo $body;
        }

        public static function addExceptionHeaders(ResponseInterface $response, \Throwable $e): ResponseInterface
        {
            $response = $response->withHeader('X-Exception-Name', get_class($e));
            $response = $response->withHeader('X-Exception-Message', preg_replace('|\n|', ' ', trim($e->getMessage())));
            $response = $response->withHeader('X-Exception-File', $e->getFile() . ':' . $e->getLine());
            return $response;
        }

        public static function toString(ResponseInterface $response): string
        {
            $status = $response->getStatusCode();
            $headers = $response->getHeaders();
            $response->getBody()->rewind();
            $body = $response->getBody()->getContents();

            $str = "$status\n";
            foreach ($headers as $key => $values) {
                foreach ($values as $value) {
                    $str .= "$key: $value\n";
                }
            }
            if ($body !== '') {
                $str .= "\n";
                $str .= "$body\n";
            }
            return $str;
        }
    }
}

// file: src/Tqdev/PhpCrudUi/Client/ApiCaller.php
namespace Tqdev\PhpCrudUi\Client {

    interface ApiCaller
    {
        function call(string $method, string $path, array $args = [], $data = false);
    }
}

// file: src/Tqdev/PhpCrudUi/Client/CrudApi.php
namespace Tqdev\PhpCrudUi\Client {

    class CrudApi
    {
        private $caller;

        public function __construct(ApiCaller $caller)
        {
            $this->caller = $caller;
        }

        public function getOpenApi()
        {
            return $this->caller->call('GET', '/openapi');
        }

        public function listRecords(string $table, array $args)
        {
            return $this->caller->call('GET', '/records/' . rawurlencode($table), $args);
        }

        public function readRecord(string $table, string $id, array $args)
        {
            return $this->caller->call('GET', '/records/' . rawurlencode($table) . '/' . rawurlencode($id), $args);
        }

        public function createRecord(string $table, $record)
        {
            return $this->caller->call('POST', '/records/' . rawurlencode($table), [], $record);
        }

        public function deleteRecord(string $table, string $id)
        {
            return $this->caller->call('DELETE', '/records/' . rawurlencode($table) . '/' . rawurlencode($id));
        }

        public function updateRecord(string $table, string $id, $record)
        {
            return $this->caller->call('PUT', '/records/' . rawurlencode($table) . '/' . rawurlencode($id), [], $record);
        }
    }
}

// file: src/Tqdev/PhpCrudUi/Client/CurlCaller.php
namespace Tqdev\PhpCrudUi\Client {

    class CurlCaller implements ApiCaller
    {
        private $url;

        public function __construct(string $url)
        {
            $this->url = $url;
        }

        public function call(string $method, string $path, array $args = [], $data = false)
        {
            $query = rtrim('?' . preg_replace('|%5B[0-9]+%5D|', '', http_build_query($args)), '?');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($ch, CURLOPT_URL, $this->url . $path . $query);
            if ($data) {
                $content = json_encode($data);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
                $headers = array();
                $headers[] = 'Content-Type: application/json';
                $headers[] = 'Content-Length: ' . strlen($content);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            }
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            return json_decode($response, true);
        }
    }
}

// file: src/Tqdev/PhpCrudUi/Client/LocalCaller.php
namespace Tqdev\PhpCrudUi\Client {

    use Tqdev\PhpCrudApi\Api;
    use Tqdev\PhpCrudApi\Config;
    use Tqdev\PhpCrudApi\RequestFactory;

    class LocalCaller implements ApiCaller
    {
        private $config;

        public function __construct(array $config)
        {
            $this->config = $config;
        }

        public function call(string $method, string $path, array $args = [], $data = false)
        {
            $query = rtrim('?' . preg_replace('|%5B[0-9]+%5D|', '', http_build_query($args)), '?');
            $config = new Config($this->config);
            $body = '';
            if ($data !== false) {
                $body = json_encode($data);
            }
            $request = RequestFactory::fromString(trim("$method $path$query\n\n$body"));
            $api = new Api($config);
            $response = $api->handle($request);
            return json_decode($response->getBody(), true);
        }
    }
}

// file: src/Tqdev/PhpCrudUi/Column/SpecificationService.php
namespace Tqdev\PhpCrudUi\Column {

    use Tqdev\PhpCrudApi\Cache\Cache;
    use Tqdev\PhpCrudUi\Client\CrudApi;

    class SpecificationService
    {
        private $api;
        private $cache;
        private $ttl;

        public function __construct(CrudApi $api, Cache $cache, int $ttl)
        {
            $this->api = $api;
            $this->cache = $cache;
            $this->ttl = $ttl;
            $this->definition = $this->getDefinition();
            $this->properties = array();
        }

        private function getDefinition(): array
        {
            $data = $this->cache->get('Definition');
            if ($data) {
                $result = json_decode(gzuncompress($data), true);
            } else {
                $result = $this->api->getOpenApi();
                if ($result) {
                    $data = gzcompress(json_encode($result));
                    $this->cache->set('Definition', $data, $this->ttl);
                } else {
                    $result = [];
                }
            }
            return $result;
        }

        private function resolve($path)
        {
            $definition = $this->definition;
            while (null !== ($element = array_shift($path))) {
                if (!isset($definition[$element])) {
                    return false;
                }
                $definition = $definition[$element];
            }
            return $definition;
        }

        private function getProperties(string $table, string $action)
        {
            $key = $action . '-' . $table;
            if (!isset($this->properties[$key])) {
                if ($action == 'list') {
                    $path = array('components', 'schemas', $key, 'properties', 'records', 'items', 'properties');
                } else {
                    $path = array('components', 'schemas', $key, 'properties');
                }
                $this->properties[$key] = $this->resolve($path);
            }
            return $this->properties[$key];
        }

        public function hasTable(string $table, string $action): bool
        {
            return (bool) $this->getProperties($table, $action);
        }

        public function getReferences(string $table, string $action)
        {
            $properties = $this->getProperties($table, $action);

            $references = array();
            foreach ($properties as $field => $property) {
                $references[$field] = isset($property['x-references']) ? $property['x-references'] : false;
            }
            return $references;
        }

        public function getTypes(string $table, string $action)
        {
            $properties = $this->getProperties($table, $action);

            $types = array();
            foreach ($properties as $field => $property) {
                $type = $property['type'];
                $nullable = isset($property['nullable']) ? $property['nullable'] : false;
                $format = isset($property['format']) ? $property['format'] : $property['type'];
                $maxLength = isset($property['maxLength']) ? $property['maxLength'] : 0;
                $pattern = $property['pattern'];
                $hint = '';

                switch ($format) {
                    case 'timestamp':
                        $hint = 'yyyy-mm-dd hh:mm:ss';
                        $maxLength = 19;
                        break;
                    case 'date':
                        $hint = 'yyyy-mm-dd';
                        $maxLength = 10;
                        break;
                    case 'time':
                        $hint = 'hh:mm:ss';
                        $maxLength = 8;
                        break;
                    case 'decimal':
                        if (preg_match_all('/{1,([0-9]+)}/', $pattern, $matches) == 2) {
                            $maxLength = array_sum($matches[1]) + 2;
                            $decimals = $matches[1][1];
                            $hint = '#.' . str_repeat('#', $decimals);
                        }
                        break;
                    case 'color':
                        $pattern = '/^#?[0-9a-fA-F]{6}$/';
                        $hint = '#3399ff';
                        $maxLength = 7;
                        break;
                    case 'email':
                        $pattern = '/^.+@[^\.].*\.[a-z]{2,}$/';
                        $hint = 'xxx@xxx.xxx';
                        break;
                    case 'url':
                        $pattern = '/^(ftp|http|https):\/\/.*$/';
                        $hint = 'https://...';
                        break;
                    case 'point':
                        $pattern = '/^POINT\s?\(.*\)$/';
                        $hint = 'POINT(lon lat)';
                        break;
                    case 'polygon':
                        $pattern = '/^POLYGON\s?\(\(.*\)\)$/';
                        $hint = 'POLYGON((lon1 lat1,lon2 lat2,lon3 lat3,lon1 lat1))';
                        break;
                }
                $types[$field] = [
                    'type' => $type,
                    'nullable' => $nullable,
                    'format' => $format,
                    'maxLength' => $maxLength,
                    'hint' => $hint,
                    'pattern' => $pattern,
                ];
            }
            return $types;
        }

        public function getReferenced(string $table, string $action)
        {
            $properties = $this->getProperties($table, $action);

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

        public function getPrimaryKey(string $table, string $action)
        {
            $properties = $this->getProperties($table, $action);

            foreach ($properties as $field => $property) {
                if (isset($property['x-primary-key'])) {
                    return $field;
                }
            }
            return false;
        }

        private function getDisplayColumn(string $table, string $action)
        {
            $properties = $this->getProperties($table, $action);

            foreach ($properties as $field => $property) {
                if ($property['type'] == 'string') {
                    return $field;
                }
            }
            return false;
        }

        public function getColumnPair(string $table)
        {
            $primaryKey = $this->getPrimaryKey($table, 'list');
            $displayColumn = $this->getDisplayColumn($table, 'list');
            return array($primaryKey, $displayColumn);
        }

        public function getColumns(string $table, string $action): array
        {
            $properties = $this->getProperties($table, $action);
            return array_keys($properties);
        }

        public function getInfo()
        {
            $info = array();
            if (isset($this->definition['info'])) {
                $info = $this->definition['info'];
                if (!isset($info['title'])) {
                    $info['title'] = 'PHP-CRUD-UI';
                }
                if (!isset($info['x-subtitle'])) {
                    $info['x-subtitle'] = 'by TQdev.com';
                }
            }
            return $info;
        }

        public function getMenu()
        {
            $items = array();
            if (isset($this->definition['tags'])) {
                foreach ($this->definition['tags'] as $tag) {
                    array_push($items, $tag['name']);
                }
            }
            return $items;
        }

        public function referenceText(string $table, /* object */ $record)
        {
            if (!$record) {
                return '';
            }
            $displayColumn = $this->getDisplayColumn($table, 'read');
            return $record[$displayColumn];
        }

        public function referenceId(string $table, /* object */ $record)
        {
            if (!$record) {
                return null;
            }
            $primaryKey = $this->getPrimaryKey($table, 'read');
            return $record[$primaryKey];
        }
    }
}

// file: src/Tqdev/PhpCrudUi/Controller/MultiResponder.php
namespace Tqdev\PhpCrudUi\Controller {

    use Psr\Http\Message\ResponseInterface;
    use Tqdev\PhpCrudApi\Controller\Responder;
    use Tqdev\PhpCrudApi\Record\Document\ErrorDocument;
    use Tqdev\PhpCrudApi\Record\ErrorCode;
    use Tqdev\PhpCrudApi\ResponseFactory;
    use Tqdev\PhpCrudUi\Document\CsvDocument;
    use Tqdev\PhpCrudUi\Document\JsonDocument;
    use Tqdev\PhpCrudUi\Document\RedirectDocument;
    use Tqdev\PhpCrudUi\Document\TemplateDocument;

    class MultiResponder implements Responder
    {
        private $variables;
        private $templatePath;

        public function __construct(string $templatePath)
        {
            $this->variables = array();
            $this->templatePath = $templatePath;
        }

        public function setVariable(string $name, $value)
        {
            $this->variables[$name] = $value;
        }

        public function error(int $error, string $argument, $details = null): ResponseInterface
        {
            $errorCode = new ErrorCode($error);
            $status = $errorCode->getStatus();
            $document = new ErrorDocument($errorCode, $argument, $details);
            $result = new TemplateDocument('layouts/error', 'error/show', $document->serialize());
            $result->addVariables($this->variables);
            $result->setTemplatePath($this->templatePath);
            return ResponseFactory::fromHtml($status, (string) $result);
        }

        public function success($result): ResponseInterface
        {
            if ($result instanceof CsvDocument) {
                return ResponseFactory::fromCsv(ResponseFactory::OK, (string) $result);
            } elseif ($result instanceof JsonDocument) {
                return ResponseFactory::fromObject(ResponseFactory::OK, json_decode((string) $result));
            } elseif ($result instanceof TemplateDocument) {
                $result->addVariables($this->variables);
                $result->setTemplatePath($this->templatePath);
                return ResponseFactory::fromHtml(ResponseFactory::OK, (string) $result);
            } elseif ($result instanceof RedirectDocument) {
                $result->addVariables($this->variables);
                $response = ResponseFactory::fromStatus(ResponseFactory::FOUND);
                return $response->withHeader('Location', (string) $result);
            } else {
                throw new \Exception('Document type not supported: ' . get_class($result));
            }
        }

        public function multi($results): ResponseInterface
        {
            return success($results);
        }

        public function exception($exception): ResponseInterface
        {

        }

    }
}

// file: src/Tqdev/PhpCrudUi/Controller/RecordController.php
namespace Tqdev\PhpCrudUi\Controller {

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Tqdev\PhpCrudApi\Controller\Responder;
    use Tqdev\PhpCrudApi\Middleware\Router\Router;
    use Tqdev\PhpCrudApi\Record\ErrorCode;
    use Tqdev\PhpCrudApi\RequestUtils;
    use Tqdev\PhpCrudUi\Record\RecordService;

    class RecordController
    {
        private $service;
        private $responder;

        public function __construct(Router $router, Responder $responder, RecordService $service)
        {
            $router->register('GET', '/', array($this, 'home'));
            $router->register('GET', '/menu', array($this, 'menu'));
            $router->register('GET', '/*/create', array($this, 'createForm'));
            $router->register('POST', '/*/create', array($this, 'create'));
            $router->register('GET', '/*/read/*', array($this, 'read'));
            $router->register('GET', '/*/update/*', array($this, 'updateForm'));
            $router->register('POST', '/*/update/*', array($this, 'update'));
            $router->register('GET', '/*/delete/*', array($this, 'deleteForm'));
            $router->register('POST', '/*/delete/*', array($this, 'delete'));
            $router->register('GET', '/*/list', array($this, '_list'));
            $router->register('GET', '/*/values/*', array($this, 'values'));
            $router->register('POST', '/*/list', array($this, 'search'));
            $router->register('GET', '/*/export', array($this, 'export'));
            $this->service = $service;
            $this->responder = $responder;
        }

        public function home(ServerRequestInterface $request): ResponseInterface
        {
            $result = $this->service->home();
            return $this->responder->success($result);
        }

        public function menu(ServerRequestInterface $request): ResponseInterface
        {
            $result = $this->service->menu();
            return $this->responder->success($result);
        }

        public function createForm(ServerRequestInterface $request): ResponseInterface
        {
            $table = RequestUtils::getPathSegment($request, 1);
            $action = RequestUtils::getPathSegment($request, 2);
            if (!$this->service->hasTable($table, $action)) {
                return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $table);
            }
            $result = $this->service->createForm($table, $action);
            return $this->responder->success($result);
        }

        public function create(ServerRequestInterface $request): ResponseInterface
        {
            $table = RequestUtils::getPathSegment($request, 1);
            $action = RequestUtils::getPathSegment($request, 2);
            if (!$this->service->hasTable($table, $action)) {
                return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $table);
            }
            $record = $request->getParsedBody();
            if ($record === null) {
                return $this->responder->error(ErrorCode::HTTP_MESSAGE_NOT_READABLE, '');
            }
            $result = $this->service->create($table, $action, $record);
            return $this->responder->success($result);
        }

        public function read(ServerRequestInterface $request): ResponseInterface
        {
            $table = RequestUtils::getPathSegment($request, 1);
            $action = RequestUtils::getPathSegment($request, 2);
            $id = RequestUtils::getPathSegment($request, 3);
            $params = RequestUtils::getParams($request);
            if (!$this->service->hasTable($table, $action)) {
                return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $table);
            }
            $result = $this->service->read($table, $action, $id, $params);
            return $this->responder->success($result);
        }

        public function updateForm(ServerRequestInterface $request): ResponseInterface
        {
            $table = RequestUtils::getPathSegment($request, 1);
            $action = RequestUtils::getPathSegment($request, 2);
            $id = RequestUtils::getPathSegment($request, 3);
            if (!$this->service->hasTable($table, $action)) {
                return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $table);
            }
            $result = $this->service->updateForm($table, $action, $id);
            return $this->responder->success($result);
        }

        public function update(ServerRequestInterface $request): ResponseInterface
        {
            $table = RequestUtils::getPathSegment($request, 1);
            $action = RequestUtils::getPathSegment($request, 2);
            $id = RequestUtils::getPathSegment($request, 3);
            if (!$this->service->hasTable($table, $action)) {
                return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $table);
            }
            $record = $request->getParsedBody();
            if ($record === null) {
                return $this->responder->error(ErrorCode::HTTP_MESSAGE_NOT_READABLE, '');
            }
            $result = $this->service->update($table, $action, $id, $record);
            return $this->responder->success($result);
        }

        public function deleteForm(ServerRequestInterface $request): ResponseInterface
        {
            $table = RequestUtils::getPathSegment($request, 1);
            $action = RequestUtils::getPathSegment($request, 2);
            $id = RequestUtils::getPathSegment($request, 3);
            if (!$this->service->hasTable($table, 'read')) {
                return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $table);
            }
            $result = $this->service->deleteForm($table, $action, $id);
            return $this->responder->success($result);
        }

        public function delete(ServerRequestInterface $request): ResponseInterface
        {
            $table = RequestUtils::getPathSegment($request, 1);
            $action = RequestUtils::getPathSegment($request, 2);
            $id = RequestUtils::getPathSegment($request, 3);
            if (!$this->service->hasTable($table, 'read')) {
                return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $table);
            }
            $result = $this->service->delete($table, $action, $id);
            return $this->responder->success($result);
        }

        public function _list(ServerRequestInterface $request): ResponseInterface
        {
            $table = RequestUtils::getPathSegment($request, 1);
            $action = RequestUtils::getPathSegment($request, 2);
            $params = RequestUtils::getParams($request);
            if (!$this->service->hasTable($table, $action)) {
                return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $table);
            }
            $result = $this->service->_list($table, $action, $params);
            return $this->responder->success($result);
        }

        public function values(ServerRequestInterface $request): ResponseInterface
        {
            $table = RequestUtils::getPathSegment($request, 1);
            $column = RequestUtils::getPathSegment($request, 3);
            $params = RequestUtils::getParams($request);
            if (!$this->service->hasTable($table, 'list')) {
                return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $table);
            }
            $result = $this->service->values($table, 'list', $column, $params);
            return $this->responder->success($result);
        }

        public function search(ServerRequestInterface $request): ResponseInterface
        {
            $table = RequestUtils::getPathSegment($request, 1);
            $action = RequestUtils::getPathSegment($request, 2);
            $params = RequestUtils::getParams($request);
            $body = $request->getParsedBody();
            if (!$this->service->hasTable($table, $action)) {
                return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $table);
            }
            $result = $this->service->search($table, $body, $params);
            return $this->responder->success($result);
        }

        public function export(ServerRequestInterface $request): ResponseInterface
        {
            $table = RequestUtils::getPathSegment($request, 1);
            if (!$this->service->hasTable($table, 'list')) {
                return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $table);
            }
            $result = $this->service->export($table, 'list');
            return $this->responder->success($result);
        }
    }
}

// file: src/Tqdev/PhpCrudUi/Document/CsvDocument.php
namespace Tqdev\PhpCrudUi\Document {

    use Tqdev\PhpCrudUi\Template\Template;

    class CsvDocument
    {
        private $variables;

        public function __construct(array $variables)
        {
            $this->variables = $variables;
        }

        public function __toString(): string
        {
            $f = fopen('php://memory', 'r+');
            fputcsv($f, $this->variables['columns']);
            foreach ($this->variables['records'] as $record) {
                fputcsv($f, $record);
            }
            rewind($f);
            return stream_get_contents($f);
        }
    }
}

// file: src/Tqdev/PhpCrudUi/Document/JsonDocument.php
namespace Tqdev\PhpCrudUi\Document {

    class JsonDocument
    {
        private $variables;

        public function __construct(array $variables)
        {
            $this->variables = $variables;
        }

        public function __toString(): string
        {
            return json_encode($this->variables['records']);
        }
    }
}

// file: src/Tqdev/PhpCrudUi/Document/RedirectDocument.php
namespace Tqdev\PhpCrudUi\Document {

    class RedirectDocument
    {
        private $path;
        private $variables;

        public function __construct(string $path, array $variables)
        {
            $this->path = $path;
            $this->variables = $variables;
        }

        public function addVariables(array $variables) /*: void*/
        {
            $this->variables = array_merge($variables, $this->variables);
        }

        public function __toString(): string
        {
            return $this->variables['base'] . $this->path;
        }
    }
}

// file: src/Tqdev/PhpCrudUi/Document/TemplateDocument.php
namespace Tqdev\PhpCrudUi\Document {

    use Tqdev\PhpCrudUi\Template\Template;

    class TemplateDocument
    {
        private $masterTemplate;
        private $contentTemplate;
        private $variables;
        private $template;
        private $templatePath;

        public function __construct(string $masterTemplate, string $contentTemplate, array $variables)
        {
            $this->masterTemplate = $masterTemplate;
            $this->contentTemplate = $contentTemplate;
            $this->variables = $variables;
            $this->template = new Template('html', $this->getFunctions());
            $this->templatePath = '';
        }

        private function getFunctions(): array
        {
            return array(
                'lt' => function ($a, $b) {
                    return $a < $b;
                },
                'gt' => function ($a, $b) {
                    return $a > $b;
                },
                'le' => function ($a, $b) {
                    return $a <= $b;
                },
                'ge' => function ($a, $b) {
                    return $a >= $b;
                },
                'eq' => function ($a, $b) {
                    return $a == $b;
                },
                'neq' => function ($a, $b) {
                    return $a != $b;
                },
                'add' => function ($a, $b) {
                    return $a + $b;
                },
                'sub' => function ($a, $b) {
                    return $a - $b;
                },
                'has' => function ($a, $b) {
                    return isset($a[$b]);
                },
                'prop' => function ($a, $b) {
                    return $a[$b];
                },
                'bool' => function ($a, $b, $c) {
                    return $a ? $b : $c;
                },
                'and' => function ($a, $b) {
                    return $a && $b;
                },
                'or' => function ($a, $b) {
                    return $a ?: $b;
                },
                'humanize' => function ($a) {
                    $a = substr($a, -3) == '_id' ? substr($a, 0, -3) : $a;
                    return ucwords(str_replace('_', ' ', $a));
                },
            );
        }

        public function addVariables(array $variables) /*: void*/
        {
            $this->variables = array_merge($variables, $this->variables);
        }

        public function setTemplatePath(string $path) /*: void*/
        {
            $this->templatePath = rtrim($path, '/');
        }

        private function getHtmlFileContents(string $template): string
        {
            global $_HTML;
            if (isset($_HTML[$template])) {
                return $_HTML[$template];
            }
            $filename = $this->templatePath . '/' . $template . '.html';
            return file_get_contents($filename);
        }

        public function __toString(): string
        {
            $data = $this->variables;
            $content = $this->getHtmlFileContents($this->contentTemplate);
            $data['content'] = $this->template->render($content, $data);
            $master = $this->getHtmlFileContents($this->masterTemplate);
            return (string) $this->template->render($master, $data);
        }
    }
}

// file: src/Tqdev/PhpCrudUi/Middleware/StaticFileMiddleware.php
namespace Tqdev\PhpCrudUi\Middleware {

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Psr\Http\Server\RequestHandlerInterface;
    use Tqdev\PhpCrudApi\Middleware\Base\Middleware;
    use Tqdev\PhpCrudApi\ResponseFactory;

    class StaticFileMiddleware extends Middleware
    {

        private function getContentType(string $filename): string
        {
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            switch ($extension) {
                case 'css':
                    return 'text/css';
                case 'woff':
                    return 'font/woff';
                case 'woff2':
                    return 'font/woff2';
                case 'svg':
                    return 'image/svg+xml';
                case 'ico':
                    return 'image/x-icon';
                case 'js':
                    return 'application/javascript';
            }
            return '';
        }

        private function santizeFilename(string $base, string $filename): string
        {
            $realBase = realpath($base);
            $realUserPath = realpath($realBase . $filename);

            if ($realUserPath === false || strpos($realUserPath, $realBase) !== 0) {
                return '';
            }

            return $realUserPath;
        }

        public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
        {
            $response = $handler->handle($request);

            if ($response->getStatusCode() == 404) {
                $path = $request->getUri()->getPath();
                $contentType = $this->getContentType($path);

                global $_STATIC;

                if ($_STATIC) {
                    if ($contentType && isset($_STATIC[$path])) {
                        $content = base64_decode($_STATIC[$path]);
                        return ResponseFactory::from(ResponseFactory::OK, $contentType, $content);
                    }
                } else {
                    $filename = $this->santizeFilename('.', $path);
                    if ($contentType && $filename) {
                        $content = file_get_contents($filename);
                        return ResponseFactory::from(ResponseFactory::OK, $contentType, $content);
                    }
                }
            }
            return $response;
        }
    }
}

// file: src/Tqdev/PhpCrudUi/Record/RecordService.php
namespace Tqdev\PhpCrudUi\Record {

    use Tqdev\PhpCrudUi\Client\CrudApi;
    use Tqdev\PhpCrudUi\Column\SpecificationService;
    use Tqdev\PhpCrudUi\Document\CsvDocument;
    use Tqdev\PhpCrudUi\Document\JsonDocument;
    use Tqdev\PhpCrudUi\Document\RedirectDocument;
    use Tqdev\PhpCrudUi\Document\TemplateDocument;

    class RecordService
    {
        private $api;
        private $definition;

        public function __construct(CrudApi $api, SpecificationService $definition)
        {
            $this->api = $api;
            $this->definition = $definition;
        }

        public function hasTable(string $table, string $action): bool
        {
            return $this->definition->hasTable($table, $action);
        }

        private function getDropDownValues(string $relatedTable): array
        {
            $values = array();
            if ($relatedTable) {
                $pair = $this->definition->getColumnPair($relatedTable);
                $args = array('include' => implode(',', $pair));
                $data = $this->api->listRecords($relatedTable, $args);
                foreach ($data['records'] as $record) {
                    if (count($pair) > 1) {
                        $values[$record[$pair[0]]] = $record[$pair[1]];
                    } else {
                        $values[$record[$pair[0]]] = $record[$pair[0]];
                    }
                }
            }
            return $values;
        }

        public function home(): TemplateDocument
        {
            return new TemplateDocument('layouts/default', 'record/home', array());
        }

        public function menu(): TemplateDocument
        {
            return new TemplateDocument('layouts/menu', 'record/menu', array());
        }

        public function createForm(string $table, string $action): TemplateDocument
        {
            $types = $this->definition->getTypes($table, $action);
            $references = $this->definition->getReferences($table, $action);
            $primaryKey = $this->definition->getPrimaryKey($table, $action);

            $columns = $this->definition->getColumns($table, $action);
            $record = array();
            foreach ($columns as $column) {
                $values = $this->getDropDownValues($references[$column]);
                $type = $types[$column];
                //TODO: sensible default
                $default = '';
                $record[$column] = array('value' => $default, 'values' => $values, 'type' => $type);
            }

            $variables = array(
                'table' => $table,
                'action' => $action,
                'record' => $record,
                'primaryKey' => $primaryKey,
            );

            return new TemplateDocument('layouts/default', 'record/create', $variables);
        }

        public function create(string $table, string $action, /* object */ $record): TemplateDocument
        {
            $primaryKey = $this->definition->getPrimaryKey($table, $action);

            $id = $this->api->createRecord($table, $record);

            $variables = array(
                'table' => $table,
                'action' => $action,
                'id' => $id,
                'primaryKey' => $primaryKey,
            );

            return new TemplateDocument('layouts/default', 'record/created', $variables);
        }

        public function read(string $table, string $action, string $id, array $params): TemplateDocument
        {
            $types = $this->definition->getTypes($table, $action);
            $references = $this->definition->getReferences($table, $action);
            $referenced = $this->definition->getReferenced($table, $action);
            $primaryKey = $this->definition->getPrimaryKey($table, $action);

            $args = array();
            $args['join'] = array_values(array_filter($references));
            $record = $this->api->readRecord($table, $id, $args);

            $name = $this->definition->referenceText($table, $record);

            foreach ($record as $key => $value) {
                if (!isset($references[$key])) {
                    unset($record[$key]);
                    continue;
                }
                $relatedTable = false;
                $relatedValue = false;
                $text = $value;
                $type = $types[$key];
                if (isset($references[$key]) && $references[$key]) {
                    $relatedTable = $references[$key];
                    $relatedValue = $this->definition->referenceId($relatedTable, $value);
                    $text = $this->definition->referenceText($relatedTable, $value);
                }
                $record[$key] = array('text' => $text, 'table' => $relatedTable, 'value' => $relatedValue, 'type' => $type);
            }

            $variables = array(
                'table' => $table,
                'action' => $action,
                'id' => $id,
                'name' => $name,
                'primaryKey' => $primaryKey,
                'referenced' => $referenced,
                'record' => $record,
            );

            return new TemplateDocument('layouts/default', 'record/read', $variables);
        }

        public function updateForm(string $table, string $action, string $id): TemplateDocument
        {
            $types = $this->definition->getTypes($table, $action);
            $references = $this->definition->getReferences($table, $action);
            $primaryKey = $this->definition->getPrimaryKey($table, $action);

            $record = $this->api->readRecord($table, $id, []);
            $name = $this->definition->referenceText($table, $record);

            foreach ($record as $key => $value) {
                $values = $this->getDropDownValues($references[$key]);
                $type = $types[$key];
                $record[$key] = array('value' => $value, 'values' => $values, 'type' => $type);
            }

            $variables = array(
                'table' => $table,
                'action' => $action,
                'id' => $id,
                'name' => $name,
                'primaryKey' => $primaryKey,
                'record' => $record,
            );

            return new TemplateDocument('layouts/default', 'record/update', $variables);
        }

        public function update(string $table, string $action, string $id, /* object */ $record): TemplateDocument
        {
            $primaryKey = $this->definition->getPrimaryKey($table, $action);

            $affected = $this->api->updateRecord($table, $id, $record);

            $variables = array(
                'table' => $table,
                'action' => $action,
                'id' => $id,
                'primaryKey' => $primaryKey,
                'affected' => $affected,
            );

            return new TemplateDocument('layouts/default', 'record/updated', $variables);
        }

        public function deleteForm(string $table, string $action, string $id): TemplateDocument
        {
            $primaryKey = $this->definition->getPrimaryKey($table, 'read');

            $record = $this->api->readRecord($table, $id, []);

            $name = $this->definition->referenceText($table, $record);

            $variables = array(
                'table' => $table,
                'action' => $action,
                'id' => $id,
                'name' => $name,
                'primaryKey' => $primaryKey,
                'name' => $name,
            );

            return new TemplateDocument('layouts/default', 'record/delete', $variables);
        }

        public function delete(string $table, string $action, string $id): TemplateDocument
        {
            $primaryKey = $this->definition->getPrimaryKey($table, 'read');

            $affected = $this->api->deleteRecord($table, $id);

            $variables = array(
                'table' => $table,
                'action' => $action,
                'id' => $id,
                'primaryKey' => $primaryKey,
                'affected' => $affected,
            );

            return new TemplateDocument('layouts/default', 'record/deleted', $variables);
        }

        private function getArguments(string $primaryKey, array $references, array $filters): array
        {
            $args = array();
            $i = 0;
            foreach ($filters as $filter) {
                if ($filter['type'] == 'search') {
                    $j = 0;
                    foreach ($references as $column => $reference) {
                        if (!$reference && $column != $primaryKey) {
                            $args["filter${j}[0]"] = implode(',', array($column, $filter['operator'], $filter['value']));
                            $j++;
                        }
                    }
                } elseif ($filter['type'] == 'value') {
                    $args["filter[$i]"] = implode(',', array($filter['field'], $filter['operator'], $filter['value']));
                    $i++;
                } elseif ($filter['type'] == 'reference') {
                    $args["filter[$i]"] = implode(',', array($filter['field'], $filter['operator'], $filter['value']));
                    $i++;
                }
            }
            return $args;
        }

        private function getFilters(array $references, array $params): array
        {
            $filters = array();
            if (isset($params['filter'])) {
                foreach ($params['filter'] as $filter) {
                    $type = substr($filter, 0, strpos($filter, ','));
                    if ($type == 'search') {
                        $filter = array_combine(array('type', 'operator', 'value'), explode(',', $filter, 3));
                        $filter['field'] = '*any*';
                    } elseif ($type == 'value') {
                        $filter = array_combine(array('type', 'field', 'operator', 'value'), explode(',', $filter, 4));
                        $filter['text'] = $filter['value'];
                    } elseif ($type == 'reference') {
                        $filter = array_combine(array('type', 'field', 'operator', 'value', 'text'), explode(',', $filter, 5));
                        $filter['value'] = implode(',', explode('|', $filter['value']));
                    }
                    $filters[] = $filter;
                }
            }
            return $filters;
        }

        private function getParams(array $references, array $filters): array
        {
            $params = ['filter' => []];
            foreach ($filters as $filter) {
                if ($filter['type'] == 'search') {
                    $param = $filter['type'] . ',' . $filter['operator'] . ',' . $filter['value'];
                } elseif ($filter['type'] == 'value') {
                    $param = $filter['type'] . ',' . $filter['field'] . ',' . $filter['operator'] . ',' . $filter['value'];
                } elseif ($filter['type'] == 'reference') {
                    $param = $filter['type'] . ',' . $filter['field'] . ',' . $filter['operator'] . ',' . implode('|', explode(',', $filter['value'])) . ',' . $filter['text'];
                }
                $params['filter'][] = $param;
            }
            return $params;
        }

        public function values(string $table, string $action, string $column, array $params): JsonDocument
        {
            $references = $this->definition->getReferences($table, $action);
            $primaryKey = $this->definition->getPrimaryKey($table, $action);

            $pageParams = isset($params['page']) ? $params['page'][0] : '1,50';
            list($pageNumber, $pageSize) = explode(',', $pageParams, 2);

            $filters = $this->getFilters($references, $params);
            $args = $this->getArguments($primaryKey, $references, $filters);

            $args['join'] = array_values(array_filter($references));
            $args['page'] = "$pageNumber,$pageSize";

            $result = [];

            if ($references[$column]) {
                $otherTable = $references[$column];
                $data = $this->api->listRecords($otherTable, $args);
                foreach ($data['records'] as $record) {
                    $id = $this->definition->referenceId($otherTable, $record);
                    $text = $this->definition->referenceText($otherTable, $record);
                    $result[$id] = $text;
                }
            }

            return new JsonDocument(['records' => $result]);
        }

        public function _list(string $table, string $action, array $params): TemplateDocument
        {
            $types = $this->definition->getTypes($table, $action);
            $references = $this->definition->getReferences($table, $action);
            $primaryKey = $this->definition->getPrimaryKey($table, $action);

            $columns = $this->definition->getColumns($table, $action);

            $pageParams = isset($params['page']) ? $params['page'][0] : '1,50';
            list($pageNumber, $pageSize) = explode(',', $pageParams, 2);

            $filters = $this->getFilters($references, $params);
            $args = $this->getArguments($primaryKey, $references, $filters);

            $args['join'] = array_values(array_filter($references));
            $args['page'] = "$pageNumber,$pageSize";
            $data = $this->api->listRecords($table, $args);

            foreach ($data['records'] as $i => $record) {
                foreach ($record as $key => $value) {
                    if (!isset($references[$key])) {
                        unset($data['records'][$i][$key]);
                        continue;
                    }
                    $relatedTable = false;
                    $relatedValue = $value;
                    $text = $value;
                    $type = $types[$key];
                    if ($references[$key]) {
                        $relatedTable = $references[$key];
                        $relatedValue = $this->definition->referenceId($relatedTable, $value);
                        $text = $this->definition->referenceText($relatedTable, $value);
                    }
                    $data['records'][$i][$key] = array('text' => $text, 'table' => $relatedTable, 'value' => $relatedValue, 'type' => $type);
                }
            }

            if (!isset($data['results'])) {
                $data['results'] = count($data['records']);
            }

            $maxPage = ceil($data['results'] / $pageSize);

            $variables = array(
                'table' => $table,
                'action' => $action,
                'filters' => $filters,
                'types' => $types,
                'references' => $references,
                'primaryKey' => $primaryKey,
                'columns' => $columns,
                'records' => $data['records'],
                'maxPage' => $maxPage,
                'pageNumber' => $pageNumber,
                'pageSize' => $pageSize,
            );

            return new TemplateDocument('layouts/default', 'record/list', $variables);
        }

        public function search(string $table, array $body, array $params)
        {
            $action = 'list';
            $references = $this->definition->getReferences($table, $action);

            $filters = $this->getFilters($references, $params);

            if (isset($body['search'])) {
                foreach ($filters as $i => $filter) {
                    if ($filter['type'] == 'search') {
                        unset($filters[$i]);
                    }
                }
                $filters = array_values($filters);
                $filters[] = ['type' => 'search', 'field' => '*any*', 'operator' => 'cs', 'value' => $body['search']];

                // loop over columns and search in referenced fields in text

                /*if (isset($body['value'])) {
            if (isset($references[$body['field']]) && $references[$body['field']]) {
            $otherTable = $references[$body['field']];
            $otherKey = $this->definition->getPrimaryKey($otherTable, $action);
            $otherReferences = $this->definition->getReferences($otherTable, $action);
            $args = $this->getArguments($otherKey, $otherReferences, [['type' => 'search', 'field' => '*any*', 'operator' => 'cs', 'value' => $body['value']]]);
            $args['include'] = $otherKey;
            $records = $this->api->listRecords($otherTable, $args);
            $values = array_map(function ($a) use ($otherKey) {return $a[$otherKey];}, $records['records']);
            $filters[] = ['type' => 'reference', 'field' => $body['field'], 'operator' => 'in', 'value' => implode(',', $values), 'text' => $body['value']];
            } else {
            $filters[] = ['type' => 'value', 'field' => $body['field'], 'operator' => 'cs', 'value' => $body['value']];
            }
            }*/
            }

            if (isset($body['value'])) {
                if (isset($references[$body['field']]) && $references[$body['field']]) {
                    $filters[] = ['type' => 'reference', 'field' => $body['field'], 'operator' => 'in', 'value' => $body['value'], 'text' => $body['text']];
                } else {
                    $filters[] = ['type' => 'value', 'field' => $body['field'], 'operator' => $body['operator'], 'value' => $body['value']];
                }
            }
            $params = $this->getParams($references, $filters);
            $query = http_build_query($params);
            return new RedirectDocument('/' . $table . '/list?' . $query, []);
        }

        public function export(string $table, string $action): CsvDocument
        {
            $references = $this->definition->getReferences($table, $action);

            $columns = $this->definition->getColumns($table, $action);

            $args = array();
            $args['join'] = array_values(array_filter($references));
            $data = $this->api->listRecords($table, $args);

            foreach ($data['records'] as $i => $record) {
                foreach ($record as $key => $value) {
                    if ($references[$key]) {
                        $value = $this->definition->referenceText($references[$key], $record[$key]);
                        $data['records'][$i][$key] = $value;
                    }
                }
            }

            $variables = array(
                'table' => $table,
                'action' => $action,
                'columns' => $columns,
                'records' => $data['records'],
            );

            return new CsvDocument($variables);
        }
    }
}

// file: src/Tqdev/PhpCrudUi/Template/Template.php
namespace Tqdev\PhpCrudUi\Template {

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
}

// file: src/Tqdev/PhpCrudUi/Template/TemplateString.php
namespace Tqdev\PhpCrudUi\Template {

    class TemplateString
    {
        private $string;

        public function __construct(string $string)
        {
            $this->string = $string;
        }

        public function __toString(): string
        {
            return $this->string;
        }
    }
}

// file: src/Tqdev/PhpCrudUi/Config.php
namespace Tqdev\PhpCrudUi {

    class Config
    {
        private $values = [
            'url' => '',
            'api' => [],
            'definition' => '',
            'middlewares' => 'staticFile',
            'controllers' => 'records',
            'cacheType' => 'TempFile',
            'cachePath' => '',
            'cacheTime' => 10,
            'debug' => false,
            'basePath' => '',
            'templatePath' => '.',
            'passwordColumnFormat' => 'string',
            'passwordColumnName' => 'password$',
            'colorColumnFormat' => 'string',
            'colorColumnName' => '_color$',
            'emailColumnFormat' => 'string',
            'emailColumnName' => '_email$',
            'urlColumnFormat' => 'string',
            'urlColumnName' => '_url$',
            'pointColumnFormat' => 'geometry',
            'pointColumnName' => '_point$',
            'polygonColumnFormat' => 'geometry',
            'polygonColumnName' => '_polygon$',
        ];

        private function parseMiddlewares(array $values): array
        {
            $newValues = array();
            $properties = array();
            $middlewares = array_map('trim', explode(',', $values['middlewares']));
            foreach ($middlewares as $middleware) {
                $properties[$middleware] = [];
            }
            foreach ($values as $key => $value) {
                if (strpos($key, '.') === false) {
                    $newValues[$key] = $value;
                } else {
                    list($middleware, $key2) = explode('.', $key, 2);
                    if (isset($properties[$middleware])) {
                        $properties[$middleware][$key2] = $value;
                    } else {
                        throw new \Exception("Config has invalid value '$key'");
                    }
                }
            }
            $newValues['middlewares'] = array_reverse($properties, true);
            return $newValues;
        }

        public function __construct(array $values)
        {
            $newValues = array_merge($this->values, $values);
            $newValues = $this->parseMiddlewares($newValues);
            $diff = array_diff_key($newValues, $this->values);
            if (!empty($diff)) {
                $key = array_keys($diff)[0];
                throw new \Exception("Config has invalid value '$key'");
            }
            $this->values = $newValues;
        }

        public function getMiddlewares(): array
        {
            return $this->values['middlewares'];
        }

        public function getControllers(): array
        {
            return array_map('trim', explode(',', $this->values['controllers']));
        }

        public function getUrl(): String
        {
            return $this->values['url'];
        }

        public function getApi(): array
        {
            return $this->values['api'];
        }

        public function getDefinition(): String
        {
            return $this->values['definition'];
        }

        public function getCacheType(): string
        {
            return $this->values['cacheType'];
        }

        public function getCachePath(): string
        {
            return $this->values['cachePath'];
        }

        public function getCacheTime(): int
        {
            return $this->values['cacheTime'];
        }

        public function getDebug(): bool
        {
            return $this->values['debug'];
        }

        public function getBasePath(): string
        {
            return $this->values['basePath'];
        }

        public function getTemplatePath(): string
        {
            return $this->values['templatePath'];
        }

        public function getPasswordColumnFormat(): string
        {
            return $this->values['passwordColumnFormat'];
        }

        public function getPasswordColumnName(): string
        {
            return $this->values['passwordColumnName'];
        }

        public function getColorColumnFormat(): string
        {
            return $this->values['colorColumnFormat'];
        }

        public function getColorColumnName(): string
        {
            return $this->values['colorColumnName'];
        }

        public function getEmailColumnFormat(): string
        {
            return $this->values['emailColumnFormat'];
        }

        public function getEmailColumnName(): string
        {
            return $this->values['emailColumnName'];
        }

        public function getUrlColumnFormat(): string
        {
            return $this->values['urlColumnFormat'];
        }

        public function getUrlColumnName(): string
        {
            return $this->values['urlColumnName'];
        }

        public function getPointColumnFormat(): string
        {
            return $this->values['pointColumnFormat'];
        }

        public function getPointColumnName(): string
        {
            return $this->values['pointColumnName'];
        }

        public function getPolygonColumnFormat(): string
        {
            return $this->values['polygonColumnFormat'];
        }

        public function getPolygonColumnName(): string
        {
            return $this->values['polygonColumnName'];
        }
    }
}

// file: src/Tqdev/PhpCrudUi/Ui.php
namespace Tqdev\PhpCrudUi {

    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Psr\Http\Server\RequestHandlerInterface;
    use Tqdev\PhpCrudApi\Cache\CacheFactory;
    use Tqdev\PhpCrudApi\Middleware\Router\SimpleRouter;
    use Tqdev\PhpCrudApi\Record\ErrorCode;
    use Tqdev\PhpCrudApi\ResponseUtils;
    use Tqdev\PhpCrudUi\Client\CrudApi;
    use Tqdev\PhpCrudUi\Client\CurlCaller;
    use Tqdev\PhpCrudUi\Client\LocalCaller;
    use Tqdev\PhpCrudUi\Column\SpecificationService;
    use Tqdev\PhpCrudUi\Controller\MultiResponder;
    use Tqdev\PhpCrudUi\Controller\RecordController;
    use Tqdev\PhpCrudUi\Middleware\StaticFileMiddleware;
    use Tqdev\PhpCrudUi\Record\RecordService;

    class Ui implements RequestHandlerInterface
    {
        private $router;
        private $responder;
        private $debug;

        public function __construct(Config $config)
        {
            $caller = new LocalCaller($config->getApi());
            if ($config->getUrl()) {
                $caller = new CurlCaller($config->getUrl());
            }
            $api = new CrudApi($caller);
            $prefix = sprintf('phpcrudui-%s-%s-', substr(md5($config->getUrl()), 0, 12), substr(md5(__FILE__), 0, 12));
            $cache = CacheFactory::create($config->getCacheType(), $prefix, $config->getCachePath());
            $definition = new SpecificationService($api, $cache, $config->getCacheTime());
            $responder = new MultiResponder($config->getTemplatePath());
            $router = new SimpleRouter($config->getBasePath(), $responder, $cache, $config->getCacheTime(), $config->getDebug());
            foreach ($config->getMiddlewares() as $middleware => $properties) {
                switch ($middleware) {
                    case 'staticFile':
                        new StaticFileMiddleware($router, $responder, $properties);
                        break;
                }
            }
            $responder->setVariable('info', $definition->getInfo());
            $responder->setVariable('base', $router->getBasePath());
            $responder->setVariable('menu', $definition->getMenu());
            $responder->setVariable('table', '');
            foreach ($config->getControllers() as $controller) {
                switch ($controller) {
                    case 'records':
                        $records = new RecordService($api, $definition);
                        new RecordController($router, $responder, $records);
                        break;
                }
            }
            $this->router = $router;
            $this->responder = $responder;
            $this->debug = $config->getDebug();
        }

        private function addParsedBody(ServerRequestInterface $request): ServerRequestInterface
        {
            $body = $request->getBody();
            if ($body->isReadable() && $body->isSeekable()) {
                $contents = $body->getContents();
                $body->rewind();
                if ($contents) {
                    parse_str($contents, $parsedBody);
                    $request = $request->withParsedBody($parsedBody);
                }
            }
            return $request;
        }

        public function handle(ServerRequestInterface $request): ResponseInterface
        {
            $response = null;
            try {
                $response = $this->router->route($this->addParsedBody($request));
                if ($response->getStatusCode() == 404) {
                }
            } catch (\Throwable $e) {
                $response = $this->responder->error(ErrorCode::ERROR_NOT_FOUND, $e->getMessage());
                if ($this->debug) {
                    $response = ResponseUtils::addExceptionHeaders($response, $e);
                }
            }
            return $response;
        }
    }
}

// file: webroot/css/music.css
namespace {
$_STATIC['/css/music.css'] = <<<'END_OF_STATIC_FILE'
LyogU1BPVElGWSBUSEVNRSAqLwoKYm9keSB7YmFja2dyb3VuZC1jb2xvcjogIzE4MTgxODsgZm9udC1mYW1pbHk6IHNhbnMtc2VyaWY7fQpib2R5LCBhIHtjb2xvcjogI2FhYTt9Ci5uYXZpZ2F0aW9uIHtiYWNrZ3JvdW5kLWNvbG9yOiAjMTIxMjEyOyBib3gtc2hhZG93OiBub25lO30KYSB7dGV4dC1kZWNvcmF0aW9uOiBub25lO30KdWw6bm90KC5icmVhZGNydW1iKSBhOjphZnRlciwgdGQgYTo6YWZ0ZXIge2NvbnRlbnQ6ICIg4oCjIn0KYnV0dG9uLCAuYnRuLCBpbnB1dFt0eXBlPSJzdWJtaXQiXSwgLmljb24gewogICAgYmFja2dyb3VuZC1jb2xvcjogIzFlZDc2MDsgCiAgICBib3JkZXItcmFkaXVzOiAycmVtOwogICAgZmlsdGVyOiBpbnZlcnQoMTAwJSkgaHVlLXJvdGF0ZSgtMTgwZGVnKSBzYXR1cmF0ZSgwLjYpIGJyaWdodG5lc3MoMS44KTsKfQp0YWJsZSB0ciB0aCB7Ym9yZGVyLWNvbG9yOiAjMzMzO30KaDIsIC5oYW1idXJnZXIsIHRhYmxlIHRyIHRoLCBoMSwgLnBhZ2luYXRpb24sIGE6bm90KC5pY29uKTpub3QoLmJ0bik6aG92ZXIsIC50aXRsZSB7Y29sb3I6IHdoaXRlO30KdGFibGUgdHI6bnRoLWNoaWxkKGV2ZW4pLCB0YWJsZS5yZWFkIHRyOm50aC1jaGlsZChvZGQpIHtiYWNrZ3JvdW5kOiBub25lO30KdWwucmVsYXRlZCwgdWwuaG9tZSB7ZGlzcGxheTogaW5saW5lLWJsb2NrO30KdWwucmVsYXRlZCBsaSwgdWwuaG9tZSBsaSwgdGFibGUgdHIgdGQge2JvcmRlci1ib3R0b206IDFweCBzb2xpZCAjMzMzO30KdWwucmVsYXRlZCBsaTpsYXN0LWNoaWxkLCB1bC5ob21lIGxpOmxhc3QtY2hpbGQsIHRhYmxlIHRyOmxhc3QtY2hpbGQgdGQge2JvcmRlcjogMDt9CnVsLnJlbGF0ZWQgbGksIHVsLmhvbWUgbGksIHRkLCB0aCwgZGwgPiAqIHtwYWRkaW5nOiAwLjJyZW0gMS41cmVtIDAuMnJlbSAwO30KaW5wdXQsIHRleHRhcmVhLCBzZWxlY3Qge2ZpbHRlcjogaW52ZXJ0KDEwMCUpIGNvbnRyYXN0KDAuNikgYnJpZ2h0bmVzcygxKTsgYm9yZGVyLWNvbG9yOiB0cmFuc3BhcmVudDt9Ci5maWx0ZXJiYXIge2JhY2tncm91bmQ6IzMzMzt9CkBtZWRpYSBvbmx5IHNjcmVlbiBhbmQgKG1heC13aWR0aDogNjAwcHgpIHsKICAgIHRhYmxlLnJlYWQgdHIge2Rpc3BsYXk6IGJsb2NrO30KICAgIGZvcm0gPiBkaXYge3BhZGRpbmc6IDAuNXJlbSAwO30KICAgIHRhYmxlLnJlYWQgdHIge3BhZGRpbmc6IDAuN3JlbSAwO30KICAgIHRhYmxlIHRyIHRkIHtib3JkZXI6IDA7fQogICAgdGFibGUucmVhZCB0ZDpudGgtY2hpbGQoMm4rMSksIGxhYmVsIHtmb250LXdlaWdodDogbm9ybWFsOyBjb2xvcjogd2hpdGU7fQp9
END_OF_STATIC_FILE;
}

// file: webroot/css/style.css
namespace {
$_STATIC['/css/style.css'] = <<<'END_OF_STATIC_FILE'
Ci8qIHB0LXNlcmlmLXJlZ3VsYXIgLSBsYXRpbiAqLwpAZm9udC1mYWNlIHsKICBmb250LWZhbWlseTogJ1BUIFNlcmlmJzsKICBmb250LXN0eWxlOiBub3JtYWw7CiAgZm9udC13ZWlnaHQ6IDQwMDsKICBzcmM6IGxvY2FsKCdQVCBTZXJpZicpLCBsb2NhbCgnUFRTZXJpZi1SZWd1bGFyJyksCiAgICAgICB1cmwoJy4uL2ZvbnRzL3B0LXNlcmlmLXYxMS1sYXRpbi9wdC1zZXJpZi12MTEtbGF0aW4tcmVndWxhci53b2ZmMicpIGZvcm1hdCgnd29mZjInKSwgLyogQ2hyb21lIDI2KywgT3BlcmEgMjMrLCBGaXJlZm94IDM5KyAqLwogICAgICAgdXJsKCcuLi9mb250cy9wdC1zZXJpZi12MTEtbGF0aW4vcHQtc2VyaWYtdjExLWxhdGluLXJlZ3VsYXIud29mZicpIGZvcm1hdCgnd29mZicpOyAvKiBDaHJvbWUgNissIEZpcmVmb3ggMy42KywgSUUgOSssIFNhZmFyaSA1LjErICovCn0KCi8qIHB0LXNlcmlmLWl0YWxpYyAtIGxhdGluICovCkBmb250LWZhY2UgewogIGZvbnQtZmFtaWx5OiAnUFQgU2VyaWYnOwogIGZvbnQtc3R5bGU6IGl0YWxpYzsKICBmb250LXdlaWdodDogNDAwOwogIHNyYzogbG9jYWwoJ1BUIFNlcmlmIEl0YWxpYycpLCBsb2NhbCgnUFRTZXJpZi1JdGFsaWMnKSwKICAgICAgIHVybCgnLi4vZm9udHMvcHQtc2VyaWYtdjExLWxhdGluL3B0LXNlcmlmLXYxMS1sYXRpbi1pdGFsaWMud29mZjInKSBmb3JtYXQoJ3dvZmYyJyksIC8qIENocm9tZSAyNissIE9wZXJhIDIzKywgRmlyZWZveCAzOSsgKi8KICAgICAgIHVybCgnLi4vZm9udHMvcHQtc2VyaWYtdjExLWxhdGluL3B0LXNlcmlmLXYxMS1sYXRpbi1pdGFsaWMud29mZicpIGZvcm1hdCgnd29mZicpOyAvKiBDaHJvbWUgNissIEZpcmVmb3ggMy42KywgSUUgOSssIFNhZmFyaSA1LjErICovCn0KCi8qIHB0LXNlcmlmLTcwMCAtIGxhdGluICovCkBmb250LWZhY2UgewogIGZvbnQtZmFtaWx5OiAnUFQgU2VyaWYnOwogIGZvbnQtc3R5bGU6IG5vcm1hbDsKICBmb250LXdlaWdodDogNzAwOwogIHNyYzogbG9jYWwoJ1BUIFNlcmlmIEJvbGQnKSwgbG9jYWwoJ1BUU2VyaWYtQm9sZCcpLAogICAgICAgdXJsKCcuLi9mb250cy9wdC1zZXJpZi12MTEtbGF0aW4vcHQtc2VyaWYtdjExLWxhdGluLTcwMC53b2ZmMicpIGZvcm1hdCgnd29mZjInKSwgLyogQ2hyb21lIDI2KywgT3BlcmEgMjMrLCBGaXJlZm94IDM5KyAqLwogICAgICAgdXJsKCcuLi9mb250cy9wdC1zZXJpZi12MTEtbGF0aW4vcHQtc2VyaWYtdjExLWxhdGluLTcwMC53b2ZmJykgZm9ybWF0KCd3b2ZmJyk7IC8qIENocm9tZSA2KywgRmlyZWZveCAzLjYrLCBJRSA5KywgU2FmYXJpIDUuMSsgKi8KfQoKLyogcHQtc2VyaWYtNzAwaXRhbGljIC0gbGF0aW4gKi8KQGZvbnQtZmFjZSB7CiAgZm9udC1mYW1pbHk6ICdQVCBTZXJpZic7CiAgZm9udC1zdHlsZTogaXRhbGljOwogIGZvbnQtd2VpZ2h0OiA3MDA7CiAgc3JjOiBsb2NhbCgnUFQgU2VyaWYgQm9sZCBJdGFsaWMnKSwgbG9jYWwoJ1BUU2VyaWYtQm9sZEl0YWxpYycpLAogICAgICAgdXJsKCcuLi9mb250cy9wdC1zZXJpZi12MTEtbGF0aW4vcHQtc2VyaWYtdjExLWxhdGluLTcwMGl0YWxpYy53b2ZmMicpIGZvcm1hdCgnd29mZjInKSwgLyogQ2hyb21lIDI2KywgT3BlcmEgMjMrLCBGaXJlZm94IDM5KyAqLwogICAgICAgdXJsKCcuLi9mb250cy9wdC1zZXJpZi12MTEtbGF0aW4vcHQtc2VyaWYtdjExLWxhdGluLTcwMGl0YWxpYy53b2ZmJykgZm9ybWF0KCd3b2ZmJyk7IC8qIENocm9tZSA2KywgRmlyZWZveCAzLjYrLCBJRSA5KywgU2FmYXJpIDUuMSsgKi8KfQoKCgoqIHttYXJnaW46IDA7IHBhZGRpbmc6IDA7IGJveC1zaXppbmc6IGJvcmRlci1ib3g7fQpodG1sIHtmb250LXNpemU6IDE2cHg7fQpib2R5IHtmb250LXNpemU6IDFyZW07IGxpbmUtaGVpZ2h0OiAxLjQ7IGZvbnQtZmFtaWx5OiAnUFQgU2VyaWYnO30KCi5jb250ZW50IHttaW4taGVpZ2h0OiAxMDB2aDt9Ci5uYXZpZ2F0aW9uIHsKICAgIGJhY2tncm91bmQtY29sb3I6IHdoaXRlOyAKICAgIGRpc3BsYXk6IGZsZXg7IAogICAgcG9zaXRpb246IGZpeGVkOyAKICAgIHdpZHRoOiAxMDAlOyAKICAgIGp1c3RpZnktY29udGVudDogc3BhY2UtYmV0d2VlbjsKICAgIGJveC1zaGFkb3c6IDBweCAwcHggMTBweCByZ2JhKDAsMCwwLDAuMjUpOwogICAgei1pbmRleDogOTsKfQoudGl0bGUge3BhZGRpbmc6IDAuNXJlbSAycmVtOyBjb2xvcjogYmxhY2s7IHRleHQtZGVjb3JhdGlvbjogbm9uZTt9Ci50aXRsZSBzcGFuIHtmb250LXdlaWdodDogYm9sZDsgZGlzcGxheTogYmxvY2s7fQouYm9keSB7cGFkZGluZzogNnJlbSAycmVtOyBmbGV4LWdyb3c6IDE7IHBhZGRpbmctYm90dG9tOiAxMHJlbTt9Ci5oYW1idXJnZXIge2Rpc3BsYXk6IGJsb2NrOyBtYXJnaW46IDAuNHJlbSAycmVtIDAgMDsgbWluLXdpZHRoOiAzcmVtOyBtYXgtd2lkdGg6IDNyZW07IGhlaWdodDogM3JlbTsgYmFja2dyb3VuZDogdHJhbnNwYXJlbnQ7IHBvc2l0aW9uOiByZWxhdGl2ZTt9Ci5oYW1idXJnZXIgc3BhbiB7cG9zaXRpb246IGFic29sdXRlOyB0b3A6IDUwJTsgd2lkdGg6IDIuNXJlbTsgbWFyZ2luLWxlZnQ6IDAuMjVyZW07IHRyYW5zZm9ybTogdHJhbnNsYXRlWSgtNTAlKTsgaGVpZ2h0OiA0cHg7IGJhY2tncm91bmQ6IGJsYWNrO30KLmhhbWJ1cmdlciBzcGFuOm50aC1jaGlsZCgxKSB7bWFyZ2luLXRvcDogLTAuNnJlbTt9Ci5oYW1idXJnZXIgc3BhbjpudGgtY2hpbGQoMykge21hcmdpbi10b3A6IDAuNnJlbTt9Ci5oYW1idXJnZXIuY2xvc2U6OmJlZm9yZSB7Y29udGVudDogbm9uZTt9Ci5oYW1idXJnZXIuY2xvc2Ugc3BhbiB7d2lkdGg6IDEuOHJlbTsgbWFyZ2luLWxlZnQ6IDAuNnJlbTt9Ci5oYW1idXJnZXIuY2xvc2Ugc3BhbjpudGgtY2hpbGQoMSkge21hcmdpbi10b3A6IDA7IHRyYW5zZm9ybTogdHJhbnNsYXRlWSgtNTAlKSByb3RhdGUoNDVkZWcpO30KLmhhbWJ1cmdlci5jbG9zZSBzcGFuOm50aC1jaGlsZCgyKSB7bWFyZ2luLXRvcDogMDsgdHJhbnNmb3JtOiB0cmFuc2xhdGVZKC01MCUpIHJvdGF0ZSgtNDVkZWcpO30KLmhhbWJ1cmdlci5jbG9zZSBzcGFuOm50aC1jaGlsZCgzKSB7ZGlzcGxheTogbm9uZTt9Cgp0aC5zZWxlY3RlZDo6YWZ0ZXIge2NvbnRlbnQ6ICIg4pa+Ijt9Cgp0ZCwgdGgsIGRsID4gKiB7cGFkZGluZzogMC4ycmVtIDEuNXJlbSAwLjJyZW0gMC41cmVtOyB0ZXh0LWFsaWduOiBsZWZ0O30KdGQsIHRoIHttYXgtd2lkdGg6IDQwcmVtO30KdGFibGUubGlzdCB0ZCwgdGFibGUubGlzdCB0aCB7dGV4dC1vdmVyZmxvdzogZWxsaXBzaXM7IHdoaXRlLXNwYWNlOiBub3dyYXA7IG92ZXJmbG93OiBoaWRkZW47IG1heC13aWR0aDogMjVyZW07fQpsYWJlbCB7cGFkZGluZzogY2FsYygwLjJyZW0gKyAxcHgpIDEuNXJlbSBjYWxjKDAuMnJlbSArIDFweCkgMDsgdGV4dC1vdmVyZmxvdzogZWxsaXBzaXM7IHdoaXRlLXNwYWNlOiBub3dyYXA7IG92ZXJmbG93OiBoaWRkZW47fQp0ZDpsYXN0LWNoaWxkIGEge2Rpc3BsYXk6IGlubGluZS1ibG9jazsgbWFyZ2luLXJpZ2h0OiAwLjVyZW07fQoubG9nbyBpbWcge2hlaWdodDogMnJlbTsgdmVydGljYWwtYWxpZ246IG1pZGRsZTt9CmEge2NvbG9yOiBibGFjazt9CmxhYmVsIHt3aWR0aDogMTVyZW07IG1pbi13aWR0aDogMTVyZW07IHBhZGRpbmctcmlnaHQ6IDJyZW07fQpoMSB7Zm9udC1zaXplOiAyLjJyZW07IG1hcmdpbi1ib3R0b206IDAuNXJlbTsgbWFyZ2luLXJpZ2h0OiAxcmVtOyBsaW5lLWhlaWdodDogMTt9CmgyIHtmb250LXNpemU6IDEuNXJlbTsgbWFyZ2luLWJvdHRvbTogMC41cmVtO30KdGFibGUge2JvcmRlci1jb2xsYXBzZTogY29sbGFwc2U7IG1hcmdpbi10b3A6IDEuNXJlbTt9CnRhYmxlIHRyOm50aC1jaGlsZChldmVuKSB7YmFja2dyb3VuZDogcmdiYSgwLDAsMCwwLjA1KTt9CnRhYmxlIHRyIHRoIHtwYWRkaW5nLXRvcDogMC4zcmVtOyBwYWRkaW5nLWJvdHRvbTogMC4zcmVtOyBmb250LXdlaWdodDogYm9sZDsgYm9yZGVyLWJvdHRvbTogMXB4IHNvbGlkIGJsYWNrO30KcCwgdGFibGUge21hcmdpbi1ib3R0b206IDEuNHJlbTt9CgoudGl0bGViYXIge2Rpc3BsYXk6IGZsZXg7IGFsaWduLWl0ZW1zOiBjZW50ZXI7IG1hcmdpbi1ib3R0b206IDAuNXJlbTsgZmxleC13cmFwOiB3cmFwO30KLnRpdGxlYmFyID4gZGl2IHttYXJnaW4tYm90dG9tOiAwLjVyZW07fQoKLmNvbHMge2NvbHVtbi13aWR0aDogNzAwcHg7IG1hcmdpbi10b3A6IC0yZW07fQouY29sIHsKICAgIC13ZWJraXQtY29sdW1uLWJyZWFrLWluc2lkZTogYXZvaWQ7IC8qIENocm9tZSwgU2FmYXJpICovCiAgICBwYWdlLWJyZWFrLWluc2lkZTogYXZvaWQ7ICAgICAgICAgICAvKiBUaGVvcmV0aWNhbGx5IEZGIDIwKyAqLwogICAgYnJlYWstaW5zaWRlOiBhdm9pZC1jb2x1bW47ICAgICAgICAgLyogSUUgMTEgKi8KICAgIGRpc3BsYXk6dGFibGU7ICAgICAgICAgICAgICAgICAgICAgIC8qIEFjdHVhbGx5IEZGIDIwKyAqLwp9CgppbnB1dCwgdGV4dGFyZWEsIHNlbGVjdHsKICAgIGhlaWdodDogY2FsYygycmVtICsgMnB4KTsgCiAgICBsaW5lLWhlaWdodDogMS40cmVtOyAKICAgIHRleHQtZGVjb3JhdGlvbjogbm9uZTsgCiAgICBib3JkZXI6IDFweCBzb2xpZCBibGFjazsgCiAgICBwYWRkaW5nOiAwIDAuNXJlbTsgCiAgICBiYWNrZ3JvdW5kOiB0cmFuc3BhcmVudDsKICAgIGNvbG9yOiBibGFjazsKICAgIGZvbnQtZmFtaWx5OiBpbmhlcml0OwogICAgZm9udC1zaXplOiBpbmhlcml0OwogICAgZmxleC1ncm93OiAxOwogICAgYmFja2dyb3VuZDogd2hpdGU7Cn0KYnV0dG9uLCBpbnB1dFt0eXBlPSJzdWJtaXQiXSwgLmJ0biB7CiAgICBoZWlnaHQ6IGNhbGMoMnJlbSArIDJweCk7IAogICAgbGluZS1oZWlnaHQ6IDJyZW07IAogICAgYm9yZGVyOiAxcHggc29saWQgdHJhbnNwYXJlbnQ7IAogICAgZGlzcGxheTogaW5saW5lLWJsb2NrOyAKICAgIHRleHQtZGVjb3JhdGlvbjogbm9uZTsgCiAgICBwYWRkaW5nOiAwIDFyZW07IAogICAgYmFja2dyb3VuZDogdHJhbnNwYXJlbnQ7CiAgICBjb2xvcjogYmxhY2s7CiAgICBmb250LWZhbWlseTogaW5oZXJpdDsKICAgIGZvbnQtc2l6ZTogaW5oZXJpdDsKICAgIGJhY2tncm91bmQtY29sb3I6IHJnYigyMjIsIDIyMiwgMjIyKTsKICAgIGN1cnNvcjogcG9pbnRlcjsKICAgIGJvcmRlci1yYWRpdXM6IDAuMTVyZW07Cn0KYnV0dG9uOmZvY3VzLCBpbnB1dFt0eXBlPSJzdWJtaXQiXTpmb2N1cywgLmJ0bjpmb2N1cywgLmljb246Zm9jdXMge2JvcmRlci1jb2xvcjogYmxhY2s7fQpzZWxlY3Q6Oi1tcy1leHBhbmQge2Rpc3BsYXk6IG5vbmU7fQpzZWxlY3QgewogICAgLXdlYmtpdC1hcHBlYXJhbmNlOiBub25lOwogICAgLW1vei1hcHBlYXJhbmNlOiBub25lOwogICAgYXBwZWFyYW5jZTogbm9uZTsKICAgIGJhY2tncm91bmQ6IHdoaXRlIHVybCgnLi4vaW1nL2Rvd24uc3ZnJykgY2FsYygxMDAlIC0gMC42cmVtKSA1MCUgbm8tcmVwZWF0OwogICAgYmFja2dyb3VuZC1zaXplOiBhdXRvIDAuNXJlbTsKICAgIHBhZGRpbmctcmlnaHQ6IDEuNzVyZW07CiAgICBtYXgtd2lkdGg6IGNhbGMoMTAwJSAtIDE1cmVtKTsKfQppbnB1dFt0eXBlPSJyYWRpbyJdLCBpbnB1dFt0eXBlPSJjaGVja2JveCJdLCBpbnB1dFt0eXBlPSJmaWxlIl0ge2JvcmRlcjogMDsgaGVpZ2h0OiBhdXRvOyBsaW5lLWhlaWdodDogYXV0bzsgbWFyZ2luLXJpZ2h0OiAwLjRyZW07IHZlcnRpY2FsLWFsaWduOiBtaWRkbGU7IHBvc2l0aW9uOiByZWxhdGl2ZTsgYm90dG9tOiAwLjFyZW07fQppbnB1dFt0eXBlPSJmaWxlIl0ge3BhZGRpbmc6IDA7IG1hcmdpbjogMDsgYm90dG9tOiAwO30KaW5wdXRbdHlwZT0nbnVtYmVyJ10gey1tb3otYXBwZWFyYW5jZTogdGV4dGZpZWxkO30KaW5wdXQ6Oi13ZWJraXQtb3V0ZXItc3Bpbi1idXR0b24sIGlucHV0Ojotd2Via2l0LWlubmVyLXNwaW4tYnV0dG9uIHstd2Via2l0LWFwcGVhcmFuY2U6IG5vbmU7fQppbnB1dFt0eXBlPSJudW1iZXIiXSB7LW1vei1hcHBlYXJhbmNlOiB0ZXh0ZmllbGQ7fQppbnB1dDo6LXdlYmtpdC1vdXRlci1zcGluLWJ1dHRvbiwgCmlucHV0Ojotd2Via2l0LWlubmVyLXNwaW4tYnV0dG9uIHstd2Via2l0LWFwcGVhcmFuY2U6IG5vbmU7fQp0ZXh0YXJlYSB7bWluLWhlaWdodDogMTByZW07IHBhZGRpbmc6IDAuMzVyZW0gMC41cmVtOyB9CgouaWNvbiB7CiAgICBkaXNwbGF5OiBpbmxpbmUtYmxvY2s7IAogICAgdGV4dC1kZWNvcmF0aW9uOiBub25lOyAKICAgIHdpZHRoOiAwOyAKICAgIGhlaWdodDogMDsgCiAgICBvdmVyZmxvdzogaGlkZGVuOyAKICAgIHBhZGRpbmctdG9wOiAycmVtOyAKICAgIHBhZGRpbmctbGVmdDogMnJlbTsgCiAgICBwb3NpdGlvbjogcmVsYXRpdmU7CiAgICBiYWNrZ3JvdW5kLWNvbG9yOiByZ2IoMjIyLCAyMjIsIDIyMik7CiAgICBjdXJzb3I6IHBvaW50ZXI7CiAgICBib3JkZXItcmFkaXVzOiAwLjE1cmVtOwogICAgYm9yZGVyOiAxcHggc29saWQgdHJhbnNwYXJlbnQ7CiAgICB2ZXJ0aWNhbC1hbGlnbjogYm90dG9tOwp9Ci5pY29uOjpiZWZvcmUge2NvbnRlbnQ6ICcnOyBwb3NpdGlvbjogYWJzb2x1dGU7IHdpZHRoOiAycmVtOyBoZWlnaHQ6IDJyZW07IGxlZnQ6IDA7IHRvcDogMDt9Ci5pY29uLmZpbHRlcjo6YmVmb3JlIHsKICAgIGJhY2tncm91bmQ6IHVybCgnLi4vaW1nL2ZpbHRlci5zdmcnKSBjZW50ZXIgY2VudGVyIC8gYXV0byA0NSUgbm8tcmVwZWF0O30KLmljb24uc2VhcmNoOjpiZWZvcmUgewogICAgYmFja2dyb3VuZDogdXJsKCcuLi9pbWcvc2VhcmNoLnN2ZycpIGNlbnRlciBjZW50ZXIgLyBhdXRvIDU3JSBuby1yZXBlYXQ7fQouaWNvbi5wcmV2OjpiZWZvcmUgewogICAgYmFja2dyb3VuZDogdXJsKCcuLi9pbWcvcHJldi5zdmcnKSBjZW50ZXIgNDglIC8gYXV0byA0MCUgbm8tcmVwZWF0O30KLmljb24ubmV4dDo6YmVmb3JlIHsKICAgIGJhY2tncm91bmQ6IHVybCgnLi4vaW1nL25leHQuc3ZnJykgY2VudGVyIDQ4JSAvIGF1dG8gNDAlIG5vLXJlcGVhdDt9CmZvcm0ge21hcmdpbi10b3A6IDEuNXJlbTt9CmZvcm0sIGRsIHt3aWR0aDogMTAwJTsgbWF4LXdpZHRoOiA0MHJlbTt9CmZvcm0gPiBkaXYge2Rpc3BsYXk6IGZsZXg7IG1hcmdpbi1ib3R0b206IDAuMjVyZW07fQpmb3JtID4gZGl2ID4gKjpudGgtY2hpbGQoMikge2ZsZXgtZ3JvdzogMTt9CmZvcm0gPiBkaXYgPiAqOm50aC1jaGlsZCgzKSB7bWFyZ2luLWxlZnQ6IDAuMjVyZW07fQpmb3JtID4gYnV0dG9uIHttYXJnaW4tdG9wOiAxLjVyZW07fQoKZGwge2Rpc3BsYXk6IGZsZXg7IG1hcmdpbi1ib3R0b206IDEuNHJlbTt9CmR0IHt3aWR0aDogMTFyZW07IG1pbi13aWR0aDogMTFyZW07IHBhZGRpbmctcmlnaHQ6IDJyZW07fQpkZCB7ZmxleC1ncm93OiAxO30KZGwgKyBkbCB7bWFyZ2luLXRvcDogLTEuNHJlbTt9CmRsICsgZGwgZHQge2JvcmRlci10b3A6IDFweCBzb2xpZCB0cmFuc3BhcmVudDt9CmRsICsgZGwgZGQge2JvcmRlci10b3A6IDFweCBzb2xpZCBzaWx2ZXI7fQoKdWwuYnJlYWRjcnVtYiB7bWFyZ2luLWJvdHRvbTogMC4zcmVtOyBmb250LXNpemU6IDAuOXJlbTsgb3BhY2l0eTogMC40NTt9CnVsLmJyZWFkY3J1bWIgbGkge2Rpc3BsYXk6IGlubGluZTsgbGlzdC1zdHlsZTogbm9uZTt9CnVsLmJyZWFkY3J1bWIgbGkgKyBsaTo6YmVmb3JlIHtjb250ZW50OiAiLyAiO30KdWwuYnJlYWRjcnVtYiBsaSBhIHt0ZXh0LWRlY29yYXRpb246IG5vbmU7fQoKdWwucmVsYXRlZCBsaSwgdWwuaG9tZSBsaSB7bGlzdC1zdHlsZTogbm9uZTt9CgoKLmZpbHRlcmJhciB7cGFkZGluZzogMC41cmVtIDAuN3JlbTsgYmFja2dyb3VuZDogcmdiYSgwLDAsMCwwLjA1KTsgZGlzcGxheTogZmxleDsganVzdGlmeS1jb250ZW50OiBzcGFjZS1iZXR3ZWVuOyBhbGlnbi1pdGVtczogY2VudGVyOyBtYXJnaW4tYm90dG9tOiAwLjVyZW07fQoKLmNsb3NlOjpiZWZvcmV7Y29udGVudDogIisiOyB0ZXh0LWRlY29yYXRpb246IG5vbmU7IHRyYW5zZm9ybTogcm90YXRlKDQ1ZGVnKTsgZGlzcGxheTogaW5saW5lLWJsb2NrO30KCi5hZGRGaWx0ZXIge21hcmdpbi1ib3R0b206IDAuNXJlbTsgZGlzcGxheTogbm9uZTt9Ci5hZGRGaWx0ZXIudmlzaWJsZSB7ZGlzcGxheTogYmxvY2s7fQouYWRkU2VhcmNoIHttYXJnaW4tYm90dG9tOiAwLjVyZW07IGRpc3BsYXk6IG5vbmU7fQouYWRkU2VhcmNoLnZpc2libGUge2Rpc3BsYXk6IGJsb2NrO30KLmZvb3RlcmFjdGlvbnMge21hcmdpbi10b3A6IDEuNXJlbTt9CgoucGFnaW5hdGlvbiB7ZGlzcGxheTogZmxleDsgYWxpZ24taXRlbXM6IGNlbnRlcjsgZm9udC1zaXplOiAwLjlyZW07fQoucGFnaW5hdGlvbiAuaWNvbiB7bWFyZ2luLXJpZ2h0OiAwLjI1cmVtO30KLmRpc2FibGVkIHtvcGFjaXR5OiAwLjQ7IGN1cnNvcjogZGVmYXVsdDt9Ci5wYWdpbmF0aW9uIC5pY29uOmxhc3QtY2hpbGQge21hcmdpbi1yaWdodDogMDsgbWFyZ2luLWxlZnQ6IDAuMjVyZW07fQouaGlkZGVuIHtkaXNwbGF5OiBub25lO30KCkBtZWRpYSBvbmx5IHNjcmVlbiBhbmQgKG1pbi13aWR0aDogMTUwMHB4KSB7CiAgICAuY29udGVudCB7ZGlzcGxheTogYmxvY2s7fQogICAgLnRpdGxlIHtwb3NpdGlvbjogYWJzb2x1dGU7IGJvdHRvbTogMS41cmVtO30KICAgIC5uYXZpZ2F0aW9uIHtkaXNwbGF5OiBibG9jazsgd2lkdGg6IDE1cmVtOyBoZWlnaHQ6IDEwMHZoO30KICAgIC5ib2R5IHtwYWRkaW5nLXRvcDogM3JlbTsgbWFyZ2luLWxlZnQ6IDE1cmVtOyBwYWRkaW5nLWxlZnQ6IDVyZW07fQogICAgLmhhbWJ1cmdlciB7bWFyZ2luLWxlZnQ6IDJyZW07IG1hcmdpbi10b3A6IDJyZW07fQogICAgLmhhbWJ1cmdlci5jbG9zZSBzcGFuOm50aC1jaGlsZCgxKSB7bWFyZ2luOiAwIDAgMCAwLjJyZW07IHdpZHRoOiAxLjNyZW07IHRyYW5zZm9ybTogdHJhbnNsYXRlWSgtNTAlKSByb3RhdGUoLTQ1ZGVnKTsgdHJhbnNmb3JtLW9yaWdpbjogMCUgMTAwJTt9CiAgICAuaGFtYnVyZ2VyLmNsb3NlIHNwYW46bnRoLWNoaWxkKDIpIHttYXJnaW4tbGVmdDogMC4zcmVtOyB0cmFuc2Zvcm06IHRyYW5zbGF0ZVkoLTUwJSkgcm90YXRlKDBkZWcpO30KICAgIC5oYW1idXJnZXIuY2xvc2Ugc3BhbjpudGgtY2hpbGQoMykge21hcmdpbjogMCAwIDAgMC4ycmVtOyB3aWR0aDogMS4zcmVtOyBkaXNwbGF5OiBibG9jazsgdHJhbnNmb3JtOiB0cmFuc2xhdGVZKC01MCUpIHJvdGF0ZSg0NWRlZyk7IHRyYW5zZm9ybS1vcmlnaW46IDAlIDAlO30KfQoKLm1vYmlsZS1vbmx5IHtkaXNwbGF5OiBub25lO30KQG1lZGlhIG9ubHkgc2NyZWVuIGFuZCAobWF4LXdpZHRoOiA2MDBweCkgewoKICAgIHVsLnJlbGF0ZWQgbGkgYSwgdWwuaG9tZSBsaSBhICB7ZGlzcGxheTogaW5saW5lLWJsb2NrOyBwYWRkaW5nOiAwLjJyZW0gMDt9CgogICAgdGFibGUucmVhZCB0aGVhZCB7ZGlzcGxheTogbm9uZTt9CiAgICB0YWJsZS5yZWFkIHRyIHtkaXNwbGF5OiBibG9jazsgcGFkZGluZzogMC43cmVtIDAuNXJlbTt9CiAgICB0YWJsZS5yZWFkIHRyIHRkIHtkaXNwbGF5OiBibG9jazsgcGFkZGluZzogMDt9CiAgICB0YWJsZS5yZWFkIHRkOm50aC1jaGlsZChvZGQpIHtmb250LXdlaWdodDogYm9sZDt9CiAgICAKICAgIC5tb2JpbGUtb25seSB7ZGlzcGxheTogaW5pdGlhbDt9CiAgICAKICAgIGZvcm0gPiBkaXYge2ZsZXgtZGlyZWN0aW9uOiBjb2x1bW47fQogICAgc2VsZWN0IHttYXgtd2lkdGg6IDEwMCU7fQoKfQo=
END_OF_STATIC_FILE;
}

// file: webroot/fonts/pt-serif-v11-latin/pt-serif-v11-latin-700.woff
namespace {
$_STATIC['/fonts/pt-serif-v11-latin/pt-serif-v11-latin-700.woff'] = <<<'END_OF_STATIC_FILE'
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
END_OF_STATIC_FILE;
}

// file: webroot/fonts/pt-serif-v11-latin/pt-serif-v11-latin-700.woff2
namespace {
$_STATIC['/fonts/pt-serif-v11-latin/pt-serif-v11-latin-700.woff2'] = <<<'END_OF_STATIC_FILE'
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
END_OF_STATIC_FILE;
}

// file: webroot/fonts/pt-serif-v11-latin/pt-serif-v11-latin-700italic.woff
namespace {
$_STATIC['/fonts/pt-serif-v11-latin/pt-serif-v11-latin-700italic.woff'] = <<<'END_OF_STATIC_FILE'
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
END_OF_STATIC_FILE;
}

// file: webroot/fonts/pt-serif-v11-latin/pt-serif-v11-latin-700italic.woff2
namespace {
$_STATIC['/fonts/pt-serif-v11-latin/pt-serif-v11-latin-700italic.woff2'] = <<<'END_OF_STATIC_FILE'
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
END_OF_STATIC_FILE;
}

// file: webroot/fonts/pt-serif-v11-latin/pt-serif-v11-latin-italic.woff
namespace {
$_STATIC['/fonts/pt-serif-v11-latin/pt-serif-v11-latin-italic.woff'] = <<<'END_OF_STATIC_FILE'
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
END_OF_STATIC_FILE;
}

// file: webroot/fonts/pt-serif-v11-latin/pt-serif-v11-latin-italic.woff2
namespace {
$_STATIC['/fonts/pt-serif-v11-latin/pt-serif-v11-latin-italic.woff2'] = <<<'END_OF_STATIC_FILE'
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
END_OF_STATIC_FILE;
}

// file: webroot/fonts/pt-serif-v11-latin/pt-serif-v11-latin-regular.woff
namespace {
$_STATIC['/fonts/pt-serif-v11-latin/pt-serif-v11-latin-regular.woff'] = <<<'END_OF_STATIC_FILE'
d09GRgABAAAAAJocABEAAAABEZAAAQABAAAAAAAAAAAAAAAAAAAAAAAAAABHUE9TAAABgAAABPUAAAswAEkNTUdTVUIAAAZ4AAAAvwAAAUh74Iy9T1MvMgAABzgAAABaAAAAYGxtMTJjbWFwAAAHlAAAAIsAAADEsr/TD2N2dCAAAAggAAAAPgAAAD4B0Q9JZnBnbQAACGAAAAESAAABk55I329nYXNwAAAJdAAAABAAAAAQABcACWdseWYAAAmEAAB3HQAAzka3xkxQaGRteAAAgKQAABGlAAAmwF2udN1oZWFkAACSTAAAADQAAAA29KCU32hoZWEAAJKAAAAAHgAAACQHEwOzaG10eAAAkqAAAAIdAAADqOFtIzBsb2NhAACUwAAAAdYAAAHWsxKBRm1heHAAAJaYAAAAIAAAACADHQZnbmFtZQAAlrgAAADYAAABnh/0PEtwb3N0AACXkAAAAa0AAAKDoMsBHHByZXAAAJlAAAAA2wAAAcqUZH+PeNqMlQOsJGkUhb/ntW3btm3bthmOHaxt29tYdPfY/TB4zEx3L8ZWNGdPspVKVep1MvfmFO49595b//8nRQ2wAYdxFrV3Pv/EQ2zy0O1PPcIO1ANIzkP4bK998O4nHmGT/6/giGFGLVDHRkytucfvWzkCDezBQdzCCHuN347leE7gJN4z+3uJH9jPio/UwcfGp+rmM9+/1J98oxa+ZR+zlpt1DD8pT8rxtApsaEXOirwVHVbkA/aeZq8N2WmjoBIbm50yO2d2j9k51x9lRUegkBWnRuq3WzUp9gWncQ4XMYgav+3PWVzO1dY0sZd+pZ/R3xhgDDQGGYONGo5VM76qnU3Y1NfN3HFz369nc25gQ27y/WaJnO8FY7LzU4xmc9qM6UY9x3M0JxgncTDvGbUNKxyl8fWmNezMDqCFKqpdE/Wd3tAnmmssULealdYE9VeRKqY5sqtsKHiu2OdEc8TMPRzV+3pXBdBHAbNZJQ3RDKhuZs3UbM3ydQ5hDFxxkf1TuW6MLy0FeQIrSvo3OolSVpR1vwZqgBSJl80sOjseNFLSQnuXY3PCfglTIczKWOL3uWHuO1XUopddM+/aHQCqGBPUTmjWfKKJmqmZAHpDOf2p+/S9UtZ3hqxmzY70mWNWs1XNANbnze7ra9rxmRHNLAm0NtgPnwuN1wQAzQUjYfIkYZ8aeTaNtmZq0CdlvK6v3cWzUROu25y461+VtABAC+S11hLiluhtlgBUCd4WUc0SOrUHTysT6b3VQcRCljOcHzlbiwG4nCqmldatCPqs0AoSpvZExBZ+J1Jvsyfea9jFHlmj4FwAvdfRirjGNayJT6NSQhOppDXWJExLkhqttAf7o7nJFQjWp0IyU9ZCAP0rsyLxrH2OivpeOdDXQXymfYyyBMZ2Qbwc6VLQBDXbJ6olPAeu5XxJSzTaz5OieyPnqu2X+hsVDXHPjCqR2Sa5Xl4ppUG5cLZ2szKsi9XQq6kcn8OoaioC6B15pWLxKSqFJ3qxypqo6eHajNQkv7+it/WlpgSTXEYdDWzAhmzMpmzG5uzAXuzDvhzCoRzBkRzF0cHf9URO4mRO4WzO4TzO5xKu4Equ5Xpu4EZu4mZu4Q760Z8BDGQQgxnKi7zMK7zKa7zOm7zH+3zBl3zF13zDz/zCr6RIkyVHngKjmcwUplKkmRZaaeO/huoaXYogCqDwGXsjPf16vAUy3N3d3d1lBWwBh5QEd3dNcM3xmK1wvr8tPrer6i95ZlJQl5ISakoIlBFqAJF6NBTTVI9MAxmqHMNUYKyqjFOeiSowSUUmq8AUlZimPmaozExVmKUqs1VjjgLmKmOJIpaqznKFrFA/a9XGKkRsU4Md8lRWi11qs1uez+qwVxkH1eW0cpxRwWbnfF5QgauqcU1F7qtuv8eEvLJbxBtFfFSTT4r4rCbfFGJNYuxJwg+lWNXv30r5qx55FlBQjpIiaoqoKyVUnkhdGirQVJfBajJURUaqyERZU0WmqcQM9TFTZexozdmqMkc15itlsWKWKmC5AlYqYD0biNmogE2K2ayALWz1e5vqbFfMDoXsVD+71GK3QvaozX6lHFSOQ2pwhJM0OaUOp1XE1j4vqMhVVbnBXRLuKbb3YwKe8JyEFwp4qQTr+/1GAW/5QMJHhXxWyFcV+aYAZ0ABZ0DED/VwBn7/Vo+/6vJPjf+Yc107AAAAeNpNj4EGwlAUhr97NzNJ0qqSJCGQwAR6gYgCEDCjxIQJguoJepQeo0eICxhQT7Hm7Mrg//7POa57UECNkB06vqQJjSQ6nxjiAuQ5GtAVUzi4+zSKGZSZHA8R4zIBBZIKjccLV8xH8cShzpYHHg36TJgRsuSNS4uAQJr5t0yaj0PL0lgWE3mjy4gpcxbcZKvDVdgTN9aN9cx6VriDT5M+d2RfaIQylysD2nQr/x8INR51PgXXfIvcyK2rH9MaKIIAeNpjYGYyYZzAwMrAwNTFFMHAwOANoRnjGIwYfrHzM3GxMbOwsjIxsTQwMKgD5b0YoCDAMciRwYFBQUmUhf/fIwYGFn5GOQUGhukgOcYvTHsYFICQBQAnBwwyAAB42mNgYGACYmYgFgGSjGCahWEDkNZgUACyOBjqGP4zGjIGM+1hOsZ0i+mOgoiClIKcgpKCmoKVgovCGkUlJSEl0f//GRiA6hcAVQbBVQorSCjIgFVaIqv8//j/of8T/xf+4/rH+Pf933cPdj7Y9mDrg00P1j+Y92DqA6P7e++du3cG6BYiAQCikzMuAAAUACwANAA+AFoAawBkADQAUAAAAAz/OAAM/5wACQEaAAkBgwAPAT4ACwGiAAsB9AAMAhsACQK8AAwDJAAJAAB42l1QgWbEQBR821zbpuAAZZVdkeJsHAAFQRIqkF6KfUXbckfTfyhBSy36La/AK5Afq3azuTscvJmZYYzHAKZmiBv7LcQXsvj7YHi//IEYoseHjEEYpcquIPHkxZHxxkJ7FhlVUZRWK5ugcsrdrJ2q1MvzmmZpQB9sHC4VQWs7f++sphzlnm4QrzOG2dgzCz0OfcPr1DBisJa/GcOxqRVFV429tdQXkvICpdaqpKGxNBRSI2YMJ/ulHt+6i+3mU+OjhSdnU0trKZcE6NykEk29c9IluNMMw4Eh4NDItwZDaIzSkkXfhKhPtByNRCcapcYiY4hN3drSL9Xj0vPx5fOVJfXJc7i3DCAZBIaT/QOblHTgAAAAAAADAAgAAgAQAAH//wADeNpsWgV4G0mWrqomsVrYYslqkUUtltkxxY6TbNiQjCfZTGiYJxnaLDPvMTPfTUvnL3PMjDomHzPf7np5Y997LcvOzBfP9N9d2K8f11NIhNQIYT/DfoZwxEkUkiFl6DlGVsiD5EnyEnkn+RbyfeR18gfkr8g/km3KqJWGaJzmaY2epm+l18iObims/QS9rv0EvaHprKczDVqyzm11zRxzuUd1s9a1Mw6f7FrXZLbDU9dhN+PNanJgv1XWhd460cnCmk60cIeEp9aNBgcNzjy13hWJsYGo6XxP57WuhSPYtmhdQbQYO1lEvJmsAvbberpN6zoEKzQqVYokdj/A043uowhXRAC/CSDoAPigE+A90LdOuu/F8UcQlgWAcYSHcbpsBZhHaCJ8CNe8DwY8Q64hKmUlRVLaSjvbpqqv7qs364qazCalpgrPrXpNaXvrtWZDTUJTVXAC3Bvt1jhrNwosKfrEKFUVmNPCSaLSqNd8XjXZFtVkszFO2xlYCaNtBRbinEyBKjBDLNCmMkXrtShNHkzJTFLcRFJgbb3mr/tEXC+pWSQGerzjrPWGJfX7rtn/EEVUs5K/XpumquRTs0ADNJBO3FIxCM02GwrSCvvv7ZmtSWpDuA+5MDuTlWIUtygz421Ku0xxWYzdb5Ma++DdF5jpl3+59qu/WgP8tV/baal2s/1xRikvSCaOZ0zkBYE3m52CyWSilHEcjPCUp0JOsdoDFrsku1yywpggcBwvWCwCnzULktUm2R1mWBnlBE6gjDktEsdJ1CaYmE0QGaM0yzgBbpJZooAWKjKcZeIoxWkiZxWwhyumHCaHxeJgHCwSJN5mFin1mRkv20UeemTRzFiDiSafQ5ZNvE2i9rtb91LwEHwGz/GiIEvwB+QwXuTwOfuGRexn7s6zD/7FX9S2tmoG3v0vSVU5KvAJr0CdAi8UElIwKDFKRcpRxjF70GZXbFaXy22nIi8wq51JDtFk4SVRpHYrpQKjQK1AJbuNo4rAU04IUVHA/dh9xlL4vgR0UWfULYohO3PLAi+arcwmupkk2d0yr0hS6OAdAYEyM6UO5D0IhoKA7PgsHswmhJGbu1+khP0sMREvWUCD/WkiEh4G+ILOZN3c00VZdw68BA+OgR94CTc03GZo2La6wCd0ACatUm1nXWh6LidtwN0P+geq92MJv6L4E6cysXgmE49l/lKnOat158/174ylUrFoKkV2d8kq/SJNgU/MEMstQkViIYTUDScyTejGHY1MkxOEe3rGTD4GI98O12tw/Txc/MYdYpftCTu3Uamu43cNkTH6afZOEiZx+nXGHmGOK2ySsBxmG3pY1uVeFxpA9CbhZA76OLnDpG24gRvr2KXtbsYOzoYyw3HynPF9PHpMXdC6ktHummyc8dnIKHS4Vmyjm2V4c8phHJXljgu3c1F8cScEz25XCEfcsu7p6R6t6zPaXX/Ihd1+WVd6uqJ1g0a7G+nTEDXI7caMXbtx4x0gF5uGTp9wQKwFqUL3fMdpiVs0C7ehi1sdgW7rtKdb5I6ZbsNNd4CbRgboDll3A92yHu/pPkPSkZ7u7+lU1oM95ES4N3Djz1O6sTlmXbayje432uBdv4ngt9Onu9+IfPq8A8cdyw4GN+eyE6fJOA3B78JpLpzhXnbD0PNBcPtpVVLbartuXHXJuCTVuNQs9NLGR/PN/EnHsdQxx5FcI/vRXCN30rWcOu46nG+c/2jqo//+2mvlryt/P/zB7bW//jpCONLY/Sn6T+yLpE2myCLdNGgfCXCFrhYA9gcG8rs9AmRpCCcB9BG5U+O3u+1ADfnX1rpyG4YuAYDud4kT7vO9Ted8fB4UJdrT23KnBboyAWMTMFaEsWK8CGOJnl6TdbWnqxqoqUZUMg3XCbguwsVDJMwZZHSm+e09m4qCGUXRpvbDMEZeK4kaIVrbJFbZCjsTueNk2935fv+8Ib+orMe2EBO9bjZKcCCrdRNZCkTKnQW2rRd6MBXog+V608D2FiikPt7TnTLQvy9eG0ZpL8ATfoCXQghhgHQFpHa18nwFpMbXoeNyA+A5hKUxgJtzCPNGFL+5v8nDuMnzIQTcJIWbXK/cxE1u4dJjuPQVhPoswDzCM3O4MeykJMssO8VBfIxRxZXUaJlrNqZYu1n3QYeDgnaUadalxDjwLRAa241M1jVFOQxkTQf939iIlrZQBqEoOGHPB3iWiLaGg5HqwnCjshiiTlOoZvU6ovHxcuTahcY3TxRKY191hlRfqWEzO91my1AyYX6rCXx0lDntidLEcGqqEuWqVc5rS+TlecbozufszqHSIe3IFevk/zQmvbvENk1fCw8ngtZtYRI8WWP3c+zT7DdIlvwF+Qwh4NFeMRMqkVfoIzvvIMsGy58i8L3TFODbEZwMgPAIAYCPDwEcMqCJTYA9famAilTQ7Y6A9EDjX9jd5hbhXU4SJxeYzdh7pQQaf2kF9GBF1klv8wnyNgK8P1GCnpKhCU1ND2zpk1vdWnMS3cnsZBNvQm0Wb68KxsSOSdzWm3JHNm13fbM1HFHJCt4WVgjccPdTPf2Upi9v4fP5nn5e61bO79M6BrSODXQ7B42cea+RgEYCFV1NjBkbjiXwRtQFg4yc0XkTycjJHTuD94/l8I1jcidMt7s1aCHV/XnHjZt+XOuuLKj35J7jyOKjFGAC4RgDmELIWEAhD1tWLMCUNjx3rxtgBXgAeX5BBbhVQCWtA5hHYHpoJD8C07kJ6FARGgg+gM2FiXMTDNZjx7lZgJV56B1fOLoA3rC1eniVoXmMITXLFGCU4RPCLBKiWuoWmHjG8hDScxWpWNun4tUCmmIdpvEjXiQgjV7rCr7WP5HB167ga9sIK/ju0/ju+uocvDRd5rIOihke5IOGfUzRLCZ9DkbBhBycCqZm2FaZ4s0I1w4mgZlNcdlMFixOlBwctOPUxyKxxdkRuZAJFqdSpbf8k0MJ21MlgaWy/qhbot/uO5Rx5EcPDzdXJoZStZY7mvNmR1Ozp5RUyT/82IQp4LNzsehvh7PmSCxsyhwptV8OHzl2WMmfaGZmKuFh+nn3cC7jjJ1oJYrOYPzuDzqG0550zJ1oHc5UT4wP2xMr6WA1rYy2hkYrOVf9sZa1cfjMsOgOhVzS+KUjdVu8GQoECcU8gvwI5BESSfYzGoHwmCQU1snB8Qa1UtyqVD2YyCuSuir4XHFrwsu+ze6KfR/sMr5bpvPs54iPjPd3kQmPOxXQf1p74JoxZvq0vU0tsKnlDW7cOrVeqQp7zktxcEamTYv1tZl0Zna97svNaqFIdSb9h+m1J9579vS7n9jIuwvnH3n1+NHbj66lgAIPUBC5LwWCrFt68EqwbZ0MKLDCS60DCnzQ8BkUgCgx5c+2Y5whXE96phIJlWdzvvr6bCZ1aL3xc6kLT77z6PGXrq3l3dm1x959+swHnt5IEyKSMfoi/Tr2P8RM3CQCXkwjo+RDfVpaxEQqSEsFPQyiaMQXJ+YRmFa0MLnB/qDxXOx1h4sYmIyWBhGyBzbhr4OjklG7E/6KH5RZrPvRot3+Ot7CeDPyJBW3hWXdEZiAFt7lwA48GWStV3RCjJimfh9EBzzntFtx6odPzTZa0zTGOWmmmUUx+xVJhMgCuar5imhaNck2kXvVeVjw2Ww+QZHlb+AFm2y+LIkwZBW4VxyLPAz5Bb9TZjckn09mqyYH/zbq9PlNBZP8EVEUhXeaTJLk98n0rNkqvBOHzJpF/pgoSeI7LRZCSZ5co//J5omVHOtzToL/LMg5i4x5mSTrPCJoI/ZYt9bJT8M4IxTnUFlnW4AwB0clA82ot3WwzrpP9alNNf9rzV+D/+kzf/iHzT/7M1hY3z0OkedtoDlPGo5QNnOFOx8zf7v5NTO30b1oBjmY5b7yzNgJ/slwJeCqwHUIrpNwiRt3EnJFPiTDGkE2G+lmF6y4sPnz9t+3Q05il3XT1uaTptsmkNxrPrphaBtGZ5RLjBr6Vvckg3ZmyzkFs1uxqk1vppX8WimaKvisfsGTirio0GhEJlsFCwHKF8mXob4xSjiiGJQzyNqBIdDmDBOGDx/yDS3S0M6/0NFpY8XuF0mPvAz8XTBWiARU6jahQBHAjBU+SyQVuA7BdRKuS3AJUFoQ6dN7lmMGYzFjZOKAse17ji2Lg/PK6OCYQnf/avdt9GmItxyJGu+jBoU6095QR4EQpNAsXczvfGqY/Yb7q7/hwVOJurtNt2GtnUTJHxur/QQkg6FbI8DlJ5HsEwhOP8jIL3dEcRtTP4e4/WbndS/hHQ/FkwuGxkHsu8EwmCGc4QGuIZw1gaFdsD6KSfwhF4YwhDEvwFGE0SA+IcxFAJoI5wFA7NfYYJNVhDUrQAtXL+H0MYRFmOk5YF6ZtfuBB70PFDnUW0+9+NSLL0yutIKXHPGqemLGlmjmjk7SBzfv/Pjrm3eqG+9dWXrhXPlbvnfphbPlbyaUPEMI/UHglud+/g898MDzOYANjgFPKDQoCtMBThLkOUybU7TtajuoRuGh7oqBZH5wZytYD/GRiYRQvpwPBmvBqNUl0v8ct5ppwFlK3r0puqyoXRWA3wUaSuRPDbbaYqBd0zHgozMWjzEwJnjWY/JegWzahiO2uA1GJCxWeQFw2I1nLjxeRTR46KT3038JyJUGtEegEcGsiEgRdHxE6yq4QUTWvVtdJSJhp6KBt+jk2b6oBTOFtAHBY8EnhJeyAJdLAM8BrJN7Jl3Bcf9gkkctU8M5xhiaq5P68DQGsWKoOSXsiU56T9CqmNTLo7Ulzd84fj6TH/mRapDxHNt5yD89P9cYcsYKEV/CQ78UfYsaUyOV6eTIC09eTmd58Sl/o1l1J5TZk+c3HshHG1m/KBJKJsAS/hlidIv8h/ENKmash1T4VlXuCOJ2V0PanQi2EuZ0WFlkNjywAcAkPdTTQ1CRDEHLsYVZbaCnB+AIjgeOiA2X7HE4AEwNvDkJ7RDIImO5AO4cg/MgStGyhQdE11bXE8DsEg/m5f6MsrZvVhLaUQLgeYRzQwCn02gbCM/VDF4/ipNWcPwFhJUhfIKhdG2KIUuhIDdNm3jOhexgyIc87wdntJosch+OPpREKimfkmvGZ34g2frBbBDqOjx93/cXktpyPZybW60ojVrBGfGKPsVvsiTUYGEknh5Je8J/r/LiNV9FK7rjf1tkEks0F/O1U6NxyeG2nZf8gYCZieiNeAAZdFsmAfKRvoXZDywMY42kbU5LJyRQZpNdMErJmHgg2rY2bd6Il21g5PL3uhE88VkAcGWgd69jfbNhdgVqxr0ErRNg27gfLLH3sEztNlMYMWy21W4ONWndhSHOr3Bt1cnadfrXO1+tFnZ+nz4Tvn07m/4BK5f9gdziD0Rd0ocV+n87pcaHTTL9i6Wlfx2SCCUjoGO/wT5LNLJlyM4BdQD0CrQHtHSdewWBUk8vaZtyKVGCjzHBN2NdpJPlt1GnyoMvKQPx5cGXeKDhQRdTBi5Bwd1T3iu4B/tPQU33yJ0k3cYoW9wa6M6zVtQdhGvGkw0tEuEmwJ2GPC+fhVC72XDNuxg44zw6Y4B10j8T3ER4zobLEZZxfAKA1h0c6BJa8Jt1qL6ncE7qqdPXgpQTRf7zgZnamfGh3OzZkrdcyjmiXtHt8ZignD/UzvljjYXMYu5/2Ged6XTS+ovh5rHq2Np4THJ4rAPVCZUm1Nx42k0pvUAYqQKXP89+j0SIRvunz6gFbDkR7VchCNjyCXQ2cQAsWsjAehmtTe5kILj5Bhx2AlOdAw4L0BBQVwKCEzkaABPFY7EvgGrYSYDeCHKncBDuXkGWLNkBxgxwI/MQXvKg8YXALUshJcT6FYnNtdgNdN7ncuglhwFWEdbKAA8DAMtvoSdv2Q/bYZpgVDIQ/AgvhAEuxAAeQ1jBTc7h+usID5VRtgDpPWEM8n+p72WlRgZdqujF8wAKiH4+MXa6NrIyHpu6/p4la/Pi0Zoon24VlhuxSwtT2pyDuSDHS5Sjjj8qn5pUs4cvjT74rS+elGOembXHp8OlSOPY6OJ5LerIWBNzI6loZZJQMkMI/Vvwr17y8YFli8QBlt11OtBjGum6qG2eFC+JDBytnWI6h/pv0roP4480eYRXEZYRRhHWAHT3QGIiCElEie3HYCN0iY5+6MKE3buv/EFcHzEDbz19r4dK23JPU0l9MsibRI5+W21WS7qupJ9YijX+mJl9lUrRHV3/um/84cc+SROfrAiEM3Ttn8FjqaRNFum3GhunCFb3BomTnoIKK5TyBBIyqBgclEJGCHZDqTVE8GQxLPj6450yv426OAKLJn1C/7jROcRv308t49CI40cOO+O4y2TciTdheBJvvslhVM462L1T7swdKGeLx1xMBBgzoV4iPAAAWotgB3hGBnjaBeBByClo8BHsiwKEh1AWCLeSAA6EXBalgnAU4WwVa2zjN8cZ+IcFQ4WX8bWTCK8iGBJcRxBkgDTCLYQXXQB5BUmJYF8UIIQvewnBnMQngM2x7HIWdi9mkXyEK1XUfISrLSR1HJ8QHgEC2kZdgduvK4jSQYxL44HUwQ0sYK800UTLcLBqoDCuRqopX6R+pLR2+dikOlEIRkfPtNonm0H6QLg0Ho9mFIszUU/HKwn5P5VMNZRPtivhXMTxrcnJasbmTJXbyeyhcmj98NhqxF1sTKrp2Vo0ok1Gk+1CyunKl4qeQDUT8CUL9Lvi5XTMnpwfnprzJoYxLmqgZf/LfgM9GvkHQ4A5AocezNEZalm/KGXhMTPvezRogyNDbYpion7gwlBx9rXI8GdOoe/PBq4s2XdlpQNted5w9uh+1m0PYyL5sBcFEgIwkpuXEVbj6GoSmM8XHi2wPbezoqHgN9dsN3DddVwXxHUmXHIGl1xJAKwVAB5FeAAWeEBCg+AhYeHVQe/J3tutxl4WqKEMxs6NhFobt4+4xy/M5EzKdKt0rBW/5E5WYpVpJ3MmGqmJafqv1dMTyezhq5Mb33Zz2RyVp85dHw0MhRvHatF2ITQUtGetqaMTmYu7u/3fn+hXSZa4SIW+g4jEVSHQf2P3OHXs9TfpO6hInE1ChvYrp5sfJ9+B0jjphdD5du/Hvd/h3fvth5IiuU7/mL2FmMhxY76EHuIpiRq5CodiMn737poY5vJsUHx9CuEQ2Me+IATDjPLSnvF4mmnIxhVBKtJ3BL+8co6ac3Q+/p/Fr8/Fv2UGaM6T/6b/RX+JZcjfkZNUBNSJHXeCTT7O475I3RxQ9x8GdbeNtxAJqSP3p+6QQZ0JYBrhqXuoW8ShWxxAljfobKEPPIK9eeidMZNlwpHzcD0C10tw8RubVi7MQakxz4/xbIP6hOw0zabb9D92bgfgg3a+kKVPDz4ILeEwSOcOWEKaVMkfGm8tZoAqZxEEUCkewl88ivLez/4y5uX8VvcEj8Ee4UkEZwYEdDHzZOZ2Bg64GrS67mLG+LUrUzTyesNodB4ORab7Hoo0aGj9Q5G2F1k0WR/e6nqHJWx7jfNQ8uA8JOIpR0EQLcijuMEeL3ZI+70vx9989uF9aga8FT849HD3FAJuB01ePrM6XZorKUPVsdqQV1KSuaRiD+djiZxJGtQJmBQ+l1U8wcKEWppraY2pfDSSapeHC9WEv6D6LKa7rw8qCYw8uHuM+0Pg7jGyQT9rUD62ANy9iL+LfAcCAdDH8HcafaPXtW1A6zgoSA+r4IJpW2fQCfI+yJ+nF6C1sPfz4WZc0ZR+laa2pSuyntvqJmpG3dy2ZMzrnNsPcyVgcmnA8VlozGJ+u7zV1ZZRiAhkGX8bgJdirWNW1tu9jolhltxxw21273TbUaFYH1dL+JqJ2WVcsSx3ThozOmvcvpAsVow8ToB1GeCGUX9AWAkC3EQwkq0swiMZnJcHCBUAUhrAVQS1AnANYLNdWcSfl3xN9G9LAAWECMIEAJ6ArbgnwstOgAvyXu1j8xHvS15YavHh1vjiFxBWEVR8uw9hYT8HfDSD85CYcwhepOi6BpAD2GxWFpCOqxWcicS8gnBlCacjvACwmV1qL4H9tRTOQQ+ydAx+vj2vqzjoIHe8N7Fvq1i0z+wFVaVM+2v8uEWbfWs6UxcFweUaOjyeGbv6vuMPfOrGyNjDn1iNLsdk9Wx95VtuHl569Qcunf/mZw6Vjl9px/J+auWt2dpodGKmcORSM5WX5KFQZr4WjeU9xcKwTP/SRXf+YaiV9aUPX5k69sqqNvP0N66uf+Bi1eEoeuXGjW+58bj+ylzzoY9dmHlureEpzFcS0/XEmYVDL10as41bLM3Tby1VWumJoxn0JwTgh0HjfSRM/rHvm3nUeHQUUxLARYSHEJIIAi+hHokSj7dLYLdo6rLhLnTPVtcle3DA3b/5PTLelH4r0L8F+53h/g1PJfeLz4PfXY2GDRo2dDgumxGsXVpHAaUOCrZ7flu6KgB9IyIIc0RaksCnmkKBEAo+bIRgPuSFVl2Fc6yn7olRBesptJ1VJb/iqmtUlf7mb1Kpu9G73qxrl3jz3vn/nc0Xf+uEhwWjsol96u7jvMUSjZps/Ouvi27K/fHKGlYcd7/MauyXSIY0yRxN9j0yBxw8gXFALlL0x52YuL337wpO4uEnEOOAbiwP1nkYkDsTMF6X9bne/cpnKjRU/Pg51YHL5rTuRfxlVgPo1IANgdoc9qtwRmbbeFSePvC8V/ezWAHBj3Ad4Rk3WizC6TBKGOHZCNoEwnWElQQ+IayN90uO8mCfqwgKwk2Ea7jPLYSVMK4B2DwbuRLBw10EM6LEowl4Pgvb1IH/LnDyTTSQ/STHN8hEM2p7vyTjilEODG8vDRUlVzSXB7k84lEzxUjuzFxeHqolY+PlaOX45Zq6NvzDqelSKN5cSB91ZDmX5iyPn5iNFx1Rj8BO8XZTlDFmT800Qo1S0sQLgeGJfOstNUUs+7PtBBR1bDv/xfP0JMfkxcrsLGM724SS5u42WzaqjX9u8JN3QN4p8wmeQeznMT1BME5wPJZddL/WifKGFNLi9qaY9qcZDnVK6NgPahVvrhd3idmzV1+MeMz4FMGShXGuNr+htnjDcNMIBeNJBii5AFZV5H/WkNRLOPQowvM4fgXHzycB1geT+idtCSBdj1Hp4JdH9GIoEvxN/17/x9SQYGLOvFb1n333hWrrgZfmZs8n8Z9nhRrWerC2PpdLzV+eGipKdyLncjanhS+sfeDByx9YzblccqFS9nxc5NPHnz+x+OypgsWEvie6+wX2cfYr4HnKe7Xc/L7lPGlAHoAA6Hm54xKMgnoCToUVcOX3sxQ/NPz9QnMnAozzgxAOGPesEzmB8JwHlRThPEI4C3ABwYawnsNmESBUwikI1n7J9gauNkzqpgcZjODLDioO53GNuYRbIODqN2m7fxA1VA/qc4zVBpEmqmpK3nXNVa6WnD/0eumBj1xyZvIFz/eEKg4hFAuLC5cmI+HJK+iJTgl2Kco47s73n3jf5RGO49jHKXf3uyiljdVnpqsPr44QSqLA4P8n7CvA28iydOuWmKlKpSpZzJJtySCZEjtxx07sMKfTEIZOup+TSYea0jPbtMxDy7vD1Laeh5lhScvkZWZqGrDyzn9Lki1Pv5n+Wn+Bqsqqc8859+CNk6INMeEn9ayGBpuWpzBaaaZF00r9BGK1mq6/LY26I6jpJS64yEdprzUXeyOJ68ZYENcay4sxyomQFrIEYzhhKdfL7XljyaMPgo++9utf+xG35RUjKR9FtYOtHbBgok0r9iozmbTCn/5aTjWb1dyv/cOAajGLzUCqTNIvfiq/v/B/mq/On7mwq/nPt4pHekETLt+w5QH/Q++dEJ7VI4xWyubstZ6wLlgNFExsRb/cUJ+AhVboJbACK19u1MN6IW64nchw0fu68PKdYju8vN/o0l+GTLklCbUQ+gmZVLOMZxMsJcB6I0FFTmGe4W+WWHtz5OLMOPhyb7HpSweCaTf7A/7ef/nBgiLSf0rhg1Wzn884+pjnDtCL/+28MqSFh5XdQks7/RJppypz6zMP4nwxO5wTwJVegn0AoTURVY0v6VGXRXUFMZaE+aXvHexrO8eIn/TojnFWJAnUg4CV8rKnEquQhiuvLA42ukLyjwNuWQFOAkOUQAJsB8zEIDUEyzOpwymarI1pKS3yMB/uu8yfgJuv85isC0KF+3byJ+DmY4AjKRwCDqcJFMB2gsz302eoXuJyKdOQiKcCQ2Nj6r6njw+Mnbg9NX1fW60Nq4PH78nnZh6oSdm4bNTKysv2nlDFIfscpXtfePD0Dx3N+Xye3krZ31Zub9jfa3U4jd8Q3dZIxOI0tXhS/CTxZF54IydPsm1hcReLRM/dqJ9I0mESyXrCJc1MJC52lJxEwyF1zRjdVtLGWJhb4DOIu8yZfHmLe59bvLqUBj8mUpCybOvFfQmwZWsfJhH/NoFdpq3mi+XUqi8rsXE541v1l2TSUKvpXPMrUtbHhc5C3GlzGpvfJr510vvaHcbVF43Y81pZqPlPtNvO2FXo/f3CIT3y6UFFKyKfFUyeFQ9PCnsFSYjTp0KfLfTZRx8T8TD5A98rd9FKTeji1X4PVrkr5ApSXmKCvyjJRR+V6Oo6ImJ16b+Rflfu7kmWod8lC73tqhSz4MfviisQHIX/ZcfGNHJAJ1crNlPFX841/VkpXq4GHR41YA8W/eKn+B9qzB4f0UweV2Jwx7A4QTRqccNz9FeLbFT/qxL91TAyPFI7Ihr2Yy4C3PBDQvyH/SRi2cZirlG/nYN7SW6mCTMXge7+8VjJop8HkR0NPQCAQ2KtJ9wIKwHmAXt8cIEI8Pcy9EzvYrGxWCx3GK5dC9bFY+0DhQ4UMFxHOfKuBIWHcANxBZuMEqfN8vszn8yI1CGQgakCOE7QVhElE2TWTHDWCrBB6N0ADyTfi58MmPThbt2oOYrLj9FZxkfAEDXEmAyxJo0KNdvF2SMBOs+e+nMp6/+6unX7znTlyeTE9ZGB/gjxdV9m1ZuVN31SSntppMDCryQOHL03H1JDM798oPkPVm+EM7g5QELsMjX/lZ64NnoyjZ4i7NLnlwBlsAK8KqB+RZ9MkIC6Y+G07DDqxqgjnzGtHtYu0Q7orIt5QZQsifaEEWH+UCX0DxMaFcKzpi2U95MI4he7DKsf+hV5ZGI0GHHYDZy1W5rGMEu/ro+90HLpSdM4REzH7Ulh0d6uuI1jCASC5ZOmKyZkFO0mDN8JBy4lQDvKWnpoecF7x0tXlTEsLq+Dh9kDdJW6Uo85vDg0QiUnTHw/bbLTBvNFkSy2eBnPBAiAK+UOeaJEkWibPGk6SHcVTIHVOqVUto15S0ua4W+55Cg2CUcaG09ijc1mbJgkACOAw3akkOyzKO4bc8yh6uK4A4KB2O6Z2LUYnUjjJaoEH6nGZ+KH45T/Ox+/ERdbqeXrgPOAuRQuTBMECZZn00f0CWzUCROzfVlCn/1HUhZDypBLKVBP6yyCoYAyNBLoKGDDzGtSXjZaE7+pfTFtY4Fs4HcCBVkuSL/5oSRLLn+Y1Azp4ojVYWJfuH559a7Irt9pTkLlQt+I+6DimiMXHmJf5frnQ0aHzhdkJ3wWVhETOVmiAdjZmEpPArytignECgPQyACzkXvrloCRZ95RB1VX+UFd41+9Xp+SSgfqxgSUntiqWwU39/vdwjqnnfcUFc2I+VgeQ1r7PgvtD6vbVBoikyqrrdr05aPqBVVEDHVG0ITD9DlHn+v0MVLZi4axDbeKm1H3bIGmAPCvjgK4Z3qDgKGG0pdiGIxg11gwZSiHPfaPf1zMjzV/NmewFdJ/7C8oFBJ4L5voN5rkHMSvx7n6pJjbs6eZcYQiVKZiETdb/baeZubIEfZmm+QQRG6ZvcgrZXLCqk5zAXFaAdYh4M46wi/ZTbymSDJ9z1TFkqobYKk1n6bXgAJxwEkLQQZwHXDWhUPAdQBPKF0G9AEOBRlRV5EVkcyqHkYQb2eYHAREwesiqMVj2YCLgBsWHPpwCLitP4lAVggsgCOdh1kT/IndyYx2FmN9fK1a2n9j584b+0vt7eVw7cDo0K4BVaPtyO5KkD2459lTtdqpZ/e0t1uuHhoYOHR1S2sriFwv95EvmRAGhQ9z0lSowq5dWMet/jsV6EECKoFcUjjFaU4FwdutM99l/vaY/C1X3M/j2VT2s1TqUH/5sHQOYcqDMmQdcFglGO0nmCNYHhuYGxARezoqXcCF/JpjuGYG19QAowO4mmCkHZJqO4y1DtWKjM50e4zZ3w5X5OZ/kEOk5APH8w+WBh6c6+vffXrYJIeCpm2hqNsUQKB8stzzQNUAw8duN+omkFUePDg5caimMpGxp0RD81MiEwPFLX0HDtD0QZxbE19rce4EO8FpOSihgm8QHEuwOEgRLdAPbmQ9Dwn2SARlgkWplbKmnaU8+LlLL3QFtNaq56gslj9nMcXVTB8mH+sK+l28K4hr9RHpVe/SyLooiAnRaTPBrWA7V3oJkA6D+wE8WXsmgXOAWxlc0jFGeKTYVCJQAPdWAMMEoSqBjYCk4BJmx52m+zA7Po6/OG6Gbg9ivBWCC1yn4O/kExALwOOAhzIEjwGOFgmCJQIL4Ej77yzbqmpVfMDkZjleHoLR5nEW9n3kRXwtf6hSOH7+2j3RoDx46vTZ4fBoZHX6+0rRtfQQixb7fZIh1BOy2tkXv59QtaTqGklVThhkQx2pen2BohMaNwOR2Y806tci0G0N1HJlBQXns7wt5k4cth3gRIrgKcBCmq4VeElyhWjzvWSyu1chqwtolqyZLEIZjfox3ihAAJHNE99ku1K553hCA3BNJjgEuAC4HqIxOaKex4QzHMYoAzKAGcB4kq2T5DMyGIxDqC3TlwE5XDvKIfn/lWlk3pluuxpyeiiIvoJQK0Wp+c1gXtLy3mP5E30DhydTu6dLDw7Vbmd7+vMp/4PbQjHXjpn9R6omR1umERqwBivzw3Mn5W3PTUfUntQ9M9vz7DiJ9h8c2zE/CwtgnDLof0dSPcYKnA5WD2o0yNZG19FQY3GIvBwyW62MB0lKxpdaDW9XFIziCtz/NNlxUxOv75S2W2CWDGTXOioS746TKhibCFcFCTqf4yfqY/zrxTEas7GOpbZ8zHzRjBorO6QUsJPvOSBMTggTYFuWoAo4DLgA4KG3bAEj2qdP/gIG1kxwjmB53D5vF1vPfFx/JvbwuEcIlqvZmSx6NvhTO8+62cdHryV4xu8OJJgpjmBsxax5b9SbndlsfLQQGpg7MjcQHdlV3nwuQl25Ri3vH4kNTQ7MH54fSEweH5s6KzN+fsZJaaFyNF8r5kd2jxen+9WA29dX6fP9oNU6NlQY7S3U5kf65od7oj5fZajio1FEyfIxsuPCwgnddwwJ5k51oHtlyULjFqIgwspSkAZLIAnsju50m88Y1CBJiLlRlz1Mj1/pyrtTo9sqiNRfO8Vd6y80/zHYp72tqhqMBlGcoUAkRUrepvXJPFB18MclKoOXpEFyw3589YMmuw3cZ6dI75vpd6eF93Hu8ySJ+0TGc+J7haRwgj4L9LlDHyPiILzgNAlXUGjxaGhloz/V8R7Adw4DtVSiv6HNT+etN6xkQm6npgL0uLnARwTEH2+wovQCsA1wFlAl+Mgh11nXoy4DsYRrhorM2n6+XjK9LlCiD3qVfE17kyx0pXdrYe8xJe/9g0BOSm4+Wn3ymUIBAQCnqXmhur0UOHqW/bjVZyNL0W9qLmy5f1Pk6nX2XnMAlBHITkRnTEj4V10u4bHxyoLtgJQukCSb7SrxFLjXZuXul91hxeaEG4VvgIJP99qkRn0YOm4WcBZwjR/KBEH9prjWYQ4vEdHbFePEQaeFBno2aPeuN9qt0I82ghqgYAdxeasW4LpMtKzJs/IR2cCVK4j+qAx5BIwQMJ2YlNG3GDqBG3hCYiJUlP46UvqbkbvkuDObr6i8XxYl8TkouYjXtvqYU/wpvg+3fGTfgRYNDe/i3s0ndBq6iYb+DuXqezv0CQJseojXhkK0usPNqeHiG15G26g/7IMqCBBcIYBHrzTq2xW8GuAsgLrJcV+PfnuEP7Ies9lps7GLtJuqGxNAegxlI70dETtPlboi/Ll24zrq56wgN0ADOAA3bTgEHAc4AJcBmh3nAJcBh1HXWnCOOeecBrLg3RhHBa6uMqMcVujUoRBOAUyAIMHyIfWsKtLZCMwZguWxyFwEJ6JQn9EZ1G1msX8keh77oSieEcOXsZkYMrAx2FWAh3TvYgeuuAi4EAMkuljCwTZwRWAIaOiRi8pfJbPvnvyVX9y8BPYwBvLKmaCYej75kxFREZ8zuEjIPHYwSXz138ApTqvOKY+86Rn21ebYm57h2oi06M8iHsv+Qq9OQW5kP+JnZsRGgJaGzt/3APYD7mgEHs0MNvEgrgaklvX7AuD7ICYsAtg+agMYbtTvj7YDAacBGbOGmzPexXQDmG0sX84/nif6nISNWAEIBBv96o0BOX3m3RgYqWfifNYdznBzPI59c8aDjebJrGOfx2DThk0l2LSXaV8Pq1kJli+ab2EOVnFiDnC440/OAi4ANIDZBuBy78Y5wGOAOS/4DTAXIBgHzEnYA8ypBPcBxjQCKYyLAWfSOARcB2QBSgZ/EvBYliAMuExA/HPEjInfQzCqERzjyWtcuQ1wFhDMdOKEAfLykVzKWTqxl8Aagykj2Rz74X+gOPfib1aSzVfS+V98q5wP/GMg4//Sp6ScxGyeTOhHXigUSaWDlf67+RmEB/3mb3/HYHNwG4yVWNbsJKVE8Dd/Y/MKjNdVPEM8FkFmsx1bdrdmamNj+bjxkhGkNnIFg572PX7EZQF2gCoDTFxVqSjgp/JEqFAAhJROwtw9roFLIwQDgJMxAgFQib2+paaz1UZ9c9HYTuCrdmkds1wwYdTceBQ2iMUQnCdgXFblVty1ukbPMCSZvWclm/10LtNM939DyQWIhtnQO96uFBAYD5ib73jZFAAJX2IP8KC82WVu/inLkmKHfOaIdhM8Lv8d/iMCVpLPIjhpkGAx0K6U9lhjmNsXoAB3AXoJ8LWNdLgNRh4B5gBfgypGqJmkfsWOE535cfmMdE0SudjLZPzKHYr5iC4+EKlT+gYiMR+vbmMUyrL4sOejyA3ZtU5+hIq7AL+iPhLQy2KkNX/1Nn7PPOA+wK0ApEvidA1g38RPAK4DZgkoL2+gUDBLtJpSWEKUeSCYrf47++Xmb2xW+cHd5mk2+zlpcHhQGhIP/4g8ODwgDa9+gOh48K7GvLzrtqbXLlBdI18wYwV1ak/rIWpzucuqWhLZS0QPLFHBMx0pH30OfvrixU+Lnyp+Z6lA43P3d6jf7m3r+u0EkffbsfL6djh02lrYCHtboXmqeFkxDAcFRt12mvBX/BeN8TsNiIk9bSBqGXhXpanBn9Ndy868XT9KSVWHfPT5K/yofygY9hbBM2VWZ/9X/KpgFa7wJ4vEM20GiYuIcYtXRNoXrCJGiIl8vhf58kwm/cCKyP0G5UtnqAK0brKsj1k6zOA1QITgXpqdUmXmYal/jr/v2LFQ/Oyo+NXmv77lnm1v5rbJJvb2u1cFg14pi3y5qYxBEHiTDcMLG8pLAjhFTsgJ9vbm+R+v4o02iVuY0yDQG23upnLdw1BaDygz8HOnon+/FaoU8CgBMia0YZZcddKgMGfwE+ZwPEJZDd/PSiab2cDg4efIL/wbUaBq0imm1/KOyogNt1fjWBzlJtHedlYbUoKTaPaSvYs5yh+Vl0/mrlAZ+lKSCl5OJq8kRVywVDa+RFcsbSZD/uTWjmQVibBFZcN6NRtbPin3VeQTV5F791oZ9R8xag9L8fOLKZL9VCwlch9/0EDLhPDzqGQYXXP1nRJGiGC5X5qU4AJGoBMAxl6yeeTeTG+11wA6hXDpKOA2vsaF5JmYqW45SJ8sfWr0MVIDSTDGoORQprpW+DdS4/WpHra+etVs4UlmvRqQvV1kM+rmHpUmC5NRyQzGN+/O7Lg0azRQQ7075Strdo+YfWBsaHPcbvq8mtW8hvH5orf3B4Jxv112SSZlJCEV4tL8pv6JpMdYmhkIGyy3oltiihbpH+3ZtPCM1BOxP+TUcmqpjHFld19lr4n/Rb8/I/wWJ0ciSBKxELwThBS0CkF43xUqNMJGFIAsLyTuJPA1zJU4wWKCN7rWY7mOrmibHBjDjqqEdnwRArEAKBNAp7KVusXBVaOD4kOGl6Avo2vjc9UJbgUEASYXwbE0/pB+4jzgQJxgG6AKuI++DxA/o2t0CJRud7a2wqOs1d26e1dsd0IVffsH7jv17JPqYH/G8fuVTW7/cGR6lyvSJ77Pqrm8luavDG164o3PvGCxuy3snVsHm/9sd1x7JDc7HCX5K5BkvJ8kIyEsrc1CcShngc9CoEw7BnoHMhcD7G1FUFQUVnRRq3sdN7/BoVeQLHv8McrugkRBvWU4ulaS+5AJ1g+ARy4eAXALfagHe3oj8L04MQ+Y4VV7BJl2rSrqpRU3Wxez0GOM7/fvr00cHY88cXlgd9jgdYaLFr+8bV4ubS2lhv2zqXJm5tTEned97sSB8E2T6cyN7I6xpOQmzgJdRIk4K0IS8fedGpvlsnUKuvYEr4xvJUJ58hDFWDIq4hAVBCYbIFCe2GpfP2cruZutusN93U24Ju73uh0mbLg+WgC8SAB15F1BY26QJhJORhA102E4PXp0KEdQBRwqEVwHnCdA4g5njwMOd766QJDhgt4iZrXFfYrMyWohavo6tGXXTaFUn3bm9JOXMkV1V2R3Sp2OTEZV282BcYevP71thzvadyaYj/mfevbp5yy2T1s1p9+8OmeV3ZLxkYHJKtPs1ptnCttrMVCad0sKQlTI692g9SzV9yCg6Te2OG+5bJ+yi7x1L2h+iUi7vmxpIy3rQROvUgqWl4Wgl/QAyBQmMrm4doUeSHao1YqQAQ6qkEGVxz9n1SOquFZe04lnJlqcZSAxHOIVm+wz1mTvcHji+KbYjYdT26oJg7H5Nbm4pZTa4X/v2CbzCmOVWV806MrMnNz09HOB3rmaLyUV52oxycue2n3K5rNu2UVyGBME9mPEbxlB7y6z9yCvo2eyeZjoBDE8EjMBIoq3AfvPz9kgwjHOSVJe01WgSqcJGVQpC+AgwALAGhL0rDwycnYGrYVyetTS+/C4Nn0KKc40mRTmE1JLjCihixqp/AiZx2tFCQDME2zQFtJCNoPDqvZGCmHXtWvDvd+JpXalCtHanPhfItlziTHliDO5ZXhwsLlg9quq38x+Ugs6UpP7y35kZ6J3e0VN9NB8NCscYryTsL53EDEjPTsD2Ev02OtdclII0DCICulWE6HdOchrs/VNr/5Vb3k53ltB3wiZwD38K5I3mv08Qo8Qo0+ZPlP0MVIeRb8lTbekK2mS9kJvDxdEfh5jMEJ/c1NPL7+KL6mFXNF240vrzar2ACToIIHMjyfBKe4pkz3owZ7QKlGgZTXqdo/+pXdpF6MqQs8uXknuSWBT0Ddl/eR4woPNJr7BzDXNeFb1wBpPGzHHSNyPCUHuCZZntMOaqDuSy85UT4r2I8gDuQGFUYJxAmL986EbIRQxd3oPxgBFwCZc1kcQIA1RwzobllSrT0Vf7seoBHnQsLO0Tw1IBwHed8daDQNMlyK93vnV2rw6scVqcT2knjsVoEo8V//M/tkyY6nJo8OPLPjilVgwkpPGNmuD818ubZmPZ0O7dmQGIs7mXYdajI0PDkxsroiCHMz7HXF3KD2x47go2oJOSfEHEtViejwnz4+G81HFbk+pSp/Lc6ianOgNrb5ID/LalaFwtepW4uwLoVI8sG2wNrUZVimmgHGSxpLwFZ2iQeI9mwhSAXiDkQCIEyyfCC5AzQRprkQHqI9hX18WADNBtIEKuDx9dacPpdQExCgRXViTxB7JjZZiV/wacWIrWX8vRvCXAWXe4oxgcT2a9K8z2XlAwQKQM1xsjdjPEPCCuFaf47oauPU2RpTEmb4Qx/84lO4dp87GkNkbcf9RLMUVPJP3juanikFf0qO6HP+y595ANCc3V4x2u6pSDdFtruKbv1SeDlT2T67SaepLgxtlEf9EzApfoD2z8LUeQcjq6yoi9vjjCrc/FwVF+Bx9GvT5K/oY0U5Hd6fu9gp/yO/+sn53WBD6eND7x9VfQqRuSm3dr9L9Kt2v0v0qJHifyq7SQ9ojaaSRLDN+bz0YM5RaA1Z/UrcP4TI/auf1ZnqV2Ucq4hZxn2ggBwNTvB2Bi1aJ0Emvfou/8ZETsYXYnZjhAVQGh2hwzRrD/mKiQTK/GOJeg4m3+eep058vPVRGvW22vFFJdKb+bi6gCAmvN1N6sNFb2BYALxIgzZhYqeeEnnXjf9aBuBA3KF3El9PuA256zWkPpjh4CCV5QqYTxSD0Qzs0hUAlrijIBOOAfLAdVKJe6U75WZnJwY1sY0BUqffzgYzkyeUzLk9psKqNPhGuzkYSififJxK7evakVM2bzaY9aoi9pFHuROrvz7uksS3TESpDm77QZ/+q2d9mIRirSX9vuV+2+FpzooXGzt1ewciJekpEl4yt4Agfj2UsFSRCpuzl7sKpsh3UAizoMylfeSux/h2CCrP8Bf1QbU9GTSTWWHl1q9Ur6L/BsFsUqOv7ICexSSP+0cSiCCuwXVrWqTD30VSgtZdb8YEXYHzM0NkSZ4aJlbpAucWlYeNLy9pYcQxu+xxMScBJgEDQmkay9BpZcEhnHYiuOUXZWEDGGjCakCJK0E9YqSezMvim1M9og7TRaIMWjljaumZ4mwQkChhAJDBLAJkoao2GouJVanSExwLIAGp8r4KLAIEBgirANgoYw8Xb+SRiisp0/0eChWyhViA5shTaPXMmAL9JIdDLxuDKrCkmnGoPj9zSTEpbQbU4sN0qScMnpv/QHpEsgXQkmInIXGW5k/7p+D1xlXl3j4V6s5rZv29TZiTtS8b/KBqxSOlopepMRVWzy/SP+S0lxR/Nys0/NZG5olIpM/tBq+b2ma6Wp+3hSnZkW6ByYOrbOot+Mz2ak6eHmn9nd+ucIW4VBdJyn9fnCBnxO9BRfb05Ql6QYX205ggvw76efdZ9BswROdQQljBHcFO9e6w7emKjT4qBT/A5ApagslKPJHzrlMLa+JpSBDkCzAzYTwNkgu7pQSfyxjEA8cWtfxSO946rpUTIEov8sVqY1rZlOnNDXlPd9n/fdcwfw9QAmrkcIKfDb7nSr08MFl/Lt6KN4COv85O6tdtZOysGOAGYAsTtoAYBTByKpMIa1rpb3ZUNKaYlhfH6sdiaQXTZwLv72srxYQ+jlKl0VBJb3ZY7IgTHCdD8gssu4opt0iG6YnlGPayigAzXzPMLEwQ7CUbaNSyvt+xUITF5tEqJ8PDTD286Nh456ctQI9aMj1hoYse3pk7dk8rOnJx46gV4oH37JpKXrvTvJSSyxO6Oii6iTkyoCE29/M2IOcu4QKH0juYDu/SQXkk3ELha6AWtWt0PAfIWPGQib/TMO0lQpXu1wG5HAYlVM8WmvCFexhjytpYSjhN7hYhF16hqtbKretNdEHAmSHB/gWCuSHCsTHBZXxfAbA1aSZ0YOtfeBFwI4jLcMI0bhgGHAA/h1gcIlO9iw2C7FgFLsnaCIXrZ0OpfJOO63Es7xu89naAcNbmn3ri/OjDu9PelE9WM5IqUv6ai5pkL+ZWhzTeenTo/m7U5fkl0OMSrk7XmPzkcycmDg4WZoR49DjAqSmyVR5jew187bEYcwDxlxgxgBqOGscAy90Rooy9ovJRoxZPq+3Ldlf1dtp5jY8BEMNh4n7TNQBseTbJ1RZN4s+KhNMGjgHMERN+d8ft45W47s4TASMeV71h71Q1e/KPu2drJU2+8XTut+OK+v4ilbgyMOf0D8XvmnJH+e/Ob7zzzpmckx+oPGxzcxvuv3OQwi5mtF68Ud9QwNQuA26KBtjf4j4u54LPqK7osGYkaLm45ecCsSEZsaadt1rcItukRpoNw+8BKB1YwYwBlHnU5jNA1iBuj+bsuCZh9yKsJuNnrzhkGBSdfciRcUl76N3/cOx3fFlONtkRpKGxxmKgqIZNu/hGNuKoir6Vr/EtSPu4zuGI+De/WT1GJN5IUVllwbbUEgde1WggEAqikFL0lf8UlCc1lkElsMN2XyksVlMtXwCIjBDECvHm701fZsDRY3ZB36p5rvtV25fRCmdVj/ES9zL8mI3JZKHvLIl8MZGiNNYoGRNEAlwHjJoISIGwj8ABG7QRFQC1B4MsQGAAp3V3gj7gEeLz7ESHcPYwbM4Aq3Z1p1Qt1hd7c4vp6IYyGwoOVFEauba6l1OJovDYTNxJDZZ1Rrz8csPPzkaF7sqUdOdHtUHsdMVdv7Q09uWS8NFoI9ycCTkd8a/K8yeCSNFc4l6Ae1kyylpU97vQ9sUesYgWj5aHRuiDeFCLCOzrRk+WFnjs9ImImZNUTLjloaKyNjinIO5X1CApGpc11ykZ9aMX9etqEcMkhcj3oQdwNll67EqeojZOD/ZGd2n3aZc1AzoXGRTOvjcLvvqihIBJwmyBAwshZFeETKcj77vXomy9FDZGulE9985uzWX8tYLFGMr3Kpql9bCVkP+zwWX9gsPkXmwZNFo9N8ju37WKT9PY+mk8zxKt9gl4ZIguYL6jUSASP6isE0g4UVMsOqQutUCJv5dUXfZR5fBwnU43XU1gFOiiAIB23FQc21NMvFsj0JYLovcE2njZJchs0VdDWmyKwbQqAMAFRRy0VsIaMo4TJtNYKOkqdAK6vOwqZ0uNxu81cy5ttSj7Wt9m3NUYH05GJuGoxmtT8UDS/uRj8ytTtTdyO3/kzc7nJorJ1mAX4cXPMikTDTbmUCpJFQhmEV4h6lHITQsIi/5EKI0l3MsgRB4VAAuwDCIw3/0ik+JGys5HUKyhKo2IUN4/ZKKy77qjbSOFaX/nuRdfXe/GXUKRQtI/bxVYHup2DH6C0k+M3Ce5VDGgE6tSPdGq3DP/xxUjod1xh36OS6LnsDTvfZ4/4l5zst+xuTUV2//cmp1gv9VNoGlm8zckWFf6GqJBml/S11EAFB4PuAiwAgoAtAEeEIAC4AhAYCnhADztpPCc/qnv0jTfCsAmiWMLP9xcjPBEd1b+I6ZuEfnWab9ZXbCnrey5w0MmaKt+zO9ApmLkyNcf442MqNkJirRTTLmgkIMtpNszQD2NntO8YdtCp844btKlrDuQZvASyj8BMQOGGWTJbj9DnPH1u0MdIbnVkAoVCchRXAcYBJb4Xwx6gliLQAOk0Dglo/PrZ+gEc4biuaixH/TRf+wV32Nlw93iOukTPw9FrftGz2xHxvE9O/1j1TMCgHKdxJedFU6kVprmyY57N25vvn5tjKdFp1zS3vTnpZOGDB5v/rdcEsVUa5Tw7oHvUAvnTMnnUelD4CgE0BmvoSkPvXFyQ8RXAIfMopQM1Zfoyjdh3NlqzvIxZvtV4q+sWlf6nAlhBxm1xmr4bLd84zn3jFP0PzYQISbaB+uYp2H/xTnlQt1XA+6a6LFnben7AqMfDvC3L4Q1jI8Qd2MiO+DrxqgqQIcANAC/AvZ/gI/d7HvY84TFQeQrGfCZIMB0juEawfCh2NibSfgq35HELgb74ETGMcINYiSkdU6Rdg1ObYrnOEKMEhw8sK/4iDelvukPOhSsE7+/p+dk3uxXn152K++L5pPfdgQxz/hn80RAN6TveYXJaVNVn+eo32qP85jc7XJrmcqBK4eW7BdEIuRX+mr+dBE/KLiCfAagA7jfrxoqVhFO2QnIlWNkAO+Bgp3SyAnAIqI1Bi4NrpX7QA/6XBE5HGc/hzmqkXE/zy15HyXXLrUYHmgPRLBOmArLg2i1o+0DctIYk1/pGto9k5Ko8g6LKIzK8LUUPUdE3HcngYtIipoFiVHR+BMGoIsUmf0dOPx0QPSei6vvl9M+HSqU+zeEzuy6abXanlX0BSk91O5p/PElDY/brArJlb79sCvTLIasnmNRITkpE2g8TVX3Cr+i5PxM6zlv5PkOD7PV6zATdaOqsaWhqrUe1ZDHD/YRIGPiSAxtNvg32Pmw6pLgEwUs8BJPPwl7q/AMv7fIf/qx1S7Wh4fmc57qHwl4ZvqgAQw0zQ/3M0Ah7t8UiNm+xyKd7VauB3Wr+zRdr7y8e7lXZizdKB9Na8wC52sII1c1spSqVHLPqGh+cw/nl6ZYaMKwAqUiw0go4J1ew3lME4c+6YtA1NSS4835hLJmQwitBe/x4ezGu5SnjXiNeYgXv52Iv0d1GXJTqysWhnnM5YuuzoZQZYmmDWM7Z77U/ZDeQLrW3+luWJzI7MzAbskhKAO7P4s5sH0rcd+PEI3oF3ZAd5U/2a5hKjdjfZj/EuyIzc3jA43jYsexF3GbPwgbJpqqDNfrHsWoTTCY/KcJay7bQTpCfylafL2azxUrleCWsyoms35dLyP+vs68Aj+NI067qHmZmntGgpBlJM2JpxiBDwHIsO4bEsZLYycaOV4rD6GXMXTbHy7x7fNL8Oi8zY3R8e+tl5v3vP3428v+9VT0jsBaei1Nv9zRUt7qrC776vvcNxasn+oYWhsYTU70/q42XY6kfpPvjTsWguFLV1A+T8VKjzjg7eeUJ9jS01zr6AAozMlXqA6hXx1+7syfrdeX9v4DxnNXpbU3jbWkcCEaPSpW2xi3HVgkR17jgwesjWPKIrzeo82g89nGw58qZU1t1PT4JL0wVpMUo009JThK8MHVWhbWh+8JCOvWqF7bCzC68q6wYHQCyFoI78NZGLHstR/HWHsQmhgd9pOcMHvow1lnehYe+U1BaARqA+8VbWylZxvCSrrPcjPf2GDJ4LuAwzuzpaSCXMxi2FOh4L/Wf/eJNQW9sSLw9QXug0kpebAr4f6q9s4Fo2BPPety5uCcUr93UN8ifI17az2vjpVjqRxte2veT8TK9NMSU8Dj/J/5mFmQPSYeb7ncyayOoElBJc6q0tYpHx5wuJ8KMndoXjFAvn+rUGOOClzsPb9S9z43JRY843+JArxhwnZtgCvAEAPuFVsQmfi4YP8dzOxPhWn817CmQXWMsGhmo1UKBviDfOVzyR/xOr7+cpWUIhkpiq59gqwpjRuZl13dKn+Rcbp9SMBsDOKXHmgi3FwFuehFa/1nhGYnWXrdlhtkKQYCg25ApuJv0ArpGh1en/DX/uuoWTyyt/bPVyotLbyIGunhCsNBNX7mRf135PZZlZfY30uXbTOOWWqFVoJJXILOHkcLhLq+wsIvsbxhfa4wuCVEFF1DrAp2r2OLCuGM5h+p2/Ra3Vrcoz6o4z40/DOi63A6pbsn+seIMJWnuE1PhcemkAqNXQdR4xdVuG4WSOgwoAPZKpmRsXcnnh0UNVBYmGCN1APp5R0JofZhc4W4x5CM3q6DbwfnXfQeHG3edTY5eX23UyE/FbQuXjB6fxeMhJ5W1z0+MNZp7cn38DW9xvvzsyPGdRdMf/V7HY2XtVtXneOcYeaq+3HWacZZgjP+EfBanNMvhoA52VcnBIZ8eVkZWITXFdSPgL0gN1gbRGMuIR60Ng5OBTo4HR+ipkgxPIpoTlOWiD5esttM59LBo71J9dalO8ZF17Mc8eAWT4yOo3rcjtBikH4No+RKDZo0DHUz27Q8RaATZbvOgZD/DG0XkTkIQROHuKhQ1Kc/rE33Iqe7w22QMGRVBgGb0GRHV0s+71gm14xhkNMBsSINuUEHxTZTzHGpO+UI2ccQZSAxTWNMdcRG/FC56h5OFEQo/CDle9wqjSeHhWHr0UxoLfb3V5JwbnHfzx1N7hkoU3ORzuPqq/QhuyiQDoaGDPUPhgXhmOhjrMNInYwemrF7LsOCly7F7SS1uByuxBnuReGN9ECZxDtHDGCK/D5Jsc/VhakgKKEHDDWaamlpBMKJL+beNgjDtpMYhlaPtpVUasMt31Sm4D5kxbgwCpKn7Xi68hwkew1ZEPjQVOW1f5SNJTrUOPa4mDzp5wB8wJrmxyqXQiZOPyPn7PI3VA7m5rMNmc2QPDR+yuUuhUNllP9SYSwV5KHWoccjmKodCJa9lbjk3MJCj9KeHrO5yKFhxW+eG5zJ2B7fbM3SqNTNA+llzw4cyVrvdmj70e/25XJXXcrl+9HP/jjFlF7V/FX6nrL1MzMDCqL18QmuCADYaHXmxmnRdP1eMU2jFRludGH8CoprzOXzL8eACl2GuCItozlgYnRoZtxkBFExhZFZAHEP7NOZdC6gL2jMVXFTO0nTtIds5n3fHKTTnwyT7PLHAOJmeJSlVKTUpzVLSnxS0lnrIrNA4kzEzc1FKUapR0p1cttFuv7CvhMSfFUYFLQdU7YJrE9+ADsNOgKon8AHuB9wBiIKs7lzsUUFchzosJGzU0g0+ViBwEkjXd9DgI3Um3sglGWmrI/ydl4u5N73qrW99q3CGp+Vv/1nHIf41r+o6xH+m3qzfK33i76VVPtJ1i/8SL8AtXtnQRzKynZt7SWiTdOhVSwdqdZMDNbrSBo1aTm9QsaaHKCT1orzk3X2yjv8+uPZhvsZb+PImrvwl/3uqKfewY/yjktcWFl7XXoyCCJb2ippMSpYtM92/SbuvE2AxVpC/UbNutxcRvFeRs3lSfi/ImpRmKZ0SHg2dwNJaxaidOU5kqtX2dZ2clmdp72HsRa05Wt0U0UCjtFEUyzw6QXGsI95UMt0j6JRTxqM+HNESi6VWFa7Ju6Xq4nVCDOlwt/0q4y3fBOhFYKjFHUE3pOLe2PWQ0aE3AowAfZmg3E9QqhJkhgh0wwT+EYIzLQymAYXrCIqHcfCNKFLyYjcDSrYOq2IPIADYAzi8eZLZgEvl+gFV5IhLmXCpCC51G65yH6APl8riUrkbNWs03I3Uq2v9jkkaPODooyCOVbNLd/2SMMWs8pvIv6hVuW7En4u6QpXJnuEDKUVnMOnDoza/q1IUe0P5fr8vF3WePT43y/XY2bL6HbWJZKg4FM00wsVG1J0IOnoTuWi4Z7w6uC9oCaUrMViyrTZXMBBy7dOr/ZFEIRHND5fi1XzcYvbHssE9B+OecDDomjUrNV4NZcN+q2skFcnHAhZLLJ5AmZ1UTvOXKJ9nVhZk59b7os/I4Rpm7X4O0yEzuAw0+Q6G/UWDSqYbECTb4C946aBn3rPooW0/9+BAj8ujQIvITF1/M8f4DEOAe9o/VxGNKmoaP5Ub7wZC4pEN65OJUCiB9NXOivKHxBQSCsZiQW3JVNKE+qjyb8oLBNPCHD8vWUJ86C374GivsSmQVEZCeOL0JnzSYa8934uOli+Bn8Pkfj+8OCx5n6dXl6arpOa1fK0BzWE4C5flLIxUgINSzAXxH2ExezQQFuObgWp7IhvG2gR1VwYmsFastndPDGBtd3VpwrW8jz6ZAWIN7g5xpJLRjSaAjWAv4GYPwUgAECQYjxKMxQhGU1hLE5wbIjhbJ3jOGM69BucSrMwcOHJAER1GZHwMsFvkTrByre0mm6J9hg3kPxTEGvIfjuFK3fzFqPeuIeSPi5zBRa7DRU4CjhzAx0Xw61hJ9FeTYgZ8VztSD03cdnFm5uKtExO3XpzZ9/z50Xr10HOnp597Q3Vw7vz4zgXSd/zDMAkam6OJlH3ghol0z8S1NP3j49RJCieMCcdY05EczPrCOp6Ze+EJGoi9cK6znLlntrd39p4ZsTy4+GrnVMhoNijRxoGh+oF61Goxx1MJy5yeHz+QnqpGTToG7Q/+EH8ZMTbU2Qx/REoupuAdmqJXn+pYaBYnYK4mwJs1E231BKpoQpgbUySUYPq3bQQlZESrm2rdqR7qZsVh04R934kBZ5MAPv+1y8D6Zexu0L4p7CPoOtZ0aWpmAMNGGAmND1DHVEaveAC5bnB2BGGlJxJnEVZ6LdZ7E5NYfww9Y1sS9XUGawQrd2ceyyhk7Mj0ZTDUwPYmAYwduJQOlzptvM+obLyBPErXHtON8F0P4oonkPME4FFcL5boxfWu62qLmHDRC5TvJV8ml6lnVHKdwKWOAAyAvQQwyHVn5f3Bq0NGoC3e5fF38qCIFclnNPLo22nQG94/3apyzge9laDbqOc6PQk4RvsnksN7i0a7kRtc0YAt5giM+hN+h87qs/h6Ym6SUrYW/HZvfcDb11tyWSJWp0J8fuaQ3znUmywEzNzg19tDXqtOP/ouhzdgrnOjM+T2ZVB2QmyEv4X/LdMzq/A+wetH9aPA2rWsUpuvdObMDNCZ61jgDHK2x6QpexxnYToxRKOq8BKjpUH0N7ng0Vdpmyq3WS+vzFpPQUhXhtyaaZe5GtIKiiDLV9gJSmcpPUJJRxxRukcQNXkSb+4AQGh2XE8AQyg2nKB170iQZOh7BP7Ln4TPLobWfvsfIk/+ToSrX/D+nw/4PvuM768/4GeMw4uV/z1/IdOzsowaI2umDApbcapJFU0AIjel0J00/AmutmwjXeF/Mr32+/yFH3jiypWORp5iYC4cyubYu5W7lC+Imv06dqMy3K3b0S1hRjFysxipdyIr8Ro6RylWE/9alA5Son5tkQ45DGr/bO9Qr0J/LoY8pSGCZp2gDBDKp9OybZiurixMX5ymI3dM17BhR7U9vgMTrARL066lmdWlGfr+QUq/g1oJyr73WlovQjWW9i8fNnbajU0NRW84K5sejDOPYsjVv9ou4j7GZMMxVl3pHZuE114Rt3Nd7xi2XldtZ9AZmQMMAFoESzdcbu+47gYcQE3W3tWlvdWlmctLY66l69e1aRT0JglWzGpYBRWY0Y8PV4f3HQAYbAA7QRAQ6k4HhrshtA8G0AoAbgsSnJekQNiW6oi37JzE7QFOAx4gAC+9gqsAdCqBH2Aw4lIAHy5vBJhtBFFAxE5gBUTcWAOYPdhLsHJ74N4Aprq7lEEXcBfnUoA8wWOAGaEXK+8CxxH8qkbKmHcowa4Dy/bsMqhxRmhw7x8apPW5yv5bh0dv3VfuLKvZyYN9VWqUsKwdnEi/1+42Pub2WF2mvGfQFSilPJWYJx0PDsbCCWsuYbUbUpMKT/OPtW7fnc3uvr21Qy531OcmksnxuUZ9jhpinhqfezPXq6GQQf0B1+sDOrM/FUjmzPGRiM1vTbTiL+fKXaORiIxyfJy+m2VENqxHhDImh49VYU1c5gpiUclSNPms8ni9zhQ2x/+SP1dwVCXZ74vzIj7Ee/qSCOfVPrEIPrGthGrwAryC9+AMUnfuQ0FJUgyvuLiy7r+FFx4GrJc3jw0/CVbM7rBbEb6cql9VtN1GQKg7bNjm1QW6jv1zgUI9Hq/nA4E8loXA6FA2X6vl8zVlIlnv8XtIXCpd7/F6e+rp0lCttzw4yBRWZsv8RzT+wxj5Ljn+0zFjV5OUXZahvUDjKrZYRI1r08Tcfo2GKYeAHBVoi9RNo14xnstmUVPEp3aETT+y1uQ/JHHT17zmmQbUYYr8BfwJtU81si8zxr/L/LjDjWauOEz3OLLCH6Yjc3Tk5a1HSnZpcaQsG01u3xABq6c4M2FtlYPNWUCVgP729VbjesbYSUrnKT1OSUcBusM0iPEbC8umSCxkeF9AucJVg1nv/UMPEz4iZSWvMNavebEFMaMFcy8KhUMHpf4243oxbu44V58K0u6gFslAK6B8x+/c6nauhdI3dTPfmfxRoR8V88ZJ3K6fIQ2bl70qwp5xlRx05ds9FenTPhL0Gwru38QnJF94SbbWO7nuFTLt3pncDa+QSekVUhhKpIZ8zg+GHQ7lBb/WL8TmFKOtK738Y1QSE6zAXicZjXsQM5zBqAXg1MiMmdY5nAVcJFjqgUcINfUoYg7RgfRVJXncAsES64hIJs2grNiGPE66IllhNRIGqLZTLDDJHpb2vcRqO4lt9Jx6aKjr4JKlV+vIT3DhBkIRam5yMDJQb9mTqcZ9jYgtkI86oZQRHrhu6IPubPD+cqzXdsuuI0MhQypt8pmTg9fUecLXt7+OGLUEOew/a3A/57jS9+xvFa+hct0gXfkP8vuZkUrUT9n/CEVNHfs6Shh7quOlb5L2GptLewbSTPKEEw8NcB5wM4EWVXGDC6HrrkXy4pcsBm2nG89plUq6mxlYmtIApR2UdKgzTdXNUbkhgzD/IZLquFP670ITOMERkIQCU6jnaYr4/pFBzpO18Wi+nxfLPX27lZ5UvBKz84Q+kQwH1LP4cg/QN35e7eNG9i9bv1xJMKV9uQqr8Pv4S0X9HGMfkg16V69LOjHjbVlMkvXS9MtZL92ixsaHF728sXZeiahldAuE/yyMkWiX7QRGQAFQFJ0BrVuAVl3BeX61B3W2XscJ0PcPmPLIwYJTKoA4oOxGNJg79stq8kY9m6lEqs18njTNIv2tfL5ZjRzu7z1x4oSSKEz3hRDoWGj2iuXk/he/CE+lwUb4B7X+9T2if20FCz91KqV9HxWOohPec2YScTZfNNNfWDU3adH1KYGrAjrYVnSiL1NBwNF66jrraYNCS4WWcEOhhkDsM9E2E7rVIwX6FzQKvD60eC78p+HI009G/mHM9+53e7/wef+73+t7Bm958sp/q3cqn2R59u2fMlZgX4JZkN75V/hH2Wmtn8z02zKLyS8VVRi44LW83rlNXl9WSpRXTuZl6ETv1EauylXksptyeS3lgvPvY5QP3ct/sNMcLUiYPyHZLaRimEslWAQstLqZDVNmw5t5BJGzUH+u8d9VGMuyqubPkCuTXkC13CzPllWqs+S8gaanxYTO7WVhTFnWmcjwCd7fg7l5hEJ6yznh/pYraxJaUcMmJafgRjYR1P8U+FQgYduCURO2ZUZNAARGz9R6ZyRkQYeS4DhsEusqRLrGUMCh61T+3g1zjPzEVdpYNlu6rxSzRStCG6tHzj72ODdJYw1Nl2t7R/trw1kpjKXs06YkUSqETpD6hJJnOVo1sO/t2roV7/U77N9pk9Qcnc9xxKt1j3qwe9Q32W8zptnpUnGM4VMEjwJOE6w4M0mM4HdnkEH7cfSVbyFYORE/G8fYH6fMAg5lCHYBTgMelKP9h3HC3i7Xwz7aun6vt2h3YWDferRzp82hzXc60z3muxeY5DhZaWZmcU/zwqpQJJgnEJF0qnbWWTqnzIaVIekXk0YvIo3rOwhOAZqALOB2AEs7NLN8iqGWcqTx01Jt28Vaex41vUMwayJuKULzscEIdoQjQSwy4vx2QW4sysWDuLeyOAB1a8UoAkMGaKDXRChSimCbiRlp2jFvFdPNwJIjQoHrLEmpSqlJSXcSVCzYbV9th7wZOUkshCHuL4Jhu7gHtFY+3ItKgEDN/nXL4bFuKNB+gAVQJlg5qzyC6LEJbGiYCI4QXDKYUEerNC7q0uLdCRi2ERQIVu60PQjr4JgYCGaFM+Ioy7J9lI5Reg4lHY3HaE8navu0AgIQpUdpKCpdBhc0AB4A7BU7TT2mhgk7TdgJ2EOg8QqSRr+F2ViEUpnSOKVrKJ2gZCBDEe7scYAF1ywDrgFEATcBHgVMAs4TrLcxBuMWaSqM7+D5qAqJKnXDMOK7nlQp5C2kvBPFX2zSrCIZq1+U6yYhXWXPeiOpnDecUn2+VMBm8SUDPWX12cWNWlaC6/5pXXGtnzSteMbn8XgjPq+mDqbOU0+vxPp5bF1HxrVFR0aSo50CuLYoykQCGxVlaI/mI9eMwyDd9ZONxSM4Lkd93BzW2mW5IYKAgXZfJI5t/WJxnK07XW+rStAlh9WVgppETUmTqMGGbSRqgnS/kKgJlrAbAgxyLVoF23O7F7/WPfFwv+NCYFw6OKCq+RWSNo3uWxQUd+qQm17jNVxnCJe/9JZiyGQKFd/y3VrEYBQKNx+/r9T7dfKDvc2RcMy9QyltK3fzuc9pL+2ozmyIkz9b9aRQg1n7udCqmuQNGXcX31arKk5g1wm/ZDt5dtiTdvLOP2ifty8S9yWIQ2UAgHRRlf3xJTPNkJjnzYtm9STGlTqhHNFTXe6lo0lSuk7MP/q6vy6lriZFvL9nQxj3NmpXGa3uY5pPlveydI9vVzJm7KpUUWtUpfzV2HpzqDpRiQLqgADgXJTgMUAf4M5kx7rSDzg6SHB4RLyr27HrPkABu04MALD/yPC6EJYxwUVnD71jOFD281+vi+Wu1hvB0ORYttGKF4c57+3LveKPfo1Glt1lVpu8kiUTsyNtSMVjYfVu51/86S+TzLpyRao6ifa2KNqn7zUYc4vH4kLDVCNAm3TVkWiZX9ttmV2y6eoe9aA8ihnYN8+snzvTvcp3JxgLyb4aHpoLDj2s19WraLmgrayJa/XKu/o+YxHRas77FhEoyPwuhFbU/J3rIjTlhg1nfCfDmEOeEV2MdvLN075J3J121Dd/yKSH1krKV/MJMYDdLMgOUzpN6T4tRJ42X8t87CZK5yg9Skknjw2zw5ROU7pPhMOLJwWC2uPqTPcq3/0CYwHJqxFGKy0gKR+swgKaZlmaWpj/FEfVkxj7okgtECDOHaZu8jis40SCpboUL0sKKQwh40LBzgW8r/HNcU9XiWzxgE1jnDvVofsSDj82yUbPXcgt5YJPSwAfS9f/8HbHvQ5FUyk7BhAlPQ44NkhwfBjbRgisgBgBWkWhvYLD7wYEcfjh7uHHcGSYwDt0lYAf+qQVLrhOuKCz9mc3qpsFjnfFzY688EQV8maOAsmbzWerx7mVNM7e+U59VKicTZLK2e38edygiZxVj79gTpM5g6hQkO/m6tq/1de+uVHuDGUWCheidzcgyvu32O8yrRSKGNAVZ1+yj4pis2+2TytfUqNBlMJBcc732Eu730i1xLc9Cl/SP68fVd181IPyKIY+7p8x1t1+i7Yd9/WHG7bPdHP9LvrEWrlL9aNtBFysy3LHqR/zNv5BxcKs7D7p5cpVmPEkLYPGQqXjHR8KaaV6Fcb+GvWLkdMuRDdDIYxbdKJh1OYDNT0Yo86CrRaXdJ1qvxEs/MJMURtocho1igmVgvHYk6/oeeWTPU8+lX/qyc8/+cqeV2jrQjvg/5HqxWdYlBXYEJecRcUtuhdFAhcBgvQcenLodjARmCAXASkSEsZC9GBjdEgyVsTGVDGGRUUuesXGbSwH3f5r26T3iqzlIuDVi6zFYrna0dKg7KtZkX22KrKXi16xsSs3oKJxAdxh7EgZ+ywEgljiXhtBriut+Rw/wdkw2iTAjUkpeQyeqY7Ut7+XwAA4BigRwO1MQY7dkGwfruK1IFtc5ZGuhsdZPzrL4UfCoKNBxvcDHkhhF3IvIM+jBCum3lAvDhrs9DEDeIsJ3glENKJ1I4tGkMtGTU/WoI7+LZQEBuaysaHM0DDWa7ReTdSHz4VCPBPZXRbSHG8Lhta+FtlZgdKA1OkI+fvjjYFXHcN60NcbHxj4nROTZ0v8mUgM6gKTd5bWSMCOVukrELzg4tsalS3HbZ0vi+VFyd96DL4/rrJOa8H6XH3KpuMe7B73TfaG7nGpfC2/+bgZeRzDl/d8fJGSsVVcZ3LDdUSvVzhlo5OUn88vQjS7Ju+uqzsCZvMG+7i48yETRn4m3lEbROXsIdkDzXMxov+37aQFu3EPfrsqmdhpiMGYn7kopSjVKLUoHaREQ4ykasdhScQTQeQSrUv/ei8J6hQrhlAgpEiWIwgo05okjMPOtq/L8XwGIHhdz9P+kUBHsSCv+bH5p/mvViIZLQohklJBqK0F+wKkRdL7y7RITO5YzEqyBYewQspbA4riH7hhcuyGhtAjuVfRrX2Klt7idOXADSKWmmrKo8R1spu/UPozONHeTqA+kR4M8EZbmXWegm95suKUjwWOafAts2IBQ7NmPt3prOCAnVV4ncHjoUbqVR0dC3oxkQ0OZpsYRq4SoooIPlJMNrnITN9PKgqXCTcSUJ5m62PaMya8BEAvfBVuztydUWg9i7YWcKSAl1Ds+JY9AEiVCdRegizADzjbJLi2hZcFeO4OgouAu3cR9AFOAZ6zW7zqcwznKGjWFbhImB4zKfBVwBFdJdj7cNk5oaAAEJfY38Ia4CGRO+Ac5ck7qtjuTcxmgorEocKhTPMk60Y4N6QDGl92x3L+aK0n8DrBeNa747r08LVVP89PlgPU1W5k58lvTLGbwzvgNTYgNu1XDgTKab81v2/q2X/dxIWWGGxl9N5UNZ3sK/RUJ0vkJBauuKf1ai2T7i/01Fr9I4fwVQt+U5XRV71b1DC7ap2+bKoF03prsUUPpNUS3/PW45mRwteex9bziXXz+RQt0tqUE2M7mItSilKNko6GWztEht0zlU93z/xsnEnL+aVqq9mabamwVW45+vPa9Q3srHv96rZuHp+ZYywpa6aWC39ADX8MO+A6gPUDG3NTvqwwxcA+x5jgtNQJTssab8p5myBmW1EaUgQYcMXXOS2DMLMBkgAj08bO9AcnmZFVKTUpzVIie5DL9G9S8V7TuXZSB1JO7yypwhQdFJSPMsimG/12VRiCTQTnnMfJqmBGSKvCDpCmgWo6mVaEbaFHhiD0qd3u7jxf5Ipm+L0N4EHA1KB5pxkBrIIH309QAdgAzwkTPEywMlM5UkHsTUUGm2BnGRADnA53qsabC5pb80qjMkMngEjC2J1F6Y4TfznhpvfQmH9kQOlMsvBCOXPy5l9Cv5nrH90y/3Kr4xVnr6bjpDcsOCJFed0nysuuMXbVVpTip9n69hi2y1J8fae9Xej2ZMUxKIHaMWfTjGXFU05Wq1XqQs9WT2GRbFQb+NU4RQtZ3q78D1pOlXV5zXZ9sDM+xbQVyM3kkZIBLasdift+IICtcAnw4v6wFff31fWvzMU8LEWpRqlFSUffTZB3rvyvGCvirrUzz17qtP21eCuuaK11jP62/6v8lPWwUf5XUs8ojHmpcDWsSC2SMDtFaYHSRTFEvHSqtlC7WFOFxpGTwkRZ2KlZLkjrU9q22pyJaFoddon4PrOVYYNNLOhMCult58RBmPfKgwFlHM8DcEoOAvXVdUGT4Bai/3ZVj+EloCehRy491KXXJzR7Me+x4GpmS4+4qFykEz4scmIfWqkKF15Hw+udhL2sQ+x/2ISCbZqBYkrQXDB3JsSuAYxnpHi4ZsMc7SE4VCLYBTgGobNdI3MjwndzJ7IcAuyS+RI0AHsAPWaCAOCwm2Csm7GQUmz14FzAEWS8l2BlZ/+hfoXWMeocEYPOBF/vwW70zqSdRrXrH5OXn98bLkSmMlPJZvy53pPD++ITxyaGj06l8lMHio0dQVsp/sSwN9/IpgbTbqPq3FGdmlVu7o9W7G5zT6y/km+2F3YsHOzr2X1ydNcduzLpUP5Qvr72kdK145lM8xgRVdjD6fNUaiXfFWr4G2QNf7j7VZU3fFUKE+X9kPxO97GtWzm+0z9i3VmJLefGcJT8Km5ibD+OkSyGC0WCHMAnTmlHsW4D9Iq1EoFZ+KlLg2UIW63YUCHo3gf+Au0Kn53u9sP7N90FvjDtmLNDjAVFO8aKrmKqqBLdXH+rv1MXsDI7zn+sHKfjvw6eceZmF/lX6Tz3xVvZx+QMkYKYTIBTFTd2BWVm1U7wdTt55yza+YW2Ez+XaG3FZU/ZlQvtFnYtYetBAkFz6GUfprRK6euUdPe0F7y0J8wY/XJRSlGqUWpROkhpntIipedRehWlN1FCLrYLlN2WE5Ddohc3GsZ9AZYIMM+tshJ5cDOlxEIswyr8FvFXZVW1IqNENRX7JIABFrJYA6SkKzbM5LRLROZb5MLuUrEIiAWauTAdEgtnsTEuF/lsGIuCWGzH0NIdADOvSWRt8oqs5SIgNi6XOFw2l1Ocsi+lRPapksheLgpiY1do0opW00ZwHPAwwcq47RpMuxhiaF8B/jjBXJpgL2yE+oK/gGmZArqsMpCmRNlcgvrMcZtKfWPbI8ggiv6FCRlYkEFPHvkBrIBRnH6IWt6uHbZTARjkCNZLw1ev+NwxelUxQXJfvgckY9cP9eeruezz7s5NhQfze+2Oz3pqqcm9PGizfzq3c3imlD27G4Rjib2Rvdm7dj7xMof9+iiPF4hHe8QfOLvYszO29tkCfB8kk4z4Uo/Jlm2OMa9oX1z9KVRRLfmhXH0svuo3s06v09lAOSBYcTVSsuHsnhHr5v6pM+J45F5NVeEyUcdMCcGG4/EtasefnWJsl6xx6kJMm7E6c1FKUapRalHS04XHtb3jzEUpRalGqUVJr9295E0Qd3+zdvevYN1WvAdlt0+b+VSYlzjArMrPwcimscz3gkUUBKBKxxTKqxibBiUjm2ELI5tjnZHNUP0lnlPWLaW6Sy2vlWbRrFplSKp3Ew/bfSilBlvApmhs8ifQpkyVri+JxsqLTTrAacD9gJESwVGCLsv8VeRqckZuM8PaKdBkXkWvRrRrf7OJYU35U+lS9abN9GqC5fP4Zoq1zpsQb/lmORaAQVzjjgUpwm7pVWRnuo4GHKSn5+FxWvO0PMq2nFpd8lwbjgbn5waGMPqLwPrpTHl3xndnwr6UIwyp4ZfLux4gmg0mtW3V59M8U4GNcunDUYHNwyn47wFVgqWK8G9Y7DC9yfE3YgorggMOijaxQkWTVy2AQgHVUZ3MfQEU9gA1+dsZSqQ0y9ZxA34U6EcBtR5Nhmox5W4RJtsOyQ0hMqOHcHsEwoxeEGb0dlbuztJQRUpG2jfa0qVI0jkrYKAznXTjMMERcYtSivRRIQzatQjeiSNvFhNPdGTawTd2VdLbTxb2wIdvfW6JfzfSjHYUPYPTcQrr0OkjW+cMn/1FpBGJNNMwxpHip97YUfQ0GLZOHBZNVmWH1a5JfMr2i97kLoUxJ41a9/FnpHtVBO1XZDaC9iuC9gvA5LwuDFpScIdpFq4+2uAy9QmHhL6OjsqeyyupPbU9ykkxQTi6iri9Pnift2uIwnERHGfrrETBjW8wuJ389xT9mMIPv7S6JCX3gsufFBdO+rHomyrIAGjNLrg0BXUQvGZQgSNKeGa9btipoq0CHBdi0RaC/VaCO9x4k8JtO31vWiHvgsyDGXhv59DuAerrIXmAIOBolWB3DaUC8LBmPkH52K0if8CcCFkQ4pZWrDkJHncRLADOuXGih+BMmuBBwIUMwe2A011xLD2u1yBYAYss9Idx7ZlaR132Llz7EYLNtJt8czTTtAqbjeTtR/BJUO5GvTY0nH+5IOXc7SJSTmov97h7B+phkHWiVR2+I24v1iie78Bw0L72GX+5WXH3ZGJmpynTV49Gxxvlt4xOGr5srP5P38HJzDlJ37n2jVDabwanJxrcYr+frDrhqTPXwpdSb7GbXFACsAdT/HXX33pgnjEuWK4/rjDm0bQuYWdgHtRzHq1dwYqwObRbQknpKgIsWfNZtSZjowPhPZgKoUU7SNCp6jG7C1/RszvjM+lwrjbotNnCfjt/r2BBXKvsvWU8pvMaEo3r6vBt4+9mX1Xex41slanK/q43ZLcRi677MR/gDTXGTExGZBnAIPY4x6cFYIBV8dNA8Azgdk2TDR28dY/nKoFGaaK/vPKM/mtCtV9nXO+nyWzP4OzbRDQT4HGC497CyDRPcmPhePy5eqf+QvRO5YDrvSrXvcd9TtzjafY+5UvMyo7Ke2TkBwemvItMFYyz91C/4UOMsWcofY3SzyhdoaSnro+B36PFVq7UDC2i/1yPnGwfJJBhMxvjI7PxeCYTj2eVN0RTqWg0mZRRnDewNdXG7CzMLV3OJo3/p/2UTwb1GozCa9QB134Mvp30KcGrH6TpK85gMki1jsqF9od7/XN/UMEDBSDae2Wv+ahZ0WQT77QRjAIeIiC/fp+SUzBpgqP1BCsNZYY2rJxR7sd2rw4vCKAjoBFDjulYndJuSocp6ch+i4tYzBFcZBwXqRCIiWkzu4nSOUqPUqJDLbjyOMFK1FaxIc4NGx7Fhpttd9MGPLhuD2RjHMHkWKUw4opkPX3D9ajbFw75Qn7lz0qjg73+TMhR642Eg+FoIiHe7p18gVrsIPsSngacGedtWlfQxlyUUpRqlFqU9PCov4RX/xS9/EtOBr9dVUTKWhEKRk9bRplLiW5JtGASgUI/Az3w15w/cyoXsH4P9vugHixDwLW3ccnIg7zAVXoP/CiHYiSGc2aCSyX7mH2/XYgyjXH6beERXuYq2R44XKcAh+0YW9j9djpxBut5+zCt83X+l8I6KwxfSDWCnlQi7rRHXd6e8SDRTNB6xKW8KRW22qwWRywbstgsZnoUasdeynbSMPEEf7EoOfsriMjdT4Vsv6SoZo799MHRr6Vjl9u1Y9SXsFAjJwndsvvF9OXFCr5WwCwBDq0R7SlYOaglW5mfWpxS0EFaPmAQujiHO2EDLao3WptkWzZToW5RvW3bE3rNjYfZXXbKMyGCBkiBs4XbuAW9nWxRrNf0RRlpttRyLTeo7RxriQ1jVUzE7lL/DQau/ZIg+gYu+kBHNrSWIh4d8FCa4CwA1oQVezlepvcwVUZEntgwFZ9ChOVOeOgB9hLQ27xNQbMKOOIGyUL6UbStpnIIp+/D6SWcbpgK4PTdO2m9Z2djJ73XaVVzjbuqsSqsK3Dhk9gkwRVQN8pvravSvMQayVbTmh7NZ/2lzY3XxFjNaUr1jWryXGp+cIM419jkm8M9UpnL2cvvRCPHeY1/whZwmTX5mk3NmSVcSQWLCbcm2pWMTs10RLvSa3PeaMxytxTs4m/pyN0wzvax/1HKfIypLChjEsmegOAdVQtDFAGI6X38m2sJPtbUzlD7f/0ZynefjWhn7Fem2bfVUeZlo904TyEnhG9dRHQisPd58FJVHQbZCHkFXxNDbWtAde7gWhSBUaPy+Xa+T28tOnUmT8iSrbsz9ZwasNXyZq/elQg6udpfCQ9W0kaMkMeo7fyy8j4VbSf7lW3n2JUFiii6QHc6vvlO0Sp07/QpcacGfHsY15GGskbWzbwi3EEa6PPU85GGQ+NYYQj3qjd7gtb0sC8/nF6wjefNHgNuVe3rDdX7c2a6Uzwp/hp6UgX2RXYJY21aMhaW8zeOpmPWQTXkU443Ov6KVuQIGn8df1p5H52zyi4p+3nnrxyRnsSGWYNC5xjeaPgrkBCkIps7wxjbbH4OlCeeA3+aXZB54j6QJ4tsyHEFOSqYyen4jBxlf8oX+cfp2f1+l0sehFwU4KR919L3NqQS+Dturit507CJbtBoD9oLdrpBk3tTNMWYjKYwKJ3IyAYgL9Y2ueuW7GgD7RE72kC7FoexUnFPuGlDzH11eONREQ83hLi4IREfx0cQDocwOC0cjiHW9sp/qX3UeBYY5cMYlrxfPBE3/YpKKwiDUXGdK59Aezf1K/+ue1iMXb9E8TqM5dljZuTxGD+79nx6U48p/7r2fPYocpHnOjnBGwFMBwgRtNIErwK0GlgTMI2fAg7hJ8E2LE9doXw4OyYF/8iowOtXIap4ZFWW+hAbY9/kq0zPni9KPatuE4R9nMn4an55h5vhLBelFKUapRalg5TmKS1SMp3cEH6NVT3O2o5t5xSlBUoXKZnosclo6tCfh+5aCGoB1JTfMBtnV8QdPiHuUF/dGsaC29PjWvJCjCUpVSk1Kc1SOkVpgdJFSiZE23XiV7Cqk3+UjrkopSjVKLUoHaQ0T2mREm5vRAa0BBfOhv583EuhLJ9n/MpdV/6bOGw+yVTJlNPm4KCLqttrKyv0Q6FX0plMfDX7E0bl/+Xqq9U/UaknIvoqy9ln35VRPpl89hCe8IErr+Pn+V7mZSfl2MTFTJIxbtaF2C2XNoc6K8MIu89FBshvjHHxbmRGsoPXHeKs6DBZqJLVC0+MxoiDb7DPnF/7fnQgrAtNxMsHcsnIUPC0n4Tl/7PPqOdxc9q39qTBZWOcFeken6B7LPGwjEiAn+Ko+Cakn6LmJbbbhmgGqkC7HCjY511t7/QiusU771UQhiD9tpcDFPZSCHFsAfsZYv9LeNfrJd27MaTALko6yoB1uzKA0YM7bpbUx8sB9Fzkr1D1UipUC7VCVI9kzHFsMm8y7alWdBCsDSvGv/gLfAA94AwBSB+s2ADIA7Br5YjtjE3R9CaP0ZsaIWXdwrp7i3ED7ZkqOhTG80Gj02HmqaODveNZR3rihlry5b0BamH52l+U5naVM4P58KstmXzG4kl4k+VQeldrMmww7nJke9LWdLC575p0vuIUXANXfpfexzSrcY/U4yzQ+5hHJVLTlDb19GxNwn5WIDgFMKcLMiC3vWjGQVrIKQKSChpH+bKT+qT73EL/HcoUkm15NwARNBsja70bI03p1SwzGP9zAWmEIzc7TkxbtMkJ205ARABLv/1LVXfTPetWTyIQtXj5UqpYK7aKapfV42484ckwwd2APsBJgpVsYiiBN4S7uYOA3ksROw8n8PoSDew8Q+tBYUcFKWWTN4xZTfEYPHQdFRFEKSYgX/BMOBOw1EbTN/ZOH88FDBYq9kM3FZKhStp35+HSkUjGo7c57HpzoukIRO2VXOR8WdHdbC+U89bc2SLXOeO98R07o96b9b5gyKIaGagl6Ft5O30rHhZhb5FfCzivptDG9QPiABvgOgIUfgMVfgcGP4ibzsFcNOTZ5aFmWPF4PNqkBgbqIUFuEUEPv6u47d1oi6X3QBYBzNKic+NYXbZKdiofDatwYlfOVtL9mmihl+JA2QYfgqctjNLqSNapjAzxF/ydO+f7N57M3XKLI+Z+hUXNLuSai6f9FOqxL8QTa/9d3adarNxdqVwIGqmm/DSNeNzUHjb5CcmyN6FWRH09wZKUqpSalGYpnaK0QOkiJRMcr1Ct9WmRrMsuuFMJCRoUS4z2pAdbkLkopSjVKLUoHaRkOAnxt0QVAR4p5AIVOGTZWAU2V5eaxGO0SqF72xHRdKkSA4MGKWh5yRlIBqoBFUyJbadhUNMTbDq5oCfxioK8HMYCkdSXWMKVSCUo3CEJ+kThQdcuycxADijuI4G2GQQY0913MKlDBJD/AT+sAZn7MwhWGkIZIaB3M6LreH8+DLg/g1JPoBIF8+bwARrLGNP+GA+SuHeC9hEddodwKE+cDUP5emOSj2RLM5bhg2cmNsYQHLlA3R3nGo083M5fmHvGZocomqAa0Ru5s1ytBX7nTd4jzhbns/xde+/clVqPI7jrvtG0xWMaGzg4lrSYHqPwA5vTonvJS8fMHovJJez6RT6jvpd8GYNsmr9atmu+Trs2OkbfQ4XDMUZBs6Cf1wv9UJT+lA1bfPOSewEOPFV097wBglyQIB4hqABmiY4JTB+Tq0uTJDFBNEG0AvbddjqD3aM4ZUzwuI26JMVcO9UAuSAFhhRo2SCLM315vavtniquAagMih1UXpDXBLlaTG/rVy+/N3x8NjE4MNm4RkQr5yYMQvqCgz6wXaS7xWFpWs1IRsQxiEnhRnJjqJRXQtViVRF/zcBqe7gwJjQosatrjNuVgmE2i6JAsHJj9g6oS45gQ2OU4AhgD+DYGO0fG9s/Bj2lcekMjMPqgMOAM4A9BFxO2AhW60JnKgGEHzJQDD4SST7U5JI8P6DxrqtZ8S8Q5I332aL2ZjpMJYY4a4yGSGraHTH+4rdIk8oVtLxtj1N1XvtWS8jljISWTT630/BA5j6DNerhM0GjWeGl+dT+WPSa1PzaP+lN+mDQrufgKQw90xj+YkhvUdcu6+3BIO3i6bVL/Jq1r5ksaP3KfIr/mF/YZoyqbBijlvlH16b5hQbmIb9MKvP3kE+CgXmYtKL+nB9SH2QmNtu1onZNpOhsLXR0XFeqrMkUOQCgfvOlp5Q3klc6LFlKUqnSikbebVIkM2TXNHqN46LeaXjceVH5uZd8yXTn/aPyys/yR9RbWJD9WFyZ2Toe7RcBNcC8jeB5gBrARXCVvazt7LJIV9UmWKT/twa0tp4jzJLv4aCt4ph/AAgz2nFAGeAkgJQIL+Gw/ThiHHACYAUwHJYD7AY0AEcAAYJfYlB7JNUIe9OphMsRd3nzE2FPOpFwkXFNbaRCZFCzOuKZsDCooZ/MI/y88gnmZXOb+8ndLvKv7h1v4g11bu0d89+od8wjV3eP5Vv9Ka+qT9ANNWR56rKLLBhRkAhWqsamEQVJkoxo1pH2U2I42WEV+aI5Fg8bvulWH+c6s93ou8krbdnf5U+qM4KR8I9k+23AzLhhAWP0i2Qxb88DnmfgF1DxsMvI9kL7CqONCwBwaK8zFGJeF/yDBKAxvyAs7CtvNP8VLMxJM239mhlieuYF2iBCds0sSalKqUlJJzgMF39D+sJUOJRKhcKprwHwQ/WH6L+g+F/Adk+QKeIJcnqCHE+Q4wnyJlfkKBqT00/hqTqNSaOCvqOR3psa5FXPNwyRRMykcu9NPqPdrONMUxEcJN+CBvsH6evkhB1WxwVlqHGzWzeiDgdpk2D1Ra+rTL2AkY0O3WUqQeWOMXWAfgxsmiO6Slq2LCJGwcJRFn6of4XWqwpYAGQjNjlljDnR3Aai/iCiPnIE9xYw3iicKQhXAyO2P1QguBtwkkCKbaLq3qISPbRZSBoGT1m2lUGSIvubSNX/P8KDutiaK/sGqgWLajMm5uITg8m7/H19JbeYtncb+dNrC3Cn3uQ2rTfbjOl8QEpMc1Wvykl9+bSn6WkPsr+W/Ng+sOhrUy52erTmVfl50m/YuqU8UlVyY2MI2D5Yx/PG8+8OBbdTJOl607erSRSSDYFzYtrG7Fpn88WFkhsZxu83wIwkoxgex7ohBkAALnpV2+tua0+0U0PI9pC/OlALRnuTbtLgLsvnmWjsLZvDpM/tKfrC7pL7u66UW/lTm9uWbdYHtpHjVg1GVW9Tnt1ByhlhUh9R2f8HGt72hAAAAHjabM+HkdwwEERRFtvNALsKRPmHpSAEOuncI+HL/W3bfq/xp6e3fQek1FooENA/557Di+QAVhLFkl2SAIiQKEEChEgWCCkSsUPrX3YxpGhQJKQdJKubPpW1YHFOihfJOoXPuz6x0AVgB+Njw6XmvVHrWEHY45WjlVL1mfxDq2bsWDlbO3EsJx0bPFstCzIgtBeKViR9bFVRdzDhs1U9hnJqH7Dkohxs61R6Wn3RPQujAO5guQFo6dfTOnSttOe7NoC0e+ykDIH+h7StV5Kyq4C4q1JxkpEEhEVbNm3AH1pLFkGDXmC1ZBVliTYgacypnEae1rq4cvGp9bz7C8wBEFBn3K3jfW88TUoUk9evPlpljwHSP7X6XanKGmBldqdznGaSM4qOYzqAMbPIjDv2p9Yh/2vN2eq/bNOLquO4EoXhBiLVvSTZuezuM3Pe/zFnqZLtZi4/QikMGH+Rbe6dd2JFK6tUXRgRca/+de79s3+sQAjb7X06lhuFuvf9W9aYbyuR2rbSDT66qrmnMAuTyG1bVVmBF3Fh3jfBok6EHc/xbW1EQrTfbJx9Kahr79SlYeu4VH+BR3SpnHc3JFqRCiruTst2Wa9wzQ0C3E7ZtxXZ/AwUOI5605lzKaytEZnXD6yNrlrNQ0WUWRXPwb6tAqqGiGwrXFzfF56Ubs7M28r1jpe1fazWodeyNi4rRSZpFfJt1cu6Y6HKaHdD/I4+O90CxG01wVCn4+vbmtT6xzoO+3GDnNljW3lb+artmaaKmrBaa8phJqYsqiki+yZlZW68z/3mwszgCNtG425YW8HknRjgzr03AQv0HONjzaI1ZO/YFIkoVV62sgq/E7SvZeBeQLjEtqI4Ngrx4Nb3aTSReb6tIpE3WKXhZOWqNWy8TGEVc1gl3NU33oapbitBSQKrtsatnrmsvtG3DqsgWIOgt05CtK2NiMecbNX4bfVK3BC4XL2tDYnK7wBvI1uDlVwx1OnkCRQhmdJ7fdWq6+6wdvBy4IdhBfyq75kPVwPPvXeT4aFhYubTTBs1gUtYpAus0oaKAtNVXGRbBWtbhZNYyMvaVco612KvpinqyD12ErZTkypY0N+sikSlzfG2ho1tReOOoaxLQKXOsB7P2FZSHXNbtXHretX3LKcbgOrRu+uMsDDgfblbBxRLWWG1ba1nJiaVEBFYFQvBOpiFg1iZy8rM6zjEq+Xf1nin4Tv7WPOyqulVWdcE7NY5DUO9ifMJPSM9tFN91WbnK360VtZ1I5JtpX9a7+EOXiRta6alAx5HuMOq3FXFlNR60z7NbFtNU1WokbayNpXBot9W0warHOcpUR1uiFBkpRnIzbUaoqgjtUo/u/ZjwQrb8NV7F7Re39ZTiWEVMr9/JazEZrOs1qWTXdGe5ZEe6ZaDKGyN4SPMI88I7wwrlNtq3rv25WbGAutQVVgNCzWTKaKSxCZCsHYROe93yeoIR4RyVDZi56HVvKzmVl3W8+gdVplxfKzH12ewuxGLwOr++Dk+1nU0Iv0vqz4zcryt6ceYMcMi854ZsJqQmbqV1frhiIXdhtnfrUvUZLBsq9u26v3x0KzO/LaOMXc2cxdh1VRDb2tln936HURuBOu5jx2dP6Ev66OsrBzx/DXL6n6cjVkdVvYrImz6GpkzfEzm9HPCmp5jPEYGMW2rw8oe1I3O2FblsGlm3NgbOWqux8fqsMa2qj6eTx3VPQMxmu98DpSRVq2yEvLwd4Fgpcf5tq68rL8+Vn86i76trz/mj95Z3M87rOaksF7xnu1r5pgRczGPuK+Va8A6H2MkCblAaeHsSeRUzywq4cu9rJ0/1lPNdYq6Kod3UrXn62WzeozLuipfY5fDq8MclTVj55/d6Xmnzp30yDu938T7H7Aq8te2KqyZX3+uskacj20NUuK44j3brznGyliwzngcRx4jxpxPXN5W/VijrI+M3NbcVufOgYV6WFmXaKhyvq2vr6+P9TkSMVpHFcdEl/W8rAFrlcjT6fUgks56Dgxk6PEnESuKr2A1FZMcP/9/bKtG3J9dxIOM5B9W/98a8xi5DpGZz+Mc54yx1mvNwcqBlQ5fDKbgemY1yTgiXLr8tt7Nww6xMOOMTmb++vnTV/WaAwk6jnMX50JzzKhOD8QoRu7iswd/Pctq58RA7m5/sVkXyK7jQABFf9HEokaB2Q8+73+B01Jg8IZsq+iU0yrX06zBSktyPgSzIq5XtzoPUFq3QrfCK9eP4y7EZhV1jqGpkjIQy8xMYzDd3QpPK5rVY1JIyaxgb+sPiGVYfYAQHN6t87pGGc38suoIlHvIaZRfVkC4h1bCNC3t1kcvZGq2HK12PaywwrBGR7S96ZfbrVtrtyaYwvRvazqEWQk1e8fYcqbMwCKLDCsEUyYEB33vmsb98dETZIBhvT2tNSYIatYYHUEf47RsW5LRwmR5S/MIslhMDKOSwBpWegwyWQaf1nmabPRiYTsY/8T5bZpctGADF8ZTLfH+kbs1ILbZdrCEU5w8vnIOEdOpLHlYveBcChdBVl1V2Bl0WAk8DuvMSBiGFQH8zdtMo3XD1Mwas484rLduXfc96WiVpzWXERa1hAVG9WVFxtHdSjBtS7e6WGXpVmv5eFhxR9+tyTMfn+VpXf7P2o/hyqKFKRfvlZZhJdG8qYpZMZoSCD2ym9CN+xNSYCyI/7YCxhwipuQZ+x4I23FAHm3KlrfKy9pjxVEDtJxFTD0ktpDQ7UYMZm2ymhUA0vrZrYbGA30cT7Us59du9YFoXm/eA01p8vTK92N4u1tLDWZda5WqpLns+W9WRk/iHLpVmCl2ayVEs5K9rRvBnABTCYnuVmfW/Twf1n1Yg1XqiGq2VP5rFe4R95DRHavr1tR0s2Wwtq/T5JNFJw0rBJHrW/1ilyPzst1CAHbJBX7lPTPje9FchUsLIfPWmrTMWspRsvZBSJ4YmEK3ktuEhWOKQo0Iwy3Q5Nky65KQUo2JzSrUrXhcF5bRkcUKVm0jbsXKkmk0A1nOYuF7YpGQO40YzDYPKyLC9s25YeWLQ4RuVX373h7WdTcrsoN/WPsxftRcmnI1a5G9zTpnzrWepeRhDcQoFFi9Y7+riEToViYKU+C7dWJYAQlqBAYIQn0PxPPtDevoKGoFq7W5x3O1ij6sCz7nmVV6LA+rv3bn4uRhyXu3Wvt3s4LFbxwSQMSo+f1nt4Yksh3dKt0qr0I/ps/WrdLmaNZjnvNcJNd2VbMmzxBYULhbvVmzqCSIyjPz3RrEmhg3IIYWQcyq3K10vb9TG53DGq02j+RuzYVHKz7nWbLcU4uV/XX4YV3L4cfU4fHzYZV3eVhz/vg1P63nFCOJBxf/bf3aSp2ztiXGqsey5KVKae2t1fKwKilHyd6LP7KqJkyZF2GOU5SHVXBD4j60ghgyTx6R3j4+HtarZita8zKSpVk114eV/rJqTzRb3fp2ep+mgGs5H9bzl/cBLfmQCIiRYi6fv5cvzoWkug+revRRX4V+zN/m2pass1mbnuta1qp1nt9bKyEFgSBmlSgleAln0Tyssoh0q7qg1iS0IwkuCRUxZhnW989Pnkdv7Wld1pGus9VKldFGz3nWoqNhlSzh/TKrC7hVO/DMTNfvh/XPsutrsWFbB8Bwb2OJFBcIbk3v7NPdvv9zHZBK3PVnaVx9SQxYetXVygQD2O6BrD3XOo9klf+y9s168mQF4wPr0YwhQkSy+sWh7Qg69MpIo3pNVt2NYIzhgoEKWin2xPRTr6knLfIgd6sQPdBDjxBy2TbpWzMCxagQYk3H3YqqleRfVlPTBqhqXabdmnCi29U63atVCKE3sgpBVmuPz7vVmDLRvpPmIA7MPOp7+qbOHl2wxkfGnJlitNEZ9H71Dsmq6+tegmbadp3uJmuArBx01LpazVNvqCcji5BaBC5MtdKfm6zr8ah8a3GWatbYMtFTzjrdyvJ7dhlr9oDSoLt16upLT2Sc6XYdW/MzPeIIyhwNIzOTzOLpNX5Zx5msynSi+7uVVesloIsWQmLMw5wSJmdcCNXaE1T0GhRZDVlNNyNYqPNWJ6P1P6yjUFrEZmW2WqXaTicVWuvDGlPLpEA5/LIW9bAi1AxYSlvdbUSs1uKWL+vy2nW79URWKbjkiOe3RFY2AIzLE1mhkx2DR6weq1t0PiHExMm65IzZgwtxC96R1QhmQFnDAPvO9AtaskpuTTJG8ycOTwyoJ1CjVEbGQYKUzJq629TxfFaxtXmkOJVyC3KgPHrTKspQPQVoa2Brxpr+SEROe7O4tVqp5Y2skoIzMCElVxzd5T39cDhU67TSDtDVyv9l1ffoQ0KbMufBrrm44sHHeIzh22q1NZysPfSrs2gHOaDJYEy1Hr6tk9RGpt2K5kBWfbpcdGwdw1/WUoMSqeCCaY36YXVfVqQMmv609t1wYHL0a98mjFrfu4416wW4UHJQg3PXj1ytwtp5q1bbk9U+YvVYPycfsrOpkBW3QtZgfUqnGHwdcJKB1Qjcut2KaIUaHBQAww/cHpilDlbNSoPMg7RKMQeHXil9ul51ap2CozhVqZQtiSIrtCYNVE9ZhzWLjgKE/rz1PVnVFLZqpbYPsirKXi1Z1aAH72+fhaycrMuRrMb2qv+blddj85JDLA7zOPCI2zj6MWJI+ZxiaFYOaKrVs96yzaNDoYSD0QIMh8ESt1n1ogyoLBRZ+W4159vN5NY5OmqgytiyY6Kij9Cazfectv7vVgfscux7QdY50EEdDvr42fe79Wa53K3h/uNuRVyPtO8MknXAR5zTN/OaQyoeyzgMyR3HKUwRY86XnKrVKm7RODtgsx6Dc05q4e1obbXigSN1QL0qY1URCrXm3tbdZi73+5f1kjy1W6caTplKIdrWbL5nFwZXQ+cp6yy7nsjacTXHE9021OnHvud1mOEd6+OnMCKE55/GH+pbfsTttFv1P6z1GN5KTGNwZarW0zSHOblYyjWnyCWvVgfVGhhDdgrO79YJd2v3ZTWbBqtHoXdrx7SG6/MzlNY1BWqgxmmu4VyoFJJtLfBtdf+westuZ1atekln1iaMOf9EVk3hMw5qt8aXnyeyDtK57UxWcEyzwT0a6jG8jylPwY2zGLI/z3Ocs0tlvJVcragG9OBxcIEz5Oe6FqWWAWdEKzrhusFRnatW1JPUTushIFkN3F5eYGxdc6AERdSaa9YcM7ZW+J5dLvqa84FCj/xOREnWNV2+rJefGWtW9+IGZbQAEdPrL3Ozen+8HIQAzwwT/tEw0Df7MaYyRz/NQhR/WZa4ZJ/G8T6WVIe5rtaAwkXOHL9EH7wy1eq+rZ7qHByNRTNJ440Zgqt73N5fX+3YupVICWpeWn4ZqfJt3R5WH/1eswbkz5dmNVu+krWO6OsvjA2G8q9eKGMkyJTefm1W5f3pSlb7b6uo1s8pkzVMixQlXJc1rcXnaXoeSyar04MLNjjhE+eOX1OIgazRLc4hWf2X1cPJWGdm1axxtz6/vdmpdW9WSc3LWvPrRJVUXOtoHdWsKdR8iJSLjr9cOZP9YI75Rrer9fbrt/XNCw3Nmt9/X36ojzchnG8dWQM3TIZHQtA3/N9cxiWFeZViDLd1y9sYyjS/TGOui8sIssbd6vk1R7KCSm71DmUnfS8C1Xl7BnRmUSYAiOR7DoAv7+84t57HRElqWbda2CZqzOO/rSHHWoiJqtZXIqp+gGO58zZN7e13sgIV3oPUANLKnD/+WKtVh3C5d1Ji4MD/Y/1xLtOa47JJOcXbtlvn5XWeSh3mRviI0cuQB+6HW44parL6zXsnexl2ax/sBdDDouBv1tePjy/ry5QpSRF1t87UlEffOuH3nP6H1Sc/vN1362n8tt7/4Fw060eQBkBZlcvnn7s1xt0aqzU+EvXY/bSMu1WR9X48luMUx2V5W6axWqFa024Nw70kslqd/RaaNfYiUn3Ai3UBVg3RWpFD3ePu7fPTLa3XZlXUemzF40JNZfKt88MaS6rFlKlqfX+uVgHn8Xlo0xSf/ySrpeJnlMZahaqM/wdm02CxAAAAeNpjYGRgAOGZd+Ps4/ltvjJIMr9gAIKTFo/+gmnLPMV/Hf8+sFQyvwZyORmYQKIAfjIOFHjaY2BkYGDh//cISK771/HfgqUSKIIKXgEAlCwGzAAAeNpt0wOsHlEUBOA55/61/WzbrG3btm23ceOkboPaZlA3rm3b1nZyn5Hky9z17pmsnkECAOAzkTTDNJmNbloD/pRkQmkIpuIeukk3ZFI1uYgMHosQTyTKFjSTWtTduc19gTSR4qg2uSiN4qlBdsbaZ7TGcK6jKIIayU00dYWhr24DdBi8dTGS9TSzKfnRbm7fgLf0R5x0Qagu5b5geJtBzDv0hMc7Z+ccphvfcRSq6XqU1e2A2QjoWq4XMwciVBLRSeY6F5mB8oXvtBKQ5qgtP3lvf4hcQrhGIly+U1f4akX4aCtUlGhu+/E7XXbta/rxWEcK5/kpzCAenw9f2YMYmYRKWhdV5LfzTW9QKZSVn85XeYFI6Y1UvEUfZpJWRUb27JtxFnXJh4K0hnMZPEcrce4nUZtdJMpOxMt1uMk/3oOz1+P8jimoLZvRyXayC2EUKS1Q2z7bQW18QLJ4oTb3t5V9PHYdyWYr7/eG7qMxZx/IuaM4ZgVgu2AP+bGHIIqjECqjZ1Azt4fCaqC7TXaRn+2iE6+Zy3lx7sUxZZmXwB4KiXZ+CbsgD64/aS145fZQGOdik/PIT9gFO6smTOG9zFHOZTRsv+KB2jIBtfGdmUHbOCu+i05EczMVzSUILSjduoUWxKRz6GYmo5lrJ5LEDW6UInWcEeytbU435GK3580jhNnO+O/IMtSWg9kdjWKeJ6Z25zcNhu9/ihWs9wAAAAAAAkQCRAJEAkQCigKwA6wE7wUlBq4G0QcSB1MH9QgvCIwIpQjdCPsJkgnUCoALQguyDGUNMA2bDs4PhA+QD64P6g/9EFMRAhJ7ExsUCxS5FWcV4xZaFy0XrRf5GDQZExliGm4bJxvfHIQdih5vH1IfriA7IN0h9SMnI8UkaSSVJLIk3yUrJUgleyZnJwgnlChJKMwpUyqTKzYrVSt4LFYsmC2lLkIu0S+YMCYwlDFrMeoyiTMMM/806DWTNgU2vjbcN5k3/Df8OEU47znHOlw7UDuEPN49OT5jP4E/+kAeQCZBu0HWQlBCn0K0QslC/EOVRCBEKUSRRKZFMUWERapFzUX6Ro9GmkatRvBHAkcdSIpJYUpSSmdKekqFSp1KtkrJSvxLE0vfS/lMDEwfTCtMN0xPTKJNuk3MTeBN9E4AThtOzE/rUANQD1AsUENQTlBqUHJRW1FmUXJRhFGiUbdRwlHfUfJTHVMvUzpTTVN+U5BTqFQaVQ9VJVU+VVZVhFWaVklWVFaVV3pYyFkYWS1Zf1nBWm5bAlxEXF1cdly2XMtdC10lXU9daV3UXfNeRl6XXuZfFl9oYDBg/mF7YoFjr2PIY9BkDWSqZPhlJ2WZZchmf2cjAAAAAQAAAOoBZwAcAGgABwABAAAAAAALAAACAASWAAQAAXjaXY61dQNQEATHzNCA2aGZme3ELMzEzAy5mlELKkaNCDcQvw83t4fALD4mGJucAxEdHmOVjs44y+Q6PMEFpQ5PDuRMsUulw9OsU+3wMnfUeSVOgiIpgvgJkGGTst4JRxzrbfKHk5SeSVkJvFK+lOXhQPRMRGdzoDqNPLyyXtkcXpTJHybpRnnKxIdB5CdLBPUendDpf8PmaB03A5tZkEpaepwYm9IOpOpglffLB1+ofqB6f2Su9tVJcMOhTho3ypOfER+gzkRk41L9HHY62snjxdUG1y48YHjabMGDgQIAAADA+962bau3jWxjy5ZqiVqgOwGg1RDUSRNdArr16NWn34BBQ4aNGDVm3IRJU6bNmDVn3oJFS5atWLVm3YZNW7bt2LVn34FDR46dOHXm3IVLQVeu3bh1596DR0+evXj15t2HT1++/fj1519IWERUTFxCUkpaRlZOXkFRSVlFVU29TRA8LIcBQAEA3FdbP1jbtqa220vt2LatiXmOnZyza7c99sYqv9z3QImPRj300jNfJPgdqz014J535i144ZPHqoyY81WiJYuW/ZSiQZ1U++z32gFNDqrXqE2zFq3GHNKpXYc0h816o0eXbkdMmPLEMUcdd9IJp3x32llnnHPeRRdcctm4K6656rqbbsj3w2233HHXpGmFeqXLiDWxVp8hw/pjnUxZcuWpli1HjUeS1CpVpjjWx4bYGJtis+dmYktsjW2xPXbEztilXMVKC+JgBDEABMBHjFJiD+M6Yhv1hzda4PtQi6IjAv2HsmKQcVHXmmHJ1nNUX7spi6YElIEKUEWCfRmfkCXtZqiKJtBnxyHnh73Pl3gbl+fqngV0gcEJTdqNBwAAAHjaZcslWIRBFEbhg7u7u7u7e+JPSFoSVvCG9bK90Qsb91nvaXuhJ3pjZp4PT+/MvecGoY8QKaSR2pcSIp0M+4ibxyKjdFBHCZDdFyeDcfp+TTKZ+tNkcc4+64zQpkk2G8zQT7Ma4qTwwAmeGSsi9d9ZGofsmKKHOjchRA55ZPUFoXnj4ax6PcSwGaTchHiWSdlsvQ1xKROy2HoX4kg2q/cocF5SpHuj6QP6L8tiSpwB6Rlt9yKT0keZ2/tlXBZR51ySr/JNNlnN/a58knH57lR3F8In/c4PdP5PzAA=
END_OF_STATIC_FILE;
}

// file: webroot/fonts/pt-serif-v11-latin/pt-serif-v11-latin-regular.woff2
namespace {
$_STATIC['/fonts/pt-serif-v11-latin/pt-serif-v11-latin-regular.woff2'] = <<<'END_OF_STATIC_FILE'
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
END_OF_STATIC_FILE;
}

// file: webroot/img/down.svg
namespace {
$_STATIC['/img/down.svg'] = <<<'END_OF_STATIC_FILE'
PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiID8+DQo8IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4iICJodHRwOi8vd3d3LnczLm9yZy9HcmFwaGljcy9TVkcvMS4xL0RURC9zdmcxMS5kdGQiPg0KPHN2ZyB3aWR0aD0iMjA2cHQiIGhlaWdodD0iMTc0cHQiIHZpZXdCb3g9IjAgMCAyMDYgMTc0IiB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+DQo8cGF0aCBvcGFjaXR5PSIxLjAwIiBkPSIgTSA1LjA4IDguOTcgQyA3MC41MSA5LjEzIDEzNS45NCA4Ljc4IDIwMS4zNyA5LjE1IEMgMTczLjQzIDU2LjA4IDE0NC4zNiAxMDIuMzQgMTE2LjA1IDE0OS4wNSBDIDExMS44NiAxNTUuODAgMTA3LjkxIDE2Mi43MCAxMDMuNDAgMTY5LjI1IEMgNzAuNTIgMTE1Ljg5IDM4LjAwIDYyLjMwIDUuMDggOC45NyBaIiAvPg0KPC9zdmc+
END_OF_STATIC_FILE;
}

// file: webroot/img/favicon.ico
namespace {
$_STATIC['/img/favicon.ico'] = <<<'END_OF_STATIC_FILE'
AAABAAEAEBAQAAEABAAoAQAAFgAAACgAAAAQAAAAIAAAAAEABAAAAAAAgAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAPj4+AJaWlQA7OzsAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACMzAAAAAAAAMwAAMzMAAjMzIAADMAAjMAMyAAMwADMAADMAAzAAMwAAMwADMAAzAAAzAAMwADMAADMyAzAjIzABMjMzMzMCMzMgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD//wAA//8AAP/wAAD/8wAAw4EAAOcYAADnPAAA5zwAAOc8AADnPAAAJBgAAACBAAD//wAA//8AAP//AAD//wAA
END_OF_STATIC_FILE;
}

// file: webroot/img/filter.svg
namespace {
$_STATIC['/img/filter.svg'] = <<<'END_OF_STATIC_FILE'
PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPCEtLSBTdmcgVmVjdG9yIEljb25zIDogaHR0cDovL3d3dy5vbmxpbmV3ZWJmb250cy5jb20vaWNvbiAtLT4KPCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj4KPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB2aWV3Qm94PSIwIDAgMTAwMCAxMDAwIiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IDAgMCAxMDAwIDEwMDAiIHhtbDpzcGFjZT0icHJlc2VydmUiPgo8bWV0YWRhdGE+IFN2ZyBWZWN0b3IgSWNvbnMgOiBodHRwOi8vd3d3Lm9ubGluZXdlYmZvbnRzLmNvbS9pY29uIDwvbWV0YWRhdGE+CjxnPjxwYXRoIGQ9Ik05OTAsMTB2NjUuM0w1OTgsNTMyLjdWOTkwTDQwMiw4NTkuM1Y1MzIuN0wxMCw3NS4zVjEwSDk5MHoiLz48L2c+Cjwvc3ZnPg==
END_OF_STATIC_FILE;
}

// file: webroot/img/next.svg
namespace {
$_STATIC['/img/next.svg'] = <<<'END_OF_STATIC_FILE'
PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+CjxzdmcKICAgeG1sbnM6ZGM9Imh0dHA6Ly9wdXJsLm9yZy9kYy9lbGVtZW50cy8xLjEvIgogICB4bWxuczpjYz0iaHR0cDovL2NyZWF0aXZlY29tbW9ucy5vcmcvbnMjIgogICB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiCiAgIHhtbG5zOnN2Zz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciCiAgIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIKICAgd2lkdGg9IjIwNnB0IgogICBoZWlnaHQ9IjE3NHB0IgogICB2aWV3Qm94PSIwIDAgMjA2IDE3NCIKICAgdmVyc2lvbj0iMS4xIj4KICA8cGF0aAogICAgIGQ9Im0gNDQuNDY2MzU2LDE2My42NjE3OCBjIDAuMTMwNTYsLTQ5LjcwMTE5IC0wLjE1NTA0LC05OS40MDIzNzMgMC4xNDY4OCwtMTQ5LjEwMzU2IDM4LjI5NDg3OSwyMS4yMjM0NjMgNzYuMDQzMDQ0LDQzLjMwNTI4MyAxMTQuMTU4NDA0LDY0LjgwOTgwMSA1LjUwNzk5LDMuMTgyNzU5IDExLjEzODM5LDYuMTgzMjEzIDE2LjQ4MzE5LDkuNjA5MDQ4IEMgMTMxLjcxMzA3LDExMy45NTMgODcuOTgzNjM0LDEzOC42NTU0NyA0NC40NjYzNTYsMTYzLjY2MTc4IFoiIC8+Cjwvc3ZnPgo=
END_OF_STATIC_FILE;
}

// file: webroot/img/prev.svg
namespace {
$_STATIC['/img/prev.svg'] = <<<'END_OF_STATIC_FILE'
PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+CjxzdmcKICAgeG1sbnM6ZGM9Imh0dHA6Ly9wdXJsLm9yZy9kYy9lbGVtZW50cy8xLjEvIgogICB4bWxuczpjYz0iaHR0cDovL2NyZWF0aXZlY29tbW9ucy5vcmcvbnMjIgogICB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiCiAgIHhtbG5zOnN2Zz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciCiAgIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIKICAgd2lkdGg9IjIwNnB0IgogICBoZWlnaHQ9IjE3NHB0IgogICB2aWV3Qm94PSIwIDAgMjA2IDE3NCIKICAgdmVyc2lvbj0iMS4xIj4KICA8cGF0aAogICAgIGQ9Im0gMTY0LjE5NTUxLDE0LjU1ODIyMyBjIC0wLjEzMDU2LDQ5LjcwMTE5IDAuMTU1MDQsOTkuNDAyMzY3IC0wLjE0Njg4LDE0OS4xMDM1NTcgQyAxMjUuNzUzNzUsMTQyLjQzODMyIDg4LjAwNTU4MSwxMjAuMzU2NSA0OS44OTAyMjEsOTguODUxOTgzIGMgLTUuNTA3OTksLTMuMTgyNzYgLTExLjEzODM5LC02LjE4MzIyIC0xNi40ODMxOSwtOS42MDkwNSA0My41NDE3NiwtMjQuOTc1OTMgODcuMjcxMTk5LC00OS42Nzg0IDEzMC43ODg0NzksLTc0LjY4NDcxIHoiIC8+Cjwvc3ZnPgo=
END_OF_STATIC_FILE;
}

// file: webroot/img/search.svg
namespace {
$_STATIC['/img/search.svg'] = <<<'END_OF_STATIC_FILE'
PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4NCjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCAyMCAyMCI+DQogIDx0aXRsZT4NCiAgICBzZWFyY2gNCiAgPC90aXRsZT4NCiAgPHBhdGggZD0iTTE5IDE3bC01LjE1LTUuMTVhNyA3IDAgMSAwLTIgMkwxNyAxOXpNMy41IDhBNC41IDQuNSAwIDEgMSA4IDEyLjUgNC41IDQuNSAwIDAgMSAzLjUgOHoiLz4NCjwvc3ZnPg0K
END_OF_STATIC_FILE;
}

// file: webroot/js/list.js
namespace {
$_STATIC['/js/list.js'] = <<<'END_OF_STATIC_FILE'
ZnVuY3Rpb24gYWpheEdldCh1cmwsIGNhbGxiYWNrKSB7CiAgICB2YXIgeG1saHR0cCA9IG5ldyBYTUxIdHRwUmVxdWVzdCgpOwogICAgeG1saHR0cC5vbnJlYWR5c3RhdGVjaGFuZ2UgPSBmdW5jdGlvbiAoKSB7CiAgICAgICAgaWYgKHhtbGh0dHAucmVhZHlTdGF0ZSA9PSA0ICYmIHhtbGh0dHAuc3RhdHVzID09IDIwMCkgewogICAgICAgICAgICBjb25zb2xlLmxvZygncmVzcG9uc2VUZXh0OicgKyB4bWxodHRwLnJlc3BvbnNlVGV4dCk7CiAgICAgICAgICAgIHRyeSB7CiAgICAgICAgICAgICAgICB2YXIgZGF0YSA9IEpTT04ucGFyc2UoeG1saHR0cC5yZXNwb25zZVRleHQpOwogICAgICAgICAgICB9IGNhdGNoIChlcnIpIHsKICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKGVyci5tZXNzYWdlICsgIiBpbiAiICsgeG1saHR0cC5yZXNwb25zZVRleHQpOwogICAgICAgICAgICAgICAgcmV0dXJuOwogICAgICAgICAgICB9CiAgICAgICAgICAgIGNhbGxiYWNrKGRhdGEpOwogICAgICAgIH0KICAgIH07CgogICAgeG1saHR0cC5vcGVuKCJHRVQiLCB1cmwsIHRydWUpOwogICAgeG1saHR0cC5zZW5kKCk7Cn0KZnVuY3Rpb24gc29ydFNlbGVjdE9wdGlvbnMobGIpIHsKICAgIGFyciA9IG5ldyBBcnJheSgpOwogICAgZm9yIChpID0gMDsgaSA8IGxiLmxlbmd0aDsgaSsrKSB7CiAgICAgICAgYXJyW2ldID0gbGIub3B0aW9uc1tpXTsKICAgIH0KICAgIGFyci5zb3J0KGZ1bmN0aW9uIChhLCBiKSB7CiAgICAgICAgcmV0dXJuIChhLnRleHQgPiBiLnRleHQpID8gMSA6ICgoYS50ZXh0IDwgYi50ZXh0KSA/IC0xIDogMCk7CiAgICB9KTsKICAgIGZvciAoaSA9IDA7IGkgPCBsYi5sZW5ndGg7IGkrKykgewogICAgICAgIGxiLm9wdGlvbnNbaV0gPSBhcnJbaV07CiAgICB9Cn0KZnVuY3Rpb24gcmVmbGVjdEhhc2goKSB7CiAgICBjb25zdCBoYXNoID0gd2luZG93LmxvY2F0aW9uLmhhc2g7CiAgICB2YXIgbmFtZSA9ICcnOwogICAgdmFyIG9wID0gJyc7CiAgICB2YXIgc3RyID0gJyc7CiAgICBjb25zdCBmaWVsZCA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5hZGRGaWx0ZXIgW25hbWU9ImZpZWxkIl0nKTsKICAgIGNvbnN0IG9wZXJhdG9yID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLmFkZEZpbHRlciBbbmFtZT0ib3BlcmF0b3IiXScpOwogICAgY29uc3QgdmFsdWUgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcuYWRkRmlsdGVyIFtuYW1lPSJ2YWx1ZSJdJyk7CiAgICBjb25zdCB2YWx1ZXMgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcuYWRkRmlsdGVyIFtuYW1lPSJ2YWx1ZXMiXScpOwogICAgY29uc3Qgc2VhcmNoID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLmFkZFNlYXJjaCBbbmFtZT0ic2VhcmNoIl0nKTsKICAgIGlmIChoYXNoLmxlbmd0aCA+IDEpIHsKICAgICAgICBjb25zdCBwYXJ0cyA9IGhhc2guc3BsaXQoJywnLCA0KTsKICAgICAgICBpZiAocGFydHNbMF0gPT0gJyNzZWFyY2gnKSB7CiAgICAgICAgICAgIGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5hZGRTZWFyY2gnKS5jbGFzc0xpc3QuYWRkKCd2aXNpYmxlJyk7CiAgICAgICAgICAgIG5hbWUgPSBwYXJ0c1sxXTsKICAgICAgICAgICAgb3AgPSAnY3MnOwogICAgICAgICAgICBzdHIgPSBwYXJ0c1syXTsKICAgICAgICB9IGVsc2UgewogICAgICAgICAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcuYWRkRmlsdGVyJykuY2xhc3NMaXN0LmFkZCgndmlzaWJsZScpOwogICAgICAgICAgICBuYW1lID0gcGFydHNbMV07CiAgICAgICAgICAgIG9wID0gcGFydHNbMl07CiAgICAgICAgICAgIHN0ciA9IHBhcnRzWzNdOwogICAgICAgIH0KICAgICAgICAvL3NldCBmaWVsZAogICAgICAgIGZvciAodmFyIGkgPSAwOyBpIDwgZmllbGQub3B0aW9ucy5sZW5ndGg7IGkrKykgewogICAgICAgICAgICBpZiAoZmllbGQub3B0aW9uc1tpXS52YWx1ZSA9PSBuYW1lKSB7CiAgICAgICAgICAgICAgICBmaWVsZC5zZWxlY3RlZEluZGV4ID0gaTsKICAgICAgICAgICAgICAgIGJyZWFrOwogICAgICAgICAgICB9CiAgICAgICAgfQogICAgICAgIGZvciAodmFyIGkgPSAwOyBpIDwgb3BlcmF0b3Iub3B0aW9ucy5sZW5ndGg7IGkrKykgewogICAgICAgICAgICBpZiAob3BlcmF0b3Iub3B0aW9uc1tpXS52YWx1ZSA9PSBvcCkgewogICAgICAgICAgICAgICAgb3BlcmF0b3Iuc2VsZWN0ZWRJbmRleCA9IGk7CiAgICAgICAgICAgICAgICBicmVhazsKICAgICAgICAgICAgfQogICAgICAgIH0KICAgICAgICB2YWx1ZS52YWx1ZSA9IHN0ciB8fCAnJzsKICAgICAgICBzdHJzID0gc3RyLnNwbGl0KCd8Jyk7CiAgICAgICAgZm9yICh2YXIgaSA9IDA7IGkgPCB2YWx1ZXMub3B0aW9ucy5sZW5ndGg7IGkrKykgewogICAgICAgICAgICBpZiAoc3Rycy5pbmRleE9mKHZhbHVlcy5vcHRpb25zW2ldLnZhbHVlKSA+PSAwKSB7CiAgICAgICAgICAgICAgICB2YWx1ZXMub3B0aW9uc1tpXS5zZWxlY3RlZCA9IHRydWU7CiAgICAgICAgICAgICAgICBicmVhazsKICAgICAgICAgICAgfQogICAgICAgIH0KICAgICAgICBzZWFyY2gudmFsdWUgPSBzdHIgfHwgJyc7CiAgICB9Cn0KCmZ1bmN0aW9uIHVwZGF0ZUFkZEZpbHRlcigpIHsKICAgIGNvbnN0IGZpZWxkID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLmFkZEZpbHRlciBbbmFtZT0iZmllbGQiXScpOwogICAgY29uc3Qgb3BlcmF0b3IgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcuYWRkRmlsdGVyIFtuYW1lPSJvcGVyYXRvciJdJyk7CiAgICBjb25zdCB2YWx1ZSA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5hZGRGaWx0ZXIgW25hbWU9InZhbHVlIl0nKTsKICAgIGNvbnN0IHZhbHVlcyA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5hZGRGaWx0ZXIgW25hbWU9InZhbHVlcyJdJyk7CiAgICBpZiAoZmllbGQub3B0aW9uc1tmaWVsZC5zZWxlY3RlZEluZGV4XS5kYXRhc2V0LnJlZmVyZW5jZXMpIHsKICAgICAgICBvcGVyYXRvci5zdHlsZS5kaXNwbGF5ID0gJ25vbmUnOwogICAgICAgIHZhbHVlLnR5cGUgPSAnaGlkZGVuJzsKICAgICAgICB2YWx1ZXMuc3R5bGUuZGlzcGxheSA9ICdpbmxpbmUnOwogICAgICAgIGFqYXhHZXQoJ3ZhbHVlcy8nICsgZmllbGQudmFsdWUsIGZ1bmN0aW9uIChkYXRhKSB7CiAgICAgICAgICAgIHZhbHVlcy5pbm5lckhUTUwgPSAnJzsKICAgICAgICAgICAgT2JqZWN0LmtleXMoZGF0YSkuZm9yRWFjaChmdW5jdGlvbiAoaXRlbSkgewogICAgICAgICAgICAgICAgdmFyIG9wdGlvbiA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoJ29wdGlvbicpOwogICAgICAgICAgICAgICAgb3B0aW9uLnZhbHVlID0gaXRlbTsKICAgICAgICAgICAgICAgIG9wdGlvbi5pbm5lckhUTUwgPSBkYXRhW2l0ZW1dOwogICAgICAgICAgICAgICAgdmFsdWVzLmFwcGVuZENoaWxkKG9wdGlvbik7CiAgICAgICAgICAgIH0pOwogICAgICAgICAgICBzb3J0U2VsZWN0T3B0aW9ucyh2YWx1ZXMpOwogICAgICAgIH0pOwogICAgfSBlbHNlIHsKICAgICAgICBvcGVyYXRvci5zdHlsZS5kaXNwbGF5ID0gJ2lubGluZSc7CiAgICAgICAgdmFsdWUudHlwZSA9ICd0ZXh0JzsKICAgICAgICB2YWx1ZXMuc3R5bGUuZGlzcGxheSA9ICdub25lJzsKICAgIH0KfQpmdW5jdGlvbiB1cGRhdGVUZXh0QW5kVmFsdWUoKSB7CiAgICBjb25zdCB0ZXh0ID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLmFkZEZpbHRlciBbbmFtZT0idGV4dCJdJyk7CiAgICBjb25zdCB2YWx1ZSA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5hZGRGaWx0ZXIgW25hbWU9InZhbHVlIl0nKTsKICAgIGNvbnN0IHZhbHVlcyA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5hZGRGaWx0ZXIgW25hbWU9InZhbHVlcyJdJyk7CiAgICB0ZXh0QXJyYXkgPSBbXTsKICAgIHZhbHVlQXJyYXkgPSBbXTsKICAgIGZvciAodmFyIGkgPSAwOyBpIDwgdmFsdWVzLm9wdGlvbnMubGVuZ3RoOyBpKyspIHsKICAgICAgICBjb25zdCBpdGVtID0gdmFsdWVzLm9wdGlvbnNbaV07CiAgICAgICAgaWYgKGl0ZW0uc2VsZWN0ZWQpIHsKICAgICAgICAgICAgdGV4dEFycmF5LnB1c2goaXRlbS50ZXh0KTsKICAgICAgICAgICAgdmFsdWVBcnJheS5wdXNoKGl0ZW0udmFsdWUpOwogICAgICAgIH0KICAgIH0KICAgIHRleHQudmFsdWUgPSB0ZXh0QXJyYXkuam9pbignLCAnKTsKICAgIHZhbHVlLnZhbHVlID0gdmFsdWVBcnJheS5qb2luKCcsJyk7Cn0KCmZ1bmN0aW9uIGNsb3NlRmlsdGVyKGluZGV4KSB7CiAgICBjb25zdCBlbGVtZW50cyA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJy5maWx0ZXJiYXInKTsKICAgIGZvciAodmFyIGkgPSAwOyBpIDwgZWxlbWVudHMubGVuZ3RoOyBpKyspIHsKICAgICAgICBpZiAoZWxlbWVudHNbaV0uZGF0YXNldC5pbmRleCA9PSBpbmRleCkgewogICAgICAgICAgICBlbGVtZW50c1tpXS5wYXJlbnROb2RlLnJlbW92ZUNoaWxkKGVsZW1lbnRzW2ldKTsKICAgICAgICB9CiAgICB9CiAgICByZXR1cm4gcmVsb2FkUXVlcnkoKTsKfQpmdW5jdGlvbiBlZGl0RmlsdGVyKGluZGV4KSB7CiAgICBjb25zdCBlbGVtZW50cyA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJy5maWx0ZXJiYXInKTsKICAgIHZhciB0eXBlID0gJyc7CiAgICB2YXIgZmlsdGVyID0gJyc7CiAgICBmb3IgKHZhciBpID0gMDsgaSA8IGVsZW1lbnRzLmxlbmd0aDsgaSsrKSB7CiAgICAgICAgaWYgKGVsZW1lbnRzW2ldLmRhdGFzZXQuaW5kZXggPT0gaW5kZXgpIHsKICAgICAgICAgICAgZmlsdGVyID0gZWxlbWVudHNbaV0uZGF0YXNldC5maWx0ZXI7CiAgICAgICAgICAgIHR5cGUgPSBmaWx0ZXIuc3Vic3RyKDAsIGZpbHRlci5pbmRleE9mKCIsIikpOwogICAgICAgICAgICBlbGVtZW50c1tpXS5wYXJlbnROb2RlLnJlbW92ZUNoaWxkKGVsZW1lbnRzW2ldKTsKICAgICAgICB9CiAgICB9CiAgICByZXR1cm4gcmVsb2FkUXVlcnkoZmlsdGVyKTsKfQpmdW5jdGlvbiBuYXZpZ2F0ZVBhZ2UocGFnZSkgewogICAgY29uc3QgZWxlbWVudCA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5wYWdpbmF0aW9uJyk7CiAgICBpZiAoZWxlbWVudCkgewogICAgICAgIGVsZW1lbnQuZGF0YXNldC5wYWdlID0gcGFnZTsKICAgIH0KICAgIHJldHVybiByZWxvYWRRdWVyeSgpOwp9CmZ1bmN0aW9uIGlzUGFydGlhbGx5T2Zmc2NyZWVuKGVsZW1lbnQpIHsKICAgIHZhciByZWN0ID0gZWxlbWVudC5nZXRCb3VuZGluZ0NsaWVudFJlY3QoKTsKICAgIHJldHVybiByZWN0LnggPCAwIHx8IChyZWN0LnggKyByZWN0LndpZHRoKSA+ICh3aW5kb3cuaW5uZXJXaWR0aCAtIDIwKTsKfQp2YXIgdGltZU91dCA9IG51bGw7CmZ1bmN0aW9uIHJlc2l6ZVdpbmRvdygpIHsKICAgIGlmICh0aW1lT3V0ICE9IG51bGwpIGNsZWFyVGltZW91dCh0aW1lT3V0KTsKICAgIHRpbWVPdXQgPSBzZXRUaW1lb3V0KGhpZGVDb2x1bW5zLCAxMDApOwp9CmZ1bmN0aW9uIGhpZGVDb2x1bW5zKCkgewogICAgY29uc3QgYWxsID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgndGgsIHRkJyk7CiAgICBmb3IgKHZhciBpID0gMDsgaSA8IGFsbC5sZW5ndGg7IGkrKykgewogICAgICAgIGFsbFtpXS5jbGFzc0xpc3QucmVtb3ZlKCdoaWRkZW4nKTsKICAgIH0KICAgIGlmICh3aW5kb3cuaW5uZXJXaWR0aCA+PSAxNTAwKSB7CiAgICAgICAgcmV0dXJuOwogICAgfQogICAgY29uc3QgZWxlbWVudHMgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCd0aCcpOwogICAgdmFyIG1heCA9IGVsZW1lbnRzLmxlbmd0aDsKICAgIGZvciAodmFyIGkgPSAwOyBpIDwgZWxlbWVudHMubGVuZ3RoOyBpKyspIHsKICAgICAgICBpZiAoaXNQYXJ0aWFsbHlPZmZzY3JlZW4oZWxlbWVudHNbaV0pKSB7CiAgICAgICAgICAgIG1heCA9IGk7CiAgICAgICAgICAgIGJyZWFrOwogICAgICAgIH0KICAgIH0KICAgIGNvbnN0IGhlYWRlcnMgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCd0aDpudGgtY2hpbGQobisnICsgKG1heCArIDEpICsgJyknKTsKICAgIGZvciAodmFyIGkgPSAwOyBpIDwgaGVhZGVycy5sZW5ndGg7IGkrKykgewogICAgICAgIGhlYWRlcnNbaV0uY2xhc3NMaXN0LmFkZCgnaGlkZGVuJyk7CiAgICB9CiAgICBjb25zdCBjZWxscyA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJ3RkOm50aC1jaGlsZChuKycgKyAobWF4ICsgMSkgKyAnKScpOwogICAgZm9yICh2YXIgaSA9IDA7IGkgPCBjZWxscy5sZW5ndGg7IGkrKykgewogICAgICAgIGNlbGxzW2ldLmNsYXNzTGlzdC5hZGQoJ2hpZGRlbicpOwogICAgfQp9CmZ1bmN0aW9uIHJlbG9hZFF1ZXJ5KGZpbHRlcikgewogICAgY29uc3QgZWxlbWVudHMgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCcuZmlsdGVyYmFyJyk7CiAgICB2YXIgcGFyYW1zID0gW107CiAgICBmb3IgKHZhciBpID0gMDsgaSA8IGVsZW1lbnRzLmxlbmd0aDsgaSsrKSB7CiAgICAgICAgcGFyYW1zLnB1c2goJ2ZpbHRlcj0nICsgZW5jb2RlVVJJQ29tcG9uZW50KGVsZW1lbnRzW2ldLmRhdGFzZXQuZmlsdGVyKSk7CiAgICB9CiAgICBjb25zdCBlbGVtZW50ID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLnBhZ2luYXRpb24nKTsKICAgIGlmIChlbGVtZW50KSB7CiAgICAgICAgcGFyYW1zLnB1c2goJ3BhZ2U9JyArIGVuY29kZVVSSUNvbXBvbmVudChlbGVtZW50LmRhdGFzZXQucGFnZSkpOwogICAgfQogICAgZG9jdW1lbnQubG9jYXRpb24uaHJlZiA9ICc/JyArIHBhcmFtcy5qb2luKCcmJykgKyAnIycgKyAoZmlsdGVyIHx8ICcnKTsKICAgIHJldHVybiBmYWxzZTsKfQp3aW5kb3cuYWRkRXZlbnRMaXN0ZW5lcignbG9hZCcsIGZ1bmN0aW9uICgpIHsgaGlkZUNvbHVtbnMoKTsgcmVmbGVjdEhhc2goKTsgdXBkYXRlQWRkRmlsdGVyKCk7IH0pOwp3aW5kb3cuYWRkRXZlbnRMaXN0ZW5lcigncmVzaXplJywgZnVuY3Rpb24gKCkgeyByZXNpemVXaW5kb3coKTsgfSk7Cg==
END_OF_STATIC_FILE;
}

// file: webroot/index.php
namespace Tqdev\PhpCrudUi {

    use Tqdev\PhpCrudApi\RequestFactory;
    use Tqdev\PhpCrudApi\ResponseUtils;
    use Tqdev\PhpCrudUi\Config;
    use Tqdev\PhpCrudUi\Ui;

    $config = new Config([
        'api' => [
            'username' => 'php-crud-api',
            'password' => 'php-crud-api',
            'database' => 'php-crud-api',
        ],
        'templatePath' => '../templates',
    ]);
    $request = RequestFactory::fromGlobals();
    $ui = new Ui($config);
    $response = $ui->handle($request);
    ResponseUtils::output($response);
}
