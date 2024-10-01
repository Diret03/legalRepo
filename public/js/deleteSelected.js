function initializeDeleteFunction(route, elementPrefix) {
    $(function (e) {

        $("#select_all_ids").click(function () {
            $('.checkbox_ids').prop('checked', $(this).prop('checked'));
        });

        $('#deleteAll').click(function (e) {
            e.preventDefault();

            if (!confirm("¿Estás seguro de que deseas eliminar los registros seleccionados?")) {
                return;
            }

            const all_ids = [];

            $('input:checkbox[name=ids]:checked').each(function () {
                all_ids.push($(this).val());
            });

            if (all_ids.length === 0) {
                // Mostrar el mensaje de error
                $('#message-error').removeClass('hidden').addClass('block');
                $('#message-text-error').text('No se ha seleccionado ningún registro.');
                return;
            }

            console.log("IDs to delete: ");
            console.log(all_ids);

            $.ajax({
                url: route,  // Use the passed route
                type: "DELETE",
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
                        $('#message-text').text(response.success);

                        setTimeout(function () {
                            location.reload();
                        }, 750);
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
