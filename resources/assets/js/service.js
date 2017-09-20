/*globals tr_handle*/
let div = document.getElementById('tr_' + tr_handle),
    iframe = document.createElement('iframe'),
    clean = input => {
        return input.replace(/\W/g, ' ').replace(/[ ]{2,}/g, ' ').trim();
    },
    meta = name => {
        var tag = document.querySelector("meta[name='" + name + "']");
        return (tag !== null) ? tag.getAttribute('content') : '';
    },
    keywords = () => {
        return encodeURIComponent(
            clean(
                meta('keywords') + ' ' + meta('description') + ' ' + document.title
            )
        ).substring(0, 400);
    };

iframe.setAttribute('src', `http://service.trafficroots.com/service/${tr_handle}/${keywords()}`);
iframe.setAttribute('allowtransparency', 'true');
iframe.setAttribute('scrolling', 'no');
iframe.setAttribute('frameborder', '0');
iframe.setAttribute('marginheight', '0');
iframe.setAttribute('marginwidth', '0');
iframe.setAttribute('width', div.dataset.width);
iframe.setAttribute('height', div.dataset.height);
if (div !== null) {
    div.appendChild(iframe);
} else {
    document.write(iframe.outerHTML);
}