<?php
# Gọi các hàm load mặc định
config();
$grp = sql_list ("SELECT grp.id, detail.title, grp.lastdate FROM ".$config['db_prefix']."_news_groups grp RIGHT JOIN ".$config['db_prefix']."_news_groups_detail detail ON grp.id = detail.groupid WHERE detail.language = '".$config['default_language']."' ORDER BY grp.oderid ASC");
$config['query'] = array();

?>