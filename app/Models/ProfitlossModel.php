<?php

namespace App\Models;
use CodeIgniter\Model;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ProfitlossModel extends Model
{
    public function get_closing_stock($start_date ='', $end_date= ''){
        
        if($start_date == ''){
            if(date('m') < '03'){
                $year = date('Y')-1;
                $start_date = $year.'-04-01';
            }else{
                $year = date('Y');
                $start_date = $year.'-04-01';
            }
        }

        if($end_date == '' ){
            if(date('m') < '03'){
                $year = date('Y');
            }else{
                $year = date('Y')+1;
            }
            $end_date =$year.'-03-31'; 
        }

        $db = $this->db;
        $db->setDatabase(session('DataSource')); 
        $builder = $db->table('item'); 
        $builder->select('*');
        $builder->where(array('is_delete'=>0));
        $query = $builder->get();
        $result = $query->getResultArray();
        $diff_total = array();

        foreach($result as $row){
            
            $sale = SaleItemSTock($row['id'],$start_date,$end_date);
            $purchase = PurchaseItemSTock($row['id'],$start_date,$end_date);
            // $sale_pur = sale_purchase_itm_total($start_date,$end_date);
            if($purchase['itm']['total_qty'] != 0 ){
                $diff_total[] =   (@$purchase['itm']['total_rate'] / @$purchase['itm']['total_qty']) * (@$purchase['itm']['total_qty'] - @$sale['itm']['total_qty']);    
            }else{
                $diff_total[] =   1 * (@$purchase['itm']['total_qty'] - @$sale['itm']['total_qty']);    
            }
        }
        $final_total  =  array_sum($diff_total);
        if(!isset($final_total) || empty($final_total)){
            $final_total = 0;
        }
        return $final_total;
        
    }

    public function get_closing_bal($start_date ='', $end_date= ''){
        
        if($start_date == ''){
            if(date('m') < '03'){
                $year = date('Y')-1;
                $start_date = $year.'-04-01';
            }else{
                $year = date('Y');
                $start_date = $year.'-04-01';
            }
        }

        if($end_date == '' ){
            if(date('m') < '03'){
                $year = date('Y');
            }else{
                $year = date('Y')+1;
            }
            $end_date =$year.'-03-31'; 
        }
       
        $db = $this->db;
        $db->setDatabase(session('DataSource')); 
        $builder = $db->table('oc_stock'); 
        $builder->select('*');
        $builder->where('date <=',$end_date);
        $builder->where('date <',date('Y-m-d'));
        $builder->where(array('is_delete'=>0));
        $builder->orderBy('date','desc');
        $builder->limit(1);
        $query = $builder->get();
        $result = $query->getRowArray();
        @$closing =  @$result['closing'];
        
        return @$closing;
        // echo '<pre>';print_r($result);exit;
        
    }
    
}
?>
