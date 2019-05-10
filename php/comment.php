<?php 

/**
	这个文件是Portal模块的一个页面，如果不需要Portal，则可以一并删除
	@param
	@return
*/

define('KC_INDEX',True);

require_once 'global.php';


/*
	评论页
*/
function king_def(){
	global $king;

	$kid=kc_get('kid',2,1);
	$listid=kc_get('listid',2,1);
	$modelid=kc_get('modelid',2,1);
	$pid=isset($_GET['pid']) ? kc_get('pid',2,1) :1;
	$rn=isset($_GET['rn']) ? kc_get('rn',2,1) :10;
	$skip=($pid==1) ? 0 : ($pid-1)*$rn;

	if($rn>100) $rn=100;

	$king->Load('portal');
	$model=$king->portal->infoModel($modelid);
	$id=$king->portal->infoID($listid,$kid);
	$tmp=new KC_Template_class($model['ktemplatecomment'],$king->config('templatepath').'/inside/comment/'.strtolower($model['modeltable']).'.htm');
	$count=$king->db->getRows_number('%s_comment','kid='.$kid);
	
	foreach ($id as $key =>$val) {
		$tmp->assign($key,$val);
	}
	$tmp->assign('title',$id['ktitle'].' '.$king->lang->get('portal/common/comment'));
	
	$tmp->assign('pid',$pid);
	$tmp->assign('rn',$rn);

	$tmp->assign('skip',$skip);
	$tmp->assign('modelid',$modelid);//传递模型id
	$tmp->assign('listid',$listid);//传递列表id
	$tmp->assign('count',$count);//总计
	$tmp->assign('kid',$kid);//传递文章id
	$tmp->assign('kid1',empty($id['kid1'])?0:$id['kid1']);
	$tmp->assign('type','comment');
	$tmp->assign('comment',$id['ncomment']);//评论统计
	echo $tmp->output();
}
?> 