<?php global $id, $config; ?>

<div class="fullwith">

	<div class="fullwith toptick">
		<div class="contarea">
			<span style="font-size:11px; color:#777;"><?=$langtext['main']['title'];?></span>
			<div class="manager">
				<? if($_SESSION['auth']['login'] == true){?>
					Chào <b><?=$_SESSION['auth']['name'];?></b> [<a href="?gnc=com:system;target:signout">Thoát</a>]
				<? }?>
			</div>
		</div>
	</div>
	
	<div class="fullwith logodiv">
		<div class="contarea">
			<img src="images/logo.png" alt="logo" height="50" style="margin-top:5px; float:right;" />
		</div>
	</div>
	<div class="fullwith menumain">
		<div class="contarea">
			<?=sys_option('system','main','menu');?>
		</div>
	</div>
	
    <? if($config['showmenu']=='1'){?>
	<div class="fullwith contents" style="height:35px; margin-bottom:10px;">
    	<div class="contarea " style="background:#3c73a9; height:35px;">
    		<div id="smoothmenu1" class="ddsmoothmenu">
            	<? categories_lilink ('?gnc=com:news;target:news_articles;groups:1;category:',1,0,$id['category']);?>
        	</div>
        </div>
    </div>
     <? }?>
     
	<div class="fullwith contents" style="min-height:450px;">
		<div class="contarea ">
			<? //sys_option('system','left','menu');?>
			
			<div class="rightcont bogoc">
				<?
					if (access() == 1) {
						if (is_file('sources/'.$id['com'].'/'.$id['target'].'.php')) {
							require 'sources/'.$id['com'].'/'.$id['target'].'.php';
						}
						
						if (is_file('templates/'.$id['com'].'/'.$id['target'].'.html.php')) {
							require 'templates/'.$id['com'].'/'.$id['target'].'.html.php';
						} else {
							require 'templates/error.html.php';
						}
					} else {
						require 'templates/nopermission.html.php';
					}
					
				?>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	
	<!--<div class="fullwith">
		<div class="contarea">
			<div class="linkcont bogoc">
				<? for($i=0;$i<4;$i++){?>
					<div class="linkbox">
						<p>HR Center</p>
						<ul>
							<li> <a href="#">Quản lý tuyển dụng</a></li>
							<li> <a href="#">Quản lý hồ sơ</a></li>
							<li class="end"> <a href="#">Quản lý nhân sự</a></li>
						</ul>
					</div>
				<? }?>
			</div>
		</div>
	</div>-->
	<div class="fullwith footer" style="margin-top:10px;">
		<div class="contarea">
			<br /><?=$langtext['sys_basic']['version'];?> - &copy; 2012 by <a href="<?=$config['url'];?>" target="_blank"><strong><?=$config['varurl'];?></strong></a>.<br /><br />
		</div>
	</div>
</div>