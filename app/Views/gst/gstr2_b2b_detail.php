<?= $this->extend(THEME . 'templete') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5"> <?=$title?> </h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">GSTR2</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?=$title?></li>
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
<!--Start Navbar -->
<div class="responsive-background">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div class="advanced-search">
            <form method="get" action="<?=url('Gst/gstr2_b2b_detail')?>">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-lg-0">
                                    <label class="">From :</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fe fe-calendar lh--9 op-6"></i>
                                            </div>
                                        </div>
                                        <input class="form-control fc-datepicker" name="from" placeholder="YYYY-MM-DD"
                                            type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-lg-0">
                                    <label class="">To :</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fe fe-calendar lh--9 op-6"></i>
                                            </div>
                                        </div>
                                        <input class="form-control fc-datepicker" name="to" placeholder="YYYY-MM-DD"
                                            type="text">
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
<!--End Navbar -->

<div class="row">
    <div class="col-lg-12">
        <div class="card custom-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-fw-widget">
                        <tbody>
                            <tr>
                                <td>
                                    <span style="size:20px;"><b><?=$title?></b></span>
                                    <br>

                                    <b id="start_date"><?=user_date($start_date)?></b> to
                                    <b id="end_date"><?=user_date($end_date,2)?></b>
                                </td>
                            </tr>
                            <tr colspan="4">
                            </tr>
                        </tbody>
                    </table>
                </div>


                <div aria-multiselectable="true" class="accordion" id="accordion" role="tablist">
                    <div class="card">

                        <div class="card-header" id="headingOne" role="tab">
                            <a aria-controls="collapseOne" aria-expanded="false" data-toggle="collapse"
                                href="#collapseOne" class="collapsed">Total Voucher<label
                                    style="float:right;"><?=@$sale['count'] + @$gnrl_sale['count']?></label>
                            </a>
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
                    <table class="table table mg-b-0">
                        <thead>
                            <tr>
                                <th rowspan="2">Particular</th>
                                <th rowspan="2">Voucher Count</th>
                                <th rowspan="2">Taxable Amount</th>
                                <th colspan="4">Tax Amount</th>
                                <th colspan="4">Input Tax Credit</th>

                            </tr>

                            <tr>
                                <th>Integrated Tax Amount</th>
                                <th>Central Tax Amount</th>
                                <th>State Tax Amount</th>
                                <th>Cess Tax Amount</th>
                                <th>Integrated Tax Amount</th>
                                <th>Central Tax Amount</th>
                                <th>State Tax Amount</th>
                                <th>Cess Tax Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                                <td><a
                                        href="<?=url('gst/gstr2_b2b_invoices?from='.$start_date.'&to='.$end_date).'&type=purchase'?>">Purchase</a>
                                </td>
                                <td><?=@$purchase_b2b['data'] ? count(@$purchase_b2b['data']) : 0?></td>
                                <td><?=@$purchase_b2b['taxable_amount']?></td>
                                <td><?=@$purchase_b2b['igst']?></td>
                                <td><?=@$purchase_b2b['cgst']?></td>
                                <td><?=@$purchase_b2b['sgst']?></td>
                                <td><?=@$purchase_b2b['cess']?></td>
                                <td><?=@$purchase_b2b['igst']?></td>
                                <td><?=@$purchase_b2b['cgst']?></td>
                                <td><?=@$purchase_b2b['sgst']?></td>
                                <td><?=@$purchase_b2b['cess']?></td>
                            </tr>
                            <tr>

                                <td><a
                                        href="<?=url('gst/gstr2_b2b_invoices?from='.$start_date.'&to='.$end_date.'&type=gnrl_purchase')?>">Genral
                                        Purchase</a></td>

                                <td><?=@$gnrl_purchase_b2b['data'] ? count(@$gnrl_purchase_b2b['data']) : 0?></td>
                                <td><?=@$gnrl_purchase_b2b['taxable_amount']?></td>
                                <td><?=@$gnrl_purchase_b2b['igst']?></td>
                                <td><?=@$gnrl_purchase_b2b['cgst']?></td>
                                <td><?=@$gnrl_purchase_b2b['sgst']?></td>
                                <td><?=@$gnrl_purchase_b2b['cess']?></td>
                                <td><?=@$gnrl_purchase_b2b['igst']?></td>
                                <td><?=@$gnrl_purchase_b2b['cgst']?></td>
                                <td><?=@$gnrl_purchase_b2b['sgst']?></td>
                                <td><?=@$gnrl_purchase_b2b['cess']?></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endsection() ?>
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