<?php
namespace Manage\Model;
use Think\Model\RelationModel;
class McategoryModel extends RelationModel{
	protected $_link = array(

	);
    protected $_validate = array(
        array('mcategory_name','require','分类不能为空'),
    );



}