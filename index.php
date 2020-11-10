<?php
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['cep']) && isset($_POST['logradouro']) && isset($_POST['complemento']) && isset($_POST['bairro']) && isset($_POST['localidade']) && isset($_POST['uf']) && isset($_POST['ibge']) && isset($_POST['gia']) && isset($_POST['ddd']) && isset($_POST['siafi'])){
	
	echo "Dados Recebidos E Guardados!";

}else if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['cep'])){
	$cep = $_POST['cep'];
	$url = "http://viacep.com.br/ws/{$cep}/json/";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, $url);
	$result = curl_exec($ch);
	curl_close($ch);
	echo $result;
	exit();
}else if($_SERVER['REQUEST_METHOD'] == "POST"){
	echo "Requisição Invalida, Acesso Negado!";
	http_response_code(500);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Form</title>
</head>
<body>
	<form action="./" method="POST">
		CEP: <input type="text" name="cep" id="cep"><br>
		logradouro: <input type="text" name="logradouro" id="logradouro"><br>
		complemento: <input type="text" name="complemento" id="complemento"><br>
		bairro: <input type="text" name="bairro" id="bairro"><br>
		localidade: <input type="text" name="localidade" id="localidade"><br>
		uf: <input type="text" name="uf" id="uf"><br>
		ibge: <input type="text" name="ibge" id="ibge"><br>
		gia: <input type="text" name="gia" id="gia"><br>
		ddd: <input type="text" name="ddd" id="ddd"><br>
		siafi: <input type="text" name="siafi" id="siafi"><br>
		<input type="submit" value="Enviar">
	</form>

	<script>
		let getCEP = (url, cep) => new Promise((resolve, reject) => {
			const formData = "cep="+cep;
			let xmlhttp;
			if (window.XMLHttpRequest) {
				xmlhttp = new XMLHttpRequest();
			} else {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function () {
				if (this.readyState == 4 && this.status == 200) {
					resolve(this.responseText);
				} else if (this.readyState == 4 && this.status !== 200 && this.status !== 0) {
					console.log("Error: Verifique a permissão de acesso!");
					reject("error: " + this.status);
				} else if (this.readyState == 4 && this.status == 0) {
					console.log("Error: desconhecido, Resposta do servidor: " + url + ", não recebida.");
					reject("Error: desconhecido, Resposta do servidor não recebida.");
				}
			}
			xmlhttp.open("POST", url, true);
			xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xmlhttp.send(formData);
		});

		document.querySelector("#cep").addEventListener("focusout", evt => {
			getCEP("./", document.querySelector("#cep").value).then(data =>{
				let logradouro = document.querySelector("#logradouro");
				let complemento = document.querySelector("#complemento");
				let bairro = document.querySelector("#bairro");
				let localidade = document.querySelector("#localidade");
				let uf = document.querySelector("#uf");
				let ibge = document.querySelector("#ibge");
				let gia = document.querySelector("#gia");
				let ddd = document.querySelector("#ddd");
				let siafi = document.querySelector("#siafi");
				logradouro.value = JSON.parse(data).logradouro;
				complemento.value = JSON.parse(data).complemento;
				bairro.value = JSON.parse(data).bairro;
				localidade.value = JSON.parse(data).localidade;
				uf.value = JSON.parse(data).uf;
				ibge.value = JSON.parse(data).ibge;
				gia.value = JSON.parse(data).gia;
				ddd.value = JSON.parse(data).ddd;
				siafi.value = JSON.parse(data).siafi;
			});
		})
	</script>
</body>
</html>