<?php
/**
* DB接続クラス
* mysqliのラッピング
*/

namespace Fc2blog\Model;

class PDOWrap implements DBInterface
{

  // DB情報
  private $host = null;
  private $user = null;
  private $password = null;
  private $database = null;
  private $charset  = null;

  // DBオブジェクト
  private $db = null;

  function __construct($host, $user, $password, $database, $charset)
  {
    $this->host = $host;
    $this->user = $user;
    $this->password = $password;
    $this->database = $database;
    $this->charset  = $charset;
  }

  /**
   * 参照系SQL
   * @param $sql
   * @param array $params
   * @param array $options
   * @return mixed
   */
  public function find(string $sql, array $params=[], array $options=[])
  {
    $_options = array(
      'types'  => '',                  // paramsの型設定(sdi)
      'result' => \Fc2blog\Model\DBInterface::RESULT_ALL,    // 戻り値 one/row/all/statment...
    );
    $options = array_merge($_options, $options);
    try{
      $stmt = $this->query($sql, $params, $options['types']);
    }catch(\Exception $e){
      if (\Fc2blog\Config::get('DEBUG', 0)) {
        \Fc2blog\Debug::log($e->getMessage(), $params, 'error', __FILE__, __LINE__);
      }
      return false;
    }
    return $this->result($stmt, $options['result']);
  }


  /**
   * 更新系SQL
   * @param string $sql
   * @param array $params
   * @param array $options
   * @return array|false|int
   */
  public function execute(string $sql, array $params=[], array $options=[])
  {
    $_options = array(
      'types' => '',                      // paramsの型設定(sdi)
      'result' => \Fc2blog\Model\DBInterface::RESULT_SUCCESS,    // 戻り値 one/row/all/statment...
    );
    $options = array_merge($_options, $options);
    try{
      $stmt = $this->query($sql, $params, $options['types']);
    }catch(\Exception $e){
      if (\Fc2blog\Config::get('DEBUG', 0)) {
        \Fc2blog\Debug::log($e->getMessage(), $params, 'error', __FILE__, __LINE__);
      }
      return false;
    }
    return $this->result($stmt, $options['result']);
  }

  /**
  * 複数の更新系SQL
  */
  public function multiExecute($sql)
  {
    $sql = preg_replace('/^--.*?\n/m', '', $sql);
    $sql = preg_replace('/\/\*.*?\*\//s', '', $sql);
    $sqls = explode(';', $sql);
    $execute_sqls = array();
    foreach ($sqls as $sql) {
      if (trim($sql)!=='') {
        $execute_sqls[] = $sql;
      }
    }
    $ret = true;
    foreach ($execute_sqls as $sql) {
      $ret = $ret && $this->execute($sql);
    }
    return $ret;
  }

  /**
   * SQLの実行
   * @param $sql
   * @param array $params
   * @param string $types
   * @return PDOStatement|mixed 成功時PDOStatement
   * @throws \Exception
   */
  private function query($sql, $params=array(), $types='')
  {
    $mtime = 0;    // SQL実行結果時間取得用
    if (\Fc2blog\Config::get('DEBUG', 0)) {
      $mtime = microtime(true);
    }

    $this->connect();

    if (!count($params)) {
      // SQL文をそのまま実行
      $stmt = $this->db->query($sql);
      if (getType($stmt) == 'boolean' && !$stmt) {
        throw new \Exception('[query Error]' . $sql);
      }
      if (\Fc2blog\Config::get('DEBUG', 0)) {
        $mtime = sprintf('%f', microtime(true) - $mtime);
        \Fc2blog\Debug::log('実行時間：' . $mtime . '<br />' . $sql, $params, 'sql', __FILE__, __LINE__);
      }
      return $stmt;
    }

    // プリペアドステートメント
    $stmt = $this->db->prepare($sql);
    if (!$stmt) {
      throw new \Exception('[prepare Error]' . $sql);
    }
    $stmt->execute($params);
    if (\Fc2blog\Config::get('DEBUG', 0)) {
      $mtime = sprintf('%f', microtime(true) - $mtime);
      \Fc2blog\Debug::log('実行時間：' . $mtime . '<br />' . $sql, $params, 'sql', __FILE__, __LINE__);
    }
    return $stmt;
  }

  public function connect($is_charset=true, $is_database=true)
  {
    if ($this->db == null) {
      $dsn = "mysql:host={$this->host};";
      if ($is_database) {
        $dsn = "mysql:host={$this->host};dbname={$this->database};";
      }
      $options = array(
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES   => false,
      );
      if ($is_charset) {
        if (version_compare(PHP_VERSION, '5.3.6') < 0) {
          $options[\PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES '" .$this->charset. "';";
        } else {
          $dsn .= "charset={$this->charset};";
        }
      }
      $this->db = new \PDO($dsn, $this->user, $this->password, $options);
    }
  }

  public function close()
  {
    if ($this->db != null) {
      $this->db = null;
    }
  }

  /**
   * @param $stmt
   * @param $type
   * @return array|int $typeによって様々な意味の返り値となる
   */
  public function result($stmt, $type)
  {
    if ($stmt===false) {
      return array();
    }

    switch($type){
      // １カラムのみ取得
      case \Fc2blog\Model\DBInterface::RESULT_ONE :
        return $stmt->fetchColumn();

      // １行のみ取得
      case \Fc2blog\Model\DBInterface::RESULT_ROW :
        return $stmt->fetch();

      // リスト形式で取得
      case \Fc2blog\Model\DBInterface::RESULT_LIST :
        $rows = array();
        $stmt->setFetchMode(\PDO::FETCH_NUM);
        foreach ($stmt as $value) {
          $rows[$value[0]] = $value[1];
        }
        return $rows;

      // 全て取得
      case \Fc2blog\Model\DBInterface::RESULT_ALL :
        return $stmt->fetchAll();

      // InsertIDを返却
      case \Fc2blog\Model\DBInterface::RESULT_INSERT_ID :
        return $this->db->lastInsertId();

      // 影響のあった行数を返却
      case \Fc2blog\Model\DBInterface::RESULT_AFFECTED :
        return $stmt->rowCount();

      // 成功したかどうかを返却
      case \Fc2blog\Model\DBInterface::RESULT_SUCCESS :
        return 1;

      case \Fc2blog\Model\DBInterface::RESULT_STAT: default:
        return $stmt;
    }
  }

  /**
  * MySQLのバージョンを取得する
  */
  public function getVersion()
  {
    $this->connect(false, false);
    $version = explode('-',$this->db->getAttribute(\PDO::ATTR_SERVER_VERSION));
    return $version[0];
  }

}

