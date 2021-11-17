$(document).ready(function () {
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: "/api/transactions",
        success: function (response) {
            let template = "";
            for (let i = 0; i < response.data.length; i++) {
                console.log(response.data[i]);
                template += `
            <tr>
            <td>
                ${response.data[i].amount}
            </td>
            <td>
                ${response.data[i].origin_account}
            </td>
            <td>
                ${response.data[i].destination_account}
            </td>
            <td>
                 ${response.data[i].created_at}
            </td>
            <td>
                ${response.data[i].state?"Entrada":"Salida"}
             </td>

        </tr>
            
            `;
            }
            $("#tablita").html(template);
        },
    });
});

window.addEventListener("load", function () {
    let restart1 = document.getElementById("transactions");
    restart1.style.transform = "translateY(0px)";
    restart1.style.visibility = "visible";
    restart1.style.opacity = "1";
});
