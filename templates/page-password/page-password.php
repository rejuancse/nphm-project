<?php
    add_filter( 'the_password_form', 'nphm_password_form' );
    function nphm_password_form() {
        global $post;
        $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
        $error_message = '';

        if (isset($_GET['password_error'])) {
            if ($_GET['password_error'] == '1') {
                $error_message = 'Incorrect password. Please try again.';
            } elseif ($_GET['password_error'] == 'empty') {
                $error_message = 'Please enter a password.';
            }
        }

        $value = '<h1>This page is Password protected.</h1><p>Use password to view this page.</p>';
        $value .= '<form id="protected-post-form" class="protected-post-form" action="' . get_option('siteurl') . '/wp-login.php?action=postpass" method="post">
                <input id="post_password" name="post_password" type="password" size="20" placeholder="Password"/>
                <div id="error-message" style="color: red; margin-top: 10px;">' . esc_html($error_message) . '</div>
                <br>
                <div class="wp-block-button is-style-outline">
                <input type="submit" name="Submit" class="wp-block-button__link has-orange-color has-text-color has-link-color has-text-align-right wp-element-button" value="' . esc_attr__( "Submit" ) . '" />
                </div>
            </form>';

        $value .= '<p style="margin-top: 30px; margin-bottom: 36px !important;">If you have no password, Please contact with NPHM author. Please click in <button id="form-protected" class="wp-block-button__link has-orange-color has-text-color has-link-color has-text-align-right wp-element-button">Here</button></p>';

        return $value;
    }

    // Hook into the password form to handle incorrect password attempts
    add_action('template_redirect', 'nphm_handle_incorrect_password');
    function nphm_handle_incorrect_password() {
        if (is_singular() && post_password_required()) {
            if (isset($_POST['post_password'])) {
                wp_redirect(add_query_arg('password_error', '0', wp_get_referer()));
                exit;
            } elseif (isset($_GET['password_error'])) {
                // Show the error message on reload
                add_filter('the_password_form', 'nphm_password_form');
            }
        }
    }

    $page_protected_password_form = get_field('page_protected_password_form', 'options');
    if( !empty( $page_protected_password_form ) ) {
        echo '<div class="nphm-form-value" style="display: none"><div class="overlay"></div>';
            echo '<div class="popup">';
                echo do_shortcode( $page_protected_password_form );

                echo '<button id="close-popup"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                <path d="M1 21.1716L20.3484 1" stroke="black" stroke-width="2"></path>
                <path d="M20.3945 21.1716L1.04615 1" stroke="black" stroke-width="2"></path>
            </svg></button>';
            echo '</div>';
        echo '</div>';
    }
?>

<script>
	// Get elements
	document.addEventListener("DOMContentLoaded", function() {
		const formProtected = document.getElementById('form-protected');
		const nphmFormValue = document.querySelector(".nphm-form-value");
		const overlay = document.querySelector('.overlay');
		const closeBtn = document.getElementById('close-popup');

		formProtected.addEventListener("click", function(event) {
			event.preventDefault();
			nphmFormValue.style.display = "block";
		});

		// Function to close popup
		function closePopup() {
			nphmFormValue.style.display = 'none';
		}

		// Event listeners
		closeBtn.addEventListener('click', closePopup);
		overlay.addEventListener('click', function(event) {
			event.preventDefault();
			closePopup();
		});
	});

	document.getElementById("protected-post-form").addEventListener("submit", function(event) {
		var passwordField = document.getElementById("post_password");
		var errorMessage = document.getElementById("error-message");
		if (passwordField.value.trim() === "") {
			event.preventDefault(); // Prevent form submission
			errorMessage.textContent = "Please enter a password.";
			errorMessage.style.display = "block"; // Show error message
		}
	});
</script>
