<?php


if (!function_exists('url')) {

    function url($slug){
        return base_url() .'/'. $slug;
    }
}

if (!function_exists('html_convert')) {

    function html_convert($text){
        $text = str_replace("'", "", $text);
        $text = str_replace("\"", "", $text);

        return html_entity_decode($text);
    }
}

function search($array, $key, $value){
    $results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, search($subarray, $key, $value));
        }
    }

    return $results;
}

function date_compare($element1, $element2) {
    $datetime1 = strtotime($element1['date']);
    $datetime2 = strtotime($element2['date']);
    return $datetime1 - $datetime2;
}

function generateRandomString($length = 5) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    $db = \Config\Database::connect();
    $builder = $db->table('property');
    $query = $builder->select('*')->where(array('pid' => $randomString))->get();
    $getdata = $query->getRow();
    if (!empty($getdata)) {
        $randomString = generateRandomString($length);
    }
    return $randomString;
}

function gl_list($abc,$test = array()){
        $db = \Config\Database::connect();
        $db->setDatabase(session('DataSource')); 
        $builder = $db->table('gl_group');
        $builder = $builder->select('GROUP_CONCAT(id) as ids');
        $builder->whereIn('parent',$abc);
        $query = $builder->get();
        $getglids = $query->getRow();

        $xyz = $test;
        if($getglids->ids != ''){
            
            $bijo =explode(',',$getglids->ids);
            $xyz = array_merge($xyz,$bijo);
            
            $xyz = gl_list($bijo,$xyz);
            
        }
        
        return $xyz;
}


function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    echo 'date : ';print_r($date);exit;

    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}

function db_date($date){
   
        if(!empty($date) && $date != '0000-00-00'){

            $dt = date_create($date);
            $year = $dt->format("Y");
            $ret_date = date_format($dt,'Y-m-d');

        }else{
            $ret_date = '';
        }
  
    return $ret_date;
}

function user_date($date){  
  
        if(!empty($date) && $date != '0000-00-00'){
            $dt = date_create($date);
            
            $ret_date = date_format($dt,'d-m-Y');
        }else{
            $ret_date = '';
        }   
   
    return $ret_date;
}

function to_time_ago( $time ) { 
    
	$diff = time() - $time; 
	if( $diff < 1 ) { 
		return 'less than 1 second ago'; 
	} 
	$time_rules = array ( 
		12 * 30 * 24 * 60 * 60 => 'year', 
		30 * 24 * 60 * 60	 => 'month', 
		24 * 60 * 60		 => 'day', 
		60 * 60				 => 'hour', 
		60					 => 'minute', 
		1					 => 'second'
	);
	foreach( $time_rules as $secs => $str ) { 	
		$div = $diff / $secs; 
		if( $div >= 1 ) { 		
			$t = round( $div ); 	
			return $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago'; 
		} 
	} 
} 

function getManagedData($tablename, $dt_col, $dt_search, $where, $dt_order = array()){ //print_r($aColumns);exit;
    $db = \Config\Database::connect();
    
    if(session('DataSource'))
    {
        $db->setDatabase(session('DataSource'));
    }
    $request = \Config\Services::request();
    $rResult = array();
    //$sQuery = "SELECT COUNT('*') AS row_count FROM " . $tablename;
    //$rResultTotal = $db->query($sQuery);
    // $aResultTotal = $rResultTotal->getRow();
    //$rResult[] = $aResultTotal->row_count;
    $post = $request->getPost();
    if (empty($post)) {
        $post = $request->getGet();
    }
    $draw = intval($post['draw']);
    $starts = $post['start'];
    $limit = $post['length'];

    $sLimit = "";
    $iDisplayStart = $post['start'];
    $iDisplayLength = $post['length'];
    
    if (isset($iDisplayStart) && $iDisplayLength != '-1') {
        $sLimit = "LIMIT " . intval($iDisplayStart) . ", " .
            intval($iDisplayLength);
    }

    $uri_string = urldecode($_SERVER['QUERY_STRING']);
    $uri_string = preg_replace("/%5B/", '[', $uri_string);
    $uri_string = preg_replace("/%5D/", ']', $uri_string);

    $get_param_array = explode("&", $uri_string);
    $arr = array();
    if (!empty($get_param_array)) {
        foreach ($get_param_array as $value) {
            $v = $value;
            $explode = explode("=", $v);
            $arr[$explode[0]] = $explode[1];
        }
    }

    $index_of_columns = $post["columns"];
    $index_of_start = $post["start"];


    /*
     * Ordering
     */
    $sOrder = "";
    for ($i = 0; $i < count($post['order']); $i++) {

        $sOrderIndex = $post['order'][$i]['column'];
        $sOrderDir = $post['order'][$i]['dir'];

        $bSortable_ = $post['columns'][$sOrderIndex]['orderable'];

        if ($bSortable_ == true) {
            if (empty($dt_order))
                $sOrder .= $dt_search[$sOrderIndex] . ($sOrderDir == 'asc' ? ' asc' : ' desc');
            else
                $sOrder .= $dt_order[$sOrderIndex] . ($sOrderDir == 'asc' ? ' asc' : ' desc');
        }
    }
    if ($sOrder != '')
        $sOrder = "ORDER BY " . $sOrder;

    if (!isset($post['order'][0]['column'])) {
        if (empty($dt_order))
            $sOrder .= $dt_search[0] . (' desc');
        else
            $sOrder .= $dt_order[0] . (' desc');
    }


    $sWhere = " WHERE 1 ";

    $sSearchVal = $post['search']['value'];
    if (isset($sSearchVal) && $sSearchVal != '') {

        $sWhere = $sWhere . "AND (";
        for ($i = 0; $i < count($dt_search); $i++) {
            $sWhere .= $dt_search[$i] . " LIKE '%" . str_replace('+', ' ', ($sSearchVal)) . "%' OR ";
        }
        $sWhere = substr_replace($sWhere, "", -3);
        $sWhere .= ')';
    }
    $sWhere .= $where;
    /*
     * SQL queries
     * Get data to display
     */
    $sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $dt_col)) . "
			FROM $tablename
			$sWhere
			$sOrder
			$sLimit
			";
    //   echo $sQuery; exit;  
    $rResult[] = $db->query($sQuery);
    // echo "<pre>"; print_r($rResult->result_array());exit;
    // echo $db->getLastQuery(); exit;
    /* Data set length after filtering */
    $sQuery = "SELECT FOUND_ROWS() AS length_count";
    $rResultFilterTotal = $db->query($sQuery);
    $aResultFilterTotal = $rResultFilterTotal->getRow();
    $rResult[] = $aResultFilterTotal->length_count;
    //  print_r($rResult[1]->result_array()); exit;
    $result_return = array(
        'table' => $rResult[0]->getResultArray(), 'draw' => $draw,
        'total' => $rResult[1]
    );
    return $result_return;
    //$iFilteredTotal
}

function MakeThumb($source_path, $target_path, $width, $height, $defalusize = '600'){
    if ($height == $defalusize && $width == $defalusize) {
        $height = $defalusize;
        $width = $defalusize;
    } else if ($height >= $width && $height > $defalusize) {
        $calc = $height / $defalusize;
        $height = $defalusize;
        $width = $width / $calc;
    } else if ($height <= $width && $width > $defalusize) {
        $calc = $width / $defalusize;
        $width = $defalusize;
        $height = $height / $calc;
    } else {
        $width = $width;
        $height = $height;
    }


    $image = \CodeIgniter\Config\Services::image()
        ->withFile($source_path)
        ->resize(600, 600, true, 'height')
        ->save($target_path);
}

function uploadMultiFiles($fieldName, $uploadfolder){

    $year = date('Y');
    $month = date('m');
    $day = date('d');
    $original_path = "/" .$uploadfolder . "/" . $year . "/" . $month . "/" . $day . "/";

    if (!file_exists(getcwd() . $original_path)) {
        mkdir(getcwd() . $original_path, 0777, true);
    }
    
    $files = $_FILES;
    $randno = uniqid();
    $name = $files[$fieldName]['name'];
    $allowed = array('csv','xlsx','xls');
    $ext = pathinfo($name, PATHINFO_EXTENSION);

    if (!in_array($ext, $allowed)) {
        $response['errors'] = 'only CSV file Allowed';
        $response['is_success'] = 0;
    } else{

        $pathinfo = pathinfo($name);
        $imageName = $pathinfo['filename'] . '_' . $randno . "." . $pathinfo['extension'];
        $_FILES[$fieldName]['name'] = $imageName;
        $_FILES[$fieldName]['type'] = $files[$fieldName]['type'];
        $_FILES[$fieldName]['tmp_name'] = $files[$fieldName]['tmp_name'];
        $_FILES[$fieldName]['error'] = $files[$fieldName]['error'];

        $targetFile = getcwd() . $original_path . $imageName;
        $tempFile = $_FILES[$fieldName]['tmp_name'];
        if(move_uploaded_file($tempFile, $targetFile)){
            $response['fileName']  = $original_path . $imageName;
            $response['is_success'] = 1;
        } else {
            $response['errors'] = '';
            $response['is_success'] = 0;
        }
    }

    return $response;
}
function get_shortcutkey_data($key_char)
{
    echo '<pre>';Print_r($key_char);exit;
    
}
// ************** start report helper function*******************//
function inword($number)
{
    //$number = 190908100.25;
    
    $no = floor($number);
    $point = round($number - $no, 2) * 100;
    $hundred = null;
    $digits_1 = strlen($no);
    $i = 0;
    $str = array();
    $words = array('0' => '', '1' => 'one', '2' => 'two',
        '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
        '7' => 'seven', '8' => 'eight', '9' => 'nine',
        '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
        '13' => 'thirteen', '14' => 'fourteen',
        '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
        '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
        '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
        '60' => 'sixty', '70' => 'seventy',
        '80' => 'eighty', '90' => 'ninety');
    $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
    while ($i < $digits_1) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += ($divider == 10) ? 1 : 2;
          
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str[] = ($number < 21) ? $words[$number] ." " . $digits[$counter] . $plural . " " . $hundred : $words[floor($number / 10) * 10] . " " . $words[$number % 10] . " ". $digits[$counter] . $plural . " " . $hundred;
        } else {
            $str[] = null;
        }

    }
    $str = array_reverse($str);
    $result = implode('', $str);
    $points = ($point) ?
    "." . $words[$point / 10] . " " .
    $words[$point = $point % 10] : '';
    
    if($result == ''){
        $result = "ZERO ";
    }
    if($points == ''){
        $points = "ZERO ";
    }
    $data = $result . "Rupees  " . $points . " Paise";
    return $data;

}
//use in bank
function get_reconsilation_data($account, $start_date = '', $end_date = '')
{

    $db = \Config\Database::connect();
    if (session('DataSource')) {
        $db->setDatabase(session('DataSource'));
    }

    if ($start_date == '') {
        if (date('m') <= '03') {
            $year = date('Y') - 1;
            $start_date = $year . '-04-01';
        } else {
            $year = date('Y');
            $start_date = $year . '-04-01';
        }
    }

    if ($end_date == '') {
        if (date('m') <= '03') {
            $year = date('Y');
        } else {
            $year = date('Y') + 1;
        }
        $end_date = $year . '-03-31';
    }

    $dt = new DateTime($start_date);
    if ($dt->format('m') <= '03') {
        $year = date('Y') - 1;
        $newdate = $year . '-04-01';
    } else {
        $year = $dt->format('Y');
        $newdate = $year . '-04-01';
    }

    $builder = $db->table('bank_tras bt');
    $builder->select('bt.id,bt.cash_type,bt.check_no,bt.check_date,bt.account,bt.payment_type,bt.mode,bt.receipt_date as date,bt.amount,bt.recons_date,ac.name as account_name');
    $builder->join('account ac', 'ac.id = bt.particular');
    $builder->where(array('DATE(bt.receipt_date)  >= ' => db_date($newdate)));
    $builder->where(array('DATE(bt.receipt_date)  <= ' => db_date($end_date)));
    $builder->where(array('bt.payment_type' => 'bank', 'bt.is_delete' => 0));
    $builder->where(array('bt.recons_date' => ''));
    $builder->where('bt.account', $account);
    $builder->orderBy('bt.receipt_date', 'ASC');
    $query = $builder->get();
    $getresult = $query->getResultArray();

    $builder = $db->table('bank_tras bt');
    $builder->select('ct.id as ct_id,bt.id,bt.cash_type,bt.check_no,bt.check_date,bt.account,bt.payment_type,ct.mode,bt.receipt_date as date,bt.amount,bt.recons_date,ac.name as account_name');
    $builder->join('contra_trans ct', 'ct.parent_id = bt.id');
    $builder->join('account ac', 'ac.id = ct.account');
    $builder->where(array('DATE(bt.receipt_date)  >= ' => db_date($newdate)));
    $builder->where(array('DATE(bt.receipt_date)  <= ' => db_date($end_date)));
    $builder->where(array('bt.payment_type' => 'contra', 'bt.is_delete' => 0));
    $builder->where(array('ct.recons_date' => ''));
    $builder->where('ct.account', $account);
    $builder->orderBy('bt.receipt_date', 'ASC');
    $query = $builder->get();
    $getresult1 = $query->getResultArray();

    // echo $db->getLastQuery();exit;

    // $builder=$db->table('bank_tras bt');
    // $builder->select('bt.id,bt.cash_type,bt.check_no,bt.check_date,bt.account,bt.payment_type,ct.mode,bt.receipt_date as date,bt.amount,bt.recons_date,ac.name as account_name');
    // $builder->join('account ac','ac.id = bt.particular');
    // $builder->where(array('DATE(bt.receipt_date)  >= ' => db_date($newdate)));
    // $builder->where(array('DATE(bt.receipt_date)  <= ' => db_date($end_date)));
    // $builder->where(array('bt.payment_type' => 'contra','bt.is_delete' => 0));
    // $builder->where(array('bt.recons_date' => ''));
    // $builder->where('bt.particular',$account);
    // $builder->orderBy('bt.receipt_date','ASC');
    // $query=$builder->get();
    // $getresult2 = $query->getResultArray();

    // echo $db->getLastQuery();
    // echo '<pre>';print_r($getresult1);exit;

    $merge_array = array_merge($getresult, $getresult1);

    usort($merge_array, 'date_compare');

    $getdata['bank'] = $merge_array;

    $builder = $db->table('account');
    $builder->select('name');
    $builder->where('id', $account);
    $query = $builder->get();
    $res = $query->getRow();

    $getdata['account_name'] = @$res->name;
    $getdata['account_id'] = @$account;

    $bankcredit_total = 0;
    $bankdebit_total = 0;
    
    foreach ($getdata['bank'] as $row) {
        if ($row['mode'] == 'Receipt') {
            $bankdebit_total = $bankdebit_total + $row["amount"];
        } else {
            $bankcredit_total = $bankcredit_total + $row["amount"];
        }
    }

    $getdata['total']['bankdebit_total'] = $bankdebit_total;
    $getdata['total']['bankcredit_total'] = $bankcredit_total;

    $getdata['from'] = $start_date;
    $getdata['to'] = $end_date;

    return $getdata;
}
function get_unreconsilation_data($account, $start_date = '', $end_date = '')
{

    $db = \Config\Database::connect();
    if (session('DataSource')) {
        $db->setDatabase(session('DataSource'));
    }

    if ($start_date == '') {
        if (date('m') <= '03') {
            $year = date('Y') - 1;
            $start_date = $year . '-04-01';
        } else {
            $year = date('Y');
            $start_date = $year . '-04-01';
        }
    }

    if ($end_date == '') {
        if (date('m') <= '03') {
            $year = date('Y');
        } else {
            $year = date('Y') + 1;
        }
        $end_date = $year . '-03-31';
    }

    $dt = new DateTime($start_date);

    if ($dt->format('m') <= '03') {
        $year = date('Y') - 1;
        $newdate = $year . '-04-01';
    } else {
        $year = $dt->format('Y');
        $newdate = $year . '-04-01';
    }

    $builder = $db->table('bank_tras bt');
    $builder->select('bt.id,bt.check_no,bt.cash_type,bt.check_date,bt.account,bt.payment_type,bt.mode,bt.receipt_date as date,bt.amount,bt.recons_date,ac.name as account_name');
    $builder->join('account ac', 'ac.id = bt.particular');
    $builder->where(array('bt.payment_type' => 'bank', 'bt.is_delete' => 0));
    $builder->where(array('bt.recons_date !=' => ''));
    $builder->where('bt.account', $account);
    $builder->where(array('DATE(bt.receipt_date)  >= ' => db_date($start_date)));
    $builder->where(array('DATE(bt.receipt_date)  <= ' => db_date($end_date)));
    $builder->orderBy('bt.receipt_date', 'ASC');
    $query = $builder->get();
    $getresult = $query->getResultArray();

    $builder = $db->table('bank_tras bt');
    $builder->select('ct.id as ct_id,bt.id,bt.cash_type,bt.check_no,bt.check_date,bt.account,bt.payment_type,ct.mode,bt.receipt_date as date,bt.amount,ct.recons_date,ac.name as account_name,acc.name as bank_account_name,pr.name as bank_particular_name');
    $builder->join('contra_trans ct', 'ct.parent_id = bt.id');
    $builder->join('account ac', 'ac.id = ct.account');
    $builder->join('account acc', 'acc.id = bt.account');
    $builder->join('account pr', 'pr.id = bt.particular');
    $builder->where(array('DATE(bt.receipt_date)  >= ' => db_date($start_date)));
    $builder->where(array('DATE(bt.receipt_date)  <= ' => db_date($end_date)));
    $builder->where(array('bt.payment_type' => 'contra', 'bt.is_delete' => 0));
    $builder->where(array('ct.recons_date !=' => ''));
    $builder->where('ct.account', $account);
    $builder->orderBy('bt.receipt_date', 'ASC');
    $query = $builder->get();
    $getresult1 = $query->getResultArray();
    

    $getresult2 = array();
    foreach($getresult1 as $row){
        if($row['cash_type'] == 'Fund Transfer'){

            if($row['account_name'] == $row['bank_account_name']){
                $row['account_name'] = $row['bank_particular_name'];
            }else{
                $row['account_name'] = $row['bank_account_name'];
            }
        }
        $getresult2[] = $row;
    }

    $merge_arr = array_merge($getresult, $getresult2);
    
    usort($merge_arr, 'date_compare');

    $getdata['bank'] = $merge_arr;

    $builder = $db->table('account');
    $builder->select('name');
    $builder->where('id', $account);
    $query = $builder->get();
    $res = $query->getRow();

    $getdata['account_name'] = @$res->name;
    $getdata['account_id'] = @$account;

    $bankcredit_total = 0;
    $bankdebit_total = 0;

    foreach ($getdata['bank'] as $row) {
        if ($row['mode'] == 'Receipt') {
            $bankdebit_total = $bankdebit_total + $row["amount"];
        } else {
            $bankcredit_total = $bankcredit_total + $row["amount"];
        }
    }

    $getdata['total']['bankdebit_total'] = $bankdebit_total;
    $getdata['total']['bankcredit_total'] = $bankcredit_total;

    $getdata['from'] = $start_date;
    $getdata['to'] = $end_date;

    return $getdata;
}
function gl_group_summary_array($id)
{
    
    $db = \Config\Database::connect();

    if (session('DataSource')) {
        $db->setDatabase(session('DataSource'));
    }
    $main = get_parent_gl_group($id);
    $parent_id = floatval($main['parent']);
  
    $result = array();
        while($parent_id > 0){  
         
           $get_pid = get_parent_gl_group($parent_id);
            $result[] = $get_pid;
            if(!empty($get_pid)){
                $parent_id = floatval($get_pid['parent']);
             }
           else {
            $parent_id = 0;
           }    
        }

    return  $result;
}
function get_parent_gl_group($id)
{
    $db = \Config\Database::connect();

    if (session('DataSource')) {
        $db->setDatabase(session('DataSource'));
    }
    $builder = $db->table('gl_group');
    $builder->select('id,name,parent');
    $builder->where('id', $id);
    $builder->where('is_delete', 0);
    $query = $builder->get();
    $result = $query->getRowArray();
    
    return $result;
}

