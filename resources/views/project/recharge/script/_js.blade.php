@include('project.global.notification._success')
<script>
    $(document).ready(function () {

        /**
         * on page load fetch services
         */
        fetchTransactions();

        /**
         * fetch existing services
         */
        function fetchTransactions() {
            $.ajax({
                type: "GET",
                url: "{{ route('recharge.fetch.transactions') }}",
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
                                     <td>00000${item.id}</td>
                                     <td>${item.plan.product.service.name} ${item.plan.product.name} ${item.plan.name} </td>
                                       <td> </td>
                                    <td>${item.amount}</td>
                                    <td>${item.transaction_date}</td>
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
        $(document).on('click', '.recharge', function (e) {
            e.preventDefault();
            $('#recharge').modal('show');
            $('#info').hide();
            $('#planInfo').hide();

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


        $('#services').change(function (e) {
            e.preventDefault();
            $('#info').show();
            $('#planInfo').hide();
            let serviceId = $('#services').val();
            $('#product').html("<option value=''>Select Product</option>");
            $('#productId').html("<option value=''>Select Plan 2</option>");

            $('#plan').html("<option value=''>Select Plan </option>");

            $.ajax({
                type: "GET",
                url: "{{ route('plan.fetch.product','+') }}".replace('+', serviceId),
                success: function (response) {
                    response.data.forEach(item => {
                        $('#product').append(`<option value="${item.id}">${item.name}</option>`)
                    })
                    response.plans.forEach(item => {
                        $('#productId').append(`<option value="${item.id}">${item.id}</option>`)
                    })
                }
            })
        })

        $('#product').change(function (e) {
            e.preventDefault();
            let productId = $(this).val();
            $('#plan').html("<option value=''>Select Plan </option>");
            $.ajax({
                type: "GET",
                url: "{{ route('recharge.fetch.plan','+') }}".replace('+', productId),
                success: function (response) {
                    response.data.forEach(item => {
                        $('#plan').append(`<option value="${item.id}">${item.name}</option>`)
                    })
                }
            })
        })

        $('#plan').change(function (e) {
            e.preventDefault();
            $('#planInfo').show();
            let planId = $(this).val();

            $.ajax({
                type: "GET",
                url: "{{ route('recharge.fetch.price','+') }}".replace('+', planId),
                success: function (response) {
                    $('#amount').val(response.data.amount);
                }
            })
        })

        $(document).on('click', '.confirmRecharge', function (e) {
            e.preventDefault();
            $(this).text('recharging...');

            let formData = new FormData($('#newForm')[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('recharge.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function (response) {
                    successNotification(response)
                    $('.confirmRecharge').text('Recharge');
                    $('#recharge').modal('hide');
                    fetchTransactions();
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

            })
        })
    });
</script>
@include('project.global.notification._error')
