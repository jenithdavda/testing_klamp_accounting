<?php

namespace App\Models;
use CodeIgniter\Model;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class BalancesheetModel extends Model
{
    public function purchase_voucher_wise_data($get)
    {
        // print_r($get);exit;
        $db = $this->db;
        $db->setDatabase(session('DataSource'));
        

        if (!empty($get['year'])) {

            $start = strtotime("{$get['year']}-{$get['month']}-01");
            $end = strtotime('-1 second', strtotime('+1 month', $start));

            $start_date = date('Y-m-d', $start);
            $end_date = date('Y-m-d', $end);

            $builder = $db->table('purchase_invoice pi');
            $builder->select('pi.id,ac.id as account_id,ac.name as party_name,pi.invoice_date as date,pi.net_amount as taxable');
            $builder->join('account ac', 'ac.id =pi.account');
            $builder->where(array('pi.account' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pi.is_delete' => '0'));
            $builder->where(array('pi.is_cancle' => '0'));
            $builder->where(array('DATE(pi.invoice_date)  >= ' => $start_date));
            $builder->where(array('DATE(pi.invoice_date)  <= ' => $end_date));
            $builder->groupBy('pi.id');
            $query = $builder->get();
            $purchase_invoice = $query->getResultArray();

            $builder = $db->table('purchase_invoice pi');
            $builder->select('pi.id,ac.id as account_id,ac.name as party_name,pi.invoice_date as date,pi.tot_igst as taxable');
            $builder->join('account ac', 'ac.id =' . $get['id'] . '');
            $builder->where(array('pi.igst_acc' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pi.is_delete' => '0'));
            $builder->where(array('pi.is_cancle' => '0'));
            $builder->where(array('DATE(pi.invoice_date)  >= ' => $start_date));
            $builder->where(array('DATE(pi.invoice_date)  <= ' => $end_date));
            $builder->groupBy('pi.id');
            $query = $builder->get();
            $purchase_igst = $query->getResultArray();

            $builder = $db->table('purchase_invoice pi');
            $builder->select('pi.id,ac.id as account_id,ac.name as party_name,pi.invoice_date as date,pi.tot_cgst as taxable');
            $builder->join('account ac', 'ac.id =' . $get['id']);
            $builder->where(array('pi.cgst_acc' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pi.is_delete' => '0'));
            $builder->where(array('pi.is_cancle' => '0'));
            $builder->where(array('DATE(pi.invoice_date)  >= ' => $start_date));
            $builder->where(array('DATE(pi.invoice_date)  <= ' => $end_date));
            $builder->groupBy('pi.id');
            $query = $builder->get();
            $purchase_cgst = $query->getResultArray();

            $builder = $db->table('purchase_invoice pi');
            $builder->select('pi.id,ac.id as account_id,ac.name as party_name,pi.invoice_date as date,pi.tot_sgst as taxable');
            $builder->join('account ac', 'ac.id =' . $get['id']);
            $builder->where(array('pi.sgst_acc' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pi.is_delete' => '0'));
            $builder->where(array('pi.is_cancle' => '0'));
            $builder->where(array('DATE(pi.invoice_date)  >= ' => $start_date));
            $builder->where(array('DATE(pi.invoice_date)  <= ' => $end_date));
            $builder->groupBy('pi.id');
            $query = $builder->get();
            $purchase_sgst = $query->getResultArray();

           
            $purchase['purchase'] =  array_merge($purchase_invoice, $purchase_igst, $purchase_cgst, $purchase_sgst);

        } else if (!empty(@$get['from'])) {

            $start_date = @$get['from']  ? db_date($get['from']) : '';
            $end_date = @$get['to'] ? db_date($get['to']) : '';

            $builder = $db->table('purchase_invoice pi');
            $builder->select('pi.id,ac.id as account_id,ac.name as party_name,pi.invoice_date as date,pi.net_amount as taxable');
            $builder->join('account ac', 'ac.id =pi.account');
            $builder->where(array('pi.account' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pi.is_delete' => '0'));
            $builder->where(array('pi.is_cancle' => '0'));
            $builder->where(array('DATE(pi.invoice_date)  >= ' => $start_date));
            $builder->where(array('DATE(pi.invoice_date)  <= ' => $end_date));
            $builder->groupBy('pi.id');
            $query = $builder->get();
            $purchase_invoice = $query->getResultArray();

            $builder = $db->table('purchase_invoice pi');
            $builder->select('pi.id,ac.id as account_id,ac.name as party_name,pi.invoice_date as date,pi.tot_igst as taxable');
            $builder->join('account ac', 'ac.id =' . $get['id'] . '');
            $builder->where(array('pi.igst_acc' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pi.is_delete' => '0'));
            $builder->where(array('pi.is_cancle' => '0'));
            $builder->where(array('DATE(pi.invoice_date)  >= ' => $start_date));
            $builder->where(array('DATE(pi.invoice_date)  <= ' => $end_date));
            $builder->groupBy('pi.id');
            $query = $builder->get();
            $purchase_igst = $query->getResultArray();

            $builder = $db->table('purchase_invoice pi');
            $builder->select('pi.id,ac.id as account_id,ac.name as party_name,pi.invoice_date as date,pi.tot_cgst as taxable');
            $builder->join('account ac', 'ac.id =' . $get['id']);
            $builder->where(array('pi.cgst_acc' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pi.is_delete' => '0'));
            $builder->where(array('pi.is_cancle' => '0'));
            $builder->where(array('DATE(pi.invoice_date)  >= ' => $start_date));
            $builder->where(array('DATE(pi.invoice_date)  <= ' => $end_date));
            $builder->groupBy('pi.id');
            $query = $builder->get();
            $purchase_cgst = $query->getResultArray();

            $builder = $db->table('purchase_invoice pi');
            $builder->select('pi.id,ac.id as account_id,ac.name as party_name,pi.invoice_date as date,pi.tot_sgst as taxable');
            $builder->join('account ac', 'ac.id =' . $get['id']);
            $builder->where(array('pi.sgst_acc' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pi.is_delete' => '0'));
            $builder->where(array('pi.is_cancle' => '0'));
            $builder->where(array('DATE(pi.invoice_date)  >= ' => $start_date));
            $builder->where(array('DATE(pi.invoice_date)  <= ' => $end_date));
            $builder->groupBy('pi.id');
            $query = $builder->get();
            $purchase_sgst = $query->getResultArray();

            $purchase['purchase'] =  array_merge($purchase_invoice, $purchase_igst, $purchase_cgst, $purchase_sgst);

        } else {
            $purchase['purchase'] = array();
            $start_date = '';
            $end_date = '';
        }
        $total_taxable = 0;
        foreach($purchase['purchase'] as $row)
        {
            $total_taxable += $row['taxable'];
        }
        $purchase['total_taxable'] = $total_taxable;
        $purchase['date']['from'] = $start_date;
        $purchase['date']['to'] = $end_date;
        $purchase['ac_id'] = $get['id'];

        return $purchase;
    }
    public function purchase_ret_voucher_wise_data($get)
    {

        $db = $this->db;
        $db->setDatabase(session('DataSource'));

        if (!empty($get['year'])) {

            $start = strtotime("{$get['year']}-{$get['month']}-01");
            $end = strtotime('-1 second', strtotime('+1 month', $start));

            $start_date = date('Y-m-d', $start);
            $end_date = date('Y-m-d', $end);

            $builder = $db->table('purchase_return pi');
            $builder->select('pi.id,ac.id as account_id,ac.name as party_name,pi.return_date as date,pi.net_amount as taxable');
            $builder->join('account ac', 'ac.id =' . $get['id']);
            $builder->where(array('pi.account' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pi.is_delete' => '0'));
            $builder->where(array('DATE(pi.return_date)  >= ' => $start_date));
            $builder->where(array('DATE(pi.return_date)  <= ' => $end_date));
            $builder->groupBy('pi.id');
            $query = $builder->get();
            $purchase_return = $query->getResultArray();

            $builder = $db->table('purchase_return pi');
            $builder->select('pi.id,ac.id as account_id,ac.name as party_name,pi.return_date as date,pi.tot_igst as taxable');
            $builder->join('account ac', 'ac.id =' . $get['id']);
            $builder->where(array('pi.igst_acc' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pi.is_delete' => '0'));
            $builder->where(array('DATE(pi.return_date)  >= ' => $start_date));
            $builder->where(array('DATE(pi.return_date)  <= ' => $end_date));
            $builder->groupBy('pi.id');
            $query = $builder->get();
            $purchase_return_igst = $query->getResultArray();
            //print_r($purchase_return_igst);exit;

            $builder = $db->table('purchase_return pi');
            $builder->select('pi.id,ac.id as account_id,ac.name as party_name,pi.return_date as date,pi.tot_cgst as taxable');
            $builder->join('account ac', 'ac.id =' . $get['id']);
            $builder->where(array('pi.cgst_acc' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pi.is_delete' => '0'));
            $builder->where(array('DATE(pi.return_date)  >= ' => $start_date));
            $builder->where(array('DATE(pi.return_date)  <= ' => $end_date));
            $builder->groupBy('pi.id');
            $query = $builder->get();
            $purchase_return_cgst = $query->getResultArray();

            $builder = $db->table('purchase_return pi');
            $builder->select('pi.id,ac.id as account_id,ac.name as party_name,pi.return_date as date,pi.tot_sgst as taxable');
            $builder->join('account ac', 'ac.id =' . $get['id']);
            $builder->where(array('pi.sgst_acc' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pi.is_delete' => '0'));
            $builder->where(array('DATE(pi.return_date)  >= ' => $start_date));
            $builder->where(array('DATE(pi.return_date)  <= ' => $end_date));
            $builder->groupBy('pi.id');
            $query = $builder->get();
            $purchase_return_sgst = $query->getResultArray();

            $purchase['purchase_ret'] =  array_merge($purchase_return, $purchase_return_igst, $purchase_return_sgst, $purchase_return_cgst);
        } else if (!empty(@$get['from'])) {

            $start_date = @$get['from']  ? db_date($get['from']) : '';
            $end_date = @$get['to'] ? db_date($get['to']) : '';

            $builder = $db->table('purchase_return pi');
            $builder->select('pi.id,ac.id as account_id,ac.name as party_name,pi.return_date as date,pi.net_amount as taxable');
            $builder->join('account ac', 'ac.id =' . $get['id']);
            $builder->where(array('pi.account' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pi.is_delete' => '0'));
            $builder->where(array('DATE(pi.return_date)  >= ' => $start_date));
            $builder->where(array('DATE(pi.return_date)  <= ' => $end_date));
            $builder->groupBy('pi.id');
            $query = $builder->get();
            $purchase_return = $query->getResultArray();

            $builder = $db->table('purchase_return pi');
            $builder->select('pi.id,ac.id as account_id,ac.name as party_name,pi.return_date as date,pi.tot_igst as taxable');
            $builder->join('account ac', 'ac.id =' . $get['id']);
            $builder->where(array('pi.igst_acc' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pi.is_delete' => '0'));
            $builder->where(array('DATE(pi.return_date)  >= ' => $start_date));
            $builder->where(array('DATE(pi.return_date)  <= ' => $end_date));
            $builder->groupBy('pi.id');
            $query = $builder->get();
            $purchase_return_igst = $query->getResultArray();

            $builder = $db->table('purchase_return pi');
            $builder->select('pi.id,ac.id as account_id,ac.name as party_name,pi.return_date as date,pi.tot_cgst as taxable');
            $builder->join('account ac', 'ac.id =' . $get['id']);
            $builder->where(array('pi.cgst_acc' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pi.is_delete' => '0'));
            $builder->where(array('DATE(pi.return_date)  >= ' => $start_date));
            $builder->where(array('DATE(pi.return_date)  <= ' => $end_date));
            $builder->groupBy('pi.id');
            $query = $builder->get();
            $purchase_return_cgst = $query->getResultArray();

            $builder = $db->table('purchase_return pi');
            $builder->select('pi.id,ac.id as account_id,ac.name as party_name,pi.return_date as date,pi.tot_sgst as taxable');
            $builder->join('account ac', 'ac.id =' . $get['id']);
            $builder->where(array('pi.sgst_acc' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pi.is_delete' => '0'));
            $builder->where(array('DATE(pi.return_date)  >= ' => $start_date));
            $builder->where(array('DATE(pi.return_date)  <= ' => $end_date));
            $builder->groupBy('pi.id');
            $query = $builder->get();
            $purchase_return_sgst = $query->getResultArray();

            $purchase['purchase_ret'] =  array_merge($purchase_return, $purchase_return_igst, $purchase_return_sgst, $purchase_return_cgst);
        } else {
            $purchase['purchase_ret'] = array();
            $start_date = '';
            $end_date = '';
        }
        $total_taxable = 0;
        foreach($purchase['purchase_ret'] as $row)
        {
            $total_taxable += $row['taxable'];
        }
        $purchase['total_taxable'] = $total_taxable;
        $purchase['date']['from'] = $start_date;
        $purchase['date']['to'] = $end_date;
        $purchase['ac_id'] = $get['id'];
        //echo '<pre>';print_r($purchase);exit;
        return $purchase;
    }
    public function generalPurchase_liabi_voucher_wise_data($get){

        $db = $this->db;
        $db->setDatabase(session('DataSource')); 
        $purchase = array();

        if(!empty($get['year'])){

            $start = strtotime("{$get['year']}-{$get['month']}-01");
            $end = strtotime('-1 second', strtotime('+1 month', $start));
             
            $start_date = date('Y-m-d',$start);
            $end_date = date('Y-m-d',$end);

            $builder = $db->table('purchase_particu pp');
            $builder->select('ac.name as party_name,pg.doc_date as date,pg.invoice_no as voucher_no ,pg.id as id ,pg.v_type as pg_type,pp.account as pp_acc,pg.net_amount as pg_amount,pg.disc_type,pg.discount,pg.amty,pg.amty_type');
            $builder->join('purchase_general pg', 'pg.id = pp.parent_id');
            $builder->join('account ac', 'ac.id = pp.account');
            $builder->where('pg.party_account',$get['id']);
            $builder->where(array('pp.is_delete' => '0'));
            $builder->where(array('pg.is_delete' => '0'));
            $builder->where(array('pg.is_cancle' => '0'));
            $builder->where(array('DATE(pg.doc_date)  >= ' => $start_date));
            $builder->where(array('DATE(pg.doc_date)  <= ' => $end_date));
            $builder->where('(pg.v_type="general" OR pg.v_type = "return")');
            $builder->groupBy('pg.id');
            $query = $builder->get();
            $purchase_invoice = $query->getResultArray();

            $builder = $db->table('purchase_particu pp');
            $builder->select('ac.name as party_name,pg.doc_date as date,pg.invoice_no as voucher_no ,pg.id as id ,pg.v_type as pg_type,pp.account as pp_acc,pg.tot_igst as pg_amount,pg.disc_type,pg.discount,pg.amty,pg.amty_type');
            $builder->join('purchase_general pg', 'pg.id = pp.parent_id');
            $builder->join('account ac', 'ac.id ='.$get['id']);
            $builder->where('pg.igst_acc',$get['id']);
            $builder->where(array('pp.is_delete' => '0'));
            $builder->where(array('pg.is_delete' => '0'));
            $builder->where(array('pg.is_cancle' => '0'));
            $builder->where(array('DATE(pg.doc_date)  >= ' => $start_date));
            $builder->where(array('DATE(pg.doc_date)  <= ' => $end_date));
            $builder->where('(pg.v_type="general" OR pg.v_type = "return")');
            $builder->groupBy('pg.id');
            $query = $builder->get();
            $purchase_igst = $query->getResultArray();

            $builder = $db->table('purchase_particu pp');
            $builder->select('ac.name as party_name,pg.doc_date as date,pg.invoice_no as voucher_no ,pg.id as id ,pg.v_type as pg_type,pp.account as pp_acc,pg.tot_cgst as pg_amount,pg.disc_type,pg.discount,pg.amty,pg.amty_type');
            $builder->join('purchase_general pg', 'pg.id = pp.parent_id');
            $builder->join('account ac', 'ac.id = '.$get['id']);
            $builder->where('pg.cgst_acc',$get['id']);
            $builder->where(array('pp.is_delete' => '0'));
            $builder->where(array('pg.is_delete' => '0'));
            $builder->where(array('pg.is_cancle' => '0'));
            $builder->where(array('DATE(pg.doc_date)  >= ' => $start_date));
            $builder->where(array('DATE(pg.doc_date)  <= ' => $end_date));
            $builder->where('(pg.v_type="general" OR pg.v_type = "return")');
            $builder->groupBy('pg.id');
            $query = $builder->get();
            $purchase_cgst = $query->getResultArray();

            $builder = $db->table('purchase_particu pp');
            $builder->select('ac.name as party_name,pg.doc_date as date,pg.invoice_no as voucher_no ,pg.id as id ,pg.v_type as pg_type,pp.account as pp_acc,pg.tot_sgst as pg_amount,pg.disc_type,pg.discount,pg.amty,pg.amty_type');
            $builder->join('purchase_general pg', 'pg.id = pp.parent_id');
            $builder->join('account ac', 'ac.id = '.$get['id']);
            $builder->where('pg.sgst_acc',$get['id']);
            $builder->where(array('pp.is_delete' => '0'));
            $builder->where(array('pg.is_delete' => '0'));
            $builder->where(array('pg.is_cancle' => '0'));
            $builder->where(array('DATE(pg.doc_date)  >= ' => $start_date));
            $builder->where(array('DATE(pg.doc_date)  <= ' => $end_date));
            $builder->where('(pg.v_type="general" OR pg.v_type = "return")');
            $builder->groupBy('pg.id');
            $query = $builder->get();
            $purchase_sgst = $query->getResultArray();

            $pg_expence['purchase'] =  array_merge($purchase_invoice,$purchase_igst,$purchase_cgst,$purchase_sgst);


        }else if(!empty(@$get['from'])){

            $start_date = @$get['from']  ? db_date($get['from']) : '';
            $end_date = @$get['to'] ? db_date($get['to']) : '';

            $builder = $db->table('purchase_particu pp');
            $builder->select('ac.name as party_name,pg.doc_date as date,pg.invoice_no as voucher_no ,pg.id as id ,pg.v_type as pg_type,pp.account as pp_acc,pg.net_amount as pg_amount,pg.disc_type,pg.discount,pg.amty,pg.amty_type');
            $builder->join('purchase_general pg', 'pg.id = pp.parent_id');
            $builder->join('account ac', 'ac.id = pp.account');
            $builder->where('pg.party_account',$get['id']);
            $builder->where(array('pp.is_delete' => '0'));
            $builder->where(array('pg.is_delete' => '0'));
            $builder->where(array('pg.is_cancle' => '0'));
            $builder->where(array('DATE(pg.doc_date)  >= ' => $start_date));
            $builder->where(array('DATE(pg.doc_date)  <= ' => $end_date));
            $builder->where('(pg.v_type="general" OR pg.v_type = "return")');
            $builder->groupBy('pg.id');
            $query = $builder->get();
            $purchase_invoice = $query->getResultArray();

            $builder = $db->table('purchase_particu pp');
            $builder->select('ac.name as party_name,pg.doc_date as date,pg.invoice_no as voucher_no ,pg.id as id ,pg.v_type as pg_type,pp.account as pp_acc,pg.tot_igst as pg_amount,pg.disc_type,pg.discount,pg.amty,pg.amty_type');
            $builder->join('purchase_general pg', 'pg.id = pp.parent_id');
            $builder->join('account ac', 'ac.id ='.$get['id']);
            $builder->where('pg.igst_acc',$get['id']);
            $builder->where(array('pp.is_delete' => '0'));
            $builder->where(array('pg.is_delete' => '0'));
            $builder->where(array('pg.is_cancle' => '0'));
            $builder->where(array('DATE(pg.doc_date)  >= ' => $start_date));
            $builder->where(array('DATE(pg.doc_date)  <= ' => $end_date));
            $builder->where('(pg.v_type="general" OR pg.v_type = "return")');
            $builder->groupBy('pg.id');
            $query = $builder->get();
            $purchase_igst = $query->getResultArray();

            $builder = $db->table('purchase_particu pp');
            $builder->select('ac.name as party_name,pg.doc_date as date,pg.invoice_no as voucher_no ,pg.id as id ,pg.v_type as pg_type,pp.account as pp_acc,pg.tot_cgst as pg_amount,pg.disc_type,pg.discount,pg.amty,pg.amty_type');
            $builder->join('purchase_general pg', 'pg.id = pp.parent_id');
            $builder->join('account ac', 'ac.id = '.$get['id']);
            $builder->where('pg.cgst_acc',$get['id']);
            $builder->where(array('pp.is_delete' => '0'));
            $builder->where(array('pg.is_delete' => '0'));
            $builder->where(array('pg.is_cancle' => '0'));
            $builder->where(array('DATE(pg.doc_date)  >= ' => $start_date));
            $builder->where(array('DATE(pg.doc_date)  <= ' => $end_date));
            $builder->where('(pg.v_type="general" OR pg.v_type = "return")');
            $builder->groupBy('pg.id');
            $query = $builder->get();
            $purchase_cgst = $query->getResultArray();

            $builder = $db->table('purchase_particu pp');
            $builder->select('ac.name as party_name,pg.doc_date as date,pg.invoice_no as voucher_no ,pg.id as id ,pg.v_type as pg_type,pp.account as pp_acc,pg.tot_sgst as pg_amount,pg.disc_type,pg.discount,pg.amty,pg.amty_type');
            $builder->join('purchase_general pg', 'pg.id = pp.parent_id');
            $builder->join('account ac', 'ac.id = '.$get['id']);
            $builder->where('pg.sgst_acc',$get['id']);
            $builder->where(array('pp.is_delete' => '0'));
            $builder->where(array('pg.is_delete' => '0'));
            $builder->where(array('pg.is_cancle' => '0'));
            $builder->where(array('DATE(pg.doc_date)  >= ' => $start_date));
            $builder->where(array('DATE(pg.doc_date)  <= ' => $end_date));
            $builder->where('(pg.v_type="general" OR pg.v_type = "return")');
            $builder->groupBy('pg.id');
            $query = $builder->get();
            $purchase_sgst = $query->getResultArray();

            $pg_expence['purchase'] =  array_merge($purchase_invoice,$purchase_igst,$purchase_cgst,$purchase_sgst);

        }else{
            $pg_expence['purchase'] = array();
            $start_date = '';
            $end_date = '';
        }   
        $result['purchase'] = array();
       // echo '<pre>';Print_r($);exit;
        
        $total = 0;
        $credit = 0;
        $debit = 0;
        if(!empty($pg_expence['purchase'])){
            foreach ($pg_expence['purchase'] as $row) {
       
               
                if($row['pg_type'] == 'general'){
                    ///$total += (float)$row['pg_amount'];
                    $credit += (float)$row['pg_amount'];
                }else{
                   // $total -= (float)$row['pg_amount'];
                    $debit  += (float)$row['pg_amount'];
                } 
                //$row['taxable'] = $total;
               // $result['purchase'][] = $row; 
              
            }
        }
        $result['purchase'] = $pg_expence['purchase'];
        //$result['total_taxable'] = $total;
        $result['credit'] = $credit;
        $result['debit'] = $debit;
        $result['date']['from'] = $start_date;
        $result['date']['to'] = $end_date;
        $result['ac_id'] = $get['id'];

        // echo '<pre>';print_r($result);exit;
        return $result;     
    }
    public function sales_voucher_wise_data($get){

        $db = $this->db;
        $db->setDatabase(session('DataSource')); 
        
        if(!empty($get['year'])){

            $start = strtotime("{$get['year']}-{$get['month']}-01");
            $end = strtotime('-1 second', strtotime('+1 month', $start));
             
            $start_date = date('Y-m-d',$start);
            $end_date = date('Y-m-d',$end);
            
            $builder = $db->table('sales_invoice pi');
            $builder->select('pi.id,ac.id as account_id,ac.name as party_name,pi.invoice_date as date,pi.net_amount as taxable');
            $builder->join('account ac', 'ac.id =pi.account');
            $builder->where(array('pi.account' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pi.is_delete' => '0'));
            $builder->where(array('pi.is_cancle' => '0'));
            $builder->where(array('DATE(pi.invoice_date)  >= ' => $start_date));
            $builder->where(array('DATE(pi.invoice_date)  <= ' => $end_date));
            $builder->groupBy('pi.id');
            $query = $builder->get();
            $sales_invoice = $query->getResultArray();   
            
            $builder = $db->table('sales_invoice pi');
            $builder->select('pi.id,ac.id as account_id,ac.name as party_name,pi.invoice_date as date,pi.tot_igst as taxable');
            $builder->join('account ac', 'ac.id ='.$get['id']);
            $builder->where(array('pi.igst_acc' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pi.is_delete' => '0'));
            $builder->where(array('pi.is_cancle' => '0'));
            $builder->where(array('DATE(pi.invoice_date)  >= ' => $start_date));
            $builder->where(array('DATE(pi.invoice_date)  <= ' => $end_date));
            $builder->groupBy('pi.id');
            $query = $builder->get();
            $sales_igst = $query->getResultArray(); 

            $builder = $db->table('sales_invoice pi');
            $builder->select('pi.id,ac.id as account_id,ac.name as party_name,pi.invoice_date as date,pi.tot_cgst as taxable');
            $builder->join('account ac', 'ac.id ='.$get['id']);
            $builder->where(array('pi.cgst_acc' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pi.is_delete' => '0'));
            $builder->where(array('pi.is_cancle' => '0'));
            $builder->where(array('DATE(pi.invoice_date)  >= ' => $start_date));
            $builder->where(array('DATE(pi.invoice_date)  <= ' => $end_date));
            $builder->groupBy('pi.id');
            $query = $builder->get();
            $sales_cgst = $query->getResultArray(); 

            $builder = $db->table('sales_invoice pi');
            $builder->select('pi.id,ac.id as account_id,ac.name as party_name,pi.invoice_date as date,pi.tot_sgst as taxable');
            $builder->join('account ac', 'ac.id ='.$get['id']);
            $builder->where(array('pi.sgst_acc' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pi.is_delete' => '0'));
            $builder->where(array('pi.is_cancle' => '0'));
            $builder->where(array('DATE(pi.invoice_date)  >= ' => $start_date));
            $builder->where(array('DATE(pi.invoice_date)  <= ' => $end_date));
            $builder->groupBy('pi.id');
            $query = $builder->get();
            $sales_sgst = $query->getResultArray();

            $sales['sales'] =  array_merge($sales_invoice,$sales_igst,$sales_cgst,$sales_sgst);


        }else if(!empty(@$get['from'])){

            $start_date = @$get['from']  ? db_date($get['from']) : '';
            $end_date = @$get['to'] ? db_date($get['to']) : '';

            $builder = $db->table('sales_invoice pi');
            $builder->select('pi.id,ac.id as account_id,ac.name as party_name,pi.invoice_date as date,pi.net_amount as taxable');
            $builder->join('account ac', 'ac.id =pi.account');
            $builder->where(array('pi.account' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pi.is_delete' => '0'));
            $builder->where(array('pi.is_cancle' => '0'));
            $builder->where(array('DATE(pi.invoice_date)  >= ' => $start_date));
            $builder->where(array('DATE(pi.invoice_date)  <= ' => $end_date));
            $builder->groupBy('pi.id');
            $query = $builder->get();
            $sales_invoice = $query->getResultArray();   
            
            $builder = $db->table('sales_invoice pi');
            $builder->select('pi.id,ac.id as account_id,ac.name as party_name,pi.invoice_date as date,pi.tot_igst as taxable');
            $builder->join('account ac', 'ac.id ='.$get['id']);
            $builder->where(array('pi.igst_acc' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pi.is_delete' => '0'));
            $builder->where(array('pi.is_cancle' => '0'));
            $builder->where(array('DATE(pi.invoice_date)  >= ' => $start_date));
            $builder->where(array('DATE(pi.invoice_date)  <= ' => $end_date));
            $builder->groupBy('pi.id');
            $query = $builder->get();
            $sales_igst = $query->getResultArray(); 

            $builder = $db->table('sales_invoice pi');
            $builder->select('pi.id,ac.id as account_id,ac.name as party_name,pi.invoice_date as date,pi.tot_cgst as taxable');
            $builder->join('account ac', 'ac.id ='.$get['id']);
            $builder->where(array('pi.cgst_acc' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pi.is_delete' => '0'));
            $builder->where(array('pi.is_cancle' => '0'));
            $builder->where(array('DATE(pi.invoice_date)  >= ' => $start_date));
            $builder->where(array('DATE(pi.invoice_date)  <= ' => $end_date));
            $builder->groupBy('pi.id');
            $query = $builder->get();
            $sales_cgst = $query->getResultArray(); 

            $builder = $db->table('sales_invoice pi');
            $builder->select('pi.id,ac.id as account_id,ac.name as party_name,pi.invoice_date as date,pi.tot_sgst as taxable');
            $builder->join('account ac', 'ac.id ='.$get['id']);
            $builder->where(array('pi.sgst_acc' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pi.is_delete' => '0'));
            $builder->where(array('pi.is_cancle' => '0'));
            $builder->where(array('DATE(pi.invoice_date)  >= ' => $start_date));
            $builder->where(array('DATE(pi.invoice_date)  <= ' => $end_date));
            $builder->groupBy('pi.id');
            $query = $builder->get();
            $sales_sgst = $query->getResultArray();

            $sales['sales'] =  array_merge($sales_invoice,$sales_igst,$sales_cgst,$sales_sgst);

        }else{
            $sales['sales'] = array();
            $start_date = '';
            $end_date = '';
        }  
        $total_taxable = 0;
        foreach($sales['sales'] as $row) 
        {
           $total_taxable += $row['taxable']; 
        }
        $sales['total_taxable'] = $total_taxable;
        $sales['date']['from'] = $start_date;
        $sales['date']['to'] = $end_date;
        $sales['ac_id'] = $get['id'];

        return $sales;     
    }
    public function sales_ret_voucher_wise_data($get){

        $db = $this->db;
        $db->setDatabase(session('DataSource')); 
        
        if(!empty($get['year'])){

            $start = strtotime("{$get['year']}-{$get['month']}-01");
            $end = strtotime('-1 second', strtotime('+1 month', $start));
             
            $start_date = date('Y-m-d',$start);
            $end_date = date('Y-m-d',$end);
            
            $builder = $db->table('sales_return pi');
            $builder->select('pi.id,ac.id as account_id,ac.name as party_name,pi.return_date as date,pi.net_amount as taxable');
            $builder->join('account ac', 'ac.id =pi.account');
            $builder->where(array('pi.account' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pi.is_delete' => '0'));
            $builder->where(array('DATE(pi.return_date)  >= ' => $start_date));
            $builder->where(array('DATE(pi.return_date)  <= ' => $end_date));
            $builder->groupBy('pi.id');
            $query = $builder->get();
            $sales_return = $query->getResultArray();

            $builder = $db->table('sales_return pi');
            $builder->select('pi.id,ac.id as account_id,ac.name as party_name,pi.return_date as date,pi.tot_igst as taxable');
            $builder->join('account ac', 'ac.id ='.$get['id']);
            $builder->where(array('pi.igst_acc' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pi.is_delete' => '0'));
            $builder->where(array('DATE(pi.return_date)  >= ' => $start_date));
            $builder->where(array('DATE(pi.return_date)  <= ' => $end_date));
            $builder->groupBy('pi.id');
            $query = $builder->get();
            $sales_return_igst = $query->getResultArray();

            $builder = $db->table('sales_return pi');
            $builder->select('pi.id,ac.id as account_id,ac.name as party_name,pi.return_date as date,pi.tot_cgst as taxable');
            $builder->join('account ac', 'ac.id ='.$get['id']);
            $builder->where(array('pi.cgst_acc' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pi.is_delete' => '0'));
            $builder->where(array('DATE(pi.return_date)  >= ' => $start_date));
            $builder->where(array('DATE(pi.return_date)  <= ' => $end_date));
            $builder->groupBy('pi.id');
            $query = $builder->get();
            $sales_return_cgst = $query->getResultArray();

            $builder = $db->table('sales_return pi');
            $builder->select('pi.id,ac.id as account_id,ac.name as party_name,pi.return_date as date,pi.tot_sgst as taxable');
            $builder->join('account ac', 'ac.id ='.$get['id']);
            $builder->where(array('pi.sgst_acc' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pi.is_delete' => '0'));
            $builder->where(array('DATE(pi.return_date)  >= ' => $start_date));
            $builder->where(array('DATE(pi.return_date)  <= ' => $end_date));
            $builder->groupBy('pi.id');
            $query = $builder->get();
            $sales_return_sgst = $query->getResultArray();

            $sales['sales_ret'] =  array_merge($sales_return,$sales_return_igst,$sales_return_cgst,$sales_return_sgst);



        }else if(!empty(@$get['from'])){

            $start_date = @$get['from']  ? db_date($get['from']) : '';
            $end_date = @$get['to'] ? db_date($get['to']) : '';

            $builder = $db->table('sales_return pi');
            $builder->select('pi.id,ac.id as account_id,ac.name as party_name,pi.return_date as date,pi.net_amount as taxable');
            $builder->join('account ac', 'ac.id =pi.account');
            $builder->where(array('pi.account' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pi.is_delete' => '0'));
            $builder->where(array('DATE(pi.return_date)  >= ' => $start_date));
            $builder->where(array('DATE(pi.return_date)  <= ' => $end_date));
            $builder->groupBy('pi.id');
            $query = $builder->get();
            $sales_return = $query->getResultArray();

            $builder = $db->table('sales_return pi');
            $builder->select('pi.id,ac.id as account_id,ac.name as party_name,pi.return_date as date,pi.tot_igst as taxable');
            $builder->join('account ac', 'ac.id ='.$get['id']);
            $builder->where(array('pi.igst_acc' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pi.is_delete' => '0'));
            $builder->where(array('DATE(pi.return_date)  >= ' => $start_date));
            $builder->where(array('DATE(pi.return_date)  <= ' => $end_date));
            $builder->groupBy('pi.id');
            $query = $builder->get();
            $sales_return_igst = $query->getResultArray();

            $builder = $db->table('sales_return pi');
            $builder->select('pi.id,ac.id as account_id,ac.name as party_name,pi.return_date as date,pi.tot_cgst as taxable');
            $builder->join('account ac', 'ac.id ='.$get['id']);
            $builder->where(array('pi.cgst_acc' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pi.is_delete' => '0'));
            $builder->where(array('DATE(pi.return_date)  >= ' => $start_date));
            $builder->where(array('DATE(pi.return_date)  <= ' => $end_date));
            $builder->groupBy('pi.id');
            $query = $builder->get();
            $sales_return_cgst = $query->getResultArray();

            $builder = $db->table('sales_return pi');
            $builder->select('pi.id,ac.id as account_id,ac.name as party_name,pi.return_date as date,pi.tot_sgst as taxable');
            $builder->join('account ac', 'ac.id ='.$get['id']);
            $builder->where(array('pi.sgst_acc' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pi.is_delete' => '0'));
            $builder->where(array('DATE(pi.return_date)  >= ' => $start_date));
            $builder->where(array('DATE(pi.return_date)  <= ' => $end_date));
            $builder->groupBy('pi.id');
            $query = $builder->get();
            $sales_return_sgst = $query->getResultArray();

            $sales['sales_ret'] =  array_merge($sales_return,$sales_return_igst,$sales_return_cgst,$sales_return_sgst);
 

        }else{
            $sales['sales_ret'] = array();
            $start_date = '';
            $end_date = '';
        }   
        $total_taxable = 0;
        foreach($sales['sales_ret'] as $row) 
        {
           $total_taxable += $row['taxable']; 
        }
        $sales['total_taxable'] = $total_taxable;
        $sales['date']['from'] = $start_date;
        $sales['date']['to'] = $end_date;
        $sales['ac_id'] = $get['id'];

        return $sales;     
    }
    public function generalSales_liabi_voucher_wise_data($get){

        $db = $this->db;
        $db->setDatabase(session('DataSource')); 
        $purchase = array();

        if(!empty($get['year'])){

            $start = strtotime("{$get['year']}-{$get['month']}-01");
            $end = strtotime('-1 second', strtotime('+1 month', $start));
             
            $start_date = date('Y-m-d',$start);
            $end_date = date('Y-m-d',$end);

            $builder = $db->table('sales_ACparticu pp');
            $builder->select('ac.name as party_name,pg.invoice_date as date,pg.invoice_no as voucher_no ,pg.id as id ,pg.v_type as pg_type,pp.account as pp_acc,pg.net_amount as pg_amount,pg.disc_type,pg.discount,pg.amty,pg.amty_type');
            $builder->join('sales_ACinvoice pg', 'pg.id = pp.parent_id');
            $builder->join('account ac', 'ac.id = pp.account');
            $builder->where('pg.party_account',$get['id']);
            $builder->where(array('pp.is_delete' => '0'));
            $builder->where(array('pg.is_delete' => '0'));
            $builder->where(array('pg.is_cancle' => '0'));
            $builder->where(array('DATE(pg.invoice_date)  >= ' => $start_date));
            $builder->where(array('DATE(pg.invoice_date)  <= ' => $end_date));
            $builder->where('(pg.v_type="general" OR pg.v_type = "return")');
            $builder->groupBy('pg.id');
            $query = $builder->get();
            $sales_invoice = $query->getResultArray();

            $builder = $db->table('sales_ACparticu pp');
            $builder->select('ac.name as party_name,pg.invoice_date as date,pg.invoice_no as voucher_no ,pg.id as id ,pg.v_type as pg_type,pp.account as pp_acc,pg.tot_igst as pg_amount,pg.disc_type,pg.discount,pg.amty,pg.amty_type');
            $builder->join('sales_ACinvoice pg', 'pg.id = pp.parent_id');
            $builder->join('account ac', 'ac.id ='.$get['id']);
            $builder->where('pg.igst_acc',$get['id']);
            $builder->where(array('pp.is_delete' => '0'));
            $builder->where(array('pg.is_delete' => '0'));
            $builder->where(array('pg.is_cancle' => '0'));
            $builder->where(array('DATE(pg.invoice_date)  >= ' => $start_date));
            $builder->where(array('DATE(pg.invoice_date)  <= ' => $end_date));
            $builder->where('(pg.v_type="general" OR pg.v_type = "return")');
            $builder->groupBy('pg.id');
            $query = $builder->get();
            $sales_igst = $query->getResultArray();
            //print_r($sales_igst);exit;

            $builder = $db->table('sales_ACparticu pp');
            $builder->select('ac.name as party_name,pg.invoice_date as date,pg.invoice_no as voucher_no ,pg.id as id ,pg.v_type as pg_type,pp.account as pp_acc,pg.tot_cgst as pg_amount,pg.disc_type,pg.discount,pg.amty,pg.amty_type');
            $builder->join('sales_ACinvoice pg', 'pg.id = pp.parent_id');
            $builder->join('account ac', 'ac.id ='.$get['id']);
            $builder->where('pg.cgst_acc',$get['id']);
            $builder->where(array('pp.is_delete' => '0'));
            $builder->where(array('pg.is_delete' => '0'));
            $builder->where(array('pg.is_cancle' => '0'));
            $builder->where(array('DATE(pg.invoice_date)  >= ' => $start_date));
            $builder->where(array('DATE(pg.invoice_date)  <= ' => $end_date));
            $builder->where('(pg.v_type="general" OR pg.v_type = "return")');
            $builder->groupBy('pg.id');
            $query = $builder->get();
            $sales_cgst = $query->getResultArray();

            $builder = $db->table('sales_ACparticu pp');
            $builder->select('ac.name as party_name,pg.invoice_date as date,pg.invoice_no as voucher_no ,pg.id as id ,pg.v_type as pg_type,pp.account as pp_acc,pg.tot_sgst as pg_amount,pg.disc_type,pg.discount,pg.amty,pg.amty_type');
            $builder->join('sales_ACinvoice pg', 'pg.id = pp.parent_id');
            $builder->join('account ac', 'ac.id ='.$get['id']);
            $builder->where('pg.sgst_acc',$get['id']);
            $builder->where(array('pp.is_delete' => '0'));
            $builder->where(array('pg.is_delete' => '0'));
            $builder->where(array('pg.is_cancle' => '0'));
            $builder->where(array('DATE(pg.invoice_date)  >= ' => $start_date));
            $builder->where(array('DATE(pg.invoice_date)  <= ' => $end_date));
            $builder->where('(pg.v_type="general" OR pg.v_type = "return")');
            $builder->groupBy('pg.id');
            $query = $builder->get();
            $sales_sgst = $query->getResultArray();

            $sales['sales'] =  array_merge($sales_invoice,$sales_igst,$sales_cgst,$sales_sgst);


        }else if(!empty(@$get['from'])){

            $start_date = @$get['from']  ? db_date($get['from']) : '';
            $end_date = @$get['to'] ? db_date($get['to']) : '';

            $builder = $db->table('sales_ACparticu pp');
            $builder->select('ac.name as party_name,pg.invoice_date as date,pg.invoice_no as voucher_no ,pg.id as id ,pg.v_type as pg_type,pp.account as pp_acc,pg.net_amount as pg_amount,pg.disc_type,pg.discount,pg.amty,pg.amty_type');
            $builder->join('sales_ACinvoice pg', 'pg.id = pp.parent_id');
            $builder->join('account ac', 'ac.id = pp.account');
            $builder->where('pg.party_account',$get['id']);
            $builder->where(array('pp.is_delete' => '0'));
            $builder->where(array('pg.is_delete' => '0'));
            $builder->where(array('pg.is_cancle' => '0'));
            $builder->where(array('DATE(pg.invoice_date)  >= ' => $start_date));
            $builder->where(array('DATE(pg.invoice_date)  <= ' => $end_date));
            $builder->where('(pg.v_type="general" OR pg.v_type = "return")');
            $builder->groupBy('pg.id');
            $query = $builder->get();
            $sales_invoice = $query->getResultArray();

            $builder = $db->table('sales_ACparticu pp');
            $builder->select('ac.name as party_name,pg.invoice_date as date,pg.invoice_no as voucher_no ,pg.id as id ,pg.v_type as pg_type,pp.account as pp_acc,pg.tot_igst as pg_amount,pg.disc_type,pg.discount,pg.amty,pg.amty_type');
            $builder->join('sales_ACinvoice pg', 'pg.id = pp.parent_id');
            $builder->join('account ac', 'ac.id ='.$get['id']);
            $builder->where('pg.igst_acc',$get['id']);
            $builder->where(array('pp.is_delete' => '0'));
            $builder->where(array('pg.is_delete' => '0'));
            $builder->where(array('pg.is_cancle' => '0'));
            $builder->where(array('DATE(pg.invoice_date)  >= ' => $start_date));
            $builder->where(array('DATE(pg.invoice_date)  <= ' => $end_date));
            $builder->where('(pg.v_type="general" OR pg.v_type = "return")');
            $builder->groupBy('pg.id');
            $query = $builder->get();
            $sales_igst = $query->getResultArray();

            $builder = $db->table('sales_ACparticu pp');
            $builder->select('ac.name as party_name,pg.invoice_date as date,pg.invoice_no as voucher_no ,pg.id as id ,pg.v_type as pg_type,pp.account as pp_acc,pg.tot_cgst as pg_amount,pg.disc_type,pg.discount,pg.amty,pg.amty_type');
            $builder->join('sales_ACinvoice pg', 'pg.id = pp.parent_id');
            $builder->join('account ac', 'ac.id ='.$get['id']);
            $builder->where('pg.cgst_acc',$get['id']);
            $builder->where(array('pp.is_delete' => '0'));
            $builder->where(array('pg.is_delete' => '0'));
            $builder->where(array('pg.is_cancle' => '0'));
            $builder->where(array('DATE(pg.invoice_date)  >= ' => $start_date));
            $builder->where(array('DATE(pg.invoice_date)  <= ' => $end_date));
            $builder->where('(pg.v_type="general" OR pg.v_type = "return")');
            $builder->groupBy('pg.id');
            $query = $builder->get();
            $sales_cgst = $query->getResultArray();

            $builder = $db->table('sales_ACparticu pp');
            $builder->select('ac.name as party_name,pg.invoice_date as date,pg.invoice_no as voucher_no ,pg.id as id ,pg.v_type as pg_type,pp.account as pp_acc,pg.tot_sgst as pg_amount,pg.disc_type,pg.discount,pg.amty,pg.amty_type');
            $builder->join('sales_ACinvoice pg', 'pg.id = pp.parent_id');
            $builder->join('account ac', 'ac.id ='.$get['id']);
            $builder->where('pg.sgst_acc',$get['id']);
            $builder->where(array('pp.is_delete' => '0'));
            $builder->where(array('pg.is_delete' => '0'));
            $builder->where(array('pg.is_cancle' => '0'));
            $builder->where(array('DATE(pg.invoice_date)  >= ' => $start_date));
            $builder->where(array('DATE(pg.invoice_date)  <= ' => $end_date));
            $builder->where('(pg.v_type="general" OR pg.v_type = "return")');
            $builder->groupBy('pg.id');
            $query = $builder->get();
            $sales_sgst = $query->getResultArray();

            $sales['sales'] =  array_merge($sales_invoice,$sales_igst,$sales_cgst,$sales_sgst);

        }else{
            $sales['sales'] = array();
            $start_date = '';
            $end_date = '';
        }   
        $result['sales'] = array();
        $total = 0;
        $credit = 0;
        $debit = 0;
        if(!empty($sales['sales'])){
            foreach ($sales['sales'] as $row) {
       
               
                if($row['pg_type'] == 'general'){
                    ///$total += (float)$row['pg_amount'];
                    $credit += (float)$row['pg_amount'];
                }else{
                   // $total -= (float)$row['pg_amount'];
                    $debit  += (float)$row['pg_amount'];
                } 
                //$row['taxable'] = $total;
               // $result['purchase'][] = $row; 
              
            }
        }
        $result['sales'] = $sales['sales'];
        //$result['total_taxable'] = $total;
        $result['credit'] = $credit;
        $result['debit'] = $debit;
        $result['date']['from'] = $start_date;
        $result['date']['to'] = $end_date;
        $result['ac_id'] = $get['id'];

        // echo '<pre>';print_r($result);exit;
        return $result;     
    }
    public function currentassets_bankcash_voucher_Perwise($get){

        $db = $this->db;
        $db->setDatabase(session('DataSource')); 
       
        if(!empty($get['year'])){

            $start = strtotime("{$get['year']}-{$get['month']}-01");
            $end = strtotime('-1 second', strtotime('+1 month', $start));
             
            $start_date = date('Y-m-d',$start);
            $end_date = date('Y-m-d',$end);
            
            $builder = $db->table('bank_tras bt');
            $builder->select('bt.id,ac.id as account_id,ac.name as party_name,bt.receipt_date as date,bt.amount as taxable,bt.mode,bt.payment_type');
            $builder->join('account ac', 'ac.id =bt.particular');
            $builder->where(array('bt.particular' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('bt.is_delete' => '0'));
            $builder->where(array('DATE(bt.receipt_date)  >= ' => $start_date));
            $builder->where(array('DATE(bt.receipt_date)  <= ' => $end_date));
            $builder->groupBy('bt.id');
            $query = $builder->get();
            $bank_income['currentassets_banktrans'] = $query->getResultArray();     
            

        }else if(!empty(@$get['from'])){

            $start_date = @$get['from']  ? db_date($get['from']) : '';
            $end_date = @$get['to'] ? db_date($get['to']) : '';
            $builder = $db->table('bank_tras bt');
            $builder->select('bt.id,ac.id as account_id,ac.name as party_name,bt.receipt_date as date,bt.amount as taxable,bt.mode,bt.payment_type');
            $builder->join('account ac', 'ac.id =bt.particular');
            $builder->where(array('bt.particular' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('bt.is_delete' => '0'));
            $builder->where(array('DATE(bt.receipt_date)  >= ' => $start_date));
            $builder->where(array('DATE(bt.receipt_date)  <= ' => $end_date));
            $builder->groupBy('bt.id');
            $query = $builder->get();
            $bank_income['currentassets_banktrans'] = $query->getResultArray();  

        }else{
            $bank_income['currentassets_banktrans'] = array();
            $start_date = '';
            $end_date = '';
        }   

        $bank_income['date']['from'] = $start_date;
        $bank_income['date']['to'] = $end_date;
        $bank_income['ac_id'] = $get['id'];

        // echo '<pre>';print_r($bank_income);exit;

        return $bank_income;     
    }
    public function currentassets_jv_voucher_wise($get){

        $db = $this->db;
        $db->setDatabase(session('DataSource')); 
       
        if(!empty($get['year'])){

            $start = strtotime("{$get['year']}-{$get['month']}-01");
            $end = strtotime('-1 second', strtotime('+1 month', $start));
             
            $start_date = date('Y-m-d',$start);
            $end_date = date('Y-m-d',$end);
            
            $builder = $db->table('jv_particular jv');
            $builder->select('jm.id,jv.jv_id,jv.date,ac.id as account_id,jv.amount as taxable, ac.name as party_name,jv.dr_cr');
            $builder->join('account ac', 'ac.id =jv.particular');
            $builder->join('jv_main jm', 'jm.id =jv.jv_id');
            $builder->where(array('jv.particular' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('jm.is_delete' => '0'));
            $builder->where(array('jv   .is_delete' => '0'));
            $builder->where(array('DATE(jm.date)  >= ' => $start_date));
            $builder->where(array('DATE(jm.date)  <= ' => $end_date));
            $builder->groupBy('jv.id');
            $query = $builder->get();
            $jv_income['currentassets_jv'] = $query->getResultArray();

        }else if(!empty(@$get['from'])){

            $start_date = @$get['from']  ? db_date($get['from']) : '';
            $end_date = @$get['to'] ? db_date($get['to']) : '';

            $builder = $db->table('jv_particular jv');
            $builder->select('jm.id,jv.jv_id,jv.date,ac.id as account_id,jv.amount as taxable, ac.name as party_name,jv.dr_cr');
            $builder->join('account ac', 'ac.id =jv.particular');
            $builder->join('jv_main jm', 'jm.id =jv.jv_id');
            $builder->where(array('jv.particular' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('jm.is_delete' => '0'));
            $builder->where(array('jv.is_delete' => '0'));
            $builder->where(array('DATE(jm.date)  >= ' => $start_date));
            $builder->where(array('DATE(jm.date)  <= ' => $end_date));
            $builder->groupBy('jv.id');
            $query = $builder->get();
            $jv_income['currentassets_jv'] = $query->getResultArray();

        }else{

            $jv_income['currentassets_jv'] = array();
            $start_date = '';
            $end_date = '';
        }   

        $jv_income['date']['from'] = $start_date;
        $jv_income['date']['to'] = $end_date;
        $jv_income['ac_id'] = $get['id'];
        
        // echo '<pre>';print_r($bank_income);exit;
        return $jv_income;     
    }
    public function currentassets_bankcash_voucher_Acwise($get){

        $db = $this->db;
        $db->setDatabase(session('DataSource')); 
       
        if(!empty($get['year'])){

            $start = strtotime("{$get['year']}-{$get['month']}-01");
            $end = strtotime('-1 second', strtotime('+1 month', $start));
             
            $start_date = date('Y-m-d',$start);
            $end_date = date('Y-m-d',$end);
            
            $builder = $db->table('bank_tras bt');
            $builder->select('bt.id,ac.id as account_id,ac.name as party_name,bt.receipt_date as date,bt.amount as taxable,bt.mode,bt.payment_type');
            $builder->join('account ac', 'ac.id =bt.account');
            $builder->where(array('bt.account' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('bt.payment_type !=' => 'contra'));
            $builder->where(array('bt.is_delete' => '0'));
            $builder->where(array('DATE(bt.receipt_date)  >= ' => $start_date));
            $builder->where(array('DATE(bt.receipt_date)  <= ' => $end_date));
            $builder->groupBy('bt.id');
            $query = $builder->get();
            $bank_income['currentassets_banktrans'] = $query->getResultArray();     


        }else if(!empty(@$get['from'])){

            $start_date = @$get['from']  ? db_date($get['from']) : '';
            $end_date = @$get['to'] ? db_date($get['to']) : '';

            $builder = $db->table('bank_tras bt');
            $builder->select('bt.id,ac.id as account_id,ac.name as party_name,bt.receipt_date as date,bt.amount as total,bt.mode,bt.payment_type');
            $builder->join('account ac', 'ac.id =bt.particular');
            $builder->where(array('bt.particular' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('bt.is_delete' => '0'));
            $builder->where(array('bt.payment_type !=' => 'contra'));
            $builder->where(array('DATE(bt.receipt_date)  >= ' => $start_date));
            $builder->where(array('DATE(bt.receipt_date)  <= ' => $end_date));
            $builder->groupBy('bt.id');
            $query = $builder->get();
            $bank_income['currentassets_banktrans'] = $query->getResultArray();      

        }else{
            $bank_income['currentassets_banktrans'] = array();
            $start_date = '';
            $end_date = '';
        }   

        $bank_income['date']['from'] = $start_date;
        $bank_income['date']['to'] = $end_date;
        $bank_income['ac_id'] = $get['id'];
        // echo '<pre>';print_r($bank_income);exit;
        return $bank_income;     
    }
    public function currentassets_salesinvoice_voucher_wise($get){

        $db = $this->db;
        $db->setDatabase(session('DataSource')); 
       
        if(!empty($get['year'])){

            $start = strtotime("{$get['year']}-{$get['month']}-01");
            $end = strtotime('-1 second', strtotime('+1 month', $start));
             
            $start_date = date('Y-m-d',$start);
            $end_date = date('Y-m-d',$end);
            
            $builder = $db->table('sales_invoice si');
            $builder->select('si.id,si.invoice_date as date,ac.id as account_id,si.net_amount as taxable, ac.name as party_name');
            $builder->join('account ac', 'ac.id =si.account');
            $builder->where(array('si.account' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('si.is_delete' => '0'));
            $builder->where(array('si.is_cancle' => '0'));
            $builder->where(array('DATE(si.invoice_date)  >= ' => $start_date));
            $builder->where(array('DATE(si.invoice_date)  <= ' => $end_date));
            $builder->groupBy('si.id');
            $query = $builder->get();
            $sales_invoice['currentassets_salesinvoice'] = $query->getResultArray();

        }else if(!empty(@$get['from'])){

            $start_date = @$get['from']  ? db_date($get['from']) : '';
            $end_date = @$get['to'] ? db_date($get['to']) : '';

            $builder = $db->table('sales_invoice si');
            $builder->select('si.id,si.invoice_date as date,ac.id as account_id,si.net_amount as taxable, ac.name as party_name');
            $builder->join('account ac', 'ac.id =si.account');
            $builder->where(array('si.account' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('si.is_delete' => '0'));
            $builder->where(array('si.is_cancle' => '0'));
            $builder->where(array('DATE(si.invoice_date)  >= ' => $start_date));
            $builder->where(array('DATE(si.invoice_date)  <= ' => $end_date));
            $builder->groupBy('si.id');
            $query = $builder->get();
            $sales_invoice['currentassets_salesinvoice'] = $query->getResultArray();

        }else{

            $sales_invoice['currentassets_salesinvoice'] = array();
            $start_date = '';
            $end_date = '';
        }   

        $sales_invoice['date']['from'] = $start_date;
        $sales_invoice['date']['to'] = $end_date;
        $sales_invoice['ac_id'] = $get['id'];
        
        // echo '<pre>';print_r($bank_income);exit;
        return $sales_invoice;     
    }
    public function currentassets_salesreturn_voucher_wise($get){

        $db = $this->db;
        $db->setDatabase(session('DataSource')); 
       
        if(!empty($get['year'])){

            $start = strtotime("{$get['year']}-{$get['month']}-01");
            $end = strtotime('-1 second', strtotime('+1 month', $start));
             
            $start_date = date('Y-m-d',$start);
            $end_date = date('Y-m-d',$end);
            
            $builder = $db->table('sales_return si');
            $builder->select('si.id,si.return_date as date,ac.id as account_id,si.net_amount as taxable, ac.name as party_name');
            $builder->join('account ac', 'ac.id =si.account');
            $builder->where(array('si.account' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('si.is_delete' => '0'));
            $builder->where(array('DATE(si.return_date)  >= ' => $start_date));
            $builder->where(array('DATE(si.return_date)  <= ' => $end_date));
            $builder->groupBy('si.id');
            $query = $builder->get();
            $sales_return['currentassets_salesreturn'] = $query->getResultArray();

        }else if(!empty(@$get['from'])){

            $start_date = @$get['from']  ? db_date($get['from']) : '';
            $end_date = @$get['to'] ? db_date($get['to']) : '';

            $builder = $db->table('sales_return si');
            $builder->select('si.id,si.return_date as date,ac.id as account_id,si.net_amount as taxable, ac.name as party_name');
            $builder->join('account ac', 'ac.id =si.account');
            $builder->where(array('si.account' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('si.is_delete' => '0'));
            $builder->where(array('DATE(si.return_date)  >= ' => $start_date));
            $builder->where(array('DATE(si.return_date)  <= ' => $end_date));
            $builder->groupBy('si.id');
            $query = $builder->get();
            $sales_return['currentassets_salesreturn'] = $query->getResultArray();

        }else{

            $sales_return['currentassets_salesreturn'] = array();
            $start_date = '';
            $end_date = '';
        }   

        $sales_return['date']['from'] = $start_date;
        $sales_return['date']['to'] = $end_date;
        $sales_return['ac_id'] = $get['id'];
        
        // echo '<pre>';print_r($bank_income);exit;
        return $sales_return;     
    }
    public function currentassets_gnrl_sale_voucher_data($get){

        $db = $this->db;
        $db->setDatabase(session('DataSource')); 
       
        if(!empty($get['year'])){

            $start = strtotime("{$get['year']}-{$get['month']}-01");
            $end = strtotime('-1 second', strtotime('+1 month', $start));
             
            $start_date = date('Y-m-d',$start);
            $end_date = date('Y-m-d',$end);

            $builder = $db->table('sales_ACinvoice pg');
            $builder->select('pg.id,pg.invoice_date as date,ac.id as account_id,ac.name as party_name,pg.net_amount as taxable');
            $builder->join('account ac', 'ac.id = pg.party_account');
            $builder->where(array('pg.v_type' => "general"));
            $builder->where(array('pg.party_account' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pg.is_delete' => '0'));
            $builder->where(array('pg.is_cancle' => '0'));
            $builder->where(array('DATE(pg.invoice_date)  >= ' => db_date($start_date)));
            $builder->where(array('DATE(pg.invoice_date)  <= ' => db_date($end_date)));
            $builder->groupBy('pg.id');
            $query = $builder->get();
            $sales_invoice['currentassets_salesinvoice'] = $query->getResultArray();
        

        }else if(!empty(@$get['from'])){

            $start_date = @$get['from']  ? db_date($get['from']) : '';
            $end_date = @$get['to'] ? db_date($get['to']) : '';
            
            $builder = $db->table('sales_ACinvoice pg');
            $builder->select('pg.id,pg.invoice_date as date,ac.id as account_id,ac.name as party_name,pg.net_amount as taxable');
            $builder->join('account ac', 'ac.id = pg.party_account');
            $builder->where(array('pg.v_type' => "general"));
            $builder->where(array('pg.party_account' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pg.is_delete' => '0'));
            $builder->where(array('pg.is_cancle' => '0'));
            $builder->where(array('DATE(pg.invoice_date)  >= ' => db_date($start_date)));
            $builder->where(array('DATE(pg.invoice_date)  <= ' => db_date($end_date)));
            $builder->groupBy('pg.id');
            $query = $builder->get();
            $sales_invoice['currentassets_salesinvoice'] = $query->getResultArray();
            

        }else{

            $sales_invoice['currentassets_salesinvoice'] = array();
            $start_date = '';
            $end_date = '';
        }   

        $sales_invoice['date']['from'] = $start_date;
        $sales_invoice['date']['to'] = $end_date;
        $sales_invoice['ac_id'] = $get['id'];
        
        // echo '<pre>';print_r($bank_income);exit;
        return $sales_invoice;     
    }
    public function currentassets_gnrl_sale_rtn_voucher_wise($get){

        $db = $this->db;
        $db->setDatabase(session('DataSource')); 
       
        if(!empty($get['year'])){

            $start = strtotime("{$get['year']}-{$get['month']}-01");
            $end = strtotime('-1 second', strtotime('+1 month', $start));
             
            $start_date = date('Y-m-d',$start);
            $end_date = date('Y-m-d',$end);

            $builder = $db->table('sales_ACinvoice pg');
            $builder->select('pg.id,pg.invoice_date as date,ac.id as account_id,ac.name as party_name,pg.net_amount as taxable');
            $builder->join('account ac', 'ac.id = pg.party_account');
            $builder->where(array('pg.v_type' => "return"));
            $builder->where(array('pg.party_account' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pg.is_delete' => '0'));
            $builder->where(array('pg.is_cancle' => '0'));
            $builder->where(array('DATE(pg.invoice_date)  >= ' => db_date($start_date)));
            $builder->where(array('DATE(pg.invoice_date)  <= ' => db_date($end_date)));
            $builder->groupBy('pg.id');
            $query = $builder->get();
            $sales_invoice['currentassets_salesreturn'] = $query->getResultArray();
        

        }else if(!empty(@$get['from'])){

            $start_date = @$get['from']  ? db_date($get['from']) : '';
            $end_date = @$get['to'] ? db_date($get['to']) : '';
            
            $builder = $db->table('sales_ACinvoice pg');
            $builder->select('pg.id,pg.invoice_date as date,ac.id as account_id,ac.name as party_name,pg.net_amount as taxable');
            $builder->join('account ac', 'ac.id = pg.party_account');
            $builder->where(array('pg.v_type' => "return"));
            $builder->where(array('pg.party_account' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('pg.is_delete' => '0'));
            $builder->where(array('pg.is_cancle' => '0'));
            $builder->where(array('DATE(pg.invoice_date)  >= ' => db_date($start_date)));
            $builder->where(array('DATE(pg.invoice_date)  <= ' => db_date($end_date)));
            $builder->groupBy('pg.id');
            $query = $builder->get();
            $sales_invoice['currentassets_salesreturn'] = $query->getResultArray();
            

        }else{

            $sales_invoice['currentassets_salesreturn'] = array();
            $start_date = '';
            $end_date = '';
        }   

        $sales_invoice['date']['from'] = $start_date;
        $sales_invoice['date']['to'] = $end_date;
        $sales_invoice['ac_id'] = $get['id'];
        
        // echo '<pre>';print_r($bank_income);exit;
        return $sales_invoice;     
    }
    public function currentassets_contra_voucher_Perwise($get){

        $db = $this->db;
        $db->setDatabase(session('DataSource')); 
       
        if(!empty($get['year'])){

            $start = strtotime("{$get['year']}-{$get['month']}-01");
            $end = strtotime('-1 second', strtotime('+1 month', $start));
             
            $start_date = date('Y-m-d',$start);
            $end_date = date('Y-m-d',$end);
            
            $builder = $db->table('bank_tras ct');
            $builder->select('ct.id,ac.id as account_id,ac.name as party_name,ct.receipt_date as date,ct.amount as taxable,ct.narration');
            $builder->join('account ac', 'ac.id =ct.particular','left');
            $builder->where(array('ct.particular' => $get['id']));
            $builder->where(array('ct.payment_type' => 'contra'));
            $builder->where(array('ct.is_delete' => '0'));
            $builder->where(array('DATE(ct.receipt_date)  >= ' => $start_date));
            $builder->where(array('DATE(ct.receipt_date)  <= ' => $end_date));
            $builder->groupBy('ct.id');
            $query = $builder->get();
            $contra_trans['currentassets_contratrans'] = $query->getResultArray(); 
            
        }else if(!empty(@$get['from'])){

            $start_date = @$get['from']  ? db_date($get['from']) : '';
            $end_date = @$get['to'] ? db_date($get['to']) : '';

            $builder = $db->table('bank_tras ct');
            $builder->select('ct.id,ac.id as account_id,ac.name as party_name,ct.receipt_date as date,ct.amount as taxable,ct.narration');
            $builder->join('account ac', 'ac.id =ct.particular','left');
            $builder->where(array('ct.particular' => $get['id']));
            $builder->where(array('ct.payment_type' => 'contra'));
            $builder->where(array('ct.is_delete' => '0'));
            $builder->where(array('DATE(ct.receipt_date)  >= ' => $start_date));
            $builder->where(array('DATE(ct.receipt_date)  <= ' => $end_date));
            $builder->groupBy('ct.id');
            $query = $builder->get();
            $contra_trans['currentassets_contratrans'] = $query->getResultArray(); 


        }else{
            $contra_trans['currentassets_contratrans'] = array();
            $start_date = '';
            $end_date = '';
        }   

        $contra_trans['date']['from'] = $start_date;
        $contra_trans['date']['to'] = $end_date;
        $contra_trans['ac_id'] = $get['id'];
         
        return $contra_trans;     
    }
    public function currentassets_contra_voucher_Acwise($get){

        $db = $this->db;
        $db->setDatabase(session('DataSource')); 
       
        if(!empty($get['year'])){

            $start = strtotime("{$get['year']}-{$get['month']}-01");
            $end = strtotime('-1 second', strtotime('+1 month', $start));
             
            $start_date = date('Y-m-d',$start);
            $end_date = date('Y-m-d',$end);
            
            $builder = $db->table('bank_tras ct');
            $builder->select('ct.id,ac.id as account_id,ac.name as party_name,ct.receipt_date as date,ct.amount as taxable,ct.narration');
            $builder->join('account ac', 'ac.id =ct.account','left');
            $builder->where(array('ct.account' => $get['id']));
            //$builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('ct.is_delete' => '0'));
            $builder->where(array('ct.payment_type' => 'contra'));
            $builder->where(array('DATE(ct.receipt_date)  >= ' => $start_date));
            $builder->where(array('DATE(ct.receipt_date)  <= ' => $end_date));
            $builder->groupBy('ct.id');
            $query = $builder->get();
            $contra_trans['currentassets_ac_contratrans'] = $query->getResultArray(); 
            //echo $db->getLastQuery();exit;    


        }else if(!empty(@$get['from'])){

            $start_date = @$get['from']  ? db_date($get['from']) : '';
            $end_date = @$get['to'] ? db_date($get['to']) : '';

            $builder = $db->table('bank_tras ct');
            $builder->select('ct.id,ac.id as account_id,ac.name as party_name,ct.receipt_date as date,ct.amount as taxable,ct.narration');
            $builder->join('account ac', 'ac.id =ct.account','left');
            $builder->where(array('ct.account' => $get['id']));
            //$builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('ct.is_delete' => '0'));
            $builder->where(array('ct.payment_type' => 'contra'));
            $builder->where(array('DATE(ct.receipt_date)  >= ' => $start_date));
            $builder->where(array('DATE(ct.receipt_date)  <= ' => $end_date));
            $builder->groupBy('ct.id');
            $query = $builder->get();
            $contra_trans['currentassets_ac_contratrans'] = $query->getResultArray(); 

        }else{
            $contra_trans['currentassets_ac_contratrans'] = array();
            $start_date = '';
            $end_date = '';
        }   

        $contra_trans['date']['from'] = $start_date;
        $contra_trans['date']['to'] = $end_date;
        $contra_trans['ac_id'] = $get['id'];
         //echo '<pre>';print_r($contra_trans);exit;
        return $contra_trans;     
    }
    public function fixedassets_bankcash_voucher_Perwise($get){

        $db = $this->db;
        $db->setDatabase(session('DataSource')); 
       
        if(!empty($get['year'])){

            $start = strtotime("{$get['year']}-{$get['month']}-01");
            $end = strtotime('-1 second', strtotime('+1 month', $start));
             
            $start_date = date('Y-m-d',$start);
            $end_date = date('Y-m-d',$end);
            
            $builder = $db->table('bank_tras bt');
            $builder->select('bt.id,ac.id as account_id,ac.name as party_name,bt.receipt_date as date,bt.amount as taxable,bt.mode,bt.payment_type');
            $builder->join('account ac', 'ac.id =bt.particular');
            $builder->where(array('bt.particular' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('bt.is_delete' => '0'));
            $builder->where(array('DATE(bt.receipt_date)  >= ' => $start_date));
            $builder->where(array('DATE(bt.receipt_date)  <= ' => $end_date));
            $builder->groupBy('bt.id');
            $query = $builder->get();
            $bank_income['fixedassets_banktrans'] = $query->getResultArray();     


        }else if(!empty(@$get['from'])){

            $start_date = @$get['from']  ? db_date($get['from']) : '';
            $end_date = @$get['to'] ? db_date($get['to']) : '';

            $builder = $db->table('bank_tras bt');
            $builder->select('bt.id,ac.id as account_id,ac.name as party_name,bt.receipt_date as date,bt.amount as total,bt.mode,bt.payment_type');
            $builder->join('account ac', 'ac.id =bt.particular');
            $builder->where(array('bt.particular' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('bt.is_delete' => '0'));
            $builder->where(array('DATE(bt.receipt_date)  >= ' => $start_date));
            $builder->where(array('DATE(bt.receipt_date)  <= ' => $end_date));
            $builder->groupBy('bt.id');
            $query = $builder->get();
            $bank_income['fixedassets_banktrans'] = $query->getResultArray();      

        }else{
            $bank_income['fixedassets_banktrans'] = array();
            $start_date = '';
            $end_date = '';
        }   

        $bank_income['date']['from'] = $start_date;
        $bank_income['date']['to'] = $end_date;
        $bank_income['ac_id'] = $get['id'];
        // echo '<pre>';print_r($bank_income);exit;
        return $bank_income;     
    }
    public function fixedassets_jv_voucher_wise($get){

        $db = $this->db;
        $db->setDatabase(session('DataSource')); 
       
        if(!empty($get['year'])){

            $start = strtotime("{$get['year']}-{$get['month']}-01");
            $end = strtotime('-1 second', strtotime('+1 month', $start));
             
            $start_date = date('Y-m-d',$start);
            $end_date = date('Y-m-d',$end);
            
            $builder = $db->table('jv_particular jv');
            $builder->select('jv.id,jv.date,ac.id as account_id,jv.amount as taxable, ac.name as party_name,jv.dr_cr');
            $builder->join('account ac', 'ac.id =jv.particular');
            $builder->where(array('jv.particular' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('jv.is_delete' => '0'));
            $builder->where(array('DATE(jv.date)  >= ' => $start_date));
            $builder->where(array('DATE(jv.date)  <= ' => $end_date));
            $builder->groupBy('jv.id');
            $query = $builder->get();
            $jv_income['fixedassets_jv'] = $query->getResultArray();

        }else if(!empty(@$get['from'])){

            $start_date = @$get['from']  ? db_date($get['from']) : '';
            $end_date = @$get['to'] ? db_date($get['to']) : '';

            $builder = $db->table('jv_particular jv');
            $builder->select('jv.id,jv.date,ac.id as account_id,jv.amount as taxable, ac.name as party_name,jv.dr_cr');
            $builder->join('account ac', 'ac.id =jv.particular');
            $builder->where(array('jv.particular' => $get['id']));
            $builder->where(array('ac.is_delete' => '0'));
            $builder->where(array('jv.is_delete' => '0'));
            $builder->where(array('DATE(jv.date)  >= ' => $start_date));
            $builder->where(array('DATE(jv.date)  <= ' => $end_date));
            $builder->groupBy('jv.id');
            $query = $builder->get();
            $jv_income['fixedassets_jv'] = $query->getResultArray();

        }else{

            $jv_income['fixedassets_jv'] = array();
            $start_date = '';
            $end_date = '';
        }   

        $jv_income['date']['from'] = $start_date;
        $jv_income['date']['to'] = $end_date;
        $jv_income['ac_id'] = $get['id'];
        
        // echo '<pre>';print_r($bank_income);exit;
        return $jv_income;     
    }
    public function generalSales_voucher_wise_data($get){

        $db = $this->db;
        $db->setDatabase(session('DataSource')); 
        $purchase = array();

        if(!empty($get['year'])){

            $start = strtotime("{$get['year']}-{$get['month']}-01");
            $end = strtotime('-1 second', strtotime('+1 month', $start));
             
            $start_date = date('Y-m-d',$start);
            $end_date = date('Y-m-d',$end);
           
            $builder = $db->table('sales_ACparticu pp');
            $builder->select('ac.name as party_name,pg.invoice_date as date,pg.invoice_no as voucher_no,pg.id,pg.v_type as pg_type,pp.account as pp_acc,pp.sub_total,pp.added_amt');
            $builder->join('sales_ACinvoice pg', 'pg.id = pp.parent_id');
            $builder->join('account ac', 'ac.id = pp.account');
            // $builder->where('(pg.v_type="general" OR pg.v_type = "return")');
            $builder->where('pp.account',$get['id']);
            $builder->where(array('pp.is_delete' => '0'));
            $builder->where(array('pg.is_delete' => '0'));
            $builder->where(array('pg.is_cancle' => '0'));
            $builder->where(array('DATE(pg.invoice_date)  >= ' => $start_date));
            $builder->where(array('DATE(pg.invoice_date)  <= ' => $end_date));
            // $builder->groupBy('pp.id');
            $query = $builder->get();
            $pg_income['sales'] = $query->getResultArray();
            // echo $db->getLastQuery();exit;


        }else if(!empty(@$get['from'])){
            $start_date = @$get['from']  ? db_date($get['from']) : '';
            $end_date = @$get['to'] ? db_date($get['to']) : '';

            $builder = $db->table('sales_ACparticu pp');
            $builder->select('ac.name as party_name,pg.invoice_date as date,pg.invoice_no as voucher_no,pg.id,pg.v_type as pg_type,pp.account as pp_acc,pp.sub_total,pp.added_amt');
            $builder->join('sales_ACinvoice pg', 'pg.id = pp.parent_id');
            $builder->join('account ac', 'ac.id = pp.account');
            // $builder->where('(pg.v_type="general" OR pg.v_type = "return")');
            $builder->where('pp.account',$get['id']);
            $builder->where(array('pp.is_delete' => '0'));
            $builder->where(array('pg.is_delete' => '0'));
            $builder->where(array('pg.is_cancle' => '0'));
            $builder->where(array('DATE(pg.invoice_date)  >= ' => db_date($start_date)));
            $builder->where(array('DATE(pg.invoice_date)  <= ' => db_date($end_date)));
            // $builder->groupBy('pp.id');
            $query = $builder->get();
            $pg_income['sales'] = $query->getResultArray();
            // echo $db->getLastQuery();exit;
            // echo '<pre>';print_r($pg_income);exit;
        }else{
            $pg_income['sales'] = array();
            $start_date = '';
            $end_date = '';
        }   
     //echo '<pre>';print_r($pg_income);exit;
        $result['sales'] = array();
        $total = 0;
        if(!empty($pg_income['sales'])){
            foreach ($pg_income['sales'] as $row) {
       
                $total = $row['sub_total'] + $row['added_amt'];
                $row['taxable'] =  $total;
                $result['sales'][] = $row; 
            }
        }

        $result['date']['from'] = $start_date;
        $result['date']['to'] = $end_date;
        $result['ac_id'] = $get['id'];

        // echo '<pre>';print_r($result);exit;
        return $result;     
    }
    public function generalPurchase_voucher_wise_data($get){

        $db = $this->db;
        $db->setDatabase(session('DataSource')); 
        $purchase = array();

        if(!empty($get['year'])){

            $start = strtotime("{$get['year']}-{$get['month']}-01");
            $end = strtotime('-1 second', strtotime('+1 month', $start));
             
            $start_date = date('Y-m-d',$start);
            $end_date = date('Y-m-d',$end);

            $builder = $db->table('purchase_particu pp');
            $builder->select('acc.name as party_name,pg.doc_date as date,pg.invoice_no as voucher_no ,pg.id as id ,pg.v_type as pg_type,pp.account as pp_acc,pp.amount as pg_amount,pg.disc_type,pg.discount,pg.amty,pg.amty_type');
            $builder->join('purchase_general pg', 'pg.id = pp.parent_id');
            $builder->join('account ac', 'ac.id = pp.account');
            $builder->join('account acc', 'acc.id = pg.party_account');
            $builder->where('pp.account',$get['id']);
            $builder->where(array('pp.is_delete' => '0'));
            $builder->where(array('pg.is_delete' => '0'));
            $builder->where(array('pg.is_cancle' => '0'));
            $builder->where(array('DATE(pg.doc_date)  >= ' => $start_date));
            $builder->where(array('DATE(pg.doc_date)  <= ' => $end_date));
            $builder->where('(pg.v_type="general" OR pg.v_type = "return")');


            $builder->groupBy('pg.id');
            $query = $builder->get();
            $pg_expence['purchase'] = $query->getResultArray();

        }else if(!empty(@$get['from'])){

            $start_date = @$get['from']  ? db_date($get['from']) : '';
            $end_date = @$get['to'] ? db_date($get['to']) : '';

            $builder = $db->table('purchase_particu pp');
            $builder->select('ac.name as party_name,pg.doc_date as date,pg.invoice_no as voucher_no,pg.id,pg.v_type as pg_type,pp.account as pp_acc,pp.amount as pg_amount,pg.disc_type,pg.discount,pg.amty,pg.amty_type');
            $builder->join('purchase_general pg', 'pg.id = pp.parent_id');
            $builder->join('account ac', 'ac.id = pp.account');
            $builder->where('(pg.v_type="general" OR pg.v_type = "return")');
            $builder->where('pp.account',$get['id']);
            $builder->where(array('pp.is_delete' => '0'));
            $builder->where(array('pg.is_delete' => '0'));
            $builder->where(array('pg.is_cancle' => '0'));
            $builder->where(array('DATE(pg.doc_date)  >= ' => $start_date));
            $builder->where(array('DATE(pg.doc_date)  <= ' => $end_date));
            $builder->groupBy('pg.id');
            $query = $builder->get();
            $pg_expence['purchase'] = $query->getResultArray();

        }else{
            $pg_expence['purchase'] = array();
            $start_date = '';
            $end_date = '';
        }   
        $result['purchase'] = array();
        $total = 0;
        if(!empty($pg_expence['purchase'])){
            foreach ($pg_expence['purchase'] as $row) {
       
                $after_disc=0;
                
                if($row['disc_type'] == 'Fixed'){
                    $row['pg_amount'] = (float)$row['pg_amount'] -  (float)$row['discount'];
                    $after_disc =  $row['pg_amount'];
                }else{
                    $row['pg_amount'] = ((float)$row['pg_amount'] * ((float)$row['discount'] / 100));
                    $after_disc =  $row['pg_amount'];
                }
                
                if($row['amty_type'] == 'Fixed'){
                    $row['pg_amount'] = (float)$row['pg_amount'] + (float)$row['amty']; 
                }else{
                    $row['pg_amount'] = (float)$row['pg_amount'] + ((float)$after_disc * ((float)$row['amty'] / 100));
                }
        
               // $total += $row['pg_amount'];
                if($row['pg_type'] == 'general'){
                    $total += (float)$row['pg_amount'];
                }else{
                    $total -= (float)$row['pg_amount'];
                } 
                $row['taxable'] = $total;
                $result['purchase'][] = $row; 
            }
        }

        $result['date']['from'] = $start_date;
        $result['date']['to'] = $end_date;
        $result['ac_id'] = $get['id'];

        // echo '<pre>';print_r($result);exit;
        return $result;     
    }
   
}
?>