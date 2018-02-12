$(($) => {
    $(document).on('submit', 'form.ajax-form', function (e) {
        const $form = $(this);
        const data = $form.data();
        $.post(data.actionUrl, $form.serialize())
            .done(() => {
                if (data.refresh) {
                    ajaxRefresh(data.refresh);
                } else {
                    alert("Done but nothing to refresh");
                }
            })
            .fail((xhr) => {
                switch (xhr.status) {
                    case 400:
                        $form.replaceWith(xhr.responseText);
                        break;
                    default:
                        alert("Sorry, the request broke");
                }
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

        $.post(data.actionUrl)
            .done((response) => {
                if ('' === response) {
                    if (data.refresh) {
                        ajaxRefresh(data.refresh);
                    } else {
                        alert("Done but nothing to refresh");
                    }
                } else {
                    $button.replaceWith(xhr.responseText);
                }
            })
            .fail(() => {
                alert("Sorry, the request broke");
            });
    });

    function ajaxRefresh(selector) {
        const $elements = $(selector);
        $elements.each(function () {
            // Note selector has to work in this context too
            $(this).load(
                $(this).data('refresh-url') + ' ' + selector + ' > *',
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
