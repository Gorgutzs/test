async function Löschen_Event(button)
{
    if (!confirm("Möchtest du diese Veranstaltung wirklich löschen?")) {
        return;

    }

    try
    {
        const id = button.dataset.id;
  

        const csrfToken = await getCsrfToken();


  const response = await fetch("/ProjektVeranstaltungen/events/delete", 
            {
                method:"POST",
                headers:{"Content-Type": "application/json",
                "X-CSRF-Token": csrfToken
                },
                body: JSON.stringify({
                id: id
                
            })
            });

        const data = await response.json();
        alert(data.message);



        const zeile = button.closest("tr");
        zeile.remove();
    } catch (error)
    {
        console.error("Fehler:",error);
    }


}   




async function Löschen_Source(button)
{
    if (!confirm("Möchtest du diese Quelle wirklich löschen?")) {
        return;

    }
 


    try
    {
        const id = button.dataset.id;
        const token = await getCsrfToken();

  const response = await fetch("/ProjektVeranstaltungen/sources/delete", 
            {
                method:"POST",
                headers:{"Content-Type": "application/json", "X-CSRF-Token": token},
                body: JSON.stringify({
                id: id
                
            })
            });
        const data = await response.json();
        alert(data.message);



        const zeile = button.closest("tr");
        zeile.remove();
    } catch (error)
    {
        console.error("Fehler:",error);
    }





}    






async function Source_aktivieren_deaktivieren(button)
{


    try
    {
        const id = button.dataset.id;
        const token = await getCsrfToken();

  const response = await fetch("/ProjektVeranstaltungen/sources/aktivieren_deaktivieren", 
            {
                method:"POST",
                headers:{"Content-Type": "application/json","X-CSRF-Token": token },
                body: JSON.stringify({
                id: id
            })
            });
        const data = await response.json();
        alert(data.message);
    

        const zeile = button.closest("tr");
        const span = zeile.querySelector("span");

        if (button.textContent == "Aktivieren")
        {
        button.textContent = "Deaktivieren";
        span.classList.replace("bg-danger", "bg-success");
        } 
        else 
        {
        button.textContent = "Aktivieren";
        span.classList.replace("bg-success", "bg-danger");
        }

  
    } catch (error)
    {
        console.error("Fehler:",error);
    }

}    




 function  ÖffneModal(modalElement)
{

    const modal = new bootstrap.Modal(modalElement);

    modal.show();
}


document.getElementById("Qulle_Hinzufügen")
    .addEventListener("click", () => {
        ÖffneModal(document.getElementById("QuelleHinzufügenModal"));
    });






    async function getCsrfToken()
{
    const response = await fetch("/ProjektVeranstaltungen/auth/csrf");
    const data = await response.json();

    return data.csrf_token;
}