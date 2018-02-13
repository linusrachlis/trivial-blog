$(($) => {
    $(document).on('submit', 'form.ajax-form', function (e) {
        const $form = $(this);
        const data = $form.data();

        ajaxPost(data.action, $form.serialize(), data.refresh, responseText => {
            console.log('responsetext', responseText);
            $form.replaceWith(responseText);
        });

        // Prevent regular form submission
        e.preventDefault();
        return false;
    });

    $(document).on('click', 'button.ajax-button', function (e) {
        const $button = $(this);
        const data = $button.data();
        const confirmed = data.confirm ? window.confirm(data.confirm) : true;

        if (!confirmed) {
            return;
        }

        ajaxPost(data.action, data.actionParams, data.refresh, responseText => {
            $button.replaceWith(responseText);
        });
    });

    function ajaxPost(action, data, refreshSelector, responseTextCallback) {
        $.post('/index.php?action=' + encodeURIComponent(action), data)
            .done((responseText) => {
                if ('' === responseText) {
                    if (refreshSelector) {
                        ajaxRefresh(refreshSelector);
                    } else {
                        alert("Done but nothing to refresh");
                    }
                } else {
                    responseTextCallback(responseText);
                }
            })
            .fail(() => {
                // Have failure callback?
                alert("Sorry, the request broke");
            });
    }

    function ajaxRefresh(selector) {

        // Change technique, use regular ajax + replaceWith rather than 'load'?

        const $elements = $(selector);
        $elements.each(function () {
            // Note selector has to work in this context too
            const elementAction = $(this).data('action');
            if (!elementAction) {
                console.error("No refresh URL", this);
                return;
            }
            $(this).load(
                '/index.php?action=' + encodeURIComponent(elementAction) + ' ' + selector + ' > *',
                function (response, status, xhr) {
                    if ('error' === status) {
                        switch (xhr.status) {
                            case 400:
                                // Or just alert response text?
                                $button.replaceWith(xhr.responseText);
                                break;
                            default:
                                alert("Sorry, the request broke");
                        }
                    }
                });
        });
    }
});
