<?= $this->extend(THEME . 'form') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-12">
    <form action="<?=url('Master/add_billterm')?>" class="ajax-form-submit" method="post"
            enctype="multipart/form-data">
            <div class="form-group">
                <label class="form-label">Name: <span class="tx-danger">*</span></label>
                <input class="form-control" required=""  placeholder="Name" onkeyup="code_generate(this.value)"  name="name" value="<?=@$billterm['name']?>" type="text">
                <input name="id" value="<?=@$billterm['id']?>" type="hidden">
            </div>  
            <div class="form-group">
                <label class="form-label">Code: <span class="tx-danger">*</span></label>
                <input class="form-control" required=""  placeholder="Code"  id="code" name="code" value="<?=@$billterm['code']?>" type="text">
            </div>  
            <div class="form-group">
                <label class="form-label">Bill Term: <span class="tx-danger">*</span></label>
                <input class="form-control" required=""  placeholder="Bill Term"  name="billterm" value="<?=@$billterm['billterm']?>" type="text">
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