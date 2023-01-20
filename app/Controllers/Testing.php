<?php 

namespace App\Controllers;
use App\Models\TestingModel;
use App\Models\GeneralModel;

class Testing extends BaseController{
    
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger){
                
        parent::initController($request, $response, $logger);
        header("Access-Control-Allow-Origin: * ");
        header("Access-Control-Allow-Methods: *");
        header("Access-Control-Allow-Headers: * ");
        $this->model = new TestingModel();
        $this->gmodel = new GeneralModel();
        
    }
    public function hsn_core_data(){
        if (!session('uid')) {
            return redirect()->to(url('Auth'));
        }
        $type = '';
        $post = $this->request->getPost();
        if(!empty($post))
        {
            $type = $post['type'];
            $start_date = $post['from'];
            $end_date = $post['to'];
            $data['from'] = $start_date;
            $data['to'] = $end_date;
            $data['invoice_data'] = $this->model->get_hsn_core_data($type,$start_date,$end_date);
        }
        else
        {
            $data['from'] =  session('financial_form');
            $data['to'] = session('financial_to');
        }
        $data['type'] = $type;
        $data['title']="Core HSN Data";
        
		return view('testing/core_hsn_data',$data);
    }
    public function hsn_core_xls_export(){

        if (!session('uid')) {
            return redirect()->to(url('auth'));
        } 
        ini_set('max_execution_time', 900);
        ini_set('memory_limit', '-1');
        ini_set('mysql.connect_timeout', 300);
        ini_set('default_socket_timeout', 300);

        $post = $this->request->getGet();
       
        if(!empty($post)){
            
            $data = $this->model->test_xls_export_data($post);
        }else{       
            $company_from = session('financial_form');
            $company_to = session('financial_to');   

            $post['from'] = $company_from; 
            $post['to'] = $company_to; 

            $data = $this->model->test_xls_export_data($post);   
        }

        return $this->response->setHeader('Contente-Disposition','attachment;filename=abc.xlsx')
        ->setContentType('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
       
    }
    public function key_code()
    {
        return view('testing/key_code');
    }
    public function shortcut_keys_list(){

        if (!session('uid')) {
            return redirect()->to(url('auth'));
        } 
        
        $data['title']="Shortcut Key List";
        
		return view('testing/shortcut_key_list',$data);
    }
    public function add_shortcut_key($id = ''){

        if (!session('uid')) {
            return redirect()->to(url('auth'));
        }
        $data = array();
        $post = $this->request->getPost();
        
        if (!empty($post)) {
            $msg = $this->model->insert_edit_shortcut_key($post);
            return $this->response->setJSON($msg);
        }

        if ($id != '') {
                $data['shortcut_key']= $this->model->get_shortcut_key_byid($id);
        }
        $data['id'] = $id;

        $data['title']="Add Shortcut Key";
        return view('testing/add_shortcut_key',$data);
    }
   

    // jv management grouping by party updated by 19-01-2023
    public function Invoice_list()
    {
        if (!session('uid')) {
            return redirect()->to(url('Auth'));
        } 
        $post = $this->request->getPost();
        if(!empty($post)){
            $data = $this->model->jv_invoice_list($post);
        }
        $data['title']="Invoice List";
        
		return view('testing/invoice_list',$data);
    }
    public function add_jv_invoice()
    {
        if (!session('uid')) {
            return redirect()->to(url('Auth'));
        } 
        $post = $this->request->getPost();
        if(!empty($post)){
            $data = $this->model->add_jv_invoice($post);
            //echo '<pre>';Print_r($data);exit;
            
            return $this->response->setJSON($data);
        }
        
    }
    public function add_jv_return()
    {
        if (!session('uid')) {
            return redirect()->to(url('Auth'));
        } 
        $post = $this->request->getPost();
        if(!empty($post)){
            $data = $this->model->add_jv_return($post);
            return $this->response->setJSON($data);
        }
        
    }
    public function party_invoice_list($id='')
    {
        if (!session('uid')) {
            return redirect()->to(url('Auth'));
        } 
        // $post = $this->request->getPost();
        // if(!empty($post)){
        //     $data = $this->model->add_jv_return($post);
        //     return $this->response->setJSON($data);
        // }
        $data['jv_id'] = $id;
        $data['title']="Party Invoice List";
        
		return view('testing/party_invoice_list',$data);
        
    }
    public function Getdata($method = '',$type='') {
        if (!session('uid')) {
            return redirect()->to(url('auth'));
        }
        if ($method == 'jv_log') {
            $get = $this->request->getGet();
            $this->model->Jv_management_log($get);
        }
      
        if ($method == 'shortcut_list') {
            $get = $this->request->getGet();
            $this->model->get_shortcutkey_data($get);
        }

        if ($method == 'party_inv_list') {
            $get = $this->request->getGet();
            $this->model->get_partyinvoice_data($get);
        }
    }

}

?>