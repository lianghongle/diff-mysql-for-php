<?php

$conf = require 'conf/config.php';

require 'lib/Db.php';

$db1 = new Db($conf['db1']);
$db2 = new Db($conf['db2']);

$tables1 = $db1->getTables();
//$tables1 = [
//    'table_0',
//    'table_1',
//];
$tables2 = $db2->getTables();
//$tables2 = [
//    'table_0',
//    'table_2',
//];

$tables_same_name = array_intersect($tables1, $tables2);
$tables_same_name_diff_columns = [];

$tableColumns1 = [];//1有2没有的字段
$tableColumns2 = [];//2有1没有的字段
//$tableColumnsSame = [];
if(!empty($tables_same_name)){
    foreach ($tables_same_name as $key=>$tableName){
        $_tableColumns1 = $db1->getTableColumns($tableName);
        $_tableColumns2 = $db2->getTableColumns($tableName);

        foreach ($_tableColumns1 as $key=>$val){
            if(!array_key_exists($key, $_tableColumns2)){
                $tableColumns1[$tableName][] = $key;
            }
        }

        foreach ($_tableColumns2 as $key=>$val){
            if(!array_key_exists($key, $_tableColumns1)){
                $tableColumns2[$tableName][] = $key;
            }
        }
    }
}

unset($db1);
unset($db2);

?>

<link type="text/css" rel="styleSheet"  href="./css/common.css" />

<div class="container">

    <!--表不同-->
    <div class="div-diff-tables">

        <div class="diff-tables diff-tables-left">
            <?php echo $conf['db1']['database'];?>
            <div class="diff-tables-data">
                <ul>
                    <?php foreach ($tables1 as $key=>$val) { ?>
                        <?php if(!in_array($val, $tables2)){?>
                            <li><?php echo $val; ?></li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>
        </div>

        <div class="diff-tables diff-tables-right">
            <?php echo $conf['db2']['database'];?>
            <div class="diff-tables-data">
                <ul>
                    <?php foreach ($tables2 as $key=>$val) { ?>
                        <?php if(!in_array($val, $tables1)){?>
                            <li><?php echo $val; ?></li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>

    <!--表字段不同-->
    <div class="div-diff-tables-structure">
        <div class="diff-tables diff-tables-left">
            <?php foreach ($tableColumns1 as $table=>$val) { ?>
                <?php echo $table; ?>
                <ul>
                    <?php foreach ($val as $column=>$v) { ?>
                        <li><?php echo $v; ?></li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>

        <div class="diff-tables diff-tables-left">
            <?php foreach ($tableColumns2 as $table=>$val) { ?>
                <?php echo $table; ?>
                <ul>
                    <?php foreach ($val as $column=>$v) { ?>
                        <li><?php echo $v; ?></li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
    </div>

</div>

<script src="./js/common.js" />
<script>
    window.onload = function(){
        alert('sss')
    }
</script>

