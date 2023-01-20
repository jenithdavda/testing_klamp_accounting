<?= $this->extend(THEME . 'templete') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5"> <?= $title ?> </h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Other</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
        </ol>
    </div>
    <div class="btn btn-list">

        <a href="#" class="btn ripple btn-secondary navresponsive-toggler collapsed" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="true" aria-label="Toggle navigation">
            <i class="fe fe-filter mr-1"></i> Filter <i class="fas fa-caret-down ml-1"></i>
        </a>
        <!-- <a href="#" class="btn ripple btn-secondary navresponsive-toggler collapsed" data-toggle="collapse" data-target="#navbarSupportedContentnew" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fe fe-plus mr-1"></i> Add JV <i class="fas fa-caret-down ml-1"></i>
        </a> -->

    </div>

</div>
<div class="responsive-background">
    <div class="navbar-collapse collapse show" id="navbarSupportedContent">
        <div class="advanced-search">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-lg-0">
                            <label class="">Particular :</label>
                            <div class="input-group">
                                <select class="form-control select2" id="party_account_new" onchange="" name="account_id_new" required>

                                </select>
                            </div>
                            <div class="form-group">
                                <div class="tx-danger error-msg-invoice"></div>
                                <div class="tx-success form_proccessing_invoice"></div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card custom-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-fw-widget">
                        <tbody>
                            <tr>
                                <td>
                                    <span style="size:20px;"><b>JV Invoice List</b></span><br>
                                    <span style="size:20px;"><b><?= @$account_name ?></b></span>


                                    <?php
                                    if (!empty($month)) {
                                        $monthNum  = @$month;
                                        $monthName = date('F', mktime(0, 0, 0, $monthNum, 10));
                                    ?>

                                        <br>
                                        <b id="start_date">Month: </b><?= @$monthName; ?>
                                        <b id="end_date">Year: </b><?= @$year; ?>
                                    <?php
                                    }
                                    ?>




                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <form method="post" id="date_submit">
                                        <div class="row align-items-center">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group mb-lg-0">
                                                            <label class="">Account :</label>
                                                            <div class="input-group">
                                                                <select class="form-control select2" id="party_account" onchange="" name="account_id" required>

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group mb-lg-0">
                                                            <label class="">Month :</label>
                                                            <div class="input-group">
                                                                <select class="form-control select2" id="month" onchange="" name="month" required>
                                                                    <option value="01">January</option>
                                                                    <option value="02">February</option>
                                                                    <option value="03">March</option>
                                                                    <option value="04">April</option>
                                                                    <option value="05">May</option>
                                                                    <option value="06">June</option>
                                                                    <option value="07">July</option>
                                                                    <option value="08">August</option>
                                                                    <option value="09">September</option>
                                                                    <option value="10">October</option>
                                                                    <option value="11">November</option>
                                                                    <option value="12">December</option>

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group mb-lg-0">
                                                            <label class="">Year :</label>
                                                            <div class="input-group">
                                                                <select class="form-control select2" id="year" onchange="" name="year" required>
                                                                    <option value="1997">1997</option>
                                                                    <option value="1998">1998</option>
                                                                    <option value="1999">1999</option>
                                                                    <option value="2000">2000</option>
                                                                    <option value="2001">2001</option>
                                                                    <option value="2002">2002</option>
                                                                    <option value="2003">2003</option>
                                                                    <option value="2004">2004</option>
                                                                    <option value="2005">2005</option>
                                                                    <option value="2006">2006</option>
                                                                    <option value="2007">2007</option>
                                                                    <option value="2008">2008</option>
                                                                    <option value="2009">2009</option>
                                                                    <option value="2010">2010</option>
                                                                    <option value="2011">2011</option>
                                                                    <option value="2012">2012</option>
                                                                    <option value="2013">2013</option>
                                                                    <option value="2014">2014</option>
                                                                    <option value="2015">2015</option>
                                                                    <option value="2016">2016</option>
                                                                    <option value="2017">2017</option>
                                                                    <option value="2018">2018</option>
                                                                    <option value="2019">2019</option>
                                                                    <option value="2020">2020</option>
                                                                    <option value="2021">2021</option>
                                                                    <option selected value="2022">2022</option>
                                                                    <option value="2023">2023</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        </br>
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary">Apply</button>
                                            <!-- <button type="reset" class="btn btn-secondary">Reset</button> -->
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="row">
    <div class="col-lg-12">
        <div class="card custom-card main-content-body-profile">
            <div class="card-header card-header-divider">
                <nav class="nav main-nav-line">
                    <a class="nav-link active" data-toggle="tab" href="#invoice">Invoice</a>
                    <a class="nav-link" data-toggle="tab" href="#return">Return</a>
                </nav>
                <div class="card-body tab-content h-100">
                    <div class="tab-pane active" id="invoice">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-fw-widget" id="table_list_data" data-id="ac_invoice" data-module="sales" data-filter_data='invoice'>
                                <thead>
                                    <tr>
                                        <!-- <th>Invoice Id</th> -->
                                        <th>Party Account</th>
                                        <th>Net Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php


                                    if (isset($invoice_list)) {
                                        //echo '<pre>';Print_r($invoice_list);exit;
                                        $total_amt = 0;
                                        $isactive = array();
                                        foreach ($invoice_list as $row) {

                                            if ($row['is_update'] == 1 && ($row['is_cancle'] == 1 || $row['is_delete'] == 1)) {
                                                $total_amt += 0;
                                            } else {
                                                $total_amt += $row['total'];
                                            }
                                            // if ($row['jv_pass'] == 0) {
                                            //     $isactive[] = 2;
                                            // } elseif ($row['jv_pass'] == 1 && $row['is_delete'] == 0 && $row['is_update'] == 0 && $row['is_cancle'] == 0) {
                                            //     $isactive[] = 0;
                                            // } else {
                                            //     $isactive[] = 1;
                                            // }
                                            if($row['jv_pass'] == 0)
                                            {
                                                $isactive[] = 0;
                                            }
                                            elseif($row['jv_pass'] == 1 && $row['is_update'] == 0)
                                            {
                                                $isactive[] = 1;
                                            }
                                            elseif($row['jv_pass'] == 1 && $row['is_update'] == 1)
                                            {
                                                $isactive[] = 2;
                                            }
                                        }

                                        //echo '<pre>';Print_r($isactive);exit;

                                    ?>
                                        <tr>

                                            <td><?= @$row['party_account_name']; ?></td>
                                            <td><?= @$total_amt; ?></td>
                                            <td>
                                                <form method="post" action="<?= url('Testing/add_jv_invoice') ?>" class="ajax-form-submit-invoice" method="POST" id="jv_form_invoice">
                                                    <input type="hidden" name="debit_party_account" value="<?= @$row['party_account']; ?>">
                                                    <input type="hidden" name="total" value="<?= @$total_amt; ?>">
                                                    <input type="hidden" name="month" value="<?= @$month; ?>">
                                                    <input type="hidden" name="year" value="<?= @$year; ?>">
                                                    <input type="hidden" name="type" value="invoice">
                                                    <input type="hidden" name="credit_party_account" id="account_new_id" value="">
                                                   <?php
                                                   if (count(array_unique($isactive)) === 1 && end($isactive) === 0) {
                                                    ?>
                                                     <button type="submit" class="btn btn-primary">Add JV</button>
                                               
                                                    <?php
                                                    }
                                                    elseif (count(array_unique($isactive)) === 1 && end($isactive) === 2) {
                                                    
                                                    ?>
                                                    <button type="submit" class="btn btn-primary" disabled>Update JV</button>
                                                    <?php
                                                    }
                                                    else
                                                    {
                                                    ?>
                                                    <button type="submit" class="btn btn-primary">Update JV</button>
                                                 
                                                    <?php
                                                    }
                                                   
                                                    
                                                   ?>

                                                </form>
                                            </td>
                                        </tr>
                                    <?php

                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>

                    <div class="tab-pane" id="return">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="table_list_data1" data-id="ac_invoice" data-module="sales" data-filter_data="return">
                                <thead>
                                    <tr>
                                        <!-- <th>Id</th> -->
                                        <th>Party Account</th>
                                        <th>Net Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($return_list)) {

                                        $total_amt = 0;
                                        $isactive = array();
                                        foreach ($return_list as $row) {
                                            if ($row['is_update'] == 1 && ($row['is_cancle'] == 1 || $row['is_delete'] == 1)) {
                                                $total_amt += 0;
                                            } else {
                                                $total_amt += $row['total'];
                                            }
                                            if($row['jv_pass'] == 0)
                                            {
                                                $isactive[] = 0;
                                            }
                                            elseif($row['jv_pass'] == 1 && $row['is_update'] == 0)
                                            {
                                                $isactive[] = 1;
                                            }
                                            elseif($row['jv_pass'] == 1 && $row['is_update'] == 1)
                                            {
                                                $isactive[] = 2;
                                            }
                                        }
                                    ?>
                                        <tr>

                                            <td><?= @$row['party_account_name']; ?></td>
                                            <td><?= @$total_amt; ?></td>
                                            <td>
                                                <form method="post" action="<?= url('Testing/add_jv_return') ?>" class="ajax-form-submit-return" method="POST" id="jv_form_return">
                                                    <input type="hidden" name="credit_party_account" value="<?= @$row['party_account']; ?>">
                                                    <input type="hidden" name="total" value="<?= @$total_amt; ?>">
                                                    <input type="hidden" name="month" value="<?= @$month; ?>">
                                                    <input type="hidden" name="year" value="<?= @$year; ?>">
                                                    <input type="hidden" name="type" value="return">
                                                    <input type="hidden" name="debit_party_account" id="daccount_new_id" value="">
                                                    <?php
                                                   if (count(array_unique($isactive)) === 1 && end($isactive) === 0) {
                                                    ?>
                                                     <button type="submit" class="btn btn-primary">Add JV</button>
                                               
                                                    <?php
                                                    }
                                                    elseif (count(array_unique($isactive)) === 1 && end($isactive) === 2) {
                                                    
                                                    ?>
                                                    <button type="submit" class="btn btn-primary" disabled>Update JV</button>
                                                    <?php
                                                    }
                                                    else
                                                    {
                                                    ?>
                                                    <button type="submit" class="btn btn-primary">Update JV</button>
                                                 
                                                    <?php
                                                    }
                                                   
                                                    
                                                   ?>


                                                </form>
                                            </td>
                                        </tr>
                                    <?php
                                    }

                                    ?>
                                </tbody>

                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endsection() ?>
<?= $this->section('scripts') ?>
<script type="text/javascript">
    $('#table_list_data').DataTable();
    $('#table_list_data1').DataTable();
    $(document).ready(function() {
        $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            showOtherMonths: true,
            selectOtherMonths: true
        });
        $('.dateMask').mask('99-99-9999');
        $('.select2').select2({
            //minimumResultsForSearch: Infinity,
            placeholder: 'Choose one',
            width: '100%'
        });
        $("#party_account").select2({

            width: '100%',
            placeholder: 'Type Party Account',
            ajax: {
                url: PATH + "Master/Getdata/search_account",
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
        $("#party_account_new").select2({

            width: '100%',
            placeholder: 'Type Party Account',
            ajax: {
                url: PATH + "Master/Getdata/search_account",
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
                    // console.log(response);
                    return {
                        results: response

                    };
                },
                cache: true
            }
        });
        $('#party_account_new').on('select2:select', function(e) {
            var suggestion = e.params.data;
            $("#account_new_id").val(suggestion.data.id);
            $("#daccount_new_id").val(suggestion.data.id);
        });

        $('.ajax-form-submit-invoice').on('submit', function(e) {
            $('#save_data_invoice').prop('disabled', true);
            $('.error-msg-invoice').html('');
            $('.form_proccessing_invoice').html('Please wait...');
            e.preventDefault();
            var aurl = $(this).attr('action');
            var form = $(this);
            var formdata = false;

            if (window.FormData) {
                formdata = new FormData(form[0]);
            }
            $.ajax({
                type: "POST",
                url: aurl,
                cache: false,
                contentType: false,
                processData: false,
                data: formdata ? formdata : form.serialize(),
                success: function(response) {
                    if (response.st == 'success') {
                        window.location = "<?= url('Testing/Invoice_list') ?>"
                    } else {
                        $('.form_proccessing_invoice').html('');
                        $('#save_data_invoice').prop('disabled', false);
                        $('.error-msg-invoice').html(response.msg);
                    }
                },
                error: function() {
                    $('#save_data_invoice').prop('disabled', false);
                    alert('Error');
                }
            });
            return false;
        });
        $('.ajax-form-submit-return').on('submit', function(e) {
            $('#save_data_return').prop('disabled', true);
            $('.error-msg-invoice').html('');
            $('.form_proccessing_invoice').html('Please wait...');
            e.preventDefault();
            var aurl = $(this).attr('action');
            var form = $(this);
            var formdata = false;

            if (window.FormData) {
                formdata = new FormData(form[0]);
            }
            $.ajax({
                type: "POST",
                url: aurl,
                cache: false,
                contentType: false,
                processData: false,
                data: formdata ? formdata : form.serialize(),
                success: function(response) {
                    if (response.st == 'success') {
                        window.location = "<?= url('Testing/Invoice_list') ?>"
                    } else {
                        $('.form_proccessing_invoice').html('');
                        $('#save_data_return').prop('disabled', false);
                        $('.error-msg-invoice').html(response.msg);
                    }
                },
                error: function() {
                    $('#save_data_return').prop('disabled', false);
                    alert('Error');
                }
            });
            return false;
        });
    });
</script>
<?= $this->endSection() ?>