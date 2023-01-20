<?= $this->extend(THEME . 'templete') ?>

<?= $this->section('content') ?>

<div class="container">

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">Contra Register Book</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= url('') ?>"><?=@$type;?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?=@$title;?></li>
            </ol>
        </div>
        <div class="btn btn-list">
            <a href="#" class="btn ripple btn-secondary navresponsive-toggler" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fe fe-filter mr-1"></i> Filter <i class="fas fa-caret-down ml-1"></i>
            </a>
        </div>

    </div>
    <div class="responsive-background">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="advanced-search">

                <form method="post" action="<?=url('Addbook/contra')?>">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-lg-0">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            FROM:
                                        </div>
                                    </div>
                                    <input class="form-control dateMask" id="dateMask" name="from"
                                        placeholder="DD-MM-YYYY" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-lg-0">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            TO:
                                        </div>
                                    </div>
                                    <input class="form-control dateMask" id="" name="to" placeholder="DD-MM-YYYY"
                                        type="text">
                                </div>
                            </div>
                        </div>
                        
                    </div>


                    <div class="text-right mt-2">
                        <button type="submit" class="btn btn-primary">Apply</button>
                        <a href="#" id="SearchButtonReset" class="btn btn-secondary" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">Reset</a>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Page Header -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card custom-card main-content-body-profile">
                <div class="card-header card-header-divider">

                    <nav class="nav main-nav-line">
                        <a class="nav-link active" data-toggle="tab" href="#all_data">All Data</a>
                        <a class="nav-link" data-toggle="tab" href="#month">Month</a>
                    </nav>

                    <div class="card-body tab-content h-100">
                        <div class="tab-pane active" id="all_data">
                            <div class="table-responsive">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered table-fw-widget">
                                        <tr>
                                            <td>
                                                <span style="size:20px;"><b><?=@$type;?></b></span>
                                                </br>

                                                <b><?=user_date($start_date); ?></b> to
                                                <b><?=user_date($end_date); ?></b>

                                            </td>
                                        </tr>
                                        <tr colspan="4">
                                        </tr>
                                    </table>
                                </div>
                                <table class="table mg-b-0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Particular</th>
                                            <th>Voucher Type</th>
                                            <th>Vch ID</th>
                                            <th>Payment Type</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                            <th>Closing</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $closing = 0;
                                            if(!empty($contra_vch))
                                            {
                                                foreach($contra_vch as $row)
                                                {
                                                    $closing +=(float)$row['amount'];
                                                       
                                        ?>
                                        <tr>
                                            <td><?=user_date($row['date']);?></td>
                                            <td><?=@$row['account_name'];?></td>
                                            <td><?=@$row['payment_type'];?></td>
                                            <td><?=@$row['id'];?></td>
                                            <td><?=@$row['cash_type'];?></td>
                                            <td> </td>
                                            <td><?=@$row['amount'];?></td>
                                            <td><?=$closing;?></td>
                                        </tr>

                                        <?php
                                                }
                                            }
                                        ?>

                                    <tfoot>
                                        <th colspan="5">
                                            <center>Closing</center>
                                        </th>
                                        <th></th>
                                        <th><?=$closing;?> CR</th>
                                        <th><?=$closing;?> CR</th>
                                    </tfoot>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane " id="month">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-fw-widget">
                                    <tr>
                                        <td>
                                            <span style="size:20px;"><b>Contra Voucher</b></span>
                                            </br>
                                            <b><?=user_date($date['from']); ?></b> to
                                            <b><?=user_date($date['to']); ?></b>
                                        </td>
                                    </tr>
                                    <tr colspan="4">
                                    </tr>
                                </table>
                            </div>
                            <?php $closing = 0;?>
                            <div class="row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="table-responsive">
                                        <table class="table main-table-reference mt-0 mb-0 text-center">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <h5>Month</h5>
                                                    </th>
                                                    <th>
                                                        <h5>Voucher</h5>
                                                    </th>
                                                    <th>
                                                        <h5>Debit</h5>
                                                    </th>
                                                    <th>
                                                        <h5>Credit</h5>
                                                    </th>
                                                    <th>
                                                        <h5>Closing</h5>
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody>

                                                <tr>
                                                    <td><a
                                                            href="<?=url('Addbook/Contra_voucher_wise?month=4&year='.@$contra[4]['year'])?>">April</a>
                                                    </td>
                                                    <td><?=isset($contra[4]['voucher_count']) ? $contra[4]['voucher_count'] :0;?>
                                                    </td>
                                                    <td></td>
                                                    <td><?=isset($contra[4]['total']) ? number_format($contra[4]['total'],2) :0;?>
                                                    </td>
                                                    <td><?=isset($contra[4]['total']) ? number_format(($closing = $closing + (float)$contra[4]['total']),2) : number_format($closing,2);?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><a
                                                            href="<?=url('Addbook/Contra_voucher_wise?month=5&year='.@$contra[5]['year'])?>">May</a>
                                                    </td>
                                                    <td><?=isset($contra[5]['voucher_count']) ? $contra[5]['voucher_count'] :0;?>
                                                    </td>
                                                    <td></td>
                                                    <td><?=isset($contra[5]['total']) ? number_format($contra[5]['total'],2) :0;?>
                                                    </td>
                                                    <td><?=isset($contra[5]['total']) ? number_format(($closing = $closing+ (float)$contra[5]['total']),2) : number_format($closing,2);?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><a
                                                            href="<?=url('Addbook/Contra_voucher_wise?month=6&year='.@$contra[6]['year'])?>">June</a>
                                                    </td>
                                                    <td><?=isset($contra[6]['voucher_count']) ? $contra[6]['voucher_count'] :0;?>
                                                    </td>
                                                    <td></td>
                                                    <td><?=isset($contra[6]['total']) ? number_format($contra[6]['total'],2) :0;?>
                                                    </td>
                                                    <td><?=isset($contra[6]['total']) ? number_format(($closing = $closing + (float)$contra[6]['total']),2) : number_format($closing,2);?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><a
                                                            href="<?=url('Addbook/Contra_voucher_wise?month=7&year='.@$contra[7]['year'])?>">July</a>
                                                    </td>
                                                    <td><?=isset($contra[7]['voucher_count']) ? $contra[7]['voucher_count'] :0;?>
                                                    </td>
                                                    <td></td>
                                                    <td><?=isset($contra[7]['total']) ? number_format($contra[7]['total'],2) :0;?>
                                                    </td>
                                                    <td><?=isset($contra[7]['total']) ? number_format(($closing =$closing + (float)$contra[7]['total']),2) : number_format($closing,2);?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><a
                                                            href="<?=url('Addbook/Contra_voucher_wise?month=8&year='.@$contra[8]['year'])?>">Auguest</a>
                                                    </td>
                                                    <td><?=isset($contra[8]['voucher_count']) ? $contra[8]['voucher_count'] :0;?>
                                                    </td>
                                                    <td></td>
                                                    <td><?=isset($contra[8]['total']) ? number_format($contra[8]['total'],2) :0;?>
                                                    </td>
                                                    <td><?=isset($contra[8]['total']) ? number_format(($closing = $closing + (float)$contra[8]['total']),2) : number_format($closing,2);?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><a
                                                            href="<?=url('Addbook/Contra_voucher_wise?month=9&year='.@$contra[9]['year'])?>">September</a>
                                                    </td>
                                                    <td><?=isset($contra[9]['voucher_count']) ? $contra[9]['voucher_count'] :0;?>
                                                    </td>
                                                    <td></td>
                                                    <td><?=isset($contra[9]['total']) ? number_format($contra[9]['total'],2) :0;?>
                                                    </td>
                                                    <td><?=isset($contra[9]['total']) ? number_format(($closing = $closing+ (float)$contra[9]['total']),2) : number_format($closing,2);?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><a
                                                            href="<?=url('Addbook/Contra_voucher_wise?month=10&year='.@$contra[10]['year'])?>">October</a>
                                                    </td>
                                                    <td><?=isset($contra[10]['voucher_count']) ? $contra[10]['voucher_count'] :0;?>
                                                    </td>
                                                    <td></td>
                                                    <td><?=isset($contra[10]['total']) ? number_format($contra[10]['total'],2) :0;?>
                                                    </td>
                                                    <td><?=isset($contra[10]['total']) ? number_format(($closing = $closing + (float)$contra[10]['total']),2) : number_format($closing,2);?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><a
                                                            href="<?=url('Addbook/Contra_voucher_wise?month=11&year='.@$contra[11]['year'])?>">November</a>
                                                    </td>
                                                    <td><?=isset($contra[11]['voucher_count']) ? $contra[11]['voucher_count'] :0;?>
                                                    </td>
                                                    <td></td>
                                                    <td><?=isset($contra[11]['total']) ? number_format($contra[11]['total'],2) :0;?>
                                                    </td>
                                                    <td><?=isset($contra[11]['total']) ? number_format(($closing =$closing + (float)$contra[11]['total']),2) : number_format($closing,2);?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><a
                                                            href="<?=url('Addbook/Contra_voucher_wise?month=12&year='.@$contra[12]['year'])?>">December</a>
                                                    </td>
                                                    <td><?=isset($contra[12]['voucher_count']) ? $contra[12]['voucher_count'] :0;?>
                                                    </td>
                                                    <td></td>
                                                    <td><?=isset($contra[12]['total']) ? number_format($contra[12]['total'],2) :0;?>
                                                    </td>
                                                    <td><?=isset($contra[12]['total']) ? number_format(($closing = $closing + (float)$contra[12]['total']),2) : number_format($closing,2);?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><a
                                                            href="<?=url('Addbook/Contra_voucher_wise?month=1&year='.@$contra[1]['year'])?>">January</a>
                                                    </td>
                                                    <td><?=isset($contra[1]['voucher_count']) ? $contra[1]['voucher_count'] :0;?>
                                                    </td>
                                                    <td></td>
                                                    <td><?=isset($contra[1]['total']) ? number_format($contra[1]['total'],2) :0;?>
                                                    </td>
                                                    <td><?=isset($contra[1]['total']) ? number_format(($closing = $closing + (float)$contra[1]['total']),2) : number_format($closing,2);?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><a
                                                            href="<?=url('Addbook/Contra_voucher_wise?month=2&year='.@$contra[2]['year'])?>">February</a>
                                                    </td>
                                                    <td><?=isset($contra[2]['voucher_count']) ? $contra[2]['voucher_count'] :0;?>
                                                    </td>
                                                    <td></td>
                                                    <td><?=isset($contra[2]['total']) ? number_format($contra[2]['total'],2) :0;?>
                                                    </td>
                                                    <td><?=isset($contra[2]['total']) ? number_format(($closing = $closing + (float)$contra[2]['total']),2) : number_format($closing,2);?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><a
                                                            href="<?=url('Addbook/Contra_voucher_wise?month=3&year='.@$contra[3]['year'])?>">March</a>
                                                    </td>
                                                    <td><?=isset($contra[3]['voucher_count']) ? $contra[3]['voucher_count'] :0;?>
                                                    </td>
                                                    <td></td>
                                                    <td><?=isset($contra[3]['total']) ? number_format($contra[3]['total'],2) :0;?>
                                                    </td>
                                                    <td><?=isset($contra[3]['total']) ? number_format(($closing = $closing + (float)$contra[3]['total']),2) : number_format($closing,2);?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <?php 
                                                $total = 0;
                                                foreach($contra as  $row){
                                                    $total += $row['total'];
                                                } 
                                            ?>
                                            <tfooter>
                                                <tr>
                                                    <th colspan="2">
                                                        <h4>Total</h4>
                                                    </th>
                                                    <th></th>
                                                    <th>
                                                        <h4><?=number_format(@$total,2)?> CR</h4>
                                                    </th>
                                                    <th>
                                                        <h4><?=number_format(@$closing,2)?> CR</h4>
                                                    </th>
                                                </tr>
                                            </tfooter>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane " id="auction">
                            <div class="table-responsive">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script type="text/javascript">
$(document).ready(function() {
    $('.fc-datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        showOtherMonths: true,
        selectOtherMonths: true
    });
    $('.dateMask').mask('99-99-9999');

    $('.select2').select2({
        minimumResultsForSearch: Infinity,
        placeholder: 'Choose one',
        width: '100%'
    });

    $('#bills').on('select2:select', function(e) {
        var data = e.params.data;

        $('#bill_tb').val(data.table);
    });

    $("#account").select2({
        width: 'resolve',
        placeholder: 'Type Account',
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
});
</script>

<?= $this->endSection() ?>