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

            let all_ids = [];

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

                    if (response.success) {
                        $('#message').removeClass('hidden').addClass('block');
                        // $('#message-text').text(response.success);

                        $('#message ul').empty();
                        $('#message-text').text(response.success.message);

                        $.each(response.success.names, function(index, name) {
                            $('#message ul').append('<li>' + name + '</li>');
                        });

                        // Filter all_ids by removing the invalidIds if there's any error
                        if (response.error) {
                            let invalidIds = response.error.ids;
                            console.log("invalid IDS");
                            console.log(invalidIds);

                            // Filter out invalidIds from all_ids
                            all_ids = all_ids.filter(function(id) {
                                return !invalidIds.includes(String(id));
                            });

                            // for (let i = 0; i < all_ids.length; i++) {
                            //     for (let j = 0; j < invalidIds.length; j++) {
                            //         if (all_ids[i] == invalidIds[j]) {  // Use '==' to compare string with number
                            //             let index = all_ids.indexOf(all_ids[i]);  // Find the index of the matching ID in all_ids
                            //             all_ids.splice(index, 1);  // Remove the matched ID from all_ids
                            //         }
                            //     }
                            // }
                            console.log("FILTERED ids");
                            console.log(all_ids);
                        }

                        $.each(all_ids, function (key, val) {
                            $('#' + elementPrefix + val).remove(); // Use the passed element prefix
                        });

                        // setTimeout(function () {
                        //     location.reload();
                        // }, 750);
                    }

                     if (response.error) {
                        $('#message-error').removeClass('hidden').addClass('block');

                         $('#message-error ul').empty();
                         $('#message-text-error').text(response.error.message);

                         // Loop through the error names and append each to the unordered list
                         $.each(response.error.names, function(index, name) {
                             $('#message-error ul').append('<li>' + name + '</li>');
                         });
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
