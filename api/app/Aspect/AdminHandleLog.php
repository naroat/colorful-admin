<?php

declare(strict_types=1);

namespace App\Aspect;

use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Router\Dispatched;
use Psr\Container\ContainerInterface;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Psr\Http\Message\ServerRequestInterface;
use function Taoran\HyperfPackage\Helpers\set_save_data;
use Taoran\HyperfPackage\Traits\NetworkTrait;

/**
 * @Aspect
 */
class AdminHandleLog extends AbstractAspect
{
    use NetworkTrait;

    protected $container;

    /**
     * @Inject()
     * @var RequestInterface
     */
    protected $request;

    //切入类 or 方法
    public $classes = [
        'App\Controller\Admin\AdminUserController::store',
        'App\Controller\Admin\AdminUserController::update',
        'App\Controller\Admin\AdminUserController::destroy',
        'App\Controller\Admin\ArticleCategoryController::store',
        'App\Controller\Admin\ArticleCategoryController::update',
        'App\Controller\Admin\ArticleCategoryController::destroy',
        'App\Controller\Admin\ArticleController::store',
        'App\Controller\Admin\ArticleController::update',
        'App\Controller\Admin\ArticleController::destroy',
        'App\Controller\Admin\RoleController::store',
        'App\Controller\Admin\RoleController::update',
        'App\Controller\Admin\RoleController::destroy',
        'App\Controller\Admin\PermissionController::store',
        'App\Controller\Admin\PermissionController::update',
        'App\Controller\Admin\PermissionController::destroy',
        'App\Controller\Admin\MenuController::store',
        'App\Controller\Admin\MenuController::update',
        'App\Controller\Admin\MenuController::destroy',
        'App\Controller\Admin\ConfigController::updateBase',
    ];

    //对应描述
    public $classesDesc = [
        'App\Controller\AdminUserController::store' => '新增管理员',
        'App\Controller\AdminUserController::update' => '更新管理员',
        'App\Controller\AdminUserController::destroy' => '删除管理员',
        'App\Controller\ArticleCategoryController::store' => '新增文章分类',
        'App\Controller\ArticleCategoryController::update' => '更新文章分类',
        'App\Controller\ArticleCategoryController::destroy' => '删除文章分类',
        'App\Controller\ArticleController::store' => '新增文章',
        'App\Controller\ArticleController::update' => '更新文章',
        'App\Controller\ArticleController::destroy' => '删除文章',
        'App\Controller\RoleController::store' => '新增角色',
        'App\Controller\RoleController::update' => '更新角色',
        'App\Controller\RoleController::destroy' => '删除角色',
        'App\Controller\PermissionController::store' => '新增权限',
        'App\Controller\PermissionController::update' => '更新权限',
        'App\Controller\PermissionController::destroy' => '删除权限',
        'App\Controller\MenuController::store' => '新增菜单',
        'App\Controller\MenuController::update' => '更新菜单',
        'App\Controller\MenuController::destroy' => '删除菜单',
        'App\Controller\Admin\ConfigController::updateBase' => '更改网站配置',
    ];

    //切入注解
    public $annotations = [];

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        $result = $proceedingJoinPoint->process();
        //记录操作日志
        $this->recordLog($result);
        return $result;
    }

    /**
     * 记录操作日志
     */
    public function recordLog($result)
    {
        $params = $this->request->all();
        $classes = $this->getClasses();
        $response_data = $this->getResponseData($result);
        $handleLogModel = new \App\Model\AdminHandleLog();
        set_save_data($handleLogModel, [
            'admin_user_id' => $this->getAdminUserId(),
            'classes' => $classes,
            'desc' => $this->classesDesc[$classes],
            'request_data' => json_encode($params, JSON_UNESCAPED_UNICODE),
            'response_data' => $response_data,
            'ip' => $this->getClientIp(),
        ]);
        $handleLogModel->save();
    }

    public function getAdminUserId()
    {
        $contextResult = \Hyperf\Context\Context::get(ServerRequestInterface::class);
        return $contextResult->getAttribute('admin_user_id');
    }

    public function getClasses()
    {
        $controllerMethod = explode('@',$this->request->getAttribute(Dispatched::class)->handler->callback);
        return $controllerMethod[0] . '::' . $controllerMethod[1];
    }

    public function getResponseData($result)
    {
        //响应数据(去掉data)
        unset($result['data']);
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}
