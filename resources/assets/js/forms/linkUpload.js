/* globals $, alert */
import displayFormErrors from '../utilities/displayFormErrors';
import Config from '../config';
import imageBlob from '../utilities/imageBlob';
import resetModal from '../utilities/closeAndResetModal';
let $form = $('form#link_form');

$form
    .on('reset', () => {
        $form.find('.error').empty();
    })
    .submit(event => {
        event.preventDefault();

        $.ajax({
                url: $form.attr('action'),
                method: 'POST',
                data: new FormData($form.get(0)),
                dataType: 'json',
                processData: false,
                contentType: false
            })
            .then(response => {
                $('#links_table tbody').append(
                    `<tr class="Link_row" id="Link_row_${response.id}">
                        <td>${response.name}</td>
                        <td>${response.category}</td>
                        <td>${response.url}</td>
                        <td>${response.status}</td>
                        <td>${response.date}</td>
                    </tr>`
                );
                resetModal('#addLink');
                window.toastr.success('Link added successfully.');
            })
            .catch(({ responseJSON, status }) => {
                if (status == 422 && responseJSON) {
                    displayFormErrors($form, responseJSON);
                    return true;
                }
                alert('Error! Please contact support or try again later.');
            });
    });