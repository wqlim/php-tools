<?php

namespace wqlim\tools\db;

class Table
{
    public static function index($dbserver,$database,$dbusername,$dbpassword)
    {
        //Set Server
        // $dbserver = "127.0.0.1";
        // $database = "test"; //数据库名
        // $dbusername = "root"; //帐号
        // $dbpassword = "4123456"; //密码

        $mysql_conn = @mysqli_connect("$dbserver", "$dbusername", "$dbpassword", "$database") or die("Mysql connect is error.");
        //$mysql_conn = new mysqli("$dbserver", "$dbusername", "$dbpassword", "$database");
        //mysqli_select_db($database, $mysql_conn);
        $dbVersion = mysqli_get_server_info($mysql_conn);
        if ($dbVersion >= "4.1") mysqli_query($mysql_conn, "SET NAMES 'utf8'");
        $query = mysqli_query($mysql_conn, "SHOW TABLES");
        while ($row = mysqli_fetch_array($query)) {
            $result[] = $row;
        }


        $tableCount = count($result);
        $menu = '';
        foreach ($result as $val) {
            $tables = $val['Tables_in_' . $database];
            $query = mysqli_query($mysql_conn, 'SHOW CREATE TABLE `' . $tables . '`');
            $row = mysqli_fetch_array($query);
            $comment = $row['Create Table'];

            //得到表的说明信息
            if (strstr($comment, "COMMENT='")) {
                $comment = ' (' . substr($comment, strrpos($comment, "COMMENT='") + 9, -1) . ')';
            } else {
                $comment = ' ()';
            }
            //跳转菜单
            $menu .= "<li><a href='#" . $tables . "' title='" . $comment . "'>" . $tables . "</a></li>";

            //表名称和注释
            $tab['table_name'] = $tables;
            $tab['table_comment'] = $comment;


            //表字段详情
            $query2 = mysqli_query($mysql_conn, 'SHOW FULL FIELDS FROM `' . $tables . '`');
            $rows = array();
            while ($row = mysqli_fetch_array($query2)) {
                $rows[] = $row;
            }
            foreach ($rows as $val) {
                if ($val['Extra'] == 'auto_increment') {
                    $val['Extra'] = 'auto';
                }
                if ($val['Default'] === null) {
                    $val['Default'] = 'NULL';
                } elseif ($val['Default'] === '') {
                    $val['Default'] = 'Empty';
                }
                $val['Default'] = ($val['Default'] === null) ? 'NULL' : $val['Default'];
                $result1[] = $val;
            }

            $tab['table_field'] = $result1;
            $tabs[] = $tab;
            unset($result1);
        }
        // include 'table.html';
        $html = require("table.html");
        return $html;
    }
}
