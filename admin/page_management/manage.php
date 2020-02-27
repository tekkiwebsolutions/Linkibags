<?php
$breadcrumb = 'Page Management';
$title = '<i class="fa fa-table"></i> Manage Pages';

$rows = $co->fetch_all_array("SELECT * FROM `pages`", array());
?>
<!-- BEGIN PAGE CONTENT-->
<table class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th></th>
			<th class="hidden-480">Title</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php
		$i=1;
		foreach($rows as $row){
		?>
		<tr class="odd gradeX">
			<td><?=$i?></td>
			<td class="hidden-480"><?=$row['title']?></td>
			<td>
				<a class="btn mini purple" href="main.php?p=page_management/edit&id=<?=$row['page_id']?>"><i class="icon-edit"></i> Edit</a>				
			</td>
		</tr>
		<?php $i++; } ?>
	</tbody>
</table>