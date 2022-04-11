@include('project.global.notification._success')
<script>
    $(document).ready(function () {

        /**
         * on page load fetch services
         */
        fetchServices();

        /**
         * fetch existing services
         */
        function fetchServices() {
            $.ajax({
                type: "GET",
                url: "{{ route('service.fetch') }}",
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
                                     <td>${item.name} </td>
                                    <td><img src=${item.image_path} style="width: 100px;"></td>\
                                     <td><button type="button" value="${item.id}" class="btn btn-outline-warning btn-circle editService"><i class="fa fa-edit"></i></button>
<button type="button" value="${item.id}" class="btn btn-outline-danger btn-circle deleteService"><i class="fa fa-trash"></i></button></td>\
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
        $(document).on('click', '.addService', function (e) {
            e.preventDefault();
            $(this).text('adding...');

            let formData = new FormData($('#newForm')[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('service.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    // display success message
                    successNotification(response)
                    $('#newForm').find('input').val("");

                    $('.addService').text('Add');
                    $('#addService').modal('hide');
                    // fetch profile information
                    fetchServices();

                },
                error: function (response) {
                    if (response.hasOwnProperty('responseJSON') && response.responseJSON.errors) {
                        const errors = response.responseJSON.errors;
                        $('#errorName').html("");

                        $('#errorName').append(errors.name);
                        $('.addService').text('Add');
                    }

                    let message = response.responseJSON ? response.responseJSON.message : null;
                    errorNotification(message);

                }
            });

        });

        /**
         * show edit modal
         */
        $(document).on('click', '.editService', function (e) {
            e.preventDefault();
            let serviceId = $(this).val();
            $('#editService').modal('show');

            $.ajax({
                type: "GET",
                url: "{{ route('service.edit','+') }}".replace('+', serviceId),
                success: function (response) {
                    $('#serviceId').val(response.service.id);
                    $('#editName').val(response.service.name);
                    $('#editImage2').val(response.service.image_path);
                    document.getElementById("editImage").src = response.service.image_path;

                }
            });

        });


        /**
         * send  data into controller to update service records
         */
        $(document).on('click', '.updateService', function (e) {
            e.preventDefault();
            $(this).text('updating...');

            let serviceId = $('#serviceId').val();

            let formData = new FormData($('#editForm')[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('service.update','+') }}".replace('+', serviceId),
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function (response) {
                    successNotification(response)
                    $('.updateService').text('Save Changes');
                    $('#editService').modal('hide');
                    fetchServices();
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
                        $('.updateService').text('Save Changes');
                    }
                }

            });
        });


        /**
         * show delete modal
         */
        $(document).on('click', '.deleteService', function (e) {
            e.preventDefault();
            let serviceId = $(this).val();
            $('#deleteService').modal('show');
            $('#deleteId').val(serviceId);
        });

        // delete service
        $(document).on('click', '.confirmDelete', function (e) {
            e.preventDefault();
            $(this).text('deleting...');

            let deleteId = $('#deleteId').val();

            $.ajax({
                type: "POST",
                url: "{{ route('service.delete', '+') }}".replace('+', deleteId),
                success: function (response) {
                    if (response.status == 400) {
                        let message = response.errors;
                        errorNotification(message)
                        $('.confirmDelete').text('Yes');
                        $('#deleteService').modal('hide');
                    } else {
                        successNotification(response)
                        $('.confirmDelete').text('Yes');
                        $('#deleteService').modal('hide');
                        fetchServices();
                    }
                }
            });
        })

    });
</script>
@include('project.global.notification._error')
