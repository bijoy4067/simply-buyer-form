<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simple Php Form</title>
    <?php require APPROOT . '/views/layouts/styles.php'; ?>
</head>
<body>
    <div class="container py-2 py-sm-5 mx-auto">
        <div class="row mb-2 mb-sm-4">
            <div class="col-12">
                <form method="post" action="">
                    <div class="row mx-auto search-bar">
                        <div class="col-12 col-sm-3 mt-3">
                            <div class="form-group">
                                <input class="form-control" type="text" id="daterangepicker" name="daterangepicker">
                            </div>
                        </div>
                        <div class="col-12 col-sm-3 mt-3">
                            <div class="form-group">
                                <select class="form-control" name="user">
                                    <option value="">Select User</option>
                                    <?php foreach ($data['users'] as $value): ?>
                                        <option value="<?= $value->entry_by?>"><?= $value->entry_by?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <button class="btn btn-primary btn-sm submit_button mt-3 mb-3 mb-sm-0"><i class="fa fa-magnify"></i>  search</button>

                            <a class="btn btn-info btn-sm mt-3 py-2 submit_button float-right" href="<?= BASEURL?>?page=form/create">
                                <i class="fa fa-plus"></i>
                                Add
                            </a>
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>
        <div class="col-12 table-content">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Amount</th>
                        <th>Created At</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <?php foreach ($data['data'] as $key => $value): ?>
                            <tr>
                                <td><?= $value->id ?></td>
                                <td><?= $value->buyer ?></td>
                                <td><?= $value->buyer_email ?></td>
                                <td><?= $value->phone ?></td>
                                <td><?= $value->amount ?></td>
                                <td><?= $value->entry_at ?></td>
                                <td>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#show_buyer<?= $value->id ?>">
                                        <i class="fa fa-eye"></i>
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="show_buyer<?= $value->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <ul class="list-group pb-2">
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            Buyer : <span><?= $value->buyer ?></span>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            Email : <span><?= $value->buyer_email ?></span>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            Phone : <span><?= $value->phone ?></span>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            City : <span><?= $value->city ?></span>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            receipt_id : <span><?= $value->receipt_id ?></span>
                                                        </li>
                                                    </ul>
                                                    <?php
                                                    $items = json_decode($value->items);
                                                    $counter = 1;
                                                    ?>
                                                    <span class="h5">Lists: </span>
                                                    <?php foreach ($items as $key => $item): ?>
                                                        <p class="mb-0"><?=$counter++.'.  '.$item ?></p>
                                                    <?php endforeach ?>
                                                    <div>
                                                        <div class="card mt-3">
                                                            <div class="bg-info card-title px-3 text-light">Description</div>
                                                            <div class="card-body">
                                                                <?= $value->note ?>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <a class="delete_btn btn btn-danger" href="<?= BASEURL?>?url=form/delete/<?= $value->id?>">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php require APPROOT . '/views/layouts/scripts.php'; ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.delete_btn').click(function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to delete this Item?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'get',
                            success: function(data) {
                                var response = JSON.parse(data);

                                if (response.type == 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Successfull',
                                        text: 'Data deleted',
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = '<?= BASEURL?>?url=form';
                                        }
                                    });
                                }                            
                            }
                        })
                    }
                })
            });

            $('#daterangepicker').daterangepicker({
                autoClose: false,
                locale: {
                    format: 'YYYY-MM-DD'
                },
                separator: ' to ',
                language: 'en',
                autoClose: false,
                autoApply: false,
            });

            /*$('#daterangepicker').on('apply.daterangepicker', function(ev, picker) {
                if (picker.startDate === null && picker.endDate === null) {
                    $(this).val('');
                }
            });*/

            $('.table').DataTable();
        })
    </script>
</body>
</html>