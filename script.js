window.onload = () => {
    const processorForm = document.getElementById("client");

    processorForm.addEventListener("submit", function (event) {
        event.preventDefault();

        const formDataProcessor = new FormData(this);

        fetch("migrations.php", {
            method: "post",
            body: formDataProcessor
        }).then(function (response){
            return response.text();
        }).then(function (text) {
            document.getElementById("toLoad").innerHTML = text;
        }).catch(function (error) {
            console.error(error);
        });
    })

    const guaranteeForm = document.getElementById("statistic");

    guaranteeForm.addEventListener("submit", function (event) {
        event.preventDefault();

        const formDataGuarantee = new FormData(this);
        fetch("migrations.php", {
            method: "post",
            body: formDataGuarantee
        }).then(function (response){
            return response.json();
        }).then(function (json) {
            document.getElementById("toLoad").innerHTML = json;
        }).catch(function (error) {
            console.error(error);
        });
    })

    const softwareForm = document.getElementById("balance");

    softwareForm.addEventListener("submit", function (event) {
        event.preventDefault();

        const formDataSoftware = new FormData(this);
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "migrations.php");
        xhr.responseType = 'document';
        xhr.send(formDataSoftware);

        xhr.onload = () => {
            document.getElementById("toLoad").innerHTML = xhr.responseXML.body.innerHTML;
        }
    })
}


