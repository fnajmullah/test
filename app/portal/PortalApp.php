<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2018 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------

namespace app\portal;
use think\facade\Db;

class PortalApp
{

    // 应用安装
    public function install()
    {
        $dbConfig = config('database.connections.mysql');
        $dbSql = cmf_split_sql(APP_PATH.'portal/data/portal.sql', $dbConfig['prefix'], $dbConfig['charset']);
        if (empty($dbConfig) || empty($dbSql)) {
            return false;
        }
        $this->updateDbConfig($dbConfig);
        $db = Db::connect('install_db');
        foreach ($dbSql as $key => $sql) {
            try {
                $db->execute($sql);
            } catch (\Exception $e) {
                return false;
            }
        }
        return true; //安装成功返回true，失败false
    }

    // 应用卸载
    public function uninstall()
    {
        return true; //卸载成功返回true，失败false
    }
    private function updateDbConfig($dbConfig)
    {
        $oldDbConfig                              = config('database');
        $oldDbConfig['connections']['install_db'] = $dbConfig;
        config($oldDbConfig, 'database');
    }
}
