<?php
class StockAvailable extends StockAvailableCore
{
	/**
     * For a given id_product and id_product_attribute, gets its stock available
     *
     * @param int $id_product
     * @param int $id_product_attribute Optional
     * @param int $id_shop Optional : gets context by default
     * @return int Quantity
     */
    /*
    * module: syncinventory
    * date: 2018-06-14 17:27:09
    * version: 1.0.0
    */
    public static function getQuantityAvailableByProduct($id_product = null, $id_product_attribute = null, $id_shop = null)
    {
        
        if(Module::isEnabled('syncinventory') &&
            Configuration::get('CONNECTIONEXTERNALSERVER_LIVE_MODE') &&  
            Configuration::get('CONNECTIONEXTERNALSERVER_LIVE_INVENTORY')
        ){
            
            if ($id_product_attribute === null) {
                $id_product_attribute = 0;
            }
            $key = 'StockAvailable::checkStock'.(int)$id_product.'-'.(int)$id_product_attribute.'-'.(int)$id_shop;
            if (!Cache::isStored($key)) {
                $result = StockAvailable::checkStock($id_product);
                Cache::store($key, $result);
                return $result;
            }
            return Cache::retrieve($key);
        }else{
            return parent::getQuantityAvailableByProduct((int)$id_product);
        }
    }
    
    /*
    * module: syncinventory
    * date: 2018-06-14 17:27:09
    * version: 1.0.0
    */
    public static function checkStock($id_product){
        
        $result = 0;
        $product = new Product((int)$id_product);
        
        try{
            $host   = Configuration::get('CONNECTIONEXTERNALSERVER_SERVER');
            $user   = Configuration::get('CONNECTIONEXTERNALSERVER_USER');
            $pass   = Configuration::get('CONNECTIONEXTERNALSERVER_PASSWORD');
            $db     = Configuration::get('CONNECTIONEXTERNALSERVER_DB_NAME');
            $mysqli = new mysqli($host, $user, $pass, $db);
            if ($mysqli->connect_error) {
               die("Connection failed: " . $mysqli->connect_error);
            }
            
            $sql = '
                SELECT 
                    SUM(exi.`ExiAlm`) as "ExiAlm"
                FROM `exialmacen` exi
                WHERE exi.`NumAlm` = 3 AND exi.`CodigoAlm` = "'.$product->reference.'"
                GROUP BY exi.`CodigoAlm`
            ';
            if ($rows = $mysqli->query($sql, MYSQLI_USE_RESULT)) {
                
                while($obj = $rows->fetch_object()){ 
                    $result = (int)$obj->ExiAlm;
                } 
                
                $rows->close();
            }
            return $result;
        }catch(mysqli_sql_exception $e){
            return parent::getQuantityAvailableByProduct();
        }
      
    }
}