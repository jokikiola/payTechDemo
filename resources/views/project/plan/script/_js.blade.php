@include('project.global.notification._success')
<script>
    $(document).ready(function () {

        /**
         * on page load fetch services
         */
        fetchPlans();

        /**
         * fetch existing services
         */
        function fetchPlans() {
            $.ajax({
                type: "GET",
                url: "{{ route('plan.fetch') }}",
                dataType: "json",
                success: function (response) {

                    let no = 1;
                    $('tbody').html("");

                    // loop json response into table body
                    $.each(response.data, function (key, item) {
                        $('tbody').append(
                            `
                               <tr>
                                 <td>${no++}</td>
                                     <td>${item.product.service.name} </td>
                                     <td>${item.product.name} </td>
                                       <td>${item.name} </td>
<td>${item.amount}</td>
                                    <td><img src=${item.image_path} style="width: 100px;"></td>\
                                     <td><button type="button" value="${item.id}" class="btn btn-outline-warning btn-circle editPlan"><i class="fa fa-edit"></i></button>
<button type="button" value="${item.id}" class="btn btn-outline-danger btn-circle deletePlan"><i class="fa fa-trash"></i></button></td>\
                             </tr>
                                `
                        )
                        ;
                    });
                }

            });
        }

        /**
         * add new services
         */
        $(document).on('click', '.addPlan', function (e) {
            e.preventDefault();
            $('#addPlan').modal('show');

            $('#services').html("<option value=''>Select Service</option>");
            $('#product').html("<option value=''>Select Product</option>");
            $.ajax({
                type: "GET",
                url: "{{ route('service.fetch') }}",
                success: function (response) {
                    response.data.forEach(item => {
                        $('#services').append(`<option value="${item.id}">${item.name}</option>`)
                    })
                }
            })
        });
        $('#services').change(function (e) {
            e.preventDefault();
            let serviceId = $('#services').val();
            $('#product').html("<option value=''>Select Product</option>");
            $.ajax({
                type: "GET",
                url: "{{ route('plan.fetch.product','+') }}".replace('+', serviceId),
                success: function (response) {
                    response.data.forEach(item => {
                        $('#product').append(`<option value="${item.id}">${item.name}</option>`)
                    })
                }
            })
        })


        $(document).on('click', '.add', function (e) {
            e.preventDefault();
            $(this).text('adding...');
            let formData = new FormData($('#newForm')[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('plan.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    // display success message
                    successNotification(response)
                    $('#newForm').find('input').val("");

                    $('.add').text('Add');
                    $('#addPlan').modal('hide');
                    // fetch profile information
                    fetchPlans()
                    ;
                    $('#errorName').html("");
                    $('#errorService').html("");
                    $('#errorProduct').html("");
                    $('#errorName').html("");
                    $('#errorAmount').html("");
                },
                error: function (response) {
                    if (response.hasOwnProperty('responseJSON') && response.responseJSON.errors) {
                        const errors = response.responseJSON.errors;
                        $('#errorName').html("");
                        $('#errorService').html("");
                        $('#errorProduct').html("");
                        $('#errorName').html("");
                        $('#errorAmount').html("");


                        $('#errorName').append(errors.name);
                        $('#errorService').append(errors.service)
                        $('#errorProduct').append(errors.product)
                        $('#errorName').append(errors.name)
                        $('#errorAmount').append(errors.amount)

                        $('.add').text('Add');
                    }
                    let message = response.responseJSON ? response.responseJSON.message : null;
                    errorNotification(message);
                }
            });

        });

        /**
         * show edit modal
         */
        $(document).on('click', '.editPlan', function (e) {
            e.preventDefault();
            let planId = $(this).val();
            $('#editPlan').modal('show');


            $.ajax({
                type: "GET",
                url: "{{ route('plan.edit','+') }}".replace('+', planId),
                success: function (response) {
                    $('#editService').val(response.plan.product.service.name);
                    $('#editProduct').val(response.plan.product.name);
                    $('#editName').val(response.plan.name);
                    $('#editAmount').val(response.plan.amount);
                    $('#editDescription').val(response.plan.description);
                    $('#planId').val(response.plan.id);
                    $('#editImage2').val(response.plan.image_path);
                    document.getElementById("showImage").src = response.plan.product.image_path;
                },
            });

        });


        /**
         * send  data into controller to update service records
         */
        $(document).on('click', '.update', function (e) {
            e.preventDefault();
            $(this).text('updating...');

            let planId = $('#planId').val();

            let formData = new FormData($('#editForm')[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('plan.update','+') }}".replace('+', planId),
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function (response) {
                    successNotification(response)
                    $('.update').text('Save Changes');
                    $('#editPlan').modal('hide');
                    fetchPlans();
                },
                error: function (response) {
                    if (response.hasOwnProperty('responseJSON') && response.responseJSON.errors) {

                        // get api exception error
                        let message = response.responseJSON ? response.responseJSON.message : null;
                        errorNotification(message)

                        // get the array of error
                        const errors = response.responseJSON.errors;

                        $('#errorEditName').html("");
                        // display error
                        $('#errorEditName').append(errors.editName);
                        $('.update').text('Save Changes');
                    }
                }
            });
        });


        /**
         * show delete modal
         */
        $(document).on('click', '.deletePlan', function (e) {
            e.preventDefault();
            let plain = $(this).val();
            $('#deletePlan').modal('show');
            $('#deleteId').val(plain);
        });

        // delete service
        $(document).on('click', '.confirmDelete', function (e) {
            e.preventDefault();
            $(this).text('deleting...');

            let deleteId = $('#deleteId').val();

            $.ajax({
                type: "POST",
                url: "{{ route('plan.delete', '+') }}".replace('+', deleteId),
                success: function (response) {
                    if (response.status == 400) {
                        let message = response.errors;
                        errorNotification(message)
                    } else {
                        successNotification(response)
                        $('.confirmDelete').text('Yes');
                        $('#deletePlan').modal('hide');
                        fetchPlans();
                    }
                }
            });
        });

        getUser();

        function getUser() {


            const url = "https://www.vtukonnect.com/api/user/";

            const xhr = new XMLHttpRequest();
            xhr.open("GET", url);
            xhr.setRequestHeader("Accept", "application/json");
            xhr.setRequestHeader("Authorization", "Token de6b5779995c4967002410a9ad9b4f0169823e86");

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    console.log(xhr.status);
                    console.log(xhr.responseText);
                }
            };
            xhr.send();
        }

    });
</script>
@include('project.global.notification._error')
