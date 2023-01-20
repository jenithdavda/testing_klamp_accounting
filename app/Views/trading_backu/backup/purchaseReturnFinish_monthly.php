<?= $this->extend(THEME . 'templete') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <div class="col-lg-12">
            <h2 class="main-content-title tx-24 mg-b-5"><?=$title?></h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Trading</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?=$title?></li>
            </ol>
        </div>
    </div>

    <div class="btn btn-list">
        <a href="#" class="btn ripple btn-secondary navresponsive-toggler" data-toggle="collapse"
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <i class="fe fe-filter mr-1"></i> Filter <i class="fas fa-caret-down ml-1"></i>
        </a>
    </div>
</div>
<!--Start Navbar -->

<div class="responsive-background">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div class="advanced-search">
            <form method="post" action="<?=url('Trading/purchaseReturnFinish_monthly')?>">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-lg-0">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                FROM:
                                            </div>
                                        </div>
                                        <input class="form-control dateMask" id="dateMask" name="from" required
                                            placeholder="DD-MM-YYYY" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-lg-0">
                                    <!-- <label class="">To :</label> -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                TO:
                                            </div>
                                        </div>
                                        <input class="form-control dateMask" id="dateMask" name="to" required
                                            placeholder="DD-MM-YYYY" type="text">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Apply</button>
                    <a href="#" id="SearchButtonReset" class="btn btn-secondary" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">Reset</a>

                </div>
            </form>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card custom-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-fw-widget">
                        <tr>
                            <td>
                                <span style="size:20px;"><b><?=$title?></b></span>
                                </br>
                                <?php
                                    $from =date_create($date['from']) ;                                         
                                    $to = date_create($date['to']);
                                ?>
                                <b><?=date_format($from,"d/m/Y"); ?></b> to
                                <b><?=date_format($to,"d/m/Y"); ?></b>

                            </td>
                        </tr>
                        <tr colspan="4">
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="table-responsive">
                            <table class="table main-table-reference mt-0 mb-0 text-center">
                                <thead>
                                    <tr>
                                        <th><h5>Month</h5></th>
                                        <th><h5>Total Taxable</h5></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    
                                    <tr>
                                        <td><a href="<?=url('Trading/purchaseReturnFinish_voucher_wise?month=4&year='.@$purchase[4]['year'])?>">April</a></td>
                                        <td><?=isset($purchase[4]['total']) ? $purchase[4]['total'] :0;?></td>
                                    </tr>

                                    <tr>
                                        <td><a href="<?=url('Trading/purchaseReturnFinish_voucher_wise?month=5&year='.@$purchase[5]['year'])?>">May</a></td>
                                        <td><?=isset($purchase[5]['total'])  ? $purchase[5]['total'] :0;?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td><a href="<?=url('Trading/purchaseReturnFinish_voucher_wise?month=6&year='.@$purchase[6]['year'])?>">June</a></td>
                                        <td><?=isset($purchase[6]['total'])  ? $purchase[6]['total'] :0;?></td>
                                    </tr>

                                    <tr>
                                        <td><a href="<?=url('Trading/purchaseReturnFinish_voucher_wise?month=7&year='.@$purchase[7]['year'])?>">July</a></td>
                                        <td><?=isset($purchase[7]['total']) ? $purchase[7]['total'] :0;?></td>
                                    </tr>

                                    <tr>
                                        <td><a href="<?=url('Trading/purchaseReturnFinish_voucher_wise?month=8&year='.@$purchase[8]['year'])?>">August</a></td>
                                        <td><?=isset($purchase[8]['total']) ? $purchase[8]['total'] :0;?></td>
                                    </tr>

                                    <tr>
                                        <td><a href="<?=url('Trading/purchaseReturnFinish_voucher_wise?month=9&year='.@$purchase[9]['year'])?>">September</a></td>
                                        <td><?=isset($purchase[9]['total']) ? $purchase[9]['total'] :0;?></td>
                                    </tr>

                                    <tr>
                                        <td><a href="<?=url('Trading/purchaseReturnFinish_voucher_wise?month=10&year='.@$purchase[10]['year'])?>">October</a></td>
                                        <td><?=isset($purchase[10]['total']) ? $purchase[10]['total'] :0;?></td>
                                    </tr>

                                    <tr>
                                        <td><a href="<?=url('Trading/purchaseReturnFinish_voucher_wise?month=11&year='.@$purchase[11]['year'])?>">November</a></td>
                                        <td><?=isset($purchase[11]['total']) ? $purchase[11]['total'] :0;?></td>
                                    </tr>

                                    <tr>
                                        <td><a href="<?=url('Trading/purchaseReturnFinish_voucher_wise?month=12&year='.@$purchase[12]['year'])?>">December</a></td>
                                        <td><?=isset($purchase[12]['total']) ? $purchase[12]['total'] :0;?></td>
                                    </tr>

                                    <tr>
                                        <td><a href="<?=url('Trading/purchaseReturnFinish_voucher_wise?month=1&year='.@$purchase[1]['year'])?>">January</a></td>
                                        <td><?=isset($purchase[1]['total']) ? $purchase[1]['total'] :0;?></td>
                                    </tr>

                                    <tr>
                                        <td><a href="<?=url('Trading/purchaseReturnFinish_voucher_wise?month=2&year='.@$purchase[2]['year'])?>">February</a></td>
                                        <td><?=isset($purchase[2]['total']) ? $purchase[2]['total'] :0;?></td>
                                    </tr>

                                    <tr>
                                        <td><a href="<?=url('Trading/purchaseReturnFinish_voucher_wise?month=3&year='.@$purchase[3]['year'])?>">March</a></td>
                                        <td><?=isset($purchase[3]['total']) ? $purchase[3]['total'] :0;?></td>
                                    </tr>
                                </tbody>
                                <?php 
                                $total = 0;
                                foreach($purchase as $row){
                                    $total += $row['total'];
                                } ?>
                                <tfooter>
                                    <tr>
                                        <th><h4>Total</h4></th>
                                        <th><h4><?=$total?></h4></th>
                                    </tr>
                                </tfooter>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End Navbar -->




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

});
</script>
<?= $this->endSection() ?>