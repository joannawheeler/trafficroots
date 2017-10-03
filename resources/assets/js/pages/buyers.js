/* globals $, alert  */
import displayFormErrors from '../utilities/displayFormErrors';
import Config from '../config';
import imageBlob from '../utilities/imageBlob';
$(document).ready(() => {
    let $button = $('.btn[for="image_file"]'),
        resetButton = () => {
            $button
                .removeClass('btn-outline')
                .find('span')
                .text('Upload');
        },
        { location } = window;
    if (location.hash) {
        $(`.nav-tabs a[href="${location.hash}"]`).tab('show');
    }
    $('form#media_form').submit(event => {
        event.preventDefault();
        let $form = $(event.currentTarget);

        $.ajax({
                url: $form.attr('action'),
                method: 'POST',
                data: new FormData($form.get(0)),
                dataType: 'json',
                processData: false,
                contentType: false
            })
            .then(() => {
                let redirect = location.origin + location.pathname + '#media-tab';
                if (location.href == redirect) {
                    location.reload();
                    return;
                }
                location.href = redirect;
            })
            .catch(({ responseJSON, status }) => {
                if (status == 422 && responseJSON) {
                    if (responseJSON.file) {
                        $('.success[for="image_file"]').hide();
                        $('.error[for="image_file"]').show()
                            .find('span').text(responseJSON.file[0]);
                        delete responseJSON.file;
                    }
                    displayFormErrors($form, responseJSON);
                    return true;
                }
                alert('Error! Please contact support or try again later.');
            });
        //       <tr class="media_row" id="media_row_{{ $file->id }}">
        //            <td>{{ $file->media_name }} </td>
        //            <td> {{ $categories[$file->category] }} </td>
        //            <td> {{ $location_types[$file->location_type] }} </td>
        //            <td> {{ $status_types[$file->status] }} </td>
        //            <td> {{ $file->created_at }} </td>
        //            <td> <a href="#" class="tr-preview" data-toggle="popover" data-html="true" data-placement="left" data-trigger="hover" title="" data-content="<img src='{{ $file->file_location }}'>" id="view_media_{{ $file->id }}"><i class="fa fa-camera-retro" aria-hidden="true"></a></i> </td>
        //      </tr>
    });

    $('input#image_file').change(({ currentTarget }) => {
        let $currentTarget = $(currentTarget),
            $success = $currentTarget.parent().find('label.success').first().hide(),
            $error = $currentTarget.parent().find('label.error').first().hide(),
            { files } = currentTarget,
            file = null;
        if (files && files.length) {
            file = files[0];
            if (!file) {
                resetButton();
                $error
                    .show()
                    .find('span').text('File must be an image');
                return false;
            }
            if (file.size > Config.maxFileSizeBytes) {
                resetButton();
                $error
                    .show()
                    .find('span').text('Max file size is 300kb');
                return false;
            }
            $success
                .show()
                .find('span').first()
                .text(file.name);
            let src = imageBlob(file);
            if (src) {
                $success.find('div img').first()
                    .attr({ src });
            }
            $button
                .addClass('btn-outline')
                .find('span').first().text('Change');
            return true;
        }
        resetButton();
    });
});