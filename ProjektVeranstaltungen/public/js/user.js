//If Search in the URL has Search and Search has a value display the clearblock
function disableSearch(elementId) {

    const element = document.getElementById(elementId);

    const params = new URLSearchParams(window.location.search);
    const search = params.get("Search");

    if (search) {
        element.style.display = "block";
    } else {
        element.style.display = "none";
    }

    
}

//clearbutton get teh function disableSearch
window.onload = function () {
    disableSearch("clearbutton");
};

//Open and close teh Alertmodal
document.getElementById("Fehlermelden").addEventListener("click",  function () {

    const modalElement = document.getElementById("fehlerModal");

    const modal = new bootstrap.Modal(modalElement);

    modal.show();

});

//Fetch the Error magssege send by User
document.getElementById("fehlerForm").addEventListener("submit", async function (event) {

    event.preventDefault();


    const fehlerText = document.getElementById("fehlerText").value;
    
   const response = await fetch("/ProjektVeranstaltungen/error", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            fehler: fehlerText
        })
    });

const data = await response.json();

console.log(data);


     document.getElementById("fehlerText").value ="";

    bootstrap.Modal.getInstance(
        document.getElementById("fehlerModal")
    ).hide();


});


