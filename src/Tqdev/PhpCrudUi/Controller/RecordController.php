<?php

namespace Tqdev\PhpCrudUi\Controller;

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
        $router->register('GET', '/editor/*/create', array($this, 'createForm'));
        $router->register('POST', '/editor/*/create', array($this, 'create'));
        $router->register('GET', '/editor/*/read/*', array($this, 'read'));
        $router->register('GET', '/editor/*/update/*', array($this, 'updateForm'));
        $router->register('POST', '/editor/*/update/*', array($this, 'update'));
        $router->register('GET', '/editor/*/delete/*', array($this, 'deleteForm'));
        $router->register('POST', '/editor/*/delete/*', array($this, 'delete'));
        $router->register('GET', '/editor/*/list', array($this, '_list'));
        $router->register('GET', '/editor/*/list/*/*/*', array($this, '_list'));
        $router->register('GET', '/editor/*/export', array($this, 'export'));
        $this->service = $service;
        $this->responder = $responder;
    }

    public function createForm(ServerRequestInterface $request): ResponseInterface
    {
        $table = RequestUtils::getPathSegment($request, 2);
        $action = RequestUtils::getPathSegment($request, 3);
        if (!$this->service->hasTable($table, $action)) {
            return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $table);
        }
        $result = $this->service->createForm($table, $action);
        return $this->responder->success($result);
    }

    public function create(ServerRequestInterface $request): ResponseInterface
    {
        $table = RequestUtils::getPathSegment($request, 2);
        $action = RequestUtils::getPathSegment($request, 3);
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
        $table = RequestUtils::getPathSegment($request, 2);
        $action = RequestUtils::getPathSegment($request, 3);
        $id = RequestUtils::getPathSegment($request, 4);
        $params = RequestUtils::getParams($request);
        if (!$this->service->hasTable($table, $action)) {
            return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $table);
        }
        $result = $this->service->read($table, $action, $id, $params);
        return $this->responder->success($result);
    }

    public function updateForm(ServerRequestInterface $request): ResponseInterface
    {
        $table = RequestUtils::getPathSegment($request, 2);
        $action = RequestUtils::getPathSegment($request, 3);
        $id = RequestUtils::getPathSegment($request, 4);
        if (!$this->service->hasTable($table, $action)) {
            return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $table);
        }
        $result = $this->service->updateForm($table, $action, $id);
        return $this->responder->success($result);
    }

    public function update(ServerRequestInterface $request): ResponseInterface
    {
        $table = RequestUtils::getPathSegment($request, 2);
        $action = RequestUtils::getPathSegment($request, 3);
        $id = RequestUtils::getPathSegment($request, 4);
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
        $table = RequestUtils::getPathSegment($request, 2);
        $action = RequestUtils::getPathSegment($request, 3);
        $id = RequestUtils::getPathSegment($request, 4);
        if (!$this->service->hasTable($table, 'read')) {
            return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $table);
        }
        $result = $this->service->deleteForm($table, $action, $id);
        return $this->responder->success($result);
    }

    public function delete(ServerRequestInterface $request): ResponseInterface
    {
        $table = RequestUtils::getPathSegment($request, 2);
        $action = RequestUtils::getPathSegment($request, 3);
        $id = RequestUtils::getPathSegment($request, 4);
        if (!$this->service->hasTable($table, 'read')) {
            return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $table);
        }
        $result = $this->service->delete($table, $action, $id);
        return $this->responder->success($result);
    }

    public function _list(ServerRequestInterface $request): ResponseInterface
    {
        $table = RequestUtils::getPathSegment($request, 2);
        $action = RequestUtils::getPathSegment($request, 3);
        $field = RequestUtils::getPathSegment($request, 4);
        $id = RequestUtils::getPathSegment($request, 5);
        $name = RequestUtils::getPathSegment($request, 6);
        $params = RequestUtils::getParams($request);
        if (!$this->service->hasTable($table, $action)) {
            return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $table);
        }
        $result = $this->service->_list($table, $action, $field, $id, $name, $params);
        return $this->responder->success($result);
    }

    public function export(ServerRequestInterface $request): ResponseInterface
    {
        $table = RequestUtils::getPathSegment($request, 2);
        if (!$this->service->hasTable($table, 'list')) {
            return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $table);
        }
        $result = $this->service->export($table, 'list');
        return $this->responder->success($result);
    }
}
