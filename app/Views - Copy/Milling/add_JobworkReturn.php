<?= $this->extend(THEME . 'templete') ?>

<?= $this->section('content') ?>
<style>
.modal-dialog {
    max-width: 750px;
    margin: 1.75rem auto;
}

.table {
    width: 135% !important;
}

.table-responsive::-webkit-scrollbar {
    width: 3px;
    height: 12px;
    transition: .3s background;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: #e1e6f1;
}
</style>

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">Transaction </h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Transaction</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?=$title?></li>
        </ol>
    </div>

    <div class="ml-auto pd-r-100">
        <h2 class="mb-1 font-weight-bold"><span>Jobwork Return Sr No :</span> <?= @$challan['sr_no'] ? $challan['sr_no'] : $current_id; ?></h2>    
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card custom-card">
            <div class="card-header card-header-divider">
                <div class="card-body">
                    <form action="<?= url('Milling/Add_return_jobwork') ?>" class="ajax-form-submit" method="POST"
                        id="challanform">
                        <div class="row">

                            <input class="form-control col-md-9" type="hidden" name="id"
                                value="<?= @$challan['id'] ? $challan['id'] : $id; ?>" placeholder="Enter id">

                            <input class="form-control col-md-9" type="hidden" name="srno" id="srno" readonly
                                value="<?= @$challan['sr_no'] ? $challan['sr_no'] : $current_id; ?>"
                                required>
                            
                            <div class="row col-md-6 form-group">
                                <label class="form-label col-md-3">Challan No: <span class="tx-danger">*</span></label>
                                <select class="form-control col-md-9" id="job_challan" name='job_challan'>
                                    <?php if(@$challan['job_challan']) { ?>
                                    <option value="<?=@$challan['job_challan']?>">
                                        <?=@$challan['job_challan_name']?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>


                            <?php 
                                if(!empty($challan)){
                                    $invoice_date = user_date($challan['date']);
                                }
                                $today = user_date(date('Y-m-d'));
                            ?>

                            <div class="row col-md-6 form-group">
                                <label class="form-label col-md-3">Date: <span class="tx-danger">*</span></label>
                                <input class="form-control col-md-9 dateMask" required placeholder="DD-MM-YYYY"
                                    type="text" id="date" name="date"
                                    value="<?= @$challan['date'] ? $invoice_date : $today; ?>">
                            </div>

                            <div class="col-lg-5 form-group">
                                <div class="row">

                                    <div class="col-md-4 form-group">
                                        <label class="form-label">Transport Mode: </label>
                                    </div>

                                    <div class="col-md-8 form-group">
                                        <select class="form-control transport_mode" id="transport_mode"
                                            name="trasport_mode">
                                            <option <?= ( @$challan['transport_mode'] == 'ROAD' ? 'selected' : '' ) ?>
                                                value="ROAD">ROAD</option>
                                            <option <?= ( @$challan['transport_mode'] == 'AIR' ? 'selected' : '' ) ?>
                                                value="AIR">AIR</option>
                                            <option <?= ( @$challan['transport_mode'] == 'RAIL' ? 'selected' : '' ) ?>
                                                value="RAIL">RAIL</option>
                                            <option <?= ( @$challan['transport_mode'] == 'SHIP' ? 'selected' : '' ) ?>
                                                value="SHIP">SHIP</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="form-label">Issue Party: <span class="tx-danger">*</span></label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <select class="form-control account" id="account" required name='account'>
                                            <?php if(@$challan['party_name']) { ?>
                                            <option value="<?=@$challan['party_name']?>">
                                                <?=@$challan['account_name']?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                        <!-- <input type="hidden" name="id" value="<?= @$challan['id']; ?>"> -->
                                        <input type="hidden" name="tds_per" id="tds_per"
                                            value="<?= @$challan['tds_per']; ?>">
                                        <input type="hidden" name="tds_limit" id="tds_limit"
                                            value="<?= @$challan['tds_limit']; ?>">
                                        <input type="hidden" name="acc_state" id="acc_state"
                                            value="<?= @$challan['acc_state']; ?>">
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label class="form-label">Delivery Ac: </label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <select class="form-control" id="delivery" name='delivery_ac'>
                                            <option value=""> Not One</option>
                                            <?php if(@$challan['delivery_ac']) { ?>
                                            <option selected value="<?=@$challan['delivery_ac']?>">
                                                <?=@$challan['delivery_ac_name']?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>


                                    <div class="col-md-4 form-group">
                                        <label class="form-label">Delivery Address: </label>
                                    </div>

                                    <div class="col-md-8 form-group">
                                        <textarea class="form-control delivery" name="delivery_code" value=""
                                            placeholder="Delivery Address"
                                            type="text"><?= @$challan['delivery_code']; ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-7 form-group">
                                <div class="row">
                                    <div class="col-md-2 form-group">
                                        <label class="form-label">LR No.: </label>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <input class="form-control lrno" name="lrno" value="<?= @$challan['lr_no']; ?>"
                                            placeholder="LR No." type="text">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label class="form-label">LR Date.: </label>
                                    </div>
                                    <?php 
                                        $lr_date = user_date(@$challan['lr_date']);
                                    ?>
                                    <div class="col-md-4 form-group">
                                        <input class="form-control dateMask lr_date" placeholder="DD/MM/YYYY"
                                            type="text" id="lr_date" name="lr_date" value="<?= @$lr_date; ?>">
                                    </div>

                                    <div class="col-md-2 form-group">
                                        <label class="form-label">Weight: </label>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <input class="form-control weight" name="weight"
                                            value="<?= @$challan['weight']; ?>" placeholder="0.00"
                                            placeholder="Enter Weight" type="text">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label class="form-label">Freight: </label>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <input class="form-control freight" name="freight"
                                            value="<?= @$challan['freight']; ?>" placeholder="00" type="text">
                                    </div>

                                    <div class="col-md-3 form-group">
                                        <label class="form-label"> Warehouse: </label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <select class="form-control warehouse" id="warehouse" name='warehouse'>
                                            <?php if(@$challan['warehouse_name']) { ?>
                                            <option value="<?=@$challan['warehouse']?>">
                                                <?=@$challan['warehouse_name']?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-md-2 form-group">
                                        <label class="form-label"> Broker: </label>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <select class="form-control broker" id="broker" name='broker'>
                                            <?php if(@$challan['broker']) { ?>
                                            <option value="<?=@$challan['broker']?>">
                                                <?=@$challan['broker_name']?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>


                                    <div class="col-md-2 form-group">
                                        <label class="form-label"> Transport </label>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <select class="form-control broker" id="transport" name='transport'>
                                            <?php if(@$challan['transport']) { ?>
                                            <option value="<?=@$challan['transport']?>">
                                                <?=@$challan['transport_name']?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <!-- <a target="_blank"   title="Add Item:<?=@$current_id?>" onclick="add_item(this)"  data-val="<?=@$current_id?>" data-pk="<?=@$current_id?>" tabindex="-1" class="btn btn-primary">Add Item</a> -->
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
                                            <th>Hsn</th>
                                            <th>Type</th>
                                            <th style="width:180px">Screen</th>
                                            <th>Grey Rate</th>
                                            <th>Gst</th>
                                            <th>PCS</th>
                                            <th>MTR</th>
                                            <th>CUT</th>
                                            <th>UNIT</th>
                                            <th>Ret PCS</th>
                                            <th>Ret Meter</th>
                                            <th>Amount</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbody">

                                        <?php 
                                        $total=0;
                                        
                                        if(isset($item))
                                        {  
                                            foreach($item as $row){
                                                $sub_total=$row['price'] * $row['pcs'] ;
                                                $total += $sub_total;
                                        ?>
                                        <tr class="<?=$row['pid']?>">

                                            <td>#</td>
                                            <input type="hidden" name="pid[]" value="<?=$row['pid']?>">

                                            <td><?=$row['name']?>
                                            </td>
                                            <td><?=$row['hsn']?>
                                            </td>
                                            <td>
                                                <select id="type" name="type[]" onchange="calculate()">
                                                    <?=$row['uom_opt']?>
                                                </select>
                                            </td>
                                            <td>
                                                <div class="input-group select2_height">
                                                    <select class="form-control select-sm screen" name="screen[]">
                                                        <?php if(!empty($row['screen'])) { ?>
                                                        <option value="<?=@$row['screen']?>"><?=@$row['screen_name']?>
                                                        </option>
                                                        <?php  } ?>
                                                    </select>
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text" style="padding:0.045rem 0.30rem;">
                                                            <a data-toggle="modal" data-target="#fm_model"
                                                                data-title="Add Finish Item"
                                                                href="<?=url('Milling/add_finishjob_screen')?>"><i
                                                                    style="font-size:20px;"
                                                                    class="fe fe-plus-circle"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td><input class="form-control input-sm" value="<?=$row['price']?>"
                                                    name="price[]" onchange="calculate()" readonly
                                                    onkeypress="return isDesimalNumberKey(event)" required=""
                                                    type="text"></td>

                                            <td><input class="form-control input-sm" value="<?=$row['igst']?>"
                                                    name="igst[]" onchange="calculate()" readonly
                                                    onkeypress="return isDesimalNumberKey(event)" required=""
                                                    type="text"></td>

                                            <td><input class="form-control input-sm" value="<?=$row['pcs']?>"
                                                    name="taka[]" readonly onchange="calculate()"
                                                    onkeypress="return isDesimalNumberKey(event)" required=""
                                                    type="text"></td>
                                            <td>
                                                <input class="form-control input-sm" type="text" name="meter[]"
                                                    value="<?=@$row['meter']?>" id="meter" readonly
                                                    onchange="cxalculate()"
                                                    onkeypress="return isDesimalNumberKey(event)">
                                            </td>

                                            <td>
                                                <input class="form-control input-sm" type="text" name="cut[]"
                                                    value="<?=@$row['cut']?>" id="cut" readonly onchange="cxalculate()"
                                                    onkeypress="return isDesimalNumberKey(event)">
                                            </td>

                                            <td>
                                                <input class="form-control input-sm" type="text" name="unit[]"
                                                    value="<?=@$row['unit']?>" id="unit" readonly
                                                    onchange="cxalculate()"
                                                    onkeypress="return isDesimalNumberKey(event)">
                                            </td>



                                            <td><input class="form-control input-sm" value="<?=$row['ret_taka']?>"
                                                    name="ret_taka[]" onchange="calculate()"
                                                    onkeypress="return isDesimalNumberKey(event)" type="text"></td>

                                            <td>
                                                <input class="form-control input-sm" type="text" name="ret_meter[]"
                                                    value="<?=@$row['ret_meter']?>" id="meter" onchange="cxalculate()"
                                                    onkeypress="return isDesimalNumberKey(event)">
                                            </td>


                                            <td><input class="form-control input-sm" value="<?=$sub_total?>"
                                                    name="subtotal[]" onchange="calculate()"
                                                    onkeypress="return isDesimalNumberKey(event)" required=""
                                                    type="text"></td>

                                            <td><input class="form-control input-sm" value="<?=$row['remark']?>"
                                                    name="remark[]" onchange="calculate()" type="text"></td>
                                        </tr>
                                        <?php 
                                            } 
                                        }?>
                                    </tbody>
                                    <tfoot>
                                        <td colspan="2" class="text-right">Total</td>

                                        <td class="amount_total"></td>
                                        <td class="amount_total"></td>
                                        <td class="IGST_total"></td>
                                        <td class="CGST_total"></td>
                                        <td class="SGST_total"></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="total"><?=@$total; ?></td>
                                        <td></td>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                </div>
                <div class="form-group">
                    <div class="tx-danger error-msg"></div>
                    <div class="tx-success form_proccessing"></div>
                </div>
                <div class=" mt-3">
                    <input class="btn btn-space btn-primary btn-product-submit" id="save_data" type="submit"
                        value="Submit">
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>

<script>
<?php 

if(isset($id)){?>
calculate();
<?php } ?>


function validate_autocomplete(obj, val) {
    if ($('#' + val).val() == '') {
        $('.' + val).html('Option Select from dropdown list')
    } else {
        $('.' + val).html('')
    }
}

$('.ajax-form-submit').on('submit', function(e) {
    var meter = $('input[name="meter[]"]').map(function() {
        return parseFloat(this.value);
    }).get();

    var test = false;
    $.each(meter, function(index, value) {
        if (value == 'NaN' || isNaN(value) || value == 'undefined') {
            console.log('value  ' + value);
            $('.error-msg').html('Please Add Meter..!!');
            test = true;
            return false;
        }
    });

    if (test) {
        return false;
    }
    $('#save_data').prop('disabled', true);
    $('.error-msg').html('');
    //$('.form_proccessing').html('Please wail...');
    e.preventDefault();
    var aurl = $(this).attr('action');
    $.ajax({
        type: "POST",
        url: aurl,
        data: $(this).serialize(),
        success: function(response) {
            if (response.st == 'success') {
                swal("success!", "Your update successfully!", "success");
                $('#save_data').prop('disabled', false);
                window.location = "<?=url('Milling/return_jobwork')?>";
            } else {
                $('.form_proccessing').html('');
                $('#save_data').prop('disabled', false);
                $('.error-msg').html(response.msg);
            }
        },
        error: function() {
            $('#save_data').prop('disabled', false);
            alert('Error');
        }
    });
    return false;
});

// function enable_gst_option() {
//     var tax = $("#tax :selected").map(function(i, el) {
//         return $(el).val();
//     }).get();

//     var igst = document.getElementById("igst");
//     var sgst = document.getElementById("sgst");
//     var cgst = document.getElementById("cgst");
//     var tds = document.getElementById("tds");
//     var cess = document.getElementById("cess");

//     $.each(tax, function() {
//         if (this == 'igst') {
//             igst.style.display = "table-row";
//         } else if (this == 'sgst') {
//             sgst.style.display = "table-row";
//         } else if (this == 'cgst') {
//             cgst.style.display = "table-row";
//         } else if (this == 'tds') {
//             tds.style.display = "table-row";
//         } else if (this == 'cess') {
//             cess.style.display = "table-row";
//         } else {}
//     });

//     var tds = document.getElementById("tds");
//     var cess = document.getElementById("cess");

//     var tax_array = ['igst', 'sgst', 'cgst', 'cess', 'tds'];
//     var diff = arr_diff(tax_array, tax);

//     $.each(diff, function() {
//         if (this == 'igst') {
//             igst.style.display = "none";
//         } else if (this == 'sgst') {
//             sgst.style.display = "none";
//         } else if (this == 'cgst') {
//             cgst.style.display = "none";
//         } else if (this == 'cess') {
//             cess.style.display = "none";
//         } else if (this == 'tds') {
//             tds.style.display = "none";
//         } else {
//             // cgst.style.display="table-row";
//         }
//     });
// }

$(document).ready(function() {

    $('.select2').select2({
        minimumResultsForSearch: Infinity,
        placeholder: 'Choose one',
        width: '100%'
    });

    $('#transport_mode').select2({
        width: '65%'
    });


    var pids = $('input[name="pid[]"]').map(function() {
        return parseInt(this.value); // $(this).val()
    }).get();

    $("#product").on('click', '.btnDelete', function() {
        const index = pids.indexOf($(this).data('id'));
        if (index !== -1) {
            delete pids[index];
        }
        $(this).closest('tr').remove();
        $('#code').attr('disabled', false);
        $('#challan_btn').attr('disabled', true);
        calculate();
    });


    $('.fc-datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        showOtherMonths: true,
        selectOtherMonths: true
    });
    $('.dateMask').mask('99-99-9999');

    $("#account").select2({
        width: '66.5%',
        placeholder: 'Type Account Name',
        ajax: {
            url: PATH + "Master/Getdata/search_accountSundry_cred_debt",
            type: "post",
            allowClear: true,
            dataType: 'json',
            delay: 250,
            data: function(params) {

                return {
                    searchTerm: params.term, // search term
                };
            },
            processResults: function(response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });

    $('#account').on('select2:select', function(e) {
        var data = e.params.data;

        $('#gst').val(data.gsttin);
        $('#tds_per').val(data.tds);
        $('#tds_limit').val(data.tds_limit);
        $('#acc_state').val(data.state);
    });

    // $("#account").select2({
    //     width: '66.5%',
    //     placeholder: 'Type Account Name',
    //     ajax: {
    //         url: PATH + "Master/Getdata/search_account_grey",
    //         type: "post",
    //         allowClear: true,
    //         dataType: 'json',
    //         delay: 250,
    //         data: function(params) {

    //             return {
    //                 searchTerm: params.term // search term
    //             };
    //         },
    //         processResults: function(response) {
    //             return {
    //                 results: response
    //             };
    //         },
    //         cache: true
    //     }
    // });

    // $('#account').on('select2:select', function(e) {
    //     var data = e.params.data;
    //     // console.log(data)
    //     $('#gst').val(data.gsttin);
    //     $('#tds_per').val(data.tds);
    //     $('#tds_limit').val(data.tds_limit);
    //     $('#acc_state').val(data.state);

    //     calculate();

    // });

    $("#broker").select2({
        width: '100%',
        placeholder: 'Type Broker Account',
        ajax: {
            url: PATH + "Master/Getdata/search_broker",
            type: "post",
            allowClear: true,
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    searchTerm: params.term // search term
                };
            },
            processResults: function(response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });



    $("#transport").select2({
        width: '100%',
        placeholder: 'Type Transport',
        ajax: {
            url: PATH + "Master/Getdata/search_transport",
            type: "post",
            allowClear: true,
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    searchTerm: params.term // search term
                };
            },
            processResults: function(response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });

    $("#warehouse").select2({
        width: '100%',
        placeholder: 'Type Warehouse Account',
        ajax: {
            url: PATH + "Master/Getdata/search_warehouse",
            type: "post",
            allowClear: true,
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    searchTerm: params.term // search term
                };
            },
            processResults: function(response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });

    $("#city").select2({
        width: '100%',
        placeholder: 'Type City',
        ajax: {
            url: PATH + "Master/Getdata/search_city",
            type: "post",
            allowClear: true,
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    searchTerm: params.term // search term
                };
            },
            processResults: function(response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });

    $("#vehicle").select2({
        width: '65%',
        placeholder: 'Type Vehicle',
        ajax: {
            url: PATH + "Master/Getdata/search_vehicle",
            type: "post",
            allowClear: true,
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    searchTerm: params.term // search term
                };
            },
            processResults: function(response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });

    $("#mill_ac").select2({
        width: '100%',
        placeholder: 'Type Mill Ac Name',
        ajax: {
            url: PATH + "Master/Getdata/search_sun_credit",
            type: "post",
            allowClear: true,
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    searchTerm: params.term // search term
                };
            },
            processResults: function(response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });

    $("#delivery").select2({
        width: 'resolve',
        placeholder: {
            id: '', // the value of the option
            text: 'None Selected'
        },
        allowClear: true,
        ajax: {
            url: PATH + "Master/Getdata/search_accountSundry_cred_debt",
            type: "post",
            allowClear: true,
            dataType: 'json',
            delay: 250,
            data: function(params) {

                return {
                    searchTerm: params.term // search term
                };
            },
            processResults: function(response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });

    $('#delivery').on('select2:select', function(e) {
        var data = e.params.data;
        console.log(data)
        $('textarea[name=delivery_code]').html(data.address);
    });


    $("#job_challan").select2({
        width: 'resolve',
        placeholder: 'Type Job Challan Name',
        ajax: {
            url: PATH + "Milling/Getdata/search_jobChallanForReturn",
            type: "post",
            allowClear: true,
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    searchTerm: params.term // search term
                };
            },
            processResults: function(response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });

    $('#job_challan').on('select2:select', function(e) {

        $(".tbody").empty();

        var suggesion = e.params.data;

        var item = suggesion.item;

        
        for (i = 0; i < item.length; i++) {

            var inp = '<input type="hidden" name="pid[]" value="' + item[i].pid + '">';
            var tds = '<tr class="' + item[i].pid + '">';
            tds += '<input type="hidden" name="ret_takaTb_ids[]" value="">';
            tds += '<input type="hidden" name="millTakaTb_ids[]" value="">';
            tds += '<input type="hidden" name="need_toDelete[]" value="">';

            tds += '<td>#</td>';

            tds += '<td>' + item[i].name + inp + '</td>';
            tds += '<td>' + item[i].hsn + '</td>';
            tds += '<td><select onchange="calculate()" name="type[]">' + item[i].uom_opt +
                '</select></td>';

            tds +=
                '<td><div class="input-group select2_height"><select  class="form-control select-sm screen" name="screen[]"></select><div class="input-group-prepend"><div class="input-group-text" style="padding:0.045rem 0.30rem;"><a data-toggle="modal" data-target="#fm_model" data-title="Add Finish Job" href="<?=url('Milling/add_finishjob_screen')?>"><i style="font-size:20px;" class="fe fe-plus-circle"></i></a></div></div></div></td>';


            tds += '<td><input id="rate" class="form-control input-sm" value="' + item[i].price +
                '" name="price[]" onchange="calculate()" readonly onkeypress="return isDesimalNumberKey(event)" value="0" required="" type="text"></td>';

            tds += '<td><input class="form-control input-sm" value="' + item[i].igst +
                '" name="igst[]" onchange="calculate()" onkeypress="return isDesimalNumberKey(event)" value="0" readonly required="" type="text"></td>';

            tds +=
                '<td><input class="form-control input-sm" id="taka" value="' + item[i].pcs +
                '" name="taka[]" onchange="calculate()" onkeypress="return isDesimalNumberKey(event)" required="" readonly type="text"></td>';

            tds +=
                '<td><input class="form-control input-sm" type="text" value="' + item[i].meter +
                '" onchange="calculate()" onkeypress="return isDesimalNumberKey(event)" id="meter" name="meter[]" required readonly></td>';

            tds +=
                '<td><input class="form-control input-sm" type="text" value="' + item[i].cut +
                '" onchange="calculate()" onkeypress="return isDesimalNumberKey(event)" name="cut[]"  readonly></td>';

            tds +=
                '<td><input class="form-control input-sm" type="text" value="' + item[i].unit +
                '" onchange="calculate()" onkeypress="return isDesimalNumberKey(event)" name="unit[]"  readonly></td>';

            tds +=
                '<td><input class="form-control input-sm" id="taka" value="" name="ret_taka[]" onchange="calculate()" onkeypress="return isDesimalNumberKey(event)" type="text"></td>';

            tds +=
                '<td><input class="form-control input-sm" type="text" value=""onchange="calculate()" onkeypress="return isDesimalNumberKey(event)"  name="ret_meter[]" ></td>';

            tds +=
                '<td><input class="form-control input-sm" id="subt" name="subtotal[]" onchange="calculate()" value="0" required="" type="text" readonly></td>';

            tds +=
                '<td><input class="form-control input-sm"  name="remark[]"  value=""  type="text" ></td>';
            tds += '</tr>';

            $('.tbody').append(tds);
            $('#code').val('');


            $('select[name="screen[]"]').select2({
                width: 'resolve',
                placeholder: 'Select JobItem',
                ajax: {
                    url: PATH + "Milling/Getdata/finishjob_item",
                    type: "post",
                    allowClear: true,
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            searchTerm: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });
            calculate();
        }
      
    });

});

function add_item(data_edit) {
    var type = 'Status';
    var data_val = $(data_edit).data('val');
    var ot_title = $(data_edit).attr('title');
    var pkno = $(data_edit).data('pk');
    var select_input = {
        "mtr": "Mtr",
        "cut": "Cut",
        "pcs": "PCS"
    };
    swal({
        title: ot_title,
        confirmButtonText: "Save",
        input: "select",
        inputValue: data_val,
        inputOptions: select_input,
        showCancelButton: !0,
        inputValidator: function(e) {
            return !e && "You need to write something!"
        }
    }).then(function(result) {

        _data = $.param({
            pk: pkno
        }) + '&' + $.param({
            val: result.value
        }) + '&' + $.param({
            type: type
        }) + '&' + $.param({
            method: $("#table_list_data").data('id')
        });

        if (result.value != undefined && result.value != '') {
            $.post(PATH + "/" + $("#table_list_data").data('module') + "/Action/Update", _data, function(data) {

                if (data.st == 'success') {
                    var selectdata = result.value;
                    $(data_edit).data('val', selectdata);
                    $(data_edit).html(select_input[selectdata]);
                    swal("success!", "Your update successfully!", "success");

                }

            });
        }
    });
}

function calculate() {

    var price = $('input[name="price[]"]').map(function() {
        return parseFloat(this.value);
    }).get();

    var igst = $('input[name="igst[]"]').map(function() {
        return parseFloat(this.value);
    }).get();

    var taka = $('input[name="ret_taka[]"]').map(function() {
        return parseFloat(this.value);
    }).get();

    var cut = $('input[name="cut[]"]').map(function() {
        return parseFloat(this.value);
    }).get();

    var return_meter = $('input[name="ret_meter[]"]').map(function() {
        return parseFloat(this.value);
    }).get();

    var is_send = $('input[name="is_send[]"]').map(function() {
        return parseFloat(this.value);
    }).get();

    var meter = $('input[name="ret_meter[]"]').map(function() {
        return parseFloat(this.value);
    }).get();



    var cut = $('input[name="cut[]"]').map(function() {
        return parseFloat(this.value);
    }).get();

  
    // Value of UOM is in the name
    var type = [];
    $('select[name="type[]"] option:selected').each(function() {
        var $this = $(this);
        if ($this.length) {
            type.push($this.text())

        }
    });
    var total = 0.0;
    var igst_amt = 0.0;
    var tot_item_brok = 0.0;
    var tot_fix_brok = 0.0;
    var mtr_total = 0;
    var return_mtr = 0;

    for (var i = 0; i < taka.length; i++) {
        if (type[i] == "PCS") {
            var sub = price[i] * taka[i];
            // var disc_amt = sub * item_disc[i] / 100;
            var final_sub = sub;
            if (isNaN(final_sub)) {
                final_sub = 0;
            }
            $('input[name="subtotal[]"]').eq(i).val(final_sub);
            igst_amt += final_sub * igst[i] / 100;
            total += final_sub;

        } else {
            if (taka[i] != '' || !isNaN(taka[i])) {
                return_mtr = taka[i] * cut[i];
                if (isNaN(return_mtr)) {
                    return_mtr = 0;
                }
                $('input[name="ret_meter[]"]').eq(i).val(return_mtr);
            }
            var sub = price[i] * return_mtr;

            var final_sub = sub;

            igst_amt += final_sub * igst[i] / 100;

            if (isNaN(final_sub)) {
                final_sub = 0;
            }
            $('input[name="subtotal[]"]').eq(i).val(final_sub);
            total += final_sub;
        }

    }

    $('.total').html(total);

    var discount = $('input[name="discount"]').val();

    var amtx = parseFloat($('input[name="amtx"]').val());
    var amty = parseFloat($('input[name="amty"]').val());
    var cess = parseFloat($('input[name="cess"]').val());
    var tds_per = $('#tds_per').val();
    var tds_limit = $('#tds_limit').val();

    if (Number.isNaN(discount)) {
        discount = 0;
    }
    if (Number.isNaN(amtx)) {
        amtx = 0;
    }
    if (Number.isNaN(amty)) {
        amty = 0;
    }
    if (Number.isNaN(cess)) {
        cess = 0;
    }
    if (Number.isNaN(tds_per)) {
        tds_per = 0;
    }

    var discount_type = $('select[name=disc_type] option').filter(':selected').val();
    var amtx_type = $('select[name=amtx_type] option').filter(':selected').val();
    var amty_type = $('select[name=amty_type] option').filter(':selected').val();
    var cess_type = $('select[name=cess_type] option').filter(':selected').val();


    if (discount_type == '%') {
        discount_amount = (total * (discount / 100));
        $('.discount_amount').html('- ' + discount_amount);
        if (discount_amount > 0) {
            var total = 0;
            var divide_disc = discount_amount / pcs.length;
            var igst_amt = 0;
            for (var i = 0; i < pcs.length; i++) {

                var sub = pcs[i] * price[i];
                //var disc_amt = sub * item_disc[i] / 100;
                var final_sub = sub;

                var abc = final_sub - divide_disc;
                igst_amt += abc * igst[i] / 100;
                total += abc;
            }
            $('.total').html(total);
        }
    } else {
        $('.discount_amount').html('- ' + discount);
        if (discount > 0) {
            var total = 0;
            var divide_disc = discount / pcs.length;
            var igst_amt = 0;
            for (var i = 0; i < pcs.length; i++) {

                var sub = pcs[i] * price[i];
                var final_sub = sub;

                var abc = final_sub - divide_disc;
                igst_amt += abc * igst[i] / 100;

                total += abc;
            }
        }
    }
    var grand_total = total;


    if (amtx_type == '%') {
        amtx_amount = (total * (amtx / 100));
        $('.amtx_amount').html('- ' + amtx_amount);
        grand_total -= amtx_amount;
    } else {
        $('.amtx_amount').html('- ' + amtx);
        grand_total -= amtx;
    }


    if (amty_type == '%') {
        amty_amount = (total * (amty / 100));
        $('.amty_amount').html('+ ' + amty_amount);
        grand_total += (total * (amty / 100));
    } else {
        $('.amty_amount').html('+ ' + amty);
        grand_total += amty;
    }


    if (cess_type == '%') {
        cess_amount = (total * (cess / 100));
        $('.cess_amount').html('+ ' + cess_amount);
        grand_total += (total * (cess / 100));
    } else {
        $('.cess_amount').html('+ ' + amty);
        grand_total += cess;
    }

    var tds_amount = 0;
    var tds_per = 0;

    if (tds_per != '') {
        tds_amount = (total * (tds_per / 100));
        grand_total += tds_amount;
    }

    var cgst = igst_amt / 2;
    var sgst = igst_amt / 2;

    var tax_option = $("#tax :selected").map(function(i, el) {
        return $(el).val();
    }).get();

    $.each(tax_option, function() {
        if (this == 'igst') {
            grand_total = grand_total + igst_amt;

        } else if (this == 'sgst') {
            grand_total = grand_total + sgst;
        } else if (this == 'cgst') {
            grand_total = grand_total + cgst;
        } else if (this == 'tds') {
            if (tds_per != '' && total > tds_limit) {
                tds_amount = (total * (tds_per / 100));
                grand_total += tds_amount;
            }
        } else {}
    });

    $('input[name="net_amount"]').val(grand_total.toFixed(2));
    $('input[name="tot_igst"]').val(igst_amt.toFixed(2));
    $('input[name="tot_cgst"]').val(cgst.toFixed(2));
    $('input[name="tot_sgst"]').val(sgst.toFixed(2));
    $('input[name="tds_amt"]').val(tds_amount.toFixed(2));

    $('.igst_amount').html('+ ' + igst_amt.toFixed(2));
    $('.cgst_amount').html('+ ' + cgst.toFixed(2));
    $('.sgst_amount').html('+ ' + sgst.toFixed(2));
    $('.cess_amount').html('+ ' + cess.toFixed(2));
    $('.tds_amount').html('+ ' + tds_amount.toFixed(2));
    $('.amty_amount').html('+ ' + amty.toFixed(2));

}


function subtotal(type) {
    var pcs = $("#pcs").val();
    var mtr = $("#mtr").val();
    var cut = $("#cut").val();
    var rate = $("#rate").val();
   

    if (type == 'pcs') {
        stotal = pcs * rate;
        
    } else if (type == 'mtr') {
        stotal = mtr * rate;
    } else {
        subtotal = cut * rate;
    }
    $("#subt").val(stotal);
    
}
</script>
<?= $this->endSection() ?>