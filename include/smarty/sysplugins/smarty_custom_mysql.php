<?php

/**
 * MySQL Resource
 *
 * Resource Implementation based on the Custom API to use
 * MySQL as the storage resource for Smarty's templates and configs.
 *
 * Table definition:
 * <pre>CREATE TABLE IF NOT EXISTS `templates` (
 *   `name` varchar(100) NOT NULL,
 *   `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 *   `source` text,
 *   PRIMARY KEY (`name`)
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8;</pre>
 *
 * Demo data:
 * <pre>INSERT INTO `templates` (`name`, `modified`, `source`) VALUES ('test.tpl', "2010-12-25 22:00:00", '{$x="hello world"}{$x}');</pre>
 *
 * @package Resource-examples
 * @author Rodney Rehm
 */
class Smarty_Resource_Mysql extends Smarty_Resource_Custom {
    // prepared fetchTimestamp() statement
    protected $mtime;

    /**
     * Fetch a template and its modification time from database
     *
     * @param string $name template name
     * @param string $source template source
     * @param integer $mtime template modification timestamp (epoch)
     * @return void
     */
    protected function fetch($name, &$source, &$mtime){
		global $db, $_conf;
		$r = $db -> Execute("select * from ".$_conf['prefix']."template where tpl_name='".$name."'");
		$row = $r -> GetRowAssoc(false);
        if ($row) {
            $source = stripslashes($row['tpl_source']);
            $mtime = $row['tpl_time'];
        } else {
            $source = null;
            $mtime = null;
        }
    }
    
    /**
     * Fetch a template's modification time from database
     *
     * @note implementing this method is optional. Only implement it if modification times can be accessed faster than loading the comple template source.
     * @param string $name template name
     * @return integer timestamp (epoch) the template was modified
     */
    protected function fetchTimestamp($name) {
		global $db, $_conf;
		$r = $db -> Execute("select * from ".$_conf['prefix']."template where tpl_name='".$name."'");
		$row = $r -> GetRowAssoc(false);
        return $row['tpl_time'];
    }
}
?>