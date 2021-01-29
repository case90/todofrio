<?php
/**
 * @property Product $object
 */
class AdminProductsController extends AdminProductsControllerCore
{

    public function processExport($text_delimiter = '"')
    {

        // clean buffer
        if (ob_get_level() && ob_get_length() > 0) {
            ob_clean();
        }
        $this->getList($this->context->language->id, null, null, 0, false);
        if (!count($this->_list)) {
            return;
        }

        header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
        header('Cache-Control: no-store, no-cache');
        header('Content-disposition: attachment; filename="'.$this->table.'_'.date('Y-m-d_His').'.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $headers = array();

        foreach ($this->fields_list as $key => $datas) {
            if ($datas['title'] == 'PDF') {
                unset($this->fields_list[$key]);
            } else {
                $headers[] = Tools::htmlentitiesDecodeUTF8($datas['title']);
            }
        }
        $content = array();
        foreach ($this->_list as $i => $row) {
            $content[$i] = array();
            $path_to_image = false;
            foreach ($this->fields_list as $key => $params) {
                $field_value = isset($row[$key]) ? Tools::htmlentitiesDecodeUTF8(Tools::nl2br($row[$key])) : '';
                if ($key == 'image') {
                    if ($params['image'] != 'p' || Configuration::get('PS_LEGACY_IMAGES')) {
                        $path_to_image = Tools::getShopDomain(true)._PS_IMG_.$params['image'].'/'.$row['id_'.$this->table].(isset($row['id_image']) ? '-'.(int)$row['id_image'] : '').'.'.$this->imageType;
                    } else {
                        $path_to_image = Tools::getShopDomain(true)._PS_IMG_.$params['image'].'/'.Image::getImgFolderStatic($row['id_image']).(int)$row['id_image'].'.'.$this->imageType;
                    }
                    if ($path_to_image) {
                        $field_value = $path_to_image;
                    }
                }
                if (isset($params['callback'])) {
                    $callback_obj = (isset($params['callback_object'])) ? $params['callback_object'] : $this->context->controller;
                    if (!preg_match('/<([a-z]+)([^<]+)*(?:>(.*)<\/\1>|\s+\/>)/ism', call_user_func_array(array($callback_obj, $params['callback']), array($field_value, $row)))) {
                        $field_value = call_user_func_array(array($callback_obj, $params['callback']), array($field_value, $row));
                    }
                }
                $content[$i][] = $field_value;
            }
        }

        $this->context->smarty->assign(array(
            'export_precontent' => "\xEF\xBB\xBF",
            'export_headers' => $headers,
            'export_content' => $content,
            'text_delimiter' => $text_delimiter
            )
        );

        $this->layout = 'layout_export_columns_format.tpl';
    }        
}
