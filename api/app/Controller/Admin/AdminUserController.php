<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Service\AdminUserService;
use Hyperf\Context\Context;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Taoran\HyperfPackage\Core\AbstractController;
use Taoran\HyperfPackage\Core\Code;

class AdminUserController extends AbstractController
{
    /**
     * @Inject()
     * @var AdminUserService
     */
    protected $adminUserService;

    public function index()
    {
        try {
            $params = $this->verify->requestParams([
                ['account', ''],
                ['is_all', 0],
            ], $this->request);

            //参数验证
            $this->verify->check(
                $params,
                [
                    'is_all' => 'in:0,1',
                ],
                [
                    'is_all.in' => '参数错误',
                ]
            );

            $list =  $this->adminUserService->getList($params);
            return $this->responseCore->success($list);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }


    public function show($id)
    {
        $data =  $this->adminUserService->getOne((int)$id);
        return $this->responseCore->success($data);
    }


    public function store()
    {
        try {
            $params = $this->verify->requestParams([
                ['account', ''],
                ['password', ''],
                ['name', ''],
                ['headimg', ''],
                ['role_id', ''],
            ], $this->request);

            //参数验证
            $this->verify->check(
                $params,
                [
                    'account' => 'required|min:6|max:16',
                    'password' => 'required|min:6|max:16',
                    'name' => 'required',
                    'headimg' => '',
                    'role_id' => 'required|integer',
                ],
                [
                    'account.required' => '账号不能为空！',
                    'account.min' => '账号不能小于6位！',
                    'account.max' => '账号不能大于16位！',
                    'name.required' => '名称不能为空！',
                    'password.required' => '密码不能为空！',
                    'password.min' => '密码不能小于6位！',
                    'password.max' => '密码不能大于16位！',
                    'role_id.required' => '请选择角色！',
                    'role_id.integer' => '参数错误！',
                ]
            );

            $this->adminUserService->add($params);
            return $this->responseCore->success("操作成功！");
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }

    public function update($id)
    {
        try {
            $params = $this->verify->requestParams([
                ['account', ''],
                ['password', ''],
                ['name', ''],
                ['headimg', ''],
                ['role_id', ''],
            ], $this->request);

            //参数验证
            $this->verify->check(
                $params,
                [
                    'account' => 'required|min:6|max:16',
                    'password' => 'min:6|max:16',
                    'name' => 'required',
                    'headimg' => '',
                    'role_id' => 'required|integer',
                ],
                [
                    'account.required' => '账号不能为空！',
                    'account.min' => '账号不能小于6位！',
                    'account.max' => '账号不能大于16位！',
                    'name.required' => '名称不能为空！',
                    'password.min' => '密码不能小于6位！',
                    'password.max' => '密码不能大于16位！',
                    'role_id.required' => '请选择角色！',
                    'role_id.integer' => '参数错误！',
                ]
            );

            $this->adminUserService->update((int)$id, $params);
            return $this->responseCore->success("操作成功！");
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }

    public function destroy($id)
    {
        $data =  $this->adminUserService->destroy((int)$id);
        return $this->responseCore->success($data);
    }

    /**
     * 获取当前管理员相关信息
     *
     * @return array
     * @throws \Exception
     */
    public function getCurrentUser()
    {
        //获取当前用户id
        $result = Context::get(ServerRequestInterface::class);
        $admin_user_id = $result->getAttribute('admin_user_id');
        $data = $this->adminUserService->getCurrentUser([
            'admin_user_id' => $admin_user_id
        ]);

        return $this->responseCore->success($data);
    }

    /**
     * 登录
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function login()
    {
        try {
            //获取参数
            $params = $this->verify->requestParams([
                ['account', ''],
                ['password', ''],
            ], $this->request);

            //参数验证
            $this->verify->check(
                $params,
                [
                    'account' => 'required',
                    'password' => 'required',
                ],
                [
                    'account.required' => '账号不能为空',
                    'password.required' => '密码不能为空',
                ]
            );

            //业务
            $result = $this->adminUserService->login($params);
            //响应
            return $this->responseCore->success($result);
        } catch (\Exception $e) {
            return $this->responseCore->error(Code::VALIDATE_ERROR, $e->getMessage());
        }
    }

    /**
     * logout
     */
    public function logout()
    {
        $this->adminUserService->logout();
        return $this->responseCore->success('操作成功');
    }
}
