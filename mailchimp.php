

function rudr_mailchimp_subscriber_status( $email, $status, $list_id, $api_key, $merge_fields = array('FNAME' => '','LNAME' => '') )
{
    $data = array(
        'apikey'        => $api_key,
        'email_address' => $email,
        'status'        => $status,
        'merge_fields'  => $merge_fields
    );
    $mch_api = curl_init(); // initialize cURL connection
    curl_setopt($mch_api, CURLOPT_URL, 'https://' . substr($api_key,strpos($api_key,'-')+1) . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members/' . md5(strtolower($data['email_address'])));
    curl_setopt($mch_api, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic '.base64_encode( 'user:'.$api_key )));
    curl_setopt($mch_api, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    curl_setopt($mch_api, CURLOPT_RETURNTRANSFER, true); // return the API response
    curl_setopt($mch_api, CURLOPT_CUSTOMREQUEST, 'PUT'); // method PUT
    curl_setopt($mch_api, CURLOPT_TIMEOUT, 10);
    curl_setopt($mch_api, CURLOPT_POST, true);
    curl_setopt($mch_api, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($mch_api, CURLOPT_POSTFIELDS, json_encode($data) ); // send data in json
    $result = curl_exec($mch_api);
    return $result;
}
// Put this wherever you want to add a user to MailChimp
// IE. in the "success" part of your form.

// Your MailChimp API key
$api_key = 'YOUR_API_KEY';

// Your mailing list ID.
$list_id = 'YOUR_LIST_ID';

// Can be "subscribed", "unsubscribed", "cleaned", or "pending"
$status = 'subscribed';

// The email address being added.
$email = $_POST['email-address'];

// Add additional fields to the mailing list.
$merge_fields = array(
    'FNAME' => $_POST['first-name'],
    'LNAME' => $_POST['last-name']
);

// Run the function.
rudr_mailchimp_subscriber_status($email, $status, $list_id, $api_key, $merge_fields );
