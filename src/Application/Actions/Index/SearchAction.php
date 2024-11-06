<?php

declare(strict_types=1);

namespace App\Application\Actions\Index;

use App\Application\Actions\Action;
use App\Model\Goods as GoodsModel;
use App\Model\GoodsType as GoodsTypeModel;
use Psr\Http\Message\ResponseInterface as Response;

class SearchAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $get = $this->request->getQueryParams();
        $keyword = htmlspecialchars(strip_tags($get['keyword']));
        $list = $typeList = [];
        $list = GoodsModel::getListByWhere($this->page, $this->pageNum, ['goods_eType' => 0,GoodsModel::TABLE_GOODS_NAME => array('LIKEMORE' => $keyword)]);
        GoodsTypeModel::getList(1, 30, function ($value) use (&$typeList) {
            $typeList[$value[GoodsTypeModel::TABLE_PY]] = $value[GoodsTypeModel::TABLE_TYPENAME];
        });
        foreach ($list as $k => $value) {
            $list[$k]['typeName'] = $typeList[$value[GoodsModel::TABLE_TYPE]];
            $list[$k]['goods_images'] = siteUrl('Upload') . $value['goods_images'];
            $list[$k]['goods_eType'] = $list[$k]['goods_eType'] !== '1' ? null : 1;
        }
        $this->title = 'Search For ' . $keyword;
        return $this->view('Search.php', [
            'goodslist' => $list,
            'keywords' => $keyword
        ]);
    }
}
