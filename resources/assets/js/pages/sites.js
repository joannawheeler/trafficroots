/*globals $*/
let showSiteZones = (site_id) => {
    $('.zones').addClass('hide');
    $('#zones' + site_id).removeClass('hide');
    $('#zones' + site_id).goTo();
};
$(document).ready(() => {
    $('.footable').footable();
    $('.alert').delay(3000).fadeOut();
    $('form').submit(event => {
        event.preventDefault();
        var $form = $(event.currentTarget);
        $.post($form.prop('action'), $form.serialize(), 'json')
            .done((response) => {
                location.reload();
            })
            .error((response) => {
                var errors = response.responseJSON;
                $.each(errors, (name, message) => {
                    $form.find('input[name="' + name + '"] + .error')
                        .removeClass('hide')
                        .text(message);
                });
            });
    });
    $('.site-zones, .site-edit, .zone-edit, .site-pixel').click(e => {
        e.preventDefault();
    });
    $('.site-zones').click(e => {
        var site_id = $(e.currentTarget).parents('td').first().data('site_id');
        showSiteZones(site_id);
    });
});