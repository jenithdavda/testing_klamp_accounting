<?= $this->extend(THEME . 'templete') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">Transaction </h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Transaction</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?=$title?></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card custom-card">
            <div class="card-header card-header-divider">
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-2 form-group">
                            <h4><label class="form-label">Challan No: <b><?= @$salesinvoice['id']?></b> </label></h4>
                        </div>
                        <div class="col-lg-2 form-group">
                            <h4><label class="form-label"> Date: <b><?= @$salesinvoice['invoice_date']?></b></label>
                            </h4>
                        </div>
                        <div class="col-lg-2 form-group">
                            
                        </div>
                        <div class="col-lg-2 form-group">
                            
                        </div>
                        <div class="col-lg-2 form-group">
                            
                        </div>
                       


                        <div class="col-md-4 form-group">
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <label class="form-label">Account: </label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <label
                                        class="form-label "><b><?=@$salesinvoice['account_name']; ?><?=@$salesinvoice['gst_no']; ?></b>
                                    </label>
                                </div>

                                <div class="col-md-3 form-group">
                                    <label class="form-label">GST No.:</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <label class="form-label "><b><?=@$salesinvoice['gst']; ?></b>
                                    </label>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label class="form-label">Broker: </label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <label class="form-label "><b><?=@$salesinvoice['broker_name']; ?></b> </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 form-group">
                            <div class="row">

                                

                                <!-- <div class="col-md-3 form-group">
                                    <label class="form-label">Brokerage type: </label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <label class="form-label "><b><?=@$salesinvoice['party_bill']; ?></b> </label>
                                </div> -->
                                <div class="col-md-3 form-group">
                                    <label class="form-label">Other: </label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <label class="form-label "><b><?=@$salesinvoice['other']; ?></b> </label>
                                </div>
                                <!-- <div class="col-md-3 form-group">
                                    <label class="form-label">Weight: </label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <label class="form-label "><b><?=@$salesinvoice['weight']; ?></b> </label>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label class="form-label">Freight: </label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <label class="form-label "><b><?=@$salesinvoice['freight']; ?></b> </label>
                                </div> -->
                                <div class="col-md-3 form-group">
                                    <label class="form-label">Delievery Ac: </label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <label class="form-label "><b><?=@$salesinvoice['delivery_name']; ?></b> </label>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label class="form-label">LR No: </label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <label class="form-label "><b><?=@$salesinvoice['lr_no']; ?></b> </label>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label class="form-label">Vehicle: </label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <label class="form-label "><b><?=@$salesinvoice['vehicle_name']; ?></b> </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 form-group">
                            <div class="row">

                                
                                <div class="col-md-3 form-group">
                                    <label class="form-label">LR Date: </label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <label class="form-label "><b><?=@$salesinvoice['lr_date']; ?></b> </label>
                                </div>

                                <div class="col-md-3 form-group">
                                    <label class="form-label">Transport:</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <label class="form-label "><b><?=@$salesinvoice['transport_name']; ?></b>
                                    </label>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label class="form-label">Transport Mode:</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <label class="form-label "><b><?=@$salesinvoice['transport_mode']; ?></b>
                                    </label>
                                </div>

                                <!-- <div class="col-md-3 form-group">
                                    <label class="form-label">City.: </label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <label class="form-label "><b><?=@$salesinvoice['city_name']; ?></b> </label>
                                </div> -->
                                
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered mg-b-0" id="product">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Item</th>
                                        <th>UOM</th>
                                        <th>Qty</th>
                                        <th>Rate</th>
                                        <th>IGST</th>
                                        <th>CGST</th>
                                        <th>SGST</th>
                                        <th>Discount(%)</th>
                                        <th>Amount</th>
                                        <th>Remark</th>
                                    </tr>
                                </thead>
                                <tbody class="tbody">
                                    <?php 
                                    
                                        $taxes = json_decode(@$salesinvoice['taxes']);
                                    
                                        if(isset($item))
                                        {
                                            $total=0.0;
                                            $i = 0;
                                            foreach($item as $row){
                                                $i++;
                                                $sub_total=$row['rate'] * $row['qty'] - $row['item_disc'] ;
                                                $total += $sub_total;
                                                $uom=explode(',',$row['item_uom']);
                                        ?>
                                    <tr>
                                        <td><?=$i;?></td>
                                        <td><?=$row['name'] ?>(<?=$row['code'] ?>)</td>
                                        <td><?=$row['uom']?></td>
                                        <td><?=$row['qty']?></td>

                                        <td><?=$row['rate']?></td>

                                        <td><?=$row['igst']?></td>

                                        <td><?=$row['cgst']?></td>

                                        <td><?=$row['sgst']?></td>

                                        <td><?=$row['item_disc']?></td>
                                        <td><?= $sub_total ?></td>
                                        <td><?=$row['remark']?></td>
                                    </tr>
                                    <?php } }?>
                                </tbody>
                                <tfoot>
                                    <td colspan="2" class="text-right">Total</td>
                                    <td></td>
                                    <td class="qty_total"></td>
                                    <td class="rate_total"></td>
                                    <td class="IGST_total"></td>
                                    <td class="CGST_total"></td>
                                    <td class="SGST_total"></td>
                                    <td class="disc_total"></td>
                                    <td class="total"><?= @$total ?></td>
                                    <td></td>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="row mt-3">
                                <div class="table-responsive">
                                    <table class="table table-bordered mg-b-0" id="selling_case">

                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mt-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered mg-b-0">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <h6>(-)Discount</h6>
                                                </th>
                                                <th>
                                                    <div class="input-group">
                                                        <?= @$salesinvoice['discount'] == '' ? '0' : @$salesinvoice['discount'] ; ?>
                                                    </div>
                                                </th>
                                                <th><?=@$salesinvoice['disc_type']?></th>
                                            </tr>

                                            <tr>
                                                <th>
                                                    <h6>(-)Less Amount</h6>
                                                </th>
                                                <th>
                                                    <?= @$salesinvoice['amtx'] == '' ? '0' : @$salesinvoice['amtx'] ; ?>
                                                </th>
                                                <th><?=@$salesinvoice['amtx_type']?></th>
                                            </tr>

                                            <tr>
                                                <th>
                                                    <h6>(+)Add Amount</h6>
                                                </th>
                                                <th>
                                                    <?= @$salesinvoice['amty'] == '' ? '0' : @$salesinvoice['amty'] ; ?>
                                                </th>
                                                <th><?=@$salesinvoice['amtx_type']?></th>
                                            </tr>

                                            <tr id="igst"
                                                style="display:<?php if(!empty($taxes)) {  echo  (in_array("igst", $taxes)) ? 'table-row;' : 'none;' ; }else{ echo 'none;'; }  ?>">
                                                <th>(+)IGST</th>
                                                <th>
                                                    <?= @$salesinvoice['tot_igst'] == '' ? '0' : @$salesinvoice['tot_igst'] ; ?>
                                                </th>
                                                <th></th>
                                            </tr>

                                            <tr id="sgst"
                                                style="display:<?php if(!empty($taxes)) { echo in_array("sgst", $taxes) ? 'table-row;' : 'none;'; } else{ echo 'none;'; } ?>">
                                                <th>
                                                    <h6>(+)SGST</h6>
                                                </th>
                                                <th>
                                                    <?= @$salesinvoice['tot_sgst'] == '' ? '0' : @$salesinvoice['tot_igst'] ; ?>
                                                </th>
                                                <th></th>
                                            </tr>

                                            <tr id="cgst"
                                                style="display:<?php if(!empty($taxes)) { echo in_array("cgst", $taxes) ? 'table-row;' : 'none;'; } else{ echo 'none;'; } ?>">
                                                <th>
                                                    <h6>(+)CGST</h6>
                                                </th>
                                                <th>
                                                    <?= @$salesinvoice['tot_cgst'] == '' ? '0' : @$salesinvoice['tot_cgst'] ; ?>
                                                </th>
                                                <th></th>
                                            </tr>

                                            <tr id="tds"
                                                style="display:<?php if(!empty($taxes)) { echo in_array("tds", $taxes) ? 'table-row;' : 'none;'; }else{ echo 'none;'; } ?>">
                                                <th>
                                                    <h6>(+)TDS</h6>
                                                </th>
                                                <th>
                                                    <?= @$salesinvoice['tds_amt'] == '' ? '0' : @$salesinvoice['tds_amt'] ; ?>
                                                </th>
                                                <th></th>
                                            </tr>

                                            <tr id="cess"
                                                style="display:<?php if(!empty($taxes)) { echo in_array("cess", $taxes) ? 'table-row;' : 'none;'; }else{echo 'none;';} ?> ">
                                                <th>
                                                    <h6>(+)Cess</h6>
                                                </th>
                                                <th>
                                                    <?= @$salesinvoice['cess'] == '' ? '0' : @$salesinvoice['cess'] ; ?>
                                                </th>
                                                <th><?=@$salesinvoice['cess_type']?></th>

                                            </tr>
                                            <tr>
                                                <td>
                                                    <h4>Net Amount </h4>
                                                </td>
                                                <td colspan="2">
                                                    <h5><?=@$salesinvoice['net_amount']?></h5>
                                                </td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>