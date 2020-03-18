<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>อันดับการตาย</h2>
<h3>
	<?php echo number_format($limit=(int)Flux::config('DeathRankingLimit')) ?> อันดับการตายมากที่สุด
	<?php if (!is_null($jobClass)): ?>
	(<?php echo htmlspecialchars($className=$this->jobClassText($jobClass)) ?>)
	<?php endif ?>
	ในเซิร์ฟเวอร์ <?php echo htmlspecialchars($server->serverName) ?>
</h3>
<?php if ($chars): ?>
<form action="" method="get" class="search-form2">
	<?php echo $this->moduleActionFormInputs('ranking', 'death') ?>
	<p>
		<label for="jobclass">ค้นหาโดยอาชีพ:</label>
		<select name="jobclass" id="jobclass">
			<option value=""<?php if (is_null($jobClass)) echo 'selected="selected"' ?>>ทั้งหมด</option>
		<?php foreach ($classes as $jobClassIndex => $jobClassName): ?>
			<option value="<?php echo $jobClassIndex ?>"
				<?php if (!is_null($jobClass) && $jobClass == $jobClassIndex) echo ' selected="selected"' ?>>
				<?php echo htmlspecialchars($jobClassName) ?>
			</option>
		<?php endforeach ?>
		</select>
		
		<input type="submit" value="Filter" />
		<input type="button" value="Reset" onclick="reload()" />
	</p>
</form>
<table class="horizontal-table table table-striped ">
	<tr>
		<th>ลำดับ</th>
		<th>ชื่อตัวละคร</th>
		<th>ตาย</th>
		<th>อาชีพ</th>
		<th>เลเวล</th>
		<th>จ๊อบเลเวล</th>
		<th colspan="2">ชื่อกิลด์</th>
	</tr>
	<?php $topRankType = !is_null($jobClass) ? $className : 'character' ?>
	<?php for ($i = 0; $i < $limit; ++$i): ?>
	<tr<?php if (!isset($chars[$i])) echo ' class="empty-row"'; if ($i === 0) echo ' class="top-ranked info" title="<strong>'.htmlspecialchars($chars[$i]->char_name).'</strong> is the most killed '.$topRankType.'!"' ?>>
		<td align="right"><?php echo number_format($i + 1) ?></td>
		<?php if (isset($chars[$i])): ?>
		<td><strong>
			<?php if ($auth->actionAllowed('character', 'view') && $auth->allowedToViewCharacter): ?>
				<?php echo $this->linkToCharacter($chars[$i]->char_id, $chars[$i]->char_name) ?>
			<?php else: ?>
				<?php echo htmlspecialchars($chars[$i]->char_name) ?>
			<?php endif ?>
		</strong></td>
		<td><?php echo number_format((int)$chars[$i]->death_count) ?></td>
		<td><?php echo $this->jobClassText($chars[$i]->char_class) ?></td>
		<td><?php echo number_format($chars[$i]->base_level) ?></td>
		<td><?php echo number_format($chars[$i]->job_level) ?></td>
		<?php if ($chars[$i]->guild_name): ?>
		<?php if ($chars[$i]->guild_emblem_len): ?>
		<td width="24"><img src="<?php echo $this->emblem($chars[$i]->guild_id) ?>" /></td>
		<?php endif ?>
		<td<?php if (!$chars[$i]->guild_emblem_len) echo ' colspan="2"' ?>>
			<?php if ($auth->actionAllowed('guild', 'view') && $auth->allowedToViewGuild): ?>
				<?php echo $this->linkToGuild($chars[$i]->guild_id, $chars[$i]->guild_name) ?>
			<?php else: ?>
				<?php echo htmlspecialchars($chars[$i]->guild_name) ?>
			<?php endif ?>
		</td>
		<?php else: ?>
		<td colspan="2"><span class="not-applicable">None</span></td>
		<?php endif ?>
		<?php else: ?>
		<td colspan="8"></td>
		<?php endif ?>
	</tr>
	<?php endfor ?>
</table>
<?php else: ?>
<p>ไม่พบข้อมูลตัวละคร. <a href="javascript:history.go(-1)">ย้อนกลับ</a>.</p>
<?php endif ?>