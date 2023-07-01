<script src="http://localhost:8080/auth/js/keycloak.js"></script>
<script src="https://cdn.jsdelivr.net/npm/js-cookie@beta/dist/js.cookie.min.js"></script>
<script type="text/javascript">
    const keycloak = Keycloak('http://localhost:8012/keycloak.json')
    const initOptions = {
        responseMode: 'fragment',
        flow: 'standard',
        onLoad: 'login-required'
    };
    function logout(){
        Cookies.remove('token');
        Cookies.remove('callback');
        keycloak.logout();
    }
    keycloak.init(initOptions).success(function(authenticated) {
        Cookies.set('token', keycloak.token);
        Cookies.set('callback',JSON.stringify(keycloak.tokenParsed.resource_access.php_service.permission));
        var arr = JSON.parse(Cookies.get('callback'));
        arr = arr.reduce((index,value) => (index[value] = true, index), {});
        (arr.access_create === true ? document.getElementById("create").disabled = false : document.getElementById("create").disabled = true);
        (arr.access_edit === true ? document.getElementById("edit").disabled = false : document.getElementById("edit").disabled = true);
        (arr.access_delete === true ? document.getElementById("delete").disabled = false : document.getElementById("delete").disabled = true);
        (arr.access_view === true ? document.getElementById("read").disabled = false : document.getElementById("read").disabled = true);
        document.getElementById("test").innerHTML = Cookies.get('token');
        // console.log('Init Success (' + (authenticated ? 'Authenticated token : '+JSON.stringify(keycloak) : 'Not Authenticated') + ')');
    }).error(function() {
        console.log('Init Error');
    });
</script>

<?php

echo 'Hi';
exit;
	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = 'https://';
	} else {
		$uri = 'http://';
	}
	$uri .= $_SERVER['HTTP_HOST'];
	header('Location: '.$uri.'/dashboard/');
	exit;
?>
Something is wrong with the XAMPP installation :-(
