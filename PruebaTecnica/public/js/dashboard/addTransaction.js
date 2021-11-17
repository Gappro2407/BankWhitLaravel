let accountsData = "";
(function () {
    var URL = location.protocol + "//" + location.host + "/api/accounts";
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        method: "GET",
        url: URL
    })
        .done(function (data) {
            let template = "";
            data = data.data;
            accountsData = data;

            for (let i = 0; i < data.length; i++) {

                template += `
                <option value="${data[i].account_number}">${data[i].account_number}</option>
            
            `;
            }
            $("#accounts").html(template);
        })
        .fail(function (xhr, textStatus, error) {
            alert("A error has ocurred");
            console.log(xhr.statusText);
            console.log(textStatus);
            console.log(error);
        });

})();

let destination = document.getElementById("destination");
let account = document.getElementById("accounts");
let amount = document.getElementById("amount");
let message = '';
function validateForm() {
    let expresion = /^[0-9]*$/;
    if (destination.value == account.value) {
        message = 'You cannot send it to this same account';
        return false;
    }
    if (destination.value == "") {
        message = 'Please enter a destination account';
        return false;
    }
    if (amount.value == "" || amount.value < 1000 || !expresion.test(amount.value)) {
        message = 'The amount field must be a numeric value and greater than 1000';
        return false;
    }
    let faccount = accountsData.filter(function (acc) {
        return acc["account_number"] == account.value;
    });
    console.log(accountsData)
    if (amount.value > faccount[0].amount) {
        message = 'Insufficient funds';
        return false;
    }

    return true

}


function addTransaction() {
    let request = {
        origin_account: account.value,
        destination_account: destination.value,
        amount: amount.value
    };
    var URL = location.protocol + "//" + location.host + "/api/transactions";
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        method: "POST",
        url: URL,
        data: request
    })
        .done(function (data) {
            Swal.fire({
                icon: 'success',
                title: 'Transaction carried out successfully',
                showConfirmButton: false,
                timer: 1500
            })
            console.log("ADD", data);
        })
        .fail(function (xhr, textStatus, error) {
            alert("A error has ocurred");
            console.log(xhr.statusText);
            console.log(textStatus);
            console.log(error);
        });

}

$("#generateTransaction").on("submit", function (e) {
    e.preventDefault();
    if (validateForm()) {
        addTransaction()
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: message,
        })
    }
});

// $("#generateTransaction").on("load", function (e) {
//     e.preventDefault();
//     texto.style.transition = "2s";
//     let restart1 = document.getElementById("generateTransaction");
//     restart1.style.transform = "translateX(0px)";
//     restart1.style.visibility = "visible";
//     restart1.style.opacity = "1";
//   });   


window.addEventListener("load", function () {
    let restart1 = document.getElementById("generateTransaction");
    restart1.style.transform = "translateX(0px)";
    restart1.style.visibility = "visible";
    restart1.style.opacity = "1";
});


