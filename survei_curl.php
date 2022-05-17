<?php
class ServiceCurl {
    function service_curl_api ($key){
        $curl = curl_init();
	    curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://dashboard.kuduskab.go.id/e_skm/wp_plugin',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => array('from_url' => $key),
		CURLOPT_HTTPHEADER => array(
			'Cookie: ci_session=bb5l04mn8iq05kfc0vtb8ku1sl501hbq'
		),
	));

	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
    }
    function service_view_curl ($key){
        $curl = curl_init();
	    curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://dashboard.kuduskab.go.id/e_skm/view_hasil_skm',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => array('from_url' => $key),
// 		CURLOPT_HTTPHEADER => array(
// 			'Cookie: ci_session=bb5l04mn8iq05kfc0vtb8ku1sl501hbq'
// 		),
	));

	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
    }
}