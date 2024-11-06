<?php

declare(strict_types=1);

namespace App\Application\Actions\Index;

use App\Application\Actions\Action;
use App\Model\Goods as GoodsModel;
use App\Model\GoodsType as GoodsTypeModel;
use Psr\Http\Message\ResponseInterface as Response;

class TypesAction extends Action
{
    protected string $title = 'Categories';
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $get = $this->request->getQueryParams();
        $typeId = intval($get['typeId']);
        $l = GoodsTypeModel::getListByWhere(1, 200, ['typeMainId' => $typeId]);
        $searchType = array(0 => $typeId);
        if ($l) {
            foreach ($l as $kl => $vl) {
                $searchType[] = $vl[GoodsTypeModel::TABLE_PY];
            }
        }
        $typeList = array();
        GoodsTypeModel::getList(1, 100, function ($value) use (&$typeList) {
            $typeList[$value[GoodsTypeModel::TABLE_PY]] = $value[GoodsTypeModel::TABLE_TYPENAME];
        });
        $list = GoodsModel::getListByWhere($this->page, 12, ['goods_eType' => 0,GoodsModel::TABLE_TYPE => array('IN' => $searchType)]);
        $count = GoodsModel::getCountByWhere(['goods_eType' => 0,GoodsModel::TABLE_TYPE => array('IN' => $searchType)]);
        foreach ($list as $k => $value) {
            $list[$k]['typeName'] = $typeList[$value[GoodsModel::TABLE_TYPE]];
            $list[$k]['goods_images'] = siteUrl('Upload') . $value['goods_images'];
            $list[$k]['goods_extraPrice'] = $value['goods_extraPrice'] < 1 ? 'no lend' : $value['goods_extraPrice'];
            $list[$k]['goods_eType'] = $list[$k]['goods_eType'] !== '1' ? null : 1;
        }
        return $this->view('TypeList.php', [
            'total' => $count,
            'typeName' => $list,
            'typeId' => $typeList[intval($get['typeId'])],
            'goodslist' => $list
        ]);
    }
}
