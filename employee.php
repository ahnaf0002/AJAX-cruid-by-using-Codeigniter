<div class="row">
    <div class="col-lg-12">
        <h3>Employee </h3>
        <div class="alert alert-success" style="display: none;">
</div>

        <table class="table">
            <thead>
                <th><button id="btnAdd" class="btn btn-success">Add New</button></th>
                <tr>


                    <td>ID</td>
                    <td>Employee Name</td>
                    <td>Address</td>
                    <td>Created at</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody id="showdata">

            </tbody>
        </table>
    </div>
</div>



<div id="myModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form id="myForm" action="" method="post" class="form-horizontal">
                <input type="hidden" name="txtId" value="0">
                    <div class="form-group">
                        <label for="name" class="label-control col-md-4">Employee Name</label>
                        <div class="col-md-12">
                            <input type="text" name="txtEmployeeName" class="form-control" id="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="label-control col-md-4">Address</label>
                        <div class="col-md-12">
                            <textarea name="txtAddress" id="" class="form-control"></textarea>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button id="btnSave" type="button" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div id="deleteModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                 Do u want to delete this record?
            </div>
            <div class="modal-footer">
                <button id="btnDelete" type="button" class="btn btn-danger">Delete</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<script>
    $(function() {
        showAllEmployee();

        //add new
        $('#btnAdd').click(function() {
            $('#myModal').modal('show');
            $('#myModal').find('.modal-title').text('Add New Employee');
            $('#myForm').attr('action', '<?php echo base_url() ?>admin/employee/addEmployee');
        });
        $('#btnSave').click(function() {

            var url = $('#myForm').attr('action');
            var data = $('#myForm').serialize();

            var employeeName = $('input[name=txtEmployeeName]');
            var address = $('textarea[name=txtAddress]');
            var result = '';

            if (employeeName.val() == '') {
                employeeName.parent().parent().addClass('has-error');

            } else {
                employeeName.parent().parent().removeClass('has-error');
                result += '1';
            }

            if (address.val() == '') {
                address.parent().parent().addClass('has-error');

            } else {
                address.parent().parent().removeClass('has-error');
                result += '2';
            }
            if (result == '12') {
                $.ajax({

                    type: 'ajax',
                    method: 'post',
                    url: url,
                    data: data,
                    async: false,
                    dataType: 'json',
                    success: function(response) {

                        if (response.success) {
                            $('#myModal').modal('hide');
                            $('#myForm')[0].reset();
                            if (response.type =='add') {
                                var type = 'added'
                                
                            }   else if(response.type =='update'){
                                var type = 'updated'

                            }
                            $('.alert-success').html('Employee '+type+' Sucessfully').fadeIn().delay(4000).fadeOut('slow');
                            showAllEmployee();
                        }else{
                            alert('error ... data');
                        }

                    },
                    error: function() {
                        alert('error...data');
                    }

                });
            }




        });

        //item edit

        $('#showdata').on('click','.item-edit', function(){
            var id = $(this).attr('data');
            $('#myModal').modal('show');
            $('#myModal').find('.modal-title').text('Edit Employee');
            $('#myForm').attr('action', '<?php echo base_url() ?>admin/employee/updateEmployee');

            $.ajax({

                type: 'ajax',
                method:'get',
                url:'<?php echo base_url() ?>admin/employee/editEmployee',
                data:{id: id},
                async:false,
                dataType:'json',
                success:function(data){

                  $('input[name=txtEmployeeName]').val(data.employee_name);
                  $('textarea[name=txtAddress]').val(data.address);
                  $('input[name=txtId]').val(data.id);
                  

                },
                error: function () {
                        alert('could not edit data');
                }

            });
             

        });

        //item delete

        $('#showdata').on('click', '.item-delete', function(){

            var id = $(this).attr('data');
            $('#deleteModal').modal('show');
            $('#btnDelete').unbind().click(function(){

                $.ajax({
                type: 'ajax',
                method:'get',
                async:false, 
                url:'<?php echo base_url() ?>admin/employee/deleteEmployee',
                data:{id:id},
                
                dataType:'json',
                success:function(response){

                   if (response.success) {
                    $('#deleteModal').modal('hide');
                    $('.alert-success').html('Data Deleted').fadeIn().delay(4000).fadeOut('slow');;
                    showAllEmployee();
                       
                   }else{
                       alert('error ajob');
                   }
                      
                  
                },
                error: function () {
                        alert('could not delete data');
                }
            });

            });
           

        });



        //function

        function showAllEmployee() {
            $.ajax({


                type: 'ajax',
                url: '<?php echo base_url() ?>admin/employee/showAllEmployee',
                async: false,
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        html += '<tr>' +
                            '<td>' + data[i].id + '</td>' +
                            '<td>' + data[i].employee_name + '</td>' +
                            '<td>' + data[i].address + '</td>' +
                            '<td>' + data[i].created_at + '</td>' +
                            '<td>' +
                            '<a href="javascript:;" class="btn btn-info item-edit" data="'+data[i].id+'">Edit</a>' +
                            '<a href="javascript:;" class="btn btn-danger item-delete" data="'+data[i].id+'">Delete</a>'+
                        '</td>' +
                        '</tr>';

                    }
                    $('#showdata').html(html);

                },
                error: function() {
                    alert('error..')
                }


            });
        }

    });
</script>