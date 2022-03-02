<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Service\ConfigService;
use Hyperf\Di\Annotation\Inject;
use Taoran\HyperfPackage\Core\AbstractController;

class ConfigController extends AbstractController
{

    /**
     * @Inject()
     * @var ConfigService
     */
    protected $configService;

    public function index()
    {
        try {
            $list = $this->configService->getData([
                'codes' => [
                    'about_us',
                    'base_setting_name',
//                    'base_setting_favicon',
                    'base_setting_keyword',
                    'base_setting_description',
                ],
                'is_all' => 1
            ]);
            return $this->responseCore->success($list);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }

    /**
     * 更新基础配置
     *
     * @return array
     */
    public function updateBase()
    {
        try {
            $params = $this->request->all();
            $this->verify->check($params, [
                'base_setting_name' => 'required',
//                'base_setting_favicon' => 'required',
                'base_setting_keyword' => 'required',
                'base_setting_description' => 'required',
                'about_us' => 'required',
            ], [
                'base_setting_name.required' => '请填写网站名称',
//                'base_setting_favicon.required' => '请上传favicon',
                'base_setting_keyword.required' => '请填写关键词',
                'base_setting_description.required' => '请填写描述',
                'about_us.required' => '请填写关于',
            ]);
            $this->configService->updateBase($params);
            return $this->responseCore->success('操作成功！');
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }
}
