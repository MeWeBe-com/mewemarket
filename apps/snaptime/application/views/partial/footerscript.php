<script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery-ui.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/perfect-scrollbar.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.validate.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/es6-promise-auto.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/moment.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap-datetimepicker.js') ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap-selectpicker.js') ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap-switch-tags.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.easypiechart.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/chartist.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap-notify.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery-jvectormap.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.bootstrap.wizard.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap-table.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.datatables.js') ?>"></script>
<script src="<?php echo base_url('assets/js/fullcalendar.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/paper-dashboard.js') ?>"></script>
<script src="<?php echo base_url('assets/js/demo.js') ?>"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!--<script src="https://cdn.jsdelivr.net/sweetalert2/6.1.1/sweetalert2.min.js"></script>-->

<script src="<?php echo base_url('assets/js/ckeditor.js') ?>"></script>
<script src="<?php echo base_url('assets/js/venobox.min.js') ?>"></script>
<!-- Latest compiled and minified CSS -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>

    $('input[name="date_range"]').daterangepicker({
        locale: {
            format: 'D/MM/Y'
        }
    });

    $(document).ready(function(){
        $('.venobox').venobox();
    });


     <?php if(isset($_GET['AlertMessage'])){ ?>

            $(document).ready(function () {
                swal({
                title: "<?php echo $_GET['AlertMessage']?>",

                icon: "warning",
                buttons: true,
                dangerMode: true,
            });
        
     });

        <?php }?>

<?php if($this->session->userdata('role') === 'Supplier') { ?>
    displayTime();
    function displayTime() {
        $(function () {
            $.ajax({
                type: 'GET',
                cache: false,
                url: "<?php echo base_url('/dashboard/server_time')?>",
               success: function (response) {
                    $('#running_timer').html(response);
                }
            });

        });
        setTimeout("displayTime()", 1000);
    }
    <?php } ?>
     function start() {
        swal({
            title: "Are you ready?",
            text: "Click [OK] to start your time log, and screenshots.",
            icon: "warning",
            buttons: {
                confirm: {
                    value: "OK",
                },
            },
            dangerMode: true,
        })
            .then((ok) => {
                if (ok) {

                    var time = $('#running_timer').text();
                    var project_id = '<?php echo $this->uri->segment(3); ?>';
                    var table = '<?php echo $this->uri->segment(1); ?>';
                    setTimeout(() => {
                        $.ajax({
                            url: '<?php echo base_url('projects/clockin');?>',
                            type: "POST",
                            dataType: 'json',
                           data: {time: time, project_id: project_id, table: table},
                            success: function (response) {
                                swal({
                                        icon: "success",
                                        title: "Time In!",
                                        text: response.message,
                                        content: {
                                            element: "textarea",
                                            attributes: {
                                                placeholder: "Type your Text",
                                                name: "notes",
                                                class: "notes",
                                                id:response.id,
                                            },
                                        },
                                    closeOnClickOutside: false,
                                    buttons: {
                                        confirm: {
                                            value: "Save",
                                        },
                                    },

                                    }).then((willDelete) => {
                                    if (willDelete) {

                                        var notes = $('.swal-content__textarea').val();
                                        var id = $('.swal-content__textarea').attr('id');

                                        $.ajax({
                                             url: '<?php echo base_url('projects/UpdateNotes');?>',
                                             type: "POST",
                                              dataType: 'json',
                                             data: {id: id, notes: notes},
                                            success: function (response) {
                                                location.reload();

                                            }
                                        });
                                    }


                                });

                                var controller= "<?php echo $this->uri->segment(1);?>";
                                var id= "<?php echo $this->uri->segment(3);?>";
                                var base_url = "<?php echo base_url();?>";


                                var strWindowFeatures = "location=yes,height=570,width=520,scrollbars=yes,status=yes";
                                var URL =  base_url+'projects/Simulator/'+id+'?module='+controller;
                                console.log(URL);
                                var win = window.open(URL, "_blank", strWindowFeatures);
                            }
                        });

                    }, 1000);


                }
            });
    }

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
        $(".download_now").tooltip({ effect: 'slide'});
    });

    function stop() {

            var note = `<?php echo $this->session->userdata('notes');?>`;
            var notes = note.replace(/(\r\n|\n|\r)/gm, "");

            swal({
                title: "Are you sure you want to stop?",
                text: "Once stop, your recording will be stop.",
                icon: "warning",
                content: {
                    element: "textarea",
                    attributes: {
                        placeholder: "Type your Text",
                        name: "notes",
                        class: "notes",
                        id:"<?php echo $this->session->userdata('time_id');?>",
                        value: notes
                    },
                },
                closeOnClickOutside: false,
                buttons: {
                    confirm: {
                        value: "Save",
                    },
                },
                dangerMode: true,
            })
                .then((ok) => {
                    if (ok) {
                        var notes = $('.swal-content__textarea').val();
                        var id = $('.swal-content__textarea').attr('id');
                        $.ajax({
                            url: '<?php echo base_url('projects/UpdateNotes');?>',
                            type: "POST",
                            dataType: 'json',
                            data: {id: id, notes: notes},
                            success: function (response) {

                                var time = $('#running_timer').text();
                                var project_id = '<?php if ($this->session->userdata('project_id') !== FALSE) {
                                    echo $this->session->userdata('project_id');
                                } else {
                                    echo $this->uri->segment(3);
                                }  ?>';
                                var table = '<?php if ($this->session->userdata('table') !== FALSE) {
                                    echo $this->session->userdata('table');
                                } else {
                                    echo $this->uri->segment(1);
                                } ?>';


                                setTimeout(() => {
                                    $.ajax({
                                        url: '<?php echo base_url('projects/clockout');?>',
                                        type: "POST",
                                        dataType: 'json',
                                        data: {time: time, project_id: project_id, table: table},
                                        success: function (response) {
                                            swal(
                                                'Time Out!',
                                                response.message,
                                                response.status == 'false' ? 'warning' : 'success'
                                            ).then((willDelete) => {
                                                if (willDelete) {
                                                    location.reload();
                                                }
                                            });
                                        }
                                    });
                                }, 1000);

                            }
                        });


                    }
                });
        }
    $(document).ready(function () {

        $('#datatables').DataTable({
            "pagingType": "numbers",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "order": [[0, "desc"]],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search",
            }

        });
    });

        $(document).ready(function () {

            var table = $('#datatables').DataTable();
                $('#supplier_type').on('change',function () {
                    if($(this).val()==='')
                    {
                        table.columns(3).search('').draw();
                    }else
                    {
                        table.columns(3).search($('#supplier_type :selected').text()).draw();
                    }
                });
                $('#department').on('change',function () {
                    if($(this).val()==='')
                    {
                        table.columns(4).search('').draw();
                    }else
                    {
                        table.columns(4).search($('#department :selected').text()).draw();
                    }
                });
            // Delete a record
            table.on('click', '.remove', function (e) {
                $tr = $(this).closest('tr');
                table.row($tr).remove().draw();
                e.preventDefault();
            });

        });

            $(function () {
                var dtToday = new Date();

                var month = dtToday.getMonth() + 1;
                var day = dtToday.getDate();
                var year = dtToday.getFullYear();
                if (month < 10)
                    month = '0' + month.toString();
                if (day < 10)
                    day = '0' + day.toString();

                var minDate = year + '-' + month + '-' + day;

                $('#due_date_picker').attr('min', minDate);
            });


            $(document).ready(function () {
                $('#confirmpassword').on('blur', function () {
                    var confirm = $(this).val();
                    var password = $('#password').val();

                    if (password == confirm) {
                        $('#Confirmerror').text('');
                        $('#save').removeAttr('disabled');
                    } else {
                        $('#Confirmerror').text('Confirm Password is not match.');
                        $('#save').attr('disabled', 'disabled');
                    }

                });
            });

             ClassicEditor
        .create(document.querySelector('.editor'), {

            toolbar: {
                items: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    'link',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'indent',
                    'outdent',
                    '|',
                    'blockQuote',
                    'undo',
                    'redo'
                ]
            },
            language: 'en',
            licenseKey: '',

        })
        .then(editor => {
            window.editor = editor;
        })
        .catch(error => {
        });

       

</script>
