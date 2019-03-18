<?php
namespace Manage\Model;
use Think\Model\RelationModel;
class SalbumModel extends RelationModel{
	protected $_link = array(

	);
    protected $_validate = array(
        array('salbum_title','require','专辑名称不能为空'),
    );



}