<?php


namespace App\Service;

use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Taoran\HyperfPackage\Core\AbstractController;

class ConfigService extends AbstractController
{
    /**
     * @Inject()
     * @var \App\Model\Config
     */
    protected $configModel;

    public function getData($params)
    {
        $list = $this->configModel->getList(['id', 'code', 'desc', 'value', 'unit'], $params, function ($query) use ($params) {
            $query->orderBy('id', 'ASC');
            if (isset($params['codes']) && $params['codes'] != '') {
                $query->whereIn('code', $params['codes']);
            }
        });

        if (!empty($list)) {
            $list->each(function ($item) {
                $item->value = htmlspecialchars_decode($item->value);
            });
            $list = $list->toArray();
            $list = array_combine( array_column($list, 'code'), array_column($list, 'value'));
        }

        return $list;
    }

    public function updateBase($params)
    {
        try {
            Db::beginTransaction();

            $this->configModel->update([
                'base_setting_name' => '',
                'base_setting_keyword' => '',
                'base_setting_description' => '',
                'about_us' => '',
            ]);

            foreach ($params as $key => $val) {
                $this->configModel->where('code', $key)->update([
                    'value' => htmlspecialchars($val['value'], ENT_QUOTES),
                    'unit' => !empty($val['unit']) ? htmlspecialchars($val['unit'], ENT_QUOTES) : '',
                ]);
            }

            Db::commit();
        } catch (\Exception $e) {
            Db::rollBack();
            throw new \Exception($e->getMessage());
        }
        return true;
    }
}