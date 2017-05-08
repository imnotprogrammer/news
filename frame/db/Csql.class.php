<?php
/**
 * 此类用于有列表、搜索、排序、分页的sql语句的生成,生成的sql语句，请用pdo预执行
 * @abstract    Csql
 * 
 */
class Csql{
    public $sql;
    public $column;
    public $condition = array();
    public $order;
    public $limit;
    public $countColumn;
    public $params =array();
    /**
     * Csql::__construct()
     * 
     * @param string $sql            sql语句,例如:select %s from user left join user_concact on uid= uc_uid
     * @param string $column         查询出的字段，默认值*
     * @param mixed $condition       条件，例子：array("create_time>'2015-06-03'")
     * @param string $order          排序，例子 order by create_time desc
     * @param string $limit          限制，例子 limit 0,20
     * @return
     */
    public function __construct($sql,$column="*",$countColumn="",$condition=array(),$order="",$limit=""){
        $this->sql = $sql;
        $this->column = $column;
        $this->countColumn = $countColumn;
        $this->condition = $condition;
        $this->order = $order;
        $this->limit = $limit;
    }
    /**
     * 添加条件
     * Csql::ac()
     * 
     * @param string $condition  条件：例如 uid=?或者uid=? or uitype=?
     * @param mixed $value      值：例如 1 或者 array(1,'guanliyuan')
     * @param integer $no       1代表的是增加uid=?这种，0代表增加的uid=1
     * @return
     */
    public function ac($condition,$value='',$no=1){
        $this->condition[] = $condition . PHP_EOL;
        if( $no == 1 ){
            if( !empty($value) || $value === 0 || $value === "0" ){
                if( is_array($value) ){
                    $this->params = array_merge($this->params,$value);
                }else{
                    $this->params[] = $value;
                }
            }
        }
    }
    /**
     * Csql::ao()  添加order
     * 
     * @param string $order  例子：order by creat_time desc
     * @return
     */
    public function ao($order){
        $this->order = $order;
    }
    /**
     * Csql::al()   添加limit
     * 
     * @param string $limit  例子： limit 0,20
     * @return
     */
    public function al($limit){
        $this->limit = $limit;
    }
    /**
     * Csql::psql() 生成查询列表sql语句
     * 
     * @return string 
     */
    public function psql(){
        $sql = sprintf($this->sql,$this->column);
        if( !empty($this->condition) ){
            $sql = sprintf('%s where %s %s %s',$sql,implode(' and ',$this->condition),$this->order . PHP_EOL,$this->limit);
        }else{
            $sql = sprintf('%s %s %s',$sql,$this->order . PHP_EOL,$this->limit);
        }
        return $sql;
    }
    /**
     * 生成查询数量的sql语句
     * Csql::csql()
     * 
     * @return
     */
    public function csql(){
        if( preg_match('/^select distinct/',$this->sql) ){
            
            $countSql = preg_replace('/^select distinct/','select',$this->sql);
            
            if( $this->countColumn ){
                
                $sql = sprintf($countSql,'count(distinct ' . $this->countColumn . ') as amount');
                
            }else{
                
                $sql = sprintf($countSql,'count(distinct ' . $this->column . ') as amount');
                
            }
            
        }else{
            $sql = sprintf($this->sql,'count(*) as amount');
        }
        
        if( !empty($this->condition) ){
            $sql = sprintf('%s where %s',$sql,implode(' and ',$this->condition));
        }else{
            $sql = sprintf('%s',$sql);
        }
        return $sql;
    }
    /**
     * 获取参数
     * Csql::getParams()
     * 
     * @return array()
     */
    public function getParams(){
        return $this->params;
    }
    /**
     * 获取sql以及参数
     * Csql::listSql()
     * 
     * @return array(列表sql语句,数量sql语句,参数)
     */
    public function listSql(){
        return array($this->psql(),$this->csql(),$this->getParams());
    }
    /**
     * 获取列表数据
     * Csql::getList()
     * 
     * @param class $db
     * @return array(二维数组数据,数量)
     */
    public function getList($db){
        $record = array();
        $record[] = $db->exec($this->psql(),$this->params,103);
        $record[] = $db->exec($this->csql(),$this->params,101);
        return $record;
    }
    /**
     * 获取数据
     * Csql::get()
     * 
     * @param class $db
     * @return array()  二维数组数据
     */
    public function get($db){
        return $db->exec($this->psql(),$this->params,103);
    }
    /**
     * 获取数量
     * Csql::getCount()
     * 
     * @param mixed $db
     * @return int
     */
    public function getCount($db){
        return $db->exec($this->csql(),$this->params,101);
    }
}
/**
 * @example
    $Csql = new Csql('select %s from user left join user_concat on user.uid=user_concat.uc_uid','*');
    $Csql->ac('ui_father_ukey=?','ddddddddddd');
    $Csql->ac('ui_status=0','',0);
    $Csql->ao('order by ui_create_time desc');
    $Csql->al( sprintf('limit %d,20',0) );
    $sql = $Csql->psql();
    $countsql = $Csql->csql();
    echo $sql . PHP_EOL;
    echo $countsql;
    var_dump($Csql->params);
*/