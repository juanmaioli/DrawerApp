<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
$usr_timezone = -3;
include("../config.php");

$conn = new mysqli($db_server, $db_user,$db_pass,$db_name,$db_serverport);
mysqli_set_charset($conn,'utf8');
$fecha = date("Y-m-d H:i:s");
$date = new DateTime($fecha);
$date->setTimezone(new DateTimeZone($usr_timezone));
$nuevoAnio =  $date->format('Y');
$nuevoMes =  $date->format('n');
$nuevoDia =  $date->format('d');
$nuevoHora =  $date->format('H');

$tipoSql = $_GET['id'];
$parametro = explode("-",$tipoSql);
$tarea = $parametro[0];

  switch ($tarea) {
    case 'list'://Tareas del Usuario
      if($parametro[2] == 0){
        $whereClause =" WHERE drawer_owner = $parametro[1] AND drawer_delete = 0 ";
      }else{
        $whereClause =" WHERE drawer_owner = $parametro[1] AND drawer_delete = 0 AND drawer_category = $parametro[2] ";
      }
      $sql  = "SELECT
      drawers_category.category_name,
      drawers_category.category_color,
      drawers_drawer.drawer_id,
      drawers_drawer.drawer_name,
      drawers_drawer.drawer_owner,
      drawers_drawer.drawer_delete,
      drawers_drawer.drawer_location,
      drawers_drawer.drawer_image,
      drawers_drawer.drawer_descriptinon,
      (SELECT GROUP_CONCAT( item_name SEPARATOR ',' ) FROM drawers_items WHERE item_drawer = drawers_drawer.drawer_id ) AS items_included,
      (SELECT sum(item_amount) as total FROM drawers_items WHERE item_drawer = drawers_drawer.drawer_id GROUP BY item_drawer) AS items_total,
      (SELECT sum(total_price) as total_price FROM total_price_drawer WHERE drawer = drawers_drawer.drawer_id) AS drawer_price
      FROM drawers_drawer
      LEFT JOIN drawers_category ON drawers_drawer.drawer_category = drawers_category.category_id
      $whereClause
      ORDER BY drawer_name";
      break;
    case 'view':
      $sql = "SELECT
      drawers_drawer.drawer_id,
      drawers_drawer.drawer_name,
      drawers_drawer.drawer_category,
      drawers_drawer.drawer_owner,
      drawers_drawer.drawer_location,
      drawers_drawer.drawer_descriptinon,
      drawers_drawer.drawer_image,
      drawers_drawer.drawer_image_full,
      drawers_drawer.drawer_date,
      drawers_drawer.drawer_update,
      drawers_drawer.drawer_delete,
      drawers_category.category_name,
      drawers_category.category_color
    FROM
      drawers_drawer
      INNER JOIN
      drawers_category
      ON
        drawers_drawer.drawer_category = drawers_category.category_id
    WHERE
      drawer_id =". $parametro[1];
      break;
    case 'categorylist':
      $sql = "SELECT
      drawers_category.category_id, 
      drawers_category.category_name, 
      drawers_category.category_color,
      (SELECT sum(item_amount) as total FROM drawers_items WHERE item_category = drawers_category.category_id) as ItemsPerCategory,
      (SELECT count(*) as total FROM drawers_drawer WHERE drawer_category = drawers_category.category_id GROUP BY drawer_category) as DrawersPerCategory
      FROM drawers_category ORDER BY category_name";
      break;
    case 'categoryview':
      $sql = "SELECT
      drawers_category.category_id,
      drawers_category.category_name,
      drawers_category.category_color
      FROM drawers_category WHERE category_id = $parametro[1]";
      break;
      case 'itemview':
        $sql = "SELECT
        drawers_items.item_id,
        drawers_items.item_drawer,
        drawers_items.item_name,
        drawers_items.item_amount,
        drawers_items.item_price,
        drawers_items.item_descrption,
        drawers_items.item_image,
        drawers_items.item_owner,
        drawers_items.item_category,
        drawers_category.category_name,
        drawers_category.category_color,
        drawers_drawer.drawer_name
      FROM
        drawers_items
        INNER JOIN
        drawers_category
        ON
          drawers_items.item_category = drawers_category.category_id
        INNER JOIN
        drawers_drawer
        ON
          drawers_items.item_drawer = drawers_drawer.drawer_id
      WHERE
        item_id = $parametro[1]";
        break;
      case 'itemlist':
        $sql = "SELECT
          drawers_category.category_name,
          drawers_category.category_color,
          drawers_items.item_id,
          drawers_items.item_drawer,
          drawers_items.item_name,
          drawers_items.item_image,
          drawers_items.item_amount,
          drawers_items.item_price,
          drawers_items.item_descrption,
          drawers_items.item_category,
          drawers_items.item_owner,
          drawers_items.item_update,
          drawers_items.item_date
        FROM
          drawers_items
          INNER JOIN
          drawers_category
          ON
            drawers_items.item_category = drawers_category.category_id
        WHERE
          item_drawer = $parametro[1] AND
          item_owner = $parametro[2] AND
          item_delete = 0
        ORDER BY
          item_name ASC";
        break;
      case 'itemsall':
        if($parametro[2] == 0){
          $whereClause =" WHERE item_owner = $parametro[1] AND item_delete = 0";
        }else{
          $whereClause =" WHERE item_owner = $parametro[1] AND item_delete = 0 AND item_category = $parametro[2] ";
        }
        $sql = "SELECT
        drawers_category.category_name, 
        drawers_category.category_color, 
        drawers_items.item_id, 
        drawers_items.item_drawer, 
        drawers_items.item_name, 
        drawers_items.item_image, 
        drawers_items.item_amount, 
        drawers_items.item_price,
        drawers_items.item_descrption, 
        drawers_items.item_category, 
        drawers_items.item_owner, 
        drawers_items.item_update, 
        drawers_items.item_date, 
        drawers_drawer.drawer_name
      FROM drawers_items
      INNER JOIN drawers_category ON drawers_items.item_category = drawers_category.category_id 
      INNER JOIN drawers_drawer ON drawers_items.item_drawer = drawers_drawer.drawer_id
      $whereClause 
      ORDER BY item_name ASC";
        break;
      case 'search':
        $sql = "SELECT * FROM drawers_items WHERE ";
        break;
      case 'totalprice':
        $sql = "SELECT sum(total_price) as total FROM total_price";
        break;
      case 'categoryprice':
        $sql = "SELECT drawers_category.category_name as Categoria, (Select sum(total_price) from total_price where category = drawers_category.category_id GROUP BY category) as category_price FROM drawers_items INNER JOIN drawers_category ON drawers_items.item_category = drawers_category.category_id GROUP BY item_category order by category_price desc limit $parametro[1]";
        break;
      case 'categorytotal':
        $sql = "SELECT drawers_category.category_name as Categoria, sum(item_amount) AS Total FROM drawers_items INNER JOIN drawers_category ON drawers_items.item_category = drawers_category.category_id GROUP BY item_category order by total desc limit $parametro[1]";
        break;
      default:$sql  = "";
  }
// echo $sql ;
  if (strlen($sql) > 5){
      $result = $conn->query($sql);
      $dataCount = mysqli_num_rows($result);
      $rawdata = array();

    $i=0;
      while($row = mysqli_fetch_assoc($result))
      {
        $rawdata[$i] = $row;
        $i++;
      }
  echo json_encode($rawdata,JSON_UNESCAPED_UNICODE);

  $conn->close();
  }