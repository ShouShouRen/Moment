<?php
class Connect extends PDO{
  public function __construct($user,$passwd){
      parent::__construct("mysql:host=localhost;dbname=Moment",$user,$passwd,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
      $this->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
      $this->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
  }
//   public function convert(object &$out,array $a){
// 	$out->$a["desk"]
//   }
}
$db = new Connect('derrick','Ed0911872587-');
$sql = 'SELECT `Guests`.`token`, `orders`.`desk`,`orders`.`product_name`,`orders`.`product_count`,`orders`.`totalPrice` FROM `Guests` NATURAL JOIN `orders` WHERE `Guests`.`token` = "$2y$10$rptGIlBzE3gpd0A7kdNyLu6gTWEEIt6UmY/WLMctwVyNjRTKLgT3m";';
$stmt = $db->prepare($sql);
$stmt->execute();
$callBack = $stmt -> fetchAll(PDO::FETCH_ASSOC);


// foreach($callBack as $key => $val){
  
//   $array_1 += array_intersect($array_1, $val);
//   print_r($array_1);
// }


// $result = array_merge_recursive($array1, $array2);
// print_r($result['key1'][0]);
$oVal = (object)[
	'key1' => (object)[
	  'var1' => "something",
	  'var2' => "something else",
	],
  ];
  $name = (object) [
	'first' => ['test','test2'],
	'last'  => 'Jie',
  ];
  $name->first = 'gg';
var_dump($name);  
?>