<?php
global $global, $config;
if(!isset($global['systemRootPath'])){
    require_once '../videos/configuration.php';
}
require_once $global['systemRootPath'] . 'objects/bootGrid.php';
require_once $global['systemRootPath'] . 'objects/user.php';

class Channel{
    
    static function getChannels($activeOnly=true, $FIND_IN_SET = ""){        
        global $global;
        $sql = "SELECT u.*, "
                . " (SELECT count(v.id) FROM videos v where v.users_id = u.id) as total_videos "
                . " FROM users u "
                . " HAVING total_videos > 0 ";
        if($activeOnly){
            $sql .= " AND u.status = 'a' ";
        }
        $sql .= BootGrid::getSqlFromPost(array('user', 'about', 'channelName', 'u.name', 'u.email'), "", "", false, $FIND_IN_SET);
        
        $res = sqlDAL::readSql($sql); 
        $fullResult = sqlDAL::fetchAllAssoc($res);
        sqlDAL::close($res);
        $subscribe = array();
        if ($res!=false) {
            foreach ($fullResult as $row) {
                unset($row['password']);
                $subscribe[] = $row;
            }
        } else {
            $subscribe = false;
            die($sql . '\nError : (' . $global['mysqli']->errno . ') ' . $global['mysqli']->error);
        }
        return $subscribe;
    }
    
    // tempcode 16.subscriptions get my channels
    static function getMyChannels($user_id){        
        global $global;
        // return null;

        $sql = "SELECT uu.* FROM (SELECT users_id AS subscriber_users_id FROM subscribes WHERE subscriber_users_id = ".$user_id." AND status = 'a' ) ss
                LEFT JOIN (SELECT u.*, (SELECT COUNT(v.id) FROM videos v WHERE v.users_id = u.id) AS total_videos FROM users u HAVING total_videos > 0 AND u.status = 'a') uu
                ON uu.id = ss.subscriber_users_id"; 
                
        $res = sqlDAL::readSql($sql); 
        $fullResult = sqlDAL::fetchAllAssoc($res);
        sqlDAL::close($res);

        return $fullResult;

        // $subscribe = array();
        // if ($res!=false) {
        //     foreach ($fullResult as $row) {
        //         $subscribe[] = $row;
        //     }
        // } else {
        //     $subscribe = false;
        //     die($sql . '\nError : (' . $global['mysqli']->errno . ') ' . $global['mysqli']->error);
        // }
        // return $subscribe;
    }
    
    static function getTotalChannels($activeOnly=true){        
        global $global;
        $sql = "SELECT count(*) as total "
                . " FROM users u "
                . " WHERE (SELECT count(v.id) FROM videos v where v.users_id = u.id) > 0 ";
        if($activeOnly){
            $sql .= " AND u.status = 'a' ";
        }
        $sql .= BootGrid::getSqlFromPost(array('user', 'about'));
        
        $res = sqlDAL::readSql($sql);
        $data = sqlDAL::fetchAssoc($res);
        sqlDAL::close($res);
        if ($res) {
            $row = intval($data['total']);
        } else {
            $row = 0;
        }
        return $row;
    }
    
}

