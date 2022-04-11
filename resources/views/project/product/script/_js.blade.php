@include('project.global.notification._success')
<script>
    $(document).ready(function () {

        /**
         * on page load fetch services
         */
        fetchProducts();

        /**
         * fetch existing services
         */
        function fetchProducts() {
            $.ajax({
                type: "GET",
                url: "{{ route('product.fetch') }}",
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
                                     <td>${item.service.name} </td>
                                       <td>${item.name} </td>
                                    <td><img src=${item.image_path} style="width: 100px;"></td>\
                                     <td><button type="button" value="${item.id}" class="btn btn-outline-warning btn-circle editProduct"><i class="fa fa-edit"></i></button>
<button type="button" value="${item.id}" class="btn btn-outline-danger btn-circle deleteProduct"><i class="fa fa-trash"></i></button></td>\
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
        $(document).on('click', '.addProduct', function (e) {
            e.preventDefault();
            $('#addProduct').modal('show');

            $('#services').html("<option value=''>Select Service</option>");

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


        $(document).on('click', '.add', function (e) {
            e.preventDefault();
            $(this).text('adding...');
            let formData = new FormData($('#newForm')[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('product.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    // display success message
                    successNotification(response)
                    $('#newForm').find('input').val("");

                    $('.add').text('Add');
                    $('#addProduct').modal('hide');
                    // fetch profile information
                    fetchProducts();
                    $('#errorName').html("");
                    $('#errorService').html("");
                },
                error: function (response) {
                    if (response.hasOwnProperty('responseJSON') && response.responseJSON.errors) {
                        const errors = response.responseJSON.errors;
                        $('#errorName').html("");
                        $('#errorService').html("");

                        $('#errorName').append(errors.name);
                        $('#errorService').append(errors.serviceId)
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
        $(document).on('click', '.editProduct', function (e) {
            e.preventDefault();
            let productId = $(this).val();
            $('#editProduct').modal('show');

            $.ajax({
                type: "GET",
                url: "{{ route('product.edit','+') }}".replace('+', productId),
                success: function (response) {
                    $('#productId').val(response.product.id);
                    $('#editName').val(response.product.name);
                    $('#editImage2').val(response.product.image_path);
                    $('#editServiceId').val(response.product.service_id);
                    document.getElementById("editImage").src = response.product.image_path;

                    response.services.forEach(item => {
                        $('#editServiceId').append(`<option value="${item.id}">${item.name}</option>`)
                    })
                },
            });

        });


        /**
         * send  data into controller to update service records
         */
        $(document).on('click', '.update', function (e) {
            e.preventDefault();
            $(this).text('updating...');

            let productId = $('#productId').val();

            let formData = new FormData($('#editForm')[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('product.update','+') }}".replace('+', productId),
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function (response) {
                    successNotification(response)
                    $('.update').text('Save Changes');
                    $('#editProduct').modal('hide');
                    fetchProducts();
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
        $(document).on('click', '.deleteProduct', function (e) {
            e.preventDefault();
            let productId = $(this).val();
            $('#deleteProduct').modal('show');
            $('#deleteId').val(productId);
        });

        // delete service
        $(document).on('click', '.confirmDelete', function (e) {
            e.preventDefault();
            $(this).text('deleting...');

            let deleteId = $('#deleteId').val();

            $.ajax({
                type: "POST",
                url: "{{ route('product.delete', '+') }}".replace('+', deleteId),
                success: function (response) {
                    if (response.status == 400) {
                        let message = response.errors;
                        errorNotification(message)
                    } else {
                        successNotification(response)
                        $('.confirmDelete').text('Yes');
                        $('#deleteProduct').modal('hide');
                        fetchProducts();
                    }
                }
            });
        });

    });
</script>
@include('project.global.notification._error')
