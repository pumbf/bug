<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<style >
	body{text-align: center;
		background: url("/kaohe/Public/bai1.jpg");
	}                               
</style>
<body>                                   
<meta charset="utf-8"/>                                        
<table border="1" cellpadding="15" cellspacing="2">
<caption><?php echo ($data["studentid"]); ?>同学的课表</caption>
<tr>
	<th></th>
	<th>一</th>
	<th>二</th>
	<th>三</th>
	<th>四</th>
	<th>五</th>
	<th>六</th>
	<th>七</th>
</tr>
<div style="float:right">                                           
	<form method='post' action="<?php echo U('Home/Index/index');?>">
	学号:
	<input type="text" name="id"></br>
	<input type="submit" value="查询" />
	</form>
</div>
<?php $__FOR_START_2192__=1;$__FOR_END_2192__=7;for($i=$__FOR_START_2192__;$i < $__FOR_END_2192__;$i+=1){ ?><tr>
	<th><?php echo ($i*2-1); ?></th>
	<?php $__FOR_START_13705__=1;$__FOR_END_13705__=8;for($a=$__FOR_START_13705__;$a < $__FOR_END_13705__;$a+=1){ if(empty($data[7*$i+$a])): ?><td rowspan="2" ></td>
	<?php else: ?>
	<td rowspan="2">
	<?php if(is_array($data[7*$i+$a])): foreach($data[7*$i+$a] as $key=>$value): ?><div title="课程详细信息&#10;名称 <?php echo ($value['lessonname']); ?>&#10;老师 <?php echo ($value['teacher']); ?>&#10;教室 <?php echo ($value['classroom']); ?>&#10;类型 <?php echo ($value['method']); ?>&#10;周数 <?php echo ($value['weeks']); ?>&#10;<?php echo ($value['special']); ?>"><?php echo ($value['lessonname']); ?></br>（上）</br>@教室 <?php echo ($value['classroom']); ?></div><?php endforeach; endif; ?>
	</td><?php endif; } ?>
</tr>
<tr>
	<th><?php echo ($i*2); ?></th>
</tr><?php } ?>

</table>
</body>
</html>