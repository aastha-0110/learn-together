
 
$(document).ready(function() {
    // Initially hide the registration form
    $('.register-form').hide();

    // Click event for links in the message
    $('.message a').click(function(event) {
        event.preventDefault(); // Prevent the default action of the link
        $('form').animate({ height: "toggle", opacity: "toggle" }, "slow");
    });
});

