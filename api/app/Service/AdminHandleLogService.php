<?php


namespace App\Service;


use App\Model\AdminHandleLog;
use Hyperf\Di\Annotation\Inject;

class AdminHandleLogService
{
    /**
     * @Inject()
     * @var AdminHandleLog
     */
    protected $adminHandleLogModel;

    public function getList($params)
    {
        $list = $this->adminHandleLogModel->getList(['id', 'admin_user_id', 'classes', 'desc', 'request_data', 'response_data', 'ip', 'create_time'], $params, function ($orm) use ($params) {
            $orm->with('adminUser')->orderBy('id', 'DESC');
            //筛选
            if (isset($params['admin_user_id']) && $params['admin_user_id'] != "") {
                $orm->where('admin_user_id', $params['admin_user_id']);
            }
            if (isset($params['desc']) && $params['desc'] != "") {
                $orm->where('desc', 'like', "%{$params['desc']}%");
            }
        });

        $list->each(function ($item) {
            $item->account = $item->adminUser->account ?? '';
            $item->request_data = htmlspecialchars_decode($item->request_data ?? '');
            $item->response_data = htmlspecialchars_decode($item->response_data ?? '');
            unset($item->user);
        });

        return $list;
    }
}