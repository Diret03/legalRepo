function initializeDeactivateFunction(route, elementPrefix) {
    $(function (e) {

        $("#select_all_ids").click(function () {
            $('.checkbox_ids').prop('checked', $(this).prop('checked'));
        });

        $('#deactivateAll').click(function (e) {
            e.preventDefault();

            if (!confirm("¿Estás seguro de que deseas desactivar los registros seleccionados?")) {
                return;
            }

            const all_ids = [];

            $('input:checkbox[name=ids]:checked').each(function () {
                all_ids.push($(this).val());
            });

            if (all_ids.length === 0) {
                $('#message-error').removeClass('hidden').addClass('block');
                $('#message-text-error').text('No se ha seleccionado ningún registro.');
                return;
            }

            console.log("IDs to delete: ");
            console.log(all_ids);

            $.ajax({
                url: route,  // Use the passed route
                type: "PATCH",
                data: {
                    ids: all_ids,
                    _token: $('meta[name="csrf-token"]').attr('content') // Ensure CSRF token is dynamically set
                },
                success: function (response) {
                    $.each(all_ids, function (key, val) {
                        $('#' + elementPrefix + val).remove(); // Use the passed element prefix
                    });

                    if (response.success) {
                        $('#message').removeClass('hidden').addClass('block');
                        $('#message-text').text(response.success.message);

                        $.each(response.success.names, function(index, name) {
                            $('#message ul').append('<li>' + name + '</li>');
                        });

                        // $.each(all_ids, function (key, val) {
                        //     $('#' + elementPrefix + val).html(response.success.data); // Use the passed element prefix
                        // });
                        $('#users-data').html(response.success.data);

                        // setTimeout(function () {
                        //     location.reload();
                        // }, 750);
                    }

                },
                error: function (xhr, status, error) {
                    console.error('Error al buscar:', error);
                    console.error('Detalles del error:', xhr, status);
                }
            });
        });
    });
}
