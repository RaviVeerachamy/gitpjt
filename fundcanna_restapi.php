<?php
if(isset($_POST['email'])) {
	


 //sixteenDigitKey: sixteenDigitKey,zipCode:zipCode,firstName:firstName,lastName:lastName,email:email,phone:phone


//session_start();
	$token_url ="https://test.salesforce.com/services/oauth2/token";
	$params =
	"grant_type=password"
	. "&client_id=3MVG9ooRt4uZ_3Tl.3FxFTs6B0nXx5gBBPtuSsLjPA1vNMCy4f5yjjnZXN298W804gPLyfU_GCesR7FsQN6zw"
	. "&client_secret=10B76BCE7C1CE67509303F741B7552981177FBB4F764F288E36FA6AC48312E9D"
	. "&username=ravi@trumatics.com.trumatics"
	. "&password=Qwerty@123PjMFjs2wEdtVCzfNSt31uQpDe";
    $curl = curl_init($token_url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
	$json_response = curl_exec($curl);
	$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		if ( $status != 200 )
			{
				die("Error: call to token URL $token_url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
			}
	curl_close($curl);
	$response = json_decode($json_response, true);
	$access_token = $response['access_token'];
	echo $access_token;
	echo "<br>";
	$instance_url= $response['instance_url'];
	echo $instance_url;
	$_SESSION['access_token'] = $access_token;
	$_SESSION['instance_url'] = $instance_url;
	
//	session_start();
		$access_token = $_SESSION['access_token'];
		$instance_url = $_SESSION['instance_url'];
		
		
		function create_account($instance_url, $access_token)
{
	$url = $instance_url."/services/apexrest/leadrecords/";
//String activationCode, String postalCode, String firstName, String lastName, String phone, String email,
                                 String company
	$content = json_encode(array("activationCode"=>$_POST['sixteenDigitKey'],"postalCode"=>$_POST['zipCode'],"firstName"=>$_POST['firstName'],"lastName"=>$_POST['lastName'],"phone"=>$_POST['phone'],
	"email"=>$_POST['email'],"Company"=>"Trumatics 125666"));
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER,array("Authorization: Bearer $access_token","Content-type: application/json"));
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
	$json_response = curl_exec($curl);
	$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		if ( $status != 201 )
		{
			die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
		}
		echo "succesfully creating account<br/><br/>";
		curl_close($curl);
	$response = json_decode($json_response, true);
	$id = $response["id"];
	//echo "New record id $id,$phone<br/><br/>";
	return $response;

}
create_account( $instance_url, $access_token);

}


//Select email,Lastname,Activation_Code__c,Phone,PostalCode From Lead 
?>

