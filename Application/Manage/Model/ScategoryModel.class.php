<?php
namespace Manage\Model;
use Think\Model\RelationModel;
class ScategoryModel extends RelationModel{
	protected $_link = array(

	);
    protected $_validate = array(
        array('scategory_name','require','故事分类名称不能为空'),
        array('scategory_type','require','类型不能为空'),
    );



}