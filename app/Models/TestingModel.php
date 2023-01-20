<?php

namespace App\Models;
use CodeIgniter\Model;
use App\Models\GeneralModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class TestingModel extends Model
{
    public function get_hsn_core_data($type,$start_date='',$end_date=''){

        if($start_date == '') {
            if (date('m') <= '03') {
                $year = date('Y') - 1;
                $start_date = $year . '-04-01';
            } else {
                $year = date('Y');
                $start_date = $year . '-04-01';
            }
        }
        
        if($end_date == '') {
    
            if (date('m') <= '03') {
                $year = date('Y');
            } else {
                $year = date('Y') + 1;
            }
            $end_date = $year . '-03-31';
        }
        $db = $this->db;
        $db->setDatabase(session('DataSource'));
        if($type == "sales_invoice")
        {
            //print_r("jkdfhke");exit;
            $vch_type = "'sale_invoice' as vch_type" ;
           
            $builder =$db->table('sales_item si');
            //$builder->select('si.*,i.hsn,s.taxes,s.disc_type,s.discount,'.$vch_type);
            $builder->select('si.parent_id,s.invoice_date as date,si.taxability,si.type,si.item_id,si.uom,si.qty,si.rate,si.igst,si.igst_amt,si.cgst_amt,si.sgst_amt,si.item_disc, i.name,i.hsn, s.taxes,s.gst,s.custom_inv_no as cinv_no,ac.name as account_name,s.disc_type, s.discount,'.$vch_type);
            $builder->join('item i','i.id = si.item_id');
            $builder->join('sales_invoice s','s.id = si.parent_id');
            $builder->join('account ac','ac.id = s.account');
            $builder->where(array('si.type' => 'invoice'));
            $builder->where(array('si.is_delete' => 0));
            $builder->where(array('s.is_delete' => 0));
            $builder->where(array('s.is_cancle' => 0));
            $builder->where(array('DATE(s.invoice_date)  >= ' => $start_date));
            $builder->where(array('DATE(s.invoice_date)  <= ' => $end_date));
            $query = $builder->get();
            $invoice_item = $query->getResultArray();
            $data['sales'] = $invoice_item;
        }
        else
        {    
            $vch_type_ret = "'sale_return' as vch_type" ;
            $builder =$db->table('sales_item si');
            $builder->select('si.parent_id,s.return_date as date,si.taxability,si.type,si.item_id,si.uom,si.qty,si.rate,si.igst,si.igst_amt,si.cgst_amt,si.sgst_amt,si.item_disc, i.name,i.hsn, s.taxes,s.gst,s.supp_inv as cinv_no,ac.name as account_name,s.disc_type, s.discount,'.$vch_type_ret);
            $builder->join('item i','i.id = si.item_id');
            $builder->join('sales_return s','s.id = si.parent_id');
            $builder->join('account ac','ac.id = s.account');
            $builder->where(array('si.type' => 'return'));
            $builder->where(array('si.is_delete' => 0));
            $builder->where(array('s.is_delete' => 0));
            $builder->where(array('s.is_cancle' => 0));
            $builder->where(array('DATE(s.return_date)  >= ' => $start_date));
            $builder->where(array('DATE(s.return_date)  <= ' => $end_date));
            $query = $builder->get();
            $return_item = $query->getResultArray();
            $data['sales'] = $return_item;
        }

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        //$data = array_merge($invoice_item,$return_item);
        //echo '<pre>';Print_r($data);exit;
        
        return $data;
    }    
    
    public function test_xls_export_data($post)
    {

        $data = $this->get_hsn_core_data($post['type'],db_date($post['from']), db_date($post['to']));

         //echo "<pre>";print_r($data);exit;
       
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getActiveSheet()->getStyle('A1:B1')->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('2F75B5');

        $spreadsheet->getActiveSheet()->getStyle('A2:M2')->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('2F75B5');

        $spreadsheet->getActiveSheet()->getStyle('A4:M4')->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('F8CBAD');

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', 'Summary');
       

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A4', 'SI No');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('B4', 'Date');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C4', 'Voucher Type');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D4', 'Custome Inv No');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('E4', 'Account Name');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('F4', 'Taxability');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('G4', 'Type');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('H4', 'Item ID');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('I4', 'Item Name');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('J4', 'Uom');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('K4', 'QTY');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('L4', 'Rate');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('M4', 'Igst');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('N4', 'Igst Amount');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('O4', 'cgst Amount');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('P4', 'sgst Amount');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('Q4', 'Item Discount');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('R4', 'HSN');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('S4', 'Taxes');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('T4', 'Gst No');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('U4', 'Discount Type'); 
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('V4', 'Discount');
      

        $i = 5;
        // echo '<pre>';print_r($final_b2b);exit;
        foreach ($data['sales'] as $row) {

            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $i, @$row['parent_id']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $i, @$row['date']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $i, @$row['vch_type'] );
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $i, @$row['cinv_no']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $i, @$row['account_name']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $i, @$row['taxability']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $i, @$row['type']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $i, @$row['item_id']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $i, @$row['name']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('J' . $i, @$row['uom']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('K' . $i, @$row['qty']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('L' . $i, @$row['rate']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('M' . $i, @$row['igst']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('N' . $i, @$row['igst_amt']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('O' . $i, @$row['cgst_amt']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('P' . $i, @$row['sgst_amt']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('Q' . $i, @$row['item_disc']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('R' . $i, @$row['hsn']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('S' . $i, @$row['taxes']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('T' . $i, @$row['gst']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('U' . $i, @$row['disc_type']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('V' . $i, @$row['discount']);

            $i++;
        }

        $spreadsheet->getActiveSheet()->setTitle('core_hsn_data');
        //$objPHPExcel->getActiveSheet()->setTitle("Title");

        $spreadsheet->createSheet();

        $spreadsheet->setActiveSheetIndex(0);
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

    }
    public function insert_edit_shortcut_key($post)
    {
        $db = $this->db;
        $db->setDatabase(session('DataSource'));
        $builder = $db->table('shortcut_key');
        $builder->select('*');
        $builder->where(array("id" => $post['id']));
        $builder->limit(1);
        $result = $builder->get();
        $result_array = $result->getRow();
       
        $msg = array();

        $builder = $db->table('shortcut_key');
        $builder->select('*');
        $builder->where(array("key_char" => $post['key_char']));
        $builder->limit(1);
        $result = $builder->get();
        $result_array1 = $result->getRow();

        $builder = $db->table('shortcut_key');
        $builder->select('*');
        $builder->where(array("voucher_type" => $post['voucher_type']));
        $builder->limit(1);
        $result = $builder->get();
        $result_array2 = $result->getRow();

        if (!empty($result_array1)) {
            if ($result_array1->id != $post['id']) {
                $msg = array('st' => 'fail', 'msg' => "Key Already Used!!!");
                return $msg;
            }
        }
        if (!empty($result_array2)) {
            if ($result_array2->id != $post['id']) {
                $msg = array('st' => 'fail', 'msg' => "Key Already Set!!!");
                return $msg;
            }
        }
        
        $pdata = array(
            'key_char' => $post['key_char'],
            'key_code' => $post['key_code'],
            'voucher_type' => $post['voucher_type'],
        );
        if (!empty($result_array)) {

            $pdata['updated_at'] = date('Y-m-d H:i:s');
            $pdata['updated_by'] = session('uid');

            if(empty($msg)) {
                $builder = $db->table('shortcut_key');
                $builder->where(array("id" => $post['id']));
                $result = $builder->Update($pdata);
                if($result){
                    $msg = array('st' => 'success', 'msg' => "Your Details updated Successfully!!!");
                } else {
                    $msg = array('st' => 'fail', 'msg' => "Your Details Updated fail");
                }
            }   
        }
        else {
            
            $pdata['created_at'] = date('Y-m-d H:i:s');
            $pdata['created_by'] = session('uid');
            
            if (empty($msg)) {
                $result = $builder->Insert($pdata);
                $id = $db->insertID();
                if($result){
                    $msg = array('st' => 'success', 'msg' => "Your Details added Successfully!!!");
                } else {
                    $msg = array('st' => 'fail', 'msg' => "Your Details added fail");
                }   
            }
        }

        return $msg;
    }
    public function get_shortcutkey_data($get)
    {
        $dt_search = $dt_col = array(
            "bt.id",
            "bt.key_char",
            "bt.key_code",
            "bt.voucher_type",
           
        );

        $filter = $get['filter_data'];
        $tablename = "shortcut_key bt";
        $where = '';
    
        $where .= " and is_delete=0";
       
        $rResult = getManagedData($tablename, $dt_col, $dt_search, $where);
        $sEcho = $rResult['draw'];

        $encode = array();
        //$statusarray = array("1" => "Activate", "0" => "Deactivate");

        foreach ($rResult['table'] as $row) {
            $DataRow = array();
            
            $btnedit = '<a   href="' . url('Bank/add_banktrans/') . $row['id'] . '"  data-title="Edit Receipt: "' . $row['id'] . '" class="btn btn-link pd-10"><i class="far fa-edit"></i></a> ';
            $btndelete = '<a data-toggle="modal" target="_blank"   title="Receipt No: ' . $row['id'] . '"  onclick="editable_remove(this)"  data-val="' . $row['id'] . '"  data-pk="' . $row['id'] . '" tabindex="-1" class="btn btn-link pd-10"><i class="far fa-trash-alt"></i></a> ';
            //  $status= '<a  tabindex="-1" onclick="editable_os(this)"  data-val="'.$row['id'].'"  data-pk="'.$row['id'].'" >'.$statusarray[$row['status']].'</a>';
            $btn = $btnedit . $btndelete;

            $DataRow[] = $row['id'];
            $DataRow[] = $row['key_char'];
            $DataRow[] = $row['key_code'];
            $DataRow[] = $row['voucher_type'];
            $DataRow[] = $btn;

            $encode[] = $DataRow;
        }

        $json = json_encode($encode);
        echo '{ "draw": ' . intval($sEcho) . ',"recordsTotal": ' . $rResult['total'] . ',"recordsFiltered": ' . $rResult['total'] . ',"data":' . $json . '}';
        exit;
    }

     // jv management grouping by party updated by 19-01-2023
     public function jv_invoice_list($post)
    {

        $start = strtotime("{$post['year']}-{$post['month']}-01");
        $end = strtotime('-1 second', strtotime('+1 month', $start));
        $start_date = date('Y-m-d', $start);
        $end_date = date('Y-m-d', $end);

        $db = $this->db;
        $db->setDatabase(session('DataSource'));
        
        $builder = $db->table('jv_management jm');
        $builder->select('jm.party_account,ac.name as party_account_name');
        $builder->join('account ac', 'ac.id = jm.party_account');
        if (!empty($post['month'])) {
            $builder->where(array('DATE(jm.invoice_date)  >= ' => $start_date));
            $builder->where(array('DATE(jm.invoice_date)  <= ' => $end_date));
        }
        $builder->where(array("jm.type" => 'invoice'));
        $builder->groupBy('jm.party_account');
        $result = $builder->get();
        $party_list = $result->getResultArray();
        $invoice_list = array();
        foreach($party_list as $row)
        {
            $builder = $db->table('jv_management jm');
            $builder->select('SUM(jm.amount) as total');
            if (!empty($post['month'])) {
                $builder->where(array('DATE(jm.invoice_date)  >= ' => $start_date));
                $builder->where(array('DATE(jm.invoice_date)  <= ' => $end_date));
            }
            $builder->where(array("jm.type" => 'invoice',"jm.party_account" => $row['party_account']));
            $result = $builder->get();
            $party_total = $result->getRowArray();
            $row['total'] = $party_total['total'];
            $invoice_list[] = $row;
            
        }
        $data['invoice_list'] = $invoice_list;
        $return_list = array();
        $builder = $db->table('jv_management jm');
        $builder->select('jm.party_account,ac.name as party_account_name');
        $builder->join('account ac', 'ac.id = jm.party_account');
        if (!empty($post['month'])) {
            $builder->where(array('DATE(jm.invoice_date)  >= ' => $start_date));
            $builder->where(array('DATE(jm.invoice_date)  <= ' => $end_date));
        }
        $builder->where(array("jm.type" => 'return'));
        $builder->groupBy('jm.party_account');
        $result = $builder->get();
        $party_list = $result->getResultArray();

        foreach($party_list as $row)
        {
            $builder = $db->table('jv_management jm');
            $builder->select('SUM(jm.amount) as total');
            if (!empty($post['month'])) {
                $builder->where(array('DATE(jm.invoice_date)  >= ' => $start_date));
                $builder->where(array('DATE(jm.invoice_date)  <= ' => $end_date));
            }
            $builder->where(array("jm.type" => 'return',"jm.party_account" => $row['party_account']));
            $result = $builder->get();
            $party_total = $result->getRowArray();
            $row['total'] = $party_total['total'];
            $return_list[] = $row;
            
        }
        $data['return_list'] = $return_list;

        $data['month'] = $post['month'];
        $data['year'] = $post['year'];
        return $data;
    }
    public function add_jv_invoice($post)
    {
       // echo '<pre>';Print_r($post);exit;
        
        $start = strtotime("{$post['year']}-{$post['month']}-01");
        $end = strtotime('-1 second', strtotime('+1 month', $start));
        $start_date = date('Y-m-d', $start);
        $end_date = date('Y-m-d', $end);
        $db = $this->db;
        $db->setDatabase(session('DataSource'));
        
        foreach($post['invoice'] as $account)
        {
            $builder = $db->table('jv_management jm');
            $builder->select('jm.*');
            if (!empty($post['month'])) {
                $builder->where(array('DATE(jm.invoice_date)  >= ' => $start_date));
                $builder->where(array('DATE(jm.invoice_date)  <= ' => $end_date));
            }
            $builder->where(array("jm.type" => 'invoice',"jm.party_account" => $account));
            $result = $builder->get();
            $invoice_list = $result->getResultArray();
            //echo '<pre>';Print_r($invoice_list);
            $jv_array = array();
            $party_total = 0;
            foreach ($invoice_list as $row) {
                if ($row['jv_pass'] == 1) {
                    $jv_array[] = 1;
                } else {
                    $jv_array[] = 0;
                }
                $party_total += $row['amount'];
            }
            $gnmodel = new GeneralModel();
            if (in_array("1", $jv_array)) { 
                
               foreach($invoice_list as $row)
               {
                    $jv_data = $gnmodel->get_data_table('jv_particular',array('jv_id'=>$row['jv_id'],'dr_cr'=>'cr'),'particular'); 
                    $post['credit_party_account'] = $jv_data['particular'];

               }
               $jv_id = $invoice_list[0]['jv_id'];
               //$post['credit_party_account'] = $invoice_list[0]['particular'];
               $total_amt = 0;
               
               $pdata['update_at'] = date('Y-m-d H:i:s');
               $pdata['update_by'] = session('uid');;
               
               $builder_main = $db->table('jv_main');
               $builder_main->where(array("id" => $jv_id));
               $result = $builder_main->Update($pdata);
               foreach($invoice_list as $row)
               {
                   if($row['jv_pass'] == 1)
                   {
                       if($row['is_update']==1 && $row['is_cancle']!=1 && $row['is_delete']!=1)
                       {
                           $invoice = $gnmodel->get_data_table('sales_invoice',array('id'=>$row['invoice_no']),'net_amount'); 
                           $total_amt += $invoice['net_amount'];
                           $update_at = date('Y-m-d H:i:s');
                           $update_by = session('uid');;
                           $result1 = $gnmodel->update_data_table('jv_management', array('invoice_no' => $row['invoice_no'],'type'=>"invoice"), array('amount' => $invoice['net_amount'],'is_update'=>0,'updated_at'=>$update_at,'updated_by'=>$update_by));            
                       }
                       elseif($row['is_update']==1 && ($row['is_cancle']==1 || $row['is_delete']==1))
                       {
                           $total_amt += 0;
                       }
                       else
                       {
                           $total_amt += $row['amount'];
                       }
                   }
                   else
                   {
                        $result_jv = $gnmodel->update_data_table('jv_management', array('id' => $row['id']), array('jv_pass' => '1', 'jv_id' => $id,'created_at'=>$created_at,'created_by'=>$created_by));
                      
                       $total_amt += $row['amount'];
                   }
                   
               }
               $update_jv_parti = $gnmodel->update_data_table('jv_particular', array("jv_id" => $jv_id,'dr_cr'=> "dr",'particular'=> $account), array('amount' => $total_amt,'update_at'=>date('Y-m-d H:i:s'),'update_by' => session('uid')));
               $update_jv_parti1 = $gnmodel->update_data_table('jv_particular', array("jv_id" => $jv_id,'dr_cr'=> "cr",'particular'=> @$post['credit_party_account']), array('amount' => $total_amt,'update_at'=>date('Y-m-d H:i:s'),'update_by' => session('uid')));
                $log_data = array(
                    'jv_id' => $jv_id,
                    'invoice_type' => "invoice",
                    'log_date' => date('Y-m-d H:i:s'),
                    'log_type' => "update",
                    'account' =>  $account,
                    'month_year' => $post['month'].'-'.$post['year'],
                    'amount' => @$total_amt,
                );
                $data = $this-> add_jv_invoice_log($log_data);
                if ($result AND $update_jv_parti) {
                    $msg = array('st' => 'success', 'msg' => "Your Details Updated Successfully!!!");
                } else {
                    $msg = array('st' => 'fail', 'msg' => "Your Details Updated fail");
                }  

            } else {
                if (empty($post['credit_party_account'])) {
                    $msg = array('st' => 'fail', 'msg' => "Please select Particular");
                    return $msg;
                }
                $pdata = array(
                    'date' => date('Y-m-d'),
                    'narration' => @$post['narration'],
                );
                $pdata['created_at'] = date('Y-m-d H:i:s');
                $pdata['created_by'] = session('uid');
                $builder_main = $db->table('jv_main');
                $result = $builder_main->Insert($pdata);

                $id = $db->insertID();

                $data = array(
                    'jv_id' => $id,
                    'date' => date('Y-m-d'),
                    'dr_cr' => "dr",
                    'particular' => @$account,
                    'method' => 'on_account',
                    'amount' => @$party_total,
                    'other' => '',
                    'stat_adj' => '',
                    'invoice' => '',
                    'invoice_tb' => '',
                );
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['created_by'] = session('uid');
                //echo '<pre>';Print_r($data);exit;
                
                $builder_parti = $db->table('jv_particular');
                $result_parti_dr = $builder_parti->Insert($data);

                $data1 = array(
                    'jv_id' => $id,
                    'date' => date('Y-m-d'),
                    'dr_cr' => "cr",
                    'particular' => @$post['credit_party_account'],
                    'method' => '',
                    'amount' => @$party_total,
                    'other' => '',
                    'stat_adj' => '',
                    'invoice' => '',
                    'invoice_tb' => '',
                );
                $data1['created_at'] = date('Y-m-d H:i:s');
                $data1['created_by'] = session('uid');
                $builder_parti = $db->table('jv_particular');
                $result_parti_cr = $builder_parti->Insert($data1);

              
                // echo $db->getLastQuery();exit;


                $log_data = array(
                    'jv_id' => $id,
                    'invoice_type' => "invoice",
                    'log_date' => date('Y-m-d H:i:s'),
                    'log_type' => "insert",
                    'account' =>  @$account,
                    'month_year' => $post['month'].'-'.$post['year'],
                    'amount' => @$party_total,
                );
                $data_log = $this-> add_jv_invoice_log($log_data);

              
                foreach($invoice_list as $row2)
                {
                    $created_at = date('Y-m-d H:i:s');
                    $created_by = session('uid');
                    $result_jv = $gnmodel->update_data_table('jv_management', array('id' => $row2['id']), array('jv_pass' => '1', 'jv_id' => $id,'created_at'=>$created_at,'created_by'=>$created_by));
                }
                if ($result and $result_parti_dr and $result_parti_cr) {
                    $msg = array('st' => 'success', 'msg' => "Your Details Added Successfully!!!");
                } else {
                    $msg = array('st' => 'fail', 'msg' => "Your Details Added fail");
                }
            }
                      
        }
        return $msg;
        //exit;
    }
    public function add_jv_return($post)
    {
        $start = strtotime("{$post['year']}-{$post['month']}-01");
        $end = strtotime('-1 second', strtotime('+1 month', $start));
        $start_date = date('Y-m-d', $start);
        $end_date = date('Y-m-d', $end);
        $db = $this->db;
        $db->setDatabase(session('DataSource'));
        
        foreach($post['return'] as $account)
        {
            $builder = $db->table('jv_management jm');
            $builder->select('jm.*');
            if (!empty($post['month'])) {
                $builder->where(array('DATE(jm.invoice_date)  >= ' => $start_date));
                $builder->where(array('DATE(jm.invoice_date)  <= ' => $end_date));
            }
            $builder->where(array("jm.type" => 'return',"jm.party_account" => $account));
            $result = $builder->get();
            $return_list = $result->getResultArray();
            //echo '<pre>';Print_r($invoice_list);
            $jv_array = array();
            $party_total = 0;
            foreach ($return_list as $row) {
                if ($row['jv_pass'] == 1) {
                    $jv_array[] = 1;
                } else {
                    $jv_array[] = 0;
                }
                $party_total += $row['amount'];
            }
            $gnmodel = new GeneralModel();
            if (in_array("1", $jv_array)) { 
                
               foreach($return_list as $row)
               {
                    $jv_data = $gnmodel->get_data_table('jv_particular',array('jv_id'=>$row['jv_id'],'dr_cr'=>'cr'),'particular'); 
                    $post['debit_party_account'] = $jv_data['particular'];

               }
               $jv_id = $return_list[0]['jv_id'];
               $total_amt = 0;
               
               $pdata['update_at'] = date('Y-m-d H:i:s');
               $pdata['update_by'] = session('uid');
               
               $builder_main = $db->table('jv_main');
               $builder_main->where(array("id" => $jv_id));
               $result = $builder_main->Update($pdata);
               foreach($return_list as $row)
               {
                   if($row['jv_pass'] == 1)
                   {
                       if($row['is_update']==1 && $row['is_cancle']!=1 && $row['is_delete']!=1)
                       {
                           $invoice = $gnmodel->get_data_table('sales_return',array('id'=>$row['invoice_no']),'net_amount'); 
                           $total_amt += $invoice['net_amount'];
                           $updated_at = date('Y-m-d H:i:s');
                           $updated_by = session('uid');
                           $result1 = $gnmodel->update_data_table('jv_management', array('invoice_no' => $row['invoice_no'],'type'=>"return"), array('amount' => $invoice['net_amount'],'is_update'=>0,'updated_at'=>$updated_at,'updated_by'=>$updated_by));            
                       }
                       elseif($row['is_update']==1 && ($row['is_cancle']==1 || $row['is_delete']==1))
                       {
                           $total_amt += 0;
                       }
                       else
                       {
                           $total_amt += $row['amount'];
                       }
                   }
                   else
                   {
                       $result_jv = $gnmodel->update_data_table('jv_management', array('id' => $row['id']), array('jv_pass' => '1', 'jv_id' => $id,'created_at'=>$created_at,'created_by'=>$created_by));
                       $total_amt += $row['amount'];
                   }
                   
               }
               $update_jv_parti = $gnmodel->update_data_table('jv_particular', array("jv_id" => $jv_id,'dr_cr'=> "cr",'particular'=> $account), array('amount' => $total_amt,'update_at'=>date('Y-m-d H:i:s'),'update_by' => session('uid')));
               $update_jv_parti1 = $gnmodel->update_data_table('jv_particular', array("jv_id" => $jv_id,'dr_cr'=> "dr",'particular'=> @$post['debit_party_account']), array('amount' => $total_amt,'update_at'=>date('Y-m-d H:i:s'),'update_by' => session('uid')));
            
                $log_data = array(
                    'jv_id' => $jv_id,
                    'invoice_type' => "invoice",
                    'log_date' => date('Y-m-d H:i:s'),
                    'log_type' => "update",
                    'account' =>  $account,
                    'month_year' => $post['month'].'-'.$post['year'],
                    'amount' => @$total_amt,
                );
                $data = $this-> add_jv_invoice_log($log_data);
                if ($result AND $result2) {
                    $msg = array('st' => 'success', 'msg' => "Your Details Updated Successfully!!!");
                } else {
                    $msg = array('st' => 'fail', 'msg' => "Your Details Updated fail");
                }  

            } else {
                if (empty($post['debit_party_account'])) {
                    $msg = array('st' => 'fail', 'msg' => "Please select Particular");
                    return $msg;
                }
                $pdata = array(
                    'date' => date('Y-m-d'),
                    'narration' => @$post['narration'],
                );
                $pdata['created_at'] = date('Y-m-d H:i:s');
                $pdata['created_by'] = session('uid');
                $builder_main = $db->table('jv_main');
                $result = $builder_main->Insert($pdata);
                $id = $db->insertID();

                
                $data = array(
                    'jv_id' => $id,
                    'date' => date('Y-m-d'),
                    'dr_cr' => "cr",
                    'particular' => @$account,
                    'method' => 'on_account',
                    'amount' => @$party_total,
                    'other' => '',
                    'stat_adj' => '',
                    'invoice' => '',
                    'invoice_tb' => '',
                );
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['created_by'] = session('uid');
                //echo '<pre>';Print_r($data);exit;
                
                $builder_parti = $db->table('jv_particular');
                $result_parti_dr = $builder_parti->Insert($data);

                $data1 = array(
                    'jv_id' => $id,
                    'date' => date('Y-m-d'),
                    'dr_cr' => "dr",
                    'particular' => @$post['debit_party_account'],
                    'method' => '',
                    'amount' => @$party_total,
                    'other' => '',
                    'stat_adj' => '',
                    'invoice' => '',
                    'invoice_tb' => '',
                );
                $data1['created_at'] = date('Y-m-d H:i:s');
                $data1['created_by'] = session('uid');
                $builder_parti = $db->table('jv_particular');
                $result_parti_cr = $builder_parti->Insert($data1);

                $log_data = array(
                    'jv_id' => $id,
                    'invoice_type' => "return",
                    'log_date' => date('Y-m-d H:i:s'),
                    'log_type' => "insert",
                    'account' =>  @$account,
                    'month_year' => $post['month'].'-'.$post['year'],
                    'amount' => @$party_total,
                );
                $data_log = $this-> add_jv_invoice_log($log_data);
                
                foreach($return_list as $row2)
                {
                    $created_at = date('Y-m-d H:i:s');
                    $created_by = session('uid');
                    $result_jv = $gnmodel->update_data_table('jv_management', array('id' => $row2['id']), array('jv_pass' => '1', 'jv_id' => $id,'created_at'=>$created_at,'created_by'=>$created_by));
                }
                if ($result and $result_parti_dr and $result_parti_cr) {
                    $msg = array('st' => 'success', 'msg' => "Your Details Added Successfully!!!");
                } else {
                    $msg = array('st' => 'fail', 'msg' => "Your Details Added fail");
                }
            }    
        }
        return $msg;
    }
    public function add_jv_invoice_log($log_data)
    {
        //echo '<pre>';Print_r($log_data);exit;
        $db = $this->db;
        $db->setDatabase(session('DataSource'));
        $builder = $db->table('jv_management_log');
        $log_data['created_at'] = date('Y-m-d H:i:s');
        $log_data['created_by'] = session('uid');
        $result = $builder->Insert($log_data);
        if ($result) {
            $msg = array('st' => 'success', 'msg' => "Your Details Added Successfully!!!");
        } else {
            $msg = array('st' => 'fail', 'msg' => "Your Details Added fail");
        }
        return $msg;
    }
    public function Jv_management_log($get){
        //echo '<pre>';Print_r("vkjfhvkj");exit;
        
        $dt_search = array(
            "gl.id",
            "gl.jv_id",
            "(select name from account ac where gl.account = ac.id)",
            "gl.log_date",
            "gl.invoice_type",
            "gl.log_type",
            "gl.amount",
        );
        $dt_col = array(
            "gl.id",
            "gl.jv_id",
            "gl.account",
            "(select name from account ac where gl.account = ac.id) as account_name",
            "gl.log_date",
            "gl.invoice_type",
            "gl.log_type",
            "gl.amount",
        );
        
        $filter = $get['filter_data'];
        $tablename = "jv_management_log gl";
        $where = '';
        // if ($filter != '' && $filter != 'undefined') {
        //     $where .= ' and UserType ="' . $filter . '"';
        // }
       // $where .= " and is_delete=0";
    
        $rResult = getManagedData($tablename, $dt_col, $dt_search, $where);
        $sEcho = $rResult['draw'];
    
        $encode = array();
        foreach ($rResult['table'] as $row) {

            $btnview = '<a href="' . url('Testing/party_invoice_list/') . $row['jv_id'] . '"    class="btn btn-link pd-6"><i class="far fa-eye"></i></a> ';
           
            $DataRow = array();
            $DataRow[] = $row['id'];
            $DataRow[] = $row['jv_id'];
            $DataRow[] = '<a href="' . url('Bank/add_jvparticular') .'/'.$row['jv_id'] . '" >'.$row['account_name'].'</a> ';
            $DataRow[] = $row['invoice_type'];
            $DataRow[] = user_date($row['log_date']);
            $DataRow[] = $row['log_type'];
            $DataRow[] = $row['amount'];
            $DataRow[] = $btnview;
    
        $encode[] = $DataRow;
        }
        $json = json_encode($encode);
        echo '{ "draw": ' . intval($sEcho) . ',"recordsTotal": ' . $rResult['total'] . ',"recordsFiltered": ' . $rResult['total'] . ',"data":' . $json . '}';
        exit;
    
    }
    public function get_partyinvoice_data($get){
        //echo '<pre>';Print_r("vkjfhvkj");exit;
        
        $dt_search = array(
            "gl.id",
            "gl.jv_id",
            "(select name from account ac where gl.party_account = ac.id)",
            "gl.invoice_no",
            "gl.type",
            "gl.invoice_date",
            "gl.amount",
            "gl.jv_pass",
        );
        $dt_col = array(
            "gl.id",
            "gl.jv_id",
            "(select name from account ac where gl.party_account = ac.id) as account_name",
            "gl.invoice_no",
            "gl.type",
            "gl.invoice_date",
            "gl.amount",
            "gl.jv_pass",
        );
        
        $filter = $get['filter_data'];
        $tablename = "jv_management gl";
        $where = '';
        if ($filter != '' && $filter != 'undefined') {
            $where .= ' and jv_id ="' . $filter . '"';
        }
        //$where .= " and gl.jv_pass = 1";
    
        $rResult = getManagedData($tablename, $dt_col, $dt_search, $where);
        $sEcho = $rResult['draw'];
    
        $encode = array();
        foreach ($rResult['table'] as $row) {
            $DataRow = array();
            $DataRow[] = $row['id'];
            $DataRow[] = $row['jv_id'];
            $DataRow[] = $row['account_name'];
            $DataRow[] = $row['invoice_no'];
            $DataRow[] = $row['type'];
            $DataRow[] = user_date($row['invoice_date']);
            $DataRow[] = $row['amount'];
            //$DataRow[] = '';
    
        $encode[] = $DataRow;
        }
        $json = json_encode($encode);
        echo '{ "draw": ' . intval($sEcho) . ',"recordsTotal": ' . $rResult['total'] . ',"recordsFiltered": ' . $rResult['total'] . ',"data":' . $json . '}';
        exit;
    
    }
    // public function get_partyinvoice_data()
    // {

    // }
}