<?= $this->extend(THEME . 'form') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-12">
    <form action="<?=url('Master/add_tds')?>" class="ajax-form-submit" method="post"
            enctype="multipart/form-data">
            <div class="form-group">
                <label class="form-label">Section: <span class="tx-danger">*</span></label>
                <input class="form-control" required  placeholder="Enter Section"  name="section" value="<?=@$tds['section']?>" type="text">
                <input name="id" value="<?=@$tds['id']?>" type="hidden">
            </div>
            <div class="form-group">
                <label class="form-label">Nature of pay: <span class="tx-danger">*</span></label>
                <input class="form-control" required  placeholder="Enter nature of pay" id="pay_nature"  name="pay_nature" value="<?=@$tds['pay_nature']?>" type="text">
                
            </div>
            <div class="form-group">
                <label class="form-label">Theshold Rs.: <span class="tx-danger">*</span></label>
                <input class="form-control" required placeholder="Enter Theshold" value="<?=@$tds['the_sold']?>" onkeypress="return isNumberKey(event)" name="the_sold" 
                    type="text">
            </div>
            <div class="form-group">
                <label class="form-label">Indv / HUF: <span class="tx-danger">*</span></label>
                <input class="form-control" required placeholder="Enter Indv / HUF" value="<?=@$tds['indv']?>" onkeypress="return isNumberKey(event)" name="indv" 
                    type="text">
            </div>
            <div class="form-group">
                <label class="form-label">Others: <span class="tx-danger">*</span></label>
                <input class="form-control" required placeholder="Enter Othes" value="<?=@$tds['others']?>" onkeypress="return isNumberKey(event)" name="others" 
                    type="text">
            </div>
            <div class="form-group">
                <div class="tx-danger error-msg"></div>
                <div class="tx-success form_proccessing"></div>
            </div>
            <div class="row pt-3">
                <div class="col-sm-6">
                    <p class="text-left">
                        <button class="btn btn-space btn-primary" id="save_data" type="submit">Submit</button>
                        <button class="btn btn-space btn-secondary" data-dismiss="modal">Cancel</button>
                    </p>
                </div>
            </div>
        </from>
    </div>
</div>
<script>

$('.ajax-form-submit').on('submit', function(e) {
    $('#save_data').prop('disabled', true);
    $('.error-msg').html('');
    $('.form_proccessing').html('Please wail...');
    e.preventDefault();
    var aurl = $(this).attr('action');
    $.ajax({
        type: "POST",
        url: aurl,
        data: $(this).serialize(),
        success: function(response) {
            if (response.st == 'success') {
                $('#fm_model').modal('toggle');
                swal("success!", "Your update successfully!", "success");
                datatable_load('');
                $('#save_data').prop('disabled', false);
                // window.location = "";
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

function afterload() {}
</script>

<?= $this->endSection() ?>