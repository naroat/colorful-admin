<?php

declare(strict_types=1);

namespace App\Middleware;

use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;
use Hyperf\HttpServer\Router\Dispatched;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Hyperf\Di\Annotation\Inject;

class RBACMiddleware implements MiddlewareInterface
{
    /**
     * @Inject
     * @var HttpResponse
     */
    protected $response;

    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        //基于角色的权限控制
        try {
            //超级管理员具有全部权限
            $result = \Hyperf\Context\Context::get(ServerRequestInterface::class);
            $role_id = $result->getAttribute('role_id');

            //1：为管理员，拥有全部权限
            if ($role_id != 1) {
                //获取当前路由code（即控制器和方法）
                $controllerMethod = $request->getAttribute(Dispatched::class)->handler->callback;

                //读取角色权限判断是否有权限操作
                $roleInfo = \App\Model\Role::where('is_on', 1)
                    ->with(['permissions' => function ($query) {
                        $query->where('is_on', 1);
                    }])
                    ->find($role_id);
                $permission_list = $roleInfo->permissions->pluck("code")->toArray();
                if (!(in_array($controllerMethod, $permission_list))) {
                    throw new \Exception("无权限！");
                }
            }

            return $handler->handle($request);
        } catch (\Exception $e) {
            return $this->response->json(['code' => 403, 'message' => $e->getMessage(), 'data' => []]);
        }
    }
}