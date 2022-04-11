<script>
    function successNotification(response) {
        $(function () {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                type: 'success',
                title: response.message
            })
        });
    }
</script>
