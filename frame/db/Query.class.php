<?php

/**
 * Query
 * 
 * 数据库查询的类,构造sql语句可以通过连贯方法操作
 * 
 * eg:
 * 
 * $Query = Query::init()->select("name")
 *              ->from("user")
 *              ->leftJoin("user_goods","uid=ug_id")
 *              ->andWhere("uid=?",1)
 *              ->andWhere("uid=? and uname=?",[1,"uid"])
 *              ->like("uname","ab")
 *              ->orlikes(["uid"=>1,"uname"=>"ab"])
 *              ->limit(1)
 *              ->offset(1);
 * 
 * $record = $Query->one();
 * $records = $Query->all();
 * $count = $Query->count();
 * 
 * $users = Query->init()->select("*")->from("user")->all();
 * 
 */
class Query extends QueryBase{

	/**
	 * Query::init()
	 * 实例化Query 
	 * @return Query
	 */
	public static function init(){
		return new self;
	}
	
	/**
	 * Query::one()
	 * 查询一条数据
	 * @return miexed false | [一条记录]
	 */
	public function one(){
		$db = DB::init();
        $this->limit(1);
		$sql = $this->getSql();
		$params = $this->getParams();
		return $db->exec($sql,$params,102);
	}
	
	/**
	 * Query::all()
	 * 查询多条数据
	 * @return array [[数据]]
	 */
	public function all(){
		$db = DB::init();
		$sql = $this->getSql();
		$params = $this->getParams();
		return $db->exec($sql,$params,103);
	}
	
	/**
	 * Query::count()
	 * 返回查询数量
	 * @return int 数量
	 */
	public function count(){
		$db = DB::init();
		$sql = $this->getCountSql();
		$params = $this->getParams();
		return $db->exec($sql,$params,101);
	}
	
    /**
	 * Query::column()
	 * 返回字段值
	 * @return  
	 */
	public function column(){
		$db = DB::init();
		$this->limit(1);
        $sql = $this->getSql();
		$params = $this->getParams();
		return $db->exec($sql,$params,101);
	}
}

class QueryBase{
	
	protected $tableName = '';
	
	protected $column = '*';
	
	protected $countColumn = '*';
	
	protected $from = '';
	
	protected $joins = [];

	protected $conditions = [];
	
	protected $params = [];
	
	protected $group = '';
	
	protected $order = '';
	
	protected $limit = 100;
	
	protected $offset = 0;
	
	public function __construct(){
		
	}
	
	/**
	 * QueryBase::select()
	 * 
	 * @param string $column
	 * @return Object Query
	 */
	public function select($column='*'){
		$this->column = $column;
		return $this;
	}
	
	/**
	 * QueryBase::selectCount()
	 * 
	 * @param string $column 查询字段
	 * @return Object Query
	 */
	public function selectCount($column="*"){
		$this->countColumn = $column;
		return $this;
	}
	
	/**
	 * QueryBase::from()
	 * 
	 * @param string $tableName  表名
	 * @return Object Query
	 */
	public function from($tableName){
		$this->tableName = $tableName;
		return $this;
	}
	
	/**
	 * QueryBase::join()
	 * 
	 * @param mixed $str left join on aid=bid | inner join on aid=bid | right join on aid=bid
	 * @return Object Query
	 */
	public function join($str){
		$this->joins[]=$str;
		return $this;
	}
	
	/**
	 * QueryBase::leftJoin()
	 * 
	 * @param mixed $tableName  表名
	 * @param string $str aid=bid
	 * @return Object Query
	 */
	public function leftJoin($tableName,$str = ''){
		$this->joins[] = 'left join ' . $tableName . ' on ' . $str;
		return $this;
	}
	
	/**
	 * QueryBase::innerJoin()
	 * 
	 * @param mixed $tableName 表名
	 * @param string $str 字符串 aid=bid
	 * @return Object Query
	 */
	public function innerJoin($tableName,$str = ''){
		$this->joins[] = 'inner join ' . $tableName . ' on ' . $str;
		return $this;
	}
	
	/**
	 * QueryBase::rightJoin()
	 * 
	 * @param mixed $tableName 表名
	 * @param string $str aid=bid
	 * @return Object Query
	 */
	public function rightJoin($tableName,$str = ''){
		$this->joins[] = 'right join ' . $tableName . ' on ' . $str;
		return $this;
	}
	
	/**
	 * QueryBase::groupby()
	 * 
	 * @param mixed $column 字段
	 * @return Object Query
	 */
	public function groupby($column){
		$this->group = "group by " . $column;
		return $this;
	}
	
	/**
	 * QueryBase::group()
	 * 
	 * @param mixed $str group by time 
	 * @return Object Query
	 */
	public function group($str){
		$this->group = $str;
		return $this;
	}
	
	/**
	 * QueryBase::orderby()
	 * 
	 * @param mixed $str time desc
	 * @return Object Query
	 */
	public function orderby($str){
		$this->order = "order by " . $str;
		return $this;
	}
	
	/**
	 * QueryBase::order()
	 * 
	 * @param mixed $str order by time desc
	 * @return Object Query
	 */
	public function order($str){
		$this->order = $str;
		return $this;
	}
	
	/**
	 * QueryBase::limit()
	 * 
	 * @param mixed $count 查询多少条数据
	 * @return Object Query
	 */
	public function limit($count){
		$this->limit = (int)$count;
		return $this;
	}
	
	/**
	 * QueryBase::offset()
	 * 
	 * @param mixed $count 从第几条开始查询
	 * @return Object Query
	 */
	public function offset($count){
		$this->offset = (int)$count;
		return $this;
	}
	
	/**
	 * QueryBase::andWhere()
	 * 增加一个条件
	 * @param mixed $str 条件 aid=? | aid=? or bid=? | aid=? and bid=?
	 * @param mixed $params 参数 1 | "ab" | [1,2]
	 * @return Object Query
	 */
	public function andWhere($str,$params=[]){
		$this->conditions[] = $str;
		if( is_array($params) ){
			foreach($params as $param){
				$this->params[] = $param;
			}
		}else{
			$this->params[] = $params;
		}
		return $this;
	}
	
	/**
	 * QueryBase::like()
	 * 增加一个like的条件
	 * @param string $column  字段名称
	 * @param string $param 搜索内容
	 * @return Object Query
	 */
	public function like($column,$param){
		$this->conditions[] = $column . ' like concat("%",?,"%")';
		$this->params[] = $param;
		return $this;
	}
	
	/**
	 * QueryBase::orLikes()
	 * 增加一个like 或者 多个like条件并且用or连接
	 * @param array $conditions 条件数组 ['uname'=>'ab'] | ['uname'=>'ab','desc'=>'dd']
	 * @return Object Query
	 */
	public function orLikes($conditions){
		$likeConditions = [];
		foreach($conditions as $key=>$value){
			$likeConditions[] = $key . ' like concat("%",?,"%")';
			$this->params[] = $value;
		}
		$this->conditions[] = '( ' . implode(' or ',$likeConditions) . ' )';
		return $this;
	}
	
	/**
	 * QueryBase::getSql()
	 * 获取sql语句
	 * @return Object Query
	 */
	public function getSql(){
		$sql = 'select ' . $this->column . ' from ' . $this->tableName . PHP_EOL;
		if( $this->joins ){
			$sql .= implode(PHP_EOL,$this->joins) . PHP_EOL;
		}
		if( $this->conditions ){
			$sql .= 'where ' . implode(PHP_EOL . 'and ',$this->conditions) . PHP_EOL;
		}
		if( $this->order ){
			$sql .= $this->order . PHP_EOL;
		}
		if( $this->group ){
			$sql .= $this->group . PHP_EOL;
		}
		if( $this->offset ){
		
		}
		$sql .= sprintf("limit %d,%d",$this->offset,$this->limit);
		return $sql;
	}
	
	/**
	 * QueryBase::getCountSql()
	 * 获取查询数量的sql语句
	 * @return Object Query
	 */
	public function getCountSql(){
		$sql = 'select count(' . $this->countColumn . ') from ' . $this->tableName . PHP_EOL;
		if( $this->joins ){
			$sql .= implode(PHP_EOL,$this->joins) . PHP_EOL;
		}
		if( $this->conditions ){
			$sql .= 'where ' . implode(PHP_EOL . 'and ',$this->conditions) . PHP_EOL;
		}
		if( $this->order ){
			$sql .= $this->order . PHP_EOL;
		}
		if( $this->group ){
			$sql .= $this->group . PHP_EOL;
		}
		return $sql;
	}
	
	/**
	 * QueryBase::getParams()
	 * 获取参数
	 * @return Object Query
	 */
	public function getParams(){
		return $this->params;
	}
	
}