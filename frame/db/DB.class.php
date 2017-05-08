<?php
/*
	数据库操作类
*/
class Db_Action{
    
	private $dbname;
	private $host;
	private $dbuser;
	private $dbpass;
	private $dbport;
	private $dsn;
	public $connobj;
	private $defcharset;
	private $debugstatus;
    private $errCode;
    private $sth;
	/*
		构造函数
	*/
	function __construct($dbname,$host,$dbuser,$dbpass,$debugstatus=0,$dbport=3306,$defcharset='utf8'){
		$this->dbname=$dbname;
		$this->host=$host;
		$this->dbuser=$dbuser;
		$this->dbpass=$dbpass;
		$this->dbport=$dbport;
		$this->defcharset=$defcharset;
		$this->debugstatus=$debugstatus;
		$this->dsn='mysql:dbname='.$dbname.';host='.$host.';port='.$dbport;
        
        $this->ConnDb();
	}
    
    public function query($sql,$type=100,$fetch= PDO::FETCH_ASSOC){
        
        $sth = $this->connobj->query($sql);
        $this->sth = $sth;
        if($sth->errorCode()=='00000'){
            if( $type == 100 ){
			     return true;
            }elseif( $type == 101 ){
                $res=$sth->fetch(PDO::FETCH_ASSOC);
				return $res['amount'];
            }elseif( $type == 102 ){
                return $sth->fetch($fetch);
            }elseif( $type == 103 ){
                return $sth->fetchAll($fetch);
            }else{
                return true;
            }
        }else{
            $this->errCode = $sth->errorCode();
            $this->ErrorStatus($sth,$sql);
        }
    }
	/*
		连接数据库
	*/
	public function ConnDb(){
		try{
			$this->connobj=new PDO($this->dsn,$this->dbuser,$this->dbpass,
				array(PDO::MYSQL_ATTR_INIT_COMMAND=>"set names ".$this->defcharset)
			);
            return true;
		} catch (PDOException $e){
            Debug::log( $e->getMessage() );
			return false;
		}
	}
    /*
    *执行sql语句
    */
    public function exec($sql,$params=array(),$type=100,$fetch = PDO::FETCH_ASSOC){
        $sth = $this->connobj->prepare($sql);
        $this->sth = $sth;
        $sth->execute($params);
        
		if($sth->errorCode()=='00000'){
            if( $type == 100 ){
			     return true;
            }elseif( $type == 101 ){
                $res=$sth->fetch(PDO::FETCH_NUM);
				return $res[0];
            }elseif( $type == 102 ){
                return $sth->fetch($fetch);
            }elseif( $type == 103 ){
                return $sth->fetchAll($fetch);
            }else{
                return true;
            }
		}else{
            $this->errCode = $sth->errorCode();
            
			$this->ErrorStatus($sth,$sql,$params);
		}
    }
    
    public function insert($tableName,$params){
        $columns = $values = $marks = [];
        foreach( $params as $key=>$param ){
            $columns[] = $key; 
            $marks[] = '?';
            $values[] = $param;
        }
        $sql = 'insert into %s(%s) values(%s)';
        $sql = sprintf($sql,$tableName,implode(',',$columns),implode(',',$marks));
        $sth = $this->connobj->prepare($sql);
        $this->sth = $sth;
        $sth->execute($values);
        if($sth->errorCode()=='00000'){
            return true;
        }else{
            $this->errCode = $sth->errorCode();
			$this->ErrorStatus($sth,$sql,$params);
        }
    }
    
    public function update($tableName,$params,$conditions){
        
        $sets = $cons  = $values = [];
        foreach( $params as $key=>$param ){ 
            $sets[] = $key . '=?' ;
            $values[] = $param;
        }
        foreach( $conditions as $key=>$condition ){
            $cons[] = $key . '=?' ;
            $values[] = $condition;
        }
        $sql = 'update %s set %s where %s';
        $sql = sprintf($sql,$tableName,implode(',',$sets),implode(' and ',$cons) );
        
        $sth = $this->connobj->prepare($sql);
        $this->sth = $sth;
        $sth->execute($values);
        
        if($sth->errorCode()=='00000'){
            return true;
        }else{
            $this->errCode = $sth->errorCode();
			$this->ErrorStatus($sth,$sql,$values);
            return false;
        }
        
    }
    
	/*
		生成预处理参数
	*/
	protected function GeneratePreParam($param){
		if(empty($param)){
			$predefine='';
		}else{
			$predefine=substr(str_repeat('?,',count($param)),0,-1);
		}
		return $predefine;
	}
	/*
		由错误日志标志来决定执行失败时的情况
	*/
	protected function ErrorStatus($cursth,$sql,$params=[]){
	   
       $msg = $cursth->errorInfo();
       
       $msgs = [
            'DB error: ' . json_encode($msg),
            'SQL statement: ' . $sql,
            'Params: ' . json_encode($params,JSON_UNESCAPED_UNICODE)
       ];
       
       Debug::trace(0,$msgs,1,5);
       
       if( $this->debugstatus ){
           echo "<pre>";
           echo implode("\n",$msgs);
           echo "</pre>";
       }
        
	   return false;
	}
    
    function beginTransaction(){
        $this->connobj->beginTransaction();
    }
    
    function commit(){
        return $this->connobj->commit();
    }
    
    function rollback(){
        $this->connobj->rollback();
    }
    
    function rowCount(){
        return $this->sth->rowCount();
    }
    
    function getErrorCode(){
        return $this->errCode;
    }
    
    function closeConn(){
        $this->connobj=null;
    }
	/*
		析构函数
	*/
	function __destruct(){
		$this->connobj=null;
	}
}


//针对具体的数据库实例,就是不同的数据库实例链接的时候相应的信息
class DB{
    
    public static $db;
    
    public static function init(){
        
        if( !self::$db ){
            self::$db = new Db_Action( DB_NAME,DB_HOST,DB_ROOT,DB_PWD,1,$dbport=3306,$defcharset='utf8' );
        }
        return self::$db;
    }
    
    
    
}