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
        $router->register('GET', '/*/create', array($this, 'createForm'));
        $router->register('POST', '/*/create', array($this, 'create'));
        $router->register('GET', '/*/read/*', array($this, 'read'));
        $router->register('GET', '/*/update/*', array($this, 'updateForm'));
        $router->register('POST', '/*/update/*', array($this, 'update'));
        $router->register('GET', '/*/delete/*', array($this, 'deleteForm'));
        $router->register('POST', '/*/delete/*', array($this, 'delete'));
        $router->register('GET', '/*/list', array($this, '_list'));
        $router->register('GET', '/*/list/*/*/*', array($this, '_list'));
        $this->service = $service;
        $this->responder = $responder;
    }

    public function createForm(ServerRequestInterface $request): ResponseInterface
    {
        $table = RequestUtils::getPathSegment($request, 1);
        $action = RequestUtils::getPathSegment($request, 2);
        if (!$this->service->hasTable($table, $action)) {
            return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $table);
        }
        $data = $this->service->createForm($table, $action);
        return $this->responder->success($data);
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
        $data = $this->service->create($table, $action, $record);
        return $this->responder->success($data);
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
        $data = $this->service->read($table, $action, $id, $params);
        return $this->responder->success($data);
    }

    public function updateForm(ServerRequestInterface $request): ResponseInterface
    {
        $table = RequestUtils::getPathSegment($request, 1);
        $action = RequestUtils::getPathSegment($request, 2);
        $id = RequestUtils::getPathSegment($request, 3);
        if (!$this->service->hasTable($table, $action)) {
            return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $table);
        }
        $data = $this->service->updateForm($table, $action, $id, $record);
        return $this->responder->success($data);
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
        $data = $this->service->update($table, $action, $id, $record);
        return $this->responder->success($data);
    }

    public function deleteForm(ServerRequestInterface $request): ResponseInterface
    {
        $table = RequestUtils::getPathSegment($request, 1);
        $action = RequestUtils::getPathSegment($request, 2);
        $id = RequestUtils::getPathSegment($request, 3);
        if (!$this->service->hasTable($table, 'read')) {
            return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $table);
        }
        $data = $this->service->deleteForm($table, $action, $id);
        return $this->responder->success($data);
    }

    public function delete(ServerRequestInterface $request): ResponseInterface
    {
        $table = RequestUtils::getPathSegment($request, 1);
        $action = RequestUtils::getPathSegment($request, 2);
        $id = RequestUtils::getPathSegment($request, 3);
        if (!$this->service->hasTable($table, 'read')) {
            return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $table);
        }
        $data = $this->service->delete($table, $action, $id);
        return $this->responder->success($data);
    }

    public function _list(ServerRequestInterface $request): ResponseInterface
    {
        $table = RequestUtils::getPathSegment($request, 1);
        $action = RequestUtils::getPathSegment($request, 2);
        $field = RequestUtils::getPathSegment($request, 3);
        $id = RequestUtils::getPathSegment($request, 4);
        $name = RequestUtils::getPathSegment($request, 5);
        $params = RequestUtils::getParams($request);
        if (!$this->service->hasTable($table, $action)) {
            return $this->responder->error(ErrorCode::TABLE_NOT_FOUND, $table);
        }
        $data = $this->service->_list($table, $action, $field, $id, $name, $params);
        return $this->responder->success($data);
    }

}
