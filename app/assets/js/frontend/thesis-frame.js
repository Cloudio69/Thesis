

const generaFrontespizio = () => {
    jQuery.ajax({
        dataType: "json",
        method: "POST",
        cache: false,
        url: ajaxurl,
        data: {
            action: "genera_frontespizio",
            data: {
                uuid: getCookie("thesis_session"),
                rgb: [192, 192, 192],
            },
        },
        success: (response) => {
            return response;
        },
    });
};

generaFrontespizio();