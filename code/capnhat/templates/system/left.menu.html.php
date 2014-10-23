

<div class="leftmenu bogoc">
	<div style="text-align:center; width:98%; line-height:25px; font-size:14px; color:#222; padding-top:5px; border-bottom:1px solid #c9ced3; margin-bottom:8px; font-weight:bold;">Thống kê hồ sơ</div>
	<ul>
			<li><a href="?gnc=com:jobs;target:list;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Theo trạng thái  <span style="color:#fb8034;">[<?=$tongcong;?>]</span></a> 
				<ul>
					<? for($k=0;$k<$sumtt;$k++){?>
						<li>
							<a href="?gnc=com:jobs;target:list;status:<?=$ddtrangthai[$k]['status'];?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<?=$trangthai[$ddtrangthai[$k]['status']];?> <span style="color:#fb8034;">[<?=$ddtrangthai[$k]['sum'];?>]</span>
							</a>
						</li>
					<? }?>
				</ul>
			</li>
			
			<li><a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Theo vị trí tuyển <span style="color:#fb8034;">[<?=$tongcong;?>]</span></a>
				<ul>
					<? for($m=0;$m<$sumpost;$m++){?>
						<li style="width:auto; line-height:18px; text-align:justify;">
							<a href="?gnc=com:jobs;target:list;jobpos:<?=$listpost[$m]['jobpos'];?>" style="width:auto; padding:3px 10px 3px 10px;"><?=$m+1;?>- <?=$listpost[$m]['vitri'];?><span style="color:#fb8034;"> [<?=$listpost[$m]['sum'];?>]</span>
							</a>
						</li>
					<? }?>
				</ul>
			</li>
	</ul>
</div>