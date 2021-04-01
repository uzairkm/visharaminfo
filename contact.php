<?php

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["name"]));
		$name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $mobile = trim($_POST["mobile"]);
        $message = trim($_POST["message"]);

        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($mobile) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Oops! There was a problem with your submission. Please complete the form and try again.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "support@visharaminfo.in";
        

        // Set the email subject.
        $subject = "Visharam InfoTech- Got a mail from $name";

        // Build the email content.
        // $email_content = "Name: $name\n";
        // $email_content .= "Email: $email\n";
        // $email_content .= "Mobile:$mobile\n\n";
        $email_content .= "Message:\n$message\n";
        
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        
        
        // Create email headers
$headers .= 'From: '.$email."\r\n".
    'Reply-To: '.$email."\r\n" .
    'X-Mailer: PHP/' . phpversion();
        
$message = '<html><body>';
$message .= '<img src="http://visharaminfo.in/images/logo-reg.png" alt="Visharam InfoTech Logo" />';
$message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
$message .= "<tr style='background: #eee;'><td><strong>Name:</strong> </td><td>" . strip_tags($_POST['name']) . "</td></tr>";
$message .= "<tr><td><strong>Email:</strong> </td><td>" . strip_tags($_POST['email']) . "</td></tr>";
$message .= "<tr><td><strong>Mobile:</strong> </td><td>" . strip_tags($_POST['mobile']) . "</td></tr>";
$message .= "<tr><td><strong>Message:</strong> </td><td>" . strip_tags($_POST['message']) . "</td></tr>";
$message .= "</table>";
$message .= "</body></html>";
        // $email_headers = "From: " .$_POST['name'];
        // $email_headers .= "CC: support@visharaminfo.in";
        // $email_headers .= "MIME-Version: 1.0";
        $email_headers = "Content-Type: text/html";

        // Send the email.
        if (mail($recipient, $subject, $message,$email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Dear $name , thanks for reaching out!We’re thrilled to hear from you. Our inbox can’t wait to get your messages, so talk to us any time you like.Cheers!";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            
            echo "Oops! Something went wrong and we couldn't send your message.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }
    
?>
