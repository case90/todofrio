<?php
/**
 * @property Product $object
 */
class AdminProductsController extends AdminProductsControllerCore
{

   
    public $products_datapv = [];
   
  
    public function __construct()
    {
        if(!Configuration::get('CONNECTIONEXTERNALSERVER_LIVE_MODE') || !Module::isEnabled('syncinventory'))
            return parent::__construct();

        $this->bootstrap = true;
        $this->table = 'product';
        $this->className = 'Product';
        $this->lang = true;
        $this->explicitSelect = true;
        $this->bulk_actions = array(
            'delete' => array(
                'text' => $this->l('Delete selected'),
                'icon' => 'icon-trash',
                'confirm' => $this->l('Delete selected items?')
            )
        );
        if (!Tools::getValue('id_product')) {
            $this->multishop_context_group = false;
        }
       
        parent::__construct();
        $this->imageType = 'jpg';
        $this->_defaultOrderBy = 'position';
        $this->max_file_size = (int)(Configuration::get('PS_LIMIT_UPLOAD_FILE_VALUE') * 1000000);
        $this->max_image_size = (int)Configuration::get('PS_PRODUCT_PICTURE_MAX_SIZE');
        $this->allow_export = true;
        $this->_join = '';
        $this->_select = '';
        $this->available_tabs_lang = array(
            'Informations' => $this->l('Information'),
            'Pack' => $this->l('Pack'),
            'VirtualProduct' => $this->l('Virtual Product'),
            'Prices' => $this->l('Prices'),
            'Seo' => $this->l('SEO'),
            'Images' => $this->l('Images'),
            'Associations' => $this->l('Associations'),
            'Shipping' => $this->l('Shipping'),
            'Combinations' => $this->l('Combinations'),
            'Features' => $this->l('Features'),
            'Customization' => $this->l('Customization'),
            'Attachments' => $this->l('Attachments'),
            'Quantities' => $this->l('Quantities'),
            'Suppliers' => $this->l('Suppliers'),
            'Warehouses' => $this->l('Warehouses'),
        );
        $this->available_tabs = array('Quantities' => 6, 'Warehouses' => 14);
        if ($this->context->shop->getContext() != Shop::CONTEXT_GROUP) {
            $this->available_tabs = array_merge($this->available_tabs, array(
                'Informations' => 0,
                'Pack' => 7,
                'VirtualProduct' => 8,
                'Prices' => 1,
                'Seo' => 2,
                'Associations' => 3,
                'Images' => 9,
                'Shipping' => 4,
                'Combinations' => 5,
                'Features' => 10,
                'Customization' => 11,
                'Attachments' => 12,
                'Suppliers' => 13,
            ));
        }
        asort($this->available_tabs, SORT_NUMERIC);
        
        
        $modules_list = Hook::getHookModuleExecList('displayAdminProductsExtra');
        if (is_array($modules_list) && count($modules_list) > 0) {
            foreach ($modules_list as $m) {
                $this->available_tabs['Module'.ucfirst($m['module'])] = 23;
                $this->available_tabs_lang['Module'.ucfirst($m['module'])] = Module::getModuleName($m['module']);
            }
        }
        if (Tools::getValue('reset_filter_category')) {
            $this->context->cookie->id_category_products_filter = false;
        }
        if (Shop::isFeatureActive() && $this->context->cookie->id_category_products_filter) {
            $category = new Category((int)$this->context->cookie->id_category_products_filter);
            if (!$category->inShop()) {
                $this->context->cookie->id_category_products_filter = false;
                Tools::redirectAdmin($this->context->link->getAdminLink('AdminProducts'));
            }
        }
        
        if ($id_category = (int)Tools::getValue('productFilter_cl!name')) {
            $this->_category = new Category((int)$id_category);
            $_POST['productFilter_cl!name'] = $this->_category->name[$this->context->language->id];
        } else {
            if ($id_category = (int)Tools::getValue('id_category')) {
                $this->id_current_category = $id_category;
                $this->context->cookie->id_category_products_filter = $id_category;
            } elseif ($id_category = $this->context->cookie->id_category_products_filter) {
                $this->id_current_category = $id_category;
            }
            if ($this->id_current_category) {
                $this->_category = new Category((int)$this->id_current_category);
            } else {
                $this->_category = new Category();
            }
        }
        $join_category = false;
        if (Validate::isLoadedObject($this->_category) && empty($this->_filter)) {
            $join_category = true;
        }
        $this->_join .= '
        LEFT JOIN `'._DB_PREFIX_.'stock_available` sav ON (sav.`id_product` = a.`id_product` AND sav.`id_product_attribute` = 0
        '.StockAvailable::addSqlShopRestriction(null, null, 'sav').') ';
        $alias = 'sa';
        $alias_image = 'image_shop';
        $id_shop = Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP? (int)$this->context->shop->id : 'a.id_shop_default';
        $this->_join .= ' JOIN `'._DB_PREFIX_.'product_shop` sa ON (a.`id_product` = sa.`id_product` AND sa.id_shop = '.$id_shop.')
                LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON ('.$alias.'.`id_category_default` = cl.`id_category` AND b.`id_lang` = cl.`id_lang` AND cl.id_shop = '.$id_shop.')
                LEFT JOIN `'._DB_PREFIX_.'shop` shop ON (shop.id_shop = '.$id_shop.')
                LEFT JOIN `'._DB_PREFIX_.'image_shop` image_shop ON (image_shop.`id_product` = a.`id_product` AND image_shop.`cover` = 1 AND image_shop.id_shop = '.$id_shop.')
                LEFT JOIN `'._DB_PREFIX_.'image` i ON (i.`id_image` = image_shop.`id_image`)
                LEFT JOIN `'._DB_PREFIX_.'product_download` pd ON (pd.`id_product` = a.`id_product` AND pd.`active` = 1)';
        $this->_select .= 'shop.`name` AS `shopname`, a.`id_shop_default`, ';
        $this->_select .= $alias_image.'.`id_image` AS `id_image`, cl.`name` AS `name_category`, '.$alias.'.`price`, 0 AS `price_final`, a.`is_virtual`, pd.`nb_downloadable`, sav.`quantity` AS `sav_quantity`, '.$alias.'.`active`, IF(sav.`quantity`<=0, 1, 0) AS `badge_danger`';
        if ($join_category) {
            $this->_join .= ' INNER JOIN `'._DB_PREFIX_.'category_product` cp ON (cp.`id_product` = a.`id_product` AND cp.`id_category` = '.(int)$this->_category->id.') ';
            $this->_select .= ' , cp.`position`, ';
        }
        $this->_use_found_rows = false;
        $this->_group = '';
        $this->fields_list = array();
        $this->fields_list['id_product'] = array(
            'title' => $this->l('ID'),
            'align' => 'center',
            'class' => 'fixed-width-xs',
            'type' => 'int'
        );
        $this->fields_list['image'] = array(
            'title' => $this->l('Image'),
            'align' => 'center',
            'image' => 'p',
            'orderby' => false,
            'filter' => false,
            'search' => false
        );
        $this->fields_list['name'] = array(
            'title' => $this->l('Name'),
            'filter_key' => 'b!name'
        );
        $this->fields_list['reference'] = array(
            'title' => $this->l('Reference'),
            'align' => 'left',
        );
        if (Shop::isFeatureActive() && Shop::getContext() != Shop::CONTEXT_SHOP) {
            $this->fields_list['shopname'] = array(
                'title' => $this->l('Default shop'),
                'filter_key' => 'shop!name',
            );
        } else {
            $this->fields_list['name_category'] = array(
                'title' => $this->l('Category'),
                'filter_key' => 'cl!name',
            );
        }
        $this->fields_list['price'] = array(
            'title' => $this->l('Base price'),
            'type' => 'price',
            'align' => 'text-right',
            'filter_key' => 'a!price'
        );
        $this->fields_list['price_final'] = array(
            'title' => $this->l('Final price'),
            'type' => 'price',
            'align' => 'text-right',
            'havingFilter' => true,
            'orderby' => false,
            'search' => false
        );
        
        $this->fields_list['active'] = array(
            'title' => $this->l('Status'),
            'active' => 'status',
            'filter_key' => $alias.'!active',
            'align' => 'text-center',
            'type' => 'bool',
            'class' => 'fixed-width-sm',
            'orderby' => false
        );
        if ($join_category && (int)$this->id_current_category) {
            $this->fields_list['position'] = array(
                'title' => $this->l('Position'),
                'filter_key' => 'cp!position',
                'align' => 'center',
                'position' => 'position'
            );
        }
      
    }

    public function initToolbar()
    {
        if(!Configuration::get('CONNECTIONEXTERNALSERVER_LIVE_MODE') || !Module::isEnabled('syncinventory'))
            return parent::initToolbar();

        parent::initToolbar();
        if ($this->display == 'edit' || $this->display == 'add') {
            $this->toolbar_btn['save'] = array(
                'short' => 'Save',
                'href' => '#',
                'desc' => $this->l('Save'),
            );

            $this->toolbar_btn['save-and-stay'] = array(
                'short' => 'SaveAndStay',
                'href' => '#',
                'desc' => $this->l('Save and stay'),
            );

            // adding button for adding a new combination in Combination tab
            $this->toolbar_btn['newCombination'] = array(
                'short' => 'New combination',
                'desc' => $this->l('New combination'),
                'class' => 'toolbar-new'
            );

            
        } elseif ($this->can_import) {
            $this->toolbar_btn['import'] = array(
                'href' => $this->context->link->getAdminLink('AdminImport', true).'&import_type=products',
                'desc' => $this->l('Import')
            );
        }
        
        if(Configuration::get('CONNECTIONEXTERNALSERVER_SYNC_PRICES_BUTTON')){
            $this->toolbar_btn['syncprices'] = array(
                'href' => $this->context->link->getAdminLink('AdminProducts', true).'&syncprices=true',
                'desc' => $this->l('Sincronizar precios'),
                'class' => 'process-icon-download-alt'
            );
        }
        
        if(Configuration::get('CONNECTIONEXTERNALSERVER_SYNC_INVENTORY_BUTTON')){
            $this->toolbar_btn['syncinventory'] = array(
                'href' => $this->context->link->getAdminLink('AdminProducts', true).'&syncinventory=true',
                'desc' => $this->l('Sincronizar existencias'),
                'class' => 'icon-inbox'
            );
        }

        $this->context->smarty->assign('toolbar_scroll', 1);
        $this->context->smarty->assign('show_toolbar', 1);
        $this->context->smarty->assign('toolbar_btn', $this->toolbar_btn);
    }

    public function postProcess()
    {
        if(!Configuration::get('CONNECTIONEXTERNALSERVER_LIVE_MODE') || !Module::isEnabled('syncinventory'))
            return parent::postProcess();

        if(Tools::getValue('syncprices'))
            $this->syncPrices();

        if(Tools::getValue('syncinventory'))
            $this->syncInventory();

        if (!$this->redirect_after) {
            parent::postProcess();
        }

        if ($this->display == 'edit' || $this->display == 'add') {
            $this->addJqueryUI(array(
                'ui.core',
                'ui.widget'
            ));

            $this->addjQueryPlugin(array(
                'autocomplete',
                'tablednd',
                'thickbox',
                'ajaxfileupload',
                'date',
                'tagify',
                'select2',
                'validate'
            ));

            $this->addJS(array(
                _PS_JS_DIR_.'admin/products.js',
                _PS_JS_DIR_.'admin/attributes.js',
                _PS_JS_DIR_.'admin/price.js',
                _PS_JS_DIR_.'tiny_mce/tiny_mce.js',
                _PS_JS_DIR_.'admin/tinymce.inc.js',
                _PS_JS_DIR_.'admin/dnd.js',
                _PS_JS_DIR_.'jquery/ui/jquery.ui.progressbar.min.js',
                _PS_JS_DIR_.'vendor/spin.js',
                _PS_JS_DIR_.'vendor/ladda.js'
            ));

            $this->addJS(_PS_JS_DIR_.'jquery/plugins/select2/select2_locale_'.$this->context->language->iso_code.'.js');
            $this->addJS(_PS_JS_DIR_.'jquery/plugins/validate/localization/messages_'.$this->context->language->iso_code.'.js');

            $this->addCSS(array(
                _PS_JS_DIR_.'jquery/plugins/timepicker/jquery-ui-timepicker-addon.css'
            ));
        }
    }

    public function syncPrices()
    {
        $result = [];
        $errorProducts  = [];
        $dataPvProducts = [];
        $cache_alias = 'syncPrices';
        $host   = Configuration::get('CONNECTIONEXTERNALSERVER_SERVER');
        $user   = Configuration::get('CONNECTIONEXTERNALSERVER_USER');
        $pass   = Configuration::get('CONNECTIONEXTERNALSERVER_PASSWORD');
        $db     = Configuration::get('CONNECTIONEXTERNALSERVER_DB_NAME');
        $mysqli = @new mysqli($host, $user, $pass, $db);
     
        $sql = 'SELECT 
            TRIM(p.ProductID) AS ProductID,
            p.ProductName,
            p.UnitPrice,
            p.UnitCost
        FROM `products` p';
        if ($rows = $mysqli->query($sql, MYSQLI_USE_RESULT)) {
            while($obj = $rows->fetch_assoc())
                $dataPvProducts[ $obj[ 'ProductID' ] ] = $obj;
            
            $rows->close();
            
            $allProducts = [];
            $sql = 'SELECT
                ps.id_product,
                pl.name,
                TRIM(p.reference) AS reference, 
                p.price AS price,
                ps.price AS price_shop
            FROM '._DB_PREFIX_.'product_shop ps
            INNER JOIN '._DB_PREFIX_.'product p ON p.id_product = ps.id_product
            INNER JOIN '._DB_PREFIX_.'product_lang pl ON pl.id_product = p.id_product
            WHERE pl.id_lang = '.(int)$this->context->employee->id_lang.' AND pl.id_shop = '.(int)$this->context->shop->id.'
            ';
  
            $sentence       = '';
            $ids_products   = '';
            if ($results = Db::getInstance()->ExecuteS($sql)){
                foreach ($results as $row){
          
                    if( isset($dataPvProducts[$row['reference']]) ){
                        $sentence.= 'WHEN '.$row['id_product'].' THEN '.$dataPvProducts[$row['reference']]['UnitPrice'].' ';
                        $ids_products.=$row['id_product'].', ';
                
                    }else{
                        $this->errors[] = Tools::displayError(
                            'No se pudo actualizar el precio del producto: <strong>ID: </strong>'.$row['id_product'].'  <strong>Referencia: </strong>'.$row['reference'].' <strong>Nombre:</strong> '.$row['name'], false
                        );
                    }
                }
                $ids_products = rtrim($ids_products, ', ');
                $updateProductsSql = '
                    UPDATE '._DB_PREFIX_.'product
                        SET price = CASE id_product '.$sentence.' END
                    WHERE id_product IN ('.$ids_products.');
                ';
                Db::getInstance()->execute($updateProductsSql);
                $updateProductsShopSql = '
                    UPDATE '._DB_PREFIX_.'product_shop
                        SET price = CASE id_product '.$sentence.' END
                    WHERE id_product IN ('.$ids_products.');
                ';
                Db::getInstance()->execute($updateProductsShopSql);
            }
            
        }

        return false;
    }

    public function syncinventory()
    {

        $host   = Configuration::get('CONNECTIONEXTERNALSERVER_SERVER');
        $user   = Configuration::get('CONNECTIONEXTERNALSERVER_USER');
        $pass   = Configuration::get('CONNECTIONEXTERNALSERVER_PASSWORD');
        $db     = Configuration::get('CONNECTIONEXTERNALSERVER_DB_NAME');
        $mysqli = @new mysqli($host, $user, $pass, $db);
     
        $sql = '
            SELECT 
                TRIM(exi.CodigoAlm) as Reference,
                exi.NumAlm,
                SUM(exi.`ExiAlm`) as ExiAlm
            FROM exialmacen exi
            WHERE NumAlm = 3
            GROUP BY Reference;
        ';
        
        if ($rows = $mysqli->query($sql, MYSQLI_USE_RESULT)) {
            while($obj = $rows->fetch_assoc())
                $dataPvProducts[ $obj[ 'ProductID' ] ] = $obj;
            
            $rows->close();
            
            $allProducts = [];
            $sql = 'SELECT
                ps.id_product,
                pl.name,
                TRIM(p.reference) AS reference, 
                p.price AS price,
                ps.price AS price_shop
            FROM '._DB_PREFIX_.'product_shop ps
            INNER JOIN '._DB_PREFIX_.'product p ON p.id_product = ps.id_product
            INNER JOIN '._DB_PREFIX_.'product_lang pl ON pl.id_product = p.id_product
            WHERE pl.id_lang = '.(int)$this->context->employee->id_lang.' AND pl.id_shop = '.(int)$this->context->shop->id.'
            ';
  
            $sentence       = '';
            $ids_products   = '';
            if ($results = Db::getInstance()->ExecuteS($sql)){
                foreach ($results as $row){
          
                    if( isset($dataPvProducts[$row['reference']]) ){
                        $sentence.= 'WHEN '.$row['id_product'].' THEN '.$dataPvProducts[$row['reference']]['UnitPrice'].' ';
                        $ids_products.=$row['id_product'].', ';
                
                    }else{
                        $this->errors[] = Tools::displayError(
                            'No se pudo actualizar el precio del producto: <strong>ID: </strong>'.$row['id_product'].'  <strong>Referencia: </strong>'.$row['reference'].' <strong>Nombre:</strong> '.$row['name'], false
                        );
                    }
                }
                $ids_products = rtrim($ids_products, ', ');
                $updateProductsSql = '
                    UPDATE '._DB_PREFIX_.'product
                        SET price = CASE id_product '.$sentence.' END
                    WHERE id_product IN ('.$ids_products.');
                ';
                Db::getInstance()->execute($updateProductsSql);
                $updateProductsShopSql = '
                    UPDATE '._DB_PREFIX_.'product_shop
                        SET price = CASE id_product '.$sentence.' END
                    WHERE id_product IN ('.$ids_products.');
                ';
                Db::getInstance()->execute($updateProductsShopSql);
            }
            
        }

        return false;
    }
        
}
