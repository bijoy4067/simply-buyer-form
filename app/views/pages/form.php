<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simple Php Form</title>
    <?php require APPROOT . '/views/layouts/styles.php'; ?>
</head>
<body>
    <div class="container">
        <form method="post" class="p-3" action="" id="submit_form">
            <h2>Buyer Form</h2>
            <div class="row">
                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <label>Buyer Name: <span class="text-danger">*</span></label>
                        <input type="text" id="buyer" name="buyer" class="form-control" placeholder="Enter buyer Name">
                    </div>
                </div>
                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <label>Buyer Email: <span class="text-danger">*</span></label>
                        <input type="email" id="buyer_email" name="buyer_email" class="form-control" placeholder="Enter buyer Email">
                    </div>
                </div>
                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <label>Buyer Phone: <span class="text-danger">*</span></label>
                        <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter buyer Phone">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12 col-sm-3">
                    <div class="form-group">
                        <label>Amount: <span class="text-danger">*</span></label>
                        <input type="number" id="amount" name="amount" class="form-control" placeholder="Enter Amount">
                    </div>
                </div>
                <div class="col-12 col-sm-3">
                    <div class="form-group">
                        <label>City: <span class="text-danger">*</span></label>
                        <input type="text" id="city" name="city" class="form-control" placeholder="Enter City">
                    </div>
                </div>
                <div class="col-12 col-sm-3">
                    <div class="form-group">
                        <label>Receipt Id: <span class="text-danger">*</span></label>
                        <input type="text" id="receipt_id" name="receipt_id" class="form-control" placeholder="Enter Receipt Id">
                    </div>
                </div>
                <div class="col-12 col-sm-3">
                    <div class="form-group">
                        <label>Entry By: <span class="text-danger">*</span></label>
                        <input type="number" id="entry_by" name="entry_by" class="form-control" placeholder="Enter By">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <label>Items: <span class="text-danger">*</span></label>
                        <div class="input-group mt-2">
                            <input type="text" id="items" name="items[]" class="form-control" placeholder="Enter items">
                            <span class="input-group-btn pl-3">
                                <button type="button" class="btn btn-danger plus-btn"><i class="fas fa-plus"></i></button>
                            </span>
                        </div>
                        <div id="items-container"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-sm-7">
                    <div class="form-group">
                        <label>Note: <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="note" name="note"></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-sm-3">
                    <div class="form-group">
                        <button class="btn btn-warning" <?php if ($_COOKIE['submit_form']) echo 'data-toggle="tooltip" data-placement="top" title="You Can Submit twice within 24 Hours" disabled'?>>Submit</button>
                        <a href="<?= BASEURL?>?url=form/index" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <?php require APPROOT . '/views/layouts/scripts.php'; ?>

    <script type="text/javascript">
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();

            $('#submit_form').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: '<?= BASEURL ?>?url=form/submit',
                    method: 'post',
                    data: $(this).serialize(),
                    success: function(data) {
                        var response = JSON.parse(data);

                        if (response.type == 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Successfull',
                                text: 'Data is inserted',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '<?= BASEURL?>?url=form'
                                }
                            });
                        }
                    },
                    error: function(error) {
                        var errors = JSON.parse(error.responseText);
                        $.each(errors, function(key, value) {
                            $('#'+key).addClass('is-invalid');
                            $('#'+key).after('<div class="d-block invalid-feedback">'+value+'</div>');
                        })
                    }
                })
            });

            $('.plus-btn').click(function() {
                var inputGroup = $(this).closest('.input-group');
                var clonedInput = inputGroup.clone();
                clonedInput.find('input').val('');
                clonedInput.find('.plus-btn').removeClass('is-valid').removeClass('plus-btn').addClass('minus-btn').html('<i class="fas fa-minus"></i>');
                $('#items-container').append(clonedInput);
            });

            $('#note').richText({
                height: 0,
                heightPercentage: 0,
            });

            $(document).on('click', '.minus-btn', function() {
                $(this).closest('.input-group').remove();
            });

            $('#buyer').blur(function(e) {
                var value = $(this).val().length;
                if (value > 0 && value < 255) {
                    $(this).removeClass('is-invalid');
                    $(this).addClass('is-valid');
                    $(this).siblings('.invalid-feedback').remove();
                }
            });

            $('#buyer_email').blur(function(e) {
                var value = $(this).val().length;
                if (value > 0 && value < 50) {
                    $(this).removeClass('is-invalid');
                    $(this).addClass('is-valid');
                    $(this).siblings('.invalid-feedback').remove();
                }
            });

            $('#phone').click(function() {
                if ($(this).val().length == 0) {
                    $(this).val('880');
                } 
                if($(this).val().length < 20) {
                    $(this).removeClass('is-invalid');
                    $(this).addClass('is-valid');
                    $(this).siblings('.invalid-feedback').remove();
                } else {
                    $(this).addClass('is-invalid');
                }
            });

            $('#phone').on('keydown', function(e) {
                var key = e.keyCode || e.which;

                if (!(key >= 48 && key <= 57) && !(key >= 96 && key <= 105) && key !== 8 && key !== 46 && key !== 37 && key !== 39) {
                    e.preventDefault();
                    $(this).siblings('.invalid-feedback').remove();
                    $(this).addClass('is-invalid');
                    $(this).after('<div class="d-block invalid-feedback">Input Digit only</div>');
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).addClass('is-valid');
                    $(this).siblings('.invalid-feedback').remove();
                }
            });

            $('#items').blur(function(e) {
                value = $(this).val().length;
                if (value > 0 && value < 255) {
                    $(this).removeClass('is-invalid');
                    $(this).addClass('is-valid');
                    $(this).siblings('.invalid-feedback').remove();
                }
            });

            $('#amount').blur(function(e) {
                value = $(this).val().length;
                if (value > 0 && value < 20) {
                    $(this).removeClass('is-invalid');
                    $(this).addClass('is-valid');
                    $(this).siblings('.invalid-feedback').remove();
                }
            });

            $('#city').blur(function(e) {
                value = $(this).val().length;
                if (value > 0 && value < 20) {
                    $(this).removeClass('is-invalid');
                    $(this).addClass('is-valid');
                    $(this).siblings('.invalid-feedback').remove();
                }
            });

            $('#receipt_id').blur(function(e) {
                value = $(this).val().length;
                if (value > 0 && value < 20) {
                    $(this).removeClass('is-invalid');
                    $(this).addClass('is-valid');
                    $(this).siblings('.invalid-feedback').remove();
                }
            });

            $('#entry_by').blur(function(e) {
                value = $(this).val().length;
                if (value > 0 && value < 10) {
                    $(this).removeClass('is-invalid');
                    $(this).addClass('is-valid');
                    $(this).siblings('.invalid-feedback').remove();
                }
            });

            /*$('#note').blur(function(e) {
                if ($(this).val().length > 0) {
                    $(this).removeClass('is-invalid');
                    $(this).addClass('is-valid');
                    $(this).siblings('.invalid-feedback').remove();
                } else {
                    $(this).addClass('is-invalid');
                }
            });*/
        });
    </script>
</body>
</html>